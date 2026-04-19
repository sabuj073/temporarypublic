@extends('layouts.app')
@section('title', __('product.add_new_product'))

@section('content')

<div class="vp-products-page-wrap">
    <section class="content vp-products-content vp-product-create-content">
    @php
    $form_class = empty($duplicate_product) ? 'create' : '';
    $is_image_required = !empty($common_settings['is_product_image_required']);
    @endphp
    {!! Form::open(['url' => action([\App\Http\Controllers\ProductController::class, 'store']), 'method' => 'post',
    'id' => 'product_add_form','class' => 'product_form ' . $form_class, 'files' => true ]) !!}
    @component('components.widget', ['class' => 'box-primary vp-product-create-first-card'])
    <div class="vp-product-create-card-head">
        <a href="{{ action([\App\Http\Controllers\ProductController::class, 'index']) }}" class="vp-product-create-back" aria-label="@lang('sale.products')">
            <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="">
        </a>
        <h1 class="vp-product-create-card-title">@lang('product.add_new_product')</h1>
    </div>

    @php
    $default_location = null;
    if (count($business_locations) == 1) {
        $default_location = array_key_first($business_locations->toArray());
    }
    @endphp

    <div class="row vp-product-create-grid">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('name', __('product.product_name') . ':*') !!}
                {!! Form::text('name', !empty($duplicate_product->name) ? $duplicate_product->name : null, ['class' => 'form-control vp-pc-input', 'required',
                'placeholder' => __('product.product_name')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('sku', __('product.sku') . ':') !!} @show_tooltip(__('tooltip.sku'))
                {!! Form::text('sku', null, ['class' => 'form-control vp-pc-input',
                'placeholder' => __('product.sku')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('barcode_type', __('product.barcode_type') . ':*') !!}
                {!! Form::select('barcode_type', $barcode_types, !empty($duplicate_product->barcode_type) ? $duplicate_product->barcode_type : $barcode_default, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2 vp-pc-select', 'required']); !!}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('unit_id', __('product.unit') . ':*') !!}
                <div class="input-group vp-pc-input-group">
                    {!! Form::select('unit_id', $units, !empty($duplicate_product->unit_id) ? $duplicate_product->unit_id : session('business.default_unit'), ['class' => 'form-control select2 vp-pc-select', 'required']); !!}
                    <span class="input-group-btn">
                        <button type="button" @if(!auth()->user()->can('unit.create')) disabled @endif class="btn btn-flat vp-pc-addon-btn btn-modal" data-href="{{action([\App\Http\Controllers\UnitController::class, 'create'], ['quick_add' => true])}}" title="@lang('unit.add_unit')" data-container=".view_modal"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4 @if(!session('business.enable_brand')) hide @endif">
            <div class="form-group">
                {!! Form::label('brand_id', __('product.brand') . ':') !!}
                <div class="input-group vp-pc-input-group">
                    {!! Form::select('brand_id', $brands, !empty($duplicate_product->brand_id) ? $duplicate_product->brand_id : null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2 vp-pc-select']); !!}
                    <span class="input-group-btn">
                        <button type="button" @if(!auth()->user()->can('brand.create')) disabled @endif class="btn btn-flat vp-pc-addon-btn btn-modal" data-href="{{action([\App\Http\Controllers\BrandController::class, 'create'], ['quick_add' => true])}}" title="@lang('brand.add_brand')" data-container=".view_modal"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4 @if(!session('business.enable_category')) hide @endif">
            <div class="form-group">
                {!! Form::label('category_id', __('product.category') . ':') !!}
                {!! Form::select('category_id', $categories, !empty($duplicate_product->category_id) ? $duplicate_product->category_id : null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2 vp-pc-select']); !!}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-4 @if(!(session('business.enable_category') && session('business.enable_sub_category'))) hide @endif">
            <div class="form-group">
                {!! Form::label('sub_category_id', __('product.sub_category') . ':') !!}
                {!! Form::select('sub_category_id', $sub_categories, !empty($duplicate_product->sub_category_id) ? $duplicate_product->sub_category_id : null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2 vp-pc-select']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('product_locations', __('business.business_locations') . ':') !!} @show_tooltip(__('lang_v1.product_location_help'))
                {!! Form::select('product_locations[]', $business_locations, $default_location, ['class' => 'form-control select2 vp-pc-select', 'multiple', 'id' => 'product_locations']); !!}
            </div>
        </div>
        <div class="col-sm-4 @if(!empty($duplicate_product) && $duplicate_product->enable_stock == 0) hide @endif" id="alert_quantity_div">
            <div class="form-group">
                {!! Form::label('alert_quantity', __('product.alert_quantity') . ':') !!} @show_tooltip(__('tooltip.alert_quantity'))
                {!! Form::text('alert_quantity', !empty($duplicate_product->alert_quantity) ? @format_quantity($duplicate_product->alert_quantity) : null , ['class' => 'form-control input_number vp-pc-input',
                'placeholder' => __('product.alert_quantity'), 'min' => '0']); !!}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-4">
            <div class="form-group vp-pc-checkbox-block">
                <label class="vp-pc-checkbox-label">
                    {!! Form::checkbox('enable_stock', 1, !empty($duplicate_product) ? $duplicate_product->enable_stock : true, ['class' => 'input-icheck', 'id' => 'enable_stock']); !!}
                    <strong>@lang('product.manage_stock')</strong>
                </label>
                @show_tooltip(__('tooltip.enable_stock'))
                <p class="help-block vp-pc-help"><i>@lang('product.enable_stock_help')</i></p>
            </div>
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>

        <div class="clearfix"></div>

        <div class="col-sm-8 mb-5">
            <div class="form-group">
                {!! Form::label('product_description', __('lang_v1.product_description') . ':') !!}
                {!! Form::textarea('product_description', !empty($duplicate_product->product_description) ? $duplicate_product->product_description : null, ['class' => 'form-control']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group vp-pc-product-image-field">
                <div class="vp-pc-img-label" id="upload_image_label">@lang('lang_v1.product_image'):</div>
                <label class="vp-pc-image-dropzone" for="upload_image" aria-labelledby="upload_image_label">
                    {!! Form::file('image', ['id' => 'upload_image', 'accept' => 'image/*',
                    'required' => $is_image_required, 'class' => 'vp-pc-image-file']); !!}
                    <span class="vp-pc-image-dropzone-ui">
                        <i class="fa fa-cloud-upload vp-pc-image-upload-icon" aria-hidden="true"></i>
                        <span class="vp-pc-image-dropzone-text">Upload Browse...</span>
                    </span>
                </label>
                <div class="vp-pc-image-help">
                    <p class="help-block vp-pc-help">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])</p>
                    <p class="help-block vp-pc-help">@lang('lang_v1.aspect_ratio_should_be_1_1')</p>
                    <p class="help-block vp-pc-help vp-pc-image-allowed">@lang('lang_v1.allowed_file'): .jpeg, .jpg, .png, .gif, .webp</p>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-12">
            <div class="form-group vp-pc-brochure-field">
                <div class="vp-pc-img-label" id="product_brochure_label">@lang('lang_v1.product_brochure'):</div>
                <label class="vp-pc-image-dropzone vp-pc-image-dropzone--brochure" for="product_brochure" aria-labelledby="product_brochure_label">
                    {!! Form::file('product_brochure', ['id' => 'product_brochure', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types'))), 'class' => 'vp-pc-image-file']); !!}
                    <span class="vp-pc-image-dropzone-ui vp-pc-brochure-dropzone-ui">
                        <i class="fa fa-cloud-upload vp-pc-image-upload-icon vp-pc-brochure-upload-icon" aria-hidden="true"></i>
                        <span class="vp-pc-brochure-dropzone-text"><span class="vp-pc-brochure-txt-upload">Upload</span><span class="vp-pc-brochure-txt-browse"> Browse...</span></span>
                    </span>
                </label>
                <div class="vp-pc-image-help vp-pc-brochure-help">
                    <p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])</p>
                    <p class="help-block">@lang('lang_v1.allowed_file'): {{ implode(', ', array_values(config('constants.document_upload_mimes_types'))) }}</p>
                </div>
            </div>
        </div>
    </div>
    @endcomponent

    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group vp-pc-checkbox-block">
                <label class="vp-pc-checkbox-label">
                    {!! Form::checkbox('enable_sr_no', 1, !(empty($duplicate_product)) ? $duplicate_product->enable_sr_no : false, ['class' => 'input-icheck']); !!}
                    <strong>@lang('lang_v1.enable_imei_or_sr_no')</strong>
                </label>
                @show_tooltip(__('lang_v1.tooltip_sr_no'))
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group vp-pc-checkbox-block">
                <label class="vp-pc-checkbox-label">
                    {!! Form::checkbox('not_for_selling', 1, !(empty($duplicate_product)) ? $duplicate_product->not_for_selling : false, ['class' => 'input-icheck']); !!}
                    <strong>@lang('lang_v1.not_for_selling')</strong>
                </label>
                @show_tooltip(__('lang_v1.tooltip_not_for_selling'))
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('weight', __('lang_v1.weight') . ':') !!}
                {!! Form::text('weight', !empty($duplicate_product->weight) ? $duplicate_product->weight : null, ['class' => 'form-control vp-pc-input', 'placeholder' => __('lang_v1.weight')]); !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('preparation_time_in_minutes', __('lang_v1.preparation_time_in_minutes') . ':') !!}
                {!! Form::number('preparation_time_in_minutes', !empty($duplicate_product->preparation_time_in_minutes) ? $duplicate_product->preparation_time_in_minutes : null, ['class' => 'form-control vp-pc-input', 'placeholder' => __('lang_v1.preparation_time_in_minutes')]); !!}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @endcomponent

    @component('components.widget', ['class' => 'box-primary'])
    <div class="row vp-pc-pricing-card">
        <div class="col-sm-12">
            <div class="row vp-pc-pricing-dropdowns">
                <div class="col-sm-4 @if(!session('business.enable_price_tax')) hide @endif">
                    <div class="form-group">
                        {!! Form::label('tax', __('product.applicable_tax') . ':') !!}
                        {!! Form::select('tax', $taxes, !empty($duplicate_product->tax) ? $duplicate_product->tax : null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2 vp-pc-select'], $tax_attributes); !!}
                    </div>
                </div>
                <div class="col-sm-4 @if(!session('business.enable_price_tax')) hide @endif">
                    <div class="form-group">
                        {!! Form::label('tax_type', __('product.selling_price_tax_type') . ':*') !!}
                        {!! Form::select('tax_type', ['inclusive' => __('product.inclusive'), 'exclusive' => __('product.exclusive')], !empty($duplicate_product->tax_type) ? $duplicate_product->tax_type : 'exclusive',
                        ['class' => 'form-control select2 vp-pc-select', 'required']); !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('type', __('product.product_type') . ':*') !!} @show_tooltip(__('tooltip.product_type'))
                        {!! Form::select('type', $product_types, !empty($duplicate_product->type) ? $duplicate_product->type : null, ['class' => 'form-control select2 vp-pc-select',
                        'required', 'data-action' => !empty($duplicate_product) ? 'duplicate' : 'add', 'data-product_id' => !empty($duplicate_product) ? $duplicate_product->id : '0']); !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-sm-12" id="product_form_part">
            @include('product.partials.single_product_form_part', ['profit_percent' => $default_profit_percent, 'vendo_pricing_ui' => true])
        </div>

        <input type="hidden" id="variation_counter" value="1">
        <input type="hidden" id="default_profit_percent" value="{{ $default_profit_percent }}">

    </div>
    @endcomponent
    <div class="vp-product-create-footer">
        <div class="row">
            <div class="col-sm-12">
                <input type="hidden" name="submit_type" id="submit_type">
                <div class="vp-pc-action-buttons">
                    @can('product.opening_stock')
                    <button id="opening_stock_button" @if(!empty($duplicate_product) && $duplicate_product->enable_stock == 0) disabled @endif type="submit" value="submit_n_add_opening_stock" class="btn vp-pc-btn vp-pc-btn-opening submit_product_form">@lang('lang_v1.save_n_add_opening_stock')</button>
                    @endcan

                    <button type="submit" value="submit" class="btn vp-pc-btn vp-pc-btn-save submit_product_form">@lang('messages.save')</button>

                    <button type="submit" value="save_n_add_another" class="btn vp-pc-btn vp-pc-btn-save-another submit_product_form">@lang('lang_v1.save_n_add_another')</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    </section>
    <!-- /.content -->
</div>

@endsection

@section('css')
    @include('product.partials.vendo_product_form_page_styles')
@endsection

@section('javascript')

<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        __page_leave_confirmation('#product_add_form');

        onScan.attachTo(document, {
            suffixKeyCodes: [13], // enter-key expected at the end of a scan
            reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
            onScan: function(sCode, iQty) {
                $('input#sku').val(sCode);
            },
            onScanError: function(oDebug) {
                console.log(oDebug);
            },
            minLength: 2,
            ignoreIfFocusOn: ['input', '.form-control']
            // onKeyDetect: function(iKeyCode){ // output all potentially relevant key events - great for debugging!
            //     console.log('Pressed: ' + iKeyCode);
            // }
        });
    });
</script>
@endsection