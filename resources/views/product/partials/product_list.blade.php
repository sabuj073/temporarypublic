@php 
    $colspan = 15;
    $custom_labels = json_decode(session('business.custom_labels'), true);
@endphp
<table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
    <thead>
        <tr>
            <th><input type="checkbox" id="select-all-row" data-table-id="product_table"></th>
            <th class="vp-product-image-col">{{__('lang_v1.product_image')}} </th>
            <th>@lang('sale.product')</th>
            <th>@lang('purchase.business_location') @show_tooltip(__('lang_v1.product_business_location_tooltip'))</th>
            @can('view_purchase_price')
                @php 
                    $colspan++;
                @endphp
                <th>@lang('lang_v1.unit_perchase_price')</th>
            @endcan
            @can('access_default_selling_price')
                @php 
                    $colspan++;
                @endphp
                <th>@lang('lang_v1.selling_price')</th>
            @endcan
            <th>@lang('report.current_stock')</th>
            <th>@lang('product.product_type')</th>
            <th>@lang('product.category')</th>
            <th>@lang('product.brand')</th>
            <th>@lang('product.tax')</th>
            <th>@lang('product.sku')</th>
            <th id="cf_1">{{ $custom_labels['product']['custom_field_1'] ?? '' }}</th>
            <th id="cf_2">{{ $custom_labels['product']['custom_field_2'] ?? '' }}</th>
            <th id="cf_3">{{ $custom_labels['product']['custom_field_3'] ?? '' }}</th>
            <th id="cf_4">{{ $custom_labels['product']['custom_field_4'] ?? '' }}</th>
            <th id="cf_5">{{ $custom_labels['product']['custom_field_5'] ?? '' }}</th>
            <th id="cf_6">{{ $custom_labels['product']['custom_field_6'] ?? '' }}</th>
            <th id="cf_7">{{ $custom_labels['product']['custom_field_7'] ?? '' }}</th>
            <th>@lang('messages.action')</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="{{$colspan}}">
            <div class="vp-product-bulk-actions">
                @can('product.delete')
                    {!! Form::open(['url' => action([\App\Http\Controllers\ProductController::class, 'massDestroy']), 'method' => 'post', 'id' => 'mass_delete_form' ]) !!}
                    {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']); !!}
                    {!! Form::submit(__('lang_v1.delete_selected'), array('class' => 'tw-dw-btn tw-dw-btn-xs vp-bulk-btn vp-bulk-btn-delete', 'id' => 'delete-selected')) !!}
                    {!! Form::close() !!}
                @endcan
                @can('product.update')
                    <button type="button" class="tw-dw-btn tw-dw-btn-xs vp-bulk-btn vp-bulk-btn-add-location update_product_location" data-type="add">@lang('lang_v1.add_to_location')</button>
                    <button type="button" class="tw-dw-btn tw-dw-btn-xs vp-bulk-btn vp-bulk-btn-remove-location update_product_location" data-type="remove">@lang('lang_v1.remove_from_location')</button>
                    <button type="button" class="tw-dw-btn tw-dw-btn-xs vp-bulk-btn vp-bulk-btn-activate" id="activate-selected">Active selected</button>
                @endcan
                {!! Form::open(['url' => action([\App\Http\Controllers\ProductController::class, 'massDeactivate']), 'method' => 'post', 'id' => 'mass_deactivate_form' ]) !!}
                    {!! Form::hidden('selected_products', null, ['id' => 'selected_products']); !!}
                    {!! Form::submit(__('lang_v1.deactivate_selected'), array('class' => 'tw-dw-btn tw-dw-btn-xs vp-bulk-btn vp-bulk-btn-deactivate', 'id' => 'deactivate-selected')) !!}
                {!! Form::close() !!}
                @if($is_woocommerce)
                    <button type="button" class="tw-dw-btn tw-dw-btn-xs vp-bulk-btn vp-bulk-btn-deactivate toggle_woocomerce_sync">
                        @lang('lang_v1.woocommerce_sync')
                    </button>
                @endif
                </div>
            </td>
        </tr>
    </tfoot>
</table>
