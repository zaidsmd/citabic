@php
    $colorMap = [
        'blue'   => '#1A5EA8',
        'teal'   => '#0F6E56',
        'amber'  => '#BA7517',
        'coral'  => '#D85A30',
        'indigo' => '#534AB7',
    ];
    $locales  = ['fr' => 'Français', 'en' => 'English', 'ar' => 'العربية'];
@endphp

<template id="item-template">
    <div class="card mb-3 item-block">
        <div class="card-header d-flex align-items-center gap-2 py-2 bg-light">

            <span class="badge bg-primary item-number"></span>
            <span class="fw-semibold small">{{ __('admin.our_approach.new_item') }}</span>

            <div class="ms-auto d-flex align-items-center gap-3">
                <button type="button" class="btn btn-sm btn-light-danger remove-item-btn">
                    {{ __('admin.our_approach.remove') }}
                </button>
            </div>
        </div>

        <div class="card-body">

            <input type="hidden" name="items[__INDEX__][id]" value="">

            {{-- Design fields --}}
            <div class="row g-3 mb-4 pb-3 border-bottom">

                <div class="col-md-5">
                    <label class="form-label fw-semibold small">
                        {{ __('admin.our_approach.color') }}
                        <span class="badge bg-success ms-1">{{ __('admin.our_approach.design_only') }}</span>
                    </label>
                    <input type="hidden" name="items[__INDEX__][color_theme]" value="blue">
                    <div class="d-flex gap-2 flex-wrap color-picker-group mt-1">
                        @foreach ($colorMap as $colorKey => $hex)
                            <div
                                class="color-dot {{ $colorKey === 'blue' ? 'selected' : '' }}"
                                data-color="{{ $colorKey }}"
                                title="{{ $colorKey }}"
                                style="
                                    width: 28px; height: 28px; border-radius: 8px;
                                    background: {{ $hex }}; cursor: pointer;
                                    border: 3px solid {{ $colorKey === 'blue' ? '#000' : 'transparent' }};
                                    transition: border-color 0.15s;
                                "
                            ></div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-7">
                    <label class="form-label fw-semibold small">
                        {{ __('admin.our_approach.icon') }}
                        <span class="badge bg-success ms-1">{{ __('admin.our_approach.design_only') }}</span>
                    </label>
                    <div class="icon-picker-field">
                        <input type="hidden" name="items[__INDEX__][icon]" value="chart-bar" class="icon-picker-input" required>
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-2 open-icon-picker"
                            data-selected-icon="chart-bar"
                        >
                            <i class="fas fa-chart-bar icon-picker-preview"></i>
                            <span class="icon-picker-label">fa-chart-bar</span>
                            <span class="badge bg-light-secondary text-dark">Choose</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Translation fields --}}
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
                                name="items[__INDEX__][translations][{{ $code }}][label]"
                                class="form-control form-control-sm"
                                @if ($code === 'ar') dir="rtl" @endif
                                required
                            >
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small">
                                {{ __('admin.our_approach.item_title') }}
                                <span class="badge bg-secondary ms-1">{{ strtoupper($code) }}</span>
                            </label>
                            <input
                                type="text"
                                name="items[__INDEX__][translations][{{ $code }}][title]"
                                class="form-control form-control-sm"
                                @if ($code === 'ar') dir="rtl" @endif
                                required
                            >
                        </div>
                        <div class="col-12">
                            <label class="form-label small">
                                {{ __('admin.our_approach.description') }}
                                <span class="badge bg-secondary ms-1">{{ strtoupper($code) }}</span>
                            </label>
                            <textarea
                                name="items[__INDEX__][translations][{{ $code }}][description]"
                                class="form-control form-control-sm"
                                rows="2"
                                @if ($code === 'ar') dir="rtl" @endif
                                required
                            ></textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</template>
