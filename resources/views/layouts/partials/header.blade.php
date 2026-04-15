@inject('request', 'Illuminate\Http\Request')
@php
    $business = session('business');
    $locations = $all_locations ?? [];
    if (empty($locations) && !empty(session('user.business_id'))) {
        try {
            $locations = \App\BusinessLocation::forDropdown(session('user.business_id'))->toArray();
        } catch (\Exception $e) {
            $locations = [];
        }
    }
    $currentLocation = count($locations) ? array_key_first($locations) : null;

    $logoPath = null;
    if (file_exists(public_path('uploads/logo.png'))) {
        $logoPath = asset('uploads/logo.png');
    } elseif (!empty($business['logo']) && file_exists(public_path('uploads/business_logos/' . $business['logo']))) {
        $logoPath = asset('uploads/business_logos/' . $business['logo']);
    } elseif (file_exists(public_path('img/logo-small.png'))) {
        $logoPath = asset('img/logo-small.png');
    }
    $locationIconPath = file_exists(public_path('images/dashboard-icons/nav/location.png'))
        ? asset('images/dashboard-icons/nav/location.png')
        : null;
    $sidebarToggleIconPath = file_exists(public_path('images/dashboard-icons/nav/sidebar-toggle.png'))
        ? asset('images/dashboard-icons/nav/sidebar-toggle.png')
        : null;

    $user = auth()->user();
    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
    if (empty($fullName)) {
        $fullName = 'Admin';
    }
    $userAvatar = !empty($user->media) && !empty($user->media->display_url)
        ? $user->media->display_url
        : 'https://ui-avatars.com/api/?name=' . urlencode($fullName);

    $segment1 = $request->segment(1);
    $isHomeDashboardHeader = $segment1 === 'home' && empty($request->segment(2));
    $topNav = [
        ['label' => 'Home', 'url' => action([\App\Http\Controllers\HomeController::class, 'index']), 'active' => $segment1 === 'home', 'icon_path' => 'images/dashboard-icons/nav/home.png', 'fallback_icon' => 'fa-home'],
        ['label' => 'Sales', 'url' => action([\App\Http\Controllers\SellController::class, 'index']), 'active' => in_array($segment1, ['sells', 'sell']), 'icon_path' => 'images/dashboard-icons/nav/sales.png', 'fallback_icon' => 'fa-bar-chart'],
        ['label' => 'Products', 'url' => action([\App\Http\Controllers\ProductController::class, 'index']), 'active' => $segment1 === 'products', 'icon_path' => 'images/dashboard-icons/nav/products.png', 'fallback_icon' => 'fa-cubes'],
        ['label' => 'Settings', 'url' => action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']), 'active' => in_array($segment1, ['business', 'invoice-layouts', 'invoice-schemes', 'tax-rates']), 'icon_path' => 'images/dashboard-icons/nav/settings.png', 'fallback_icon' => 'fa-cog'],
    ];
@endphp

<div class="vp-global-header no-print">
    <div class="vp-global-inner">
        <div class="vp-global-left">
            @if (!$isHomeDashboardHeader)
                <button type="button" class="small-view-button vp-side-btn">
                    <span class="tw-sr-only">Sidebar Menu</span>
                    @if (!empty($sidebarToggleIconPath))
                        <img src="{{ $sidebarToggleIconPath }}" alt="Sidebar menu" class="vp-side-btn-icon-image">
                    @else
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    @endif
                </button>
            @endif

            <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-global-logo-wrap">
                @if (!empty($logoPath))
                    <img src="{{ $logoPath }}" alt="POS Logo" class="vp-global-logo-image">
                @else
                    <span class="vp-global-logo-fallback"><i class="fa fa-home"></i></span>
                @endif
            </a>

            <div class="vp-global-meta">
                @if (count($locations) > 1)
                    <div class="vp-global-location-wrap">
                        @if (!empty($locationIconPath))
                            <img src="{{ $locationIconPath }}" alt="Location icon" class="vp-global-location-icon-image">
                        @else
                            <i class="fa fa-map-marker vp-global-location-fallback-icon" aria-hidden="true"></i>
                        @endif
                        {!! Form::select('dashboard_location_mirror', $locations, $currentLocation, ['class' => 'vp-global-select vp-global-select-location']) !!}
                    </div>
                @elseif (count($locations) === 1)
                    <span class="vp-global-pill vp-global-location-pill">
                        @if (!empty($locationIconPath))
                            <img src="{{ $locationIconPath }}" alt="Location icon" class="vp-global-location-icon-image">
                        @else
                            <i class="fa fa-map-marker vp-global-location-fallback-icon" aria-hidden="true"></i>
                        @endif
                        <span>{{ reset($locations) }}</span>
                    </span>
                @endif
                <span class="vp-global-pill">{{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="vp-global-right">
            <nav class="vp-global-nav">
                @foreach ($topNav as $item)
                    <a href="{{ $item['url'] }}" class="vp-global-nav-link {{ $item['active'] ? 'is-active' : '' }}">
                        @if (!empty($item['icon_path']) && file_exists(public_path($item['icon_path'])))
                            <img src="{{ asset($item['icon_path']) }}" alt="{{ $item['label'] }} icon" class="vp-global-nav-icon-image">
                        @else
                            <i class="fa {{ $item['fallback_icon'] }}"></i>
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <details class="vp-admin-menu">
                <summary>
                    <span class="vp-admin-avatar-wrap">
                        <img src="{{ $userAvatar }}" alt="{{ $fullName }}" class="vp-admin-avatar">
                    </span>
                    <span class="vp-admin-text">
                        <strong>{{ $fullName }}</strong>
                        <small>{{ $user->email ?? '' }}</small>
                    </span>
                    <i class="fa fa-angle-down"></i>
                </summary>

                <ul>
                    <li>
                        <a href="{{ action([\App\Http\Controllers\UserController::class, 'getProfile']) }}">
                            <i class="fa fa-user"></i>
                            <span>@lang('lang_v1.profile')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'logout']) }}">
                            <i class="fa fa-sign-out"></i>
                            <span>@lang('lang_v1.sign_out')</span>
                        </a>
                    </li>
                </ul>
            </details>
        </div>
    </div>
