{{--
  Frosted-shell form pages: back control + page title (and optional trailing HTML inside the title row).

  Required: $vendoFormPageHeadBackUrl (string)
  Required: $vendoFormPageHeadTitle (string) — plain text, escaped
  Optional: $vendoFormPageHeadBackLabel — aria-label for back link
  Optional: $vendoFormPageHeadTitleSuffixHtml — trusted HTML after title (e.g. keyboard help icon)
--}}
@php
    $vendoFormPageHeadBackUrl = $vendoFormPageHeadBackUrl ?? null;
    $vendoFormPageHeadTitle = $vendoFormPageHeadTitle ?? '';
@endphp
@if (!empty($vendoFormPageHeadBackUrl))
    <div class="vp-vendo-form-page-head">
        <a href="{{ $vendoFormPageHeadBackUrl }}" class="vp-vendo-form-back"
            aria-label="{{ $vendoFormPageHeadBackLabel ?? __('messages.go_back') }}">
            <img src="{{ asset('images/dashboard-icons/sales-back.png') }}" alt="">
        </a>
        <div class="vp-vendo-form-head-main">
            <h1 class="vp-vendo-form-title tw-inline-flex tw-items-center tw-gap-2 tw-flex-wrap">
                {{ $vendoFormPageHeadTitle }}
                @if (!empty($vendoFormPageHeadTitleSuffixHtml))
                    {!! $vendoFormPageHeadTitleSuffixHtml !!}
                @endif
            </h1>
        </div>
    </div>
@endif
