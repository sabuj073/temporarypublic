@extends('layouts.app')
@section('title', __('business.business_settings'))

@section('css')
    @include('business.partials.vendo_business_settings_page_styles')
@endsection

@section('content')
    {!! Form::open([
        'url' => action([\App\Http\Controllers\BusinessController::class, 'postBusinessSettings']),
        'method' => 'post',
        'id' => 'bussiness_edit_form',
        'files' => true,
    ]) !!}

    <div class="vp-business-settings-page-wrap no-print">
        <div class="vp-business-settings-shell">
            <div class="vp-business-settings-page-head">
                <button type="button" class="vp-business-settings-back" id="vp_business_settings_back_btn"
                    title="{{ __('messages.go_back') }}" aria-label="{{ __('messages.go_back') }}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <h1 class="vp-business-settings-page-title">@lang('business.business_settings')</h1>
            </div>

            <div class="vp-business-settings-search">
                @include('layouts.partials.search_settings')
            </div>

            <div class="pos-tab-container vp-business-settings-card">
                <div class="vp-business-settings-layout">
                    <aside class="vp-business-settings-sidebar">
                        <div class="pos-tab-menu">
                            <div class="list-group">
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base active"
                                    data-section-title="{{ __('business.business') }}">@lang('business.business')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('business.tax') }}">@lang('business.tax') @show_tooltip(__('tooltip.business_tax'))</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('business.product') }}">@lang('business.product')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('contact.contact') }}">@lang('contact.contact')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('business.sale') }}">@lang('business.sale')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('sale.pos_sale') }}">@lang('sale.pos_sale')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.display_screen') }}">@lang('lang_v1.display_screen')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('purchase.purchases') }}">@lang('purchase.purchases')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.payment') }}">@lang('lang_v1.payment')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('business.dashboard') }}">@lang('business.dashboard')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('business.system') }}">@lang('business.system')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.prefixes') }}">@lang('lang_v1.prefixes')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.email_settings') }}">@lang('lang_v1.email_settings')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.sms_settings') }}">@lang('lang_v1.sms_settings')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.reward_point_settings') }}">@lang('lang_v1.reward_point_settings')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.modules') }}">@lang('lang_v1.modules')</a>
                                <a href="#" class="list-group-item text-center tw-font-bold tw-text-sm md:tw-text-base"
                                    data-section-title="{{ __('lang_v1.custom_labels') }}">@lang('lang_v1.custom_labels')</a>
                            </div>
                        </div>
                    </aside>

                    <div class="vp-business-settings-main">
                        <div class="vp-business-settings-section-bar">
                            <span id="vp_bs_section_title">{{ __('business.business') }}</span>
                        </div>

                        <div class="pos-tab">
                            @include('business.partials.settings_business')
                            @include('business.partials.settings_tax')
                            @include('business.partials.settings_product')
                            @include('business.partials.settings_contact')
                            @include('business.partials.settings_sales')
                            @include('business.partials.settings_pos')
                            @include('business.partials.settings_display_pos')
                            @include('business.partials.settings_purchase')
                            @include('business.partials.settings_payment')
                            @include('business.partials.settings_dashboard')
                            @include('business.partials.settings_system')
                            @include('business.partials.settings_prefixes')
                            @include('business.partials.settings_email')
                            @include('business.partials.settings_sms')
                            @include('business.partials.settings_reward_point')
                            @include('business.partials.settings_modules')
                            @include('business.partials.settings_custom_labels')
                        </div>

                        <div class="vp-business-settings-actions">
                            <button class="vp-business-settings-submit" type="submit">@lang('business.update_settings')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#vp_business_settings_back_btn').on('click', function() {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.assign('{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}');
                }
            });

            function vpBsSyncSectionTitle() {
                var $a = $('.vp-business-settings-sidebar .list-group-item.active').first();
                if (!$a.length) {
                    return;
                }
                var t = $a.data('section-title');
                if (!t) {
                    t = $a.clone().children().remove().end().text().trim();
                }
                $('#vp_bs_section_title').text(t);
            }

            vpBsSyncSectionTitle();
            $(document).on('click', 'div.pos-tab-menu>div.list-group>a', function() {
                window.setTimeout(vpBsSyncSectionTitle, 0);
            });
            $('#search_settings').on('change', function() {
                window.setTimeout(vpBsSyncSectionTitle, 0);
            });
        });
    </script>
    <script type="text/javascript">
        __page_leave_confirmation('#bussiness_edit_form');
        $(document).on('ifToggled', '#use_superadmin_settings', function() {
            if ($('#use_superadmin_settings').is(':checked')) {
                $('#toggle_visibility').addClass('hide');
                $('.test_email_btn').addClass('hide');
            } else {
                $('#toggle_visibility').removeClass('hide');
                $('.test_email_btn').removeClass('hide');
            }
        });

        $(document).ready(function() {
            $('#test_email_btn').click(function() {
                var data = {
                    mail_driver: $('#mail_driver').val(),
                    mail_host: $('#mail_host').val(),
                    mail_port: $('#mail_port').val(),
                    mail_username: $('#mail_username').val(),
                    mail_password: $('#mail_password').val(),
                    mail_encryption: $('#mail_encryption').val(),
                    mail_from_address: $('#mail_from_address').val(),
                    mail_from_name: $('#mail_from_name').val(),
                };
                $.ajax({
                    method: 'post',
                    data: data,
                    url: "{{ action([\App\Http\Controllers\BusinessController::class, 'testEmailConfiguration']) }}",
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            swal({
                                text: result.msg,
                                icon: 'success'
                            });
                        } else {
                            swal({
                                text: result.msg,
                                icon: 'error'
                            });
                        }
                    },
                });
            });

            $('#test_sms_btn').click(function() {
                var test_number = $('#test_number').val();
                if (test_number.trim() == '') {
                    toastr.error(@json(__('lang_v1.test_number_is_required')));
                    $('#test_number').focus();

                    return false;
                }

                var data = {
                    url: $('#sms_settings_url').val(),
                    send_to_param_name: $('#send_to_param_name').val(),
                    msg_param_name: $('#msg_param_name').val(),
                    request_method: $('#request_method').val(),
                    param_1: $('#sms_settings_param_key1').val(),
                    param_2: $('#sms_settings_param_key2').val(),
                    param_3: $('#sms_settings_param_key3').val(),
                    param_4: $('#sms_settings_param_key4').val(),
                    param_5: $('#sms_settings_param_key5').val(),
                    param_6: $('#sms_settings_param_key6').val(),
                    param_7: $('#sms_settings_param_key7').val(),
                    param_8: $('#sms_settings_param_key8').val(),
                    param_9: $('#sms_settings_param_key9').val(),
                    param_10: $('#sms_settings_param_key10').val(),

                    param_val_1: $('#sms_settings_param_val1').val(),
                    param_val_2: $('#sms_settings_param_val2').val(),
                    param_val_3: $('#sms_settings_param_val3').val(),
                    param_val_4: $('#sms_settings_param_val4').val(),
                    param_val_5: $('#sms_settings_param_val5').val(),
                    param_val_6: $('#sms_settings_param_val6').val(),
                    param_val_7: $('#sms_settings_param_val7').val(),
                    param_val_8: $('#sms_settings_param_val8').val(),
                    param_val_9: $('#sms_settings_param_val9').val(),
                    param_val_10: $('#sms_settings_param_val10').val(),
                    test_number: test_number,

                    header_1: $('#sms_settings_header_key1').val(),
                    header_val_1: $('#sms_settings_header_val1').val(),
                    header_2: $('#sms_settings_header_key2').val(),
                    header_val_2: $('#sms_settings_header_val2').val(),
                    header_3: $('#sms_settings_header_key3').val(),
                    header_val_3: $('#sms_settings_header_val3').val(),
                    data_parameter_type: $('#data_parameter_type').val(),
                };

                $.ajax({
                    method: 'post',
                    data: data,
                    url: "{{ action([\App\Http\Controllers\BusinessController::class, 'testSmsConfiguration']) }}",
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            swal({
                                text: result.msg,
                                icon: 'success'
                            });
                        } else {
                            swal({
                                text: result.msg,
                                icon: 'error'
                            });
                        }
                    },
                });
            });

            $('select.custom_labels_products').change(function() {
                value = $(this).val();
                textarea = $(this).parents('div.custom_label_product_div').find('div.custom_label_product_dropdown');
                if (value == 'dropdown') {
                    textarea.removeClass('hide');
                } else {
                    textarea.addClass('hide');
                }
            });

            tinymce.init({
                selector: 'textarea#display_screen_heading',
                height: 250
            });

            $('.carousel_image').fileinput({
                showUpload: true,
                showPreview: true,
                browseLabel: LANG.file_browse_label,
                removeLabel: LANG.remove,
            });
        });
    </script>
@endsection
