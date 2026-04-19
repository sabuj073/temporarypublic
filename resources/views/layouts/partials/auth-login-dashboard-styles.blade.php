@php
    $loginDashboardBg = file_exists(public_path('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg'))
        ? asset('images/49ec31f1f87aef66d6806918046454b221e3915a.jpg')
        : null;
@endphp
<style>
    html.vp-login-dashboard-page {
        height: 100%;
        background-color: #24255b !important;
        @if (!empty($loginDashboardBg))
            background-image:
                linear-gradient(0deg, rgba(36, 37, 91, 0.8), rgba(36, 37, 91, 0.8)),
                url('{{ $loginDashboardBg }}') !important;
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
        @else
            background-image: linear-gradient(125deg, #151c3d 0%, #24255b 42%, #2a377f 100%) !important;
            background-attachment: fixed;
        @endif
    }

    html.vp-login-dashboard-page body {
        background: transparent !important;
    }

    /* Vertical center: reserve top bar, flex main login row */
    html.vp-login-dashboard-page .right-col {
        display: flex !important;
        flex-direction: column;
        min-height: 100vh !important;
        padding-top: 0.5rem !important;
        padding-bottom: 1.5rem !important;
    }

    html.vp-login-dashboard-page .right-col > .row:first-of-type {
        flex: 0 0 auto;
        min-height: 4.25rem;
        position: relative;
    }

    html.vp-login-dashboard-page .vp-login-page-center-wrap {
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: center;
        width: 100%;
        align-self: stretch;
        min-height: calc(100vh - 5.5rem);
        box-sizing: border-box;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    /* Bootstrap row inside flex must stay full width (otherwise it collapses to a narrow strip) */
    html.vp-login-dashboard-page .vp-login-page-center-wrap > .vp-login-root-row {
        width: 100% !important;
        max-width: 1140px;
        margin-left: auto !important;
        margin-right: auto !important;
        float: none !important;
    }

    html.vp-login-dashboard-page .right-col a:hover {
        color: #fff !important;
    }

    html.vp-login-dashboard-page .vp-login-demo-col .tw-bg-white {
        background: linear-gradient(140deg, rgba(40, 62, 118, 0.55) 0%, rgba(28, 42, 98, 0.65) 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.28) !important;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12), 0 12px 36px rgba(3, 6, 27, 0.45) !important;
        color: rgba(255, 255, 255, 0.92) !important;
        --tw-ring-color: rgba(255, 255, 255, 0.15) !important;
    }

    html.vp-login-dashboard-page .vp-login-demo-col .box-header,
    html.vp-login-dashboard-page .vp-login-demo-col .box-header h4,
    html.vp-login-dashboard-page .vp-login-demo-col .box-header small {
        color: rgba(255, 255, 255, 0.95) !important;
    }

    html.vp-login-dashboard-page .vp-login-demo-col .btn-app {
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    html.vp-login-dashboard-page .vp-login-shell {
        width: 100%;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
        box-sizing: border-box;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(140deg, rgba(63, 102, 156, 0.42) 0%, rgba(35, 63, 127, 0.5) 100%);
        border: 1px solid rgba(255, 255, 255, 0.35);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18), 0 16px 40px rgba(3, 6, 27, 0.42);
    }

    @media (min-width: 768px) {
        html.vp-login-dashboard-page .vp-login-shell {
            padding: 1.5rem 1.75rem;
        }
    }

    html.vp-login-dashboard-page .vp-login-shell-inner {
        max-width: 100%;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    html.vp-login-dashboard-page .vp-login-shell .form-group label.tw-dw-form-control {
        position: relative;
    }

    html.vp-login-dashboard-page .vp-login-shell .vp-login-input {
        width: 100%;
        height: 3rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.28) !important;
        background: rgba(12, 18, 46, 0.45) !important;
        color: #fff !important;
        outline: none;
        padding-left: 0.75rem;
        padding-right: 2.5rem;
        font-weight: 500;
    }

    html.vp-login-dashboard-page .vp-login-shell .vp-login-input::placeholder {
        color: rgba(255, 255, 255, 0.45) !important;
    }

    html.vp-login-dashboard-page .vp-login-shell .vp-login-input:focus {
        border-color: rgba(147, 197, 253, 0.65) !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
    }

    html.vp-login-dashboard-page .vp-login-shell .has-error .vp-login-input {
        border-color: rgba(248, 113, 113, 0.85) !important;
    }

    html.vp-login-dashboard-page .vp-login-shell .help-block strong {
        color: #fecaca !important;
    }

    html.vp-login-dashboard-page .vp-login-shell label.tw-dw-form-control:has(#password) .show_hide_icon {
        position: absolute;
        top: auto;
        bottom: 0.55rem;
        right: 0.35rem;
        background: transparent;
        border: 0;
        padding: 0.25rem;
        cursor: pointer;
        line-height: 0;
    }

    html.vp-login-dashboard-page .vp-login-shell .show_hide_icon svg {
        stroke: currentColor;
        color: rgba(255, 255, 255, 0.88);
    }

    html.vp-login-dashboard-page .vp-login-submit {
        width: 100%;
        max-width: 100%;
        height: 3rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.22);
        margin-top: 0.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #fff !important;
        cursor: pointer;
        background: linear-gradient(140deg, rgba(88, 130, 190, 0.95) 0%, rgba(44, 78, 150, 0.98) 100%);
        box-shadow: 0 8px 22px rgba(8, 14, 42, 0.35);
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    html.vp-login-dashboard-page .vp-login-submit:hover {
        filter: brightness(1.06);
        box-shadow: 0 12px 28px rgba(8, 14, 42, 0.45);
    }

    html.vp-login-dashboard-page .vp-login-shell .tw-dw-checkbox {
        border-color: rgba(255, 255, 255, 0.45);
    }

    html.vp-login-dashboard-page .vp-login-shell .text-danger {
        color: #fecaca !important;
    }

    html.vp-login-dashboard-page .vp-login-shell .g-recaptcha {
        transform-origin: left top;
    }

    /* Force readable white text (overrides Bootstrap / DaisyUI on dark card) */
    html.vp-login-dashboard-page .vp-login-shell,
    html.vp-login-dashboard-page .vp-login-shell h1,
    html.vp-login-dashboard-page .vp-login-shell h2,
    html.vp-login-dashboard-page .vp-login-shell h3,
    html.vp-login-dashboard-page .vp-login-shell label,
    html.vp-login-dashboard-page .vp-login-shell .tw-dw-label,
    html.vp-login-dashboard-page .vp-login-shell .tw-dw-label span,
    html.vp-login-dashboard-page .vp-login-shell .form-group,
    html.vp-login-dashboard-page .vp-login-shell .tw-dw-form-control,
    html.vp-login-dashboard-page .vp-login-shell a:not(.vp-login-submit) {
        color: #ffffff !important;
    }

    html.vp-login-dashboard-page .vp-login-shell a:not(.vp-login-submit):hover,
    html.vp-login-dashboard-page .vp-login-shell a:not(.vp-login-submit):focus {
        color: #ffffff !important;
        text-decoration: underline;
    }

    html.vp-login-dashboard-page .vp-login-shell .help-block,
    html.vp-login-dashboard-page .vp-login-shell .help-block strong {
        color: #fecaca !important;
    }
</style>
