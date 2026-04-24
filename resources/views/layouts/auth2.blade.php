<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
    class="{{ request()->routeIs('login') || request()->routeIs('business.getRegister') || request()->routeIs('password.request') || request()->routeIs('password.reset') ? 'vp-login-dashboard-page' : '' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'POS') }}</title>

    @include('layouts.partials.css')

    @include('layouts.partials.extracss_auth')

    @if (request()->routeIs('login') || request()->routeIs('business.getRegister') || request()->routeIs('password.request') || request()->routeIs('password.reset'))
        @include('layouts.partials.auth-login-dashboard-styles')
    @endif

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body class="pace-done" data-new-gr-c-s-check-loaded="14.1172.0" data-gr-ext-installed="" cz-shortcut-listen="true">
    @inject('request', 'Illuminate\Http\Request')
    @php
        $authBusiness = session('business');
        $authLogoPath = null;
        if (file_exists(public_path('uploads/logo.png'))) {
            $authLogoPath = asset('uploads/logo.png');
        } elseif (!empty($authBusiness['logo']) && file_exists(public_path('uploads/business_logos/' . $authBusiness['logo']))) {
            $authLogoPath = asset('uploads/business_logos/' . $authBusiness['logo']);
        } elseif (file_exists(public_path('img/logo-small.png'))) {
            $authLogoPath = asset('img/logo-small.png');
        }
    @endphp
    @if (session('status') && session('status.success'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
            data-msg="{{ session('status.msg') }}">
    @endif
    <div class="container-fluid">
        <div class="row eq-height-row">
            <div class="col-md-12 col-sm-12 col-xs-12 right-col vp-auth-page-wrap">
                <div class="row">
                    {{-- <div
                        class="lg:tw-w-16 md:tw-h-16 tw-w-12 tw-h-12 tw-flex tw-items-center tw-justify-center tw-mx-auto tw-overflow-hidden tw-bg-white tw-rounded-full tw-p-0.5 tw-mb-4">
                        <img src="{{ asset('img/logo-small.png')}}" alt="lock" class="tw-rounded-full tw-object-fill" />
                    </div> --}}

                    <div class="vp-auth-topbar">
                        <div class="vp-auth-topbar-left">
                        <a href="{{ url('/') }}" class="vp-auth-logo-link" style="max-width: 250px; display: inline-block;">
                            <div
                                class="vp-auth-logo-wrap tw-flex tw-items-center tw-justify-start tw-mx-auto tw-mb-2 tw-overflow-visible"
                                style="max-width: 250px;">
                                @if (!empty($authLogoPath))
                                    <img src="{{ $authLogoPath }}" alt="{{ config('app.name', 'POS') }}" class="vp-auth-logo-img tw-object-contain tw-object-left tw-drop-shadow-sm" style="display: block; max-width: 250px; width: auto; height: auto;" />
                                @else
                                    <span class="tw-text-white tw-text-xl md:tw-text-2xl"><i class="fa fa-home" aria-hidden="true"></i></span>
                                @endif
                            </div>
                        </a>
                        @if(config('constants.SHOW_REPAIR_STATUS_LOGIN_SCREEN') && Route::has('repair-status'))
                            <a class="tw-text-white tw-font-medium tw-text-sm md:tw-text-base hover:tw-text-white"
                                href="{{ action([\Modules\Repair\Http\Controllers\CustomerRepairStatusController::class, 'index']) }}">
                                @lang('repair::lang.repair_status')
                            </a>
                        @endif
                        
                        @if(Route::has('member_scanner'))
                            <a class="tw-text-white tw-font-medium tw-text-sm md:tw-text-base hover:tw-text-white"
                                href="{{ action([\Modules\Gym\Http\Controllers\MemberController::class, 'member_scanner']) }}">
                                @lang('gym::lang.gym_member_profile')
                            </a>
                        @endif
                        </div>

                        <div class="vp-auth-topbar-right">
                        @if (!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
                            <!-- Register Url -->
                            @if (config('constants.allow_registration'))
                            {{-- <span
                                class="tw-text-white tw-font-medium tw-text-sm md:tw-text-base">{{ __('business.not_yet_registered') }}
                            </span> --}}

                            <div class="tw-border-2 tw-border-white tw-rounded-full tw-h-10 md:tw-h-12 tw-w-24 tw-flex tw-items-center tw-justify-center">
                             <a href="{{ route('business.getRegister')}}@if(!empty(request()->lang)){{'?lang='.request()->lang}}@endif"
                                    class="tw-text-white tw-font-medium tw-text-sm md:tw-text-base hover:tw-text-white">
                                    {{ __('business.register') }}</a>
                            </div>

                                <!-- pricing url -->
                                @if (Route::has('pricing') && config('app.env') != 'demo' && $request->segment(1) != 'pricing')
                                    &nbsp; <a class="tw-text-white tw-font-medium tw-text-sm md:tw-text-base hover:tw-text-white"
                                        href="{{ action([\Modules\Superadmin\Http\Controllers\PricingController::class, 'index']) }}">@lang('superadmin::lang.pricing')</a>
                                @endif
                            @endif
                        @endif
                        @if ($request->segment(1) != 'login')
                            <a class="tw-text-white tw-font-medium tw-text-sm md:tw-text-base hover:tw-text-white"
                                href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'login'])}}@if(!empty(request()->lang)){{'?lang='.request()->lang}}@endif">{{ __('business.sign_in') }}</a>
                        @endif
                        @include('layouts.partials.language_btn')
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>


    @include('layouts.partials.javascripts')

    <!-- Scripts -->
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>

    @yield('javascript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2_register').select2();

            // $('input').iCheck({
            //     checkboxClass: 'icheckbox_square-blue',
            //     radioClass: 'iradio_square-blue',
            //     increaseArea: '20%' // optional
            // });
        });
    </script>
    <style>
        .wizard>.content {
            background-color: white !important;
        }

        .vp-auth-page-wrap {
            padding: 1.25rem clamp(1rem, 4vw, 2.5rem) 1.5rem !important;
            box-sizing: border-box;
        }

        /* Bootstrap .row uses negative side margins; without columns they cancel parent padding */
        .vp-auth-page-wrap > .row:first-of-type {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .vp-auth-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            padding-top: 0.25rem;
        }

        .vp-auth-topbar-left,
        .vp-auth-topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 0;
        }

        .vp-auth-topbar-right {
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .vp-auth-topbar-right .tw-dw-dropdown {
            margin: 0 !important;
        }

        /* Logo cap (Tailwind arbitrary classes may be missing from built CSS) */
        .tw-absolute.tw-flex > a.vp-auth-logo-link {
            flex-shrink: 1;
            min-width: 0;
        }

        .vp-auth-logo-link,
        .vp-auth-logo-wrap {
            max-width: 250px !important;
            box-sizing: border-box;
        }

        .vp-auth-logo-img {
            max-width: 250px !important;
            width: auto !important;
            height: auto !important;
            display: block !important;
            object-fit: contain;
        }

        @media (max-width: 767px) {
            .vp-auth-page-wrap {
                padding: 1rem clamp(0.85rem, 4vw, 1.25rem) 1.2rem !important;
            }

            .vp-auth-topbar {
                flex-direction: column;
                align-items: center;
                gap: 0.4rem;
                text-align: center;
                margin-bottom: 0.35rem;
            }

            .vp-auth-topbar-left,
            .vp-auth-topbar-right {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.6rem;
            }

            .vp-auth-logo-wrap {
                margin-bottom: 0 !important;
            }

            .vp-auth-topbar-right .tw-border-2 {
                height: 2.2rem;
                width: auto;
                padding-left: 0.9rem;
                padding-right: 0.9rem;
            }
        }
    </style>
</body>

</html>
