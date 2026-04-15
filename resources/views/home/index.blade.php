@extends('layouts.app')
@section('title', __('home.home'))

@php
    $business = session('business');
    $locations = $all_locations ?? [];
    $currentLocation = count($locations) ? array_key_first($locations) : null;

    $logoPath = null;
    if (file_exists(public_path('uploads/logo.png'))) {
        $logoPath = asset('uploads/logo.png');
    } elseif (!empty($business['logo']) && file_exists(public_path('uploads/business_logos/' . $business['logo']))) {
        $logoPath = asset('uploads/business_logos/' . $business['logo']);
    } elseif (file_exists(public_path('img/logo-small.png'))) {
        $logoPath = asset('img/logo-small.png');
    }

    $dashboardBgPath = null;
    if (file_exists(public_path('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg'))) {
        $dashboardBgPath = asset('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg');
    }

    $topNav = [
        ['label' => 'Home', 'url' => action([\App\Http\Controllers\HomeController::class, 'index']), 'active' => true, 'icon_path' => 'images/dashboard-icons/nav/home.png', 'fallback_icon' => 'fa-home'],
        ['label' => 'Sales', 'url' => action([\App\Http\Controllers\SellController::class, 'index']), 'active' => false, 'icon_path' => 'images/dashboard-icons/nav/sales.png', 'fallback_icon' => 'fa-bar-chart'],
        ['label' => 'Products', 'url' => action([\App\Http\Controllers\ProductController::class, 'index']), 'active' => false, 'icon_path' => 'images/dashboard-icons/nav/products.png', 'fallback_icon' => 'fa-cubes'],
        ['label' => 'Settings', 'url' => action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']), 'active' => false, 'icon_path' => 'images/dashboard-icons/nav/settings.png', 'fallback_icon' => 'fa-cog'],
    ];

    $dashboardTiles = [
        ['label' => 'Register', 'url' => action([\App\Http\Controllers\CashRegisterController::class, 'index']), 'icon_path' => 'images/dashboard-icons/register.png', 'fallback_icon' => 'fa fa-clipboard'],
        ['label' => 'Sales', 'url' => action([\App\Http\Controllers\SellController::class, 'index']), 'icon_path' => 'images/dashboard-icons/sales.png', 'fallback_icon' => 'fa fa-bar-chart'],
        ['label' => 'Products', 'url' => action([\App\Http\Controllers\ProductController::class, 'index']), 'icon_path' => 'images/dashboard-icons/products.png', 'fallback_icon' => 'fa fa-cubes'],
        ['label' => 'Users', 'url' => action([\App\Http\Controllers\ManageUserController::class, 'index']), 'icon_path' => 'images/dashboard-icons/users.png', 'fallback_icon' => 'fa fa-users'],
        ['label' => 'Contacts', 'url' => action([\App\Http\Controllers\ContactController::class, 'index']) . '?type=supplier', 'icon_path' => 'images/dashboard-icons/contacts.png', 'fallback_icon' => 'fa fa-address-book-o'],
        ['label' => 'Purchases', 'url' => action([\App\Http\Controllers\PurchaseController::class, 'index']), 'icon_path' => 'images/dashboard-icons/purchases.png', 'fallback_icon' => 'fa fa-shopping-cart'],
        ['label' => 'Stock Transfer', 'url' => action([\App\Http\Controllers\StockTransferController::class, 'index']), 'icon_path' => 'images/dashboard-icons/stock-transfer.png', 'fallback_icon' => 'fa fa-exchange'],
        ['label' => 'Stock Adjustment', 'url' => action([\App\Http\Controllers\StockAdjustmentController::class, 'index']), 'icon_path' => 'images/dashboard-icons/stock-adjustment.png', 'fallback_icon' => 'fa fa-balance-scale'],
        ['label' => 'Expenses', 'url' => action([\App\Http\Controllers\ExpenseController::class, 'index']), 'icon_path' => 'images/dashboard-icons/expense.png', 'fallback_icon' => 'fa fa-money'],
        ['label' => 'Reports', 'url' => action([\App\Http\Controllers\ReportController::class, 'getProfitLoss']), 'icon_path' => 'images/dashboard-icons/reports.png', 'fallback_icon' => 'fa fa-pie-chart'],
        ['label' => 'Settings', 'url' => action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']), 'icon_path' => 'images/dashboard-icons/settings.png', 'fallback_icon' => 'fa fa-cogs'],
        ['label' => 'Notifications', 'url' => action([\App\Http\Controllers\NotificationTemplateController::class, 'index']), 'icon_path' => 'images/dashboard-icons/notifications.png', 'fallback_icon' => 'fa fa-bell-o'],
    ];
@endphp

@section('content')
    <div class="vp-dashboard">
        <section class="vp-tile-grid">
            @foreach ($dashboardTiles as $tile)
                <a class="vp-tile-card" href="{{ $tile['url'] }}">
                    <span class="vp-tile-icon">
                        @if (!empty($tile['icon_path']) && file_exists(public_path($tile['icon_path'])))
                            <img src="{{ asset($tile['icon_path']) }}" alt="{{ $tile['label'] }} icon" class="vp-tile-icon-image">
                        @else
                            <i class="{{ $tile['fallback_icon'] }}"></i>
                        @endif
                    </span>
                    <h3>{{ $tile['label'] }}</h3>
                </a>
            @endforeach
        </section>
    </div>
@endsection

@section('css')
    <style>
        body {
            background-color: #24255b !important;
            @if (!empty($dashboardBgPath))
                background-image:
                    linear-gradient(0deg, rgba(36, 37, 91, 0.8), rgba(36, 37, 91, 0.8)),
                    url('{{ $dashboardBgPath }}') !important;
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
        #scrollable-container {
            height: auto !important;
            min-height: 100vh !important;
            overflow: visible !important;
            background: transparent !important;
        }

        #scrollable-container {
            padding: 24px 26px 28px;
        }

        body.vp-home-dashboard #scrollable-container {
            padding-top: 20px;
        }

        .vp-dashboard {
            width: 100%;
            margin: 0 auto;
            max-width: none;
            min-height: calc(100vh - 20px);
            color: #fff;
        }

        body.vp-home-dashboard .vp-dashboard {
            padding: 0 8px 16px;
        }

        .vp-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 10px 14px;
            border-radius: 12px;
            background: linear-gradient(90deg, rgba(20, 32, 73, 0.95) 0%, rgba(29, 45, 99, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 12px 30px rgba(3, 6, 27, 0.35);
        }

        .vp-topbar-left,
        .vp-topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .vp-logo-wrap {
            width: 180px;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.08);
            padding: 4px 8px;
        }

        .vp-logo-image {
            display: block;
            max-width: 100%;
            max-height: 36px;
            object-fit: contain;
        }

        .vp-logo-fallback {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #1d2f68;
            font-size: 16px;
        }

        .vp-location-time {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .vp-select-location,
        .vp-location-pill,
        .vp-date-pill {
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            height: 34px;
            padding: 0 10px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
        }

        .vp-select-location option {
            color: #1f2d5d;
        }

        .vp-main-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .vp-nav-link {
            color: rgba(255, 255, 255, 0.95);
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 34px;
            padding: 0 12px;
            border-radius: 8px;
            border: 1px solid transparent;
            font-size: 13px;
        }

        .vp-nav-icon-image {
            width: 24px;
            height: 24px;
            object-fit: contain;
            display: inline-block;
            flex-shrink: 0;
        }

        .vp-nav-link.is-active,
        .vp-nav-link:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.24);
        }

        .vp-user-menu {
            position: relative;
        }

        .vp-user-menu summary {
            list-style: none;
            cursor: pointer;
            user-select: none;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 34px;
            padding: 0 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 13px;
        }

        .vp-user-menu summary::-webkit-details-marker {
            display: none;
        }

        .vp-user-menu ul {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            min-width: 180px;
            background: #fff;
            border-radius: 10px;
            padding: 8px;
            margin: 0;
            list-style: none;
            box-shadow: 0 18px 32px rgba(22, 30, 72, 0.35);
            border: 1px solid #e8ebf5;
            z-index: 50;
        }

        .vp-user-menu ul a {
            color: #243054;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
        }

        .vp-user-menu ul a:hover {
            background: #f2f5ff;
        }

        .vp-tile-grid {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .vp-tile-card {
            min-height: 165px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: linear-gradient(140deg, rgba(63, 102, 156, 0.5) 0%, rgba(35, 63, 127, 0.45) 100%);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 14px;
            color: #fff !important;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .vp-tile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(8, 14, 42, 0.38);
            background: linear-gradient(140deg, rgba(77, 118, 175, 0.58) 0%, rgba(44, 74, 143, 0.52) 100%);
        }

        .vp-tile-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #243054;
            background: #f5f7fc;
            font-size: 23px;
            border: 1px solid rgba(23, 37, 73, 0.08);
            box-shadow: 0 8px 14px rgba(14, 27, 62, 0.2);
        }

        .vp-tile-icon-image {
            width: 34px;
            height: 34px;
            object-fit: contain;
            display: block;
        }

        .vp-tile-card h3 {
            margin: 0;
            font-size: 30px;
            line-height: 1.15;
            letter-spacing: 0.2px;
            font-weight: 700;
            text-align: center;
            color: #fff !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
        }

        @media (max-width: 1440px) {
            .vp-tile-card h3 {
                font-size: 26px;
            }
        }

        @media (max-width: 1199px) {
            .vp-tile-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .vp-tile-card h3 {
                font-size: 22px;
            }
        }

        @media (max-width: 991px) {
            #scrollable-container {
                padding: 16px 14px 18px;
            }

            .vp-topbar {
                padding: 10px;
            }

            .vp-tile-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .vp-tile-card {
                min-height: 140px;
            }

            .vp-tile-card h3 {
                font-size: 19px;
            }
        }

        @media (max-width: 640px) {
            .vp-tile-grid {
                grid-template-columns: 1fr;
            }

            .vp-logo-wrap {
                width: 140px;
            }

            .vp-main-nav {
                width: 100%;
            }

            .vp-nav-link {
                flex: 1;
                justify-content: center;
                min-width: 80px;
            }
        }
    </style>
@endsection
