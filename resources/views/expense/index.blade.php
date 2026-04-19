@extends('layouts.app')
@section('title', __('expense.expenses'))

@section('css')
    @include('expense.partials.vendo_expenses_page_styles')
@endsection

@section('content')
    <div class="vp-expenses-page-wrap no-print">
        <div class="vp-expenses-shell">
            <div class="vp-expenses-page-head">
                <button type="button" class="vp-expenses-back" id="vp_expenses_back_btn" title="{{ __('messages.go_back') }}"
                    aria-label="{{ __('messages.go_back') }}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <h1 class="vp-expenses-page-title">@lang('expense.expenses')</h1>
            </div>

            <div class="vp-expenses-card">
                <div class="vp-expenses-filters">
                    <div class="vp-expenses-filter-row">
                        @if (auth()->user()->can('all_expense.access'))
                            <div class="vp-expenses-filter-field">
                                {!! Form::label('location_id', __('purchase.business_location')) !!}
                                {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                            </div>
                            <div class="vp-expenses-filter-field">
                                {!! Form::label('expense_for', __('expense.expense_for')) !!}
                                {!! Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                            </div>
                            <div class="vp-expenses-filter-field">
                                {!! Form::label('created_by', __('lang_v1.added_by')) !!}
                                {!! Form::select('created_by', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                            </div>
                            <div class="vp-expenses-filter-field">
                                {!! Form::label('expense_contact_filter', __('contact.contact')) !!}
                                {!! Form::select('expense_contact_filter', $contacts, null, [
                                    'class' => 'form-control select2',
                                    'style' => 'width:100%',
                                    'placeholder' => __('lang_v1.all'),
                                ]) !!}
                            </div>
                        @endif
                        <div class="vp-expenses-filter-field">
                            {!! Form::label('expense_category_id', __('expense.expense_category')) !!}
                            {!! Form::select('expense_category_id', $categories, null, [
                                'placeholder' => __('report.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'expense_category_id',
                            ]) !!}
                        </div>
                        <div class="vp-expenses-filter-field">
                            {!! Form::label('expense_sub_category_id_filter', __('product.sub_category')) !!}
                            {!! Form::select('expense_sub_category_id_filter', $sub_categories, null, [
                                'placeholder' => __('report.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'expense_sub_category_id_filter',
                            ]) !!}
                        </div>
                        <div class="vp-expenses-filter-field">
                            {!! Form::label('expense_date_range', __('report.date_range')) !!}
                            {!! Form::text('date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'id' => 'expense_date_range',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="vp-expenses-filter-field">
                            {!! Form::label('expense_payment_status', __('purchase.payment_status')) !!}
                            {!! Form::select(
                                'expense_payment_status',
                                ['paid' => __('lang_v1.paid'), 'due' => __('lang_v1.due'), 'partial' => __('lang_v1.partial')],
                                null,
                                ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')],
                            ) !!}
                        </div>
                    </div>
                </div>

                <div class="vp-expenses-card-toolbar">
                    <h2 class="vp-expenses-card-title">@lang('expense.all_expenses')</h2>
                    <div class="vp-expenses-card-toolbar-end">
                        <div class="vp-expenses-slot vp-expenses-filter-slot"></div>
                        <div class="vp-expenses-slot vp-expenses-length-slot"></div>
                        @can('expense.add')
                            <a class="vp-expenses-import-btn" href="{{ action([\App\Http\Controllers\ExpenseController::class, 'importExpense']) }}">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                @lang('expense.import_expense')
                            </a>
                            <a class="vp-expenses-add-btn" href="{{ action([\App\Http\Controllers\ExpenseController::class, 'create']) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="vp-expenses-table-wrap">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ajax_view" id="expense_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('messages.date')</th>
                                    <th>@lang('purchase.ref_no')</th>
                                    <th>@lang('lang_v1.recur_details')</th>
                                    <th>@lang('expense.expense_category')</th>
                                    <th>@lang('product.sub_category')</th>
                                    <th>@lang('business.location')</th>
                                    <th>@lang('sale.payment_status')</th>
                                    <th>@lang('product.tax')</th>
                                    <th>@lang('sale.total_amount')</th>
                                    <th>@lang('purchase.payment_due')</th>
                                    <th>@lang('expense.expense_for')</th>
                                    <th>@lang('contact.contact')</th>
                                    <th>@lang('expense.expense_note')</th>
                                    <th>@lang('lang_v1.added_by')</th>
                                    <th>@lang('messages.action')</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="bg-gray font-17 text-center footer-total">
                                    <td colspan="6"><strong>@lang('sale.total'):</strong></td>
                                    <td class="footer_payment_status_count"></td>
                                    <td></td>
                                    <td class="footer_expense_total"></td>
                                    <td class="footer_total_due"></td>
                                    <td colspan="5"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="vp-expenses-card-footer">
                    <div class="vp-expenses-slot vp-expenses-info-slot"></div>
                    <div class="vp-expenses-slot vp-expenses-paginate-slot"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="vp-expenses-export-dock no-print">
        <div id="vp-expenses-export-inner" class="vp-expenses-export-inner"></div>
    </div>

    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@endsection

@section('javascript')
    <script>
        window.__vpExpensesMoveLayout = function() {
            var w = $('#expense_table_wrapper');
            if (!w.length || !$('.vp-expenses-page-wrap').length) {
                return;
            }
            w.find('.dataTables_filter').appendTo('.vp-expenses-filter-slot');
            w.find('.dataTables_length').appendTo('.vp-expenses-length-slot');
            w.find('.dataTables_info').appendTo('.vp-expenses-info-slot');
            w.find('.dataTables_paginate').appendTo('.vp-expenses-paginate-slot');
            var $dtButtons = w.find('.dt-buttons');
            if ($dtButtons.length && $('#vp-expenses-export-inner').length) {
                $('#vp-expenses-export-inner').empty().append($dtButtons);
            }
            w.find('.row.margin-bottom-20').first().hide();
            $('.vp-expenses-filter-slot .dataTables_filter input').attr({
                type: 'search',
                autocomplete: 'off'
            });
            if (typeof LANG !== 'undefined' && LANG.search) {
                $('.vp-expenses-filter-slot .dataTables_filter input').attr('placeholder', LANG.search + ' ...');
            }
            if (!$('#vp-expenses-export-inner').find('.dt-buttons').length) {
                $('.vp-expenses-export-dock').removeClass('vp-expenses-export-dock--visible');
            } else {
                $('.vp-expenses-export-dock').addClass('vp-expenses-export-dock--visible');
            }
        };

        window.__vpExpensesDataTableOverrides = {
            scrollY: '',
            scrollX: false,
            scrollCollapse: false,
        };
        @cannot('view_export_buttons')
            window.__vpExpensesDataTableOverrides.dom = 'lfrtip';
            window.__vpExpensesDataTableOverrides.buttons = [];
        @endcannot
    </script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/expenses_index.js?v=' . $asset_v) }}"></script>
    <script>
        $('#vp_expenses_back_btn').on('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.assign('{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}');
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                if (typeof window.__vpExpensesMoveLayout === 'function') {
                    window.__vpExpensesMoveLayout();
                }
            }, 450);
            $('#expense_table').on('draw.dt', function() {
                if (typeof window.__vpExpensesMoveLayout === 'function') {
                    window.__vpExpensesMoveLayout();
                }
            });
        });
    </script>
@endsection
