<?php

namespace App\Utils;

use App\Contact;
use App\Business;
use App\Promotion;
use App\PromotionUsage;
use App\Transaction;

class PromotionUtil
{
    /**
     * Evaluate active promotions for a cart.
     */
    public function evaluatePromotions($business_id, $products, $contact_id = null, $coupon_code = null)
    {
        $summary = [
            'discount_amount' => 0,
            'matched_promotions' => [],
            'promotion_code' => null,
        ];

        $business = Business::find($business_id);
        $common_settings = ! empty($business->common_settings) ? $business->common_settings : [];
        if (array_key_exists('enable_promotion_engine', $common_settings) && empty($common_settings['enable_promotion_engine'])) {
            return $summary;
        }

        $coupon_code = ! empty($coupon_code) ? strtoupper(trim($coupon_code)) : null;
        $contact = ! empty($contact_id) ? Contact::find($contact_id) : null;
        $order_subtotal = $this->calculateOrderSubtotal($products);
        $now = now();

        $promotions = Promotion::where('business_id', $business_id)
            ->where('is_active', 1)
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->orderBy('priority', 'asc')
            ->get();

        foreach ($promotions as $promotion) {
            if (! empty($promotion->coupon_code)) {
                if (empty($coupon_code) || strtoupper($promotion->coupon_code) !== $coupon_code) {
                    continue;
                }
                if (! $this->passesCouponUsageLimits($promotion, $contact_id)) {
                    continue;
                }
            }

            if (! empty($promotion->min_order_total) && $order_subtotal < (float) $promotion->min_order_total) {
                continue;
            }

            $eligible = $this->eligibleLineStats($products, $promotion, $contact);
            if ($eligible['qty'] <= 0 || $eligible['subtotal'] <= 0) {
                continue;
            }

            $discount = $this->calculatePromotionDiscount($promotion, $eligible, $order_subtotal);
            if ($discount <= 0) {
                continue;
            }

            if (! empty($promotion->max_discount_amount) && $discount > (float) $promotion->max_discount_amount) {
                $discount = (float) $promotion->max_discount_amount;
            }

            $summary['discount_amount'] += $discount;
            $summary['matched_promotions'][] = [
                'promotion_id' => $promotion->id,
                'name' => $promotion->name,
                'rule_type' => $promotion->rule_type,
                'discount_amount' => round($discount, 4),
            ];
            if (! empty($promotion->coupon_code)) {
                $summary['promotion_code'] = $promotion->coupon_code;
            }
        }

        $summary['discount_amount'] = round($summary['discount_amount'], 4);

        return $summary;
    }

    /**
     * Record promotion usage for finalized transaction.
     */
    public function recordPromotionUsage(Transaction $transaction, array $promotion_summary, $contact_id = null, $created_by = null)
    {
        if (empty($promotion_summary['matched_promotions'])) {
            return;
        }

        $created_by = $created_by ?: auth()->id();

        PromotionUsage::where('transaction_id', $transaction->id)->delete();
        foreach ($promotion_summary['matched_promotions'] as $match) {
            PromotionUsage::create([
                'business_id' => $transaction->business_id,
                'promotion_id' => $match['promotion_id'],
                'transaction_id' => $transaction->id,
                'contact_id' => $contact_id,
                'coupon_code' => $promotion_summary['promotion_code'],
                'discount_amount' => $match['discount_amount'],
                'meta' => json_encode($match),
                'created_by' => $created_by,
            ]);
        }
    }

    protected function calculateOrderSubtotal($products)
    {
        $subtotal = 0;
        foreach ($products as $product) {
            $qty = ! empty($product['quantity']) ? (float) $product['quantity'] : 0;
            $price = ! empty($product['unit_price_inc_tax']) ? (float) $product['unit_price_inc_tax'] : 0;
            $subtotal += ($qty * $price);
        }

        return $subtotal;
    }

