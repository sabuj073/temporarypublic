<style id="vp-profit-loss-vendo-styles">
    body.vp-profit-loss-vendo-page aside.side-bar.vp-custom-sidebar {
        display: none !important;
    }

    body.vp-profit-loss-vendo-page .vp-side-btn {
        display: none !important;
    }

    body.vp-profit-loss-vendo-page #scrollable-container {
        overflow-x: hidden;
        padding-bottom: 0;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-page-wrap {
        box-sizing: border-box;
        margin: 22px 26px 28px;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
        width: auto;
        max-width: none;
        min-width: 0;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-shell {
        margin: 0;
        padding: 0;
        min-width: 0;
        max-width: 100%;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-page-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 0 0 16px;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-back {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.45);
        background: #fff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-back:hover {
        color: #0f172a;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-page-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #fff;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-card {
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 50px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-toolbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        padding: 18px 20px 16px;
        border-bottom: 1px solid #e8ecf4;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-toolbar-main {
        display: flex;
        flex-wrap: wrap;
        gap: 14px 16px;
        align-items: flex-end;
        flex: 1 1 auto;
        min-width: 0;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-filter-field {
        flex: 1 1 200px;
        min-width: 160px;
        max-width: 100%;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-filter-field label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-filter-field .select2-container,
    body.vp-profit-loss-vendo-page .vp-profit-loss-filter-field .form-control {
        width: 100% !important;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-filter-field .form-control,
    body.vp-profit-loss-vendo-page .vp-profit-loss-date-btn {
        height: 38px;
        border-radius: 10px;
        border: 1px solid #d9e0f4;
        font-size: 13px;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-date-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0 14px;
        background: #fff;
        color: #0f172a;
        font-weight: 600;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-print-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 38px;
        padding: 0 16px;
        border-radius: 10px;
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%);
        color: #fff !important;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 4px 12px rgba(16, 28, 58, 0.35);
        white-space: nowrap;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-print-btn:hover {
        filter: brightness(1.06);
        color: #fff !important;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-pl-body {
        padding: 16px 20px 8px;
        border-bottom: 1px solid #e8ecf4;
    }

    body.vp-profit-loss-vendo-page .vp-pl-metric-card {
        background: #fff;
        border: 1px solid #e8ecf4;
        border-radius: 12px;
        padding: 12px 14px 14px;
        height: 100%;
    }

    body.vp-profit-loss-vendo-page .vp-pl-metric-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-metric-table > tbody > tr > th,
    body.vp-profit-loss-vendo-page .vp-pl-metric-table > tbody > tr > td {
        border: none !important;
        padding: 10px 12px !important;
        vertical-align: middle;
        background: #f1f5f9;
    }

    body.vp-profit-loss-vendo-page .vp-pl-metric-table > tbody > tr > th {
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        border-radius: 8px 0 0 8px !important;
        width: 58%;
    }

    body.vp-profit-loss-vendo-page .vp-pl-metric-table > tbody > tr > td {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        text-align: right;
        border-radius: 0 8px 8px 0 !important;
    }

    body.vp-profit-loss-vendo-page .vp-pl-summary-wrap {
        margin-top: 8px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-cogs-block {
        padding: 12px 0 8px;
        border-bottom: 1px solid #e8ecf4;
        margin-bottom: 14px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-cogs-title {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-top: 4px;
    }

    @media (max-width: 767px) {
        body.vp-profit-loss-vendo-page .vp-pl-hero-cards {
            grid-template-columns: 1fr;
        }
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-card {
        border-radius: 12px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        min-height: 72px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-card--gross {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #0f172a;
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-card--net {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-label {
        font-size: 13px;
        font-weight: 700;
        opacity: 0.9;
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-value {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-card--net .vp-pl-hero-label,
    body.vp-profit-loss-vendo-page .vp-pl-hero-card--net .vp-pl-hero-value,
    body.vp-profit-loss-vendo-page .vp-pl-hero-card--net .display_currency {
        color: #fff !important;
    }

    body.vp-profit-loss-vendo-page .vp-pl-hero-help {
        margin-top: 10px;
        font-size: 11px;
        line-height: 1.45;
        color: #64748b;
    }

    body.vp-profit-loss-vendo-page .vp-profit-loss-tabs-wrap {
        padding: 0 12px 16px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-nav-tabs.nav-tabs {
        border-bottom: 1px solid #e8ecf4;
        display: flex;
        flex-wrap: wrap;
        gap: 4px 8px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-nav-tabs > li {
        margin-bottom: -1px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-nav-tabs > li > a {
        border: none !important;
        border-radius: 10px 10px 0 0;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        padding: 10px 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-nav-tabs > li > a i {
        font-size: 16px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-nav-tabs > li.active > a,
    body.vp-profit-loss-vendo-page .vp-pl-nav-tabs > li.active > a:hover,
    body.vp-profit-loss-vendo-page .vp-pl-nav-tabs > li.active > a:focus {
        color: #0d9488 !important;
        background: #fff !important;
        border-bottom: 3px solid #0d9488 !important;
        font-weight: 700;
    }

    body.vp-profit-loss-vendo-page .vp-pl-tab-content.tab-content {
        padding: 16px 8px 8px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-dt-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-filter-slot .dataTables_filter,
    body.vp-profit-loss-vendo-page .vp-pl-length-slot .dataTables_length {
        float: none;
        margin: 0;
    }

    body.vp-profit-loss-vendo-page .vp-pl-filter-slot .dataTables_filter label,
    body.vp-profit-loss-vendo-page .vp-pl-length-slot .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    body.vp-profit-loss-vendo-page .vp-pl-filter-slot .dataTables_filter input {
        width: 220px;
        max-width: 42vw;
        height: 36px;
        border-radius: 10px;
        border: 1px solid #d9e0f4;
        padding: 0 36px 0 12px;
        font-size: 13px;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E") no-repeat right 10px center;
    }

    body.vp-profit-loss-vendo-page .vp-pl-length-slot .dataTables_length select {
        height: 34px;
        border-radius: 8px;
        border: 1px solid #d9e0f4;
        padding: 0 28px 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        min-width: 72px;
    }

    body.vp-profit-loss-vendo-page .vp-pl-dt-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 12px;
        padding-top: 8px;
        border-top: 1px solid #e8ecf4;
    }

    body.vp-profit-loss-vendo-page .vp-pl-info-slot .dataTables_info {
        float: none;
        margin: 0;
        padding: 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    body.vp-profit-loss-vendo-page .vp-pl-paginate-slot .dataTables_paginate {
        float: none;
        margin: 0;
        text-align: end;
    }

    body.vp-profit-loss-vendo-page .vp-pl-paginate-slot .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        background: #fff !important;
        color: #475569 !important;
        margin-left: 6px !important;
        min-width: 34px;
        height: 34px;
        line-height: 32px !important;
        padding: 0 10px !important;
    }

    body.vp-profit-loss-vendo-page .vp-pl-paginate-slot .dataTables_paginate .paginate_button.current,
    body.vp-profit-loss-vendo-page .vp-pl-paginate-slot .dataTables_paginate .paginate_button.current:hover {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%) !important;
        border-color: #101c3a !important;
        color: #fff !important;
    }

    body.vp-profit-loss-vendo-page .tab-pane .dataTables_wrapper .dt-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        padding: 14px 0 4px;
        width: 100%;
    }

    body.vp-profit-loss-vendo-page .tab-pane .dataTables_wrapper .dt-button {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%) !important;
        color: #fff !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 8px 14px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        box-shadow: 0 4px 12px rgba(16, 28, 58, 0.28) !important;
    }

    body.vp-profit-loss-vendo-page .tab-pane .dataTables_wrapper .dt-button:hover {
        filter: brightness(1.06);
        color: #fff !important;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] {
        table-layout: fixed;
        width: 100% !important;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] thead th:nth-child(1),
    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] tbody td:nth-child(1) {
        width: 62%;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] thead th:nth-child(2),
    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] tbody td:nth-child(2) {
        width: 38%;
        text-align: right;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] thead th {
        background: #f4f6fb !important;
        color: #475569 !important;
        font-size: 12px;
        font-weight: 700;
        border-bottom: 1px solid #e8ecf4 !important;
        padding: 12px 10px !important;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] tbody td {
        font-size: 13px;
        color: #0f172a;
        padding: 10px !important;
        border-color: #eef1f7 !important;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] tbody tr:nth-child(even) td {
        background: #fafbfd;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] tfoot tr.footer-total {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%) !important;
        color: #fff !important;
    }

    body.vp-profit-loss-vendo-page .tab-pane table[id^="profit_by"] tfoot tr.footer-total td {
        background: transparent !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        font-weight: 700;
        padding: 14px 10px !important;
    }

    body.vp-profit-loss-vendo-page .nav-tabs-custom {
        box-shadow: none;
        margin-bottom: 0;
    }

    body.vp-profit-loss-vendo-page .nav-tabs-custom > .nav-tabs {
        margin: 0 4px;
    }

    @media (max-width: 991px) {
        body.vp-profit-loss-vendo-page .vp-profit-loss-page-wrap {
            margin: 14px 12px 16px;
            padding: 10px 12px;
        }
    }

    @media (max-width: 640px) {
        body.vp-profit-loss-vendo-page .vp-profit-loss-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        body.vp-profit-loss-vendo-page .vp-pl-filter-slot .dataTables_filter input {
            width: 100%;
            max-width: none;
        }
    }
</style>
