@extends('admin.layouts.master')

@section('title', $mode === 'edit' ? __('admin.certification.form.title_edit') : __('admin.certification.form.title_create'))

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css" />
@endpush

@section('content')
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

            <x-admin.page-header
                :title="$mode === 'edit' ? __('admin.certification.form.title_edit') : __('admin.certification.form.title_create')"
                :subtitle="$mode === 'edit' ? __('admin.certification.form.title_edit') : __('admin.certification.form.title_create')"
                :back-url="route('admin.certifications.index')"
                :back-label="__('admin.common.back_to_list')"/>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ $mode === 'edit' ? route('admin.certifications.update', $certification) : route('admin.certifications.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if ($mode === 'edit')
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <x-admin.section-title
                                            class="mb-3"
                                            icon="fa fa-language"
                                            :title="__('admin.certification.form.tabs.french')"/>
                                        <x-admin.text-input
                                            name="name_fr"
                                            id="certification-name-fr"
                                            :label="__('admin.certification.form.fields.name_fr')"
                                            :value="$form['name_fr']"
                                            :required="true"/>
                                        <x-admin.textarea
                                            name="description_fr"
                                            id="certification-description-fr"
                                            :label="__('admin.certification.form.fields.description_fr')"
                                            :value="$form['description_fr']"
                                            :rows="4"
                                            :floating="true"
                                            :required="true"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-admin.section-title
                                            class="mb-3"
                                            icon="fa fa-language"
                                            :title="__('admin.certification.form.tabs.english')"/>
                                        <x-admin.text-input
                                            name="name_en"
                                            id="certification-name-en"
                                            :label="__('admin.certification.form.fields.name_en')"
                                            :value="$form['name_en']"
                                            :required="true"/>
                                        <x-admin.textarea
                                            name="description_en"
                                            id="certification-description-en"
                                            :label="__('admin.certification.form.fields.description_en')"
                                            :value="$form['description_en']"
                                            :rows="4"
                                            :floating="true"
                                            :required="true"/>
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
                                        <i class="fa fa-times me-1"></i>{{ __('admin.common.cancel') }}
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
    <script src="{{asset('/build/js/plugins/dropzone-amd-module.min.js')}}"></script>
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
