@php
    $staticFallbackSidebarItems = [
        ['label' => 'Register', 'url' => action([\App\Http\Controllers\SellPosController::class, 'create']), 'is_active' => request()->segment(1) == 'pos'],
        ['label' => 'Sales', 'url' => action([\App\Http\Controllers\SellController::class, 'index']), 'is_active' => request()->segment(1) == 'sells'],
        ['label' => 'Products', 'url' => action([\App\Http\Controllers\ProductController::class, 'index']), 'is_active' => request()->segment(1) == 'products'],
        ['label' => 'Users', 'url' => action([\App\Http\Controllers\ManageUserController::class, 'index']), 'is_active' => request()->segment(1) == 'users'],
        ['label' => 'Contacts', 'url' => action([\App\Http\Controllers\ContactController::class, 'index']) . '?type=supplier', 'is_active' => request()->segment(1) == 'contacts'],
        ['label' => 'Purchases', 'url' => action([\App\Http\Controllers\PurchaseController::class, 'index']), 'is_active' => request()->segment(1) == 'purchases'],
        ['label' => 'Stock Transfer', 'url' => action([\App\Http\Controllers\StockTransferController::class, 'index']), 'is_active' => request()->segment(1) == 'stock-transfers'],
        ['label' => 'Stock Adjustment', 'url' => action([\App\Http\Controllers\StockAdjustmentController::class, 'index']), 'is_active' => request()->segment(1) == 'stock-adjustments'],
        ['label' => 'Expenses', 'url' => action([\App\Http\Controllers\ExpenseController::class, 'index']), 'is_active' => request()->segment(1) == 'expenses'],
        ['label' => 'Gift Cards', 'url' => action([\App\Http\Controllers\GiftCardController::class, 'index']), 'is_active' => request()->segment(1) == 'gift-cards'],
        ['label' => 'Promotions', 'url' => action([\App\Http\Controllers\PromotionController::class, 'index']), 'is_active' => request()->segment(1) == 'promotions'],
        ['label' => 'Loyalty Tiers', 'url' => action([\App\Http\Controllers\LoyaltyTierController::class, 'index']), 'is_active' => request()->segment(1) == 'loyalty-tiers'],
        ['label' => 'Loyalty Analytics', 'url' => action([\App\Http\Controllers\LoyaltyAnalyticsController::class, 'index']), 'is_active' => request()->segment(1) == 'reports' && request()->segment(2) == 'loyalty-analytics'],
        ['label' => 'Reports', 'url' => action([\App\Http\Controllers\ReportController::class, 'getProfitLoss']), 'is_active' => request()->segment(1) == 'reports'],
        ['label' => 'Settings', 'url' => action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']), 'is_active' => request()->segment(1) == 'business'],
        ['label' => 'Notifications', 'url' => action([\App\Http\Controllers\NotificationTemplateController::class, 'index']), 'is_active' => request()->segment(1) == 'notification-templates'],
    ];

    $iconByUrl = static function ($url) {
        $map = [
            '/pos/create' => 'images/dashboard-icons/register.png',
            '/sells' => 'images/dashboard-icons/sales.png',
            '/products' => 'images/dashboard-icons/products.png',
            '/users' => 'images/dashboard-icons/users.png',
            '/contacts' => 'images/dashboard-icons/contacts.png',
            '/purchases' => 'images/dashboard-icons/purchases.png',
            '/stock-transfers' => 'images/dashboard-icons/stock-transfer.png',
            '/stock-adjustments' => 'images/dashboard-icons/stock-adjustment.png',
            '/expenses' => 'images/dashboard-icons/expense.png',
            '/gift-cards' => 'images/dashboard-icons/sales.png',
            '/promotions' => 'images/dashboard-icons/sales.png',
            '/loyalty-tiers' => 'images/dashboard-icons/contacts.png',
            '/reports/loyalty-analytics' => 'images/dashboard-icons/reports.png',
            '/reports' => 'images/dashboard-icons/reports.png',
            '/business' => 'images/dashboard-icons/settings.png',
            '/notification-templates' => 'images/dashboard-icons/notifications.png',
        ];

        foreach ($map as $needle => $icon) {
            if (\Illuminate\Support\Str::contains($url, $needle)) {
                // Root-relative paths break on nested routes (e.g. /pos/create → /pos/images/...).
                if (file_exists(public_path($icon))) {
                    return asset($icon);
                }

                return null;
            }
        }

        return null;
    };

    $dynamicSidebarTree = [];
    try {
        $menuBuilder = \Menu::instance('admin-sidebar-menu');
        if ($menuBuilder && method_exists($menuBuilder, 'getOrderedItems')) {
            $buildTree = function ($menuItems) use (&$buildTree, $iconByUrl) {
                $nodes = [];
                foreach ($menuItems as $menuItem) {
                    if (!is_object($menuItem) || !method_exists($menuItem, 'hidden') || $menuItem->hidden()) {
                        continue;
                    }
                    if ((method_exists($menuItem, 'isDivider') && $menuItem->isDivider())
                        || (method_exists($menuItem, 'isHeader') && $menuItem->isHeader())) {
                        continue;
                    }

                    $label = trim(strip_tags((string) ($menuItem->title ?? '')));
                    if ($label === '') {
                        continue;
                    }

                    $url = method_exists($menuItem, 'getUrl') ? (string) $menuItem->getUrl() : '';
                    $hasChildren = method_exists($menuItem, 'hasChilds') ? (bool) $menuItem->hasChilds() : false;
                    $childItems = ($hasChildren && method_exists($menuItem, 'getChilds')) ? $menuItem->getChilds() : [];
                    $children = !empty($childItems) ? $buildTree($childItems) : [];

                    $isActive = method_exists($menuItem, 'isActive') && $menuItem->isActive();
                    $isChildActive = method_exists($menuItem, 'hasActiveOnChild') && $menuItem->hasActiveOnChild();
                    $branchActive = $isActive || $isChildActive;

                    $isPlaceholderUrl = $url === ''
                        || $url === '#'
                        || \Illuminate\Support\Str::endsWith($url, '/#')
                        || \Illuminate\Support\Str::endsWith($url, '#');

                    $nodes[] = [
                        'label' => $label,
                        'url' => (!$isPlaceholderUrl) ? $url : null,
                        'children' => $children,
                        'is_active' => $isActive,
                        'is_child_active' => $isChildActive,
                        'branch_active' => $branchActive,
                        'icon' => $iconByUrl($url),
                    ];
                }

                return $nodes;
            };

            $dynamicSidebarTree = $buildTree($menuBuilder->getOrderedItems());
        }
    } catch (\Throwable $e) {
        $dynamicSidebarTree = [];
    }

    if (!empty($dynamicSidebarTree)) {
        $sidebarTree = $dynamicSidebarTree;
    } else {
        $sidebarTree = [];
        foreach ($staticFallbackSidebarItems as $staticItem) {
            $sidebarTree[] = [
                'label' => $staticItem['label'],
                'url' => $staticItem['url'],
                'children' => [],
                'is_active' => $staticItem['is_active'] ?? false,
                'is_child_active' => false,
                'branch_active' => (bool) ($staticItem['is_active'] ?? false),
                'icon' => $iconByUrl($staticItem['url'] ?? ''),
            ];
        }
    }

@endphp
<aside class="side-bar vp-custom-sidebar" id="vp-custom-sidebar" data-sidebar-tree='@json($sidebarTree)'>
    <div class="vp-custom-sidebar-inner" id="vp-custom-sidebar-root"></div>
</aside>
<script>
    (function () {
        var branchSeq = 0;
        var root = document.getElementById('vp-custom-sidebar-root');
        var aside = document.getElementById('vp-custom-sidebar');
        if (!root || !aside) {
            return;
        }

        var tree = [];
        try {
            tree = JSON.parse(aside.getAttribute('data-sidebar-tree') || '[]') || [];
        } catch (e) {
            tree = [];
        }

        function esc(s) {
            return String(s == null ? '' : s)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function iconImgHtml(iconPath, label) {
            if (!iconPath) {
                return '';
            }
            return (
                '<span class="vp-sidebar-item-icon">' +
                '<img src="' + esc(iconPath) + '" alt="' + esc(label) + ' icon">' +
                '</span>'
            );
        }

        function defaultIconHtml(isSub) {
            return (
                '<span class="vp-sidebar-item-icon">' +
                '<i class="fa ' + (isSub ? 'fa-angle-right' : 'fa-circle') + '"></i>' +
                '</span>'
            );
        }

        /** Icon shown on submenu rows in data — parent uses first direct child's icon. */
        function iconMarkupForMenuNode(n, treatAsSubmenuRow) {
            if (!n) {
                return '';
            }
            var lbl = n.label || '';
            return iconImgHtml(n.icon, lbl) || defaultIconHtml(!!treatAsSubmenuRow);
        }

        function parentBranchIconHtml(node, children) {
            var first = (children && children.length) ? children[0] : null;
            var fromFirst = iconMarkupForMenuNode(first, true);
            if (fromFirst) {
                return fromFirst;
            }
            return iconMarkupForMenuNode(node, false) || (
                '<span class="vp-sidebar-item-icon"><i class="fa fa-folder"></i></span>'
            );
        }

        function renderItems(items, depth) {
            if (!items || !items.length) {
                return '';
            }

            var html = '';
            for (var i = 0; i < items.length; i++) {
                html += renderNode(items[i], depth);
            }
            return html;
        }

        function renderNode(node, depth) {
            var label = node.label || '';
            var url = node.url || '';
            var children = node.children || [];
            var hasChildren = children.length > 0;
            var branchActive = !!node.branch_active;
            var isSub = depth > 0;
            var level = Math.min(depth, 4);

            if (!label) {
                return '';
            }

            if (!hasChildren) {
                if (isSub) {
                    return (
                        '<a href="' + esc(url) + '"' +
                        ' class="vp-sidebar-item vp-sidebar-item-sub' + (node.is_active ? ' is-active' : '') + '"' +
                        ' style="--vp-level: ' + level + ';">' +
                        '<span class="vp-sidebar-item-text">' + esc(label) + '</span>' +
                        '</a>'
                    );
                }
                return (
                    '<a href="' + esc(url) + '"' +
                    ' class="vp-sidebar-item' + (node.is_active ? ' is-active' : '') + '"' +
                    ' style="--vp-level: ' + level + ';">' +
                    (iconImgHtml(node.icon, label) || defaultIconHtml(false)) +
                    '<span class="vp-sidebar-item-label">' + esc(label) + '</span>' +
                    '</a>'
                );
            }

            var open = branchActive ? ' is-open' : '';
            var activeHeader = branchActive ? ' is-active' : '';
            var branchId = 'vp-sidebar-branch-' + (++branchSeq);

            return (
                '<div class="vp-sidebar-branch" data-vp-sidebar-branch>' +
                '<button type="button" class="vp-sidebar-item vp-sidebar-item-parent' + activeHeader + open + '"' +
                ' style="--vp-level: ' + level + ';"' +
                ' aria-expanded="' + (branchActive ? 'true' : 'false') + '"' +
                ' aria-controls="' + esc(branchId) + '"' +
                ' data-vp-sidebar-toggle>' +
                parentBranchIconHtml(node, children) +
                '<span class="vp-sidebar-item-label">' + esc(label) + '</span>' +
                '<span class="vp-sidebar-chevron" aria-hidden="true"><i class="fa fa-angle-down"></i></span>' +
                '</button>' +
                '<div class="vp-sidebar-children" id="' + esc(branchId) + '"' +
                (branchActive ? '' : ' hidden') + ' data-vp-sidebar-children>' +
                renderItems(children, depth + 1) +
                '</div>' +
                '</div>'
            );
        }

        root.innerHTML = renderItems(tree, 0);

        root.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-vp-sidebar-toggle]');
            if (!btn || !root.contains(btn)) {
                return;
            }

            var branch = btn.closest('[data-vp-sidebar-branch]');
            if (!branch) {
                return;
            }

            var panel = branch.querySelector('[data-vp-sidebar-children]');
            if (!panel) {
                return;
            }

            var willOpen = btn.classList.contains('is-open') ? false : true;

            // Accordion: close sibling branches at the same nesting level
            var parentChildren = branch.parentElement;
            if (parentChildren) {
                var siblings = parentChildren.querySelectorAll(':scope > [data-vp-sidebar-branch]');
                for (var i = 0; i < siblings.length; i++) {
                    var sib = siblings[i];
                    if (sib === branch) {
                        continue;
                    }
                    var sibBtn = sib.querySelector('[data-vp-sidebar-toggle]');
                    var sibPanel = sib.querySelector('[data-vp-sidebar-children]');
                    if (sibBtn) {
                        sibBtn.classList.remove('is-open');
                        sibBtn.setAttribute('aria-expanded', 'false');
                    }
                    if (sibPanel) {
                        sibPanel.setAttribute('hidden', 'hidden');
                    }
                }
            }

            if (willOpen) {
                btn.classList.add('is-open');
                btn.setAttribute('aria-expanded', 'true');
                panel.removeAttribute('hidden');
            } else {
                btn.classList.remove('is-open');
                btn.setAttribute('aria-expanded', 'false');
                panel.setAttribute('hidden', 'hidden');
            }
        });
    })();
