@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush

@php($isEdit = $domain->exists)

@section('title', $isEdit ? __('admin.domains.edit') : __('admin.domains.create'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.domains.update', $domain) : route('admin.domains.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <x-admin.page-header
                    :title="$isEdit ? __('admin.domains.edit') : __('admin.domains.add')"
                    :subtitle="$isEdit ? __('admin.domains.form.subtitle_edit') : __('admin.domains.form.subtitle_create')"
                    :back-url="route('admin.domains.index')"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <x-admin.language-tabs id-prefix="domain" class="mb-3"/>

                                <div class="tab-content" id="domainTabsContent">
                                    <div class="tab-pane fade show active" id="domain-fr-content" role="tabpanel" aria-labelledby="domain-fr-tab">
                                        <x-admin.text-input
                                            name="title"
                                            :label="__('admin.domains.form.title_fr')"
                                            :value="old('title', $form['title'])"
                                            :required="true"/>

                                        <label class="fw-semibold mb-2">{{ __('admin.domains.items_fr') }}</label>
                                        <div id="fr-items-list" class="mb-2">
                                            @php($frItems = old('items', $form['items']))
                                            @if(count($frItems) > 0)
                                                @foreach($frItems as $item)
                                                    <div class="input-group mb-2 item-row">
                                                        <input type="text" name="items[]" class="form-control" value="{{ $item }}" placeholder="{{ __('admin.domains.form.item_placeholder') }}">
                                                        <button type="button" class="btn btn-outline-danger remove-item-btn"><i class="fa fa-trash-alt"></i></button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2 item-row">
                                                    <input type="text" name="items[]" class="form-control" placeholder="{{ __('admin.domains.form.item_placeholder') }}">
                                                    <button type="button" class="btn btn-outline-danger remove-item-btn"><i class="fa fa-trash-alt"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-fr-item">
                                            <i class="fa fa-plus-circle me-2"></i>{{ __('admin.domains.form.add_item') }}
                                        </button>
                                    </div>

                                    <div class="tab-pane fade" id="domain-en-content" role="tabpanel" aria-labelledby="domain-en-tab">
                                        <x-admin.text-input
                                            name="en[title]"
                                            :label="__('admin.domains.form.title_en')"
                                            :value="old('en.title', $form['en']['title'] ?? '')"/>

                                        <label class="fw-semibold mb-2">{{ __('admin.domains.items_en') }}</label>
                                        <div id="en-items-list" class="mb-2">
                                            @php($enItems = old('en.items', $form['en']['items'] ?? []))\
                                            @if(count($enItems) > 0)
                                                @foreach($enItems as $item)
                                                    <div class="input-group mb-2 item-row">
                                                        <input type="text" name="en[items][]" class="form-control" value="{{ $item }}" placeholder="{{ __('admin.domains.form.item_placeholder') }}">
                                                        <button type="button" class="btn btn-outline-danger remove-item-btn"><i class="fa fa-trash-alt"></i></button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2 item-row">
                                                    <input type="text" name="en[items][]" class="form-control" placeholder="{{ __('admin.domains.form.item_placeholder') }}">
                                                    <button type="button" class="btn btn-outline-danger remove-item-btn"><i class="fa fa-trash-alt"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-en-item">
                                            <i class="fa fa-plus-circle me-2"></i>{{ __('admin.domains.form.add_item') }}
                                        </button>
                                    </div>

                                    <div class="tab-pane fade" id="domain-ar-content" role="tabpanel" aria-labelledby="domain-ar-tab">
                                        <div dir="rtl">
                                            <x-admin.text-input
                                                name="ar[title]"
                                                :label="__('admin.domains.form.title_ar')"
                                                :value="old('ar.title', $form['ar']['title'] ?? '')"/>

                                            <label class="fw-semibold mb-2">{{ __('admin.domains.items_ar') }}</label>
                                            <div id="ar-items-list" class="mb-2">
                                                @php($arItems = old('ar.items', $form['ar']['items'] ?? []))
                                                @if(count($arItems) > 0)
                                                    @foreach($arItems as $item)
                                                        <div class="input-group mb-2 item-row">
                                                            <input type="text" name="ar[items][]" class="form-control" value="{{ $item }}" placeholder="{{ __('admin.domains.form.item_placeholder') }}" dir="rtl">
                                                            <button type="button" class="btn btn-outline-danger remove-item-btn"><i class="fa fa-trash-alt"></i></button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2 item-row">
                                                        <input type="text" name="ar[items][]" class="form-control" placeholder="{{ __('admin.domains.form.item_placeholder') }}" dir="rtl">
                                                        <button type="button" class="btn btn-outline-danger remove-item-btn"><i class="fa fa-trash-alt"></i></button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-ar-item">
                                                <i class="fa fa-plus-circle me-2"></i>{{ __('admin.domains.form.add_item') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card border mb-4">
                                    <div class="card-header bg-transparent border-bottom">
                                        <h6 class="fw-semibold mb-0">{{ __('admin.domains.form.icon') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="icon-existing" style="{{ filled($form['icon'] ?? null) ? '' : 'display:none' }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="text-secondary-emphasis small mb-0">
                                                    <i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}
                                                </p>
                                                <button type="button" class="btn btn-sm btn-outline-warning" id="icon-change-btn">
                                                    <i class="fa fa-pencil me-1"></i>{{ __('admin.common.change') }}
                                                </button>
                                            </div>
                                            <img id="icon-preview-img"
                                                 src="{{ filled($form['icon'] ?? null) ? Storage::disk('public')->url($form['icon']) : '' }}"
                                                 alt="current" class="img-thumbnail shadow-sm" style="max-height:120px;">
                                        </div>

                                        <div id="icon-dropzone-wrapper" style="{{ filled($form['icon'] ?? null) ? 'display:none' : '' }}">
                                            <div id="icon-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                <div class="dz-message needsclick">
                                                    <i class="fa fa-cloud-upload-alt fs-1 text-secondary mb-3"></i>
                                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                </div>
                                            </div>
                                            @if(filled($form['icon'] ?? null))
                                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="icon-cancel-btn">
                                                    <i class="fa fa-times me-1"></i>{{ __('admin.common.cancel') }}
                                                </button>
                                            @endif
                                        </div>

                                        <input type="hidden" id="icon-path" name="icon" value="{{ old('icon', $form['icon']) }}">
                                        @error('icon')
                                        <div class="text-danger small mt-2">
                                            <i class="fa fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light-subtle border-top p-4 text-end">
                        <button type="submit" class="btn btn-primary px-5">{{ __('admin.domains.form.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        const uploadUrl = '{{ route('admin.domains.upload-image') }}';
        const csrfToken = '{{ csrf_token() }}';

        const pathInput = document.getElementById('icon-path');
        const existingDiv = document.getElementById('icon-existing');
        const wrapperDiv = document.getElementById('icon-dropzone-wrapper');
        const previewImg = document.getElementById('icon-preview-img');
        const changeBtn = document.getElementById('icon-change-btn');
        const cancelBtn = document.getElementById('icon-cancel-btn');

        const showDropzone = () => {
            existingDiv.style.display = 'none';
            wrapperDiv.style.display = '';
        };
        const showExisting = () => {
            wrapperDiv.style.display = 'none';
            existingDiv.style.display = '';
        };

        if (changeBtn) {
            changeBtn.addEventListener('click', showDropzone);
        }
        if (cancelBtn) {
            cancelBtn.addEventListener('click', showExisting);
        }

        if (typeof Dropzone !== 'undefined') {
            const dz = new Dropzone('#icon-dropzone', {\
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
                dz.files.filter((file, index) => index < dz.files.length - 1).forEach((file) => dz.removeFile(file));
            });

            dz.on('success', (file, response) => {
                if (response.path) {
                    pathInput.value = response.path;
                    previewImg.src = response.url;
                    showExisting();
                }
            });
        }

        function addItemRow(listId, inputName, isRtl = false) {
            const list = document.getElementById(listId);
            if (!list) return;
            const row = document.createElement('div');
            row.className = 'input-group mb-2 item-row';
            const dirAttr = isRtl ? 'dir="rtl"' : '';
            row.innerHTML = `
                <input type="text" name="${inputName}" class="form-control" placeholder="{{ __('admin.domains.form.item_placeholder') }}" ${dirAttr}>
                <button type="button" class="btn btn-outline-danger remove-item-btn"><i class="fa fa-trash-alt"></i></button>`;
            list.appendChild(row);
        }

        function syncLocalesToFr() {
            const frList = document.getElementById('fr-items-list');
            const enList = document.getElementById('en-items-list');
            const arList = document.getElementById('ar-items-list');
            const frCount = frList.querySelectorAll('.item-row').length;

            if (enList) {
                const enRows = enList.querySelectorAll('.item-row');
                const enCount = enRows.length;
                if (frCount > enCount) {
                    for (let i = enCount; i < frCount; i++) {
                        addItemRow('en-items-list', 'en[items][]');
                    }
                } else if (frCount < enCount) {
                    const rowsToRemove = Array.from(enRows).slice(frCount);
                    rowsToRemove.forEach((row) => row.remove());
                    if (enList.querySelectorAll('.item-row').length === 0) {
                        addItemRow('en-items-list', 'en[items][]');
                    }
                }
            }

            if (arList) {
                const arRows = arList.querySelectorAll('.item-row');
                const arCount = arRows.length;
                if (frCount > arCount) {
                    for (let i = arCount; i < frCount; i++) {
                        addItemRow('ar-items-list', 'ar[items][]', true);
                    }
                } else if (frCount < arCount) {
                    const rowsToRemove = Array.from(arRows).slice(frCount);
                    rowsToRemove.forEach((row) => row.remove());
                    if (arList.querySelectorAll('.item-row').length === 0) {
                        addItemRow('ar-items-list', 'ar[items][]', true);
                    }
                }
            }
        }

        document.getElementById('add-fr-item')?.addEventListener('click', function () {
            addItemRow('fr-items-list', 'items[]');
            syncLocalesToFr();
        });

        document.getElementById('add-en-item')?.addEventListener('click', function () {
            addItemRow('en-items-list', 'en[items][]');
        });

        document.getElementById('add-ar-item')?.addEventListener('click', function () {
            addItemRow('ar-items-list', 'ar[items][]', true);
        });

        document.addEventListener('click', function (event) {
            if (event.target.closest('.remove-item-btn')) {
                const button = event.target.closest('.remove-item-btn');
                const list = button.closest('[id$="-items-list"]');
                const rows = list.querySelectorAll('.item-row');
                const isFrList = list.id === 'fr-items-list';

                if (rows.length > 1) {
                    button.closest('.item-row').remove();
                } else {
                    const input = list.querySelector('.item-row input');
                    if (input) {
                        input.value = '';
                    }
                }

                if (isFrList) {
                    syncLocalesToFr();
                }
            }
        });
    </script>
@endpush
