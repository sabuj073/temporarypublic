$(document).ready(function() {
    $(document).on('click', 'a.delete_expense', function(e) {
        e.preventDefault();
        var $link = $(this);
        swal({
            title: LANG.sure,
            text: LANG.confirm_delete_expense,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(function(willDelete) {
            if (willDelete) {
                var href = $link.data('href');
                var data = $link.serialize();

                $.ajax({
                    method: 'DELETE',
                    url: href,
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success === true) {
                            toastr.success(result.msg);
                            if (typeof expense_table !== 'undefined' && expense_table) {
                                expense_table.ajax.reload();
                            }
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            }
        });
    });

    if (!$('#expense_table').length || !$('#expense_table').closest('.vp-expenses-page-wrap').length) {
        return;
    }

    if ($('#expense_date_range').length === 1) {
        $('#expense_date_range').daterangepicker(
            dateRangeSettings,
            function(start, end) {
                $('#expense_date_range').val(
                    start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                );
                if (typeof expense_table !== 'undefined' && expense_table) {
                    expense_table.ajax.reload();
                }
            }
        );

        $('#expense_date_range').on('cancel.daterangepicker', function() {
            $('#expense_date_range').val('');
            if (typeof expense_table !== 'undefined' && expense_table) {
                expense_table.ajax.reload();
            }
        });
    }

    var _expense_table_opts = {
        processing: true,
        serverSide: true,
        fixedHeader: false,
        aaSorting: [[0, 'desc']],
        ajax: {
            url: '/expenses',
            data: function(d) {
                d.expense_for = $('select#expense_for').val();
                d.created_by = $('select#created_by').val();
                d.contact_id = $('select#expense_contact_filter').val();
                d.location_id = $('select#location_id').val();
                d.expense_category_id = $('select#expense_category_id').val();
                d.expense_sub_category_id = $('select#expense_sub_category_id_filter').val();
                d.payment_status = $('select#expense_payment_status').val();
                var $dr = $('input#expense_date_range');
                if ($dr.length && $dr.data('daterangepicker')) {
                    d.start_date = $dr.data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.end_date = $dr.data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
        },
        columns: [
            { data: 'transaction_date', name: 'transaction_date' },
            { data: 'ref_no', name: 'ref_no' },
            { data: 'recur_details', name: 'recur_details', orderable: false, searchable: false },
            { data: 'category', name: 'ec.name' },
            { data: 'sub_category', name: 'esc.name' },
            { data: 'location_name', name: 'bl.name' },
            { data: 'payment_status', name: 'payment_status', orderable: false },
            { data: 'tax', name: 'tr.name' },
            { data: 'final_total', name: 'final_total' },
            { data: 'payment_due', name: 'payment_due' },
            { data: 'expense_for', name: 'expense_for' },
            { data: 'contact_name', name: 'c.name' },
            { data: 'additional_notes', name: 'additional_notes' },
            { data: 'added_by', name: 'usr.first_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        fnDrawCallback: function() {
            var expense_total = sum_table_col($('#expense_table'), 'final-total');
            var total_due = sum_table_col($('#expense_table'), 'payment_due');

            $('.footer_expense_total').html(__currency_trans_from_en(expense_total));
            $('.footer_total_due').html(__currency_trans_from_en(total_due));

            $('.footer_payment_status_count').html(__sum_status_html($('#expense_table'), 'payment-status'));

            if (typeof window.__vpExpensesMoveLayout === 'function') {
                window.__vpExpensesMoveLayout();
            }
        },
        initComplete: function() {
            if (typeof window.__vpExpensesMoveLayout === 'function') {
                window.__vpExpensesMoveLayout();
            }
        },
        createdRow: function(row) {
            $(row)
                .find('td:eq(3)')
                .attr('class', 'clickable_td');
        },
    };

    if (typeof window.__vpExpensesDataTableOverrides !== 'undefined' && window.__vpExpensesDataTableOverrides !== null) {
        $.extend(true, _expense_table_opts, window.__vpExpensesDataTableOverrides);
    }

    expense_table = $('#expense_table').DataTable(_expense_table_opts);

    $(
        'select#location_id, select#expense_for, select#created_by, select#expense_contact_filter, ' +
            'select#expense_category_id, select#expense_payment_status, select#expense_sub_category_id_filter'
    ).on('change', function() {
        expense_table.ajax.reload();
    });
});
