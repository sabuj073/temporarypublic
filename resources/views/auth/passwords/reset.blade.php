@extends('layouts.auth2')

@section('title', __('lang_v1.reset_password'))

@section('content')
    <div class="vp-login-page-center-wrap">
        <div class="row vp-login-root-row">
            <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12">
        <div class="vp-auth-card tw-mb-4 tw-transition-all tw-duration-200">
            <div class="tw-flex tw-flex-col tw-gap-4 tw-dw-rounded-box tw-dw-p-6 tw-dw-max-w-md">
                <h3 class="tw-text-sm tw-font-medium vp-auth-text-muted tw-self-center">@lang('lang_v1.reset_password')</h3>
                <form method="POST" action="{{ route('password.update') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="tw-dw-form-control">
                            <div class="tw-dw-label">
                                <span class="tw-text-xs md:tw-text-sm tw-font-medium">@lang('Email')</span>
                            </div>
                            <input id="email" type="email" class="vp-login-input tw-font-medium placeholder:tw-font-medium" name="email"
                                value="{{ $email ?? old('email') }}" required autofocus placeholder="@lang('lang_v1.email_address')">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="tw-dw-form-control">
                            <div class="tw-dw-label">
                                <span class="tw-text-xs md:tw-text-sm tw-font-medium">@lang('lang_v1.password')</span>
                            </div>
                            <input id="password" type="password" class="vp-login-input tw-font-medium placeholder:tw-font-medium" name="password"
                                required placeholder="@lang('lang_v1.password')">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="tw-dw-form-control">
                            <div class="tw-dw-label">
                                <span class="tw-text-xs md:tw-text-sm tw-font-medium">@lang('business.confirm_password')</span>
                            </div>
                            <input id="password-confirm" type="password" class="vp-login-input tw-font-medium placeholder:tw-font-medium"
                                name="password_confirmation" required placeholder="@lang('business.confirm_password')">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>
                    <button type="submit" class="vp-auth-submit focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-sky-400/50 focus:tw-ring-offset-0">
                        @lang('lang_v1.reset_password')</button>
                </form>
            </div>
        </div>
            </div>
        </div>
    </div>
@endsection


