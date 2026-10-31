@props([
    'mobile' => false,
])

@php
    $currentLocale = app()->getLocale();
    $supportedLocales = config('localization.supported', ['fr', 'en', 'ar']);
@endphp

@if ($mobile)
    <div class="mobile-lang-switcher">
        <div class="lang-switcher">
            <div class="lang-switcher-track" role="navigation" aria-label="{{ __('site.language.label') }}">
                @foreach ($supportedLocales as $lang)
                    <a href="{{ route('locale.switch', $lang) }}"
                       class="lang-switcher-link{{ $currentLocale === $lang ? ' is-active' : '' }}"
                       aria-label="{{ __('site.language.switch_to', ['name' => __('site.language.' . $lang . '_name')]) }}"
                       @if ($currentLocale === $lang) aria-current="true" @endif>
                        {{ __('site.language.' . $lang) }}
                        <small>{{ __('site.language.' . $lang . '_name') }}</small>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="lang-switcher me-3">
        <div class="lang-switcher-track" role="navigation" aria-label="{{ __('site.language.label') }}">
            @foreach ($supportedLocales as $lang)
                <a href="{{ route('locale.switch', $lang) }}"
                   class="lang-switcher-link{{ $currentLocale === $lang ? ' is-active' : '' }}"
                   title="{{ __('site.language.' . $lang . '_name') }}"
                   aria-label="{{ __('site.language.switch_to', ['name' => __('site.language.' . $lang . '_name')]) }}"
                   @if ($currentLocale === $lang) aria-current="true" @endif>
                    {{ __('site.language.' . $lang) }}
                </a>
            @endforeach
        </div>
    </div>
@endif
