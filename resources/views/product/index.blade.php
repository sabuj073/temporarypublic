@extends('layouts.app')
@section('title', __('sale.products'))

@section('content')
    <div class="vp-products-page-wrap">
        <!-- Content Header (Page header) -->
        <section class="content-header vp-products-header">
            <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold">
                <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-products-back-btn" aria-label="Back to home">
                    <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="Back">
                </a>
                @lang('sale.products')
            </h1>
        </section>

        <!-- Main content -->
        <section class="content vp-products-content">
        <div class="row">
            <div class="col-md-12">
                <div class="vp-products-filter-card">
                    <div class="vp-products-filter-row">
                        <div class="vp-filter-field">
                            {!! Form::label('type', __('product.product_type')) !!}
                            {!! Form::select(
                                'type',
                                ['single' => __('lang_v1.single'), 'variable' => __('lang_v1.variable'), 'combo' => __('lang_v1.combo')],
                                null,
                                [
                                    'class' => 'form-control select2',
                                    'style' => 'width:100%',
                                    'id' => 'product_list_filter_type',
                                    'placeholder' => __('lang_v1.all'),
                                ],
                            ) !!}
                        </div>
                        <div class="vp-filter-field">
                            {!! Form::label('category_id', __('product.category')) !!}
                            {!! Form::select('category_id', $categories, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'product_list_filter_category_id',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-filter-field">
                            {!! Form::label('unit_id', __('product.unit')) !!}
                            {!! Form::select('unit_id', $units, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'product_list_filter_unit_id',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-filter-field">
                            {!! Form::label('tax_id', __('product.tax')) !!}
                            {!! Form::select('tax_id', $taxes, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'product_list_filter_tax_id',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-filter-field">
                            {!! Form::label('brand_id', __('product.brand')) !!}
                            {!! Form::select('brand_id', $brands, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'product_list_filter_brand_id',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-filter-field" id="location_filter">
                            {!! Form::label('location_id', __('purchase.business_location')) !!}
                            {!! Form::select('location_id', $business_locations, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                        <div class="vp-filter-field">
                            {!! Form::label('active_state', __('sale.status')) !!}
                            {!! Form::select(
                                'active_state',
                                ['active' => __('business.is_active'), 'inactive' => __('lang_v1.inactive')],
                                null,
                                [
                                    'class' => 'form-control select2',
                                    'style' => 'width:100%',
                                    'id' => 'active_state',
                                    'placeholder' => __('lang_v1.all'),
                                ],
                            ) !!}
                        </div>
                        <div class="vp-filter-check-field">
                            <label>
                                {!! Form::checkbox('not_for_selling', 1, false, ['class' => 'input-icheck', 'id' => 'not_for_selling']) !!}
                                <span>@lang('lang_v1.not_for_selling')</span>
                            </label>
                        </div>
                        <div class="vp-filter-action">
                            <button type="button" id="vp-apply-products-filter" class="btn vp-apply-btn">
                                Apply <i class="fa fa-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('product.view')
            <div class="row">
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#product_list_tab" data-toggle="tab" aria-expanded="true">@lang('lang_v1.all_products')</a>
                            </li>
                            @can('stock_report.view')
                                <li>
                                    <a href="#product_stock_report" class="product_stock_report" data-toggle="tab"
                                        aria-expanded="true">@lang('report.stock_report')</a>
                                </li>
                            @endcan
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active " id="product_list_tab">
                                @if ($is_admin)

                                    <a class="tw-dw-btn vp-product-download-btn pull-right tw-m-2"
                                        href="{{ action([\App\Http\Controllers\ProductController::class, 'downloadExcel']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg> @lang('lang_v1.download_excel')
                                    </a>
                                @endif
                                @can('product.create')

                                    <a class="tw-dw-btn vp-product-add-btn pull-right tw-m-2"
                                        href="{{ action([\App\Http\Controllers\ProductController::class, 'create']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg> @lang('messages.add')
                                    </a>
                                @endcan
                                <div id="vp-product-top-actions" class="vp-product-top-actions">
                                    <div class="vp-product-top-actions-left"></div>
                                    <div class="vp-product-top-actions-right"></div>
                                </div>
                                @include('product.partials.product_list')
                                <div id="vp-product-export-actions" class="vp-product-export-actions"></div>
                            </div>
                            @can('stock_report.view')
                                <div class="tab-pane" id="product_stock_report">
                                    @include('report.partials.stock_report_table')
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        <input type="hidden" id="is_rack_enabled" value="{{ $rack_enabled }}">

        <div class="modal fade product_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

        <div class="modal fade" id="view_product_modal" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel">
        </div>

        <div class="modal fade" id="opening_stock_modal" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel">
        </div>

        @if ($is_woocommerce)
            @include('product.partials.toggle_woocommerce_sync_modal')
        @endif
        @include('product.partials.edit_product_location_modal')

    </section>
    <!-- /.content -->
    </div>

@endsection

@section('css')
    <style>
        .vp-products-page-wrap {
            margin: 22px 26px 28px;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
        }

        .vp-products-header {
            margin: 0 0 10px !important;
        }

        .vp-products-header h1 {
            color: #fff !important;
            font-size: 34px !important;
            font-weight: 700 !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .vp-products-back-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(18, 29, 64, 0.18);
            flex-shrink: 0;
        }

        .vp-products-back-btn img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }

        .vp-products-filter-card,
        .vp-products-content .nav-tabs-custom {
            background: #fff;
            border-radius: 12px;
            border: none !important;
            box-shadow: none !important;
            overflow: hidden;
        }

        .vp-products-filter-card {
            padding: 12px;
            margin-bottom: 0;
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid #e3e7f3;
        }

        .vp-products-content .nav-tabs-custom {
            border-radius: 0 0 12px 12px;
            margin-top: 0 !important;
            overflow: visible !important;
        }

        .vp-products-filter-row {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            flex-wrap: wrap;
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

        .vp-filter-check-field {
            min-width: 140px;
            padding-bottom: 8px;
        }

        .vp-filter-check-field label {
            margin: 0;
            font-size: 14px;
            color: #2b356d;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .vp-filter-action {
            width: 120px;
        }

        .vp-apply-btn {
            width: 100%;
            height: 34px;
            border: none !important;
            border-radius: 6px !important;
            background: #27306f !important;
            color: #fff !important;
            font-weight: 600;
            font-size: 13px;
        }

        .vp-products-content .nav-tabs {
            border-bottom: none !important;
            padding: 12px 12px 0;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vp-products-content .nav-tabs > li > a {
            color: #2d366d !important;
            font-size: 16px;
            font-weight: 700;
            border: 1px solid #cfd5e6 !important;
            border-radius: 8px !important;
            padding: 8px 22px;
            line-height: 1.2;
            margin: 0 !important;
            background: #fff;
        }

        .vp-products-content .nav-tabs > li.active > a,
        .vp-products-content .nav-tabs > li > a:hover {
            background: #27306f !important;
            color: #fff !important;
            border-color: #27306f !important;
        }

        .vp-products-content .nav-tabs > li.active > a {
            box-shadow: none !important;
        }

        .vp-products-content .nav-tabs-custom > .nav-tabs > li.active {
            border-top-color: transparent !important;
        }

        .vp-products-content .nav > li > a:focus {
            background: #27306f !important;
            color: #fff !important;
            border-color: #27306f !important;
        }

        .vp-products-content .tab-content {
            padding: 10px 12px 14px;
            background: #fff;
        }

        .vp-product-add-btn {
            min-width: 108px;
            height: 34px;
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
            padding: 0 12px !important;
        }

        .vp-product-download-btn {
            min-width: 138px;
            height: 34px;
            border-radius: 6px !important;
            border: none !important;
            background: #3ba55c !important;
            color: #fff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 12px !important;
        }

        .vp-product-top-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 8px 0 10px;
            flex-wrap: wrap;
        }

        .vp-product-top-actions-left,
        .vp-product-top-actions-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vp-product-top-actions-right {
            justify-content: flex-end;
        }

        .vp-product-top-actions .vp-product-add-btn,
        .vp-product-top-actions .vp-product-download-btn {
            margin: 0 !important;
            float: none !important;
        }

        .vp-product-top-actions .dataTables_length,
        .vp-product-top-actions .dataTables_filter {
            margin: 0 !important;
            float: none !important;
        }

        .vp-product-top-actions .dataTables_length label,
        .vp-product-top-actions .dataTables_filter label {
            margin: 0 !important;
            font-size: 13px;
            font-weight: 600;
            color: #2a336e;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .vp-product-top-actions .dataTables_filter input,
        .vp-product-top-actions .dataTables_length select {
            height: 34px !important;
            border: 1px solid #cfd5ea !important;
            border-radius: 6px !important;
            padding: 6px 10px !important;
            font-size: 13px !important;
            color: #2f3970;
        }

        .vp-products-content #product_table {
            width: 100% !important;
        }

        .vp-products-content #product_table th.vp-product-image-col,
        .vp-products-content #product_table td:nth-child(2) {
            width: 72px !important;
            min-width: 72px !important;
            max-width: 72px !important;
            text-align: center;
            white-space: nowrap;
        }

        .vp-products-content #product_table td:nth-child(2) img {
            max-width: 44px !important;
            max-height: 44px !important;
            width: 44px !important;
            height: 44px !important;
            object-fit: contain;
            margin: 0 auto;
            display: block;
        }

        .vp-products-content #product_table_wrapper,
        .vp-products-content .dataTables_scroll,
        .vp-products-content .dataTables_scrollHead,
        .vp-products-content .dataTables_scrollBody,
        .vp-products-content .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        .vp-products-content #product_table .dropdown-menu {
            z-index: 1051;
        }

        .vp-products-content table.dataTable thead th {
            color: #303a73 !important;
            background: #fbfbff;
            border-bottom: 1px solid #e3e6f3 !important;
            font-weight: 700;
            font-size: 12px;
        }

        .vp-products-content table.dataTable tbody td {
            font-size: 12px;
            color: #2f3a67;
        }

        .vp-products-content #product_table .btn-group .btn,
        .vp-products-content #product_table .btn,
        .vp-products-content #product_table .dropdown-toggle {
            background: #27306f !important;
            border-color: #27306f !important;
            color: #fff !important;
        }

        .vp-products-content #product_table .btn-group .btn:hover,
        .vp-products-content #product_table .btn:hover,
        .vp-products-content #product_table .dropdown-toggle:hover {
            background: #1f275f !important;
            border-color: #1f275f !important;
        }

        .vp-products-content .vp-product-bulk-actions {
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 12px 8px;
        }

        .vp-products-content .vp-product-bulk-actions form {
            margin: 0 !important;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn {
            min-width: 142px;
            height: 34px;
            border-radius: 4px !important;
            border: none !important;
            color: #fff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            text-transform: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px !important;
            transition: opacity 0.15s ease;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn:hover,
        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn:focus {
            color: #fff !important;
            opacity: 0.92;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn-delete {
            background: #cf0a0a !important;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn-add-location {
            background: #262f74 !important;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn-remove-location {
            background: #e8e8e8 !important;
            color: #2a2a2a !important;
            border: 1px solid #d9d9d9 !important;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn-remove-location:hover,
        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn-remove-location:focus {
            color: #2a2a2a !important;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn-activate {
            background: #2ea043 !important;
        }

        .vp-products-content .vp-product-bulk-actions .vp-bulk-btn-deactivate {
            background: #e8a10a !important;
        }

        .vp-products-content .dt-buttons {
            display: inline-flex;
            gap: 8px;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #cdd4e8;
            box-shadow: 0 4px 12px rgba(21, 31, 66, 0.15);
        }

        .vp-products-content .dt-buttons .dt-button {
            background: #27306f !important;
            color: #fff !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 7px 12px !important;
            font-size: 13px !important;
        }

        .vp-product-export-actions {
            margin-top: 14px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 991px) {
            .vp-products-page-wrap {
                margin: 14px 12px 16px;
                padding: 14px;
            }

            .vp-products-header h1 {
                font-size: 26px !important;
            }

            .vp-products-content .nav-tabs > li > a {
                font-size: 15px;
                padding: 8px 14px;
            }

            .vp-product-top-actions {
                flex-wrap: wrap;
                justify-content: flex-start;
            }

            .vp-product-top-actions-left,
            .vp-product-top-actions-right {
                width: 100%;
            }

            .vp-product-top-actions-right {
                justify-content: flex-start;
            }

            .vp-products-content .vp-product-bulk-actions {
                justify-content: center;
                gap: 8px;
            }

            .vp-products-content .vp-product-bulk-actions .vp-bulk-btn {
                min-width: 130px;
                font-size: 12px !important;
                padding: 0 12px !important;
            }
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                fixedHeader:false,
                aaSorting: [
                    [2, 'asc']
                ],
                scrollY: "75vh",
                scrollX: false,
                scrollCollapse: true,
                autoWidth: false,
                "ajax": {
                    "url": "/products",
                    "data": function(d) {
                        d.type = $('#product_list_filter_type').val();
                        d.category_id = $('#product_list_filter_category_id').val();
                        d.brand_id = $('#product_list_filter_brand_id').val();
                        d.unit_id = $('#product_list_filter_unit_id').val();
                        d.tax_id = $('#product_list_filter_tax_id').val();
                        d.active_state = $('#active_state').val();
                        d.not_for_selling = $('#not_for_selling').is(':checked');
                        d.location_id = $('#location_id').val();
                        if ($('#repair_model_id').length == 1) {
                            d.repair_model_id = $('#repair_model_id').val();
                        }

                        if ($('#woocommerce_enabled').length == 1 && $('#woocommerce_enabled').is(
                                ':checked')) {
                            d.woocommerce_enabled = 1;
                        }

                        d = __datatable_ajax_callback(d);
                    }
                },
                columnDefs: [{
                    "targets": [0, 1],
                    "orderable": false,
                    "searchable": false
                }, {
                    "targets": [0],
                    "width": "34px"
                }, {
                    "targets": [1],
                    "width": "72px"
                }],
                columns: [{
                        data: 'mass_delete'
                    },
                    {
                        data: 'image',
                        name: 'products.image'
                    },
                    {
                        data: 'product',
                        name: 'products.name'
                    },
                    {
                        data: 'product_locations',
                        name: 'product_locations'
                    },
                    @can('view_purchase_price')
                        {
                            data: 'purchase_price',
                            name: 'max_purchase_price',
                            searchable: false
                        },
                    @endcan
                    @can('access_default_selling_price')
                        {
                            data: 'selling_price',
                            name: 'max_price',
                            searchable: false
                        },
                    @endcan {
                        data: 'current_stock',
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'products.type'
                    },
                    {
                        data: 'category',
                        name: 'c1.name'
                    },
                    {
                        data: 'brand',
                        name: 'brands.name'
                    },
                    {
                        data: 'tax',
                        name: 'tax_rates.name',
                        searchable: false
                    },
                    {
                        data: 'sku',
                        name: 'products.sku'
                    },
                    {
                        data: 'product_custom_field1',
                        name: 'products.product_custom_field1',
                        visible: $('#cf_1').text().length > 0
                    },
                    {
                        data: 'product_custom_field2',
                        name: 'products.product_custom_field2',
                        visible: $('#cf_2').text().length > 0
                    },
                    {
                        data: 'product_custom_field3',
                        name: 'products.product_custom_field3',
                        visible: $('#cf_3').text().length > 0
                    },
                    {
                        data: 'product_custom_field4',
                        name: 'products.product_custom_field4',
                        visible: $('#cf_4').text().length > 0
                    },
                    {
                        data: 'product_custom_field5',
                        name: 'products.product_custom_field5',
                        visible: $('#cf_5').text().length > 0
                    },
                    {
                        data: 'product_custom_field6',
                        name: 'products.product_custom_field6',
                        visible: $('#cf_6').text().length > 0
                    },
                    {
                        data: 'product_custom_field7',
                        name: 'products.product_custom_field7',
                        visible: $('#cf_7').text().length > 0
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    if ($('input#is_rack_enabled').val() == 1) {
                        var target_col = 0;
                        @can('product.delete')
                            target_col = 1;
                        @endcan
                        $(row).find('td:eq(' + target_col + ') div').prepend(
                            '<i style="margin:auto;" class="fa fa-plus-circle text-success cursor-pointer no-print rack-details" title="' +
                            LANG.details + '"></i>&nbsp;&nbsp;');
                    }
                    $(row).find('td:eq(0)').attr('class', 'selectable_td');
                },
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#product_table'));
                },
            });

            function moveProductTopActions() {
                var $topWrap = $('#vp-product-top-actions');
                if (!$topWrap.length) {
                    return;
                }
                var $left = $topWrap.find('.vp-product-top-actions-left');
                var $right = $topWrap.find('.vp-product-top-actions-right');
                if (!$left.length || !$right.length) {
                    return;
                }
                var $length = $('#product_table_wrapper .dataTables_length');
                var $filter = $('#product_table_wrapper .dataTables_filter');
                var $addBtn = $('.vp-products-content .vp-product-add-btn').first();
                var $downloadBtn = $('.vp-products-content .vp-product-download-btn').first();

                if ($filter.length && !$left.find('.dataTables_filter').length) {
                    $left.append($filter);
                }
                if ($length.length && !$right.find('.dataTables_length').length) {
                    $right.append($length);
                }
                if ($addBtn.length && !$right.find('.vp-product-add-btn').length) {
                    $right.append($addBtn);
                }
                if ($downloadBtn.length && !$right.find('.vp-product-download-btn').length) {
                    $right.append($downloadBtn);
                }
            }

            function moveProductExportButtons() {
                var $buttons = $('#product_table_wrapper .dt-buttons');
                if ($buttons.length && $('#vp-product-export-actions').length) {
                    $('#vp-product-export-actions').empty().append($buttons);
                }
            }

            setTimeout(function() {
                moveProductTopActions();
                moveProductExportButtons();
            }, 400);
            $('#product_table').on('draw.dt', moveProductTopActions);
            $('#product_table').on('draw.dt', moveProductExportButtons);
            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#product_table tbody').on('click', 'tr i.rack-details', function() {
                var i = $(this);
                var tr = $(this).closest('tr');
                var row = product_table.row(tr);
                var idx = $.inArray(tr.attr('id'), detailRows);

                if (row.child.isShown()) {
                    i.addClass('fa-plus-circle text-success');
                    i.removeClass('fa-minus-circle text-danger');

                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                } else {
                    i.removeClass('fa-plus-circle text-success');
                    i.addClass('fa-minus-circle text-danger');

                    row.child(get_product_details(row.data())).show();

                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.attr('id'));
                    }
                }
            });

            $('#opening_stock_modal').on('hidden.bs.modal', function(e) {
                product_table.ajax.reload();
            });

            $('table#product_table tbody').on('click', 'a.delete-product', function(e) {
                e.preventDefault();
                swal({
                    title: LANG.sure,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    product_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#delete-selected', function(e) {
                e.preventDefault();
                var selected_rows = getSelectedRows();

                if (selected_rows.length > 0) {
                    $('input#selected_rows').val(selected_rows);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('form#mass_delete_form').submit();
                        }
                    });
                } else {
                    $('input#selected_rows').val('');
                    swal('@lang('lang_v1.no_row_selected')');
                }
            });

            $(document).on('click', '#deactivate-selected', function(e) {
                e.preventDefault();
                var selected_rows = getSelectedRows();

                if (selected_rows.length > 0) {
                    $('input#selected_products').val(selected_rows);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            var form = $('form#mass_deactivate_form')

                            var data = form.serialize();
                            $.ajax({
                                method: form.attr('method'),
                                url: form.attr('action'),
                                dataType: 'json',
                                data: data,
                                success: function(result) {
                                    if (result.success == true) {
                                        toastr.success(result.msg);
                                        product_table.ajax.reload();
                                        form
                                            .find('#selected_products')
                                            .val('');
                                    } else {
                                        toastr.error(result.msg);
                                    }
                                },
                            });
                        }
                    });
                } else {
                    $('input#selected_products').val('');
                    swal('@lang('lang_v1.no_row_selected')');
                }
            })

            $(document).on('click', '#edit-selected', function(e) {
                e.preventDefault();
                var selected_rows = getSelectedRows();

                if (selected_rows.length > 0) {
                    $('input#selected_products_for_edit').val(selected_rows);
                    $('form#bulk_edit_form').submit();
                } else {
                    $('input#selected_products').val('');
                    swal('@lang('lang_v1.no_row_selected')');
                }
            })

            $('table#product_table tbody').on('click', 'a.activate-product', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                $.ajax({
                    method: "get",
                    url: href,
                    dataType: "json",
                    success: function(result) {
                        if (result.success == true) {
                            toastr.success(result.msg);
                            product_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            });

            $(document).on('click', '#activate-selected', function(e) {
                e.preventDefault();
                var selected_rows = getSelectedRows();

                if (selected_rows.length > 0) {
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: false,
                    }).then((willActivate) => {
                        if (willActivate) {
                            var requests = [];
                            var activate_base_url = "{{ url('/products/activate') }}";

                            selected_rows.forEach(function(product_id) {
                                requests.push($.ajax({
                                    method: "get",
                                    url: activate_base_url + '/' + product_id,
                                    dataType: "json"
                                }));
                            });

                            $.when.apply($, requests).done(function() {
                                toastr.success('Selected products activated successfully');
                                product_table.ajax.reload();
                            }).fail(function(xhr) {
                                var msg = (xhr && xhr.responseJSON && xhr.responseJSON.msg) ? xhr
                                    .responseJSON.msg : "@lang('messages.something_went_wrong')";
                                toastr.error(msg);
                            });
                        }
                    });
                } else {
                    swal('@lang('lang_v1.no_row_selected')');
                }
            });

            $(document).on('change',
                '#product_list_filter_type, #product_list_filter_category_id, #product_list_filter_brand_id, #product_list_filter_unit_id, #product_list_filter_tax_id, #location_id, #active_state, #repair_model_id',
                function() {
                    if ($("#product_list_tab").hasClass('active')) {
                        product_table.ajax.reload();
                    }

                    if ($("#product_stock_report").hasClass('active')) {
                        stock_report_table.ajax.reload();
                    }
                });

            $(document).on('ifChanged', '#not_for_selling, #woocommerce_enabled', function() {
                if ($("#product_list_tab").hasClass('active')) {
                    product_table.ajax.reload();
                }

                if ($("#product_stock_report").hasClass('active')) {
                    stock_report_table.ajax.reload();
                }
            });

            $('#vp-apply-products-filter').on('click', function() {
                if ($("#product_list_tab").hasClass('active')) {
                    product_table.ajax.reload();
                }
                if ($("#product_stock_report").hasClass('active') && typeof stock_report_table !== 'undefined') {
                    stock_report_table.ajax.reload();
                }
            });

            $('#product_location').select2({
                dropdownParent: $('#product_location').closest('.modal')
            });

            @if ($is_woocommerce)
                $(document).on('click', '.toggle_woocomerce_sync', function(e) {
                    e.preventDefault();
                    var selected_rows = getSelectedRows();
                    if (selected_rows.length > 0) {
                        $('#woocommerce_sync_modal').modal('show');
                        $("input#woocommerce_products_sync").val(selected_rows);
                    } else {
                        $('input#selected_products').val('');
                        swal('@lang('lang_v1.no_row_selected')');
                    }
                });

                $(document).on('submit', 'form#toggle_woocommerce_sync_form', function(e) {
                    e.preventDefault();
                    var url = $('form#toggle_woocommerce_sync_form').attr('action');
                    var method = $('form#toggle_woocommerce_sync_form').attr('method');
                    var data = $('form#toggle_woocommerce_sync_form').serialize();
                    var ladda = Ladda.create(document.querySelector('.ladda-button'));
                    ladda.start();
                    $.ajax({
                        method: method,
                        dataType: "json",
                        url: url,
                        data: data,
                        success: function(result) {
                            ladda.stop();
                            if (result.success) {
                                $("input#woocommerce_products_sync").val('');
                                $('#woocommerce_sync_modal').modal('hide');
                                toastr.success(result.msg);
                                product_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                });
            @endif
        });

        $(document).on('shown.bs.modal', 'div.view_product_modal, div.view_modal, #view_product_modal',
            function() {
                var div = $(this).find('#view_product_stock_details');
                if (div.length) {
                    $.ajax({
                        url: "{{ action([\App\Http\Controllers\ReportController::class, 'getStockReport']) }}" +
                            '?for=view_product&product_id=' + div.data('product_id'),
                        dataType: 'html',
                        success: function(result) {
                            div.html(result);
                            __currency_convert_recursively(div);
                        },
                    });
                }
                __currency_convert_recursively($(this));
            });
        var data_table_initailized = false;
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            if ($(e.target).attr('href') == '#product_stock_report') {
                if (!data_table_initailized) {
                    //Stock report table
                    var stock_report_cols = [{
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'sku',
                            name: 'variations.sub_sku'
                        },
                        {
                            data: 'product',
                            name: 'p.name'
                        },
                        {
                            data: 'variation',
                            name: 'variation'
                        },
                        {
                            data: 'category_name',
                            name: 'c.name'
                        },
                        {
                            data: 'location_name',
                            name: 'l.name'
                        },
                        {
                            data: 'unit_price',
                            name: 'variations.sell_price_inc_tax'
                        },
                        {
                            data: 'stock',
                            name: 'stock',
                            searchable: false
                        },
                    ];
                    if ($('th.stock_price').length) {
                        stock_report_cols.push({
                            data: 'stock_price',
                            name: 'stock_price',
                            searchable: false
                        });
                        stock_report_cols.push({
                            data: 'stock_value_by_sale_price',
                            name: 'stock_value_by_sale_price',
                            searchable: false,
                            orderable: false
                        });
                        stock_report_cols.push({
                            data: 'potential_profit',
                            name: 'potential_profit',
                            searchable: false,
                            orderable: false
                        });
                    }

                    stock_report_cols.push({
                        data: 'total_sold',
                        name: 'total_sold',
                        searchable: false
                    });
                    stock_report_cols.push({
                        data: 'total_transfered',
                        name: 'total_transfered',
                        searchable: false
                    });
                    stock_report_cols.push({
                        data: 'total_adjusted',
                        name: 'total_adjusted',
                        searchable: false
                    });
                    stock_report_cols.push({
                        data: 'product_custom_field1',
                        name: 'p.product_custom_field1'
                    });
                    stock_report_cols.push({
                        data: 'product_custom_field2',
                        name: 'p.product_custom_field2'
                    });
                    stock_report_cols.push({
                        data: 'product_custom_field3',
                        name: 'p.product_custom_field3'
                    });
                    stock_report_cols.push({
                        data: 'product_custom_field4',
                        name: 'p.product_custom_field4'
                    });

                    if ($('th.current_stock_mfg').length) {
                        stock_report_cols.push({
                            data: 'total_mfg_stock',
                            name: 'total_mfg_stock',
                            searchable: false
                        });
                    }
                    stock_report_table = $('#stock_report_table').DataTable({
                        order: [
                            [1, 'asc']
                        ],
                        processing: true,
                        serverSide: true,
                        scrollY: "75vh",
                        scrollX: true,
                        scrollCollapse: true,
                        fixedHeader:false,
                        ajax: {
                            url: '/reports/stock-report',
                            data: function(d) {
                                d.location_id = $('#location_id').val();
                                d.category_id = $('#product_list_filter_category_id').val();
                                d.brand_id = $('#product_list_filter_brand_id').val();
                                d.unit_id = $('#product_list_filter_unit_id').val();
                                d.type = $('#product_list_filter_type').val();
                                d.active_state = $('#active_state').val();
                                d.not_for_selling = $('#not_for_selling').is(':checked');
                                if ($('#repair_model_id').length == 1) {
                                    d.repair_model_id = $('#repair_model_id').val();
                                }
                            }
                        },
                        columns: stock_report_cols,
                        fnDrawCallback: function(oSettings) {
                            __currency_convert_recursively($('#stock_report_table'));
                        },
                        "footerCallback": function(row, data, start, end, display) {
                            var footer_total_stock = 0;
                            var footer_total_sold = 0;
                            var footer_total_transfered = 0;
                            var total_adjusted = 0;
                            var total_stock_price = 0;
                            var footer_stock_value_by_sale_price = 0;
                            var total_potential_profit = 0;
                            var footer_total_mfg_stock = 0;
                            for (var r in data) {
                                footer_total_stock += $(data[r].stock).data('orig-value') ?
                                    parseFloat($(data[r].stock).data('orig-value')) : 0;

                                footer_total_sold += $(data[r].total_sold).data('orig-value') ?
                                    parseFloat($(data[r].total_sold).data('orig-value')) : 0;

                                footer_total_transfered += $(data[r].total_transfered).data(
                                        'orig-value') ?
                                    parseFloat($(data[r].total_transfered).data('orig-value')) : 0;

                                total_adjusted += $(data[r].total_adjusted).data('orig-value') ?
                                    parseFloat($(data[r].total_adjusted).data('orig-value')) : 0;

                                total_stock_price += $(data[r].stock_price).data('orig-value') ?
                                    parseFloat($(data[r].stock_price).data('orig-value')) : 0;

                                footer_stock_value_by_sale_price += $(data[r].stock_value_by_sale_price)
                                    .data('orig-value') ?
                                    parseFloat($(data[r].stock_value_by_sale_price).data(
                                        'orig-value')) : 0;

                                total_potential_profit += $(data[r].potential_profit).data(
                                        'orig-value') ?
                                    parseFloat($(data[r].potential_profit).data('orig-value')) : 0;

                                footer_total_mfg_stock += $(data[r].total_mfg_stock).data(
                                        'orig-value') ?
                                    parseFloat($(data[r].total_mfg_stock).data('orig-value')) : 0;
                            }

                            $('.footer_total_stock').html(__currency_trans_from_en(footer_total_stock,
                                false));
                            $('.footer_total_stock_price').html(__currency_trans_from_en(
                                total_stock_price));
                            $('.footer_total_sold').html(__currency_trans_from_en(footer_total_sold,
                                false));
                            $('.footer_total_transfered').html(__currency_trans_from_en(
                                footer_total_transfered, false));
                            $('.footer_total_adjusted').html(__currency_trans_from_en(total_adjusted,
                                false));
                            $('.footer_stock_value_by_sale_price').html(__currency_trans_from_en(
                                footer_stock_value_by_sale_price));
                            $('.footer_potential_profit').html(__currency_trans_from_en(
                                total_potential_profit));
                            if ($('th.current_stock_mfg').length) {
                                $('.footer_total_mfg_stock').html(__currency_trans_from_en(
                                    footer_total_mfg_stock, false));
                            }
                        },
                    });
                    data_table_initailized = true;
                } else {
                    stock_report_table.ajax.reload();
                }
            } else {
                product_table.ajax.reload();
            }

            // remove class from data table button
            $('.btn-default').removeClass('btn-default');
            $('.tw-dw-btn-outline').removeClass('btn');
        });

        $(document).on('click', '.update_product_location', function(e) {
            e.preventDefault();
            var selected_rows = getSelectedRows();

            if (selected_rows.length > 0) {
                $('input#selected_products').val(selected_rows);
                var type = $(this).data('type');
                var modal = $('#edit_product_location_modal');
                if (type == 'add') {
                    modal.find('.remove_from_location_title').addClass('hide');
                    modal.find('.add_to_location_title').removeClass('hide');
                } else if (type == 'remove') {
                    modal.find('.add_to_location_title').addClass('hide');
                    modal.find('.remove_from_location_title').removeClass('hide');
                }

                modal.modal('show');
                modal.find('#product_location').select2({
                    dropdownParent: modal
                });
                modal.find('#product_location').val('').change();
                modal.find('#update_type').val(type);
                modal.find('#products_to_update_location').val(selected_rows);
            } else {
                $('input#selected_products').val('');
                swal('@lang('lang_v1.no_row_selected')');
            }
        });

        $(document).on('submit', 'form#edit_product_location_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    __disable_submit_button(form.find('button[type="submit"]'));
                },
                success: function(result) {
                    if (result.success == true) {
                        $('div#edit_product_location_modal').modal('hide');
                        toastr.success(result.msg);
                        product_table.ajax.reload();
                        $('form#edit_product_location_form')
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
