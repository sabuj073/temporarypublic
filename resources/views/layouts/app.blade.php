@inject('request', 'Illuminate\Http\Request')

@if (
    $request->segment(1) == 'pos' &&
        ($request->segment(2) == 'create' || $request->segment(3) == 'edit' || $request->segment(2) == 'payment'))
    @php
        $pos_layout = true;
    @endphp
@else
    @php
        $pos_layout = false;
    @endphp
@endif

@php
    $whitelist = ['127.0.0.1', '::1'];
    $vp_users_vendo_page = $request->path() === 'users';
    $vp_purchases_vendo_page = $request->path() === 'purchases';
    $vp_stock_transfer_vendo_page = $request->path() === 'stock-transfers';
    $vp_stock_adjustment_vendo_page = $request->path() === 'stock-adjustments';
    $vp_expenses_vendo_page = $request->path() === 'expenses';
    $vp_profit_loss_vendo_page = $request->path() === 'reports/profit-loss';
    $vp_business_settings_vendo_page = $request->path() === 'business/settings';
    $vp_path = $request->path();
    $vp_vendo_scroll_shell = \Illuminate\Support\Str::startsWith($vp_path, 'products')
        || \Illuminate\Support\Str::startsWith($vp_path, 'expenses')
        || \Illuminate\Support\Str::startsWith($vp_path, 'purchases')
        || \Illuminate\Support\Str::startsWith($vp_path, 'users')
        || \Illuminate\Support\Str::startsWith($vp_path, 'contacts')
        || \Illuminate\Support\Str::startsWith($vp_path, 'stock-transfers')
        || \Illuminate\Support\Str::startsWith($vp_path, 'stock-adjustments')
        || \Illuminate\Support\Str::startsWith($vp_path, 'sells');
    $is_home_dashboard = $request->segment(1) == 'home' && empty($request->segment(2));
    $global_dashboard_bg = file_exists(public_path('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg'))
        ? asset('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg')
        : null;
    $adminlte_skin_class = 'skin-' . (!empty(session('business.theme_color')) ? session('business.theme_color') : 'blue-light');
@endphp

<!DOCTYPE html>
<html class="tw-bg-white tw-scroll-smooth {{ $vp_vendo_scroll_shell ? 'vp-vendo-scroll-shell-html' : '' }}" lang="{{ app()->getLocale() }}"
    dir="{{ in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr' }}">
<head>
    <!-- Tell the browser to be responsive to screen width -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title') - {{ Session::get('business.name') }}</title>

    @include('layouts.partials.css')
    

    @include('layouts.partials.extracss')

    @if ($pos_layout)
        <style id="vp-pos-page-surface">
            body.vp-pos-page {
                background-color: #24255b !important;
                @if (!empty($global_dashboard_bg))
                    background-image:
                        linear-gradient(0deg, rgba(36, 37, 91, 0.8), rgba(36, 37, 91, 0.8)),
                        url('{{ $global_dashboard_bg }}') !important;
                    background-size: cover !important;
                    background-position: center center !important;
                    background-repeat: no-repeat !important;
                    background-attachment: fixed !important;
                @else
                    background-image: linear-gradient(120deg, #1c2a62 0%, #242f70 55%, #2a377f 100%) !important;
                @endif
            }

            body.vp-pos-page .thetop,
            body.vp-pos-page .thetop main,
            body.vp-pos-page #scrollable-container {
                background: transparent !important;
            }

            body.vp-pos-page .vp-pos-secondary-toolbar {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
                border: 0 !important;
            }

            /* Keep POS in one viewport: header + scroll area must not exceed 100vh */
            body.vp-pos-page .thetop {
                min-height: 100vh;
                max-height: 100vh;
                overflow: hidden;
                flex-direction: column !important;
            }

            body.vp-pos-page .thetop > main {
                min-height: 0;
                flex: 1 1 auto;
                height: auto !important;
                max-height: 100%;
                overflow: hidden;
            }

            body.vp-pos-page #scrollable-container {
                height: auto !important;
                min-height: 0 !important;
                flex: 1 1 auto !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
            }
        </style>
    @endif

    @yield('css')

