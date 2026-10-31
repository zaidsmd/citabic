@extends('admin.layouts.master')

@section('title', __('admin.our_approach.title'))

@php
    $formItems = old('items', $items);
    $locales   = ['fr' => 'Français', 'en' => 'English', 'ar' => 'العربية'];
    $colors    = ['blue', 'teal', 'amber', 'coral', 'indigo'];

    $fontAwesomeIcons = [];
    $faSourcePath = resource_path('views/admin/elements/icon-fontawesome.blade.php');
    if (is_file($faSourcePath)) {
        $faSource = file_get_contents($faSourcePath) ?: '';
        preg_match_all("/'fa-([a-z0-9-]+)'/i", $faSource, $matches);
        $fontAwesomeIcons = array_values(array_unique(array_map('strtolower', $matches[1] ?? [])));
        sort($fontAwesomeIcons);
    }
@endphp

@section('content')
    <x-breadcrumb item="{{ __('admin.common.cms') }}" active="{{ __('admin.our_approach.title') }}" />

    <div class="row">
        <div class="col-sm-12">

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    {{ __('admin.common.fix_errors') }}
                    <ul class="list-" >
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.our-approach.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('admin.our_approach.title') }}</h5>
                        <button type="submit" class="btn btn-sm btn-primary">
                            {{ __('admin.common.save') }}
                        </button>
                    </div>

                    <div class="card-body">

                        {{-- ───────────────────────────────────────────
                             GLOBAL LOCALE SWITCHER
                        ─────────────────────────────────────────────── --}}
                        <div class="mb-4">
                            <ul class="nav nav-tabs align-items-center" id="locale-tabs" role="tablist">
                                @foreach ($locales as $code => $label)
                                    <li class="nav-item" role="presentation">
                                        <button
                                            type="button"
                                            class="nav-link locale-tab {{ $code === 'fr' ? 'active' : '' }}"
                                            data-locale="{{ $code }}"
                                            role="tab"
                                            aria-selected="{{ $code === 'fr' ? 'true' : 'false' }}"
                                        >
                                            {{ strtoupper($code) }} — {{ $label }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- ───────────────────────────────────────────
                             SECTION META — per locale
                        ─────────────────────────────────────────────── --}}
                        <div class="card mb-4 border">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0">{{ __('admin.our_approach.section_header') }}</h6>
                            </div>
                            <div class="card-body">
                                @foreach ($locales as $code => $label)
                                    <div
                                        class="locale-fields row g-3"
                                        data-locale="{{ $code }}"
                                        @if ($code !== 'fr') style="display:none;" @endif
                                    >
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                {{ __('admin.our_approach.section_title') }}
                                                <span class="badge bg-secondary ms-1">{{ strtoupper($code) }}</span>
                                            </label>
                                            <input
                                                type="text"
                                                name="section[translations][{{ $code }}][title]"
                                                class="form-control @error("section.translations.$code.title") is-invalid @enderror"
                                                value="{{ old("section.translations.$code.title", $sectionMeta['translations'][$code]['title'] ?? '') }}"
                                                @if ($code === 'ar') dir="rtl" @endif
                                                required
                                            >
                                            @error("section.translations.$code.title")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ───────────────────────────────────────────
                             ITEMS
                        ─────────────────────────────────────────────── --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">{{ __('admin.our_approach.items') }}</h6>
                            <button type="button" class="btn btn-sm btn-light-primary" id="add-item-btn">
                                + {{ __('admin.our_approach.add_item') }}
                            </button>
                        </div>

                        <div id="items-wrapper">
                            @forelse ($formItems as $index => $item)
                                @include('admin.our-approach._item', [
                                    'index'   => $index,
                                    'item'    => $item,
                                    'locales' => $locales,
                                    'colors'  => $colors,
                                ])
                            @empty
                                @include('admin.our-approach._item', [
                                    'index'   => 0,
                                    'item'    => [],
                                    'locales' => $locales,
                                    'colors'  => $colors,
                                ])
                            @endforelse
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            {{ __('admin.our_approach.save_changes') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    @include('admin.our-approach._item_template')

    <div class="modal fade" id="iconPickerModal" tabindex="-1" aria-labelledby="iconPickerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iconPickerModalLabel">Choose Font Awesome Icon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-md-8">
                            <label for="icon-picker-search" class="form-label mb-1">Search</label>
                            <input type="text" id="icon-picker-search" class="form-control" placeholder="Search icons (e.g. chart, user, shield)">
                        </div>
                        <div class="col-md-4">
                            <label for="icon-picker-category" class="form-label mb-1">Category</label>
                            <select id="icon-picker-category" class="form-select">
                                <option value="all">All</option>
                                <option value="arrows">Arrows</option>
                                <option value="charts">Charts</option>
                                <option value="business">Business</option>
                                <option value="users">Users</option>
                                <option value="security">Security</option>
                                <option value="communication">Communication</option>
                                <option value="files">Files</option>
                                <option value="media">Media</option>
                                <option value="transport">Transport</option>
                                <option value="hardware">Hardware</option>
                                <option value="brands">Brands</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-muted" id="icon-picker-meta">Loading icons...</small>
                        <small class="text-muted">Click an icon to select it</small>
                    </div>

                    <div class="row g-2" id="icon-picker-grid"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            'use strict';
            const iconCatalogSeed = @json($fontAwesomeIcons);

            /* ── Locale switcher ─────────────────────────────────────── */
            const localeTabs   = document.getElementById('locale-tabs');
            let   activeLang   = 'fr';

            localeTabs.addEventListener('click', function (e) {
                const btn = e.target.closest('.locale-tab');
                if (!btn) return;

                activeLang = btn.dataset.locale;

                localeTabs.querySelectorAll('.locale-tab').forEach(t => {
                    const isActive = t === btn;
                    t.classList.toggle('active', isActive);
                    t.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });

                document.querySelectorAll('.locale-fields').forEach(panel => {
                    panel.style.display = (panel.dataset.locale === activeLang) ? '' : 'none';
                });
            });

            /* ── Color picker ────────────────────────────────────────── */
            document.addEventListener('click', function (e) {
                const dot = e.target.closest('.color-dot');
                if (!dot) return;

                const pickerGroup = dot.closest('.color-picker-group');
                if (!pickerGroup) return;

                pickerGroup.querySelectorAll('.color-dot').forEach(d => {
                    d.classList.remove('selected');
                    d.style.borderColor = 'transparent';
                });
                dot.classList.add('selected');
                dot.style.borderColor = '#000';

                const hiddenInput = pickerGroup.parentElement?.querySelector('input[type="hidden"][name$="[color_theme]"]');
                if (hiddenInput) {
                    hiddenInput.value = dot.dataset.color;
                }
            });

            /* ── Icon picker modal ───────────────────────────────────── */
            const iconModalElement  = document.getElementById('iconPickerModal');
            const iconPickerModal   = new bootstrap.Modal(iconModalElement);
            const iconPickerGrid    = document.getElementById('icon-picker-grid');
            const iconPickerSearch  = document.getElementById('icon-picker-search');
            const iconPickerCategory = document.getElementById('icon-picker-category');
            const iconPickerMeta    = document.getElementById('icon-picker-meta');

            let activeIconField = null;
            let iconCatalog = [];
            let iconCatalogReady = false;

            function classifyIcon(iconName) {
                const checks = [
                    ['arrows', ['arrow', 'angle', 'caret', 'chevron', 'long-arrow', 'exchange', 'level-']],
                    ['charts', ['chart', 'analytics', 'signal', 'percentage', 'poll']],
                    ['business', ['briefcase', 'building', 'calculator', 'wallet', 'cash', 'handshake', 'coins']],
                    ['users', ['user', 'users', 'id-card', 'address-book', 'portrait']],
                    ['security', ['shield', 'lock', 'unlock', 'key', 'fingerprint', 'user-shield']],
                    ['communication', ['phone', 'envelope', 'comment', 'sms', 'mail', 'bell', 'bullhorn']],
                    ['files', ['file', 'folder', 'copy', 'save', 'print', 'clipboard']],
                    ['media', ['play', 'pause', 'stop', 'volume', 'music', 'camera', 'image', 'video']],
                    ['transport', ['car', 'bus', 'truck', 'ship', 'plane', 'train', 'bicycle', 'motorcycle']],
                    ['hardware', ['microchip', 'cpu', 'server', 'database', 'laptop', 'desktop', 'mobile', 'tablet']],
                    ['brands', ['facebook', 'twitter', 'linkedin', 'github', 'google', 'apple', 'android', 'instagram', 'youtube', 'whatsapp', 'slack', 'git', 'npm', 'aws']],
                ];

                for (const [category, tokens] of checks) {
                    if (tokens.some(token => iconName.includes(token))) {
                        return category;
                    }
                }

                return 'other';
            }

            function parseIconsFromStyleSheets() {
                const iconSet = new Set();

                for (const sheet of Array.from(document.styleSheets)) {
                    let rules;

                    try {
                        rules = sheet.cssRules;
                    } catch (error) {
                        continue;
                    }

                    if (!rules) continue;

                    for (const rule of Array.from(rules)) {
                        if (!rule.selectorText || !rule.selectorText.includes('.fa-') || !rule.selectorText.includes(':before')) {
                            continue;
                        }

                        const matches = rule.selectorText.match(/\.fa-([a-z0-9-]+):before/g);
                        if (!matches) continue;

                        matches.forEach(match => {
                            const iconName = match.replace('.fa-', '').replace(':before', '');

                            // Exclude utility helpers that are not icon glyphs.
                            if ([
                                'lg', 'xs', 'sm', 'fw', 'ul', 'li', 'border', 'pull-left',
                                'pull-right', 'spin', 'pulse', 'rotate-90', 'rotate-180',
                                'rotate-270', 'flip-horizontal', 'flip-vertical', 'stack',
                                'stack-1x', 'stack-2x', 'inverse'
                            ].includes(iconName)) {
                                return;
                            }

                            iconSet.add(iconName);
                        });
                    }
                }

                return Array.from(iconSet).sort((a, b) => a.localeCompare(b));
            }

            function ensureIconCatalog() {
                if (iconCatalogReady) return;

                const parsedIcons = parseIconsFromStyleSheets();
                const fallbackIcons = [
                    'chart-bar', 'leaf', 'shield-alt', 'clock', 'microchip', 'chart-line', 'cogs',
                    'user', 'users', 'briefcase', 'phone', 'envelope', 'file-alt', 'camera',
                    'play', 'car', 'lock', 'key', 'database', 'wrench'
                ];

                const source = iconCatalogSeed.length > 0
                    ? iconCatalogSeed
                    : (parsedIcons.length > 0 ? parsedIcons : fallbackIcons);
                iconCatalog = source.map(name => ({ name, category: classifyIcon(name) }));
                iconCatalogReady = true;
            }

            function renderIconGrid() {
                ensureIconCatalog();

                const term = iconPickerSearch.value.trim().toLowerCase();
                const category = iconPickerCategory.value;
                const selectedIcon = activeIconField?.input?.value || '';

                const filtered = iconCatalog.filter(icon => {
                    const matchesTerm = !term || icon.name.includes(term);
                    const matchesCategory = category === 'all' || icon.category === category;

                    return matchesTerm && matchesCategory;
                });

                iconPickerMeta.textContent = `${filtered.length} icon${filtered.length === 1 ? '' : 's'} shown`;

                iconPickerGrid.innerHTML = filtered.map(icon => {
                    const isActive = icon.name === selectedIcon;

                    return `
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <button
                                type="button"
                                class="btn btn-sm w-100 text-start ${isActive ? 'btn-primary' : 'btn-light'} border icon-candidate"
                                data-icon="${icon.name}"
                            >
                                <span class="d-inline-flex align-items-center gap-2">
                                    <i class="fas fa-${icon.name}"></i>
                                    <span class="small">fa-${icon.name}</span>
                                </span>
                            </button>
                        </div>
                    `;
                }).join('');
            }

            document.addEventListener('click', function (e) {
                const openPickerBtn = e.target.closest('.open-icon-picker');
                if (openPickerBtn) {
                    const field = openPickerBtn.closest('.icon-picker-field');
                    if (!field) return;

                    activeIconField = {
                        field,
                        input: field.querySelector('.icon-picker-input'),
                        preview: field.querySelector('.icon-picker-preview'),
                        label: field.querySelector('.icon-picker-label'),
                        trigger: openPickerBtn,
                    };

                    renderIconGrid();
                    iconPickerModal.show();
                    setTimeout(() => iconPickerSearch.focus(), 120);
                    return;
                }

                const iconCandidate = e.target.closest('.icon-candidate');
                if (!iconCandidate || !activeIconField) return;

                const iconName = iconCandidate.dataset.icon;

                activeIconField.input.value = iconName;
                activeIconField.trigger.dataset.selectedIcon = iconName;
                activeIconField.preview.className = `fas fa-${iconName} icon-picker-preview`;
                activeIconField.label.textContent = `fa-${iconName}`;

                iconPickerModal.hide();
            });

            iconPickerSearch.addEventListener('input', renderIconGrid);
            iconPickerCategory.addEventListener('change', renderIconGrid);
            iconModalElement.addEventListener('hidden.bs.modal', function () {
                activeIconField = null;
                iconPickerSearch.value = '';
                iconPickerCategory.value = 'all';
            });

            /* ── Row numbering ───────────────────────────────────────── */
            function updateRowNumbers() {
                document.querySelectorAll('#items-wrapper .item-block').forEach((block, i) => {
                    const num = block.querySelector('.item-number');
                    if (num) num.textContent = i + 1;

                    block.querySelectorAll('[name]').forEach(field => {
                        field.name = field.name.replace(/items\[\d+\]/, `items[${i}]`);
                    });
                });
            }

            /* ── Add item ────────────────────────────────────────────── */
            document.getElementById('add-item-btn').addEventListener('click', function () {
                const count   = document.querySelectorAll('#items-wrapper .item-block').length;
                const tpl     = document.getElementById('item-template');
                const clone   = tpl.content.cloneNode(true);

                clone.querySelectorAll('[name]').forEach(field => {
                    field.name = field.name.replace(/items\[__INDEX__\]/, `items[${count}]`);
                });

                document.getElementById('items-wrapper').appendChild(clone);
                updateRowNumbers();

                /* Apply current locale to new item */
                document.querySelectorAll('.locale-fields').forEach(panel => {
                    panel.style.display = (panel.dataset.locale === activeLang) ? '' : 'none';
                });
            });

            /* ── Remove item ─────────────────────────────────────────── */
            document.getElementById('items-wrapper').addEventListener('click', function (e) {
                const btn = e.target.closest('.remove-item-btn');
                if (!btn) return;

                const blocks = document.querySelectorAll('#items-wrapper .item-block');
                if (blocks.length <= 1) return;

                btn.closest('.item-block').remove();
                updateRowNumbers();
            });

            updateRowNumbers();
        })();
    </script>
@endpush
