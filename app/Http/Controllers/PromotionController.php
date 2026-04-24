<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Promotion;
use App\Utils\PromotionUtil;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PromotionController extends Controller
{
    /**
     * Display a listing.
     */
    public function index(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $promotions = Promotion::where('business_id', $business_id)
            ->orderBy('priority')
            ->orderByDesc('id')
            ->paginate(25);
        $products = Product::where('business_id', $business_id)
            ->orderBy('name')
            ->pluck('name', 'id');
        $categories = Category::where('business_id', $business_id)
            ->where('category_type', 'product')
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('promotion.index', compact('promotions', 'products', 'categories'));
    }

    /**
     * Store a promotion.
     */
    public function store(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $data = $this->validatedData($request);
        $data['target_id'] = $this->resolveTargetIdFromScope($data, $request);
        $data['business_id'] = $business_id;
        $data['created_by'] = auth()->id();
        $data['coupon_code'] = ! empty($data['coupon_code']) ? strtoupper(trim($data['coupon_code'])) : null;

        Promotion::create($data);

        return redirect()->back()->with('status', ['success' => 1, 'msg' => __('messages.success')]);
    }

    /**
     * Update promotion.
     */
    public function update(Request $request, $id)
    {
        $business_id = $request->session()->get('user.business_id');
        $promotion = Promotion::where('business_id', $business_id)->findOrFail($id);
        $data = $this->validatedData($request);
        $data['target_id'] = $this->resolveTargetIdFromScope($data, $request);
        $data['coupon_code'] = ! empty($data['coupon_code']) ? strtoupper(trim($data['coupon_code'])) : null;

        $promotion->update($data);

        return redirect()->back()->with('status', ['success' => 1, 'msg' => __('lang_v1.updated_succesfully')]);
    }

    /**
     * Toggle status.
     */
    public function toggleStatus($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $promotion = Promotion::where('business_id', $business_id)->findOrFail($id);
        $promotion->is_active = $promotion->is_active ? 0 : 1;
        $promotion->save();

        return redirect()->back()->with('status', ['success' => 1, 'msg' => __('lang_v1.updated_succesfully')]);
    }

    /**
     * Validate and preview promo result for cart.
     */
    public function validateCartPromotion(Request $request, PromotionUtil $promotionUtil)
    {
        $business_id = $request->session()->get('user.business_id');
        $products = $request->input('products', []);
        $contact_id = $request->input('contact_id');
        $code = $request->input('promotion_code');
        $summary = $promotionUtil->evaluatePromotions($business_id, $products, $contact_id, $code);

        return response()->json([
            'success' => true,
            'discount_amount' => $summary['discount_amount'],
            'promotion_code' => $summary['promotion_code'],
            'matched_promotions' => $summary['matched_promotions'],
        ]);
    }

    protected function validatedData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'rule_type' => 'required|string|max:50',
            'discount_type' => 'nullable|string|max:20',
            'discount_value' => 'nullable|numeric|min:0',
            'coupon_code' => 'nullable|string|max:80',
            'target_scope' => 'nullable|string|max:40',
            'target_id' => 'nullable|integer',
            'target_product_id' => 'nullable|integer',
            'target_category_id' => 'nullable|integer',
            'target_customer_group_id' => 'nullable|integer',
            'min_order_total' => 'nullable|numeric|min:0',
            'min_qty' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'buy_qty' => 'nullable|numeric|min:0',
            'get_qty' => 'nullable|numeric|min:0',
            'bundle_qty' => 'nullable|numeric|min:0',
            'bundle_price' => 'nullable|numeric|min:0',
            'tier_min_qty' => 'nullable|numeric|min:0',
            'usage_limit_per_coupon' => 'nullable|integer|min:0',
            'usage_limit_per_customer' => 'nullable|integer|min:0',
            'priority' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);
    }

    protected function resolveTargetIdFromScope(array $data, Request $request)
    {
        $scope = $data['target_scope'] ?? 'all_products';
        $target_id = $data['target_id'] ?? null;

        if ($scope === 'product') {
            $target_id = $target_id ?: $request->input('target_product_id');
        } elseif ($scope === 'category') {
            $target_id = $target_id ?: $request->input('target_category_id');
        } elseif ($scope === 'customer_group') {
            $target_id = $target_id ?: $request->input('target_customer_group_id');
        } else {
            $target_id = null;
        }

        if (in_array($scope, ['product', 'category', 'customer_group']) && empty($target_id)) {
            throw ValidationException::withMessages([
                'target_scope' => 'Target selection is required for the selected scope.',
            ]);
        }

        return $target_id;
    }
}
