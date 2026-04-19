<style id="vp-business-settings-vendo-styles">
    body.vp-business-settings-vendo-page aside.side-bar.vp-custom-sidebar {
        display: none !important;
    }

    body.vp-business-settings-vendo-page .vp-side-btn {
        display: none !important;
    }

    body.vp-business-settings-vendo-page #scrollable-container {
        overflow-x: hidden;
        padding-bottom: 0;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-page-wrap {
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

    body.vp-business-settings-vendo-page .vp-business-settings-shell {
        margin: 0;
        padding: 0;
        min-width: 0;
        max-width: 100%;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-page-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 0 0 14px;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-back {
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

    body.vp-business-settings-vendo-page .vp-business-settings-back:hover {
        color: #0f172a;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-page-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #fff;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search {
        margin: 0 0 16px;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search .row {
        margin: 0;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search .col-md-8 {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search .input-group {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #d9e0f4;
        background: #fff;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search .input-group-addon {
        background: #fff;
        border: none;
        color: #94a3b8;
        padding: 0 14px 0 16px;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search #search_settings {
        border: none !important;
        box-shadow: none !important;
        min-height: 44px;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search .select2-container {
        width: 100% !important;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search .select2-container--default .select2-selection--single {
        border: none !important;
        height: 44px;
        border-radius: 0;
        padding: 6px 12px;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-search .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px;
        color: #0f172a;
        font-weight: 500;
    }

    body.vp-business-settings-vendo-page .pos-tab-container.vp-business-settings-card {
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 50px rgba(15, 23, 42, 0.12);
        overflow: hidden;
        padding: 0;
    }

    body.vp-business-settings-vendo-page .pos-tab-container.vp-business-settings-card > .box-header,
    body.vp-business-settings-vendo-page .pos-tab-container.vp-business-settings-card > .box-body {
        display: none !important;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-layout {
        display: flex;
        flex-wrap: nowrap;
        align-items: stretch;
        min-height: 0;
    }

    @media (max-width: 991px) {
        body.vp-business-settings-vendo-page .vp-business-settings-layout {
            flex-direction: column;
        }
    }

    body.vp-business-settings-vendo-page .vp-business-settings-sidebar {
        flex: 0 0 230px;
        max-width: 100%;
        background: #f8fafc;
        border-right: 1px solid #e8ecf4;
        padding: 12px 0 12px 10px;
    }

    @media (max-width: 991px) {
        body.vp-business-settings-vendo-page .vp-business-settings-sidebar {
            flex: 0 0 auto;
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #e8ecf4;
            padding: 10px;
        }
    }

    body.vp-business-settings-vendo-page .vp-business-settings-sidebar .pos-tab-menu {
        float: none !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-sidebar .list-group {
        border-radius: 10px;
        overflow: visible;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-sidebar .list-group-item {
        border: none !important;
        border-radius: 10px 0 0 10px !important;
        margin-bottom: 4px;
        padding: 11px 12px;
        font-size: 13px;
        font-weight: 600;
        color: #475569 !important;
        background: transparent !important;
        text-align: left !important;
        position: relative;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-sidebar .list-group-item:hover {
        background: rgba(26, 43, 102, 0.06) !important;
        color: #1a2b66 !important;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-sidebar .list-group-item.active {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%) !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(16, 28, 58, 0.25);
    }

    body.vp-business-settings-vendo-page .vp-business-settings-sidebar .list-group-item.active::after {
        content: '';
        position: absolute;
        right: -1px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-right: 8px solid #fff;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-main {
        flex: 1 1 auto;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-section-bar {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%);
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        padding: 14px 20px;
        letter-spacing: -0.01em;
    }

    body.vp-business-settings-vendo-page .pos-tab {
        float: none !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 18px 20px 24px !important;
        flex: 1 1 auto;
        min-height: 0;
    }

    body.vp-business-settings-vendo-page div.pos-tab-content {
        padding: 0 !important;
        background: transparent !important;
    }

    body.vp-business-settings-vendo-page div.pos-tab-menu div.list-group > a.active::after,
    body.vp-business-settings-vendo-page div.pos-tab-menu div.list-group > a.active:after {
        display: none !important;
        content: none !important;
        border: none !important;
    }

    body.vp-business-settings-vendo-page .pos-tab-content .form-group label {
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }

    body.vp-business-settings-vendo-page .pos-tab-content .form-control,
    body.vp-business-settings-vendo-page .pos-tab-content .select2-container--default .select2-selection--single {
        border-radius: 10px !important;
        border: 1px solid #d9e0f4 !important;
        min-height: 40px;
    }

    body.vp-business-settings-vendo-page .pos-tab-content .input-group .form-control {
        border-radius: 0 10px 10px 0 !important;
    }

    body.vp-business-settings-vendo-page .pos-tab-content .input-group-addon {
        border-radius: 10px 0 0 10px !important;
        border: 1px solid #d9e0f4;
        border-right: none;
        background: #f8fafc;
        color: #64748b;
    }

    body.vp-business-settings-vendo-page .pos-tab-content .col-sm-4,
    body.vp-business-settings-vendo-page .pos-tab-content .col-md-4 {
        padding-left: 10px;
        padding-right: 10px;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-actions {
        padding: 0 20px 22px;
        display: flex;
        justify-content: center;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-submit {
        min-width: 220px;
        max-width: 100%;
        height: 46px;
        padding: 0 28px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(180deg, #22c55e 0%, #16a34a 100%);
        color: #fff !important;
        font-size: 15px;
        font-weight: 700;
        box-shadow: 0 6px 18px rgba(22, 163, 74, 0.35);
        cursor: pointer;
    }

    body.vp-business-settings-vendo-page .vp-business-settings-submit:hover {
        filter: brightness(1.05);
        color: #fff !important;
    }

    @media (max-width: 991px) {
        body.vp-business-settings-vendo-page .vp-business-settings-page-wrap {
            margin: 14px 12px 16px;
            padding: 10px 12px;
        }

        body.vp-business-settings-vendo-page .vp-business-settings-sidebar .list-group-item.active::after {
            display: none;
        }
    }
</style>
