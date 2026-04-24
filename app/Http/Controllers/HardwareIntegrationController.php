<?php

namespace App\Http\Controllers;

use App\Product;
use App\Utils\EslUtil;
use App\Utils\ScaleUtil;
use Illuminate\Http\Request;

class HardwareIntegrationController extends Controller
{
    public function testEslConnection(Request $request, EslUtil $eslUtil)
    {
        $business_id = $request->session()->get('user.business_id');
        $response = $eslUtil->testConnection($business_id);

        return response()->json($response);
    }

    public function syncProductToEsl(Request $request, $product_id, EslUtil $eslUtil)
    {
        $business_id = $request->session()->get('user.business_id');
        $product = Product::where('business_id', $business_id)
            ->with(['product_variations.variations'])
            ->findOrFail($product_id);

        $response = $eslUtil->syncProductPrice($business_id, $product, $request->session()->get('user.id'));

        return response()->json($response);
    }

    public function readFromScale(Request $request, ScaleUtil $scaleUtil)
    {
        $business_id = $request->session()->get('user.business_id');
        $response = $scaleUtil->readWeight($business_id, $request->session()->get('user.id'));

        return response()->json($response);
    }
}
