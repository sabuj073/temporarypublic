<div class="row pos_form_totals">
    <div class="col-md-12">
        <div class="vp-pos-summary-wrap">
            <div class="vp-pos-summary-arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>

            <div class="vp-pos-summary-top">
                <div class="vp-pos-summary-cell">
                    <span class="vp-pos-summary-label">@lang('sale.item')</span>
                    <span class="total_quantity vp-pos-summary-value number">0</span>
                </div>
                <div class="vp-pos-summary-cell">
                    <span class="vp-pos-summary-label vp-pos-summary-label-due">Due</span>
                    <span class="price_total vp-pos-summary-value vp-pos-summary-value-due number">0</span>
                </div>
            </div>

            <div class="vp-pos-summary-grid">
                <div class="vp-pos-summary-item @if (Gate::check('disable_discount') && !auth()->user()->can('superadmin') && !auth()->user()->can('admin')) hide @endif">
                    <span class="vp-pos-summary-key">
                        @lang('sale.discount')(-)
                        @if ($edit_discount)
                            <i class="fas fa-edit cursor-pointer" id="pos-edit-discount" title="@lang('sale.edit_discount')" aria-hidden="true" data-toggle="modal" data-target="#posEditDiscountModal"></i>
                        @endif
                    </span>
                    <span class="vp-pos-summary-val" id="total_discount">0</span>

                    <input type="hidden" name="discount_type" id="discount_type" value="@if (empty($edit)){{ 'percentage' }}@else{{ $transaction->discount_type }}@endif" data-default="percentage">
                    <input type="hidden" name="discount_amount" id="discount_amount" value="@if (empty($edit)){{ @num_format($business_details->default_sales_discount) }}@else{{ @num_format($transaction->discount_amount) }}@endif" data-default="{{ $business_details->default_sales_discount }}">
                    <input type="hidden" name="rp_redeemed" id="rp_redeemed" value="@if (empty($edit)){{ '0' }}@else{{ $transaction->rp_redeemed }}@endif">
                    <input type="hidden" name="rp_redeemed_amount" id="rp_redeemed_amount" value="@if (empty($edit)){{ '0' }}@else{{ $transaction->rp_redeemed_amount }}@endif">
                    <input type="hidden" name="customer_loyalty_tier" id="customer_loyalty_tier" value="">
                    <input type="hidden" name="promotion_code" id="promotion_code" value="@if (empty($edit)){{ '' }}@else{{ $transaction->promotion_code }}@endif">
                    <input type="hidden" name="promotion_discount_amount" id="promotion_discount_amount" value="@if (empty($edit)){{ '0' }}@else{{ $transaction->promotion_discount_amount }}@endif">
                </div>

                <div class="vp-pos-summary-item @if ($pos_settings['disable_order_tax'] != 0) hide @endif">
                    <span class="vp-pos-summary-key">
                        @lang('sale.order_tax')(+)
                        <i class="fas fa-edit cursor-pointer" title="@lang('sale.edit_order_tax')" aria-hidden="true" data-toggle="modal" data-target="#posEditOrderTaxModal" id="pos-edit-tax"></i>
                    </span>
                    <span class="vp-pos-summary-val" id="order_tax">@if (empty($edit))0 @else{{ $transaction->tax_amount }}@endif</span>

                    <input type="hidden" name="tax_rate_id" id="tax_rate_id" value="@if (empty($edit)){{ $business_details->default_sales_tax }}@else{{ $transaction->tax_id }}@endif" data-default="{{ $business_details->default_sales_tax }}">
                    <input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" value="@if (empty($edit)){{ @num_format($business_details->tax_calculation_amount) }}@else{{ @num_format($transaction->tax?->amount) }}@endif" data-default="{{ $business_details->tax_calculation_amount }}">
                </div>

                <div class="vp-pos-summary-item">
                    <span class="vp-pos-summary-key">
                        @lang('sale.shipping')(+)
                        <i class="fas fa-edit cursor-pointer" title="@lang('sale.shipping')" aria-hidden="true" data-toggle="modal" data-target="#posShippingModal"></i>
                    </span>
                    <span class="vp-pos-summary-val" id="shipping_charges_amount">0</span>

                    <input type="hidden" name="shipping_details" id="shipping_details" value="@if (empty($edit)){{ '' }}@else{{ $transaction->shipping_details }}@endif" data-default="">
                    <input type="hidden" name="shipping_address" id="shipping_address" value="@if (empty($edit)){{ '' }}@else{{ $transaction->shipping_address }}@endif">
                    <input type="hidden" name="shipping_status" id="shipping_status" value="@if (empty($edit)){{ '' }}@else{{ $transaction->shipping_status }}@endif">
                    <input type="hidden" name="delivered_to" id="delivered_to" value="@if (empty($edit)){{ '' }}@else{{ $transaction->delivered_to }}@endif">
                    <input type="hidden" name="delivery_person" id="delivery_person" value="@if (empty($edit)){{ '' }}@else{{ $transaction->delivery_person }}@endif">
                    <input type="hidden" name="shipping_charges" id="shipping_charges" value="@if (empty($edit)){{ @num_format(0.00) }}@else{{ @num_format($transaction->shipping_charges) }}@endif" data-default="0.00">
                </div>
            </div>

            <div class="vp-pos-grand-total">
                <span class="vp-pos-grand-total-label">@lang('sale.total')</span>
                <span class="vp-pos-grand-total-value number" id="vp_pos_total_payable_mirror">0.00</span>
            </div>
        </div>
    </div>
</div>
