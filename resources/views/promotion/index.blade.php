@extends('layouts.app')
@section('title', 'Promotions')

@section('content')
<div class="vp-theme-page-wrap">
    <section class="content-header no-print vp-theme-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black vp-theme-header-title">
            <span class="vp-theme-header-title-row">
                <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-theme-back-btn" aria-label="Back to home">
                    <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="Back">
                </a>
                <span class="vp-theme-title-text">Promotion Engine</span>
            </span>
        </h1>
    </section>

    <section class="content no-print vp-theme-content">
        <div class="row">
            <div class="col-md-4">
                @component('components.widget', ['class' => 'box-primary', 'title' => 'Create Promotion'])
                    {!! Form::open(['url' => action([\App\Http\Controllers\PromotionController::class, 'store']), 'method' => 'post']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Promotion Name:*') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('rule_type', 'Rule Type:*') !!}
                            {!! Form::select('rule_type', [
                                'coupon_fixed' => 'Coupon (Fixed)',
                                'coupon_percentage' => 'Coupon (Percentage)',
                                'bogo' => 'Buy One Get One',
                                'bundle' => 'Bundle Discount',
                                'tiered_volume' => 'Tiered Volume',
                            ], null, ['class' => 'form-control', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('coupon_code', 'Coupon Code') !!}
                            {!! Form::text('coupon_code', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('target_scope', 'Target Scope') !!}
                                    {!! Form::select('target_scope', [
                                        'all_products' => 'All Products',
                                        'product' => 'Specific Product',
                                        'category' => 'Specific Category',
                                        'customer_group' => 'Customer Group'
                                    ], 'all_products', ['class' => 'form-control', 'id' => 'promotion_target_scope']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group promotion-target-block promotion-target-product hide">
                                    {!! Form::label('target_product_id', 'Product') !!}
                                    {!! Form::select('target_product_id', $products, null, ['class' => 'form-control select2', 'style' => 'width:100%;', 'placeholder' => 'Select product']) !!}
                                </div>
                                <div class="form-group promotion-target-block promotion-target-category hide">
                                    {!! Form::label('target_category_id', 'Category') !!}
                                    {!! Form::select('target_category_id', $categories, null, ['class' => 'form-control select2', 'style' => 'width:100%;', 'placeholder' => 'Select category']) !!}
                                </div>
                                <div class="form-group promotion-target-block promotion-target-customer-group hide">
                                    {!! Form::label('target_customer_group_id', 'Customer Group ID') !!}
                                    {!! Form::number('target_customer_group_id', null, ['class' => 'form-control', 'placeholder' => 'Customer group id']) !!}
                                </div>
                                <input type="hidden" name="target_id" id="promotion_target_id_hidden">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('discount_type', 'Discount Type') !!}
                                    {!! Form::select('discount_type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'], 'fixed', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('discount_value', 'Discount Value') !!}
                                    {!! Form::text('discount_value', null, ['class' => 'form-control input_number']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('buy_qty', 'Buy Qty') !!}
                                    {!! Form::text('buy_qty', null, ['class' => 'form-control input_number']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('get_qty', 'Get Qty') !!}
                                    {!! Form::text('get_qty', null, ['class' => 'form-control input_number']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('bundle_qty', 'Bundle Qty') !!}
                                    {!! Form::text('bundle_qty', null, ['class' => 'form-control input_number']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('bundle_price', 'Bundle Price') !!}
                                    {!! Form::text('bundle_price', null, ['class' => 'form-control input_number']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('tier_min_qty', 'Tier Min Qty') !!}
                                    {!! Form::text('tier_min_qty', null, ['class' => 'form-control input_number']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('priority', 'Priority') !!}
                                    {!! Form::number('priority', 1, ['class' => 'form-control', 'min' => 1]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('min_order_total', 'Minimum Order Total') !!}
                            {!! Form::text('min_order_total', null, ['class' => 'form-control input_number']) !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('starts_at', 'Starts At') !!}
                                    {!! Form::text('starts_at', null, ['class' => 'form-control datetimepicker']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('ends_at', 'Ends At') !!}
                                    {!! Form::text('ends_at', null, ['class' => 'form-control datetimepicker']) !!}
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="tw-dw-btn vp-theme-save-btn">Save</button>
                    {!! Form::close() !!}
                @endcomponent
            </div>
            <div class="col-md-8">
                @component('components.widget', ['class' => 'box-primary', 'title' => 'Active Promotions'])
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Rule</th>
                                    <th>Coupon</th>
                                    <th>Scope</th>
                                    <th>Discount</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promotions as $promotion)
                                    <tr>
                                        <td>{{ $promotion->name }}</td>
                                        <td>{{ $promotion->rule_type }}</td>
                                        <td>{{ $promotion->coupon_code ?? '--' }}</td>
                                        <td>{{ $promotion->target_scope ?? 'all_products' }}</td>
                                        <td>{{ $promotion->discount_type ?? '--' }} {{ $promotion->discount_value ?? '--' }}</td>
                                        <td>{{ $promotion->priority }}</td>
                                        <td>
                                            @if($promotion->is_active)
                                                <span class="label label-success">Active</span>
                                            @else
                                                <span class="label label-default">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            {!! Form::open(['url' => action([\App\Http\Controllers\PromotionController::class, 'toggleStatus'], [$promotion->id]), 'method' => 'post']) !!}
                                            <button type="submit" class="btn btn-xs btn-default">{{ $promotion->is_active ? 'Deactivate' : 'Activate' }}</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center">No data found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $promotions->links() }}
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

@section('javascript')
<script>
    function syncPromotionTargetInputs() {
        var scope = $('#promotion_target_scope').val();
        $('.promotion-target-block').addClass('hide');
        $('select[name="target_product_id"], select[name="target_category_id"], input[name="target_customer_group_id"]').prop('disabled', true);

        if (scope === 'product') {
            $('.promotion-target-product').removeClass('hide');
            $('select[name="target_product_id"]').prop('disabled', false);
        } else if (scope === 'category') {
            $('.promotion-target-category').removeClass('hide');
            $('select[name="target_category_id"]').prop('disabled', false);
        } else if (scope === 'customer_group') {
            $('.promotion-target-customer-group').removeClass('hide');
            $('input[name="target_customer_group_id"]').prop('disabled', false);
        }
    }

    $(document).on('change', '#promotion_target_scope', syncPromotionTargetInputs);
    syncPromotionTargetInputs();

    $('form').on('submit', function() {
        var scope = $('#promotion_target_scope').val();
        var targetId = '';
        if (scope === 'category') {
            targetId = $('select[name="target_category_id"]').val() || '';
        } else if (scope === 'customer_group') {
            targetId = $('input[name="target_customer_group_id"]').val() || '';
        } else if (scope === 'product') {
            targetId = $('select[name="target_product_id"]').val() || '';
        }
        $('#promotion_target_id_hidden').val(targetId);
    });

    $('.datetimepicker').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true
    });
</script>
@endsection
