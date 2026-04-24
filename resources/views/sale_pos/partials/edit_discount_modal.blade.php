<!-- Edit discount Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="posEditDiscountModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					@if($is_discount_enabled)
						@lang('sale.discount')
					@endif
					@if($is_rp_enabled)
						{{session('business.rp_name')}}
					@endif
				</h4>
			</div>
			<div class="modal-body">
				<div class="row @if(!$is_discount_enabled) hide @endif">
					<div class="col-md-12">
						<h4 class="modal-title">@lang('sale.edit_discount'):</h4>
					</div>
					<div class="col-md-6">
				        <div class="form-group">
				            {!! Form::label('discount_type_modal', __('sale.discount_type') . ':*' ) !!}
				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
				                {!! Form::select('discount_type_modal', ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], $discount_type , ['class' => 'form-control','placeholder' => __('messages.please_select'), 'required']); !!}
				            </div>
				        </div>
				    </div>
				    @php
				    	$max_discount = !is_null(auth()->user()->max_sales_discount_percent) ? auth()->user()->max_sales_discount_percent : '';

				    	//if sale discount is more than user max discount change it to max discount
				    	if($discount_type == 'percentage' && $max_discount != '' && $sales_discount > $max_discount) $sales_discount = $max_discount;
				    @endphp
				    <div class="col-md-6">
				        <div class="form-group">
				            {!! Form::label('discount_amount_modal', __('sale.discount_amount') . ':*' ) !!}
				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
				                {!! Form::text('discount_amount_modal', @num_format($sales_discount), ['class' => 'form-control input_number', 'data-max-discount' => $max_discount, 'data-max-discount-error_msg' => __('lang_v1.max_discount_error_msg', ['discount' => $max_discount != '' ? @num_format($max_discount) : '']) ]); !!}
				            </div>
				        </div>
				    </div>
				</div>
				<br>
				<div class="row @if(!$is_rp_enabled) hide @endif">
					<div class="well well-sm bg-light-gray col-md-12">
					<div class="col-md-12">
						<h4 class="modal-title">{{session('business.rp_name')}}:</h4>
					</div>
					<div class="col-md-6">
				        <div class="form-group">
				            {!! Form::label('rp_redeemed_modal', __('lang_v1.redeemed') . ':' ) !!}
				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-gift"></i>
				                </span>
				                {!! Form::number('rp_redeemed_modal', $rp_redeemed, ['class' => 'form-control', 'data-amount_per_unit_point' => session('business.redeem_amount_per_unit_rp'), 'data-max_points' => $max_available, 'min' => 0, 'data-min_order_total' => session('business.min_order_total_for_redeem') ]); !!}
				                <input type="hidden" id="rp_name" value="{{session('business.rp_name')}}">
				            </div>
				        </div>
				    </div>
				    <div class="col-md-6">
				    	<p><strong>@lang('lang_v1.available'):</strong> <span id="available_rp">{{$max_available}}</span></p>
				    	<h5><strong>@lang('lang_v1.redeemed_amount'):</strong> <span id="rp_redeemed_amount_text">{{@num_format($rp_redeemed_amount)}}</span></h5>
				    </div>
				    </div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<h4 class="modal-title">@lang('lang_v1.promotions_engine'):</h4>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							{!! Form::label('promotion_code_modal', __('lang_v1.promotion_code') . ':' ) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-ticket"></i>
								</span>
								{!! Form::text('promotion_code_modal', !empty($transaction) ? $transaction->promotion_code : null, ['class' => 'form-control', 'placeholder' => __('lang_v1.promotion_code')]); !!}
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<label>&nbsp;</label>
						<button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-w-full" id="apply_promotion_code">@lang('lang_v1.apply_promotion')</button>
					</div>
					<div class="col-md-12">
						<p>
							<strong>@lang('lang_v1.promotion_discount'):</strong>
							<span id="promotion_discount_amount_text">{{ !empty($transaction) ? @num_format($transaction->promotion_discount_amount) : @num_format(0) }}</span>
						</p>
						<input type="hidden" id="promotion_discount_amount_modal" value="{{ !empty($transaction) ? @num_format($transaction->promotion_discount_amount) : @num_format(0) }}">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white" id="posEditDiscountModalUpdate">@lang('messages.update')</button>
			    <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang('messages.cancel')</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->