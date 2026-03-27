@extends('admin.layouts.master')

@section('title', __('admin.about-us.title'))

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-12">
                <x-admin.status-messages/>

                <form action="{{ route('admin.pages.about-us.update') }}"
                      enctype="multipart/form-data"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <x-admin.page-header
                        :title="__('admin.pages.about.title')"
                        :subtitle="__('admin.pages.about.subtitle')"
                        :back-url="route('admin.dashboard')"/>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <x-admin.language-tabs id-prefix="about"/>
                            </div>

                            <div class="tab-content mb-4" id="aboutLangTabsContent">
                                @foreach($locales as $locale)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                         id="about-{{ $locale }}-content"
                                         role="tabpanel"
                                         aria-labelledby="about-{{ $locale }}-tab">
                                        <div class="d-grid gap-4">
                                            @foreach($contentSections[$locale] ?? [] as $section)
                                                <div class="rounded-3 border p-3 p-lg-4">
                                                    <x-admin.section-title
                                                        :title="$section['title']"
                                                        :icon="$section['icon']"
                                                        class="mb-3"/>

                                                    @if(!empty($section['text_input_fields']))
                                                        <div class="row g-3">
                                                            @foreach($section['text_input_fields'] as $field)
                                                                <div class="{{ $field['column_class'] }}">
                                                                    <x-admin.text-input
                                                                        :name="$field['name']"
                                                                        :label="$field['label']"
                                                                        :value="$field['value']"
                                                                        :required="$field['required']"
                                                                        :locale="$locale"/>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @if(!empty($section['textarea_fields']))
                                                        <div class="row g-3">
                                                            @foreach($section['textarea_fields'] as $field)
                                                                <div class="{{ $field['column_class'] }}">
                                                                    <x-admin.textarea
                                                                        :name="$field['name']"
                                                                        :label="$field['label']"
                                                                        :value="$field['value']"
                                                                        :required="$field['required']"
                                                                        :locale="$locale"
                                                                        :rows="$field['rows']"/>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-grid gap-4">
                                @foreach($imageSections as $imageSection)
                                    <div class="rounded-3 border p-3 p-lg-4">
                                        <x-admin.section-title
                                            :title="$imageSection['title']"
                                            :icon="$imageSection['icon']"
                                            class="mb-3"/>

                                        <div class="row g-4">
                                            @foreach($imageSection['fields'] as $field)
                                                <div class="col-md-6">
                                                    <x-admin.image-upload
                                                        :key="$field['key']"
                                                        :label="$field['label']"
                                                        :value="$field['value']"/>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <x-admin.form-actions/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/build/js/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('/build/js/plugins/dropzone-amd-module.min.js')}}"></script>

    <script>
        if (typeof Dropzone !== 'undefined') {
            Dropzone.autoDiscover = false;
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize TinyMCE
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: @json($tinyMceSelectors).join(', '),
                    plugins: 'lists link code',
                    toolbar: 'undo redo | bold italic underline | bullist numlist | link | code',
                    menubar: false,
                    height: 300,
                    branding: false,
                    license_key: 'gpl',
                    language: 'en',
                    paste_data_images: false,
                    automatic_uploads: false,
                    images_upload_handler: () => Promise.reject('Image uploads are disabled.'),
                });
            }

            // Initialize Dropzone for all image uploads
            if (typeof Dropzone !== 'undefined') {
                Dropzone.autoDiscover = false;
                const imageKeys = @json($imageKeys);

                imageKeys.forEach(key => {
                    const dropzoneElement = document.getElementById(`${key}-dropzone`);
                    if (!dropzoneElement) return;
                    if (dropzoneElement.dropzone) return;

                    const pathInput = document.getElementById(`${key}-path`);
                    const existingDiv = document.getElementById(`${key}-existing`);
                    const wrapperDiv = document.getElementById(`${key}-dropzone-wrapper`);
                    const previewImg = document.getElementById(`${key}-preview-img`);

                    const uploadUrl = dropzoneElement.dataset.uploadUrl || '{{ route('admin.pages.about-us.upload-image') }}';
                    const csrfToken = "{{ csrf_token() }}";

                    const dz = new Dropzone(`#${key}-dropzone`, {
                        url: uploadUrl,
                        autoProcessQueue: true,
                        uploadMultiple: false,
                        maxFiles: 1,
                        paramName: 'image',
                        acceptedFiles: 'image/*',
                        addRemoveLinks: true,
                        maxFilesize: 5,
                        headers: {'X-CSRF-TOKEN': csrfToken},
                    });

                    dz.on('sending', (file, xhr, formData) => {
                        formData.append('key', key);
                    });

                    dz.on('addedfile', () => {
                        dz.files
                            .filter((f, i) => i < dz.files.length - 1)
                            .forEach((f) => dz.removeFile(f));
                    });

                    dz.on('success', (file, response) => {
                        if (response.path) {
                            pathInput.value = response.path;
                            if (previewImg) previewImg.src = response.url;
                            if (existingDiv) existingDiv.style.display = '';
                            if (wrapperDiv) wrapperDiv.style.display = 'none';
                        }
                    });

                    dz.on('error', (file, message) => {
                        console.error('Upload error for', key, ':', message);
                    });
                });
            }

            // Handle change/cancel buttons
            document.querySelectorAll('.image-change-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const key = btn.dataset.key;
                    const existingDiv = document.getElementById(`${key}-existing`);
                    const wrapperDiv = document.getElementById(`${key}-dropzone-wrapper`);
                    if (existingDiv) existingDiv.style.display = 'none';
                    if (wrapperDiv) wrapperDiv.style.display = '';
                });
            });

            document.querySelectorAll('.image-cancel-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const key = btn.dataset.key;
                    const existingDiv = document.getElementById(`${key}-existing`);
                    const wrapperDiv = document.getElementById(`${key}-dropzone-wrapper`);
                    if (existingDiv) existingDiv.style.display = '';
                    if (wrapperDiv) wrapperDiv.style.display = 'none';
                });
            });
        });
    </script>
@endpush
