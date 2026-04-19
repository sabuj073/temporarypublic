@extends('layouts.app')
@section('title', __('user.users'))

@section('css')
    @include('manage_user.partials.vendo_users_page_styles')
@endsection

@section('content')
    <div class="vp-users-page-wrap no-print">
        <div class="vp-users-shell">
            <div class="vp-users-page-head">
                <button type="button" class="vp-users-back" id="vp_users_back_btn" title="{{ __('messages.go_back') }}"
                    aria-label="{{ __('messages.go_back') }}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <h1 class="vp-users-page-title">@lang('user.users')</h1>
            </div>

            <div class="vp-users-card">
                <div class="vp-users-card-toolbar">
                    <h2 class="vp-users-card-title">@lang('user.all_users')</h2>
                    <div class="vp-users-card-toolbar-end">
                        <div class="vp-users-slot vp-users-filter-slot"></div>
                        <div class="vp-users-slot vp-users-length-slot"></div>
                        @can('user.create')
                            <a class="vp-users-add-btn" href="{{ action([\App\Http\Controllers\ManageUserController::class, 'create']) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>
                        @endcan
                    </div>
                </div>

                @can('user.view')
                    <div class="vp-users-table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover vp-users-dt" id="users_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('business.username')</th>
                                        <th>@lang('user.name')</th>
                                        <th>@lang('user.role')</th>
                                        <th>@lang('business.email')</th>
                                        <th>@lang('messages.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div id="vp-users-export-actions" class="vp-users-export-actions"></div>
                    <div class="vp-users-card-footer">
                        <div class="vp-users-slot vp-users-info-slot"></div>
                        <div class="vp-users-slot vp-users-paginate-slot"></div>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="modal fade user_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#vp_users_back_btn').on('click', function() {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.assign(
                        '{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}');
                }
            });

            @can('user.view')
                var pageLen = parseInt(
                    typeof __default_datatable_page_entries !== 'undefined' ? __default_datatable_page_entries : '25',
                    10);
                if (isNaN(pageLen) || pageLen < 1) {
                    pageLen = 25;
                }

                var usersDtOpts = {
                    processing: true,
                    serverSide: true,
                    fixedHeader: false,
                    ajax: '/users',
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: pageLen,
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    columnDefs: [{
                        targets: [4],
                        orderable: false,
                        searchable: false
                    }],
                    columns: [{
                            data: 'username'
                        },
                        {
                            data: 'full_name'
                        },
                        {
                            data: 'role'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'action'
                        }
                    ],
                    initComplete: function() {
                        moveUsersTableControls();
                        moveUsersExportButtons();
                    }
                };

                @cannot('view_export_buttons')
                    usersDtOpts.dom = 'lfrtip';
                    usersDtOpts.buttons = [];
                @endcannot

                var users_table = $('#users_table').DataTable(usersDtOpts);

                function moveUsersTableControls() {
                    var w = $('#users_table_wrapper');
                    if (!w.length) {
                        return;
                    }
                    w.find('.dataTables_filter').appendTo('.vp-users-filter-slot');
                    w.find('.dataTables_length').appendTo('.vp-users-length-slot');
                    w.find('.dataTables_info').appendTo('.vp-users-info-slot');
                    w.find('.dataTables_paginate').appendTo('.vp-users-paginate-slot');
                    w.find('.row.margin-bottom-20').first().hide();
                    $('.vp-users-filter-slot .dataTables_filter input').attr('type', 'search').attr(
                        'autocomplete', 'off');
                    if (typeof LANG !== 'undefined' && LANG.search) {
                        $('.vp-users-filter-slot .dataTables_filter input').attr('placeholder', LANG.search +
                            ' ...');
                    }
                }

                function moveUsersExportButtons() {
                    var $buttons = $('#users_table_wrapper .dt-buttons');
                    if ($buttons.length && $('#vp-users-export-actions').length) {
                        $('#vp-users-export-actions').empty().append($buttons);
                    }
                }

                setTimeout(function() {
                    moveUsersTableControls();
                    moveUsersExportButtons();
                }, 400);
                $('#users_table').on('draw.dt', function() {
                    moveUsersTableControls();
                    moveUsersExportButtons();
                });

                $(document).on('click', 'button.delete_user_button', function() {
                    var $btn = $(this);
                    swal({
                        title: LANG.sure,
                        text: LANG.confirm_delete_user,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            var href = $btn.data('href');
                            var data = $btn.serialize();
                            $.ajax({
                                method: "DELETE",
                                url: href,
                                dataType: "json",
                                data: data,
                                success: function(result) {
                                    if (result.success == true) {
                                        toastr.success(result.msg);
                                        users_table.ajax.reload();
                                    } else {
                                        toastr.error(result.msg);
                                    }
                                }
                            });
                        }
                    });
                });
            @endcan
        });
    </script>
@endsection
