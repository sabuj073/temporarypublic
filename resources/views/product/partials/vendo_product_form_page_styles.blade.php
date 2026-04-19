<style id="vp-product-form-page-styles">
        .vp-products-page-wrap {
            margin: 22px 26px 28px;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
        }

        .vp-product-create-content {
            padding: 0 !important;
            margin-right: 0 !important;
            margin-left: 0 !important;
        }

        .vp-product-create-content > form {
            width: 100%;
            max-width: none;
        }

        .vp-product-create-content form > .box-primary {
            background: #fff !important;
            border-radius: 12px !important;
            border: none !important;
            box-shadow: none !important;
            --tw-ring-width: 0 !important;
            --tw-ring-offset-width: 0 !important;
            margin-bottom: 12px;
        }

        .vp-product-create-first-card .tw-py-2 {
            padding-top: 0.75rem !important;
        }

        .vp-product-create-card-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 0 20px;
            padding-bottom: 4px;
        }

        .vp-product-create-back {
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

        .vp-product-create-back img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }

        .vp-product-create-card-title {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #232f66 !important;
            line-height: 1.2;
        }

        .vp-product-create-grid .form-group {
            margin-bottom: 18px;
        }

        .vp-product-create-content .form-group label,
        .vp-product-create-content label.control-label {
            font-weight: 700;
            font-size: 13px;
            color: #111827 !important;
            margin-bottom: 6px;
        }

        .vp-product-create-content .vp-pc-input,
        .vp-product-create-content textarea.form-control {
            height: 40px;
            padding: 8px 12px;
            font-size: 14px;
            color: #111827;
            background: #fff !important;
            border: 1px solid #d1d5db !important;
            border-radius: 6px !important;
            box-shadow: none !important;
        }

        .vp-product-create-content textarea.form-control {
            height: auto;
            min-height: 120px;
        }

        .vp-product-create-content .vp-pc-input:focus,
        .vp-product-create-content textarea.form-control:focus {
            border-color: #27306f !important;
            outline: 0;
        }

        .vp-product-create-content .select2-container {
            width: 100% !important;
        }

        .vp-product-create-content .select2-container--default .select2-selection--single,
        .vp-product-create-content .select2-container--default .select2-selection--multiple {
            min-height: 40px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 6px !important;
            background: #fff !important;
            box-shadow: none !important;
        }

        .vp-product-create-content .select2-container--default .select2-selection--single {
            height: 40px !important;
        }

        .vp-product-create-content .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
            padding-left: 12px;
            padding-right: 28px;
            color: #111827;
            font-size: 14px;
        }

        .vp-product-create-content .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }

        .vp-product-create-content .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: 6px 8px;
        }

        .vp-product-create-content .vp-pc-input-group .form-control {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .vp-product-create-content .vp-pc-input-group .select2-container .select2-selection--single {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .vp-product-create-content .vp-pc-addon-btn {
            width: 40px;
            height: 40px;
            padding: 0;
            margin: 0;
            border: 1px solid #d1d5db !important;
            border-left: 0 !important;
            border-radius: 0 6px 6px 0 !important;
            background: #fff !important;
            color: #27306f !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vp-product-create-content .vp-pc-addon-btn:hover {
            background: #f8fafc !important;
            color: #1e3a5f !important;
        }

        .vp-product-create-content .vp-pc-addon-btn .fa-plus {
            font-size: 14px;
        }

        .vp-product-create-content .vp-pc-help,
        .vp-product-create-content .help-block {
            font-size: 12px;
            color: #6b7280 !important;
            margin-top: 6px;
        }

        .vp-product-create-content .vp-pc-checkbox-block {
            padding-top: 4px;
        }

        .vp-product-create-content .vp-pc-checkbox-label {
            font-weight: 700;
            color: #111827;
            cursor: pointer;
        }

        .vp-product-create-content .vp-pc-checkbox-label strong {
            font-weight: 700;
        }

        .vp-product-create-content .vp-pc-img-label {
            font-weight: 700;
            font-size: 13px;
            color: #111827 !important;
            margin-bottom: 8px;
        }

        .vp-product-create-content .vp-pc-image-dropzone {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            box-sizing: border-box;
            min-height: 132px;
            margin: 0;
            padding: 20px 16px;
            background: #fff;
            border: 2px dashed #c5cdd9 !important;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.15s ease, background 0.15s ease;
        }

        .vp-product-create-content .vp-pc-image-dropzone:hover,
        .vp-product-create-content .vp-pc-image-dropzone.vp-pc-image-dropzone--active {
            border-color: #94a3b8 !important;
            background: #f8fafc;
        }

        .vp-product-create-content .vp-pc-image-dropzone--brochure {
            min-height: 168px;
            padding: 28px 20px;
            background: #fafbfc;
            border-color: #d1d5db !important;
        }

        .vp-product-create-content .vp-pc-image-dropzone--brochure:hover,
        .vp-product-create-content .vp-pc-image-dropzone--brochure.vp-pc-image-dropzone--active {
            background: #f3f4f6;
            border-color: #9ca3af !important;
        }

        .vp-product-create-content .vp-pc-brochure-txt-upload {
            font-weight: 700;
            color: #111827;
        }

        .vp-product-create-content .vp-pc-brochure-txt-browse {
            font-weight: 400;
            color: #6b7280;
        }

        .vp-product-create-content .vp-pc-brochure-field .vp-pc-brochure-upload-icon {
            color: #9ca3af;
        }

        .vp-product-create-content .vp-pc-brochure-help .help-block {
            font-size: 12px;
            font-weight: 400;
            color: #1f2937 !important;
            line-height: 1.45;
            margin-top: 8px;
            margin-bottom: 0;
        }

        .vp-product-create-content .vp-pc-brochure-help .help-block:first-child {
            margin-top: 14px;
        }

        .vp-product-create-content .vp-pc-image-dropzone--has-file .vp-pc-brochure-dropzone-text {
            font-weight: 500;
            color: #111827 !important;
        }

        .vp-product-create-content .vp-pc-image-file {
            position: absolute;
            inset: 0;
            width: 100% !important;
            height: 100% !important;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .vp-product-create-content .vp-pc-image-dropzone-ui {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            pointer-events: none;
        }

        .vp-product-create-content .vp-pc-image-upload-icon {
            font-size: 28px;
            line-height: 1;
            color: #b8c0ce;
        }

        .vp-product-create-content .vp-pc-image-dropzone-text {
            color: #9ca3af;
            font-size: 14px;
            font-weight: 500;
        }

        .vp-product-create-content .vp-pc-image-dropzone--has-file .vp-pc-image-dropzone-text {
            color: #111827;
        }

        .vp-product-create-content .vp-pc-image-help .help-block {
            margin-top: 4px;
            margin-bottom: 0;
            color: #374151 !important;
        }

        .vp-product-create-content .vp-pc-image-help .help-block:first-child {
            margin-top: 10px;
        }

        .vp-product-create-content .vp-pc-grid-spacer {
            min-height: 1px;
        }

        .vp-product-create-content .vp-pc-image-dropzone--compact {
            min-height: 88px;
            padding: 10px 8px;
        }

        .vp-product-create-content .vp-pc-image-dropzone--compact .vp-pc-image-upload-icon {
            font-size: 22px;
        }

        .vp-product-create-content .vp-pc-image-dropzone--compact .vp-pc-image-dropzone-text,
        .vp-product-create-content .vp-pc-image-dropzone--compact .vp-pc-variation-dropzone-text {
            font-size: 13px;
        }

        .vp-product-create-content .vp-pc-pricing-dropdowns {
            margin-bottom: 8px;
        }

        .vp-product-create-content .vp-pc-vendo-price-table {
            margin-bottom: 0;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px;
            overflow: hidden;
        }

        .vp-product-create-content .vp-pc-vendo-price-table > tbody > tr:first-child > th,
        .vp-product-create-content .vp-pc-vendo-price-table > tr:first-child > th {
            background: #39ad48 !important;
            color: #fff !important;
            font-size: 13px;
            font-weight: 700;
            border: 0 !important;
            border-right: 1px solid rgba(255, 255, 255, 0.35) !important;
            padding: 10px 12px !important;
            vertical-align: middle;
        }

        .vp-product-create-content .vp-pc-vendo-price-table > tbody > tr:first-child > th:last-child,
        .vp-product-create-content .vp-pc-vendo-price-table > tr:first-child > th:last-child {
            border-right: 0 !important;
        }

        .vp-product-create-content .vp-pc-vendo-price-table > tbody > tr:nth-child(2) > td,
        .vp-product-create-content .vp-pc-vendo-price-table > tr:nth-child(2) > td {
            background: #fff !important;
            border-color: #e5e7eb !important;
            vertical-align: top;
            padding: 12px 10px !important;
        }

        .vp-product-create-content .vp-pc-vendo-price-table td.vp-pc-vendo-td {
            vertical-align: top;
        }

        .vp-product-create-content .vp-pc-vendo-dpp-cell label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.35;
            min-height: 1.35em;
            color: #111827 !important;
        }

        .vp-product-create-content .vp-pc-vendo-dsp-label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.35;
            min-height: 1.35em;
            color: #111827 !important;
        }

        .vp-product-create-content .vp-pc-vendo-label-spacer {
            display: block;
            min-height: 1.35em;
            margin-bottom: 6px;
            line-height: 1.35;
        }

        .vp-product-create-content .vp-pc-vendo-td-margin .form-control#profit_percent,
        .vp-product-create-content .vp-pc-vendo-td-dpp .form-control,
        .vp-product-create-content .vp-pc-vendo-td-dsp .form-control#single_dsp {
            margin-top: 0;
        }

        .vp-product-create-content .vp-pc-vendo-price-table .form-group {
            margin-bottom: 8px;
        }

        .vp-product-create-content .vp-pc-vendo-price-table .vp-pc-variation-image-field .vp-pc-image-help .help-block {
            margin-top: 4px;
        }

        .vp-product-create-content .add-product-price-table .form-control {
            height: 38px;
            border-radius: 6px !important;
            border: 1px solid #d1d5db !important;
        }

        .vp-product-create-footer {
            background: #2d3555 !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            box-shadow: none !important;
            padding: 16px 20px;
            margin-top: 4px;
        }

        .vp-pc-action-buttons {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .vp-pc-btn {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.25;
            padding: 10px 20px;
            min-height: 44px;
            border-radius: 6px !important;
            border: none !important;
            box-shadow: none !important;
            transition: background 0.15s ease, opacity 0.15s ease;
        }

        .vp-pc-btn-opening {
            background: #32a832 !important;
            color: #fff !important;
        }

        .vp-pc-btn-opening:hover:not(:disabled) {
            background: #2a922a !important;
            color: #fff !important;
        }

        .vp-pc-btn-opening:disabled {
            opacity: 0.55;
        }

        .vp-pc-btn-save {
            background: #21255d !important;
            color: #fff !important;
        }

        .vp-pc-btn-save:hover {
            background: #1a1d4a !important;
            color: #fff !important;
        }

        .vp-pc-btn-save-another {
            background: #d4d4d4 !important;
            color: #111827 !important;
        }

        .vp-pc-btn-save-another:hover {
            background: #c4c4c4 !important;
            color: #111827 !important;
        }

        /* Same flex row packing as Vendo shell forms (see vendo_form_shell_wrap_styles). */
        .vp-product-create-content .row {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .vp-product-create-content .row::before,
        .vp-product-create-content .row::after {
            content: none !important;
            display: none !important;
        }

        .vp-product-create-content .row > [class*='col-'] {
            float: none !important;
        }

        .vp-product-create-content .row > .clearfix {
            display: none !important;
        }

        @media (max-width: 991px) {
            .vp-products-page-wrap {
                margin: 14px 12px 16px;
                padding: 14px;
            }

            .vp-product-create-card-title {
                font-size: 22px;
            }
        }

</style>
