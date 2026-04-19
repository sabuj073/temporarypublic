<style id="vp-vendo-form-shell-wrap-styles">
    .vp-vendo-page-wrap {
        margin: 22px 26px 28px;
        padding: 22px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
    }

    .vp-vendo-form-page-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 16px;
        padding-bottom: 2px;
    }

    .vp-vendo-form-back {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(18, 29, 64, 0.08);
        flex-shrink: 0;
        text-decoration: none !important;
    }

    .vp-vendo-form-back img {
        width: 14px;
        height: 14px;
        object-fit: contain;
    }

    .vp-vendo-form-head-main {
        flex: 1;
        min-width: 0;
    }

    .vp-vendo-form-title {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        color: #f8fafc !important;
        line-height: 1.2;
    }

    .vp-vendo-form-title .text-muted,
    .vp-vendo-form-title .hover-q {
        color: rgba(248, 250, 252, 0.88) !important;
    }

    .vp-vendo-form-title .vp-vendo-form-title-sub {
        font-weight: 600;
        color: rgba(248, 250, 252, 0.92) !important;
    }

    .vp-vendo-form-page-head--with-actions {
        flex-wrap: wrap;
        align-items: flex-start;
    }

    .vp-vendo-form-head-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
        margin-left: auto;
    }

    .vp-vendo-form-subtitle {
        margin: 6px 0 0;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.35;
        color: rgba(248, 250, 252, 0.88);
    }

    .vp-vendo-page-wrap > .content-header {
        background: transparent;
        border: none;
        padding: 0 0 14px;
        margin: 0;
    }

    .vp-vendo-page-wrap > .content-header h1 {
        color: #f8fafc !important;
        font-weight: 700;
    }

    .vp-vendo-page-wrap > .content-header .text-muted,
    .vp-vendo-page-wrap > .content-header .hover-q {
        color: rgba(248, 250, 252, 0.85) !important;
    }

    .vp-vendo-form-content {
        padding: 0 !important;
        margin-right: 0 !important;
        margin-left: 0 !important;
    }

    .vp-vendo-form-content > form {
        width: 100%;
        max-width: none;
    }

    .vp-vendo-form-content form > .box,
    .vp-vendo-form-content form > .box-primary,
    .vp-vendo-form-content form > .box-solid,
    .vp-vendo-form-content > .box,
    .vp-vendo-form-content > .box-primary,
    .vp-vendo-form-content > .box-solid,
    .vp-vendo-form-content .box-primary,
    .vp-vendo-form-content .box.box-solid {
        background: #fff !important;
        border-radius: 12px !important;
        border: none !important;
        box-shadow: none !important;
        margin-bottom: 12px;
    }

    /*
     * Bootstrap 3 float columns + clearfix leave large holes when one column is taller
     * (e.g. ref_no + help text) and the next row is forced below the whole line.
     * Flex-wrap packs the next fields beside shorter columns. Payment rows opt out
     * because they mix hidden inputs and float-specific layout.
     */
    .vp-vendo-form-content .row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
    }

    .vp-vendo-form-content .row::before,
    .vp-vendo-form-content .row::after {
        content: none !important;
        display: none !important;
    }

    .vp-vendo-form-content .row > [class*='col-'] {
        float: none !important;
    }

    .vp-vendo-form-content .payment_row > .row,
    .vp-vendo-form-content .payment_row .row {
        display: block;
    }

    .vp-vendo-form-content .payment_row > .row::before,
    .vp-vendo-form-content .payment_row > .row::after,
    .vp-vendo-form-content .payment_row .row::before,
    .vp-vendo-form-content .payment_row .row::after {
        content: ' ' !important;
        display: table !important;
    }

    .vp-vendo-form-content .payment_row > .row > [class*='col-'],
    .vp-vendo-form-content .payment_row .row > [class*='col-'] {
        float: left !important;
    }

    /* Standalone clearfix divs between columns become bogus flex items — hide them except in payment rows. */
    .vp-vendo-form-content .row > .clearfix {
        display: none !important;
    }

    .vp-vendo-form-content .payment_row > .row > .clearfix,
    .vp-vendo-form-content .payment_row .row > .clearfix {
        display: block !important;
    }

    @media (max-width: 768px) {
        .vp-vendo-form-page-head--with-actions .vp-vendo-form-head-actions {
            width: 100%;
            margin-left: 0;
            padding-left: 48px;
        }
    }

    @media (max-width: 991px) {
        .vp-vendo-page-wrap {
            margin: 14px 12px 16px;
            padding: 14px;
        }

        .vp-vendo-form-title {
            font-size: 22px;
        }
    }
</style>
