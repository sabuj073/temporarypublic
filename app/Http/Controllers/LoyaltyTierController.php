<?php

namespace App\Http\Controllers;

use App\LoyaltyTier;
use Illuminate\Http\Request;

class LoyaltyTierController extends Controller
{
    public function index(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $tiers = LoyaltyTier::where('business_id', $business_id)
            ->orderBy('level')
            ->get();

        return view('loyalty_tier.index', compact('tiers'));
    }

    public function store(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $data = $this->validatedData($request);
        $data['business_id'] = $business_id;
        $data['created_by'] = auth()->id();
        LoyaltyTier::create($data);

        return redirect()->back()->with('status', ['success' => 1, 'msg' => __('messages.success')]);
    }

    public function update(Request $request, $id)
    {
        $business_id = $request->session()->get('user.business_id');
        $tier = LoyaltyTier::where('business_id', $business_id)->findOrFail($id);
        $tier->update($this->validatedData($request));

        return redirect()->back()->with('status', ['success' => 1, 'msg' => __('lang_v1.updated_succesfully')]);
    }

    protected function validatedData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'level' => 'required|integer|min:1',
            'min_total_points' => 'nullable|numeric|min:0',
            'min_lifetime_sales' => 'nullable|numeric|min:0',
            'bonus_multiplier' => 'nullable|numeric|min:0',
            'extra_discount_percent' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'benefits' => 'nullable|string|max:1000',
        ]);
    }
}
