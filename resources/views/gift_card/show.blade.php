@extends('layouts.app')
@section('title', __('lang_v1.gift_card_details'))

@section('content')
    <div class="vp-gift-page-wrap">
        <section class="content-header no-print vp-gift-header">
            <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black vp-gift-header-title">
                <span class="vp-gift-header-title-row">
                    <a href="{{ action([\App\Http\Controllers\GiftCardController::class, 'index']) }}" class="vp-gift-back-btn" aria-label="Back to gift cards">
                        <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="Back">
                    </a>
                    <span class="vp-gift-title-text">@lang('lang_v1.gift_card_details')</span>
                </span>
            </h1>
        </section>

        <section class="content no-print vp-gift-content">
            <div class="row">
                <div class="col-md-12">
                    @component('components.widget', ['class' => 'box-primary', 'title' => $gift_card->card_number])
                        <div class="row">
                            <div class="col-md-3">
                                <strong>@lang('contact.customer'):</strong><br>
                                {{ optional($gift_card->customer)->name ?? '--' }}
                            </div>
                            <div class="col-md-3">
                                <strong>@lang('lang_v1.initial_balance'):</strong><br>
                                <span class="display_currency" data-currency_symbol="true">{{ $gift_card->initial_balance }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>@lang('lang_v1.current_balance'):</strong><br>
                                <span class="display_currency" data-currency_symbol="true">{{ $gift_card->current_balance }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>@lang('sale.status'):</strong><br>
                                {{ ucfirst($gift_card->status) }}
                            </div>
                            <div class="col-md-12 tw-mt-3">
                                <strong>@lang('lang_v1.gift_card_linked_pos_sale'):</strong>
                                @if(!empty($gift_card->linked_sale_id))
                                    <a href="{{ action([\App\Http\Controllers\SellController::class, 'show'], [$gift_card->linked_sale_id]) }}" target="_blank" rel="noopener">@lang('lang_v1.gift_card_view_sale') (#{{ $gift_card->linked_sale_id }})</a>
                                    @if(optional($gift_card->linkedSale)->invoice_no)
                                        — @lang('sale.invoice_no'): {{ $gift_card->linkedSale->invoice_no }}
                                    @endif
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                        @if(!empty($gift_card->note))
                            <hr>
                            <strong>@lang('brand.note'):</strong>
                            <p>{{ $gift_card->note }}</p>
                        @endif
                    @endcomponent
                </div>

                <div class="col-md-12">
                    @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.gift_card_transactions')])
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.date')</th>
                                        <th>@lang('lang_v1.type')</th>
                                        <th>@lang('sale.amount')</th>
                                        <th>@lang('lang_v1.balance_before')</th>
                                        <th>@lang('lang_v1.balance_after')</th>
                                        <th>@lang('sale.invoice_no')</th>
                                        <th>@lang('sale.note')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                        <tr>
                                            <td>{{ @format_datetime($trx->created_at) }}</td>
                                            <td>{{ ucfirst($trx->type) }}</td>
                                            <td><span class="display_currency" data-currency_symbol="true">{{ $trx->amount }}</span></td>
                                            <td><span class="display_currency" data-currency_symbol="true">{{ $trx->balance_before }}</span></td>
                                            <td><span class="display_currency" data-currency_symbol="true">{{ $trx->balance_after }}</span></td>
                                            <td>{{ optional($trx->transaction)->invoice_no ?? '--' }}</td>
                                            <td>{{ $trx->note ?? '--' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $transactions->links() }}
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
        .vp-gift-back-btn {
            width: 30px; height: 30px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
            background: #fff; text-decoration: none !important; box-shadow: 0 4px 10px rgba(18, 29, 64, 0.18);
        }
        .vp-gift-back-btn img { width: 14px; height: 14px; object-fit: contain; display: block; }
        .vp-gift-content .box, .vp-gift-content .box.box-primary {
            border: none !important; border-radius: 12px !important; box-shadow: none !important; background: #fff !important;
        }
        .vp-gift-content .box-header { border: none !important; background: #fff; padding: 14px 14px 8px; }
        .vp-gift-content .box-title { color: #27306f !important; font-size: 34px; font-weight: 700; }
        .vp-gift-content .box-body { padding: 10px 14px 14px; }
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
