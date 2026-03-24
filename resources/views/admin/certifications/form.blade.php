@extends('admin.layouts.master')

@section('title', $mode === 'edit' ? __('admin.certification.form.title_edit') : __('admin.certification.form.title_create'))

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css" />
@endpush

@section('content')
    <x-breadcrumb item="{{ __('admin.common.cms') }}" active="{{ $mode === 'edit' ? __('admin.certification.form.title_edit') : __('admin.certification.form.title_create') }}"/>

    <div class="row">
        <div class="col-sm-12">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ __('admin.common.fix_errors') }}</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ $mode === 'edit' ? __('admin.certification.form.title_edit') : __('admin.certification.form.title_create') }}</h5>
                    <a href="{{ route('admin.certifications.index') }}" class="btn btn-light btn-sm">{{ __('admin.common.back_to_list') }}</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $mode === 'edit' ? route('admin.certifications.update', $certification) : route('admin.certifications.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if ($mode === 'edit')
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="certification-language-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="certification-fr-tab" data-bs-toggle="tab" data-bs-target="#certification-fr-pane" type="button" role="tab" aria-controls="certification-fr-pane" aria-selected="true">{{ __('admin.certification.form.tabs.french') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="certification-en-tab" data-bs-toggle="tab" data-bs-target="#certification-en-pane" type="button" role="tab" aria-controls="certification-en-pane" aria-selected="false">{{ __('admin.certification.form.tabs.english') }}</button>
                                    </li>
                                </ul>
                                <div class="tab-content border border-top-0 rounded-bottom p-3" id="certification-language-tabs-content">
                                    <div class="tab-pane fade show active" id="certification-fr-pane" role="tabpanel" aria-labelledby="certification-fr-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label for="certification-name-fr" class="form-label">{{ __('admin.certification.form.fields.name_fr') }}</label>
                                            <input type="text" class="form-control" id="certification-name-fr" name="name_fr" value="{{ $form['name_fr'] }}" required>
                                        </div>
                                        <div>
                                            <label for="certification-description-fr" class="form-label">{{ __('admin.certification.form.fields.description_fr') }}</label>
                                            <textarea class="form-control" id="certification-description-fr" name="description_fr" rows="4" required>{{ $form['description_fr'] }}</textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="certification-en-pane" role="tabpanel" aria-labelledby="certification-en-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label for="certification-name-en" class="form-label">{{ __('admin.certification.form.fields.name_en') }}</label>
                                            <input type="text" class="form-control" id="certification-name-en" name="name_en" value="{{ $form['name_en'] }}" required>
                                        </div>
                                        <div>
                                            <label for="certification-description-en" class="form-label">{{ __('admin.certification.form.fields.description_en') }}</label>
                                            <textarea class="form-control" id="certification-description-en" name="description_en" rows="4" required>{{ $form['description_en'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label d-block">{{ __('admin.certification.form.fields.image') }}</label>

                                @php $hasImage = !empty($form['image_url']); @endphp

                                <div id="certification-image-existing" style="{{ $hasImage ? '' : 'display:none' }}">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <p class="text-secondary-emphasis small mb-0">
                                            <i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.certification.form.fields.current_image') }}
                                        </p>
                                        <button type="button" class="btn btn-sm btn-outline-warning" id="certification-image-change-btn">
                                            <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                        </button>
                                    </div>
                                    <img id="certification-image-preview-img"
                                         src="{{ $form['image_url'] ?? '' }}"
                                         alt="{{ __('admin.certification.form.fields.current_image_alt') }}"
                                         class="rounded img-thumbnail shadow-sm" style="max-height:120px;">
                                </div>

                                <div id="certification-image-dropzone-wrapper" style="{{ $hasImage ? 'display:none' : '' }}">
                                    <div id="certification-image-dropzone" class="dropzone">
                                        <div class="dz-message needsclick">
                                            <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                            <small class="text-muted d-block mt-1">
                                                {{ $mode === 'edit' ? __('admin.certification.form.dropzone.edit_help') : __('admin.certification.form.dropzone.create_help') }}
                                            </small>
                                        </div>
                                        <div class="fallback">
                                            <input name="file" type="file" />
                                        </div>
                                    </div>
                                    @if($hasImage)
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="certification-image-cancel-btn">
                                        <i class="fa fa-times me-1"></i>Cancel
                                    </button>
                                    @endif
                                </div>

                                <input type="file" class="d-none" id="certification-image" name="image" accept="image/*">
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ $mode === 'edit' ? __('admin.common.update') : __('admin.common.create') }}</button>
                            <a href="{{ route('admin.certifications.index') }}" class="btn btn-light">{{ __('admin.common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script>
        (() => {
            const imageInput = document.getElementById('certification-image');
            if (!imageInput || typeof Dropzone === 'undefined') {
                return;
            }

            Dropzone.autoDiscover = false;

            const existingDiv   = document.getElementById('certification-image-existing');
            const wrapperDiv    = document.getElementById('certification-image-dropzone-wrapper');
            const previewImg    = document.getElementById('certification-image-preview-img');
            const changeBtn     = document.getElementById('certification-image-change-btn');
            const cancelBtn     = document.getElementById('certification-image-cancel-btn');

            const showDropzone  = () => { existingDiv.style.display = 'none';  wrapperDiv.style.display = ''; };
            const showExisting  = () => { wrapperDiv.style.display  = 'none';  existingDiv.style.display = ''; };

            if (changeBtn) changeBtn.addEventListener('click', showDropzone);
            if (cancelBtn) cancelBtn.addEventListener('click', showExisting);

            const certificationDropzone = new Dropzone('#certification-image-dropzone', {
                url: '#',
                autoProcessQueue: false,
                uploadMultiple: false,
                maxFiles: 1,
                paramName: 'image',
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
            });

            certificationDropzone.on('addedfile', (file) => {
                if (!(file instanceof Blob)) {
                    return;
                }

                certificationDropzone.files
                    .filter((dzFile) => dzFile !== file && dzFile.size !== undefined)
                    .forEach((dzFile) => certificationDropzone.removeFile(dzFile));

                const dt = new DataTransfer();
                dt.items.add(file);
                imageInput.files = dt.files;

                // Show preview of newly selected file
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    existingDiv.style.display = '';
                    wrapperDiv.style.display = 'none';
                };
                reader.readAsDataURL(file);
            });

            certificationDropzone.on('removedfile', () => {
                if (certificationDropzone.files.some((dzFile) => dzFile.size !== undefined)) {
                    return;
                }

                const dt = new DataTransfer();
                imageInput.files = dt.files;
            });
        })();
    </script>
@endpush
