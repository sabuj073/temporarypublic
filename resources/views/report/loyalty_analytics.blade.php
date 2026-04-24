@extends('layouts.app')
@section('title', 'Loyalty Analytics')

@section('content')
<div class="vp-theme-page-wrap">
    <section class="content-header no-print vp-theme-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black vp-theme-header-title">
            <span class="vp-theme-header-title-row">
                <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-theme-back-btn" aria-label="Back to home">
                    <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="Back">
                </a>
                <span class="vp-theme-title-text">Loyalty Program Analytics</span>
            </span>
        </h1>
    </section>

    <section class="content no-print vp-theme-content">
        @component('components.widget', ['class' => 'box-primary', 'title' => 'Filter'])
            {!! Form::open(['url' => action([\App\Http\Controllers\LoyaltyAnalyticsController::class, 'index']), 'method' => 'get']) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('start_date', __('messages.date') . ' (From)') !!}
                        {!! Form::date('start_date', $start_date, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('end_date', __('messages.date') . ' (To)') !!}
                        {!! Form::date('end_date', $end_date, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 25px;">
                        <button type="submit" class="tw-dw-btn vp-theme-save-btn">@lang('report.apply_filters')</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        @endcomponent

        <div class="row">
            <div class="col-md-6">
                @component('components.widget', ['class' => 'box-primary', 'title' => 'Points Summary'])
                    <table class="table table-bordered">
                        <tr>
                            <th>Points Earned</th>
                            <td>{{ $points_earned }}</td>
                        </tr>
                        <tr>
                            <th>Points Redeemed</th>
                            <td>{{ $points_redeemed }}</td>
                        </tr>
                        <tr>
                            <th>Net Points</th>
                            <td>{{ $points_earned - $points_redeemed }}</td>
                        </tr>
                    </table>
                @endcomponent
            </div>
            <div class="col-md-6">
                @component('components.widget', ['class' => 'box-primary', 'title' => 'Configured Membership Tiers'])
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Tier</th>
                                <th>Min Points</th>
                                <th>Min Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tiers as $tier)
                                <tr>
                                    <td>{{ $tier->level }}</td>
                                    <td>{{ $tier->name }}</td>
                                    <td>{{ $tier->min_total_points }}</td>
                                    <td>{{ $tier->min_lifetime_sales }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">No data found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                @component('components.widget', ['class' => 'box-primary', 'title' => 'Active Members by Tier'])
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tier</th>
                                <th>Total Members</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tier_customers as $row)
                                <tr>
                                    <td>{{ $row->tier_name }}</td>
                                    <td>{{ $row->total_customers }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center">No data found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @endcomponent
            </div>
            <div class="col-md-6">
                @component('components.widget', ['class' => 'box-primary', 'title' => 'Tier-wise Sales Contribution'])
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tier</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tier_sales as $row)
                                <tr>
                                    <td>{{ $row->tier_name }}</td>
                                    <td><span class="display_currency" data-currency_symbol="true">{{ $row->total_sales }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center">No data found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>
    </section>
</div>
@endsection

@section('css')
<style>
    .vp-theme-page-wrap {
        margin: 22px 26px 28px;
        padding: 22px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
    }
    .vp-theme-header { margin: 0 0 10px !important; }
    .vp-theme-header h1.vp-theme-header-title {
        color: #fff !important;
        font-size: 34px !important;
        font-weight: 700 !important;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .vp-theme-header .vp-theme-header-title-row { display: inline-flex; align-items: center; gap: 12px; }
    .vp-theme-back-btn {
        width: 30px; height: 30px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
        background: #fff; text-decoration: none !important; box-shadow: 0 4px 10px rgba(18, 29, 64, 0.18);
    }
    .vp-theme-back-btn img { width: 14px; height: 14px; object-fit: contain; display: block; }
    .vp-theme-content .box, .vp-theme-content .box.box-primary {
        border: none !important; border-radius: 12px !important; box-shadow: none !important; background: #fff !important;
    }
    .vp-theme-content .box-header { border: none !important; background: #fff; padding: 14px 14px 8px; }
    .vp-theme-content .box-title { color: #27306f !important; font-size: 34px; font-weight: 700; }
    .vp-theme-content .box-body { padding: 10px 14px 14px; }
    .vp-theme-content label { color: #303a73 !important; font-size: 12px; font-weight: 600; margin-bottom: 5px; }
    .vp-theme-content .form-control, .vp-theme-content .select2-selection {
        border: 1px solid #cfd5ea !important; border-radius: 6px !important; font-size: 13px !important; color: #2f3970; height: 34px !important;
    }
    .vp-theme-save-btn {
        background: linear-gradient(90deg, #4f63d8 0%, #5ea0ff 100%) !important;
        border: none !important; color: #fff !important; border-radius: 12px !important; padding: 8px 18px !important; font-weight: 700;
    }
    .vp-theme-content table thead th {
        color: #303a73 !important;
        background: #fbfbff;
        border-bottom: 1px solid #e3e6f3 !important;
        font-weight: 700;
        font-size: 12px;
    }
    .vp-theme-content table tbody td { font-size: 12px; color: #2f3a67; }
</style>
@endsection
