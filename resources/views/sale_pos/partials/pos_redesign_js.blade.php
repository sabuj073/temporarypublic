<script>
    $(function () {
        function syncPayableMirror() {
            var $src = $('#total_payable');
            var $dst = $('#vp_pos_total_payable_mirror');
            if ($src.length && $dst.length) {
                $dst.text($.trim($src.text()) || '0.00');
            }
        }

        function setCartTabView(tabName) {
            var $panel = $('.vp-pos-cart-panel-inner');
            if (!$panel.length) {
                return;
            }

            var $customerBlock = $panel.find('.vp-pos-customer-block');
            var $orderArea = $panel.find('.pos_product_div, .pos_form_totals');
            var $actions = $('.vp-pos-cart-col').find('.pos-form-actions');
            var $cartCol = $('.vp-pos-cart-col');

            $panel.attr('data-active-tab', tabName);
            $cartCol.removeClass('is-customers-tab is-orders-tab is-tables-tab').addClass('is-' + tabName + '-tab');

            if (tabName === 'customers') {
                $customerBlock.show();
                $orderArea.hide();
                $actions.hide();
            } else {
                $customerBlock.hide();
                $orderArea.show();
                $actions.show();
            }

            syncPayableMirror();

        }

        var $host = $('#vp_pos_search_host');
        var $sp = $('input#search_product');
        if ($host.length && $sp.length) {
            var $col = $sp.closest('.col-md-8');
            if ($col.length) {
                $col.detach().appendTo($host);
            }
        }

        var $cartPanel = $('.vp-pos-cart-panel-inner');
        if ($cartPanel.length) {
            var $firstRow = $cartPanel.find('> .row').first();
            if ($firstRow.length) {
                $firstRow.addClass('vp-pos-customer-block');
            }
            setCartTabView('orders');
        }
        syncPayableMirror();
        setInterval(syncPayableMirror, 700);

        $(document).on('click', '.vp-pos-cart-tab', function () {
            var tabName = $(this).data('tab');
            $('.vp-pos-cart-tab').removeClass('is-active').removeAttr('aria-current');
            $(this).addClass('is-active').attr('aria-current', 'page');
            setCartTabView(tabName);
        });

        $(document).on('change', '#vp_pos_brand_select', function () {
            if (typeof global_brand_id === 'undefined' || typeof get_product_suggestion_list !== 'function') {
                return;
            }
            var v = $(this).val();
            global_brand_id = v === '' || v === null ? null : v;
            $('input#suggestion_page').val(1);
            get_product_suggestion_list(
                global_p_category_id,
                global_brand_id,
                $('input#location_id').val(),
                null
            );
            if (typeof get_featured_products === 'function') {
                get_featured_products();
            }
        });

        $(document).on('click', '.product_brand', function () {
            var id = $(this).data('value');
            var $sel = $('#vp_pos_brand_select');
            if ($sel.length) {
                $sel.val(String(id));
            }
        });

        $(document).on('click', '.vp-pos-category-pill.main-category', function () {
            $('.vp-pos-category-pill').removeClass('vp-pos-cat-active');
            $(this).addClass('vp-pos-cat-active');
        });

        $(document).on('click', '.tw-dw-drawer-side .main-category[data-parent="0"]', function () {
            var val = $(this).data('value');
            $('.vp-pos-category-pill').removeClass('vp-pos-cat-active');
            $('.vp-pos-category-pill.main-category')
                .filter(function () {
                    return String($(this).data('value')) === String(val);
                })
                .addClass('vp-pos-cat-active');
        });
    });

    // POS cart: minus at minimum quantity is a no-op in common.js; treat it as "remove line" (capture so it runs before delegated handlers).
    document.addEventListener(
        'click',
        function (e) {
            if (!document.body.classList.contains('vp-pos-page')) {
                return;
            }
            var btn = e.target.closest && e.target.closest('#pos_table .input-number .quantity-down');
            if (!btn) {
                return;
            }
            var wrap = btn.closest('.input-number');
            if (!wrap || typeof jQuery === 'undefined' || typeof __read_number !== 'function') {
                return;
            }
            var $input = jQuery(wrap).find('input').first();
            if (!$input.length) {
                return;
            }
            var qty = __read_number($input);
            var step = 1;
            if ($input.data('step')) {
                step = parseFloat($input.data('step'));
                if (isNaN(step) || step <= 0) {
                    step = 1;
                }
            }
            var min = parseFloat($input.data('min'));
            if (isNaN(min)) {
                return;
            }
            if (qty - step >= min - 1e-9) {
                return;
            }
            if (qty > min + 1e-9) {
                return;
            }
            e.preventDefault();
            e.stopImmediatePropagation();
            var $remove = jQuery(btn).closest('tr').find('i.pos_remove_row');
            if ($remove.length) {
                $remove.trigger('click');
            }
        },
        true
    );
</script>