</script>
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
        background: #f4f4f7 !important;
        box-shadow: 12px 0 28px rgba(17, 24, 53, 0.22);
        border-radius: 0 14px 14px 0;
        overflow-y: auto;
    }

    .vp-custom-sidebar-inner {
        padding: 16px 14px 20px;
    }

    /* Top-level single links: light “card” */
    .vp-sidebar-item:not(.vp-sidebar-item-sub):not(.vp-sidebar-item-parent) {
        min-height: 56px;
        margin-bottom: 10px;
        border-radius: 12px;
        background: #ececf1;
        color: #272e74 !important;
        font-size: 16px;
        font-weight: 600;
        gap: 14px;
        display: flex;
        align-items: center;
        padding: 10px 14px;
        text-decoration: none !important;
        transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
        border: 1px solid rgba(23, 37, 73, 0.06);
        box-shadow: 0 4px 12px rgba(15, 25, 60, 0.1);
    }

    .vp-sidebar-item:not(.vp-sidebar-item-sub):not(.vp-sidebar-item-parent):hover {
        background: #e2e3ea;
        color: #212867 !important;
        box-shadow: 0 6px 16px rgba(15, 25, 60, 0.12);
    }

    .vp-sidebar-item.vp-sidebar-item-group {
        min-height: 48px;
        margin-bottom: 10px;
        border-radius: 12px;
        padding: 10px 14px;
        background: #d9dbe4;
        color: #20285f !important;
        cursor: default;
        border: 1px solid rgba(23, 37, 73, 0.08);
        box-shadow: 0 2px 8px rgba(15, 25, 60, 0.08);
    }

    /* Expandable parent: same light row as other items — color only on the icon tile */
    .vp-sidebar-item.vp-sidebar-item-parent {
        width: 100%;
        min-height: 56px;
        margin-bottom: 0;
        border-radius: 12px;
        text-align: left;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        font: inherit;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        margin-bottom: 8px;
        background: #ececf1;
        color: #272e74 !important;
        border: 1px solid rgba(23, 37, 73, 0.06);
        box-shadow: 0 4px 12px rgba(15, 25, 60, 0.1);
        transition: background 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
    }

    .vp-sidebar-item.vp-sidebar-item-parent:hover {
        background: #e2e3ea;
        color: #212867 !important;
        box-shadow: 0 6px 16px rgba(15, 25, 60, 0.12);
    }

    .vp-sidebar-item.vp-sidebar-item-parent.is-open {
        border-color: rgba(44, 51, 94, 0.14);
    }

    .vp-sidebar-item.vp-sidebar-item-parent .vp-sidebar-item-label {
        color: #272e74 !important;
        font-weight: 700;
        font-size: 16px;
    }

    .vp-sidebar-item.vp-sidebar-item-parent .vp-sidebar-item-icon {
        background: linear-gradient(160deg, #3a4570 0%, #2c335e 100%);
        border: 1px solid rgba(0, 0, 0, 0.12);
        box-shadow: 0 4px 12px rgba(44, 51, 94, 0.35);
        color: #fff;
    }

    .vp-sidebar-item.vp-sidebar-item-parent .vp-sidebar-item-icon i {
        color: #fff;
    }

    .vp-sidebar-item.vp-sidebar-item-parent .vp-sidebar-item-icon img {
        opacity: 0.95;
        filter: brightness(0) invert(1);
    }

    .vp-sidebar-item.vp-sidebar-item-parent .vp-sidebar-chevron {
        margin-left: auto;
        color: #2c335e;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: #f5f7fc;
        border: 1px solid rgba(44, 51, 94, 0.12);
        box-shadow: 0 2px 6px rgba(15, 25, 60, 0.08);
    }

    .vp-sidebar-item-parent.is-open .vp-sidebar-chevron i {
        transform: rotate(180deg);
    }

    .vp-sidebar-chevron i {
        transition: transform 0.15s ease;
    }

    .vp-sidebar-children {
        margin: 0 0 14px;
        padding: 4px 2px 2px 6px;
    }

    /* Submenu: text only, card rows */
    .vp-sidebar-item.vp-sidebar-item-sub {
        min-height: 46px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        border-radius: 10px;
        background: #fff !important;
        color: #4a5380 !important;
        padding: 10px 14px 10px 16px;
        border: 1px solid rgba(44, 51, 94, 0.08);
        box-shadow: 0 2px 10px rgba(15, 25, 60, 0.08);
        gap: 0;
        display: flex;
        align-items: center;
        text-decoration: none !important;
        transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
    }

    .vp-sidebar-item.vp-sidebar-item-sub:hover {
        background: #f6f7fa !important;
        color: #2c335e !important;
    }

    .vp-sidebar-item.vp-sidebar-item-sub .vp-sidebar-item-text {
        flex: 1;
        line-height: 1.35;
    }

    .vp-sidebar-item.vp-sidebar-item-sub.is-active {
        background: #e2e4e9 !important;
        color: #2c335e !important;
        border-color: rgba(44, 51, 94, 0.14);
        box-shadow: 0 2px 8px rgba(15, 25, 60, 0.06);
    }

    /* Active top-level leaf */
    .vp-sidebar-item:not(.vp-sidebar-item-parent):not(.vp-sidebar-item-sub).is-active {
        background: #d7d9e5;
        border-color: rgba(39, 48, 111, 0.18);
        color: #1b2259 !important;
    }

    .vp-sidebar-item-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 10px;
        background: #f5f7fc;
        border: 1px solid rgba(23, 37, 73, 0.1);
        box-shadow: 0 4px 10px rgba(15, 25, 60, 0.15);
        color: #27306f;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .vp-sidebar-item-icon img {
        width: 20px;
        height: 20px;
        object-fit: contain;
        display: block;
    }

    .vp-sidebar-item-icon i {
        font-size: 14px;
    }

    .side-bar.small-view-side-active.vp-custom-sidebar {
        display: block !important;
    }
</style>
