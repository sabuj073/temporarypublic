<style id="vp-vendo-scroll-shell-styles">
    /*
     * Long admin forms scroll inside #scrollable-container. The global layout forces
     * transparent backgrounds on that node so the body image shows through — but the body
     * does not move with the inner scroll, which can expose gaps. Paint the same surface
     * on #scrollable-container for designated routes so the background fills while scrolling.
     */
    html.vp-vendo-scroll-shell-html {
        background-color: #24255b !important;
        min-height: 100%;
    }

    body.vp-vendo-scroll-shell #scrollable-container {
        min-height: 100vh;
        background-color: #24255b !important;
        @if (!empty($global_dashboard_bg))
            background-image:
                linear-gradient(0deg, rgba(36, 37, 91, 0.8), rgba(36, 37, 91, 0.8)),
                url('{{ $global_dashboard_bg }}') !important;
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
        @else
            background-image: linear-gradient(120deg, #1c2a62 0%, #242f70 55%, #2a377f 100%) !important;
        @endif
    }
</style>
