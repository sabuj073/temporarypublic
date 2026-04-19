@extends('layouts.app')
@section('title', __('report.profit_loss'))

@section('css')
    @include('report.partials.vendo_profit_loss_page_styles')
@endsection

@section('content')
    <div class="print_section">
        <h2>{{ session()->get('business.name') }} - @lang('report.profit_loss')</h2>
    </div>

    <div class="vp-profit-loss-page-wrap no-print">
        <div class="vp-profit-loss-shell">
            <div class="vp-profit-loss-page-head">
                <button type="button" class="vp-profit-loss-back" id="vp_profit_loss_back_btn"
                    title="{{ __('messages.go_back') }}" aria-label="{{ __('messages.go_back') }}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <h1 class="vp-profit-loss-page-title">@lang('report.profit_loss')</h1>
            </div>

            <div class="vp-profit-loss-card">
                <div class="vp-profit-loss-toolbar">
                    <div class="vp-profit-loss-toolbar-main">
                        <div class="vp-profit-loss-filter-field">
                            <label for="profit_loss_date_filter">@lang('report.date_range')</label>
                            <button type="button" class="vp-profit-loss-date-btn" id="profit_loss_date_filter">
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i> {{ __('messages.filter_by_date') }}
                                </span>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="vp-profit-loss-filter-field">
                            <label for="profit_loss_location_filter">@lang('business.location')</label>
                            <select class="form-control select2" id="profit_loss_location_filter" style="width:100%">
                                @foreach ($business_locations as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="vp-profit-loss-filter-field" style="flex: 2 1 240px;">
                            <label class="tw-sr-only">AI</label>
                            <div id="ai-analysis-container" class="ai-analysis-content"></div>
                        </div>
                    </div>
                    <button type="button" class="vp-profit-loss-print-btn" aria-label="@lang('messages.print')"
                        onclick="window.print();">
                        <i class="fa fa-print" aria-hidden="true"></i>
                        @lang('messages.print')
                    </button>
                </div>

                <div class="vp-profit-loss-pl-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="pl_data_div"></div>
                        </div>
                    </div>
                </div>

                <div class="vp-profit-loss-tabs-wrap">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs vp-pl-nav-tabs">
                        <li class="active">
                            <a href="#profit_by_products" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_products')</a>
                        </li>

                        <li>
                            <a href="#profit_by_categories" data-toggle="tab" aria-expanded="true"><i class="fa fa-tags"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_categories')</a>
                        </li>

                        <li>
                            <a href="#profit_by_brands" data-toggle="tab" aria-expanded="true"><i class="fa fa-diamond"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_brands')</a>
                        </li>

                        <li>
                            <a href="#profit_by_locations" data-toggle="tab" aria-expanded="true"><i
                                    class="fa fa-map-marker" aria-hidden="true"></i> @lang('lang_v1.profit_by_locations')</a>
                        </li>

                        <li>
                            <a href="#profit_by_invoice" data-toggle="tab" aria-expanded="true"><i class="fa fa-file-alt"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_invoice')</a>
                        </li>

                        <li>
                            <a href="#profit_by_date" data-toggle="tab" aria-expanded="true"><i class="fa fa-calendar"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_date')</a>
                        </li>
                        <li>
                            <a href="#profit_by_customer" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_customer')</a>
                        </li>
                        <li>
                            <a href="#profit_by_day" data-toggle="tab" aria-expanded="true"><i class="fa fa-calendar"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_day')</a>
                        </li>
                        <li>
                            <a href="#profit_by_service_staff" data-toggle="tab" aria-expanded="true"><i class="fa fa-user-secret"
                                    aria-hidden="true"></i> @lang('lang_v1.profit_by_service_staff')</a>
                        </li>
                    </ul>

                    <div class="tab-content vp-pl-tab-content">
                        <div class="tab-pane active" id="profit_by_products">
                            @include('report.partials.profit_by_products')
                        </div>

                        <div class="tab-pane" id="profit_by_categories">
                            @include('report.partials.profit_by_categories')
                        </div>

                        <div class="tab-pane" id="profit_by_brands">
                            @include('report.partials.profit_by_brands')
                        </div>

                        <div class="tab-pane" id="profit_by_locations">
                            @include('report.partials.profit_by_locations')
                        </div>

                        <div class="tab-pane" id="profit_by_invoice">
                            @include('report.partials.profit_by_invoice')
                        </div>

                        <div class="tab-pane" id="profit_by_date">
                            @include('report.partials.profit_by_date')
                        </div>

                        <div class="tab-pane" id="profit_by_customer">
                            @include('report.partials.profit_by_customer')
                        </div>
                        <div class="tab-pane" id="profit_by_service_staff">
                            @include('report.partials.profit_by_service_staff')
                        </div>

                        <div class="tab-pane" id="profit_by_day">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script>
        window.vpPlMoveDtControls = function(tableNode) {
            var $table = $(tableNode);
            if (!$table.length || !$('.vp-profit-loss-page-wrap').length) {
                return;
            }
            var $w = $table.closest('.dataTables_wrapper');
            if (!$w.length) {
                return;
            }
            var $pane = $table.closest('.tab-pane');
            var $fSlot = $pane.find('.vp-pl-filter-slot').first();
            if (!$fSlot.length) {
                return;
            }
            $w.find('.dataTables_filter').appendTo($fSlot);
            $w.find('.dataTables_length').appendTo($pane.find('.vp-pl-length-slot').first());
            $w.find('.dataTables_info').appendTo($pane.find('.vp-pl-info-slot').first());
            $w.find('.dataTables_paginate').appendTo($pane.find('.vp-pl-paginate-slot').first());
            $w.find('.row.margin-bottom-20').first().hide();
        };
    </script>
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#vp_profit_loss_back_btn').on('click', function() {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.assign('{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}');
                }
            });

            profit_by_products_table = $('#profit_by_products_table').DataTable({
                processing: true,
                serverSide: true,
                fixedHeader:false,
                initComplete: function() {
                    if (typeof window.vpPlMoveDtControls === 'function') {
                        window.vpPlMoveDtControls($(this.api().table().node()));
                    }
                },
                fnDrawCallback: function() {
                    if (typeof window.vpPlMoveDtControls === 'function') {
                        window.vpPlMoveDtControls($(this.api().table().node()));
                    }
                },
                "ajax": {
                    "url": "/reports/get-profit/product",
                    "data": function(d) {
                        d.start_date = $('#profit_loss_date_filter')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        d.end_date = $('#profit_loss_date_filter')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                        d.location_id = $('#profit_loss_location_filter').val();
                    }
                },
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'gross_profit',
                        "searchable": false
                    },
                ],
                footerCallback: function(row, data, start, end, display) {
                    var total_profit = 0;
                    for (var r in data) {
                        total_profit += $(data[r].gross_profit).data('orig-value') ?
                            parseFloat($(data[r].gross_profit).data('orig-value')) : 0;
                    }

                    $('#profit_by_products_table .footer_total').html(__currency_trans_from_en(
                        total_profit));
                }
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr('href');
                if (target == '#profit_by_categories') {
                    if (typeof profit_by_categories_datatable == 'undefined') {
                        profit_by_categories_datatable = $('#profit_by_categories_table').DataTable({
                            processing: true,
                            serverSide: true,
                            fixedHeader:false,
                            initComplete: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            fnDrawCallback: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            "ajax": {
                                "url": "/reports/get-profit/category",
                                "data": function(d) {
                                    d.start_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.end_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                    d.location_id = $('#profit_loss_location_filter').val();
                                }
                            },
                            columns: [{
                                    data: 'category',
                                    name: 'C.name'
                                },
                                {
                                    data: 'gross_profit',
                                    "searchable": false
                                },
                            ],
                            footerCallback: function(row, data, start, end, display) {
                                var total_profit = 0;
                                for (var r in data) {
                                    total_profit += $(data[r].gross_profit).data('orig-value') ?
                                        parseFloat($(data[r].gross_profit).data('orig-value')) :
                                        0;
                                }

                                $('#profit_by_categories_table .footer_total').html(
                                    __currency_trans_from_en(total_profit));
                            },
                        });
                    } else {
                        profit_by_categories_datatable.ajax.reload();
                    }
                } else if (target == '#profit_by_brands') {
                    if (typeof profit_by_brands_datatable == 'undefined') {
                        profit_by_brands_datatable = $('#profit_by_brands_table').DataTable({
                            processing: true,
                            serverSide: true,
                            fixedHeader:false,
                            initComplete: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            fnDrawCallback: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            "ajax": {
                                "url": "/reports/get-profit/brand",
                                "data": function(d) {
                                    d.start_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.end_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                    d.location_id = $('#profit_loss_location_filter').val();
                                }
                            },
                            columns: [{
                                    data: 'brand',
                                    name: 'B.name'
                                },
                                {
                                    data: 'gross_profit',
                                    "searchable": false
                                },
                            ],
                            footerCallback: function(row, data, start, end, display) {
                                var total_profit = 0;
                                for (var r in data) {
                                    total_profit += $(data[r].gross_profit).data('orig-value') ?
                                        parseFloat($(data[r].gross_profit).data('orig-value')) :
                                        0;
                                }

                                $('#profit_by_brands_table .footer_total').html(
                                    __currency_trans_from_en(total_profit));
                            },
                        });
                    } else {
                        profit_by_brands_datatable.ajax.reload();
                    }
                } else if (target == '#profit_by_locations') {
                    if (typeof profit_by_locations_datatable == 'undefined') {
                        profit_by_locations_datatable = $('#profit_by_locations_table').DataTable({
                            processing: true,
                            serverSide: true,
                            fixedHeader:false,
                            initComplete: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            fnDrawCallback: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            "ajax": {
                                "url": "/reports/get-profit/location",
                                "data": function(d) {
                                    d.start_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.end_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                    d.location_id = $('#profit_loss_location_filter').val();
                                }
                            },
                            columns: [{
                                    data: 'location',
                                    name: 'L.name'
                                },
                                {
                                    data: 'gross_profit',
                                    "searchable": false
                                },
                            ],
                            footerCallback: function(row, data, start, end, display) {
                                var total_profit = 0;
                                for (var r in data) {
                                    total_profit += $(data[r].gross_profit).data('orig-value') ?
                                        parseFloat($(data[r].gross_profit).data('orig-value')) :
                                        0;
                                }

                                $('#profit_by_locations_table .footer_total').html(
                                    __currency_trans_from_en(total_profit));
                            },
                        });
                    } else {
                        profit_by_locations_datatable.ajax.reload();
                    }
                } else if (target == '#profit_by_invoice') {
                    if (typeof profit_by_invoice_datatable == 'undefined') {
                        profit_by_invoice_datatable = $('#profit_by_invoice_table').DataTable({
                            processing: true,
                            serverSide: true,
                            fixedHeader:false,
                            initComplete: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            fnDrawCallback: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            "ajax": {
                                "url": "/reports/get-profit/invoice",
                                "data": function(d) {
                                    d.start_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.end_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                    d.location_id = $('#profit_loss_location_filter').val();
                                }
                            },
                            columns: [{
                                    data: 'invoice_no',
                                    name: 'sale.invoice_no'
                                },
                                {
                                    data: 'gross_profit',
                                    "searchable": false
                                },
                            ],
                            footerCallback: function(row, data, start, end, display) {
                                var total_profit = 0;
                                for (var r in data) {
                                    total_profit += $(data[r].gross_profit).data('orig-value') ?
                                        parseFloat($(data[r].gross_profit).data('orig-value')) :
                                        0;
                                }

                                $('#profit_by_invoice_table .footer_total').html(
                                    __currency_trans_from_en(total_profit));
                            },
                        });
                    } else {
                        profit_by_invoice_datatable.ajax.reload();
                    }
                } else if (target == '#profit_by_date') {
                    if (typeof profit_by_date_datatable == 'undefined') {
                        profit_by_date_datatable = $('#profit_by_date_table').DataTable({
                            processing: true,
                            serverSide: true,
                            fixedHeader:false,
                            initComplete: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            fnDrawCallback: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            "ajax": {
                                "url": "/reports/get-profit/date",
                                "data": function(d) {
                                    d.start_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.end_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                    d.location_id = $('#profit_loss_location_filter').val();
                                }
                            },
                            columns: [{
                                    data: 'transaction_date',
                                    name: 'sale.transaction_date'
                                },
                                {
                                    data: 'gross_profit',
                                    "searchable": false
                                },
                            ],
                            footerCallback: function(row, data, start, end, display) {
                                var total_profit = 0;
                                for (var r in data) {
                                    total_profit += $(data[r].gross_profit).data('orig-value') ?
                                        parseFloat($(data[r].gross_profit).data('orig-value')) :
                                        0;
                                }

                                $('#profit_by_date_table .footer_total').html(
                                    __currency_trans_from_en(total_profit));
                            },
                        });
                    } else {
                        profit_by_date_datatable.ajax.reload();
                    }
                } else if (target == '#profit_by_customer') {
                    if (typeof profit_by_customers_table == 'undefined') {
                        profit_by_customers_table = $('#profit_by_customer_table').DataTable({
                            processing: true,
                            serverSide: true,
                            fixedHeader:false,
                            initComplete: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            fnDrawCallback: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            "ajax": {
                                "url": "/reports/get-profit/customer",
                                "data": function(d) {
                                    d.start_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.end_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                    d.location_id = $('#profit_loss_location_filter').val();
                                }
                            },
                            columns: [{
                                    data: 'customer',
                                    name: 'CU.name'
                                },
                                {
                                    data: 'gross_profit',
                                    "searchable": false
                                },
                            ],
                            footerCallback: function(row, data, start, end, display) {
                                var total_profit = 0;
                                for (var r in data) {
                                    total_profit += $(data[r].gross_profit).data('orig-value') ?
                                        parseFloat($(data[r].gross_profit).data('orig-value')) :
                                        0;
                                }

                                $('#profit_by_customer_table .footer_total').html(
                                    __currency_trans_from_en(total_profit));
                            },
                        });
                    } else {
                        profit_by_customers_table.ajax.reload();
                    }
                } else if (target == '#profit_by_service_staff') {
                    if (typeof profit_by_service_staffs_table == 'undefined') {
                        
                        profit_by_service_staffs_table = $('#profit_by_service_staff_table').DataTable({
                            processing: true,
                            serverSide: true,
                            fixedHeader:false,
                            initComplete: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            fnDrawCallback: function() {
                                if (typeof window.vpPlMoveDtControls === 'function') {
                                    window.vpPlMoveDtControls($(this.api().table().node()));
                                }
                            },
                            "ajax": {
                                "url": "/reports/get-profit/service_staff",
                                "data": function(d) {
                                    d.start_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.end_date = $('#profit_loss_date_filter')
                                        .data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                    d.location_id = $('#profit_loss_location_filter').val();
                                }
                            },
                            columns: [{
                                    data: 'staff_name',
                                    name: 'U.first_name'
                                },
                                {
                                    data: 'gross_profit',
                                    "searchable": false
                                },
                            ],
                            footerCallback: function(row, data, start, end, display) {
                                var total_profit = 0;
                                for (var r in data) {
                                    total_profit += $(data[r].gross_profit).data('orig-value') ?
                                        parseFloat($(data[r].gross_profit).data('orig-value')) :
                                        0;
                                }

                                $('#profit_by_service_staff_table .footer_total').html(
                                    __currency_trans_from_en(total_profit));
                            },
                        });
                    } else {
                        profit_by_service_staffs_table.ajax.reload();
                    }
                } else if (target == '#profit_by_day') {
                    var start_date = $('#profit_loss_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');

                    var end_date = $('#profit_loss_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                    var location_id = $('#profit_loss_location_filter').val();

                    var url = '/reports/get-profit/day?start_date=' + start_date + '&end_date=' + end_date +
                        '&location_id=' + location_id;
                    $.ajax({
                        url: url,
                        dataType: 'html',
                        success: function(result) {
                            $('#profit_by_day').html(result);
                            profit_by_days_table = $('#profit_by_day_table').DataTable({
                                "searching": false,
                                'paging': false,
                                'ordering': false,
                                initComplete: function() {
                                    if (typeof window.vpPlMoveDtControls === 'function') {
                                        window.vpPlMoveDtControls($(this.api().table().node()));
                                    }
                                },
                                fnDrawCallback: function() {
                                    if (typeof window.vpPlMoveDtControls === 'function') {
                                        window.vpPlMoveDtControls($(this.api().table().node()));
                                    }
                                },
                            });
                            var total_profit = sum_table_col($('#profit_by_day_table'),
                                'gross-profit');
                            $('#profit_by_day_table .footer_total').text(total_profit);
                            __currency_convert_recursively($('#profit_by_day_table'));
                        },
                    });
                } else if (target == '#profit_by_products') {
                    profit_by_products_table.ajax.reload();
                }
                setTimeout(function() {
                    if (typeof window.vpPlMoveDtControls !== 'function') {
                        return;
                    }
                    var $pane = $(target);
                    if ($pane.length) {
                        var $t = $pane.find('table[id]').first();
                        if ($t.length) {
                            window.vpPlMoveDtControls($t.get(0));
                        }
                    }
                }, 120);
                $("a.btn").removeClass("btn btn-default buttons-excel buttons-html5");
            });
        });
    </script>

@endsection
