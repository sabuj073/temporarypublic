@if(!session('business.enable_price_tax'))
  @php
    $default = 0;
    $class = 'hide';
  @endphp
@else
  @php
    $default = null;
    $class = '';
  @endphp
@endif
@php
    $common_settings = session()->get('business.common_settings');
    $vendo_pricing_ui = !empty($vendo_pricing_ui ?? false);
@endphp

@if(!$vendo_pricing_ui)
<div class="col-sm-12"><br>
    <div class="table-responsive">
    <table class="table table-bordered add-product-price-table table-condensed {{$class}}">
        <tr>
          <th>@lang('product.default_purchase_price')</th>
          <th>@lang('product.profit_percent') @show_tooltip(__('tooltip.profit_percent'))</th>
          <th>@lang('product.default_selling_price')</th>
          <th>@lang('lang_v1.product_image')</th>
        </tr>
        @foreach($product_deatails->variations as $variation )
            @php
                $is_image_required = !empty($common_settings['is_product_image_required']) && count($variation->media) == 0;
            @endphp
            @if($loop->first)
                <tr>
                    <td>
                        <input type="hidden" name="single_variation_id" value="{{$variation->id}}">

                        <div class="col-sm-6">
                          {!! Form::label('single_dpp', trans('product.exc_of_tax') . ':*') !!}

                          {!! Form::text('single_dpp', @num_format($variation->default_purchase_price), ['class' => 'form-control input-sm dpp input_number', 'placeholder' => __('product.exc_of_tax'), 'required']); !!}
                        </div>

                        <div class="col-sm-6">
                          {!! Form::label('single_dpp_inc_tax', trans('product.inc_of_tax') . ':*') !!}

                          {!! Form::text('single_dpp_inc_tax', @num_format($variation->dpp_inc_tax), ['class' => 'form-control input-sm dpp_inc_tax input_number', 'placeholder' => __('product.inc_of_tax'), 'required']); !!}
                        </div>
                    </td>

                    <td>
                        <br/>
                        {!! Form::text('profit_percent', @num_format($variation->profit_percent), ['class' => 'form-control input-sm input_number', 'id' => 'profit_percent', 'required']); !!}
                    </td>

                    <td>
                        <label><span class="dsp_label"></span></label>
                        {!! Form::text('single_dsp', @num_format($variation->default_sell_price), ['class' => 'form-control input-sm dsp input_number', 'placeholder' => __('product.exc_of_tax'), 'id' => 'single_dsp', 'required']); !!}

                        {!! Form::text('single_dsp_inc_tax', @num_format($variation->sell_price_inc_tax), ['class' => 'form-control input-sm hide input_number', 'placeholder' => __('product.inc_of_tax'), 'id' => 'single_dsp_inc_tax', 'required']); !!}
                    </td>
                    <td>
                        @php
                            $action = !empty($action) ? $action : '';
                        @endphp
                        @if($action !== 'duplicate')
                            @foreach($variation->media as $media)
                                <div class="img-thumbnail">
                                    <span class="badge bg-red delete-media" data-href="{{ action([\App\Http\Controllers\ProductController::class, 'deleteMedia'], ['media_id' => $media->id])}}"><i class="fas fa-times"></i></span>
                                    {!! $media->thumbnail() !!}
                                </div>
                            @endforeach
                        @endif
                        <div class="form-group">
                            {!! Form::label('variation_images', __('lang_v1.product_image') . ':') !!}
                            {!! Form::file('variation_images[]', ['class' => 'variation_images',
                                'accept' => 'image/*', 'multiple', 'required' => $is_image_required]); !!}
                            <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p></small>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </table>
    </div>
