@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush

@php($isEdit = $value->exists)
@php($titleLabel = $type === 'human_values' ? __('admin.values.title_human_values') : __('admin.values.title_values'))
@php($hasImage = !empty(old('image', $form['image'] ?? null)))
@php($imageUrl = $hasImage ? \Illuminate\Support\Facades\Storage::disk('public')->url(old('image', $form['image'])) : '')

@section('title', $isEdit ? __('admin.values.edit_value', ['title' => $titleLabel]) : __('admin.values.create_value', ['title' => $titleLabel]))

@section('content')
    <x-breadcrumb item="{{ __('admin.common.cms') }}" :active="$isEdit ? __('admin.values.edit_value', ['title' => $titleLabel]) : __('admin.values.create_value', ['title' => $titleLabel])"/>

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.values.update', $value) : route('admin.values.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                <input type="hidden" name="type" value="{{ $form['type'] }}">

                <x-admin.page-header
                    :title="$isEdit ? __('admin.values.edit_value', ['title' => $titleLabel]) : ($type === 'human_values' ? __('admin.values.add_human_value') : __('admin.values.add_value'))"
                    :subtitle="__('admin.values.form.subtitle')"
                    :back-url="route('admin.values.index', ['type' => $type])"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="border rounded p-3">
                                    <h6 class="mb-3">{{ __('admin.values.image') }} (416 x 442)</h6>

                                    <div id="value_image-existing" style="{{ $hasImage ? '' : 'display:none' }}">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="text-secondary-emphasis small mb-0">
                                                <i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}
                                            </p>
                                            <button type="button" class="btn btn-sm btn-outline-warning media-change-btn" data-key="value_image">
                                                <i class="fa fa-pencil me-1"></i>{{ __('admin.common.change') }}
                                            </button>
                                        </div>
                                        <img id="value_image-preview-img"
                                             src="{{ $imageUrl }}"
                                             alt="value image"
                                             class="img-thumbnail shadow-sm"
                                             style="width: 100%; max-width: 416px; max-height: 442px; object-fit: cover;">
                                    </div>

                                    <div id="value_image-dropzone-wrapper" style="{{ $hasImage ? 'display:none' : '' }}">
                                        <div id="value_image-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                            <div class="dz-message needsclick">
                                                <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                <small class="text-secondary-emphasis d-block mt-1">{{ __('admin.values.form.image_help') }}</small>
                                            </div>
                                        </div>
                                        @if($hasImage)
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2 media-cancel-btn" data-key="value_image">
                                                <i class="fa fa-times me-1"></i>{{ __('admin.common.cancel') }}
                                            </button>
                                        @endif
                                    </div>

                                    <input type="hidden" id="value_image-path" name="image" value="{{ old('image', $form['image'] ?? '') }}">
                                    @error('image')
                                        <div class="text-danger small mt-2">
                                            <i class="fa fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <x-admin.language-tabs id-prefix="value" class="mb-3"/>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="value-fr-content" role="tabpanel" aria-labelledby="value-fr-tab">
                                        <div class="border rounded p-3 h-100">
                                            <x-admin.text-input
                                                name="title"
                                                :label="__('admin.values.title_fr')"
                                                :value="old('title', $form['title'])"
                                                :required="true"/>
                                            <div class="form-floating mb-3">
                                                <textarea
                                                    name="text"
                                                    id="value_text_fr"
                                                    class="form-control js-value-editor @error('text') is-invalid @enderror"
                                                    rows="5"
                                                    placeholder="{{ __('admin.values.text_fr') }}"
                                                    required>{{ old('text', $form['text']) }}</textarea>
                                                <label class="fw-semibold" for="value_text_fr">{{ __('admin.values.text_fr') }} <span class="text-danger">*</span></label>
                                                @error('text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="value-en-content" role="tabpanel" aria-labelledby="value-en-tab">
                                        <div class="border rounded p-3 h-100">
                                            <x-admin.text-input
                                                name="en[title]"
                                                :label="__('admin.values.title_en')"
                                                :value="old('en.title', $form['en']['title'] ?? '')"/>
                                            <div class="form-floating mb-3">
                                                <textarea
                                                    name="en[text]"
                                                    id="value_text_en"
                                                    class="form-control js-value-editor"
                                                    rows="5"
                                                    placeholder="{{ __('admin.values.text_en') }}">{{ old('en.text', $form['en']['text'] ?? '') }}</textarea>
                                                <label class="fw-semibold" for="value_text_en">{{ __('admin.values.text_en') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="value-ar-content" role="tabpanel" aria-labelledby="value-ar-tab">
                                        <div class="border rounded p-3 h-100" dir="rtl">
                                            <x-admin.text-input
                                                name="ar[title]"
                                                :label="__('admin.values.title_ar')"
                                                :value="old('ar.title', $form['ar']['title'] ?? '')"/>
                                            <div class="form-floating mb-3">
                                                <textarea
                                                    name="ar[text]"
                                                    id="value_text_ar"
                                                    class="form-control js-value-editor"
                                                    rows="5"
                                                    dir="rtl"
                                                    placeholder="{{ __('admin.values.text_ar') }}">{{ old('ar.text', $form['ar']['text'] ?? '') }}</textarea>
                                                <label class="fw-semibold" for="value_text_ar">{{ __('admin.values.text_ar') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('admin.values.form.save', ['title' => $titleLabel]) }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/build/js/plugins/tinymce/tinymce.min.js"></script>
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        const uploadUrl = @json(route('admin.values.upload-image'));
        const csrfToken = "{{ csrf_token() }}";

        const init_dropzone = (img) => {
            const pathInput = document.getElementById(`${img}-path`);
            const existingDiv = document.getElementById(`${img}-existing`);
            const wrapperDiv = document.getElementById(`${img}-dropzone-wrapper`);
            const previewImg = document.getElementById(`${img}-preview-img`);
            const dropzoneEl = document.getElementById(`${img}-dropzone`);

            if (typeof Dropzone === 'undefined') {
                return;
            }

            if (!uploadUrl) {
                return;
            }

            if (!pathInput || !existingDiv || !wrapperDiv || !previewImg || !dropzoneEl) {
                return;
            }

            if (dropzoneEl.dropzone) {
                return;
            }

            const showDropzone = () => {
                existingDiv.style.display = 'none';
                wrapperDiv.style.display = '';
            };
            const showExisting = () => {
                wrapperDiv.style.display = 'none';
                existingDiv.style.display = '';
            };

            const changeBtn = existingDiv.querySelector('.media-change-btn');
            const cancelBtn = wrapperDiv.querySelector('.media-cancel-btn');

            if (changeBtn) {
                changeBtn.addEventListener('click', showDropzone);
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', showExisting);
            }

            const dz = new Dropzone(`#${img}-dropzone`, {
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
                dz.files
                    .filter((file, index) => index < dz.files.length - 1)
                    .forEach((file) => dz.removeFile(file));
            });

            dz.on('success', (file, response) => {
                if (response.path) {
                    pathInput.value = response.path;
                    previewImg.src = response.url;
                    showExisting();
                }
            });
        };

        document.addEventListener('DOMContentLoaded', () => {
            tinymce.init({
                selector: '.js-value-editor',
                menubar: false,
                height: 220,
                branding: false,
                toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
                plugins: [
                    'advlist', 'anchor', 'autolink', 'charmap', 'code', 'fullscreen',
                    'help', 'insertdatetime', 'link', 'lists', 'preview', 'searchreplace',
                    'table', 'visualblocks',
                ],
                setup: (editor) => {
                    editor.on('change keyup', () => {
                        editor.save();
                    });
                },
            });

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', () => {
                    if (window.tinymce) {
                        window.tinymce.triggerSave();
                    }
                });
            });

            init_dropzone('value_image');
        });
    </script>
@endpush
