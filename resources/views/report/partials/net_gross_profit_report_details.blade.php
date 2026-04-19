<div class="vp-pl-cogs-block">
    <div class="vp-pl-cogs-title">
        @lang('lang_v1.cogs')
        <span class="display_currency" data-currency_symbol="true">{{ ($data['opening_stock'] + $data['total_purchase']) - $data['closing_stock'] }}</span>
    </div>
    <small class="help-block text-muted" style="margin: 0;">
        @lang('lang_v1.cogs_help_text')
    </small>
</div>

<div class="vp-pl-hero-cards">
    <div>
        <div class="vp-pl-hero-card vp-pl-hero-card--gross">
            <div>
                <div class="vp-pl-hero-label">{{ __('lang_v1.gross_profit') }}</div>
                <div class="vp-pl-hero-value">
                    <span class="display_currency" data-currency_symbol="true">{{ $data['gross_profit'] }}</span>
                </div>
            </div>
            <i class="fa fa-info-circle" style="opacity: 0.45;" aria-hidden="true"></i>
        </div>
        <div class="vp-pl-hero-help">
            (@lang('lang_v1.total_sell_price') - @lang('lang_v1.total_purchase_price'))
            @if (!empty($data['gross_profit_label']))
                @foreach ($data['gross_profit_label'] as $val)
                    + {{ $val }}
                @endforeach
            @endif
        </div>
    </div>
    <div>
        <div class="vp-pl-hero-card vp-pl-hero-card--net">
            <div>
                <div class="vp-pl-hero-label">{{ __('report.net_profit') }}</div>
                <div class="vp-pl-hero-value">
                    <span class="display_currency" data-currency_symbol="true">{{ $data['net_profit'] }}</span>
                </div>
            </div>
            <i class="fa fa-info-circle" style="opacity: 0.55;" aria-hidden="true"></i>
        </div>
        <div class="vp-pl-hero-help">
            @lang('lang_v1.gross_profit') + (@lang('lang_v1.total_sell_shipping_charge') + @lang('lang_v1.sell_additional_expense') + @lang('report.total_stock_recovered') + @lang('lang_v1.total_purchase_discount') + @lang('lang_v1.total_sell_round_off')
            @foreach ($data['right_side_module_data'] as $module_data)
                @if (!empty($module_data['add_to_net_profit']))
                    + {{ $module_data['label'] }}
                @endif
            @endforeach
            ) <br> - ( @lang('report.total_stock_adjustment') + @lang('report.total_expense') + @lang('lang_v1.total_purchase_shipping_charge') + @lang('lang_v1.total_transfer_shipping_charge') + @lang('lang_v1.purchase_additional_expense') + @lang('lang_v1.total_sell_discount') + @lang('lang_v1.total_reward_amount')
            @foreach ($data['left_side_module_data'] as $module_data)
                @if (!empty($module_data['add_to_net_profit']))
                    + {{ $module_data['label'] }}
                @endif
            @endforeach )
        </div>
    </div>
</div>
