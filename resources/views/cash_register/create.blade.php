@extends('layouts.app')
@section('title',  __('cash_register.open_cash_register'))

@section('content')
    <style type="text/css">
        .vp-open-register-wrap {
            padding: 6px 8px 16px;
        }

        .vp-open-register-title {
            margin: 0 0 12px;
            color: #fff;
            font-size: 34px;
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: 0.2px;
            text-shadow: 0 3px 12px rgba(0, 0, 0, 0.3);
        }

        .vp-open-register-card {
            border-radius: 12px;
            background: #fff;
            border: 1px solid #e4eaf8;
            box-shadow: 0 10px 28px rgba(10, 16, 44, 0.16);
            padding: 20px 18px;
            min-height: 210px;
        }

        .vp-open-register-card .form-control {
            border-radius: 8px;
            height: 40px;
            border-color: #d6deef;
            box-shadow: none;
        }

        .vp-open-register-card .form-control:focus {
            border-color: #7f9cff;
            box-shadow: 0 0 0 2px rgba(99, 123, 255, 0.18);
        }

        .vp-open-register-card label {
            color: #1f2f5d;
            font-weight: 700;
        }

        .vp-open-register-submit {
            border-radius: 8px;
            min-width: 150px;
            height: 42px;
            border: 1px solid transparent;
            background: linear-gradient(140deg, #5b78f4 0%, #4f6de9 100%);
            color: #fff !important;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(71, 92, 192, 0.3);
        }

        .vp-open-register-submit:hover {
            filter: brightness(1.04);
            color: #fff !important;
        }
    </style>

    <section class="content vp-open-register-wrap">
        <h1 class="vp-open-register-title">@lang('cash_register.open_cash_register')</h1>

        {!! Form::open([
            'url' => action([\App\Http\Controllers\CashRegisterController::class, 'store']),
            'method' => 'post',
            'id' => 'add_cash_register_form',
        ]) !!}
        <div class="vp-open-register-card">
            <input type="hidden" name="sub_type" value="{{ $sub_type }}">
            <div class="row">
                @if ($business_locations->count() > 0)
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            {!! Form::label('amount', __('cash_register.cash_in_hand') . ':*') !!}
                            {!! Form::text('amount', null, [
                                'class' => 'form-control input_number',
                                'placeholder' => __('cash_register.enter_amount'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                    @if (count($business_locations) > 1)
                        <div class="clearfix"></div>
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="form-group">
                                {!! Form::label('location_id', __('business.business_location') . ':') !!}
                                {!! Form::select('location_id', $business_locations, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang_v1.select_location'),
                                ]) !!}
                            </div>
                        </div>
                    @else
                        {!! Form::hidden('location_id', array_key_first($business_locations->toArray())) !!}
                    @endif
                    <div class="col-sm-8 col-sm-offset-2">
                        <button type="submit" class="vp-open-register-submit pull-right">@lang('cash_register.open_register')</button>
                    </div>
                @else
                    <div class="col-sm-8 col-sm-offset-2 text-center">
                        <h3>@lang('lang_v1.no_location_access_found')</h3>
                    </div>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection