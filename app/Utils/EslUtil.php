<?php

namespace App\Utils;

use App\Business;
use App\EslDevice;
use App\EslSyncLog;
use App\Product;

class EslUtil extends Util
{
    public function isEnabled($business_id)
    {
        $business = Business::find($business_id);
        $settings = ! empty($business->common_settings) ? $business->common_settings : [];

        return ! empty($settings['enable_esl_integration']);
    }

    public function syncProductPrice($business_id, Product $product, $user_id = null)
    {
        $business = Business::find($business_id);
        $settings = ! empty($business->common_settings) ? $business->common_settings : [];
        $device = EslDevice::where('business_id', $business_id)->where('is_active', 1)->first();

        $payload = [
            'vendor' => $settings['esl_vendor'] ?? 'generic',
            'product_id' => $product->id,
            'sku' => $product->sku,
            'name' => $product->name,
            'selling_price' => (float) $this->extractSellingPrice($product),
            'currency' => $business->currency_id,
            'location' => $device->location_ref ?? null,
        ];

        $log = EslSyncLog::create([
            'business_id' => $business_id,
            'product_id' => $product->id,
            'esl_device_id' => ! empty($device) ? $device->id : null,
            'status' => 'pending',
            'payload' => json_encode($payload),
            'created_by' => $user_id ?: auth()->id(),
        ]);

        $endpoint = $settings['esl_api_url'] ?? null;
        $api_key = $settings['esl_api_key'] ?? null;
        if (empty($endpoint)) {
            $log->status = 'failed';
            $log->error_message = 'ESL endpoint is not configured.';
            $log->save();

            return ['success' => false, 'message' => 'ESL endpoint is not configured.'];
        }

        $response = $this->sendJsonRequest($endpoint, $payload, $api_key);
        $log->response_body = $response['body'] ?? null;
        if (! empty($response['success'])) {
            $log->status = 'success';
            $log->synced_at = now();
            $log->save();

            return ['success' => true, 'message' => 'Synced to ESL.'];
        }

        $log->status = 'failed';
        $log->error_message = $response['error'] ?? 'Unknown ESL sync error.';
        $log->save();

        return ['success' => false, 'message' => $log->error_message];
    }

    public function testConnection($business_id)
    {
        $business = Business::find($business_id);
        $settings = ! empty($business->common_settings) ? $business->common_settings : [];
        $endpoint = $settings['esl_api_url'] ?? null;
        $api_key = $settings['esl_api_key'] ?? null;

        if (empty($endpoint)) {
            return ['success' => false, 'message' => 'ESL API URL missing'];
        }

        return $this->sendJsonRequest($endpoint, ['health_check' => true], $api_key);
    }

    protected function sendJsonRequest($url, array $payload, $api_key = null)
    {
        $ch = curl_init($url);
        $headers = ['Content-Type: application/json'];
        if (! empty($api_key)) {
            $headers[] = 'Authorization: Bearer '.$api_key;
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (! empty($error)) {
            return ['success' => false, 'error' => $error, 'body' => $result];
        }

        if ($http >= 200 && $http < 300) {
            return ['success' => true, 'body' => $result];
        }

        return ['success' => false, 'error' => 'HTTP '.$http, 'body' => $result];
    }

    protected function extractSellingPrice(Product $product)
    {
        $price = 0;
        if ($product->relationLoaded('product_variations')) {
            foreach ($product->product_variations as $pv) {
                if ($pv->relationLoaded('variations')) {
                    foreach ($pv->variations as $variation) {
                        if (! is_null($variation->sell_price_inc_tax)) {
                            return $variation->sell_price_inc_tax;
                        }
                    }
                }
            }
        }

        return $price;
    }
}
