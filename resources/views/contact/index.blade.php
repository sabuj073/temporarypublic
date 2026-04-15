@extends('layouts.app')
@section('title', __('lang_v1.' . $type . 's'))
@php
    $api_key = env('GOOGLE_MAP_API_KEY');
@endphp
@section('css')
    @if (!empty($api_key))
        @include('contact.partials.google_map_styles')
    @endif
    <style>
        .vp-contacts-page-wrap {
            margin: 22px 26px 28px;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: linear-gradient(140deg, rgba(51, 80, 142, 0.45) 0%, rgba(35, 57, 118, 0.5) 100%);
        }

        .vp-contacts-header {
            margin: 0 0 10px !important;
        }

        .vp-contacts-header h1 {
            color: #fff !important;
            font-size: 34px !important;
            font-weight: 700 !important;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .vp-contacts-header h1 small {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px !important;
            font-weight: 500 !important;
        }

        .vp-contacts-back-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(18, 29, 64, 0.18);
            flex-shrink: 0;
        }

        .vp-contacts-back-btn img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }

        .vp-contact-filter-host > div {
            background: #fff !important;
            border-radius: 12px 12px 0 0 !important;
            border: none !important;
            box-shadow: none !important;
            margin-bottom: 0 !important;
            overflow: visible !important;
            padding: 0 12px 10px;
        }

        .vp-contact-filter-host .box-header {
            padding: 0 !important;
        }

        .vp-contact-filter-host .box-title {
            padding: 10px 0 6px !important;
        }

        .vp-contact-filter-host .box-title a {
            color: #2d366d !important;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none !important;
        }

        .vp-contact-filter-host #collapseFilter {
            display: block !important;
            height: auto !important;
            visibility: visible !important;
            padding: 6px 0 0 !important;
        }

        .vp-contact-filter-host .box-body {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 0 !important;
        }

        .vp-contact-filter-host .box-body .col-md-3 {
            float: none !important;
            width: auto !important;
            flex: 1 1 220px;
            padding: 0;
        }

        .vp-contact-filter-host .form-group {
            margin-bottom: 0 !important;
        }

        .vp-contact-filter-host label {
            color: #232f66 !important;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .vp-contact-filter-host .form-control,
        .vp-contact-filter-host .select2-selection {
            height: 34px !important;
            border: 1px solid #cfd5ea !important;
            border-radius: 6px !important;
            font-size: 13px !important;
            color: #2f3970;
        }

        .vp-contact-filter-host .select2-selection__rendered {
            line-height: 32px !important;
        }

        .vp-contact-filter-host .select2-selection__arrow {
            height: 32px !important;
        }

        .vp-contact-table-card {
            background: #fff !important;
            border-radius: 0 0 12px 12px !important;
            border: none !important;
            box-shadow: none !important;
            margin-top: 0 !important;
            overflow: visible !important;
        }

        .vp-contact-table-card > .tw-p-2 {
            padding: 10px 12px 12px !important;
        }

        .vp-contact-table-card .box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .vp-contact-table-card .box-title {
            margin: 0 !important;
            color: #2d366d !important;
            font-size: 34px;
            font-weight: 700;
        }

        .vp-contact-table-card .box-tools {
            float: none !important;
            margin: 0 !important;
        }

        .vp-contact-table-card .tw-flow-root > div > .tw-py-2 {
            padding: 0 !important;
        }

        .vp-contact-table-card .table-responsive {
            border-radius: 0 !important;
            overflow: visible;
            margin-bottom: 0;
        }

        .vp-contact-table-card #contact_table_wrapper,
        .vp-contact-table-card .dataTables_scroll,
        .vp-contact-table-card .dataTables_scrollHead,
        .vp-contact-table-card .dataTables_scrollBody,
        .vp-contact-table-card .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        .vp-contact-table-card #contact_table {
            width: 100% !important;
        }

        .vp-contact-table-card table.dataTable thead th {
            color: #303a73 !important;
            background: #fbfbff;
            border-bottom: 1px solid #e3e6f3 !important;
            font-weight: 700;
            font-size: 12px;
        }

        .vp-contact-table-card table.dataTable tbody td {
            font-size: 12px;
            color: #2f3a67;
        }

        .vp-contact-table-card #contact_table .btn-group .btn,
        .vp-contact-table-card #contact_table .btn,
        .vp-contact-table-card #contact_table .dropdown-toggle {
            background: #27306f !important;
            border-color: #27306f !important;
            color: #fff !important;
        }

        .vp-contact-table-card #contact_table .dropdown-menu {
            z-index: 1051;
        }

        .vp-contact-table-card .footer-total {
            background: #27306f !important;
            color: #fff !important;
        }

        .vp-contact-table-card .footer-total td,
        .vp-contact-table-card .footer-total strong {
            color: #fff !important;
        }

        .vp-contact-top-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-left: auto;
            flex-wrap: nowrap;
        }

        .vp-contact-top-actions .dataTables_filter,
        .vp-contact-top-actions .dataTables_length,
        .vp-contact-top-actions .box-tools {
            margin: 0 !important;
            float: none !important;
        }

        .vp-contact-top-actions .dataTables_filter label,
        .vp-contact-top-actions .dataTables_length label {
            margin: 0 !important;
            font-size: 13px;
            font-weight: 600;
            color: #2a336e;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .vp-contact-top-actions .dataTables_filter input,
        .vp-contact-top-actions .dataTables_length select {
            height: 34px !important;
            border: 1px solid #cfd5ea !important;
            border-radius: 6px !important;
            padding: 6px 10px !important;
            font-size: 13px !important;
            color: #2f3970;
        }

        .vp-contact-top-actions .tw-dw-btn {
            min-width: 108px;
            height: 34px;
            border-radius: 6px !important;
            border: none !important;
            background: #27306f !important;
            color: #fff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 12px !important;
        }

        .vp-contact-top-actions .tw-dw-btn svg {
            width: 14px;
            height: 14px;
        }

        .vp-contact-export-actions {
            margin-top: 12px;
            display: flex;
            justify-content: center;
        }

        .vp-contact-export-actions .dt-buttons {
            display: inline-flex;
            gap: 8px;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #cdd4e8;
            box-shadow: 0 4px 12px rgba(21, 31, 66, 0.15);
        }

        .vp-contact-export-actions .dt-button {
            background: #27306f !important;
            color: #fff !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 7px 12px !important;
            font-size: 13px !important;
        }

        @media (max-width: 991px) {
            .vp-contacts-page-wrap {
                margin: 14px 12px 16px;
                padding: 14px;
            }

            .vp-contacts-header h1 {
                font-size: 26px !important;
                flex-wrap: wrap;
            }

            .vp-contact-table-card .box-header {
                flex-wrap: wrap;
            }

            .vp-contact-top-actions {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }
        }
    </style>
@endsection
@section('content')
    <div class="vp-contacts-page-wrap">
    <!-- Content Header (Page header) -->
    <section class="content-header vp-contacts-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">
            <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-contacts-back-btn" aria-label="Back to home">
                <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="Back">
            </a>
            @lang('lang_v1.' . $type . 's')
            <small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold">@lang('contact.manage_your_contact', ['contacts' => __('lang_v1.' . $type . 's')])</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content vp-contacts-content">
        <div class="vp-contact-filter-host">
        @component('components.filters', ['title' => __('report.filters')])
            @if ($type == 'customer')
                <div class="col-md-3">
                    <div class="form-group">
                        <label>
                            {!! Form::checkbox('has_sell_due', 1, false, ['class' => 'input-icheck', 'id' => 'has_sell_due']) !!} <strong>@lang('lang_v1.sell_due')</strong>
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>
                            {!! Form::checkbox('has_sell_return', 1, false, ['class' => 'input-icheck', 'id' => 'has_sell_return']) !!} <strong>@lang('lang_v1.sell_return')</strong>
                        </label>
                    </div>
                </div>
            @elseif($type == 'supplier')
                <div class="col-md-3">
                    <div class="form-group">
                        <label>
                            {!! Form::checkbox('has_purchase_due', 1, false, ['class' => 'input-icheck', 'id' => 'has_purchase_due']) !!} <strong>@lang('report.purchase_due')</strong>
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>
                            {!! Form::checkbox('has_purchase_return', 1, false, ['class' => 'input-icheck', 'id' => 'has_purchase_return']) !!} <strong>@lang('lang_v1.purchase_return')</strong>
                        </label>
                    </div>
                </div>
            @endif
            <div class="col-md-3">
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('has_advance_balance', 1, false, ['class' => 'input-icheck', 'id' => 'has_advance_balance']) !!} <strong>@lang('lang_v1.advance_balance')</strong>
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('has_opening_balance', 1, false, ['class' => 'input-icheck', 'id' => 'has_opening_balance']) !!} <strong>@lang('lang_v1.opening_balance')</strong>
                    </label>
                </div>
            </div>
            @if ($type == 'customer')
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="has_no_sell_from">@lang('lang_v1.has_no_sell_from'):</label>
                        {!! Form::select(
                            'has_no_sell_from',
                            [
                                'one_month' => __('lang_v1.one_month'),
                                'three_months' => __('lang_v1.three_months'),
                                'six_months' => __('lang_v1.six_months'),
                                'one_year' => __('lang_v1.one_year'),
                            ],
                            null,
                            ['class' => 'form-control', 'id' => 'has_no_sell_from', 'placeholder' => __('messages.please_select')],
                        ) !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cg_filter">@lang('lang_v1.customer_group'):</label>
                        {!! Form::select('cg_filter', $customer_groups, null, ['class' => 'form-control', 'id' => 'cg_filter']) !!}
                    </div>
                </div>
            @endif

            @if (config('constants.enable_contact_assign') === true)
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('assigned_to', __('lang_v1.assigned_to') . ':') !!}
                        {!! Form::select('assigned_to', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                    </div>
                </div>
            @endif

            <div class="col-md-3">
                <div class="form-group">
                    <label for="status_filter">@lang('sale.status'):</label>
                    {!! Form::select(
                        'status_filter',
                        ['active' => __('business.is_active'), 'inactive' => __('lang_v1.inactive')],
                        null,
                        ['class' => 'form-control', 'id' => 'status_filter', 'placeholder' => __('lang_v1.none')],
                    ) !!}
                </div>
            </div>
        @endcomponent
        </div>
        <input type="hidden" value="{{ $type }}" id="contact_type">
        @component('components.widget', [
            'class' => 'box-primary vp-contact-table-card',
            'title' => __('contact.all_your_contact', ['contacts' => __('lang_v1.' . $type . 's')]),
        ])
            @if (auth()->user()->can('supplier.create') ||
                    auth()->user()->can('customer.create') ||
                    auth()->user()->can('supplier.view_own') ||
                    auth()->user()->can('customer.view_own'))
                @slot('tool')
                    <div class="box-tools">
                        <a class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full btn-modal"
                                data-href="{{ action([\App\Http\Controllers\ContactController::class, 'create'], ['type' => $type]) }}"
                                data-container=".contact_modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                                </svg> @lang('messages.add')
                        </a>
                    </div>
                @endslot
            @endif
            @if (auth()->user()->can('supplier.view') ||
                    auth()->user()->can('customer.view') ||
                    auth()->user()->can('supplier.view_own') ||
                    auth()->user()->can('customer.view_own'))
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="contact_table">
                        <thead>
                            <tr>
                                <th class="tw-w-full">@lang('messages.action')</th>
                                <th>@lang('lang_v1.contact_id')</th>
                                @if ($type == 'supplier')
                                    <th>@lang('business.business_name')</th>
                                    <th>@lang('contact.name')</th>
                                    <th>@lang('business.email')</th>
                                    <th>@lang('contact.tax_no')</th>
                                    <th>@lang('contact.pay_term')</th>
                                    <th>@lang('account.opening_balance')</th>
                                    <th>@lang('lang_v1.advance_balance')</th>
                                    <th>@lang('lang_v1.added_on')</th>
                                    <th>@lang('business.address')</th>
                                    <th>@lang('contact.mobile')</th>
                                    <th>@lang('contact.total_purchase_due')</th>
                                    <th>@lang('lang_v1.total_purchase_return_due')</th>
                                @elseif($type == 'customer')
                                    <th>@lang('business.business_name')</th>
                                    <th>@lang('user.name')</th>
                                    <th>@lang('business.email')</th>
                                    <th>@lang('contact.tax_no')</th>
                                    <th>@lang('lang_v1.credit_limit')</th>
                                    <th>@lang('contact.pay_term')</th>
                                    <th>@lang('account.opening_balance')</th>
                                    <th>@lang('lang_v1.advance_balance')</th>
                                    <th>@lang('lang_v1.added_on')</th>
                                    @if ($reward_enabled)
                                        <th id="rp_col">{{ session('business.rp_name') }}</th>
                                    @endif
                                    <th>@lang('lang_v1.customer_group')</th>
                                    <th>@lang('business.address')</th>
                                    <th>@lang('contact.mobile')</th>
                                    <th>@lang('contact.total_sale_due')</th>
                                    <th>@lang('lang_v1.total_sell_return_due')</th>
                                @endif
                                @php
                                    $custom_labels = json_decode(session('business.custom_labels'), true);
                                @endphp
                                <th>
                                    {{ $custom_labels['contact']['custom_field_1'] ?? __('lang_v1.contact_custom_field1') }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_2'] ?? __('lang_v1.contact_custom_field2') }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_3'] ?? __('lang_v1.contact_custom_field3') }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_4'] ?? __('lang_v1.contact_custom_field4') }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_5'] ?? __('lang_v1.custom_field', ['number' => 5]) }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_6'] ?? __('lang_v1.custom_field', ['number' => 6]) }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_7'] ?? __('lang_v1.custom_field', ['number' => 7]) }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_8'] ?? __('lang_v1.custom_field', ['number' => 8]) }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_9'] ?? __('lang_v1.custom_field', ['number' => 9]) }}
                                </th>
                                <th>
                                    {{ $custom_labels['contact']['custom_field_10'] ?? __('lang_v1.custom_field', ['number' => 10]) }}
                                </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-gray font-17 text-center footer-total">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td @if ($type == 'supplier') colspan="6"
                            @elseif($type == 'customer')
                                @if ($reward_enabled)
                                    colspan="9"
                                @else
                                    colspan="8" @endif
                                    @endif>
                                    <strong>
                                        @lang('sale.total'):
                                    </strong>
                                </td>
                                <td class="footer_contact_due"></td>
                                <td class="footer_contact_return_due"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div id="vp-contact-export-actions" class="vp-contact-export-actions"></div>
            @endif
        @endcomponent

        <div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        <div class="modal fade pay_contact_due_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->
    </div>
