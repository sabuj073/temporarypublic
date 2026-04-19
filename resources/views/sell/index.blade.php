@extends('layouts.app')
@section('title', __('lang_v1.all_sales'))

@section('content')
    <div class="vp-sales-page-wrap">

        <!-- Content Header (Page header) -->
        <section class="content-header no-print vp-sales-header">
            <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black vp-sales-header-title">
                <span class="vp-sales-header-title-row">
                    <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-sales-back-btn" aria-label="Back to home">
                        <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="Back">
                    </a>
                    <span class="vp-sales-title-text">@lang('sale.sells')</span>
                </span>
                <span id="sell_list_selected_range" class="tw-text-gray-600 tw-font-normal tw-text-base">
                    {{ @format_date(\Carbon\Carbon::now()->subDays(29)) }} ~ {{ @format_date(\Carbon\Carbon::now()) }}
                </span>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content no-print vp-sales-content">
            <div class="vp-sales-filter-card">
                <div class="vp-sales-filter-row">
                    <div class="vp-filter-field">
                        {!! Form::label('sell_list_filter_location_id', __('purchase.business_location')) !!}
                        {!! Form::select('sell_list_filter_location_id', $business_locations, null, [
                            'class' => 'form-control select2',
                            'placeholder' => __('lang_v1.all'),
                            'style' => 'width:100%',
                        ]) !!}
                    </div>

                    <div class="vp-filter-field">
                        {!! Form::label('sell_list_filter_customer_id', __('contact.customer')) !!}
                        {!! Form::select('sell_list_filter_customer_id', $customers, null, [
                            'class' => 'form-control select2',
                            'placeholder' => __('lang_v1.all'),
                            'style' => 'width:100%',
                        ]) !!}
                    </div>

                    <div class="vp-filter-field">
                        {!! Form::label('sell_list_filter_payment_status', __('purchase.payment_status')) !!}
                        {!! Form::select('sell_list_filter_payment_status', ['paid' => __('lang_v1.paid'), 'due' => __('lang_v1.due'), 'partial' => __('lang_v1.partial'), 'overdue' => __('lang_v1.overdue')], null, [
                            'class' => 'form-control select2',
                            'placeholder' => __('lang_v1.all'),
                            'style' => 'width:100%',
                        ]) !!}
                    </div>

                    <div class="vp-filter-field">
                        {!! Form::label('sell_list_filter_date_range', __('report.date_range')) !!}
                        {!! Form::text('sell_list_filter_date_range', null, [
                            'placeholder' => __('lang_v1.select_a_date_range'),
                            'class' => 'form-control',
                            'readonly',
                        ]) !!}
                    </div>

                    <div class="vp-filter-field">
                        {!! Form::label('created_by', __('report.user')) !!}
                        {!! Form::select('created_by', $sales_representative ?? [], null, [
                            'class' => 'form-control select2',
                            'placeholder' => __('lang_v1.all'),
                            'style' => 'width:100%',
                        ]) !!}
                    </div>

                    <div class="vp-filter-field">
                        {!! Form::label('shipping_status', __('lang_v1.shipping_status')) !!}
                        {!! Form::select('shipping_status', $shipping_statuses ?? [], null, [
                            'class' => 'form-control select2',
                            'placeholder' => __('lang_v1.all'),
                            'style' => 'width:100%',
                        ]) !!}
                    </div>

                    <div class="vp-filter-action">
                        <label>&nbsp;</label>
                        <button type="button" id="vp-apply-sales-filter" class="btn vp-apply-btn">
                            Apply <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.all_sales')])
                @can('direct_sell.access')
                    @slot('tool')
                        <div class="box-tools">
                            <a class="tw-dw-btn vp-add-btn pull-right"
                                href="{{ action([\App\Http\Controllers\SellController::class, 'create']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg> @lang('messages.add')
                            </a>
                        </div>
                    @endslot
                @endcan
                @if (auth()->user()->can('direct_sell.view') ||
                        auth()->user()->can('view_own_sell_only') ||
                        auth()->user()->can('view_commission_agent_sell'))
                    @php
                        $custom_labels = json_decode(session('business.custom_labels'), true);
                    @endphp
                    <table class="table table-bordered table-striped ajax_view" id="sell_table">
                        <thead>
                            <tr>
                                <th>@lang('messages.date')</th>
                                <th>@lang('sale.invoice_no')</th>
                                <th>@lang('sale.customer_name')</th>
                                <th>@lang('sale.location')</th>
                                <th>@lang('sale.payment_status')</th>
                                <th>@lang('lang_v1.payment_method')</th>
                                <th>@lang('sale.total_amount')</th>
                                <th>@lang('sale.total_paid')</th>
                                <th>@lang('lang_v1.sell_due')</th>
                                <th>@lang('lang_v1.total_items')</th>
                                <th>@lang('lang_v1.added_by')</th>
                                <th>@lang('sale.sell_note')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr class="bg-gray font-17 footer-total text-center">
                                <td colspan="4"><strong>@lang('sale.total'):</strong></td>
                                <td class="footer_payment_status_count"></td>
                                <td class="payment_method_count"></td>
                                <td class="footer_sale_total"></td>
                                <td class="footer_total_paid"></td>
                                <td class="footer_total_remaining"></td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="vp-sales-export-actions" class="vp-sales-export-actions"></div>
                @endif
            @endcomponent
        </section>
    </div>
    <!-- /.content -->
    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    <!-- This will be printed -->
    <section class="invoice print_section" id="receipt_section">
        </section> 

