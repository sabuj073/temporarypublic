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
    $vendo_pricing_ui = !empty($vendo_pricing_ui ?? false);
@endphp

<div class="table-responsive">
    <table class="table table-bordered add-product-price-table table-condensed {{ $class }} {{ $vendo_pricing_ui ? 'vp-pc-vendo-price-table' : '' }}">
        <tr>
          <th>@lang('product.default_purchase_price')</th>
          <th>@lang('product.profit_percent') @show_tooltip(__('tooltip.profit_percent'))</th>
          <th>@lang('product.default_selling_price')</th>
          @if(empty($quick_add))
            <th>@lang('lang_v1.product_image')</th>
          @endif
        </tr>
        <tr>
          <td @if($vendo_pricing_ui) class="vp-pc-vendo-td vp-pc-vendo-td-dpp" @endif>
            <div class="col-sm-6 {{ $vendo_pricing_ui ? 'vp-pc-vendo-dpp-cell' : '' }}">
              {!! Form::label('single_dpp', trans('product.exc_of_tax') . ':*') !!}

              {!! Form::text('single_dpp', $default, ['class' => 'form-control input-sm dpp input_number' . ($vendo_pricing_ui ? ' vp-pc-input' : ''), 'placeholder' => __('product.exc_of_tax'), 'required']); !!}
            </div>

            <div class="col-sm-6 {{ $vendo_pricing_ui ? 'vp-pc-vendo-dpp-cell' : '' }}">
              {!! Form::label('single_dpp_inc_tax', trans('product.inc_of_tax') . ':*') !!}

              {!! Form::text('single_dpp_inc_tax', $default, ['class' => 'form-control input-sm dpp_inc_tax input_number' . ($vendo_pricing_ui ? ' vp-pc-input' : ''), 'placeholder' => __('product.inc_of_tax'), 'required']); !!}
            </div>
          </td>

          <td @if($vendo_pricing_ui) class="vp-pc-vendo-td vp-pc-vendo-td-margin" @endif>
            @if(empty($vendo_pricing_ui))
            <br/>
            @else
            <div class="vp-pc-vendo-label-spacer" aria-hidden="true"></div>
            @endif
            {!! Form::text('profit_percent', @num_format($profit_percent), ['class' => 'form-control input-sm input_number' . ($vendo_pricing_ui ? ' vp-pc-input' : ''), 'id' => 'profit_percent', 'required', 'title' => __('product.profit_percent'), 'aria-label' => __('product.profit_percent'), 'placeholder' => __('lang_v1.profit_margin')]); !!}
          </td>

          <td @if($vendo_pricing_ui) class="vp-pc-vendo-td vp-pc-vendo-td-dsp" @endif>
            <label class="vp-pc-vendo-dsp-label" for="single_dsp"><span class="dsp_label">@lang('product.exc_of_tax')</span></label>
            {!! Form::text('single_dsp', $default, ['class' => 'form-control input-sm dsp input_number' . ($vendo_pricing_ui ? ' vp-pc-input' : ''), 'placeholder' => __('product.exc_of_tax'), 'id' => 'single_dsp', 'required']); !!}

            {!! Form::text('single_dsp_inc_tax', $default, ['class' => 'form-control input-sm hide input_number', 'placeholder' => __('product.inc_of_tax'), 'id' => 'single_dsp_inc_tax', 'required']); !!}
          </td>
          @if(empty($quick_add))
          <td @if(!empty($vendo_pricing_ui)) class="vp-pc-vendo-td vp-pc-vendo-td-image" @endif>
              @if(!empty($vendo_pricing_ui))
              <div class="vp-pc-vendo-label-spacer" aria-hidden="true"></div>
              <div class="form-group vp-pc-variation-image-field">
                <label class="vp-pc-image-dropzone vp-pc-image-dropzone--compact" for="variation_images_upload">
                  <input type="file" name="variation_images[]" id="variation_images_upload" class="vp-pc-image-file variation_images" accept="image/*" multiple>
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
              @else
              <div class="form-group">
                {!! Form::label('variation_images', __('lang_v1.product_image') . ':') !!}
                {!! Form::file('variation_images[]', ['class' => 'variation_images',
                    'accept' => 'image/*', 'multiple']); !!}
                <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p></small>
              </div>
              @endif
          </td>
          @endif
        </tr>
    </table>
</div>