</div>
@else
<div class="table-responsive">
    <table class="table table-bordered add-product-price-table table-condensed {{ $class }} vp-pc-vendo-price-table">
        <tr>
          <th>@lang('product.default_purchase_price')</th>
          <th>@lang('product.profit_percent') @show_tooltip(__('tooltip.profit_percent'))</th>
          <th>@lang('product.default_selling_price')</th>
          <th>@lang('lang_v1.product_image')</th>
        </tr>
        @foreach($product_deatails->variations as $variation )
            @php
                $is_image_required = !empty($common_settings['is_product_image_required']) && count($variation->media) == 0;
                $action = !empty($action) ? $action : '';
            @endphp
            @if($loop->first)
                <tr>
                    <td class="vp-pc-vendo-td vp-pc-vendo-td-dpp">
                        <input type="hidden" name="single_variation_id" value="{{$variation->id}}">

                        <div class="col-sm-6 vp-pc-vendo-dpp-cell">
                          {!! Form::label('single_dpp', trans('product.exc_of_tax') . ':*') !!}

                          {!! Form::text('single_dpp', @num_format($variation->default_purchase_price), ['class' => 'form-control input-sm dpp input_number vp-pc-input', 'placeholder' => __('product.exc_of_tax'), 'required']); !!}
                        </div>

                        <div class="col-sm-6 vp-pc-vendo-dpp-cell">
                          {!! Form::label('single_dpp_inc_tax', trans('product.inc_of_tax') . ':*') !!}

                          {!! Form::text('single_dpp_inc_tax', @num_format($variation->dpp_inc_tax), ['class' => 'form-control input-sm dpp_inc_tax input_number vp-pc-input', 'placeholder' => __('product.inc_of_tax'), 'required']); !!}
                        </div>
                    </td>

                    <td class="vp-pc-vendo-td vp-pc-vendo-td-margin">
                        <div class="vp-pc-vendo-label-spacer" aria-hidden="true"></div>
                        {!! Form::text('profit_percent', @num_format($variation->profit_percent), ['class' => 'form-control input-sm input_number vp-pc-input', 'id' => 'profit_percent', 'required', 'title' => __('product.profit_percent'), 'aria-label' => __('product.profit_percent'), 'placeholder' => __('lang_v1.profit_margin')]); !!}
                    </td>

                    <td class="vp-pc-vendo-td vp-pc-vendo-td-dsp">
                        <label class="vp-pc-vendo-dsp-label" for="single_dsp"><span class="dsp_label"></span></label>
                        {!! Form::text('single_dsp', @num_format($variation->default_sell_price), ['class' => 'form-control input-sm dsp input_number vp-pc-input', 'placeholder' => __('product.exc_of_tax'), 'id' => 'single_dsp', 'required']); !!}

                        {!! Form::text('single_dsp_inc_tax', @num_format($variation->sell_price_inc_tax), ['class' => 'form-control input-sm hide input_number', 'placeholder' => __('product.inc_of_tax'), 'id' => 'single_dsp_inc_tax', 'required']); !!}
                    </td>
                    <td class="vp-pc-vendo-td vp-pc-vendo-td-image">
                        <div class="vp-pc-vendo-label-spacer" aria-hidden="true"></div>
                        @if($action !== 'duplicate')
                            @foreach($variation->media as $media)
                                <div class="img-thumbnail" style="margin-bottom: 8px;">
                                    <span class="badge bg-red delete-media" data-href="{{ action([\App\Http\Controllers\ProductController::class, 'deleteMedia'], ['media_id' => $media->id])}}"><i class="fas fa-times"></i></span>
                                    {!! $media->thumbnail() !!}
                                </div>
                            @endforeach
                        @endif
                        <div class="form-group vp-pc-variation-image-field">
                            <label class="vp-pc-image-dropzone vp-pc-image-dropzone--compact" for="variation_images_upload_edit">
                                <input type="file" name="variation_images[]" id="variation_images_upload_edit" class="vp-pc-image-file variation_images" accept="image/*" multiple @if($is_image_required) required @endif>
                                <span class="vp-pc-image-dropzone-ui">
                                    <i class="fa fa-cloud-upload vp-pc-image-upload-icon" aria-hidden="true"></i>
                                    <span class="vp-pc-variation-dropzone-text">Upload Browse...</span>
                                </span>
                            </label>
                            <div class="vp-pc-image-help">
                                <p class="help-block vp-pc-help">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])</p>
                                <p class="help-block vp-pc-help">@lang('lang_v1.aspect_ratio_should_be_1_1')</p>
                            </div>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </table>
</div>
@endif
