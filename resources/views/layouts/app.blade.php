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

    /*
     * “Vendo” shell: same background on #scrollable-container + optional section card chrome as All Sales / Contacts.
     * Covers essentially all sidebar-backed admin routes; POS create/edit stays excluded via $pos_layout.
     */
    $vpVendoShellPrefixes = [
        'products',
        'expenses',
        'purchases',
        'users',
        'user/',
        'contacts',
        'stock-transfers',
        'stock-adjustments',
        'sells',
        'sell-return',
        'reports',
        'backup',
        'notification-templates',
        'business',
        'roles',
        'brands',
        'tax-rates',
        'units',
        'barcodes',
        'invoice-schemes',
        'invoice-layouts',
        'labels',
        'group-taxes',
        'ledger-discount',
        'import-sales',
        'purchase-requisition',
        'taxonomies',
        'variation-templates',
        'payment-account',
        'account',
        'account-types',
        'cash-register',
        'opening-stock',
        'import-opening-stock',
        'discount',
        'customer-group',
        'selling-price-group',
        'types-of-service',
        'shipments',
        'manage-modules',
        'subscription',
        'superadmin',
        'connector',
        'woocommerce',
        'sales-commission-agents',
        'bookings',
        'modules/',
        'warranties',
        'calendar',
    ];

    $vp_vendo_scroll_shell = false;
    if (! $pos_layout) {
        foreach ($vpVendoShellPrefixes as $prefix) {
            if (\Illuminate\Support\Str::startsWith($vp_path, $prefix)) {
                $vp_vendo_scroll_shell = true;
                break;
            }
        }
    }
    $is_home_dashboard = $request->segment(1) == 'home' && empty($request->segment(2));
    $global_dashboard_bg = file_exists(public_path('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg'))
        ? asset('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg')
        : null;
    $adminlte_skin_class = 'skin-' . (!empty(session('business.theme_color')) ? session('business.theme_color') : 'blue-light');
@endphp

