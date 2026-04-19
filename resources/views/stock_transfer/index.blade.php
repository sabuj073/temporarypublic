@extends('layouts.app')
@section('title', __('lang_v1.stock_transfers'))

@section('css')
    @include('stock_transfer.partials.vendo_stock_transfers_page_styles')
@endsection

@section('content')
    <div class="vp-stock-transfer-page-wrap no-print">
        <div class="vp-stock-transfer-shell">
            <div class="vp-stock-transfer-page-head">
                <button type="button" class="vp-stock-transfer-back" id="vp_stock_transfer_back_btn"
                    title="{{ __('messages.go_back') }}" aria-label="{{ __('messages.go_back') }}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <h1 class="vp-stock-transfer-page-title">@lang('lang_v1.stock_transfers')</h1>
            </div>

            <div class="vp-stock-transfer-card">
                <div class="vp-stock-transfer-card-toolbar">
                    <h2 class="vp-stock-transfer-card-title">@lang('lang_v1.all_stock_transfers')</h2>
                    <div class="vp-stock-transfer-card-toolbar-end">
                        <div class="vp-stock-transfer-slot vp-stock-transfer-filter-slot"></div>
                        <div class="vp-stock-transfer-slot vp-stock-transfer-length-slot"></div>
                        @can('stock_transfer.create')
                            <a class="vp-stock-transfer-add-btn"
                                href="{{ action([\App\Http\Controllers\StockTransferController::class, 'create']) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="vp-stock-transfer-table-wrap">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ajax_view" id="stock_transfer_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('messages.date')</th>
                                    <th>@lang('purchase.ref_no')</th>
                                    <th>@lang('lang_v1.location_from')</th>
                                    <th>@lang('lang_v1.location_to')</th>
                                    <th>@lang('sale.status')</th>
                                    <th>@lang('lang_v1.shipping_charges')</th>
                                    <th>@lang('stock_adjustment.total_amount')</th>
                                    <th>@lang('purchase.additional_notes')</th>
                                    <th>@lang('messages.action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="vp-stock-transfer-card-footer">
                    <div class="vp-stock-transfer-slot vp-stock-transfer-info-slot"></div>
                    <div class="vp-stock-transfer-slot vp-stock-transfer-paginate-slot"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="vp-stock-transfer-export-dock no-print">
        <div id="vp-stock-transfer-export-inner" class="vp-stock-transfer-export-inner"></div>
    </div>

    @include('stock_transfer.partials.update_status_modal')

    <section id="receipt_section" class="print_section"></section>
@endsection

@section('javascript')
    <script>
        window.__vpStockTransferMoveLayout = function() {
            var w = $('#stock_transfer_table_wrapper');
            if (!w.length || !$('.vp-stock-transfer-page-wrap').length) {
                return;
            }
            w.find('.dataTables_filter').appendTo('.vp-stock-transfer-filter-slot');
            w.find('.dataTables_length').appendTo('.vp-stock-transfer-length-slot');
            w.find('.dataTables_info').appendTo('.vp-stock-transfer-info-slot');
            w.find('.dataTables_paginate').appendTo('.vp-stock-transfer-paginate-slot');
            var $dtButtons = w.find('.dt-buttons');
            if ($dtButtons.length && $('#vp-stock-transfer-export-inner').length) {
                $('#vp-stock-transfer-export-inner').empty().append($dtButtons);
            }
            w.find('.row.margin-bottom-20').first().hide();
            $('.vp-stock-transfer-filter-slot .dataTables_filter input').attr({
                type: 'search',
                autocomplete: 'off'
            });
            if (typeof LANG !== 'undefined' && LANG.search) {
                $('.vp-stock-transfer-filter-slot .dataTables_filter input').attr('placeholder', LANG.search + ' ...');
            }
            if (!$('#vp-stock-transfer-export-inner').find('.dt-buttons').length) {
                $('.vp-stock-transfer-export-dock').removeClass('vp-stock-transfer-export-dock--visible');
            } else {
                $('.vp-stock-transfer-export-dock').addClass('vp-stock-transfer-export-dock--visible');
            }
        };

        window.__vpStockTransferDataTableOverrides = {
            scrollY: '',
            scrollX: false,
            scrollCollapse: false,
        };
        @cannot('view_export_buttons')
            window.__vpStockTransferDataTableOverrides.dom = 'lfrtip';
            window.__vpStockTransferDataTableOverrides.buttons = [];
        @endcannot
    </script>
    <script src="{{ asset('js/stock_transfer.js?v=' . $asset_v) }}"></script>
    <script>
        $('#vp_stock_transfer_back_btn').on('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.assign('{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}');
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                if (typeof window.__vpStockTransferMoveLayout === 'function') {
                    window.__vpStockTransferMoveLayout();
                }
            }, 450);
            $('#stock_transfer_table').on('draw.dt', function() {
                if (typeof window.__vpStockTransferMoveLayout === 'function') {
                    window.__vpStockTransferMoveLayout();
                }
            });
        });
    </script>
@endsection

@cannot('view_purchase_price')
    <style>
        .show_price_with_permission {
            display: none !important;
        }
    </style>
@endcannot