</head>
<body
    class="tw-font-sans tw-antialiased tw-text-gray-900 tw-bg-gray-100 {{ $is_home_dashboard ? 'vp-home-dashboard' : '' }} {{ $vp_users_vendo_page ? 'vp-users-vendo-page' : '' }} {{ $vp_purchases_vendo_page ? 'vp-purchases-vendo-page' : '' }} {{ $vp_stock_transfer_vendo_page ? 'vp-stock-transfer-vendo-page' : '' }} {{ $vp_stock_adjustment_vendo_page ? 'vp-stock-adjustment-vendo-page' : '' }} {{ $vp_expenses_vendo_page ? 'vp-expenses-vendo-page' : '' }} {{ $vp_profit_loss_vendo_page ? 'vp-profit-loss-vendo-page' : '' }} {{ $vp_business_settings_vendo_page ? 'vp-business-settings-vendo-page' : '' }} {{ $vp_vendo_scroll_shell ? 'vp-vendo-scroll-shell' : '' }} @if ($pos_layout) hold-transition lockscreen vp-pos-page {{ $adminlte_skin_class }} @else hold-transition {{ $adminlte_skin_class }} sidebar-mini @endif" >
    <div class="tw-flex thetop">
        <script type="text/javascript">
            if (localStorage.getItem("upos_sidebar_collapse") == 'true') {
                var body = document.getElementsByTagName("body")[0];
                body.className += " sidebar-collapse";
            }
        </script>
        @if (!$pos_layout && $request->segment(1) != 'customer-display')
            @include('layouts.partials.sidebar')
        @endif

        @if (in_array($_SERVER['REMOTE_ADDR'], $whitelist))
            <input type="hidden" id="__is_localhost" value="true">
        @endif

        <!-- Add currency related field-->
        <input type="hidden" id="__code" value="{{ session('currency')['code'] }}">
        <input type="hidden" id="__symbol" value="{{ session('currency')['symbol'] }}">
        <input type="hidden" id="__thousand" value="{{ session('currency')['thousand_separator'] }}">
        <input type="hidden" id="__decimal" value="{{ session('currency')['decimal_separator'] }}">
        <input type="hidden" id="__symbol_placement" value="{{ session('business.currency_symbol_placement') }}">
        <input type="hidden" id="__precision" value="{{ session('business.currency_precision', 2) }}">
        <input type="hidden" id="__quantity_precision" value="{{ session('business.quantity_precision', 2) }}">
        <!-- End of currency related field-->
        @can('view_export_buttons')
            <input type="hidden" id="view_export_buttons">
        @endcan
        @if (isMobile())
            <input type="hidden" id="__is_mobile">
        @endif
        @if (session('status'))
            <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
                data-msg="{{ session('status.msg') }}">
        @endif
        <main class="tw-flex tw-flex-col tw-flex-1 tw-h-full tw-min-w-0 tw-bg-transparent">
            @if($request->segment(1) != 'customer-display' && !$pos_layout)
                @include('layouts.partials.header')
            @elseif($request->segment(1) != 'customer-display' && $pos_layout)
                @include('layouts.partials.header')
                @include('layouts.partials.header-pos')
            @endif
            <!-- empty div for vuejs -->
            <div id="app">
                @yield('vue')
            </div>
            <div class="tw-flex-1 tw-overflow-y-auto tw-h-screen" id="scrollable-container">
                @yield('content')
                @if (!$pos_layout && !$is_home_dashboard && !$vp_vendo_scroll_shell && !$vp_profit_loss_vendo_page && !$vp_business_settings_vendo_page)
                    @include('layouts.partials.footer')
                @endif
            </div>
            <div class='scrolltop no-print'>
                <div class='scroll icon'><i class="fas fa-angle-up"></i></div>
            </div>

            @if (config('constants.iraqi_selling_price_adjustment'))
                <input type="hidden" id="iraqi_selling_price_adjustment">
            @endif

            <!-- This will be printed -->
            <section class="invoice print_section" id="receipt_section">
            </section>
        </main>

        @include('home.todays_profit_modal')
        <!-- /.content-wrapper -->



        <audio id="success-audio">
            <source src="{{ asset('/audio/success.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/success.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>
        <audio id="error-audio">
            <source src="{{ asset('/audio/error.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/error.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>
        <audio id="warning-audio">
            <source src="{{ asset('/audio/warning.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/warning.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>

        @if (!empty($__additional_html))
            {!! $__additional_html !!}
        @endif

        @include('layouts.partials.javascripts')
        
        {{-- Module JS --}}
        @include('layouts.module-assets')
        <div class="modal fade view_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

        @if (!empty($__additional_views) && is_array($__additional_views))
            @foreach ($__additional_views as $additional_view)
                @includeIf($additional_view)
            @endforeach
        @endif
        <div>

            <div class="overlay tw-hidden"></div>
        </div>
</body>
<style>
    body:not(.lockscreen) {
        background-color: #24255b !important;
        @if (!empty($global_dashboard_bg))
            background-image:
                linear-gradient(0deg, rgba(36, 37, 91, 0.8), rgba(36, 37, 91, 0.8)),
                url('{{ $global_dashboard_bg }}') !important;
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
        @else
            background-image: linear-gradient(120deg, #1c2a62 0%, #242f70 55%, #2a377f 100%) !important;
        @endif
    }

    .thetop,
    .thetop main,
    body:not(.vp-vendo-scroll-shell) #scrollable-container {
        background: transparent !important;
    }

    @media print {
        #scrollable-container {
            overflow: visible !important;
            height: auto !important;
        }
        
        /* Hide side menu */
        .side-bar,
        .thetop > aside {
            display: none !important;
        }
    }
</style>
@if (!empty($vp_vendo_scroll_shell))
    @include('layouts.partials.vendo_scroll_shell_page_styles')
    @include('layouts.partials.vendo_form_shell_wrap_styles')
@endif
<style>
    .side-bar.small-view-side-active:not(.vp-custom-sidebar) {
        display: grid !important;
        z-index: 1000;
        position: absolute;
    }
    .side-bar.vp-custom-sidebar.small-view-side-active {
        display: block !important;
        z-index: 1101;
        position: fixed;
    }
    .overlay {
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        z-index: 1100;
    }

    .tw-dw-btn.tw-dw-btn-xs.tw-dw-btn-outline {
        width: max-content;
        margin: 2px;
    }

    #scrollable-container{
        position:relative;
    }
    



</style>

</html>
