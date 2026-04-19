@extends('layouts.app')
@section('title', __('purchase.purchases'))

@section('css')
    @include('purchase.partials.vendo_purchases_page_styles')
@endsection

@section('content')
    <div class="vp-purchases-page-wrap no-print">
        <div class="vp-purchases-shell">
            <div class="vp-purchases-page-head">
                <button type="button" class="vp-purchases-back" id="vp_purchases_back_btn" title="{{ __('messages.go_back') }}"
                    aria-label="{{ __('messages.go_back') }}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <h1 class="vp-purchases-page-title">@lang('purchase.purchases')</h1>
            </div>

            <div class="vp-purchases-card">
                <div class="vp-purchases-filters">
                    <div class="vp-purchases-filter-row">
                        <div class="vp-purchases-filter-field">
                            {!! Form::label('purchase_list_filter_location_id', __('purchase.business_location')) !!}
                            {!! Form::select('purchase_list_filter_location_id', $business_locations, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-purchases-filter-field">
                            {!! Form::label('purchase_list_filter_supplier_id', __('purchase.supplier')) !!}
                            {!! Form::select('purchase_list_filter_supplier_id', $suppliers, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-purchases-filter-field">
                            {!! Form::label('purchase_list_filter_status', __('purchase.purchase_status')) !!}
                            {!! Form::select('purchase_list_filter_status', $orderStatuses, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-purchases-filter-field">
                            {!! Form::label('purchase_list_filter_payment_status', __('purchase.payment_status')) !!}
                            {!! Form::select(
                                'purchase_list_filter_payment_status',
                                [
                                    'paid' => __('lang_v1.paid'),
                                    'due' => __('lang_v1.due'),
                                    'partial' => __('lang_v1.partial'),
                                    'overdue' => __('lang_v1.overdue'),
                                ],
                                null,
                                ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')],
                            ) !!}
                        </div>
                        <div class="vp-purchases-filter-field">
                            {!! Form::label('purchase_list_filter_date_range', __('report.date_range')) !!}
                            {!! Form::text('purchase_list_filter_date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="vp-purchases-card-toolbar">
                    <h2 class="vp-purchases-card-title">@lang('purchase.all_purchases')</h2>
                    <div class="vp-purchases-card-toolbar-end">
                        <div class="vp-purchases-slot vp-purchases-filter-slot"></div>
                        <div class="vp-purchases-slot vp-purchases-length-slot"></div>
                        @can('purchase.create')
                            <a class="vp-purchases-add-btn" href="{{ action([\App\Http\Controllers\PurchaseController::class, 'create']) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="vp-purchases-table-wrap">
                    @include('purchase.partials.purchase_table')
                </div>

                <div class="vp-purchases-card-footer">
                    <div class="vp-purchases-slot vp-purchases-info-slot"></div>
                    <div class="vp-purchases-slot vp-purchases-paginate-slot"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="vp-purchases-export-dock no-print">
        <div id="vp-purchases-export-inner" class="vp-purchases-export-inner"></div>
    </div>

    <div class="modal fade product_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

    @include('purchase.partials.update_purchase_status_modal')

    <section id="receipt_section" class="print_section"></section>
@endsection

@section('javascript')
    <script>
        window.__vpPurchasesMoveLayout = function() {
            var w = $('#purchase_table_wrapper');
            if (!w.length || !$('.vp-purchases-page-wrap').length) {
                return;
            }
            w.find('.dataTables_filter').appendTo('.vp-purchases-filter-slot');
            w.find('.dataTables_length').appendTo('.vp-purchases-length-slot');
            w.find('.dataTables_info').appendTo('.vp-purchases-info-slot');
            w.find('.dataTables_paginate').appendTo('.vp-purchases-paginate-slot');
            var $dtButtons = w.find('.dt-buttons');
            if ($dtButtons.length && $('#vp-purchases-export-inner').length) {
                $('#vp-purchases-export-inner').empty().append($dtButtons);
            }
            w.find('.row.margin-bottom-20').first().hide();
            $('.vp-purchases-filter-slot .dataTables_filter input').attr({
                type: 'search',
                autocomplete: 'off'
            });
            if (typeof LANG !== 'undefined' && LANG.search) {
                $('.vp-purchases-filter-slot .dataTables_filter input').attr('placeholder', LANG.search + ' ...');
            }
            if (!$('#vp-purchases-export-inner').find('.dt-buttons').length) {
                $('.vp-purchases-export-dock').removeClass('vp-purchases-export-dock--visible');
            } else {
                $('.vp-purchases-export-dock').addClass('vp-purchases-export-dock--visible');
            }
        };

        window.__vpPurchasesDataTableOverrides = {
            scrollY: '',
            scrollX: false,
            scrollCollapse: false,
        };
        @cannot('view_export_buttons')
            window.__vpPurchasesDataTableOverrides.dom = 'lfrtip';
            window.__vpPurchasesDataTableOverrides.buttons = [];
        @endcannot
    </script>
    @php
        $custom_labels = json_decode(session('business.custom_labels'), true);
    @endphp
    <script>
        var customFieldVisibility = {
            custom_field_1: @json(!empty($custom_labels['purchase']['custom_field_1'])),
            custom_field_2: @json(!empty($custom_labels['purchase']['custom_field_2'])),
            custom_field_3: @json(!empty($custom_labels['purchase']['custom_field_3'])),
            custom_field_4: @json(!empty($custom_labels['purchase']['custom_field_4']))
        };
    </script>
    <script src="{{ asset('js/purchase.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script>
        $('#vp_purchases_back_btn').on('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.assign('{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}');
            }
        });

        $('#purchase_list_filter_date_range').daterangepicker(
            dateRangeSettings,
            function(start, end) {
                $('#purchase_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                    moment_date_format));
                if (typeof purchase_table !== 'undefined' && purchase_table) {
                    purchase_table.ajax.reload();
                }
            }
        );
        $('#purchase_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#purchase_list_filter_date_range').val('');
            if (typeof purchase_table !== 'undefined' && purchase_table) {
                purchase_table.ajax.reload();
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                if (typeof window.__vpPurchasesMoveLayout === 'function') {
                    window.__vpPurchasesMoveLayout();
                }
            }, 450);
        });

        $(document).on('click', '.update_status', function(e) {
            e.preventDefault();
            $('#update_purchase_status_form').find('#status').val($(this).data('status'));
            $('#update_purchase_status_form').find('#purchase_id').val($(this).data('purchase_id'));
            $('#update_purchase_status_modal').modal('show');
        });

        $(document).on('submit', '#update_purchase_status_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    __disable_submit_button(form.find('button[type="submit"]'));
                },
                success: function(result) {
                    if (result.success == true) {
                        $('#update_purchase_status_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof purchase_table !== 'undefined' && purchase_table) {
                            purchase_table.ajax.reload();
                        }
                        $('#update_purchase_status_form')
                            .find('button[type="submit"]')
                            .attr('disabled', false);
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        });
    </script>
@endsection