@stop

@section('css')
    <style>
        .vp-sales-page-wrap {
            margin: 22px 26px 28px;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
        }

        .vp-sales-header {
            margin-top: 0 !important;
            margin-bottom: 10px !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vp-sales-header h1.vp-sales-header-title {
            color: #fff !important;
            font-size: 34px !important;
            font-weight: 700 !important;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            min-width: 0;
            row-gap: 10px;
        }

        .vp-sales-header .vp-sales-header-title-row {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            flex-shrink: 0;
        }

        .vp-sales-header .vp-sales-title-text {
            white-space: nowrap;
        }

        .vp-sales-back-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            flex-shrink: 0;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(18, 29, 64, 0.18);
        }

        .vp-sales-back-btn img {
            width: 14px;
            height: 14px;
            object-fit: contain;
            display: block;
        }

        .vp-sales-header #sell_list_selected_range {
            flex: 0 1 auto;
            max-width: 100%;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px !important;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 6px 10px;
        }

        .vp-sales-content .box,
        .vp-sales-content .box.box-primary {
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: #fff !important;
            margin: 0 !important;
        }

        .vp-sales-content .box-header {
            border: none !important;
            border-radius: 0 !important;
            background: #fff;
            padding: 14px 14px 8px;
        }

        .vp-sales-content .box-body {
            border-radius: 0 0 12px 12px;
            background: #fff;
            padding: 10px 14px 14px;
        }

        .vp-sales-content .box-title {
            color: #27306f !important;
            font-size: 40px !important;
            font-weight: 700 !important;
            text-transform: none;
        }

        .vp-sales-content .box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .vp-sales-top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
            flex-wrap: nowrap;
        }

        .vp-sales-top-actions .dataTables_filter,
        .vp-sales-top-actions .dataTables_length,
        .vp-sales-top-actions .box-tools {
            margin: 0 !important;
            float: none !important;
        }

        .vp-sales-top-actions .dataTables_filter label,
        .vp-sales-top-actions .dataTables_length label {
            margin: 0 !important;
            font-size: 13px;
            font-weight: 600;
            color: #2a336e;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .vp-sales-top-actions .dataTables_filter input,
        .vp-sales-top-actions .dataTables_length select {
            height: 34px !important;
            border: 1px solid #cfd5ea !important;
            border-radius: 6px !important;
            padding: 6px 10px !important;
            font-size: 13px !important;
            color: #2f3970;
            min-width: 90px;
        }

        .vp-sales-top-actions .dataTables_filter input {
            min-width: 180px;
        }

        .vp-add-btn {
            min-width: 108px;
            height: 34px;
            padding: 0 12px !important;
            border-radius: 6px !important;
            border: none !important;
            background: #27306f !important;
            color: #fff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .vp-add-btn svg {
            width: 14px;
            height: 14px;
        }

        .vp-sales-filter-card {
            background: #fff;
            border-radius: 12px 12px 0 0;
            padding: 12px 12px 8px;
            margin-bottom: 0;
            border-bottom: 1px solid #e3e7f3;
        }

        .vp-sales-content {
            background: #fff;
            border-radius: 12px;
            overflow: visible;
            padding: 0 !important;
        }

        .vp-sales-filter-row {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            flex-wrap: nowrap;
        }

        .vp-filter-field {
            flex: 1;
            min-width: 150px;
        }

        .vp-filter-field label {
            color: #232f66 !important;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .vp-filter-action {
            width: 120px;
            min-width: 120px;
        }

        .vp-apply-btn {
            width: 100%;
            height: 34px;
            border: none;
            border-radius: 6px !important;
            background: #27306f !important;
            color: #fff !important;
            font-weight: 600;
            font-size: 13px;
        }

        .vp-sales-content .btn,
        .vp-sales-content .tw-dw-btn {
            border-radius: 6px !important;
        }

        .vp-sales-content .dataTables_wrapper {
            border-radius: 10px;
            overflow: visible;
            width: 100%;
        }

        .vp-sales-content .dataTables_scroll,
        .vp-sales-content .dataTables_scrollHead,
        .vp-sales-content .dataTables_scrollBody,
        .vp-sales-content .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        .vp-sales-content #sell_table {
            width: 100% !important;
        }

        .vp-sales-content table.dataTable thead th {
            color: #303a73 !important;
            background: #fbfbff;
            border-bottom: 1px solid #e3e6f3 !important;
            font-weight: 700;
            font-size: 12px;
        }

        .vp-sales-content table.dataTable tbody td {
            font-size: 12px;
            color: #2f3a67;
        }

        .vp-sales-content #sell_table .btn-group .btn,
        .vp-sales-content #sell_table .btn,
        .vp-sales-content #sell_table .dropdown-toggle {
            background: #27306f !important;
            border-color: #27306f !important;
            color: #fff !important;
        }

        .vp-sales-content #sell_table .btn-group .btn:hover,
        .vp-sales-content #sell_table .btn:hover,
        .vp-sales-content #sell_table .dropdown-toggle:hover {
            background: #1f275f !important;
            border-color: #1f275f !important;
            color: #fff !important;
        }

        .vp-sales-content #sell_table .dropdown-menu {
            z-index: 1051;
        }

        .vp-sales-content table.dataTable tfoot tr.footer-total {
            background: #27306f !important;
            color: #fff !important;
        }

        .vp-sales-content table.dataTable tfoot tr.footer-total td,
        .vp-sales-content table.dataTable tfoot tr.footer-total strong {
            color: #fff !important;
        }

        .vp-sales-content .form-control,
        .vp-sales-content .select2-selection {
            border-radius: 6px !important;
            border-color: #d1d6ea !important;
            min-height: 34px;
        }

        .vp-sales-export-actions {
            margin-top: 14px;
            display: flex;
            justify-content: center;
        }

        .vp-sales-export-actions .dt-buttons {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #cdd4e8;
            box-shadow: 0 4px 12px rgba(21, 31, 66, 0.15);
        }

        .vp-sales-export-actions .dt-button {
            background: #272f6f !important;
            color: #fff !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 7px 12px !important;
            font-size: 13px !important;
        }

        @media (max-width: 991px) {
            .vp-sales-page-wrap {
                margin: 14px 12px 16px;
                padding: 14px;
            }

            .vp-sales-header h1.vp-sales-header-title {
                font-size: 26px !important;
            }

            .vp-sales-content .box-title {
                font-size: 24px !important;
            }

            .vp-sales-top-actions {
                width: 100%;
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .vp-sales-filter-row {
                flex-wrap: wrap;
            }

            .vp-filter-field {
                min-width: calc(50% - 6px);
            }

            .vp-filter-action {
                width: 100%;
            }
        }
    </style>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            //Date range as a button
            var startLast30 = moment().subtract(29, 'days');
            var endLast = moment();
            
            // Function to update heading with date range
            function updateDateRangeHeading(start, end) {
                if (start && end) {
                    var formattedStart = start.format(moment_date_format);
                    var formattedEnd = end.format(moment_date_format);
                    $('#sell_list_selected_range').text(formattedStart + ' ~ ' + formattedEnd);
                } else {
                    // Reset to default (last 30 days)
                    var defaultStart = moment().subtract(29, 'days').format(moment_date_format);
                    var defaultEnd = moment().format(moment_date_format);
                    $('#sell_list_selected_range').text(defaultStart + ' ~ ' + defaultEnd);
                }
            }
            
            $('#sell_list_filter_date_range').daterangepicker(
                $.extend(true, {}, dateRangeSettings, { startDate: startLast30, endDate: endLast }),
                function(start, end) {
                    updateDateRangeHeading(start, end);
                    sell_table.ajax.reload();
                }
            );
            $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#sell_list_filter_date_range').val('');
                updateDateRangeHeading(null, null);
                sell_table.ajax.reload();
            });

            sell_table = $('#sell_table').DataTable({
                processing: true,
                serverSide: true,
                fixedHeader:false,
                aaSorting: [
                    [1, 'desc']
                ],
                "ajax": {
                    "url": "/sells",
                    "data": function(d) {
                        if ($('#sell_list_filter_date_range').val()) {
                            var start = $('#sell_list_filter_date_range').data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            var end = $('#sell_list_filter_date_range').data('daterangepicker').endDate
                                .format('YYYY-MM-DD');
                            d.start_date = start;
                            d.end_date = end;
                        }
                        d.is_direct_sale = 1;

                        d.location_id = $('#sell_list_filter_location_id').val();
                        d.customer_id = $('#sell_list_filter_customer_id').val();
                        d.payment_status = $('#sell_list_filter_payment_status').val();
                        d.created_by = $('#created_by').val();
                        d.sales_cmsn_agnt = $('#sales_cmsn_agnt').val();
                        d.service_staffs = $('#service_staffs').val();

                        if ($('#shipping_status').length) {
                            d.shipping_status = $('#shipping_status').val();
                        }

                        if ($('#sell_list_filter_source').length) {
                            d.source = $('#sell_list_filter_source').val();
                        }

                        if ($('#only_subscriptions').is(':checked')) {
                            d.only_subscriptions = 1;
                        }

                        if ($('#payment_method').length) {
                            d.payment_method = $('#payment_method').val();
                        }

                        d = __datatable_ajax_callback(d);
                    }
                },
                scrollY: "75vh",
                scrollX: false,
                scrollCollapse: true,
                autoWidth: false,
                columns: [{
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'conatct_name',
                        name: 'conatct_name'
                    },
                    {
                        data: 'business_location',
                        name: 'bl.name'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'payment_methods',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'final_total',
                        name: 'final_total'
                    },
                    {
                        data: 'total_paid',
                        name: 'total_paid',
                        "searchable": false
                    },
                    {
                        data: 'total_remaining',
                        name: 'total_remaining'
                    },
                    {
                        data: 'total_items',
                        name: 'total_items',
                        "searchable": false
                    },
                    {
                        data: 'added_by',
                        name: 'u.first_name'
                    },
                    {
                        data: 'additional_notes',
                        name: 'additional_notes'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        "searchable": false
                    },
                ],
                "fnDrawCallback": function(oSettings) {
                    __currency_convert_recursively($('#sell_table'));
                },
                "footerCallback": function(row, data, start, end, display) {
                    var footer_sale_total = 0;
                    var footer_total_paid = 0;
                    var footer_total_remaining = 0;
                    for (var r in data) {
                        footer_sale_total += $(data[r].final_total).data('orig-value') ? parseFloat($(
                            data[r].final_total).data('orig-value')) : 0;
                        footer_total_paid += $(data[r].total_paid).data('orig-value') ? parseFloat($(
                            data[r].total_paid).data('orig-value')) : 0;
                        footer_total_remaining += $(data[r].total_remaining).data('orig-value') ?
                            parseFloat($(data[r].total_remaining).data('orig-value')) : 0;
                    }
                    $('.footer_total_remaining').html(__currency_trans_from_en(footer_total_remaining));
                    $('.footer_total_paid').html(__currency_trans_from_en(footer_total_paid));
                    $('.footer_sale_total').html(__currency_trans_from_en(footer_sale_total));

                    $('.footer_payment_status_count').html(__count_status(data, 'payment_status'));
                    $('.payment_method_count').html(__count_status(data, 'payment_methods'));
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(4)').attr('class', 'clickable_td');
                }
            });

            function moveSalesExportButtons() {
                var $buttons = $('#sell_table_wrapper .dt-buttons');
                if ($buttons.length && $('#vp-sales-export-actions').length) {
                    $('#vp-sales-export-actions').empty().append($buttons);
                }
            }

            function moveSalesTopActions() {
                var $header = $('.vp-sales-content .box-header');
                if (!$header.length) {
                    return;
                }

                var $actionWrap = $header.find('.vp-sales-top-actions');
                if (!$actionWrap.length) {
                    $actionWrap = $('<div class="vp-sales-top-actions"></div>');
                    $header.append($actionWrap);
                }

                var $length = $('#sell_table_wrapper .dataTables_length');
                var $filter = $('#sell_table_wrapper .dataTables_filter');
                var $addBtnWrap = $header.find('.box-tools');

                if ($length.length && !$actionWrap.find('.dataTables_length').length) {
                    $actionWrap.append($length);
                }
                if ($filter.length && !$actionWrap.find('.dataTables_filter').length) {
                    $actionWrap.append($filter);
                }
                if ($addBtnWrap.length && !$actionWrap.find('.box-tools').length) {
                    $actionWrap.append($addBtnWrap);
                }
            }

            setTimeout(function() {
                moveSalesTopActions();
                moveSalesExportButtons();
            }, 400);
            $('#sell_table').on('draw.dt', moveSalesExportButtons);
            $('#sell_table').on('draw.dt', moveSalesTopActions);

            $(document).on('change',
                '#sell_list_filter_location_id, #sell_list_filter_customer_id, #sell_list_filter_payment_status, #created_by, #sales_cmsn_agnt, #service_staffs, #shipping_status, #sell_list_filter_source, #payment_method',
                function() {
                    sell_table.ajax.reload();
                });

            $('#vp-apply-sales-filter').on('click', function() {
                sell_table.ajax.reload();
            });

            $('#only_subscriptions').on('ifChanged', function(event) {
                sell_table.ajax.reload();
            });
        });
    </script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection
