@php use App\Enums\ContentKey; @endphp
@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush
@section('title', __('admin.contact.title'))
@section('content')
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-12">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fs-5 me-2"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle fs-5 me-2"></i>
                            <span>{{ __('admin.common.fix_errors') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.pages.contact.update') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Header Card -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
                                <div>
                                    <h4 class="fw-bold mb-1">{{ __('admin.contact.title') }}</h4>
                                    <p class="text-secondary-emphasis mb-0 small">{{ __('admin.contact.subtitle') }}</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                        <i class="fa fa-arrow-left me-2"></i>
                                        {{ __('admin.common.back_to_list') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fa fa-save me-2"></i>
                                        {{ __('admin.common.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Title -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-4">
                                <i class="fa fa-heading me-2 text-primary"></i>
                                {{ __('admin.content_keys.contact_title') }}
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ __('admin.common.french') }}</label>
                                    <input type="text" name="{{ ContentKey::CONTACT_TITLE->value }}"
                                           class="form-control @error(ContentKey::CONTACT_TITLE->value) is-invalid @enderror"
                                           value="{{ old(ContentKey::CONTACT_TITLE->value, $data[ContentKey::CONTACT_TITLE->value] ?? '') }}">
                                    @error(ContentKey::CONTACT_TITLE->value)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ __('admin.common.english') }}</label>
                                    <input type="text" name="en[{{ ContentKey::CONTACT_TITLE->value }}]"
                                           class="form-control"
                                           value="{{ old('en.' . ContentKey::CONTACT_TITLE->value, $data['en'][ContentKey::CONTACT_TITLE->value] ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form Text -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-4">
                                <i class="fa fa-align-left me-2 text-primary"></i>
                                {{ __('admin.content_keys.contact_form_text') }}
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ __('admin.common.french') }}</label>
                                    <textarea name="{{ ContentKey::CONTACT_FORM_TEXT->value }}"
                                              class="form-control @error(ContentKey::CONTACT_FORM_TEXT->value) is-invalid @enderror"
                                              rows="4">{{ old(ContentKey::CONTACT_FORM_TEXT->value, $data[ContentKey::CONTACT_FORM_TEXT->value] ?? '') }}</textarea>
                                    @error(ContentKey::CONTACT_FORM_TEXT->value)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ __('admin.common.english') }}</label>
                                    <textarea name="en[{{ ContentKey::CONTACT_FORM_TEXT->value }}]"
                                              class="form-control"
                                              rows="4">{{ old('en.' . ContentKey::CONTACT_FORM_TEXT->value, $data['en'][ContentKey::CONTACT_FORM_TEXT->value] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Embed -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-4">
                                <i class="fa fa-map me-2 text-primary"></i>
                                {{ __('admin.content_keys.map_embed') }}
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-medium">{{ __('admin.content_keys.map_embed') }}</label>
                                    <textarea name="{{ ContentKey::MAP_EMBED->value }}"
                                              class="form-control @error(ContentKey::MAP_EMBED->value) is-invalid @enderror"
                                              rows="4"
                                              placeholder="<iframe src=&quot;https://maps.google.com/...&quot;></iframe>">{{ old(ContentKey::MAP_EMBED->value, $data[ContentKey::MAP_EMBED->value] ?? '') }}</textarea>
                                    @error(ContentKey::MAP_EMBED->value)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Image -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-4">
                                <i class="fa fa-image me-2 text-primary"></i>
                                {{ __('admin.content_keys.contact_image') }}
                            </h5>
                            <div id="{{ ContentKey::CONTACT_IMAGE->value }}-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                <div class="dz-message">
                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                </div>
                            </div>
                            <input type="hidden" name="{{ ContentKey::CONTACT_IMAGE->value }}"
                                   id="{{ ContentKey::CONTACT_IMAGE->value }}-input"
                                   value="{{ $images[ContentKey::CONTACT_IMAGE->value] ?? '' }}">
                            <div id="{{ ContentKey::CONTACT_IMAGE->value }}-preview" class="mt-3 text-center" style="{{ empty($images[ContentKey::CONTACT_IMAGE->value]) ? 'display:none' : '' }}">
                                <p class="text-secondary-emphasis small mb-2">{{ __('admin.common.current') }}</p>
                                <img id="{{ ContentKey::CONTACT_IMAGE->value }}-img"
                                     src="{{ !empty($images[ContentKey::CONTACT_IMAGE->value]) ? Storage::disk('public')->url($images[ContentKey::CONTACT_IMAGE->value]) : '' }}"
                                     alt="contact image" class="img-fluid rounded-3 shadow-sm" style="max-height:300px;">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mb-4">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fa fa-save me-2"></i>
                            {{ __('admin.common.save') }}
                        </button>
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
        const uploadUrl = '{{ route('admin.pages.contact.upload-image') }}';
        const csrfToken = '{{ csrf_token() }}';

        const init_dropzone = (img) => {
            const inputEl = document.getElementById(`${img}-input`);
            const previewEl = document.getElementById(`${img}-preview`);
            const imgEl = document.getElementById(`${img}-img`);

            const dz = new Dropzone(`#${img}-dropzone`, {
                url: uploadUrl,
                maxFiles: 1,
                maxFilesize: 10,
                paramName: 'image',
                acceptedFiles: 'image/*',
                headers: {'X-CSRF-TOKEN': csrfToken},
                params: {key: img},
                success(file, response) {
                    inputEl.value = response.path;
                    imgEl.src = response.url;
                    previewEl.style.display = '';
                },
            });
        };

        @php $imageKeys = [ContentKey::CONTACT_IMAGE->value]; @endphp
        const imageKeys = @json($imageKeys);
        imageKeys.forEach((image) => {
            init_dropzone(image);
        });
    </script>
@endpush
