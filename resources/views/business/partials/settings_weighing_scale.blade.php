<div class="row">
    <div class="col-sm-12">
        <h4>@lang('lang_v1.weighing_scale_setting'):</h4>
        <p>@lang('lang_v1.weighing_scale_setting_help')</p>
        <br/>
    </div>

    <!-- 1st part: Prefix (here any prefix can be entered), user can leave it blank also if prefix not supported by scale.
	2nd part: Dropdown list from 1 to 9 for Barcode 0
	3rd part: Dropdown list from 1 to 5 for Quantity 
	4th part: Dropdown list from 1 to 4 for Quantity decimals. -->


    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('label_prefix', __('lang_v1.weighing_barcode_prefix') . ':') !!}
             {!! Form::text('weighing_scale_setting[label_prefix]', isset($weighing_scale_setting['label_prefix']) ? $weighing_scale_setting['label_prefix'] : null, ['class' => 'form-control', 'id' => 'label_prefix']); !!}
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('product_sku_length', __('lang_v1.weighing_product_sku_length') . ':') !!}
            
            {!! Form::select('weighing_scale_setting[product_sku_length]', [1,2,3,4,5,6,7,8,9], isset($weighing_scale_setting['product_sku_length']) ? $weighing_scale_setting['product_sku_length'] : 4, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'product_sku_length']); !!}
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('qty_length', __('lang_v1.weighing_qty_integer_part_length') . ':') !!}
            
            {!! Form::select('weighing_scale_setting[qty_length]', [1,2,3,4,5], isset($weighing_scale_setting['qty_length']) ? $weighing_scale_setting['qty_length'] : 3, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'qty_length']); !!}
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('qty_length_decimal', __('lang_v1.weighing_qty_fractional_part_length') . ':') !!}
            {!! Form::select('weighing_scale_setting[qty_length_decimal]', [1,2,3,4], isset($weighing_scale_setting['qty_length_decimal']) ? $weighing_scale_setting['qty_length_decimal'] : 2, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'qty_length_decimal']); !!}
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-sm-12"><hr><h4>Live Weighing Scale Integration</h4></div>
    <div class="col-sm-4">
        <div class="form-group">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('common_settings[enable_scale_live_read]', 1, !empty($common_settings['enable_scale_live_read']), [ 'class' => 'input-icheck']) !!}
                    Enable live scale read
                </label>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('scale_api_url', 'Scale API URL:') !!}
            {!! Form::text('common_settings[scale_api_url]', $common_settings['scale_api_url'] ?? null, ['class' => 'form-control', 'placeholder' => 'https://scale-adapter.local/read']) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('scale_api_key', 'Scale API Key:') !!}
            {!! Form::text('common_settings[scale_api_key]', $common_settings['scale_api_key'] ?? null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('scale_tcp_host', 'Scale TCP Host:') !!}
            {!! Form::text('common_settings[scale_tcp_host]', $common_settings['scale_tcp_host'] ?? null, ['class' => 'form-control', 'placeholder' => '192.168.1.80']) !!}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('scale_tcp_port', 'Scale TCP Port:') !!}
            {!! Form::number('common_settings[scale_tcp_port]', $common_settings['scale_tcp_port'] ?? null, ['class' => 'form-control', 'placeholder' => '3001']) !!}
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-sm-12"><hr><h4>Electronic Shelf Label (ESL) Integration</h4></div>
    <div class="col-sm-4">
        <div class="form-group">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('common_settings[enable_esl_integration]', 1, !empty($common_settings['enable_esl_integration']), [ 'class' => 'input-icheck']) !!}
                    Enable ESL integration
                </label>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('esl_vendor', 'ESL Vendor:') !!}
            {!! Form::select('common_settings[esl_vendor]', ['generic' => 'Generic adapter', 'solum' => 'SoluM', 'sesimagotag' => 'SES-imagotag', 'hanshow' => 'Hanshow'], $common_settings['esl_vendor'] ?? 'generic', ['class' => 'form-control select2', 'style' => 'width:100%;']) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('esl_api_url', 'ESL API URL:') !!}
            {!! Form::text('common_settings[esl_api_url]', $common_settings['esl_api_url'] ?? null, ['class' => 'form-control', 'placeholder' => 'https://esl-adapter.local/sync-price']) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('esl_api_key', 'ESL API Key:') !!}
            {!! Form::text('common_settings[esl_api_key]', $common_settings['esl_api_key'] ?? null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group" style="margin-top: 25px;">
            <button type="button" id="test_esl_connection" class="tw-dw-btn tw-dw-btn-primary tw-text-white">Test ESL Connection</button>
        </div>
    </div>
    <div class="col-sm-12">
        <p id="test_esl_result" class="help-block"></p>
    </div>
</div>

<script>
$(document).on('click', '#test_esl_connection', function() {
    $.ajax({
        method: 'POST',
        url: "{{ route('integrations.esl.test') }}",
        data: {_token: "{{ csrf_token() }}"},
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#test_esl_result').text('ESL connection successful');
            } else {
                $('#test_esl_result').text('ESL connection failed: ' + (result.message || result.error || 'Unknown'));
            }
        },
        error: function() {
            $('#test_esl_result').text('ESL connection test failed.');
        }
    });
});
</script>