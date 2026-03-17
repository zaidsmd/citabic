@php
    $colorMap = [
        'blue'   => '#1A5EA8',
        'teal'   => '#0F6E56',
        'amber'  => '#BA7517',
        'coral'  => '#D85A30',
        'indigo' => '#534AB7',
    ];
    $selectedColor = $item['color_theme'] ?? 'blue';
    $legacyIconMap = [
        'bar-chart' => 'chart-bar',
        'shield-check' => 'shield-alt',
        'cpu' => 'microchip',
        'trending-up' => 'chart-line',
        'settings' => 'cogs',
    ];
    $rawIcon = $item['icon'] ?? 'chart-bar';
    $selectedIcon = $legacyIconMap[$rawIcon] ?? $rawIcon;
@endphp

<div class="card mb-3 item-block">
    <div class="card-header d-flex align-items-center gap-2 py-2 bg-light">

        <span class="badge bg-primary item-number">{{ $index + 1 }}</span>

        <span class="fw-semibold small">
            {{ $item['translations']['fr']['title'] ?? __('admin.our_approach.new_item') }}
        </span>

        <div class="ms-auto d-flex align-items-center gap-3">
            <button type="button" class="btn btn-sm btn-light-danger remove-item-btn">
                {{ __('admin.our_approach.remove') }}
            </button>
        </div>
    </div>

    <div class="card-body">

        {{-- Hidden id --}}
        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item['id'] ?? '' }}">

        {{-- ── DESIGN FIELDS (locale-independent) ─────────────── --}}
        <div class="row g-3 mb-4 pb-3 border-bottom">

            {{-- Color picker --}}
            <div class="col-md-5">
                <label class="form-label fw-semibold small">
                    {{ __('admin.our_approach.color') }}
                    <span class="badge bg-success ms-1">{{ __('admin.our_approach.design_only') }}</span>
                </label>

                <input
                    type="hidden"
                    name="items[{{ $index }}][color_theme]"
                    value="{{ $selectedColor }}"
                >

                <div class="d-flex gap-2 flex-wrap color-picker-group mt-1">
                    @foreach ($colorMap as $colorKey => $hex)
                        <div
                            class="color-dot {{ $colorKey === $selectedColor ? 'selected' : '' }}"
                            data-color="{{ $colorKey }}"
                            title="{{ $colorKey }}"
                            style="
                                width: 28px; height: 28px; border-radius: 8px;
                                background: {{ $hex }}; cursor: pointer;
                                border: 3px solid {{ $colorKey === $selectedColor ? '#000' : 'transparent' }};
                                transition: border-color 0.15s;
                            "
                        ></div>
                    @endforeach
                </div>
            </div>

            {{-- Icon picker --}}
            <div class="col-md-7">
                <label class="form-label fw-semibold small">
                    {{ __('admin.our_approach.icon') }}
                    <span class="badge bg-success ms-1">{{ __('admin.our_approach.design_only') }}</span>
                </label>
                <div class="icon-picker-field">
                    <input
                        type="hidden"
                        name="items[{{ $index }}][icon]"
                        value="{{ $selectedIcon }}"
                        class="@error("items.$index.icon") is-invalid @enderror icon-picker-input"
                        required
                    >
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-2 open-icon-picker"
                        data-selected-icon="{{ $selectedIcon }}"
                    >
                        <i class="fas fa-{{ $selectedIcon }} icon-picker-preview"></i>
                        <span class="icon-picker-label">fa-{{ $selectedIcon }}</span>
                        <span class="badge bg-light-secondary text-dark">Choose</span>
                    </button>
                </div>
                @error("items.$index.icon")
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        {{-- ── TRANSLATION FIELDS ───────────────────────────────── --}}
        @foreach ($locales as $code => $label)
            <div
                class="locale-fields"
                data-locale="{{ $code }}"
                @if ($code !== 'fr') style="display:none;" @endif
            >
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label small">
                            {{ __('admin.our_approach.label') }}
                            <span class="badge bg-secondary ms-1">{{ strtoupper($code) }}</span>
                        </label>
                        <input
                            type="text"
                            name="items[{{ $index }}][translations][{{ $code }}][label]"
                            class="form-control form-control-sm @error("items.$index.translations.$code.label") is-invalid @enderror"
                            value="{{ old("items.$index.translations.$code.label", $item['translations'][$code]['label'] ?? '') }}"
                            @if ($code === 'ar') dir="rtl" @endif
                            required
                        >
                        @error("items.$index.translations.$code.label")
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label small">
                            {{ __('admin.our_approach.item_title') }}
                            <span class="badge bg-secondary ms-1">{{ strtoupper($code) }}</span>
                        </label>
                        <input
                            type="text"
                            name="items[{{ $index }}][translations][{{ $code }}][title]"
                            class="form-control form-control-sm @error("items.$index.translations.$code.title") is-invalid @enderror"
                            value="{{ old("items.$index.translations.$code.title", $item['translations'][$code]['title'] ?? '') }}"
                            @if ($code === 'ar') dir="rtl" @endif
                            required
                        >
                        @error("items.$index.translations.$code.title")
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label small">
                            {{ __('admin.our_approach.description') }}
                            <span class="badge bg-secondary ms-1">{{ strtoupper($code) }}</span>
                        </label>
                        <textarea
                            name="items[{{ $index }}][translations][{{ $code }}][description]"
                            class="form-control form-control-sm @error("items.$index.translations.$code.description") is-invalid @enderror"
                            rows="2"
                            @if ($code === 'ar') dir="rtl" @endif
                            required
                        >{{ old("items.$index.translations.$code.description", $item['translations'][$code]['description'] ?? '') }}</textarea>
                        @error("items.$index.translations.$code.description")
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        @endforeach

    </div>{{-- /card-body --}}
</div>