</div>

<style>
    .vp-global-header {
        margin: 22px 26px 0;
        padding: 10px 12px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        border-radius: 10px;
        background: linear-gradient(90deg, rgba(24, 35, 80, 0.95) 0%, rgba(35, 49, 105, 0.95) 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    body.vp-home-dashboard .vp-global-header {
        margin: 22px 26px 0;
    }

    .vp-global-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .vp-global-left,
    .vp-global-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vp-side-btn {
        width: 34px;
        height: 34px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .vp-side-btn-icon-image {
        width: 20px;
        height: 20px;
        object-fit: contain;
        display: block;
    }

    .vp-global-logo-wrap {
        width: 186px;
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.09);
        padding: 4px 10px;
    }

    .vp-global-logo-image {
        display: block;
        max-width: 100%;
        max-height: 32px;
        object-fit: contain;
    }

    .vp-global-logo-fallback {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #fff;
        color: #1d2f68;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .vp-global-meta {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vp-global-location-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .vp-global-select,
    .vp-global-pill {
        height: 34px;
        padding: 0 10px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        display: inline-flex;
        align-items: center;
        font-size: 13px;
    }

    .vp-global-select-location {
        padding-left: 38px !important;
        min-width: 250px;
    }

    .vp-global-location-pill {
        gap: 8px;
        min-width: 250px;
        justify-content: flex-start;
    }

    .vp-global-location-icon-image {
        width: 20px;
        height: 20px;
        object-fit: contain;
        display: inline-block;
        flex-shrink: 0;
    }

    .vp-global-location-wrap .vp-global-location-icon-image,
    .vp-global-location-wrap .vp-global-location-fallback-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        pointer-events: none;
    }

    .vp-global-location-fallback-icon {
        font-size: 18px;
        color: rgba(255, 255, 255, 0.95);
    }

    .vp-global-select option {
        color: #1f2d5d;
    }

    .vp-global-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .vp-global-nav-link {
        height: 40px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0 14px;
        border-radius: 8px;
        border: 1px solid transparent;
        text-decoration: none !important;
        color: rgba(255, 255, 255, 0.95);
        font-size: 15px;
        font-weight: 600;
    }

    .vp-global-nav-link.is-active,
    .vp-global-nav-link:hover {
        background: rgba(255, 255, 255, 0.14);
        border-color: rgba(255, 255, 255, 0.25);
        color: #fff;
    }

    .vp-global-nav-icon-image {
        width: 24px;
        height: 24px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .vp-admin-menu {
        position: relative;
        margin-left: 8px;
        padding-left: 10px;
        border-left: 1px solid rgba(255, 255, 255, 0.5);
    }

    .vp-admin-menu summary {
        list-style: none;
        cursor: pointer;
        min-width: 270px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 6px 10px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: #fff;
    }

    .vp-admin-menu summary::-webkit-details-marker {
        display: none;
    }

    .vp-admin-avatar-wrap {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid rgba(255, 255, 255, 0.25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .vp-admin-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .vp-admin-text {
        display: flex;
        flex-direction: column;
        min-width: 0;
        flex: 1;
        line-height: 1.2;
    }

    .vp-admin-text strong {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .vp-admin-text small {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.95);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .vp-admin-menu > summary > i {
        font-size: 20px;
        flex-shrink: 0;
    }

    .vp-admin-menu ul {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 220px;
        margin: 0;
        padding: 8px;
        list-style: none;
        border-radius: 10px;
        border: 1px solid #d8dbef;
        background: #fff;
        box-shadow: 0 18px 32px rgba(22, 30, 72, 0.35);
        z-index: 1000;
    }

    .vp-admin-menu ul a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 10px;
        border-radius: 8px;
        text-decoration: none !important;
        color: #2d3961;
        font-weight: 600;
        font-size: 14px;
    }

    .vp-admin-menu ul a:hover {
        background: #f1f4ff;
    }

    @media (max-width: 1024px) {
        .vp-global-nav-link {
            height: 36px;
            padding: 0 10px;
            font-size: 14px;
        }

        .vp-admin-menu summary {
            min-width: 220px;
        }

        .vp-admin-text strong {
            font-size: 16px;
        }

        .vp-admin-text small {
            font-size: 13px;
        }
    }

    @media (max-width: 768px) {
        .vp-global-header {
            margin: 14px 12px 0;
        }

        .vp-global-inner {
            align-items: flex-start;
        }

        .vp-global-right {
            width: 100%;
            justify-content: space-between;
        }

        .vp-global-nav {
            flex: 1;
        }

        .vp-admin-menu {
            margin-left: auto;
        }
    }
</style>