    protected function eligibleLineStats($products, Promotion $promotion, $contact = null)
    {
        $qty = 0;
        $subtotal = 0;

        if ($promotion->target_scope === 'customer_group' && ! empty($promotion->target_id)) {
            if (empty($contact) || (int) $contact->customer_group_id !== (int) $promotion->target_id) {
                return ['qty' => 0, 'subtotal' => 0, 'avg_price' => 0];
            }
            return ['qty' => $this->sumQty($products), 'subtotal' => $this->calculateOrderSubtotal($products), 'avg_price' => $this->avgPrice($products)];
        }

        foreach ($products as $product) {
            $line_qty = ! empty($product['quantity']) ? (float) $product['quantity'] : 0;
            $line_price = ! empty($product['unit_price_inc_tax']) ? (float) $product['unit_price_inc_tax'] : 0;

            if (! $this->lineMatchesTarget($product, $promotion)) {
                continue;
            }

            $qty += $line_qty;
            $subtotal += $line_qty * $line_price;
        }

        $avg = $qty > 0 ? ($subtotal / $qty) : 0;

        return ['qty' => $qty, 'subtotal' => $subtotal, 'avg_price' => $avg];
    }

    protected function lineMatchesTarget($product, Promotion $promotion)
    {
        if ($promotion->target_scope === 'all_products' || empty($promotion->target_scope)) {
            return true;
        }

        if ($promotion->target_scope === 'product' && ! empty($promotion->target_id)) {
            return ! empty($product['product_id']) && (int) $product['product_id'] === (int) $promotion->target_id;
        }

        if ($promotion->target_scope === 'category' && ! empty($promotion->target_id)) {
            return ! empty($product['category_id']) && (int) $product['category_id'] === (int) $promotion->target_id;
        }

        return false;
    }

    protected function calculatePromotionDiscount(Promotion $promotion, array $eligible, $order_subtotal)
    {
        $discount = 0;

        switch ($promotion->rule_type) {
            case 'coupon_fixed':
                $discount = (float) $promotion->discount_value;
                break;
            case 'coupon_percentage':
                $discount = ((float) $promotion->discount_value / 100) * $eligible['subtotal'];
                break;
            case 'bogo':
                $buy = (float) ($promotion->buy_qty ?: 1);
                $get = (float) ($promotion->get_qty ?: 1);
                $cycle = $buy + $get;
                if ($cycle > 0 && $eligible['qty'] >= $cycle) {
                    $eligible_sets = floor($eligible['qty'] / $cycle);
                    $free_units = $eligible_sets * $get;
                    $discount = $free_units * $eligible['avg_price'];
                }
                break;
            case 'bundle':
                $bundle_qty = (float) ($promotion->bundle_qty ?: 0);
                $bundle_price = (float) ($promotion->bundle_price ?: 0);
                if ($bundle_qty > 0 && $eligible['qty'] >= $bundle_qty) {
                    $bundle_sets = floor($eligible['qty'] / $bundle_qty);
                    $normal_bundle_price = $bundle_qty * $eligible['avg_price'];
                    $bundle_discount = max(0, $normal_bundle_price - $bundle_price);
                    $discount = $bundle_sets * $bundle_discount;
                }
                break;
            case 'tiered_volume':
                $tier_qty = (float) ($promotion->tier_min_qty ?: 0);
                if ($tier_qty > 0 && $eligible['qty'] >= $tier_qty) {
                    if ($promotion->discount_type === 'percentage') {
                        $discount = ((float) $promotion->discount_value / 100) * $eligible['subtotal'];
                    } else {
                        $discount = (float) $promotion->discount_value;
                    }
                }
                break;
            default:
                if ($promotion->discount_type === 'percentage') {
                    $discount = ((float) $promotion->discount_value / 100) * $order_subtotal;
                } else {
                    $discount = (float) $promotion->discount_value;
                }
                break;
        }

        return max(0, $discount);
    }

    protected function passesCouponUsageLimits(Promotion $promotion, $contact_id = null)
    {
        if (! empty($promotion->usage_limit_per_coupon)) {
            $total_usage = PromotionUsage::where('promotion_id', $promotion->id)->count();
            if ($total_usage >= (int) $promotion->usage_limit_per_coupon) {
                return false;
            }
        }

        if (! empty($promotion->usage_limit_per_customer) && ! empty($contact_id)) {
            $customer_usage = PromotionUsage::where('promotion_id', $promotion->id)
                ->where('contact_id', $contact_id)
                ->count();
            if ($customer_usage >= (int) $promotion->usage_limit_per_customer) {
                return false;
            }
        }

        return true;
    }

    protected function sumQty($products)
    {
        $qty = 0;
        foreach ($products as $product) {
            $qty += ! empty($product['quantity']) ? (float) $product['quantity'] : 0;
        }

        return $qty;
    }

    protected function avgPrice($products)
    {
        $qty = $this->sumQty($products);
        if ($qty <= 0) {
            return 0;
        }

        return $this->calculateOrderSubtotal($products) / $qty;
    }
}