<!DOCTYPE html>
<html class="tw-scroll-smooth vp-app-html {{ $vp_vendo_scroll_shell ? 'vp-vendo-scroll-shell-html' : '' }}" lang="{{ app()->getLocale() }}"
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
        {{-- Include on POS too: header hamburger toggles .side-bar + .overlay; skipping sidebar left a backdrop with no drawer. --}}
        @if ($request->segment(1) != 'customer-display')
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

            @if ($request->segment(1) != 'customer-display')
                <button type="button" id="vp-app-fullscreen-fab" class="vp-app-fullscreen-fab no-print"
                    aria-pressed="false"
                    title="{{ __('messages.fullscreen') }}"
                    aria-label="{{ __('messages.fullscreen') }}"
                    data-title-enter="{{ __('messages.fullscreen') }}"
                    data-title-exit="{{ __('messages.exit_fullscreen') }}"
                    data-msg-unsupported="{{ __('messages.fullscreen_unsupported') }}">
                    <i class="fas fa-expand" aria-hidden="true"></i>
                </button>
            @endif

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
    /*
     * Avoid white gaps when overscrolling or when inner scroll is shorter than the viewport:
     * html used to be tw-bg-white; body bg is fixed/cover — paint the same stack on html + scroll column.
     */
    html.vp-app-html {
        background-color: #24255b !important;
        min-height: 100%;
    }

    body:not(.lockscreen) {
        min-height: 100vh;
        min-height: 100dvh;
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
    .thetop main {
        background: transparent !important;
    }

    /* Vendo shell partial already paints this; elsewhere fill the scroll pane so empty tail isn’t white */
    body:not(.vp-vendo-scroll-shell):not(.vp-pos-page):not(.lockscreen) #scrollable-container {
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

    body.vp-vendo-scroll-shell #scrollable-container,
    body.vp-pos-page #scrollable-container {
        background: transparent !important;
    }

    /* Elegant receipt (classes used instead of inline white-on-blue for print safety) */
    #receipt_section .vp-receipt-blue-header-row,
    #receipt_section .vp-receipt-blue-header-cell,
    #receipt_section .vp-receipt-blue-total-cell {
        background-color: #357ca5 !important;
        color: #fff !important;
    }

    /* Full screen toggle: fixed bottom-right (above scroll-to-top control). */
    .vp-app-fullscreen-fab {
        position: fixed;
        z-index: 1088;
        bottom: calc(5.25rem + env(safe-area-inset-bottom, 0px));
        right: calc(0.75rem + env(safe-area-inset-right, 0px));
        width: 46px;
        height: 46px;
        padding: 0;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff !important;
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%);
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.35);
        transition: filter 0.15s ease, transform 0.15s ease;
    }

    .vp-app-fullscreen-fab:hover {
        filter: brightness(1.08);
    }

    .vp-app-fullscreen-fab:active {
        transform: scale(0.97);
    }

    .vp-app-fullscreen-fab .fas {
        font-size: 1.1rem;
        line-height: 1;
    }

    html[dir="rtl"] .vp-app-fullscreen-fab {
        right: auto;
        left: calc(0.75rem + env(safe-area-inset-left, 0px));
    }

    @media print {
        html,
        body {
            background: #fff !important;
            background-image: none !important;
            background-color: #fff !important;
            color: #000 !important;
        }

        body:not(.lockscreen) {
            background: #fff !important;
            background-image: none !important;
            background-attachment: scroll !important;
        }

        .wrapper,
        .thetop,
        .thetop main,
        .content-wrapper,
        .right-side,
        body:not(.vp-vendo-scroll-shell) #scrollable-container {
            background: #fff !important;
            background-image: none !important;
        }

        #scrollable-container {
            overflow: visible !important;
            height: auto !important;
        }

        /* Receipt / invoice fragment injected into #receipt_section */
        #receipt_section.invoice,
        #receipt_section.print_section {
            background: #fff !important;
            color: #000 !important;
        }

        /*
         * AdminLTE print CSS sets .invoice-col to 33.33% width — breaks two-column receipts
         * (customer block overlaps totals / “Subtotal” shows wrong text). Force a stable layout.
         */
        #receipt_section .row.invoice-info {
            display: flex !important;
            flex-wrap: wrap !important;
            width: 100% !important;
            align-items: flex-start !important;
        }

        #receipt_section .row.invoice-info > .invoice-col.width-50,
        #receipt_section .invoice .invoice-col.width-50 {
            flex: 0 0 50% !important;
            width: 50% !important;
            max-width: 50% !important;
            float: none !important;
            box-sizing: border-box !important;
        }

        /* When backgrounds are omitted, keep totals / header text visible */
        #receipt_section .vp-receipt-blue-header-row,
        #receipt_section .vp-receipt-blue-header-cell,
        #receipt_section .vp-receipt-blue-total-cell {
            background-color: #cfd9e8 !important;
            color: #0f172a !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
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
@if (! empty($vp_vendo_scroll_shell))
    <style id="vp-admin-section-shell-styles">
        body.vp-vendo-scroll-shell #scrollable-container {
            padding-bottom: 28px;
        }

        /*
         * Classic AdminLTE pages (content-header + content): same outer margins + translucent shell
         * as All Sales / Contacts (white cards inside .box / DataTables).
         */
        body.vp-vendo-scroll-shell #scrollable-container > section.no-print,
        body.vp-vendo-scroll-shell #scrollable-container > section.content-header,
        body.vp-vendo-scroll-shell #scrollable-container > section.content {
            margin: 0 26px;
            padding: 18px 18px 16px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        body.vp-vendo-scroll-shell #scrollable-container > section.no-print {
            margin-top: 12px;
        }

        body.vp-vendo-scroll-shell #scrollable-container > section.content-header:first-child,
        body.vp-vendo-scroll-shell #scrollable-container > section.content:first-child {
            margin-top: 12px;
        }

        body.vp-vendo-scroll-shell #scrollable-container > section.no-print + section.content-header,
        body.vp-vendo-scroll-shell #scrollable-container > section.content-header + section.content,
        body.vp-vendo-scroll-shell #scrollable-container > section.no-print + section.content {
            margin-top: 12px;
        }

        body.vp-vendo-scroll-shell #scrollable-container > section.content {
            margin-bottom: 28px;
            padding-top: 16px;
        }

        body.vp-vendo-scroll-shell #scrollable-container > section.content-header h1,
        body.vp-vendo-scroll-shell #scrollable-container > section.content-header h1 small {
            color: #f8fafc !important;
        }

        body.vp-vendo-scroll-shell #scrollable-container > section.content-header .text-muted,
        body.vp-vendo-scroll-shell #scrollable-container > section.content-header .hover-q {
            color: rgba(248, 250, 252, 0.85) !important;
        }

        body.vp-vendo-scroll-shell #scrollable-container .vp-classic-module-topnav {
            margin: 0;
            border: 0;
            border-radius: 12px;
            background: #fff !important;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        }

        body.vp-vendo-scroll-shell #scrollable-container .vp-classic-module-topnav .navbar-nav > li > a {
            font-weight: 700;
        }

        body.vp-vendo-scroll-shell #scrollable-container .vp-classic-module-topnav .navbar-nav > .active > a,
        body.vp-vendo-scroll-shell #scrollable-container .vp-classic-module-topnav .navbar-nav > .active > a:hover,
        body.vp-vendo-scroll-shell #scrollable-container .vp-classic-module-topnav .navbar-nav > .active > a:focus {
            background: rgba(36, 37, 91, 0.08);
            color: #1b2259 !important;
        }

        body.vp-vendo-scroll-shell #scrollable-container .box,
        body.vp-vendo-scroll-shell #scrollable-container .box-primary,
        body.vp-vendo-scroll-shell #scrollable-container .box-solid,
        body.vp-vendo-scroll-shell #scrollable-container .small-box {
            border-radius: 12px !important;
        }

        @media (max-width: 767px) {
            body.vp-vendo-scroll-shell #scrollable-container > section.no-print,
            body.vp-vendo-scroll-shell #scrollable-container > section.content-header,
            body.vp-vendo-scroll-shell #scrollable-container > section.content {
                margin-left: 12px;
                margin-right: 12px;
                padding: 14px;
            }

            body.vp-vendo-scroll-shell #scrollable-container > section.no-print {
                margin-top: 14px;
            }

            body.vp-vendo-scroll-shell #scrollable-container > section.content-header:first-child,
            body.vp-vendo-scroll-shell #scrollable-container > section.content:first-child {
                margin-top: 14px;
            }

            body.vp-vendo-scroll-shell #scrollable-container > section.no-print + section.content-header,
            body.vp-vendo-scroll-shell #scrollable-container > section.content-header + section.content,
            body.vp-vendo-scroll-shell #scrollable-container > section.no-print + section.content {
                margin-top: 12px;
            }

            body.vp-vendo-scroll-shell #scrollable-container > section.content {
                margin-bottom: 16px;
            }
        }
    </style>
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

    @media (max-width: 991px) {
        /*
         * Mobile browsers (especially iOS) render fixed backgrounds unreliably inside
         * nested scroll containers. Use scroll attachment to keep theme visible.
         */
        body:not(.lockscreen) {
            background-attachment: scroll !important;
            background-position: center top !important;
        }

        /*
         * Keep dropdowns in cards from clipping. Do NOT force overflow:visible on table
         * wrappers — that breaks horizontal scroll on mobile and makes tables spill past
         * the card (DataTables + wide tables).
         */
        #scrollable-container .box,
        #scrollable-container [class*="vp-"][class$="-card"] {
            overflow: visible !important;
        }

        #scrollable-container .table-responsive,
        #scrollable-container [class*="vp-"][class$="-table-wrap"] {
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
        }

        #scrollable-container .dataTables_wrapper .dataTables_scrollBody {
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch;
        }

        #scrollable-container .dataTables_wrapper table.dataTable,
        #scrollable-container .table-responsive table {
            min-width: 860px;
        }

        /*
         * DataTables footer / toolbar on index-style pages: floats + Buttons extension
         * overflow the white card between tablet and desktop widths. Normalize layout for
         * all list screens under the Vendo shell.
         */
        #scrollable-container .dataTables_wrapper {
            max-width: 100%;
            box-sizing: border-box;
        }

        #scrollable-container .dataTables_wrapper > .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            max-width: 100%;
        }

        #scrollable-container .dataTables_wrapper .dataTables_length,
        #scrollable-container .dataTables_wrapper .dataTables_filter,
        #scrollable-container .dataTables_wrapper .dataTables_info,
        #scrollable-container .dataTables_wrapper .dataTables_paginate {
            float: none !important;
            text-align: center !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            box-sizing: border-box !important;
        }

        #scrollable-container .dataTables_wrapper .dataTables_paginate .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 8px 0 0;
        }

        #scrollable-container .dataTables_wrapper .dt-buttons {
            float: none !important;
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 6px !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 8px 0 !important;
            padding: 0 4px !important;
            box-sizing: border-box !important;
            clear: both !important;
        }

        #scrollable-container .dataTables_wrapper .dt-buttons .btn,
        #scrollable-container .dataTables_wrapper .dt-buttons .dt-button {
            float: none !important;
            margin: 4px 2px !important;
        }

        /* DaisyUI outline xs buttons use width:max-content — allow wrap inside DT footers */
        #scrollable-container .dataTables_wrapper .dt-buttons .tw-dw-btn.tw-dw-btn-xs.tw-dw-btn-outline {
            width: auto !important;
            max-width: calc(100% - 8px);
        }

        /*
         * Phones: three export / utility buttons per row (grid) so the bar stays compact
         * and does not force horizontal page scroll.
         */
        @media (max-width: 767px) {
            #scrollable-container .dataTables_wrapper .dt-buttons,
            #scrollable-container [id$="-export-actions"] .dt-buttons,
            #scrollable-container [class*="-export-actions"] .dt-buttons,
            #scrollable-container [id*="export-inner"] .dt-buttons,
            #scrollable-container [class*="-export-inner"] .dt-buttons {
                display: grid !important;
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                gap: 8px !important;
                padding: 8px !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                align-items: stretch !important;
                float: none !important;
            }

            /* Let grouped Buttons children participate in the parent grid */
            #scrollable-container .dataTables_wrapper .dt-buttons > .btn-group,
            #scrollable-container [id$="-export-actions"] .dt-buttons > .btn-group,
            #scrollable-container [class*="-export-actions"] .dt-buttons > .btn-group,
            #scrollable-container [id*="export-inner"] .dt-buttons > .btn-group,
            #scrollable-container [class*="-export-inner"] .dt-buttons > .btn-group {
                display: contents !important;
            }

            #scrollable-container .dataTables_wrapper .dt-buttons > .dt-button,
            #scrollable-container .dataTables_wrapper .dt-buttons > .btn,
            #scrollable-container .dataTables_wrapper .dt-buttons .btn-group > .btn,
            #scrollable-container .dataTables_wrapper .dt-buttons .btn-group > .dt-button,
            #scrollable-container [id$="-export-actions"] .dt-button,
            #scrollable-container [id$="-export-actions"] .btn,
            #scrollable-container [class*="-export-actions"] .dt-button,
            #scrollable-container [class*="-export-actions"] .btn,
            #scrollable-container [id*="export-inner"] .dt-button,
            #scrollable-container [class*="-export-inner"] .dt-button,
            #scrollable-container [id*="export-inner"] .dt-buttons > .btn,
            #scrollable-container [class*="-export-inner"] .dt-buttons > .btn {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                float: none !important;
                margin: 0 !important;
                box-sizing: border-box !important;
                overflow-wrap: break-word !important;
            }

            /* Slightly wider gaps on detached export docks (colvis + PDF on same row). */
            #scrollable-container [id*="export-inner"] .dt-buttons,
            #scrollable-container [class*="-export-inner"] .dt-buttons {
                gap: 12px !important;
            }

            /* Last export control (usually PDF) — breathing room after colvis. */
            #scrollable-container .dataTables_wrapper .dt-buttons > *:last-child,
            #scrollable-container [id$="-export-actions"] .dt-buttons > *:last-child,
            #scrollable-container [class*="-export-actions"] .dt-buttons > *:last-child,
            #scrollable-container [id*="export-inner"] .dt-buttons > *:last-child,
            #scrollable-container [class*="-export-inner"] .dt-buttons > *:last-child {
                margin-left: 30px !important;
            }

            #scrollable-container .dataTables_wrapper .dt-buttons .tw-dw-btn.tw-dw-btn-xs.tw-dw-btn-outline {
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        #scrollable-container table .btn-group > .dropdown-menu,
        #scrollable-container table .dropdown > .dropdown-menu {
            left: auto;
            right: 0;
            max-width: calc(100vw - 24px);
            z-index: 2000;
        }

        #scrollable-container table .btn-group,
        #scrollable-container table .dropdown {
            position: relative;
        }
    }
</style>

</html>
