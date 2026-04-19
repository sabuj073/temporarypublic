@extends('layouts.auth2')
@section('title', config('app.name', 'ultimatePOS'))
@inject('request', 'Illuminate\Http\Request')
@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div
                class="tw-p-5 md:tw-p-6 tw-mb-4 tw-rounded-2xl tw-transition-all tw-duration-200 tw-bg-white tw-shadow-sm tw-ring-1 tw-ring-gray-200">
                <div class="tw-flex tw-flex-col tw-gap-5 tw-dw-rounded-box tw-dw-p-2 md:tw-dw-p-4 tw-dw-max-w-md tw-mx-auto">
                    <div class="tw-flex tw-flex-col tw-items-center tw-text-center tw-gap-1">
                        <h1 class="tw-text-lg md:tw-text-xl tw-font-semibold tw-text-[#1e1e1e]">
                            {{ config('app.name', 'UltimatePOS') }}
                        </h1>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-500 tw-max-w-sm">
                            @lang('lang_v1.login_to_your') {{ config('app.name', 'ultimatePOS') }}
                        </p>
                    </div>

                    <div class="tw-flex tw-flex-col tw-gap-3">
                        <a href="{{ route('login') }}@if (!empty(request()->lang)){{ '?lang=' . request()->lang }}@endif"
                            class="tw-flex tw-items-center tw-justify-center tw-bg-gradient-to-r tw-from-indigo-500 tw-to-blue-500 tw-h-12 tw-rounded-xl tw-text-sm md:tw-text-base tw-text-white tw-font-semibold tw-w-full hover:tw-from-indigo-600 hover:tw-to-blue-600 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-ring-offset-2">
                            {{ __('business.sign_in') }}
                        </a>

                        @if (config('constants.allow_registration'))
                            <a href="{{ route('business.getRegister') }}@if (!empty(request()->lang)){{ '?lang=' . request()->lang }}@endif"
                                class="tw-flex tw-items-center tw-justify-center tw-h-12 tw-rounded-xl tw-text-sm md:tw-text-base tw-font-semibold tw-w-full tw-border-2 tw-border-[#D1D5DA] tw-text-gray-700 hover:tw-border-indigo-400 hover:tw-text-indigo-600 tw-transition-colors">
                                {{ __('business.register') }}
                            </a>
                        @endif
                    </div>

                    <p class="tw-text-center tw-text-xs tw-text-gray-400 tw-mb-0">
                        {{ config('app.name') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
@endsection
