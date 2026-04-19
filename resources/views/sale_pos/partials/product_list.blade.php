@forelse($products as $product)
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box hover:tw-shadow-lg hover:tw-animate-pulse" data-variation_id="{{$product->id}}" title="{{$product->name}} @if($product->type == 'variable')- {{$product->variation}} @endif {{ '(' . $product->sub_sku . ')'}} @if(!empty($show_prices)) @lang('lang_v1.default') - @format_currency($product->selling_price) @foreach($product->group_prices as $group_price) @if(array_key_exists($group_price->price_group_id, $allowed_group_prices)) {{$allowed_group_prices[$group_price->price_group_id]}} - @format_currency($group_price->price_inc_tax) @endif @endforeach @endif">

		<div class="image-container" 
			style="background-image: url(
					@if(count($product->media) > 0)
						{{$product->media->first()->display_url}}
					@elseif(!empty($product->product_image))
						{{asset('/uploads/img/' . rawurlencode($product->product_image))}}
					@else
						{{asset('/img/default.png')}}
					@endif
				);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<div class="vp-pos-product-title">{{ $product->name }}
			@if($product->type == 'variable')
				<span class="vp-pos-product-var"> — {{ $product->variation }}</span>
			@endif
			</div>
			<div class="vp-pos-product-price">@format_currency($product->selling_price)</div>
			<div class="vp-pos-product-meta text-muted">
				<span class="vp-pos-product-sku">({{ $product->sub_sku }})</span>
				<span class="vp-pos-product-stock">
				@if($product->enable_stock)
					{{ @num_format($product->qty_available) }} {{ $product->unit }} @lang('lang_v1.in_stock')
				@else
					&mdash;
				@endif
				</span>
			</div>
		</div>
			
		</div>
	</div>
@empty
	<input type="hidden" id="no_products_found">
	<div class="col-md-12">
		<h4 class="text-center">
			@lang('lang_v1.no_products_to_display')
		</h4>
	</div>
@endforelse