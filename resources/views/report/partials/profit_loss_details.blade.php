<div class="row vp-pl-details-row">
    <div class="col-lg-6 col-md-12 mb-3 mb-lg-0">
        <div class="vp-pl-metric-card">
            @include('report.partials.opening_stock_report_table')
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="vp-pl-metric-card">
            @include('report.partials.clossing_stock_report_table')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="vp-pl-summary-wrap">
            @include('report.partials.net_gross_profit_report_details')
        </div>
    </div>
</div>
