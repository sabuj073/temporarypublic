        body.vp-pos-page .vp-global-header {
            margin: 8px 26px 6px !important;
        }

        body.vp-pos-page .content.vp-pos-redesign {
            padding: 0 26px 8px;
            background: transparent !important;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }

        body.vp-pos-page .content.vp-pos-redesign > form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }

        body.vp-pos-page .vp-pos-page-root-row {
            flex: 1 1 auto;
            min-height: 0;
            margin-bottom: 0 !important;
            display: flex;
            flex-direction: column;
        }

        body.vp-pos-page .vp-pos-page-root-row > .col-md-12 {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
        }

        body.vp-pos-page .vp-pos-main-row {
            flex: 1 1 auto;
            min-height: 0;
        }

        body.vp-pos-page .vp-pos-browse-shell {
            border-radius: 20px !important;
            border: 1px solid rgba(255, 255, 255, 0.22) !important;
            background: linear-gradient(160deg, rgba(18, 28, 58, 0.92) 0%, rgba(28, 42, 88, 0.88) 45%, rgba(16, 24, 48, 0.95) 100%) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 16px 40px rgba(5, 10, 35, 0.35) !important;
            padding: 12px 14px 14px;
        }

        body.vp-pos-page .vp-pos-cart-shell {
            border-radius: 20px !important;
            border: 1px solid #e2e8f0 !important;
            background: #fff !important;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12) !important;
            padding: 0 !important;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        body.vp-pos-page .vp-pos-cart-shell > .box-body {
            padding: 0 !important;
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Bootstrap .row negative margin + overflow:hidden clips table/summary on the left */
        body.vp-pos-page .vp-pos-cart-shell > .box-body > .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        body.vp-pos-page .vp-pos-cart-panel-inner {
            padding: 10px 12px 10px;
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Global POS app.css pins .pos-form-actions to viewport bottom — undo for redesign */
        body.vp-pos-page .pos-form-actions {
            position: static !important;
            bottom: auto !important;
            left: auto !important;
            right: auto !important;
            width: auto !important;
            max-width: 100% !important;
            z-index: auto !important;
        }

        /* Compact typography for this POS page */
        body.vp-pos-page .vp-pos-browse-shell,
        body.vp-pos-page .vp-pos-cart-shell,
        body.vp-pos-page .pos-form-actions {
            font-size: 12px;
        }

        body.vp-pos-page .vp-pos-cart-panel-inner[data-active-tab="orders"] .vp-pos-customer-block,
        body.vp-pos-page .vp-pos-cart-panel-inner[data-active-tab="tables"] .vp-pos-customer-block {
            display: none !important;
        }

        body.vp-pos-page .vp-pos-cart-panel-inner[data-active-tab="customers"] .pos_product_div,
        body.vp-pos-page .vp-pos-cart-panel-inner[data-active-tab="customers"] .pos_form_totals {
            display: none !important;
        }

        body.vp-pos-page .vp-pos-cart-col.is-customers-tab .pos-form-actions {
            display: none !important;
        }

        body.vp-pos-page .vp-pos-products-col {
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 0;
        }

        body.vp-pos-page .vp-pos-cart-col {
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 0;
        }

        /* Desktop + tablet landscape: same two-pane layout as wide screens (Tailwind lg starts at 1024). */
        @media (min-width: 992px) {
            body.vp-pos-page .vp-pos-main-row {
                display: flex !important;
                flex-direction: row !important;
                align-items: stretch;
                flex-wrap: nowrap;
                max-height: 100%;
            }

            body.vp-pos-page .vp-pos-products-col {
                flex: 0 1 60% !important;
                max-width: 60% !important;
                width: auto !important;
                overflow: hidden;
            }

            body.vp-pos-page .vp-pos-cart-col {
                flex: 1 1 0 !important;
                max-width: none !important;
                width: auto !important;
            }
        }

        /* Actions live inside the same white card as totals (create POS) */
        body.vp-pos-page .vp-pos-cart-shell .pos-form-actions,
        body.vp-pos-page .vp-pos-cart-shell .vp-pos-actions-embed {
            flex-shrink: 0;
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            border-top: 1px solid #e8edf8;
            margin-top: 0 !important;
            padding: 10px 12px 12px !important;
        }

        body.vp-pos-page .vp-pos-cart-shell .vp-pos-actions-embed-row {
            margin-bottom: 0 !important;
        }

        body.vp-pos-page .vp-pos-cart-shell > .box-body > .row:last-of-type {
            flex-shrink: 0;
        }

        body.vp-pos-page .vp-pos-cart-shell > .box-body > .row:last-of-type > div {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            float: none !important;
        }

        body.vp-pos-page .vp-pos-cart-col > .pos-form-actions {
            flex-shrink: 0;
            margin-top: 6px;
        }

        body.vp-pos-page .vp-pos-products-col .vp-pos-browse-shell {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        body.vp-pos-page .vp-pos-products-col .box-body,
        body.vp-pos-page .vp-pos-products-col #product_div,
        body.vp-pos-page .vp-pos-browse-shell #product_list_body {
            background: transparent !important;
        }

        body.vp-pos-page .vp-pos-browse-toolbar {
            display: flex;
            align-items: stretch;
            gap: 10px;
            margin-bottom: 14px;
        }

        body.vp-pos-page .vp-pos-browse-search-host {
            flex: 1 1 auto;
            min-width: 0;
        }

        body.vp-pos-page .vp-pos-browse-search-host .col-md-8 {
            width: 100% !important;
            max-width: 100%;
            flex: 1 1 auto;
            padding-left: 0;
            padding-right: 0;
        }

        body.vp-pos-page .vp-pos-browse-search-host .form-group {
            margin-bottom: 0 !important;
        }

        body.vp-pos-page .vp-pos-browse-search-host .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.12);
        }

        body.vp-pos-page .vp-pos-browse-search-host .form-control,
        body.vp-pos-page .vp-pos-browse-search-host .input-group-addon,
        body.vp-pos-page .vp-pos-browse-search-host .input-group-btn .btn {
            border-color: #e2e8f0 !important;
            background: #fff !important;
        }

        body.vp-pos-page .vp-pos-browse-search-host #search_product {
            border-left: 0 !important;
            font-size: 12px;
        }

        body.vp-pos-page .vp-pos-browse-toolbar-side {
            display: flex;
            align-items: stretch;
            gap: 8px;
            flex: 0 0 auto;
        }

        body.vp-pos-page .vp-pos-brand-select {
            min-width: 132px;
            max-width: 180px;
            height: 40px;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            background: #fff !important;
            color: #0f172a !important;
            font-weight: 600;
            font-size: 12px;
            padding: 0 10px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.12);
        }

        body.vp-pos-page .vp-pos-text-drawer-link {
            font-size: 12px;
            font-weight: 700;
            color: rgba(248, 250, 252, 0.92);
            text-decoration: underline;
            text-underline-offset: 3px;
            cursor: pointer;
            white-space: nowrap;
            align-self: center;
            margin: 0;
        }

        body.vp-pos-page .vp-pos-browse-toolbar-side .vp-pos-text-drawer-link {
            color: #0f172a;
            align-self: center;
        }

        body.vp-pos-page .vp-pos-text-drawer-link:hover {
            color: #fff;
        }

        body.vp-pos-page .vp-pos-browse-toolbar-side .vp-pos-text-drawer-link:hover {
            color: #2563eb;
        }

        body.vp-pos-page .vp-pos-cart-tabs {
            display: flex;
            align-items: stretch;
            border-bottom: 1px solid #e5e7eb;
            margin: 0 0 12px;
        }

        body.vp-pos-page .vp-pos-cart-tab {
            flex: 1 1 0;
            text-align: center;
            font-size: 9px;
            font-weight: 700;
            color: #64748b;
            padding: 10px 6px 12px;
            border-right: 1px solid #e5e7eb;
            background: #fff;
            border-top: 0;
            border-left: 0;
            border-bottom: 0;
            cursor: pointer;
            user-select: none;
            line-height: 1.2;
        }

        body.vp-pos-page .vp-pos-cart-tab:last-child {
            border-right: 0;
        }

        body.vp-pos-page .vp-pos-cart-tab.is-active {
            color: #1e3a8a;
            box-shadow: inset 0 -3px 0 #2563eb;
        }

        body.vp-pos-page .vp-pos-browse-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
            margin-top: 4px;
        }

        body.vp-pos-page .vp-pos-items-head {
            margin-top: 16px;
        }

        body.vp-pos-page .vp-pos-browse-section-title {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: 0.01em;
        }

        body.vp-pos-page .vp-pos-category-pills-scroll {
            display: flex;
            flex-wrap: nowrap;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 6px;
            margin-bottom: 4px;
            scrollbar-width: thin;
        }

        body.vp-pos-page .vp-pos-category-pill {
            flex: 0 0 auto;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            background: transparent;
            color: #f1f5f9;
            font-weight: 600;
            font-size: 10px;
            padding: 10px 16px 10px;
            line-height: 1.2;
            cursor: pointer;
            white-space: normal;
            min-width: 108px;
            text-align: left;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }

        body.vp-pos-page .vp-pos-category-pill .vp-pos-pill-title {
            font-size: 10px;
            font-weight: 700;
        }

        body.vp-pos-page .vp-pos-category-pill .vp-pos-pill-count {
            font-size: 8px;
            font-weight: 600;
            opacity: 0.88;
        }

        body.vp-pos-page .vp-pos-category-pill:hover {
            border-color: rgba(255, 255, 255, 0.75);
            background: rgba(255, 255, 255, 0.08);
        }

        body.vp-pos-page .vp-pos-category-pill.vp-pos-cat-active {
            background: #fff !important;
            color: #0f172a !important;
            border-color: #fff !important;
        }

        body.vp-pos-page .vp-pos-category-pill.vp-pos-cat-active .vp-pos-pill-count {
            color: #475569 !important;
            opacity: 1;
        }

        body.vp-pos-page .vp-pos-browse-shell .vp-pos-product-grid-row {
            margin-left: 0;
            margin-right: 0;
        }

        body.vp-pos-page .vp-pos-browse-shell #product_list_body {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin: 0;
        }

        body.vp-pos-page .vp-pos-browse-shell #product_list_body .product_list {
            float: none !important;
            width: auto !important;
            max-width: none !important;
            padding: 0 !important;
        }

        body.vp-pos-page .vp-pos-browse-shell .product_box {
            display: flex;
            flex-direction: row;
            align-items: stretch;
            gap: 0;
            border: 1px solid #e2e8f0;
            background: #fff;
            border-radius: 20px;
            margin-bottom: 0;
            min-height: 118px;
            text-align: left;
            position: relative;
            padding: 0 48px 0 0;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.1);
        }

        body.vp-pos-page .vp-pos-browse-shell .product_box::after {
            content: "+";
            position: absolute;
            right: 12px;
            bottom: 12px;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid #0f766e;
            background: transparent;
            color: #0f766e;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            line-height: 1;
        }

        body.vp-pos-page .vp-pos-browse-shell .product_box .image-container {
            flex: 0 0 112px;
            width: 112px;
            min-width: 112px;
            min-height: 100%;
            height: auto;
            margin: 0;
            border-radius: 18px 0 0 18px;
            align-self: stretch;
            background-size: cover !important;
            background-position: center center !important;
        }

        body.vp-pos-page .vp-pos-browse-shell .product_box .text_div {
            flex: 1 1 auto;
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 6px;
            padding: 14px 12px 14px 14px;
        }

        body.vp-pos-page .vp-pos-browse-shell .vp-pos-product-title {
            font-size: 10px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
            max-height: 42px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        body.vp-pos-page .vp-pos-browse-shell .vp-pos-product-var {
            font-weight: 600;
            color: #475569;
        }

        body.vp-pos-page .vp-pos-browse-shell .vp-pos-product-price {
            color: #0f766e !important;
            font-weight: 800;
            font-size: 11px !important;
            line-height: 1.1;
        }

        body.vp-pos-page .vp-pos-browse-shell .vp-pos-product-meta {
            font-size: 8px !important;
            color: #64748b !important;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        body.vp-pos-page .vp-pos-cart-shell .form-group .form-control,
        body.vp-pos-page .vp-pos-cart-shell .input-group-addon,
        body.vp-pos-page .vp-pos-cart-shell .input-group-btn .btn {
            border-color: #d9e0f4 !important;
        }

        body.vp-pos-page .vp-pos-cart-shell .form-group .form-control {
            border-radius: 8px !important;
        }

        body.vp-pos-page .vp-pos-cart-shell .box-body > .row:first-of-type .col-md-4 {
            width: 100% !important;
            max-width: 100%;
        }

        body.vp-pos-page .vp-pos-cart-shell #pos_table {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0 !important;
            background: #fff;
            margin-bottom: 10px;
            border-collapse: separate;
            border-spacing: 0;
        }

        body.vp-pos-page .vp-pos-cart-shell #pos_table thead th {
            background: #e3eae6 !important;
            color: #1e293b !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: 1px solid #c9d6d1 !important;
            font-weight: 700;
            font-size: 10px;
            text-transform: none;
            padding: 10px 6px !important;
            line-height: 1.2;
            vertical-align: middle;
            word-wrap: break-word;
        }

        body.vp-pos-page .vp-pos-cart-shell #pos_table tbody td {
            border-left: none !important;
            border-right: none !important;
            border-top: none !important;
            border-bottom: 1px solid #eef2f7 !important;
            font-size: 11px;
            color: #0f172a;
            vertical-align: middle !important;
            padding: 10px 6px !important;
        }

        body.vp-pos-page .vp-pos-cart-shell #pos_table tbody tr:last-child td {
            border-bottom: none !important;
        }

        body.vp-pos-page .vp-pos-cart-shell #pos_table.table-striped > tbody > tr:nth-of-type(odd) > td,
        body.vp-pos-page .vp-pos-cart-shell #pos_table.table-striped > tbody > tr:nth-of-type(even) > td {
            background-color: #fff !important;
        }

        body.vp-pos-page #pos_table .vp-pos-col-action-icon {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 400;
        }

        body.vp-pos-page #pos_table .vp-pos-line-remove {
            font-size: 13px;
            color: #ef4444 !important;
            padding: 5px 7px;
            border: 1px solid #fecaca;
            border-radius: 999px;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            transition: background 0.15s ease;
        }

        body.vp-pos-page #pos_table .vp-pos-line-remove:hover {
            background: #fef2f2;
        }

        body.vp-pos-page .vp-pos-cart-shell .pos_form_totals {
            margin-top: 4px;
        }

        body.vp-pos-page .vp-pos-cart-shell .pos_form_totals table {
            background: #fff;
            border-radius: 10px;
        }

        body.vp-pos-page .vp-pos-cart-shell .pos_form_totals table tr td {
            border-top: 1px solid #e7ecf8 !important;
            color: #24345f;
            font-size: 9px;
        }

        /* Standalone actions bar only (not embedded under totals in create POS) */
        body.vp-pos-page .pos-form-actions:not(.vp-pos-actions-embed) {
            border-radius: 16px !important;
            border: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08) !important;
        }

        body.vp-pos-page .pos-form-actions .tw-text-gray-700,
        body.vp-pos-page .pos-form-actions .tw-text-gray-700 i {
            color: #334155 !important;
        }

        body.vp-pos-page .pos-form-actions .pos-express-finalize[data-pay_method="cash"] {
            background: #16a34a !important;
            border-radius: 12px !important;
        }

        body.vp-pos-page .pos-form-actions .pos-express-finalize[data-pay_method="card"] {
            background: #2563eb !important;
            border-radius: 12px !important;
        }

        body.vp-pos-page .pos-form-actions .pos-express-finalize[data-pay_method="card"] i,
        body.vp-pos-page .pos-form-actions .pos-express-finalize[data-pay_method="cash"] i,
        body.vp-pos-page .pos-form-actions #pos-finalize i {
            color: #fff !important;
        }

        body.vp-pos-page .pos-form-actions #pos-cancel {
            background: #ffe4e6 !important;
            color: #be123c !important;
            border: 1px solid #fda4af !important;
            border-radius: 12px !important;
        }

        body.vp-pos-page .pos-form-actions #pos-cancel i {
            color: #be123c !important;
        }

        body.vp-pos-page .pos-form-actions .pos-total div,
        body.vp-pos-page .pos-form-actions .pos-total span {
            color: #0f172a !important;
        }

        body.vp-pos-page .pos-form-actions #total_payable {
            color: #047857 !important;
        }

        body.vp-pos-page .vp-pos-cart-shell .pos_form_totals table tr td b,
        body.vp-pos-page .vp-pos-cart-shell .pos_form_totals table tr td span,
        body.vp-pos-page .pos-form-actions button,
        body.vp-pos-page .pos-form-actions .pos-total div,
        body.vp-pos-page .pos-form-actions .pos-total span {
            font-size: 9px !important;
        }

        /* Right panel 1:1 style pass */
        body.vp-pos-page .vp-pos-cart-col,
        body.vp-pos-page .vp-pos-cart-shell,
        body.vp-pos-page .vp-pos-cart-panel-inner {
            overflow-x: hidden !important;
        }

        body.vp-pos-page .vp-pos-cart-shell .vp-pos-customer-block .col-md-8 {
            display: none !important;
        }

        body.vp-pos-page .vp-pos-cart-shell .vp-pos-customer-block .col-md-4 {
            width: 100% !important;
            max-width: 100% !important;
        }

        body.vp-pos-page .pos_product_div {
            min-width: 0;
            max-width: 100%;
        }

        body.vp-pos-page #pos_table {
            width: 100%;
            max-width: 100%;
            table-layout: fixed;
        }

        body.vp-pos-page #pos_table tbody {
            counter-reset: posRow;
        }

        body.vp-pos-page #pos_table tbody tr {
            counter-increment: posRow;
        }

        body.vp-pos-page #pos_table thead .vp-pos-col-no,
        body.vp-pos-page #pos_table thead .vp-pos-no-col {
            width: 7%;
            min-width: 28px;
            max-width: 36px;
            text-align: left !important;
            padding: 8px 4px 8px 8px !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-line-no {
            width: 7%;
            min-width: 28px;
            max-width: 36px;
            text-align: left !important;
            padding: 8px 4px 8px 8px !important;
            font-weight: 700;
            color: #0f172a;
            vertical-align: middle !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-line-no::before {
            content: counter(posRow) ".";
        }

        body.vp-pos-page #pos_table thead .vp-pos-col-product {
            width: 26%;
            min-width: 0;
        }

        body.vp-pos-page #pos_table thead .vp-pos-col-qty {
            width: 22%;
            min-width: 0;
        }

        body.vp-pos-page #pos_table thead .vp-pos-col-service {
            width: 14%;
            min-width: 0;
        }

        body.vp-pos-page #pos_table thead .vp-pos-col-price {
            width: 18%;
            min-width: 0;
        }

        body.vp-pos-page #pos_table thead .vp-pos-col-subtotal {
            width: 18%;
            min-width: 0;
        }

        body.vp-pos-page #pos_table thead .vp-pos-col-action {
            width: 9%;
            min-width: 28px;
            max-width: 40px;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-product img,
        body.vp-pos-page #pos_table td.vp-pos-col-product small,
        body.vp-pos-page #pos_table td.vp-pos-col-product .modifiers_html,
        body.vp-pos-page #pos_table td.vp-pos-col-product .lot_number,
        body.vp-pos-page #pos_table td.vp-pos-col-product br,
        body.vp-pos-page #pos_table td.vp-pos-col-product .sub_unit {
            display: none !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-product {
            min-width: 0;
            font-size: 11px !important;
            font-weight: 600;
            line-height: 1.25;
            word-wrap: break-word;
            overflow-wrap: anywhere;
            vertical-align: middle !important;
        }

        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-col-no,
        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-no-col {
            width: 5%;
            min-width: 24px;
            max-width: 32px;
        }

        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-col-product {
            width: 21%;
        }

        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-col-qty {
            width: 14%;
        }

        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-col-service {
            width: 15%;
        }

        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-col-price {
            width: 16%;
        }

        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-col-subtotal {
            width: 16%;
        }

        body.vp-pos-page #pos_table:has(thead .vp-pos-col-service) thead .vp-pos-col-action {
            width: 7%;
            min-width: 26px;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-qty {
            min-width: 0;
            vertical-align: middle !important;
            padding-left: 4px !important;
            padding-right: 4px !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 100%;
            margin: 0;
            position: relative;
            isolation: isolate;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number .input-group-btn {
            position: relative;
            z-index: 2;
            flex-shrink: 0;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number .form-control {
            flex: 1 1 0;
            min-width: 0;
            width: auto !important;
            max-width: none;
            text-align: center;
            font-size: 11px !important;
            font-weight: 700;
            padding: 2px 4px;
            height: 28px;
            line-height: 1.2;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            position: relative;
            z-index: 0;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number .btn {
            flex: 0 0 26px;
            width: 26px;
            min-width: 26px;
            padding: 0;
            height: 26px;
            line-height: 24px;
            border-radius: 999px !important;
            border: 1px solid #cbd5e1 !important;
            background: #fff !important;
            box-shadow: none !important;
            position: relative;
            z-index: 1;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number .btn i {
            font-size: 11px;
            color: #64748b !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-price,
        body.vp-pos-page #pos_table td.vp-pos-col-subtotal {
            min-width: 0;
            vertical-align: middle !important;
            padding-left: 4px !important;
            padding-right: 4px !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-price .pos_unit_price_inc_tax,
        body.vp-pos-page #pos_table td.vp-pos-col-subtotal .pos_line_total,
        body.vp-pos-page #pos_table td.vp-pos-col-subtotal .pos_line_total_text {
            width: 100% !important;
            max-width: 100%;
            min-width: 0;
            font-size: 11px !important;
            font-weight: 700;
            padding: 2px 4px;
            height: 26px;
            text-align: right;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-action {
            width: 9%;
            min-width: 28px;
            padding: 4px 2px !important;
            vertical-align: middle !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-action .fa-times {
            font-size: 14px;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-service .select2-container {
            min-width: 0 !important;
            max-width: 100% !important;
        }

        body.vp-pos-page #pos_table td.vp-pos-col-service select {
            font-size: 10px !important;
            padding: 2px 4px;
            height: 28px;
        }

        body.vp-pos-page .pos_form_totals .row {
            margin-left: 0;
            margin-right: 0;
        }

        body.vp-pos-page .pos_form_totals .col-md-12 {
            padding-left: 6px;
            padding-right: 6px;
        }

        body.vp-pos-page .vp-pos-summary-wrap {
            margin-top: 8px;
            border-top: 1px solid #e8edf8;
            padding: 4px 4px 2px;
            box-sizing: border-box;
        }

        body.vp-pos-page .vp-pos-summary-arrow {
            text-align: center;
            color: #0f766e;
            font-size: 18px;
            margin: 0 0 8px;
            line-height: 1;
        }

        body.vp-pos-page .vp-pos-summary-top {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 8px 12px;
            margin-bottom: 8px;
        }

        body.vp-pos-page .vp-pos-summary-cell {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        body.vp-pos-page .vp-pos-summary-label {
            font-size: 10px;
            font-weight: 700;
            color: #0f172a;
            flex-shrink: 0;
            min-width: min-content;
            padding-right: 4px;
        }

        body.vp-pos-page .vp-pos-summary-label-due {
            color: #dc2626;
        }

        body.vp-pos-page .vp-pos-summary-value {
            font-size: 10px;
            font-weight: 800;
            color: #0f172a;
            flex: 0 1 auto;
            min-width: 0;
            max-width: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: right;
        }

        body.vp-pos-page .vp-pos-summary-value-due {
            color: #dc2626;
        }

        body.vp-pos-page .vp-pos-summary-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 6px 10px;
            margin-bottom: 10px;
        }

        body.vp-pos-page .vp-pos-summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 6px;
            min-width: 0;
        }

        body.vp-pos-page .vp-pos-summary-key {
            font-size: 10px;
            font-weight: 700;
            color: #0f172a;
            flex-shrink: 0;
            min-width: min-content;
            padding-right: 4px;
            line-height: 1.25;
        }

        body.vp-pos-page .vp-pos-summary-key .fas {
            margin-left: 2px;
            flex-shrink: 0;
        }

        body.vp-pos-page .vp-pos-summary-val {
            font-size: 10px;
            font-weight: 800;
            color: #111827;
            flex: 0 1 auto;
            min-width: 0;
            max-width: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: right;
        }

        body.vp-pos-page .vp-pos-grand-total {
            background: linear-gradient(90deg, #049f7c 0%, #02877f 100%);
            border-radius: 10px;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 14px;
            color: #fff;
            margin-bottom: 0;
        }

        body.vp-pos-page .vp-pos-grand-total-label {
            font-size: 11px;
            font-weight: 700;
        }

        body.vp-pos-page .vp-pos-grand-total-value {
            font-size: 15px;
            font-weight: 800;
            line-height: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: right;
        }

        body.vp-pos-page .pos-form-actions > .tw-flex > div:nth-child(1),
        body.vp-pos-page .pos-form-actions > .tw-flex > div:nth-child(2),
        body.vp-pos-page .pos-form-actions > .tw-flex > div:nth-child(4),
        body.vp-pos-page .pos-form-actions .pos-total {
            display: none !important;
        }

        body.vp-pos-page .vp-pos-cart-shell .pos-form-actions > .tw-flex {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        body.vp-pos-page .pos-form-actions > .tw-flex > div:nth-child(3) {
            display: grid !important;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 8px;
            width: 100%;
            overflow: hidden !important;
            padding: 0 !important;
        }

        body.vp-pos-page .pos-form-actions > .tw-flex > div:nth-child(3) button {
            width: 100% !important;
            min-width: 0 !important;
            height: 36px;
            border-radius: 8px !important;
            display: inline-flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 9px !important;
            font-weight: 700 !important;
        }

        body.vp-pos-page .pos-form-actions #pos-draft,
        body.vp-pos-page .pos-form-actions #pos-quotation,
        body.vp-pos-page .pos-form-actions [data-pay_method="suspend"],
        body.vp-pos-page .pos-form-actions [data-pay_method="credit_sale"] {
            grid-column: span 3;
            background: #e5e7eb !important;
            color: #111827 !important;
            border: 1px solid #d1d5db !important;
            box-shadow: none !important;
        }

        body.vp-pos-page .pos-form-actions #pos-draft i,
        body.vp-pos-page .pos-form-actions #pos-quotation i,
        body.vp-pos-page .pos-form-actions [data-pay_method="suspend"] i,
        body.vp-pos-page .pos-form-actions [data-pay_method="credit_sale"] i {
            color: #111827 !important;
        }

        body.vp-pos-page .pos-form-actions #pos-cancel {
            grid-column: span 3;
            background: #ffe4e6 !important;
            color: #ef4444 !important;
            border: 1px solid #fecdd3 !important;
            box-shadow: none !important;
        }

        body.vp-pos-page .pos-form-actions #pos-cancel i {
            color: #ef4444 !important;
        }

        body.vp-pos-page .pos-form-actions .pos-express-finalize[data-pay_method="card"] {
            grid-column: span 3;
            background: #2580ff !important;
            color: #fff !important;
            border: 0 !important;
        }

        body.vp-pos-page .pos-form-actions #pos-finalize {
            grid-column: span 3;
            background: #1e40af !important;
            color: #fff !important;
            border: 0 !important;
            display: inline-flex !important;
            width: 100% !important;
            min-width: 0 !important;
            height: 36px;
            border-radius: 8px !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 9px !important;
            font-weight: 700 !important;
        }

        body.vp-pos-page .pos-form-actions .pos-express-finalize[data-pay_method="cash"] {
            grid-column: span 3;
            background: #2ea936 !important;
            color: #fff !important;
            border: 0 !important;
        }

        @media (max-width: 1400px) {
            body.vp-pos-page .vp-pos-browse-shell #product_list_body {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1199px) {
            body.vp-pos-page .vp-pos-browse-shell #product_list_body {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        @media (max-width: 991px) {
            body.vp-pos-page .content.vp-pos-redesign {
                padding: 0 12px 12px;
            }

            body.vp-pos-page .vp-global-header {
                margin-left: 12px !important;
                margin-right: 12px !important;
            }

            body.vp-pos-page .vp-pos-products-col,
            body.vp-pos-page .vp-pos-cart-col {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
            }

            /*
             * Stacked tablet/phone (e.g. 768px): cart is full width but line table is still wide —
             * compact type + optional horizontal scroll so columns never crush each other.
             */
            body.vp-pos-page .pos_product_div {
                max-width: 100%;
                min-width: 0;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            body.vp-pos-page .vp-pos-cart-shell #pos_table {
                margin-bottom: 8px;
            }

            body.vp-pos-page .vp-pos-cart-shell #pos_table thead th {
                font-size: 9px !important;
                padding: 7px 4px !important;
                line-height: 1.15 !important;
            }

            body.vp-pos-page .vp-pos-cart-shell #pos_table tbody td {
                font-size: 10px !important;
                padding: 7px 4px !important;
            }

            body.vp-pos-page #pos_table td.vp-pos-col-product {
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            body.vp-pos-page #pos_table td.vp-pos-col-price .pos_unit_price_inc_tax,
            body.vp-pos-page #pos_table td.vp-pos-col-subtotal .pos_line_total,
            body.vp-pos-page #pos_table td.vp-pos-col-subtotal .pos_line_total_text {
                font-size: 10px !important;
                height: 24px !important;
                padding: 2px 4px !important;
            }

            body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number .form-control {
                font-size: 10px !important;
                height: 26px !important;
                padding: 2px 3px !important;
            }

            body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number .btn {
                flex: 0 0 24px !important;
                width: 24px !important;
                min-width: 24px !important;
                height: 24px !important;
            }

            body.vp-pos-page #pos_table td.vp-pos-col-qty .input-number .btn i {
                font-size: 10px !important;
            }

            body.vp-pos-page #pos_table .vp-pos-line-remove {
                font-size: 12px !important;
                padding: 4px 6px !important;
            }

            body.vp-pos-page .vp-pos-cart-tab {
                font-size: 12px !important;
                padding: 9px 8px !important;
            }

            body.vp-pos-page .pos-form-actions > .tw-flex > div:nth-child(3) {
                gap: 6px !important;
            }

            body.vp-pos-page .pos-form-actions > .tw-flex > div:nth-child(3) button {
                font-size: 8px !important;
                height: 34px !important;
            }

            body.vp-pos-page .vp-pos-browse-shell .product_box {
                min-height: 104px;
                padding: 0 40px 0 0;
            }

            body.vp-pos-page .vp-pos-browse-shell .product_box .image-container {
                flex: 0 0 92px;
                width: 92px;
                min-width: 92px;
            }

            body.vp-pos-page .vp-pos-browse-shell .product_box::after {
                width: 28px;
                height: 28px;
                right: 10px;
                bottom: 10px;
                font-size: 18px;
            }

            body.vp-pos-page .vp-pos-browse-shell .vp-pos-product-title {
                font-size: 11px !important;
            }

            body.vp-pos-page .vp-pos-browse-shell .vp-pos-product-price {
                font-size: 12px !important;
            }
        }
