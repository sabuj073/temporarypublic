@extends('layouts.app')
@section('title', __('stock_adjustment.stock_adjustments'))

@section('css')
    @include('stock_adjustment.partials.vendo_stock_adjustments_page_styles')
@endsection

@section('content')
    <div class="vp-stock-adjustment-page-wrap no-print">
        <div class="vp-stock-adjustment-shell">
            <div class="vp-stock-adjustment-page-head">
                <button type="button" class="vp-stock-adjustment-back" id="vp_stock_adjustment_back_btn"
                    title="{{ __('messages.go_back') }}" aria-label="{{ __('messages.go_back') }}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <h1 class="vp-stock-adjustment-page-title">@lang('stock_adjustment.stock_adjustments')</h1>
            </div>

            <div class="vp-stock-adjustment-card">
                <div class="vp-stock-adjustment-card-toolbar">
                    <h2 class="vp-stock-adjustment-card-title">@lang('stock_adjustment.all_stock_adjustments')</h2>
                    <div class="vp-stock-adjustment-card-toolbar-end">
                        <div class="vp-stock-adjustment-slot vp-stock-adjustment-filter-slot"></div>
                        <div class="vp-stock-adjustment-slot vp-stock-adjustment-length-slot"></div>
                        @can('stock_adjustment.create')
                            <a class="vp-stock-adjustment-add-btn"
                                href="{{ action([\App\Http\Controllers\StockAdjustmentController::class, 'create']) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="vp-stock-adjustment-table-wrap">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ajax_view" id="stock_adjustment_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('messages.date')</th>
                                    <th>@lang('purchase.ref_no')</th>
                                    <th>@lang('business.location')</th>
                                    <th>@lang('stock_adjustment.adjustment_type')</th>
                                    <th>@lang('stock_adjustment.total_amount')</th>
                                    <th>@lang('stock_adjustment.total_amount_recovered')</th>
                                    <th>@lang('stock_adjustment.reason_for_stock_adjustment')</th>
                                    <th>@lang('lang_v1.added_by')</th>
                                    <th>@lang('messages.action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="vp-stock-adjustment-card-footer">
                    <div class="vp-stock-adjustment-slot vp-stock-adjustment-info-slot"></div>
                    <div class="vp-stock-adjustment-slot vp-stock-adjustment-paginate-slot"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="vp-stock-adjustment-export-dock no-print">
        <div id="vp-stock-adjustment-export-inner" class="vp-stock-adjustment-export-inner"></div>
    </div>
@endsection

@section('javascript')
    <script>
        window.__vpStockAdjustmentMoveLayout = function() {
            var w = $('#stock_adjustment_table_wrapper');
            if (!w.length || !$('.vp-stock-adjustment-page-wrap').length) {
                return;
            }
            w.find('.dataTables_filter').appendTo('.vp-stock-adjustment-filter-slot');
            w.find('.dataTables_length').appendTo('.vp-stock-adjustment-length-slot');
            w.find('.dataTables_info').appendTo('.vp-stock-adjustment-info-slot');
            w.find('.dataTables_paginate').appendTo('.vp-stock-adjustment-paginate-slot');
            var $dtButtons = w.find('.dt-buttons');
            if ($dtButtons.length && $('#vp-stock-adjustment-export-inner').length) {
                $('#vp-stock-adjustment-export-inner').empty().append($dtButtons);
            }
            w.find('.row.margin-bottom-20').first().hide();
            $('.vp-stock-adjustment-filter-slot .dataTables_filter input').attr({
                type: 'search',
                autocomplete: 'off'
            });
            if (typeof LANG !== 'undefined' && LANG.search) {
                $('.vp-stock-adjustment-filter-slot .dataTables_filter input').attr('placeholder', LANG.search + ' ...');
            }
            if (!$('#vp-stock-adjustment-export-inner').find('.dt-buttons').length) {
                $('.vp-stock-adjustment-export-dock').removeClass('vp-stock-adjustment-export-dock--visible');
            } else {
                $('.vp-stock-adjustment-export-dock').addClass('vp-stock-adjustment-export-dock--visible');
            }
        };

        window.__vpStockAdjustmentDataTableOverrides = {
            scrollY: '',
            scrollX: false,
            scrollCollapse: false,
        };
        @cannot('view_export_buttons')
            window.__vpStockAdjustmentDataTableOverrides.dom = 'lfrtip';
            window.__vpStockAdjustmentDataTableOverrides.buttons = [];
        @endcannot
    </script>
    <script src="{{ asset('js/stock_adjustment.js?v=' . $asset_v) }}"></script>
    <script>
        $('#vp_stock_adjustment_back_btn').on('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.assign('{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}');
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                if (typeof window.__vpStockAdjustmentMoveLayout === 'function') {
                    window.__vpStockAdjustmentMoveLayout();
                }
            }, 450);
            $('#stock_adjustment_table').on('draw.dt', function() {
                if (typeof window.__vpStockAdjustmentMoveLayout === 'function') {
                    window.__vpStockAdjustmentMoveLayout();
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
