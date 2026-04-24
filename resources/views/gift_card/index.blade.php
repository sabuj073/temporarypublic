@extends('layouts.app')
@section('title', __('lang_v1.gift_cards'))

@section('content')
    <div class="vp-gift-page-wrap">
        <section class="content-header no-print vp-gift-header">
            <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black vp-gift-header-title">
                <span class="vp-gift-header-title-row">
                    <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-gift-back-btn" aria-label="Back to home">
                        <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="Back">
                    </a>
                    <span class="vp-gift-title-text">@lang('lang_v1.gift_cards')</span>
                </span>
            </h1>
        </section>

        <section class="content no-print vp-gift-content">
            <div class="vp-gift-help-callout tw-mb-4 tw-rounded-xl tw-border tw-border-[#cfd5ea] tw-bg-[#f7f8ff] tw-p-4 tw-text-sm tw-text-[#2f3a67]">
                <p class="tw-font-bold tw-mb-2 tw-text-[#27306f]">@lang('lang_v1.gift_card_help_title')</p>
                <ul class="tw-mb-0 tw-pl-5 tw-space-y-2">
                    <li>@lang('lang_v1.gift_card_help_issue')</li>
                    <li>@lang('lang_v1.gift_card_help_customer_pays')</li>
                    <li>@lang('lang_v1.gift_card_help_redeem')</li>
                    <li>@lang('lang_v1.gift_card_help_pos_toggle')</li>
                    <li>@lang('lang_v1.gift_card_help_pos_auto_amount')</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-4">
                    @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.issue_gift_card')])
                        {!! Form::open(['url' => action([\App\Http\Controllers\GiftCardController::class, 'store']), 'method' => 'post']) !!}
                            <div class="form-group">
                                {!! Form::label('card_number', __('lang_v1.gift_card_number')) !!}
                                {!! Form::text('card_number', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.gift_card_number_auto')]) !!}
                                <p class="help-block">@lang('lang_v1.gift_card_number_auto_help')</p>
                            </div>

                            <div class="form-group">
                                {!! Form::label('contact_id', __('contact.customer')) !!}
                                {!! Form::select('contact_id', $customers, null, ['class' => 'form-control select2', 'style' => 'width:100%;', 'placeholder' => __('messages.please_select')]) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('issue_amount', __('lang_v1.gift_card_issue_amount') . ':*') !!}
                                {!! Form::text('issue_amount', null, ['class' => 'form-control input_number', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('bonus_amount', __('lang_v1.gift_card_bonus_amount')) !!}
                                {!! Form::text('bonus_amount', null, ['class' => 'form-control input_number']) !!}
                                <p class="help-block">@lang('lang_v1.gift_card_bonus_help')</p>
                            </div>

                            <div class="form-group">
                                {!! Form::label('expires_at', __('lang_v1.gift_card_expiry_date')) !!}
                                {!! Form::text('expires_at', null, ['class' => 'form-control datepicker']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('note', __('brand.note')) !!}
                                {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 3]) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('linked_invoice_no', __('lang_v1.gift_card_linked_pos_sale')) !!}
                                {!! Form::text('linked_invoice_no', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.gift_card_linked_sale_placeholder'), 'autocomplete' => 'off']) !!}
                                <p class="help-block">@lang('lang_v1.gift_card_linked_pos_sale_help')</p>
                            </div>

                            <button type="submit" class="tw-dw-btn vp-gift-save-btn">
                                @lang('messages.save')
                            </button>
                        {!! Form::close() !!}
                    @endcomponent
                </div>

                <div class="col-md-8">
                    <div class="vp-gift-filter-card">
                        {!! Form::open(['url' => action([\App\Http\Controllers\GiftCardController::class, 'index']), 'method' => 'get']) !!}
                        <div class="vp-gift-filter-row">
                            <div class="vp-filter-field">
                                {!! Form::label('card_number', __('lang_v1.gift_card_number')) !!}
                                {!! Form::text('card_number', request('card_number'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="vp-filter-field">
                                {!! Form::label('status', __('sale.status')) !!}
                                {!! Form::select('status', ['' => __('messages.all'), 'active' => __('lang_v1.gift_card_status_active'), 'inactive' => __('lang_v1.gift_card_status_inactive'), 'expired' => __('lang_v1.gift_card_status_expired')], request('status'), ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                            </div>
                            <div class="vp-filter-action">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn vp-apply-btn">@lang('report.apply_filters')</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.balance_tracking')])
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('lang_v1.gift_card_number')</th>
                                        <th>@lang('contact.customer')</th>
                                        <th>@lang('lang_v1.initial_balance')</th>
                                        <th>@lang('lang_v1.current_balance')</th>
                                        <th>@lang('sale.status')</th>
                                        <th>@lang('lang_v1.expiry')</th>
                                        <th>@lang('lang_v1.gift_card_linked_sale_short')</th>
                                        <th>@lang('messages.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gift_cards as $card)
                                        <tr>
                                            <td>{{ $card->card_number }}</td>
                                            <td>{{ optional($card->customer)->name ?? '--' }}</td>
                                            <td><span class="display_currency" data-currency_symbol="true">{{ $card->initial_balance }}</span></td>
                                            <td><span class="display_currency" data-currency_symbol="true">{{ $card->current_balance }}</span></td>
                                            <td>
                                                @if($card->status === 'active')
                                                    <span class="label label-success">@lang('lang_v1.gift_card_status_active')</span>
                                                @elseif($card->status === 'inactive')
                                                    <span class="label label-warning">@lang('lang_v1.gift_card_status_inactive')</span>
                                                @else
                                                    <span class="label label-danger">@lang('lang_v1.gift_card_status_expired')</span>
                                                @endif
                                            </td>
                                            <td>{{ !empty($card->expires_at) ? @format_date($card->expires_at) : '--' }}</td>
                                            <td>
                                                @if(!empty($card->linked_sale_id))
                                                    <a href="{{ action([\App\Http\Controllers\SellController::class, 'show'], [$card->linked_sale_id]) }}" class="btn btn-xs btn-info" target="_blank" rel="noopener">
                                                        {{ optional($card->linkedSale)->invoice_no ?: optional($card->linkedSale)->ref_no ?: ('#'.$card->linked_sale_id) }}
                                                    </a>
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-primary" href="{{ action([\App\Http\Controllers\GiftCardController::class, 'show'], [$card->id]) }}">@lang('messages.view')</a>
                                                @if($card->status !== 'expired')
                                                    {!! Form::open(['url' => action([\App\Http\Controllers\GiftCardController::class, 'toggleStatus'], [$card->id]), 'method' => 'post', 'style' => 'display:inline-block']) !!}
                                                    <button type="submit" class="btn btn-xs btn-default">
                                                        @if($card->status === 'active')
                                                            @lang('lang_v1.deactivate')
                                                        @else
                                                            @lang('lang_v1.activate')
                                                        @endif
                                                    </button>
                                                    {!! Form::close() !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $gift_cards->links() }}
                    @endcomponent
                </div>
            </div>
        </section>
    </div>
@endsection

@section('css')
    <style>
        .vp-gift-page-wrap {
            margin: 22px 26px 28px;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
        }
        .vp-gift-header { margin: 0 0 10px !important; }
        .vp-gift-header h1.vp-gift-header-title {
            color: #fff !important;
            font-size: 34px !important;
            font-weight: 700 !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .vp-gift-header .vp-gift-header-title-row { display: inline-flex; align-items: center; gap: 12px; }
        .vp-gift-back-btn {
            width: 30px; height: 30px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
            background: #fff; text-decoration: none !important; box-shadow: 0 4px 10px rgba(18, 29, 64, 0.18);
        }
        .vp-gift-back-btn img { width: 14px; height: 14px; object-fit: contain; display: block; }
        .vp-gift-content .box, .vp-gift-content .box.box-primary {
            border: none !important; border-radius: 12px !important; box-shadow: none !important; background: #fff !important;
        }
        .vp-gift-content .box-header {
            border: none !important; background: #fff; padding: 14px 14px 8px;
        }
        .vp-gift-content .box-title { color: #27306f !important; font-size: 34px; font-weight: 700; }
        .vp-gift-content .box-body { padding: 10px 14px 14px; }
        .vp-gift-content label { color: #303a73 !important; font-size: 12px; font-weight: 600; margin-bottom: 5px; }
        .vp-gift-content .form-control, .vp-gift-content .select2-selection {
            border: 1px solid #cfd5ea !important; border-radius: 6px !important; font-size: 13px !important; color: #2f3970;
            height: 34px !important;
        }
        .vp-gift-content textarea.form-control { min-height: 88px; height: auto !important; }
        .vp-gift-save-btn {
            background: linear-gradient(90deg, #4f63d8 0%, #5ea0ff 100%) !important;
            border: none !important; color: #fff !important; border-radius: 12px !important; padding: 8px 18px !important; font-weight: 700;
        }
        .vp-gift-filter-card {
            background: #fff; border-radius: 12px 12px 0 0; padding: 12px 14px 10px; margin-bottom: 0;
        }
        .vp-gift-filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end; }
        .vp-gift-filter-row .vp-filter-field { flex: 1 1 240px; min-width: 180px; }
        .vp-gift-filter-row .vp-filter-action { width: 130px; }
        .vp-gift-filter-row .vp-filter-action label { visibility: hidden; margin: 0; height: 18px; display: block; }
        .vp-apply-btn {
            width: 100%; height: 36px; border-radius: 8px; border: none;
            color: #fff; font-weight: 600; background: linear-gradient(90deg, #4f63d8 0%, #5ea0ff 100%);
        }
        .vp-gift-content table.dataTable thead th,
        .vp-gift-content table thead th {
            color: #303a73 !important;
            background: #fbfbff;
            border-bottom: 1px solid #e3e6f3 !important;
            font-weight: 700;
            font-size: 12px;
        }
        .vp-gift-content table tbody td { font-size: 12px; color: #2f3a67; }
    </style>
@endsection
