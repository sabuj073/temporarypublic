@php
    $sidebarItems = [
        ['label' => 'Register', 'url' => action([\App\Http\Controllers\CashRegisterController::class, 'index']), 'icon_path' => 'images/dashboard-icons/register.png'],
        ['label' => 'Sales', 'url' => action([\App\Http\Controllers\SellController::class, 'index']), 'icon_path' => 'images/dashboard-icons/sales.png'],
        ['label' => 'Products', 'url' => action([\App\Http\Controllers\ProductController::class, 'index']), 'icon_path' => 'images/dashboard-icons/products.png'],
        ['label' => 'Users', 'url' => action([\App\Http\Controllers\ManageUserController::class, 'index']), 'icon_path' => 'images/dashboard-icons/users.png'],
        ['label' => 'Contacts', 'url' => action([\App\Http\Controllers\ContactController::class, 'index']) . '?type=supplier', 'icon_path' => 'images/dashboard-icons/contacts.png'],
        ['label' => 'Purchases', 'url' => action([\App\Http\Controllers\PurchaseController::class, 'index']), 'icon_path' => 'images/dashboard-icons/purchases.png'],
        ['label' => 'Stock Transfer', 'url' => action([\App\Http\Controllers\StockTransferController::class, 'index']), 'icon_path' => 'images/dashboard-icons/stock-transfer.png'],
        ['label' => 'Stock Adjustment', 'url' => action([\App\Http\Controllers\StockAdjustmentController::class, 'index']), 'icon_path' => 'images/dashboard-icons/stock-adjustment.png'],
        ['label' => 'Expenses', 'url' => action([\App\Http\Controllers\ExpenseController::class, 'index']), 'icon_path' => 'images/dashboard-icons/expense.png'],
        ['label' => 'Reports', 'url' => action([\App\Http\Controllers\ReportController::class, 'getProfitLoss']), 'icon_path' => 'images/dashboard-icons/reports.png'],
        ['label' => 'Settings', 'url' => action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']), 'icon_path' => 'images/dashboard-icons/settings.png'],
        ['label' => 'Notifications', 'url' => action([\App\Http\Controllers\NotificationTemplateController::class, 'index']), 'icon_path' => 'images/dashboard-icons/notifications.png'],
    ];
@endphp
<aside class="side-bar vp-custom-sidebar">
    <div class="vp-custom-sidebar-inner">
        @foreach ($sidebarItems as $item)
            <a href="{{ $item['url'] }}" class="vp-sidebar-item">
                <span class="vp-sidebar-item-icon">
                    @if (!empty($item['icon_path']) && file_exists(public_path($item['icon_path'])))
                        <img src="{{ asset($item['icon_path']) }}" alt="{{ $item['label'] }} icon">
                    @else
                        <i class="fa fa-circle"></i>
                    @endif
                </span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</aside>
<style>
    .vp-custom-sidebar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 320px;
        max-width: calc(100vw - 30px);
        z-index: 1100;
        background: #efeff3 !important;
        box-shadow: 12px 0 28px rgba(17, 24, 53, 0.32);
        border-radius: 0 14px 14px 0;
        overflow-y: auto;
    }

    .vp-custom-sidebar-inner {
        padding: 16px 14px 20px;
    }

    .vp-sidebar-item {
        min-height: 56px;
        margin-bottom: 10px;
        border-radius: 8px;
        background: #e5e5ea;
        color: #272e74 !important;
        font-size: 16px;
        font-weight: 600;
        gap: 14px;
        display: flex;
        align-items: center;
        padding: 8px 12px;
        text-decoration: none !important;
    }

    .vp-sidebar-item:hover {
        background: #ddddE4;
        color: #212867 !important;
    }

    .vp-sidebar-item-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 10px;
        background: #f5f7fc;
        border: 1px solid rgba(23, 37, 73, 0.1);
        box-shadow: 0 4px 10px rgba(15, 25, 60, 0.15);
        color: #27306f;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .vp-sidebar-item-icon img {
        width: 20px;
        height: 20px;
        object-fit: contain;
        display: block;
    }

    .vp-sidebar-item-icon i {
        font-size: 13px;
    }

    .side-bar.small-view-side-active.vp-custom-sidebar {
        display: block !important;
    }
</style>