@stop
@section('javascript')
    @if (!empty($api_key))
        <script>
            // This example adds a search box to a map, using the Google Place Autocomplete
            // feature. People can enter geographical searches. The search box will return a
            // pick list containing a mix of places and predicted search terms.

            // This example requires the Places library. Include the libraries=places
            // parameter when you first load the API. For example:
            // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

            function initAutocomplete() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: -33.8688,
                        lng: 151.2195
                    },
                    zoom: 10,
                    mapTypeId: 'roadmap'
                });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        map.setCenter(initialLocation);
                    });
                }


                // Create the search box and link it to the UI element.
                var input = document.getElementById('shipping_address');
                var searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function() {
                    searchBox.setBounds(map.getBounds());
                });

                var markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {
                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                            map: map,
                            icon: icon,
                            title: place.name,
                            position: place.geometry.location
                        }));

                        //set position field value
                        var lat_long = [place.geometry.location.lat(), place.geometry.location.lng()]
                        $('#position').val(lat_long);

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ $api_key }}&libraries=places" async defer></script>
        <script type="text/javascript">
            $(document).on('shown.bs.modal', '.contact_modal', function(e) {
                initAutocomplete();
            });
        </script>
    @endif
    <script type="text/javascript">
        $(document).ready(function() {
            function moveContactTopActions() {
                var $header = $('.vp-contact-table-card .box-header').first();
                if (!$header.length) {
                    return;
                }

                var $actionWrap = $header.find('.vp-contact-top-actions');
                if (!$actionWrap.length) {
                    $actionWrap = $('<div class="vp-contact-top-actions"></div>');
                    $header.append($actionWrap);
                }

                var $filter = $('#contact_table_wrapper .dataTables_filter');
                var $length = $('#contact_table_wrapper .dataTables_length');
                var $boxTools = $header.children('.box-tools');

                if ($filter.length) {
                    $actionWrap.append($filter);
                }
                if ($length.length) {
                    $actionWrap.append($length);
                }
                if ($boxTools.length) {
                    $actionWrap.append($boxTools);
                }
            }

            function moveContactExportButtons() {
                var $buttons = $('#contact_table_wrapper .dt-buttons');
                if ($buttons.length && $('#vp-contact-export-actions').length) {
                    $('#vp-contact-export-actions').empty().append($buttons);
                }
            }

            setTimeout(function() {
                moveContactTopActions();
                moveContactExportButtons();
            }, 400);

            $('#contact_table').on('draw.dt', moveContactTopActions);
            $('#contact_table').on('draw.dt', moveContactExportButtons);
        });
    </script>
@endsection
