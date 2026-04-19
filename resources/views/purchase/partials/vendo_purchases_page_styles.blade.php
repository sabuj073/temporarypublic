<style id="vp-purchases-vendo-styles">
    body.vp-purchases-vendo-page aside.side-bar.vp-custom-sidebar {
        display: none !important;
    }

    body.vp-purchases-vendo-page .vp-side-btn {
        display: none !important;
    }

    /*
     * Export actions use position:fixed — they do not need padding on #scrollable-container.
     * Extra padding-bottom here only increased scrollHeight and forced an unnecessary vertical scrollbar.
     */
    body.vp-purchases-vendo-page #scrollable-container {
        overflow-x: hidden;
        padding-bottom: 0;
    }

    /*
     * Align outer frame with .vp-global-header: same margin (22px 26px), padding (10px 12px),
     * border and radius. Do NOT use width:100% with horizontal margins — it overflows the row
     * and reads wider than the header bar.
     */
    body.vp-purchases-vendo-page .vp-purchases-page-wrap {
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

    body.vp-purchases-vendo-page .vp-purchases-shell {
        margin: 0;
        padding: 0;
        min-width: 0;
        max-width: 100%;
    }

    body.vp-purchases-vendo-page .vp-purchases-page-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 0 0 16px;
    }

    body.vp-purchases-vendo-page .vp-purchases-back {
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

    body.vp-purchases-vendo-page .vp-purchases-back:hover {
        color: #0f172a;
    }

    body.vp-purchases-vendo-page .vp-purchases-page-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #fff;
    }

    /* Filters live inside the single white card (not a second card). */
    body.vp-purchases-vendo-page .vp-purchases-filters {
        padding: 18px 20px 16px;
        border-bottom: 1px solid #e8ecf4;
    }

    body.vp-purchases-vendo-page .vp-purchases-filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 14px 16px;
        align-items: flex-end;
    }

    body.vp-purchases-vendo-page .vp-purchases-filter-field {
        flex: 1 1 160px;
        min-width: 140px;
        max-width: 100%;
    }

    body.vp-purchases-vendo-page .vp-purchases-filter-field label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    body.vp-purchases-vendo-page .vp-purchases-filter-field .select2-container,
    body.vp-purchases-vendo-page .vp-purchases-filter-field .form-control {
        width: 100% !important;
    }

    body.vp-purchases-vendo-page .vp-purchases-filter-field .form-control {
        height: 38px;
        border-radius: 10px;
        border: 1px solid #d9e0f4;
        font-size: 13px;
    }

    body.vp-purchases-vendo-page .vp-purchases-card {
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

    body.vp-purchases-vendo-page .vp-purchases-card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        padding: 16px 20px 14px;
        border-bottom: 1px solid #e8ecf4;
    }

    body.vp-purchases-vendo-page .vp-purchases-card-title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    body.vp-purchases-vendo-page .vp-purchases-card-toolbar-end {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
        flex: 1 1 auto;
        min-width: 0;
    }

    body.vp-purchases-vendo-page .vp-purchases-slot .dataTables_length,
    body.vp-purchases-vendo-page .vp-purchases-slot .dataTables_filter {
        float: none;
        margin: 0;
    }

    body.vp-purchases-vendo-page .vp-purchases-slot .dataTables_length label,
    body.vp-purchases-vendo-page .vp-purchases-slot .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    body.vp-purchases-vendo-page .vp-purchases-slot .dataTables_length select {
        height: 34px;
        border-radius: 8px;
        border: 1px solid #d9e0f4;
        padding: 0 28px 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        min-width: 72px;
    }

    body.vp-purchases-vendo-page .vp-purchases-filter-slot .dataTables_filter input {
        width: 220px;
        max-width: 42vw;
        height: 36px;
        border-radius: 10px;
        border: 1px solid #d9e0f4;
        padding: 0 36px 0 12px;
        font-size: 13px;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E") no-repeat right 10px center;
    }

    body.vp-purchases-vendo-page .vp-purchases-add-btn {
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
        text-decoration: none !important;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 4px 12px rgba(16, 28, 58, 0.35);
        white-space: nowrap;
    }

    body.vp-purchases-vendo-page .vp-purchases-add-btn:hover {
        filter: brightness(1.06);
        color: #fff !important;
    }

    body.vp-purchases-vendo-page .vp-purchases-table-wrap {
        padding: 0 8px 8px;
        max-width: 100%;
        min-width: 0;
        overflow-x: auto;
    }

    body.vp-purchases-vendo-page #purchase_table {
        margin: 0 !important;
    }

    body.vp-purchases-vendo-page #purchase_table thead th {
        background: #f4f6fb !important;
        color: #475569 !important;
        font-size: 12px;
        font-weight: 700;
        border-bottom: 1px solid #e8ecf4 !important;
        padding: 12px 10px !important;
        vertical-align: middle !important;
    }

    body.vp-purchases-vendo-page #purchase_table tbody td {
        font-size: 13px;
        color: #0f172a;
        padding: 10px !important;
        vertical-align: middle !important;
        border-color: #eef1f7 !important;
    }

    body.vp-purchases-vendo-page #purchase_table tbody tr:nth-child(even) td {
        background: #fafbfd;
    }

    body.vp-purchases-vendo-page #purchase_table tfoot tr.footer-total {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%) !important;
        color: #fff !important;
    }

    body.vp-purchases-vendo-page #purchase_table tfoot tr.footer-total td,
    body.vp-purchases-vendo-page #purchase_table tfoot tr.footer-total th {
        background: transparent !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        font-weight: 700;
        padding: 14px 10px !important;
    }

    body.vp-purchases-vendo-page #purchase_table tfoot tr.footer-total small,
    body.vp-purchases-vendo-page #purchase_table tfoot tr.footer-total .text-muted {
        color: rgba(255, 255, 255, 0.88) !important;
    }

    body.vp-purchases-vendo-page #purchase_table tfoot .footer_purchase_total,
    body.vp-purchases-vendo-page #purchase_table tfoot .footer_total_due,
    body.vp-purchases-vendo-page #purchase_table tfoot .footer_total_purchase_return_due {
        color: #fff !important;
    }

    body.vp-purchases-vendo-page .vp-purchases-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 12px 18px 16px;
        border-top: 1px solid #e8ecf4;
    }

    body.vp-purchases-vendo-page .vp-purchases-card-footer .dataTables_info {
        float: none;
        margin: 0;
        padding: 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    body.vp-purchases-vendo-page .vp-purchases-card-footer .dataTables_paginate {
        float: none;
        margin: 0;
        text-align: end;
    }

    body.vp-purchases-vendo-page .vp-purchases-card-footer .dataTables_paginate .paginate_button {
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

    body.vp-purchases-vendo-page .vp-purchases-card-footer .dataTables_paginate .paginate_button.current,
    body.vp-purchases-vendo-page .vp-purchases-card-footer .dataTables_paginate .paginate_button.current:hover {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%) !important;
        border-color: #101c3a !important;
        color: #fff !important;
    }

    body.vp-purchases-vendo-page .vp-purchases-export-dock {
        display: none;
        position: fixed;
        left: 12px;
        right: 12px;
        bottom: 16px;
        z-index: 900;
        pointer-events: none;
        box-sizing: border-box;
        justify-content: center;
        align-items: center;
    }

    body.vp-purchases-vendo-page .vp-purchases-export-dock.vp-purchases-export-dock--visible {
        display: flex;
    }

    body.vp-purchases-vendo-page .vp-purchases-export-inner {
        pointer-events: auto;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 14px;
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.2);
        max-width: 100%;
        margin: 0 auto;
        box-sizing: border-box;
    }

    body.vp-purchases-vendo-page .vp-purchases-export-inner .dt-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    body.vp-purchases-vendo-page .vp-purchases-export-inner .dt-button {
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

    body.vp-purchases-vendo-page .vp-purchases-export-inner .dt-button:hover {
        filter: brightness(1.06);
        color: #fff !important;
    }

    @media (max-width: 991px) {
        body.vp-purchases-vendo-page .vp-purchases-page-wrap {
            margin: 14px 12px 16px;
            padding: 10px 12px;
        }
    }

    @media (max-width: 640px) {
        body.vp-purchases-vendo-page .vp-purchases-card-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        body.vp-purchases-vendo-page .vp-purchases-card-toolbar-end {
            flex-direction: column;
            align-items: stretch;
        }

        body.vp-purchases-vendo-page .vp-purchases-filter-slot .dataTables_filter input {
            width: 100%;
            max-width: none;
        }
    }
</style>
