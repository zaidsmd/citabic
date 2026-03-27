@props([
    'locales' => ['fr', 'en'],
    'idPrefix' => 'about',
])

<ul class="nav nav-tabs border-bottom" {{ $attributes->merge(['role' => 'tablist']) }}>
    @foreach($locales as $locale)
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-semibold {{ $loop->first ? 'active' : '' }}"
               id="{{ $idPrefix }}-{{ $locale }}-tab"
               data-bs-toggle="tab"
               data-toggle="tab"
               data-bs-target="#{{ $idPrefix }}-{{ $locale }}-content"
               href="#{{ $idPrefix }}-{{ $locale }}-content"
               role="tab"
               aria-controls="{{ $idPrefix }}-{{ $locale }}-content"
               aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                @lang("admin.common.language.{$locale}")
            </a>
        </li>
    @endforeach
</ul>
