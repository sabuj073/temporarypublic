<div class="vp-pl-dt-toolbar">
    <div class="vp-pl-filter-slot"></div>
    <div class="vp-pl-length-slot"></div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-text-center" id="profit_by_day_table">
        <thead>
            <tr>
                <th>@lang('lang_v1.days')</th>
                <th>@lang('lang_v1.gross_profit')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($days as $day)
                <tr>
                    <td>@lang('lang_v1.' . $day)</td>
                    <td><span class="gross-profit" data-orig-value="{{$profits[$day] ?? 0}}">@if(isset($profits[$day]))@format_currency($profits[$day]) @else 0 @endif</span></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td><strong>@lang('sale.total'):</strong></td>
                <td><span class="display_currency footer_total" data-currency_symbol ="true"></span></td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="vp-pl-dt-footer">
    <div class="vp-pl-info-slot"></div>
    <div class="vp-pl-paginate-slot"></div>
</div>