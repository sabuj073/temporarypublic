<style id="vp-users-vendo-styles">
    body.vp-users-vendo-page aside.side-bar.vp-custom-sidebar {
        display: none !important;
    }

    body.vp-users-vendo-page .vp-side-btn {
        display: none !important;
    }

    body.vp-users-vendo-page #scrollable-container {
        padding-bottom: 28px;
    }

    /* Same outer treatment as product index: width aligns with .vp-global-header (22px 26px margins). */
    body.vp-users-vendo-page .vp-users-page-wrap {
        margin: 12px 26px 28px;
        padding: 22px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }

    body.vp-users-vendo-page .vp-users-shell {
        max-width: none;
        margin: 0;
        padding: 0;
    }

    body.vp-users-vendo-page .vp-users-page-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 0 0 16px;
    }

    body.vp-users-vendo-page .vp-users-back {
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
        text-decoration: none;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
    }

    body.vp-users-vendo-page .vp-users-back:hover {
        color: #0f172a;
        border-color: rgba(255, 255, 255, 0.65);
    }

    body.vp-users-vendo-page .vp-users-page-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #fff;
        line-height: 1.15;
    }

    body.vp-users-vendo-page .vp-users-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 50px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    body.vp-users-vendo-page .vp-users-card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        padding: 18px 20px 14px;
        border-bottom: 1px solid #e8ecf4;
    }

    body.vp-users-vendo-page .vp-users-card-title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    body.vp-users-vendo-page .vp-users-card-toolbar-end {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
        flex: 1 1 auto;
        min-width: 0;
    }

    body.vp-users-vendo-page .vp-users-slot .dataTables_length,
    body.vp-users-vendo-page .vp-users-slot .dataTables_filter {
        float: none;
        margin: 0;
        text-align: inherit;
    }

    body.vp-users-vendo-page .vp-users-slot .dataTables_length label,
    body.vp-users-vendo-page .vp-users-slot .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    body.vp-users-vendo-page .vp-users-slot .dataTables_length select {
        height: 34px;
        border-radius: 8px;
        border: 1px solid #d9e0f4;
        padding: 0 28px 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        background-color: #fff;
        min-width: 72px;
    }

    body.vp-users-vendo-page .vp-users-filter-slot .dataTables_filter input {
        width: 220px;
        max-width: 42vw;
        height: 36px;
        border-radius: 10px;
        border: 1px solid #d9e0f4;
        padding: 0 36px 0 12px;
        font-size: 13px;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E") no-repeat right 10px center;
    }

    body.vp-users-vendo-page .vp-users-add-btn {
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

    body.vp-users-vendo-page .vp-users-add-btn:hover {
        filter: brightness(1.06);
        color: #fff !important;
    }

    body.vp-users-vendo-page .vp-users-table-wrap {
        padding: 0 4px 8px;
    }

    body.vp-users-vendo-page .vp-users-table-wrap .dataTables_processing {
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%);
        margin: 0 !important;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
    }

    body.vp-users-vendo-page #users_table {
        margin: 0 !important;
        border: none !important;
    }

    body.vp-users-vendo-page #users_table thead th {
        background: #f4f6fb !important;
        color: #475569 !important;
        font-size: 12px;
        font-weight: 700;
        text-transform: none;
        letter-spacing: 0.01em;
        border-bottom: 1px solid #e8ecf4 !important;
        padding: 12px 14px !important;
        vertical-align: middle !important;
    }

    body.vp-users-vendo-page #users_table tbody td {
        font-size: 13px;
        color: #0f172a;
        padding: 12px 14px !important;
        vertical-align: middle !important;
        border-color: #eef1f7 !important;
    }

    body.vp-users-vendo-page #users_table tbody tr:nth-child(even) td {
        background: #fafbfd;
    }

    body.vp-users-vendo-page table.dataTable thead .sorting,
    body.vp-users-vendo-page table.dataTable thead .sorting_asc,
    body.vp-users-vendo-page table.dataTable thead .sorting_desc {
        padding-right: 22px !important;
    }

    body.vp-users-vendo-page .vp-users-actions {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    body.vp-users-vendo-page .vp-users-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        cursor: pointer;
        text-decoration: none !important;
        transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
    }

    body.vp-users-vendo-page .vp-users-action-btn:hover {
        border-color: #cbd5e1;
        color: #0f172a;
        background: #f8fafc;
    }

    body.vp-users-vendo-page .vp-users-action-btn--danger {
        border-color: #fecaca;
        color: #dc2626;
        background: #fff5f5;
    }

    body.vp-users-vendo-page .vp-users-action-btn--danger:hover {
        border-color: #fca5a5;
        color: #b91c1c;
        background: #fef2f2;
    }

    body.vp-users-vendo-page .vp-users-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 12px 18px 16px;
        border-top: 1px solid #e8ecf4;
    }

    body.vp-users-vendo-page .vp-users-card-footer .dataTables_info {
        float: none;
        padding: 0;
        margin: 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    body.vp-users-vendo-page .vp-users-card-footer .dataTables_paginate {
        float: none;
        margin: 0;
        text-align: end;
    }

    body.vp-users-vendo-page .vp-users-card-footer .dataTables_paginate .paginate_button {
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

    body.vp-users-vendo-page .vp-users-card-footer .dataTables_paginate .paginate_button.current,
    body.vp-users-vendo-page .vp-users-card-footer .dataTables_paginate .paginate_button.current:hover {
        background: linear-gradient(180deg, #1a2b66 0%, #101c3a 100%) !important;
        border-color: #101c3a !important;
        color: #fff !important;
    }

    body.vp-users-vendo-page .vp-users-card-footer .dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
    }

    /* Export cluster (DataTables Buttons from common.js) — same idea as product index */
    body.vp-users-vendo-page .vp-users-export-actions {
        margin: 0 0 12px;
        padding: 0 8px;
        display: flex;
        justify-content: center;
    }

    body.vp-users-vendo-page .vp-users-card .dt-buttons {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 8px;
        background: #fff;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #cdd4e8;
        box-shadow: 0 4px 12px rgba(21, 31, 66, 0.15);
    }

    body.vp-users-vendo-page .vp-users-card .dt-buttons .dt-button {
        background: #27306f !important;
        color: #fff !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 7px 12px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
    }

    body.vp-users-vendo-page .vp-users-card .dt-buttons .dt-button:hover {
        filter: brightness(1.06);
        color: #fff !important;
    }

    @media (max-width: 991px) {
        body.vp-users-vendo-page .vp-users-page-wrap {
            margin: 14px 12px 16px;
            padding: 14px;
        }
    }

    @media (max-width: 640px) {
        body.vp-users-vendo-page .vp-users-card-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        body.vp-users-vendo-page .vp-users-card-toolbar-end {
            flex-direction: column;
            align-items: stretch;
        }

        body.vp-users-vendo-page .vp-users-filter-slot .dataTables_filter input {
            width: 100%;
            max-width: none;
        }
    }
</style>
