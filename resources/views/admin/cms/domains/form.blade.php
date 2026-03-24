@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush

@php($isEdit = $domain->exists)

@section('title', $isEdit ? 'Edit Domain' : 'Create Domain')

@section('content')
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <x-breadcrumb item="CMS" active="{{ $isEdit ? 'Edit Domain' : 'Create Domain' }}"/>

                <form action="{{ $isEdit ? route('admin.domains.update', $domain) : route('admin.domains.store') }}" method="POST">
                    @csrf
                    @if($isEdit) @method('PUT') @endif

                    <!-- Header Card -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
                                <div>
                                    <h4 class="fw-bold mb-1">
                                        <i class="fa fa-sitemap me-2 text-primary"></i>
                                        {{ $isEdit ? 'Edit Domain' : 'Add New Domain' }}
                                    </h4>
                                    <p class="text-secondary-emphasis mb-0 small">
                                        {{ $isEdit ? 'Update domain information below' : 'Create a new domain with its content' }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.domains.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa fa-arrow-left me-2"></i>
                                        Back to List
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fa fa-save me-2"></i>
                                        {{ $isEdit ? 'Update Domain' : 'Save Domain' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Card -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Left Column - Language Content -->
                                <div class="col-lg-8">
                                    <!-- Language Tabs -->
                                    <div class="mb-4">
                                        <ul class="nav nav-tabs border-bottom" id="domainTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active fw-semibold" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content" aria-selected="true">
                                                    <i class="fa fa-language me-2"></i>French (Default)
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link fw-semibold" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="false">
                                                    <i class="fa fa-language me-2"></i>English
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Tab Content -->
                                    <div class="tab-content" id="domainTabsContent">
                                        <!-- French Content -->
                                        <div class="tab-pane fade show active" id="fr-content" role="tabpanel" aria-labelledby="fr-tab">
                                            <div class="mb-4">
                                                <div class="form-floating">
                                                    <input type="text"
                                                           name="title"
                                                           class="form-control @error('title') is-invalid @enderror"
                                                           id="titleFr"
                                                           value="{{ old('title', $form['title']) }}"
                                                           placeholder="Enter title"
                                                           required>
                                                    <label for="titleFr" class="fw-semibold">
                                                        Title (FR) <span class="text-danger">*</span>
                                                    </label>
                                                    @error('title')
                                                    <div class="invalid-feedback">
                                                        <i class="fa fa-exclamation-circle me-1"></i>
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold mb-2">
                                                    <i class="fa fa-list-ul me-2 text-primary"></i>
                                                    Items (FR) <span class="text-danger">*</span>
                                                </label>
                                                <div id="fr-items-list" class="mb-2">
                                                    @php($frItems = old('items', $form['items']))
                                                    @if(count($frItems) > 0)
                                                        @foreach($frItems as $item)
                                                            <div class="input-group mb-2 item-row shadow-sm">
                                                                <span class="input-group-text bg-light">
                                                                    <i class="fa fa-grip-vertical text-secondary"></i>
                                                                </span>
                                                                <input type="text" name="items[]" class="form-control" value="{{ $item }}" placeholder="Enter item...">
                                                                <button type="button" class="btn btn-outline-danger remove-item-btn" title="Remove item">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="input-group mb-2 item-row shadow-sm">
                                                            <span class="input-group-text bg-light">
                                                                <i class="fa fa-grip-vertical text-secondary"></i>
                                                            </span>
                                                            <input type="text" name="items[]" class="form-control" placeholder="Enter item...">
                                                            <button type="button" class="btn btn-outline-danger remove-item-btn" title="Remove item">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-fr-item">
                                                    <i class="fa fa-plus-circle me-2"></i>
                                                    Add Item
                                                </button>
                                            </div>
                                        </div>

                                        <!-- English Content -->
                                        <div class="tab-pane fade" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                                            <div class="mb-4">
                                                <div class="form-floating">
                                                    <input type="text"
                                                           name="en[title]"
                                                           class="form-control"
                                                           id="titleEn"
                                                           value="{{ old('en.title', $form['en']['title'] ?? '') }}"
                                                           placeholder="Enter title">
                                                    <label for="titleEn" class="fw-semibold">Title (EN)</label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold mb-2">
                                                    <i class="fa fa-list-ul me-2 text-primary"></i>
                                                    Items (EN)
                                                </label>
                                                <div id="en-items-list" class="mb-2">
                                                    @php($enItems = old('en.items', $form['en']['items'] ?? []))
                                                    @if(count($enItems) > 0)
                                                        @foreach($enItems as $item)
                                                            <div class="input-group mb-2 item-row shadow-sm">
                                                                <span class="input-group-text bg-light">
                                                                    <i class="fa fa-grip-vertical text-secondary"></i>
                                                                </span>
                                                                <input type="text" name="en[items][]" class="form-control" value="{{ $item }}" placeholder="Enter item...">
                                                                <button type="button" class="btn btn-outline-danger remove-item-btn" title="Remove item">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="input-group mb-2 item-row shadow-sm">
                                                            <span class="input-group-text bg-light">
                                                                <i class="fa fa-grip-vertical text-secondary"></i>
                                                            </span>
                                                            <input type="text" name="en[items][]" class="form-control" placeholder="Enter item...">
                                                            <button type="button" class="btn btn-outline-danger remove-item-btn" title="Remove item">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-en-item">
                                                    <i class="fa fa-plus-circle me-2"></i>
                                                    Add Item
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Settings -->
                                <div class="col-lg-4">
                                    <!-- Icon Upload Card -->
                                    <div class="card border mb-4">
                                        <div class="card-header bg-transparent border-bottom">
                                            <h6 class="fw-semibold mb-0">
                                                <i class="fa fa-image me-2 text-primary"></i>
                                                Icon
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @php $hasIcon = !empty($form['icon']); @endphp

                                            <div id="icon-existing" style="{{ $hasIcon ? '' : 'display:none' }}">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <p class="text-secondary-emphasis small mb-0">
                                                        <i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}
                                                    </p>
                                                    <button type="button" class="btn btn-sm btn-outline-warning" id="icon-change-btn">
                                                        <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                    </button>
                                                </div>
                                                <img id="icon-preview-img"
                                                     src="{{ $hasIcon ? Storage::disk('public')->url($form['icon']) : '' }}"
                                                     alt="current" class="img-thumbnail shadow-sm" style="max-height:120px;">
                                            </div>

                                            <div id="icon-dropzone-wrapper" style="{{ $hasIcon ? 'display:none' : '' }}">
                                                <div id="icon-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                    <div class="dz-message needsclick">
                                                        <i class="fa fa-cloud-upload-alt fs-1 text-secondary mb-3"></i>
                                                        <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                        <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                                    </div>
                                                </div>
                                                @if($hasIcon)
                                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="icon-cancel-btn">
                                                    <i class="fa fa-times me-1"></i>Cancel
                                                </button>
                                                @endif
                                            </div>

                                            <input type="hidden" id="icon-path" name="icon" value="{{ old('icon', $form['icon']) }}">
                                            @error('icon')
                                            <div class="text-danger small mt-2">
                                                <i class="fa fa-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sort Order Card -->
                                    <div class="card border">
                                        <div class="card-header bg-transparent border-bottom">
                                            <h6 class="fw-semibold mb-0">
                                                <i class="fa fa-sort-numeric-down me-2 text-primary"></i>
                                                Display Settings
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-floating">
                                                <input type="number"
                                                       name="sort_order"
                                                       class="form-control @error('sort_order') is-invalid @enderror"
                                                       id="sortOrder"
                                                       value="{{ old('sort_order', $form['sort_order']) }}"
                                                       placeholder="Sort order"
                                                       min="0"
                                                       required>
                                                <label for="sortOrder" class="fw-semibold">
                                                    Sort Order <span class="text-danger">*</span>
                                                </label>
                                                @error('sort_order')
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                <div class="form-text text-secondary-emphasis small mt-2">
                                                    <i class="fa fa-info-circle me-1"></i>
                                                    Lower numbers appear first
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer bg-light-subtle border-top p-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary px-4">
                                    <i class="fa fa-undo me-2"></i>
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fa fa-save me-2"></i>
                                    {{ $isEdit ? 'Update Domain' : 'Save Domain' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        const uploadUrl = '{{ route('admin.domains.upload-image') }}';
        const csrfToken = '{{ csrf_token() }}';

        const pathInput   = document.getElementById('icon-path');
        const existingDiv = document.getElementById('icon-existing');
        const wrapperDiv  = document.getElementById('icon-dropzone-wrapper');
        const previewImg  = document.getElementById('icon-preview-img');
        const changeBtn   = document.getElementById('icon-change-btn');
        const cancelBtn   = document.getElementById('icon-cancel-btn');

        const showDropzone = () => { existingDiv.style.display = 'none'; wrapperDiv.style.display = ''; };
        const showExisting = () => { wrapperDiv.style.display  = 'none'; existingDiv.style.display = ''; };

        if (changeBtn) changeBtn.addEventListener('click', showDropzone);
        if (cancelBtn) cancelBtn.addEventListener('click', showExisting);

        const dz = new Dropzone('#icon-dropzone', {
            url: uploadUrl,
            autoProcessQueue: true,
            uploadMultiple: false,
            maxFiles: 1,
            paramName: 'image',
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            headers: { 'X-CSRF-TOKEN': csrfToken },
        });

        dz.on('addedfile', () => {
            dz.files.filter((f, i) => i < dz.files.length - 1).forEach((f) => dz.removeFile(f));
        });

        dz.on('success', (file, response) => {
            if (response.path) {
                pathInput.value = response.path;
                previewImg.src = response.url;
                showExisting();
            }
        });

        dz.on('error', (file, message, xhr) => {
            console.error('Upload error:', message, xhr ? xhr.responseText : '');
        });

        dz.on('removedfile', () => {
            if (dz.files.length === 0) {
                pathInput.value = '';
                existingDiv.style.display = 'none';
                wrapperDiv.style.display = '';
            }
        });

        // Item management functions
        function addItemRow(listId, inputName) {
            const list = document.getElementById(listId);
            const row = document.createElement('div');
            row.className = 'input-group mb-2 item-row shadow-sm';
            row.innerHTML = `
                <span class="input-group-text bg-light">
                    <i class="fa fa-grip-vertical text-secondary"></i>
                </span>
                <input type="text" name="${inputName}" class="form-control" placeholder="Enter item...">
                <button type="button" class="btn btn-outline-danger remove-item-btn" title="Remove item">
                    <i class="fa fa-trash-alt"></i>
                </button>`;
            list.appendChild(row);
        }

        function syncEnToFr() {
            const frList = document.getElementById('fr-items-list');
            const enList = document.getElementById('en-items-list');
            const frCount = frList.querySelectorAll('.item-row').length;
            const enRows = enList.querySelectorAll('.item-row');
            const enCount = enRows.length;

            if (frCount > enCount) {
                for (let i = enCount; i < frCount; i++) {
                    addItemRow('en-items-list', 'en[items][]');
                }
            } else if (frCount < enCount) {
                const rowsToRemove = Array.from(enRows).slice(frCount);
                rowsToRemove.forEach(row => row.remove());
                // ensure at least one row
                if (enList.querySelectorAll('.item-row').length === 0) {
                    addItemRow('en-items-list', 'en[items][]');
                }
            }
        }

        document.getElementById('add-fr-item').addEventListener('click', function () {
            addItemRow('fr-items-list', 'items[]');
            syncEnToFr();
        });

        document.getElementById('add-en-item').addEventListener('click', function () {
            addItemRow('en-items-list', 'en[items][]');
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-item-btn')) {
                const btn = e.target.closest('.remove-item-btn');
                const list = btn.closest('[id$="-items-list"]');
                const rows = list.querySelectorAll('.item-row');
                const isFrList = list.id === 'fr-items-list';

                if (rows.length > 1) {
                    btn.closest('.item-row').remove();
                } else {
                    const input = list.querySelector('.item-row input');
                    if (input) input.value = '';
                }

                if (isFrList) {
                    syncEnToFr();
                }
            }
        });
    </script>
@endpush
