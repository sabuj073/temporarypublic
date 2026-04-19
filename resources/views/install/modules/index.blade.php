@extends('layouts.app')
@section('title', __('lang_v1.manage_modules'))

@section('content')

<div class="vp-vendo-page-wrap">
    <div class="vp-vendo-form-page-head vp-vendo-form-page-head--with-actions">
        <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" class="vp-vendo-form-back"
            aria-label="{{ __('messages.go_back') }}">
            <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="">
        </a>
        <div class="vp-vendo-form-head-main">
            <h1 class="vp-vendo-form-title">
                @lang('lang_v1.manage_modules')
            </h1>
            <p class="vp-vendo-form-subtitle">
                Only superadmin can access manage modules
            </p>
        </div>
        <div class="vp-vendo-form-head-actions">
            <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm upload_module_btn">
                <i class="fas fa-upload"></i>
                @lang('lang_v1.upload_module')
            </button>
            <a class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm"
                href="{{ action([\App\Http\Controllers\Install\ModulesController::class, 'regenerate']) }}">
                <i class="fas fa-tools"></i>
                Regenerate @show_tooltip("<br/>1. Regenerate/publish modules css/js to fix not found issue. <br/> 2. Publish api module oauth files")
            </a>
        </div>
    </div>

    <!-- Main content -->
    <section class="content vp-vendo-form-content">
        <div class="row">
            <div class="col-md-12 form_col" style="display: none;">
                @component('components.widget')
                    {!! Form::open(['url' => action([\App\Http\Controllers\Install\ModulesController::class, 'uploadModule']), 'id' => 'upload_module_form','files' => true, 'style' => 'display:none']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('module', __('lang_v1.upload_module') . ":*") !!}

                                    {!! Form::file('module', ['required', 'accept' => 'application/zip']) !!}
                                    <p class="help-block">
                                        @lang("lang_v1.pls_upload_valid_zip_file")
                                    </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-4">
                                <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm">
                                    @lang('lang_v1.upload')
                                </button>
                                &nbsp;
                                <button type="button" class="tw-dw-btn tw-dw-btn-error tw-text-white tw-dw-btn-sm cancel_upload_btn">
                                    @lang('messages.cancel')
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                @endcomponent
            </div>
            <div class="col-md-12">
                @component('components.widget')
                    <table class="table">
                        <tr class="success">
                            <th class="col-md-1">#</th>
                            <th class="col-md-4">@lang('lang_v1.modules')</th>
                            <th class="col-md-7">@lang('lang_v1.description')</th>
                        </tr>
                        @foreach($modules as $module)

                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    <strong>{{$module['name']}}</strong> <br/>
                                    @if(!$module['is_installed'])
                                        <a class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-accent"
                                        @if($is_demo)
                                            href="#"
                                            title="@lang('lang_v1.disabled_in_demo')"
                                            disabled
                                        @else
                                            href="{{$module['install_link']}}"
                                        @endif
                                        > @lang('lang_v1.install')</a>
                                    @else
                                        <a class="btn btn-warning btn-xs"
                                            @if($is_demo)
                                                href="#"
                                                disabled
                                                title="@lang('lang_v1.disabled_in_demo')"
                                            @else
                                                href="{{$module['uninstall_link']}}"
                                            @endif
                                            onclick="return confirm('Do you really want to uninstall the module? Module will be uninstall but the data will not be deleted')"
                                        >@lang('lang_v1.uninstall')
                                        </a>

                                        {{-- Commented Activate/Deactivate
                                        @if($module['active'] == 1)
                                            <form
                                                action="{{action([\App\Http\Controllers\Install\ModulesController::class, 'update'], ['module_name' => $module['name']])}}"
                                                style="display: inline;"
                                                method="post">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" name="action_type" value="deactivate">
                                                <button class="btn btn-warning btn-xs">Deactivate</button>
                                            </form>
                                        @else
                                            <form action="{{action([\App\Http\Controllers\Install\ModulesController::class, 'update'], ['module_name' => $module['name']])}}"
                                                style="display: inline;"
                                                method="post"
                                            >
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" name="action_type" value="activate">
                                                <button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-accent">Activate</button>
                                            </form>
                                        @endif
                                        --}}
                                    @endif

                                    <form
                                        action="{{action([\App\Http\Controllers\Install\ModulesController::class, 'destroy'], ['module_name' => $module['name']])}}"
                                            style="display: inline;"
                                            method="post"
                                            onsubmit="return confirm('Do you really want to delete the module? Module code will be deleted but the data will not be deleted')"
                                        >
                                            @method('DELETE')
                                            @csrf
                                            <button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-error"
                                                @if($is_demo)
                                                disabled="disabled"
                                                title="@lang('lang_v1.disabled_in_demo')"
                                                @endif
                                            >
                                            @lang('messages.delete')</button>
                                        </form>
                                </td>

                                <td>
                                    {{$module['description']}} <br/>
                                    @isset($module['version'])
                                        <small class="label bg-gray">@lang('lang_v1.version') {{$module['version']['installed_version']}}</small>
                                    @endisset

                                    @if(!empty($module['version']) && $module['version']['is_update_available'])
                                        <div class="alert alert-warning mt-5">
                                            <i class="fas fa-sync"></i> @lang('lang_v1.module_new_version', ['module' => $module['name'], 'link' => $module['update_link']])
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        @php
                            $mods = unserialize($mods);

                        @endphp

                        @foreach($mods as $mod)
                            @if(!isset($modules[$mod->n]))
                                <tr>
                                    <td><i class="fas fa-hand-point-right fa-2x"></i></td>
                                    <td>
                                        <strong>{{$mod->dn}}</strong> <br/>
                                        <button onclick="window.open('{{$mod->u}}', '_blank')"
                                        class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-accent"><i class="fas fa-money-bill"></i> Buy</button>
                                    </td>
                                    <td>
                                        {{$mod->d}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endcomponent
            </div>
        </div>
    </section>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
    //show a hidden form on upload_module_btn click
    $(document).on('click', '.upload_module_btn', function(){
        $(".form_col,form#upload_module_form").fadeToggle();
    });

    //hide form on cancel_upload_btn click
    $(document).on('click', '.cancel_upload_btn', function(){
        $("form#upload_module_form")[0].reset();
        $(".form_col,form#upload_module_form").fadeOut();
    });

</script>
@endsection
