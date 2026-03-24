@php use App\Enums\ContentKey; @endphp
@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush
@section('title', __('admin.about-us.title'))

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

                <form action="{{ route('admin.pages.about-us.update') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Header Card -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
                                <div>
                                    <h4 class="fw-bold mb-1">{{ __('admin.company_info.title') }}</h4>
                                    <p class="text-secondary-emphasis mb-0 small">{{ __('admin.company_info.subtitle') }}</p>
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

                    <!-- Main Content Card -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <!-- Language Tabs -->
                            <div class="mb-4">
                                <ul class="nav nav-tabs border-bottom" id="aboutLangTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active fw-semibold" id="about-fr-tab" data-bs-toggle="tab" data-bs-target="#about-fr-content" type="button" role="tab" aria-controls="about-fr-content" aria-selected="true">
                                            <i class="fa fa-language me-2"></i>French (Default)
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-semibold" id="about-en-tab" data-bs-toggle="tab" data-bs-target="#about-en-content" type="button" role="tab" aria-controls="about-en-content" aria-selected="false">
                                            <i class="fa fa-language me-2"></i>English
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Tab Content -->
                            <div class="tab-content mb-4" id="aboutLangTabsContent">
                                <!-- French Content -->
                                <div class="tab-pane fade show active" id="about-fr-content" role="tabpanel" aria-labelledby="about-fr-tab">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="{{ ContentKey::ABOUT_TITLE->value }}"
                                                       class="form-control @error(ContentKey::ABOUT_TITLE->value) is-invalid @enderror"
                                                       id="aboutTitleFr"
                                                       value="{{ old(ContentKey::ABOUT_TITLE->value, $data[ContentKey::ABOUT_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.placeholders.'.ContentKey::ABOUT_TITLE->value) }}">
                                                <label for="aboutTitleFr" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::ABOUT_TITLE->value) }} (FR)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                @error(ContentKey::ABOUT_TITLE->value)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="{{ ContentKey::ROUNDED_TEXT->value }}"
                                                       class="form-control @error(ContentKey::ROUNDED_TEXT->value) is-invalid @enderror"
                                                       id="aboutTitleFr"
                                                       value="{{ old(ContentKey::ROUNDED_TEXT->value, $data[ContentKey::ROUNDED_TEXT->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.placeholders.'.ContentKey::ROUNDED_TEXT->value) }}">
                                                <label for="aboutTitleFr" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::ROUNDED_TEXT->value) }} (FR)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                @error(ContentKey::ROUNDED_TEXT->value)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="{{ ContentKey::MISSION_TITLE->value }}"
                                                       class="form-control @error(ContentKey::MISSION_TITLE->value) is-invalid @enderror"
                                                       id="roundedTextFr"
                                                       value="{{ old(ContentKey::MISSION_TITLE->value, $data[ContentKey::MISSION_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.placeholders.'.ContentKey::MISSION_TITLE->value) }}">
                                                <label for="roundedTextFr" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::MISSION_TITLE->value) }} (FR)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                @error(ContentKey::MISSION_TITLE->value)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="{{ ContentKey::WHY_US_TITLE->value }}"
                                                       class="form-control @error(ContentKey::WHY_US_TITLE->value) is-invalid @enderror"
                                                       id="whyUsTitleFr"
                                                       value="{{ old(ContentKey::WHY_US_TITLE->value, $data[ContentKey::WHY_US_TITLE->value] ?? '') }}"
                                                       placeholder="Why Us Title">
                                                <label for="whyUsTitleFr" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::WHY_US_TITLE->value) }} (FR)
                                                </label>
                                                @error(ContentKey::WHY_US_TITLE->value)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::WHY_US_TEXT->value) }} (FR)
                                            </label>
                                            <textarea
                                                name="{{ ContentKey::WHY_US_TEXT->value }}"
                                                id="why_us_text_fr"
                                                class="form-control @error(ContentKey::WHY_US_TEXT->value) is-invalid @enderror"
                                                rows="6">{{ old(ContentKey::WHY_US_TEXT->value, $data[ContentKey::WHY_US_TEXT->value] ?? '') }}</textarea>
                                            @error(ContentKey::WHY_US_TEXT->value)
                                            <div class="invalid-feedback">
                                                <i class="fa fa-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::WHY_US_CARDS->value) }} (FR)
                                                <small class="text-secondary fw-normal ms-1">{{ __('admin.pages.about.why_us_cards_hint') }}</small>
                                            </label>
                                            <textarea
                                                name="{{ ContentKey::WHY_US_CARDS->value }}"
                                                id="why_us_cards_fr"
                                                rows="13"
                                                class="form-control @error(ContentKey::WHY_US_CARDS->value) is-invalid @enderror"
                                                rows="4">{{ old(ContentKey::WHY_US_CARDS->value, $data[ContentKey::WHY_US_CARDS->value] ?? '') }}</textarea>
                                            @error(ContentKey::WHY_US_CARDS->value)
                                            <div class="invalid-feedback">
                                                <i class="fa fa-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="{{ ContentKey::ORGANIGRAME_TITLE->value }}"
                                                       class="form-control @error(ContentKey::ORGANIGRAME_TITLE->value) is-invalid @enderror"
                                                       id="organigrameTitleFr"
                                                       value="{{ old(ContentKey::ORGANIGRAME_TITLE->value, $data[ContentKey::ORGANIGRAME_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.'.ContentKey::ORGANIGRAME_TITLE->value) }}">
                                                <label for="organigrameTitleFr" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::ORGANIGRAME_TITLE->value) }} (FR)
                                                </label>
                                                @error(ContentKey::ORGANIGRAME_TITLE->value)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="{{ ContentKey::CARTOGRAPHIE_TITLE->value }}"
                                                       class="form-control @error(ContentKey::CARTOGRAPHIE_TITLE->value) is-invalid @enderror"
                                                       id="cartographieTitleFr"
                                                       value="{{ old(ContentKey::CARTOGRAPHIE_TITLE->value, $data[ContentKey::CARTOGRAPHIE_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.'.ContentKey::CARTOGRAPHIE_TITLE->value) }}">
                                                <label for="cartographieTitleFr" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::CARTOGRAPHIE_TITLE->value) }} (FR)
                                                </label>
                                                @error(ContentKey::CARTOGRAPHIE_TITLE->value)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::ABOUT_TEXT->value) }} (FR)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea
                                                name="{{ ContentKey::ABOUT_TEXT->value }}"
                                                id="about_text_fr"
                                                class="form-control @error(ContentKey::ABOUT_TEXT->value) is-invalid @enderror"
                                                rows="6">{{ old(ContentKey::ABOUT_TEXT->value, $data[ContentKey::ABOUT_TEXT->value] ?? '') }}</textarea>
                                            @error(ContentKey::ABOUT_TEXT->value)
                                            <div class="invalid-feedback">
                                                <i class="fa fa-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::MISSION_TEXT->value) }} (FR)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea
                                                name="{{ ContentKey::MISSION_TEXT->value }}"
                                                id="about_text_fr"
                                                class="form-control @error(ContentKey::MISSION_TEXT->value) is-invalid @enderror"
                                                rows="6">{{ old(ContentKey::MISSION_TEXT->value, $data[ContentKey::MISSION_TEXT->value] ?? '') }}</textarea>
                                            @error(ContentKey::MISSION_TEXT->value)
                                            <div class="invalid-feedback">
                                                <i class="fa fa-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- English Content -->
                                <div class="tab-pane fade" id="about-en-content" role="tabpanel" aria-labelledby="about-en-tab">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="en[{{ ContentKey::ABOUT_TITLE->value }}]"
                                                       class="form-control"
                                                       id="aboutTitleEn"
                                                       value="{{ old('en.'.ContentKey::ABOUT_TITLE->value, $data['en'][ContentKey::ABOUT_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.placeholders.'.ContentKey::ABOUT_TITLE->value) }}">
                                                <label for="aboutTitleEn" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::ABOUT_TITLE->value) }} (EN)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="en[{{ ContentKey::ROUNDED_TEXT->value }}]"
                                                       class="form-control"
                                                       id="aboutTitleEn"
                                                       value="{{ old('en.'.ContentKey::ROUNDED_TEXT->value, $data['en'][ContentKey::ROUNDED_TEXT->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.placeholders.'.ContentKey::ROUNDED_TEXT->value) }}">
                                                <label for="aboutTitleEn" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::ROUNDED_TEXT->value) }} (EN)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="en[{{ ContentKey::MISSION_TITLE->value }}]"
                                                       class="form-control"
                                                       id="roundedTextEn"
                                                       value="{{ old('en.'.ContentKey::MISSION_TITLE->value, $data['en'][ContentKey::MISSION_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.placeholders.'.ContentKey::MISSION_TITLE->value) }}">
                                                <label for="roundedTextEn" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::MISSION_TITLE->value) }} (EN)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="en[{{ ContentKey::WHY_US_TITLE->value }}]"
                                                       class="form-control"
                                                       id="whyUsTitleEn"
                                                       value="{{ old('en.'.ContentKey::WHY_US_TITLE->value, $data['en'][ContentKey::WHY_US_TITLE->value] ?? '') }}"
                                                       placeholder="Why Us Title">
                                                <label for="whyUsTitleEn" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::WHY_US_TITLE->value) }} (EN)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::WHY_US_TEXT->value) }} (EN)
                                            </label>
                                            <textarea
                                                name="en[{{ ContentKey::WHY_US_TEXT->value }}]"
                                                id="why_us_text_en"
                                                class="form-control"
                                                rows="6">{{ old('en.'.ContentKey::WHY_US_TEXT->value, $data['en'][ContentKey::WHY_US_TEXT->value] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::WHY_US_CARDS->value) }} (EN)
                                                <small class="text-secondary fw-normal ms-1">{{ __('admin.pages.about.why_us_cards_hint') }}</small>
                                            </label>
                                            <textarea
                                                name="en[{{ ContentKey::WHY_US_CARDS->value }}]"
                                                rows="13"
                                                id="why_us_cards_en"
                                                class="form-control"
                                                rows="4">{{ old('en.'.ContentKey::WHY_US_CARDS->value, $data['en'][ContentKey::WHY_US_CARDS->value] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="en[{{ ContentKey::ORGANIGRAME_TITLE->value }}]"
                                                       class="form-control"
                                                       id="organigrameTitleEn"
                                                       value="{{ old('en.'.ContentKey::ORGANIGRAME_TITLE->value, $data['en'][ContentKey::ORGANIGRAME_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.'.ContentKey::ORGANIGRAME_TITLE->value) }}">
                                                <label for="organigrameTitleEn" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::ORGANIGRAME_TITLE->value) }} (EN)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text"
                                                       name="en[{{ ContentKey::CARTOGRAPHIE_TITLE->value }}]"
                                                       class="form-control"
                                                       id="cartographieTitleEn"
                                                       value="{{ old('en.'.ContentKey::CARTOGRAPHIE_TITLE->value, $data['en'][ContentKey::CARTOGRAPHIE_TITLE->value] ?? '') }}"
                                                       placeholder="{{ __('admin.pages.about.'.ContentKey::CARTOGRAPHIE_TITLE->value) }}">
                                                <label for="cartographieTitleEn" class="fw-semibold">
                                                    {{ __('admin.pages.about.'.ContentKey::CARTOGRAPHIE_TITLE->value) }} (EN)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::ABOUT_TEXT->value) }} (EN)
                                            </label>
                                            <textarea
                                                name="en[{{ ContentKey::ABOUT_TEXT->value }}]"
                                                id="about_text_en"
                                                class="form-control"
                                                rows="6">{{ old('en.'.ContentKey::ABOUT_TEXT->value, $data['en'][ContentKey::ABOUT_TEXT->value] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="fw-semibold mb-2">
                                                {{ __('admin.pages.about.'.ContentKey::MISSION_TEXT->value) }} (EN)
                                            </label>
                                            <textarea
                                                name="en[{{ ContentKey::MISSION_TEXT->value }}]"
                                                id="about_text_en"
                                                class="form-control"
                                                rows="6">{{ old('en.'.ContentKey::MISSION_TEXT->value, $data['en'][ContentKey::MISSION_TEXT->value] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload Section -->
                            <div class="row g-4">
                                @php
                                    $aboutImgCards = [
                                        ContentKey::ABOUT_HEADER_BG_IMG->value => __('admin.pages.about.'.ContentKey::ABOUT_HEADER_BG_IMG->value),
                                        ContentKey::SECTION_IMAGE->value        => __('admin.pages.about.'.ContentKey::SECTION_IMAGE->value),
                                        ContentKey::ORGANIGRAME->value          => __('admin.pages.about.'.ContentKey::ORGANIGRAME->value),
                                        ContentKey::CARTOGRAPHIE->value         => __('admin.pages.about.'.ContentKey::CARTOGRAPHIE->value),
                                    ];
                                @endphp
                                @foreach($aboutImgCards as $imgKey => $imgLabel)
                                @php $imgVal = $images[$imgKey] ?? ''; @endphp
                                <div class="col-md-6">
                                    <div class="card h-100 border">
                                        <div class="card-header bg-transparent border-bottom">
                                            <h6 class="fw-semibold mb-0">
                                                <i class="fa fa-image me-2 text-primary"></i>
                                                {{ $imgLabel }}
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="{{ $imgKey }}-existing" style="{{ empty($imgVal) ? 'display:none' : '' }}">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <p class="text-secondary-emphasis small mb-0">
                                                        <i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}
                                                    </p>
                                                    <button type="button" class="btn btn-sm btn-outline-warning about-img-change-btn" data-key="{{ $imgKey }}">
                                                        <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                    </button>
                                                </div>
                                                <img id="{{ $imgKey }}-preview-img"
                                                     src="{{ !empty($imgVal) ? Storage::disk('public')->url($imgVal) : '' }}"
                                                     alt="current" class="img-thumbnail shadow-sm w-100" style="max-height:120px; object-fit:cover;">
                                            </div>
                                            <div id="{{ $imgKey }}-dropzone-wrapper" style="{{ !empty($imgVal) ? 'display:none' : '' }}">
                                                <div id="{{ $imgKey }}-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                    <div class="dz-message needsclick">
                                                        <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                        <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                        <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                                    </div>
                                                </div>
                                                @if(!empty($imgVal))
                                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2 about-img-cancel-btn" data-key="{{ $imgKey }}">
                                                    <i class="fa fa-times me-1"></i>Cancel
                                                </button>
                                                @endif
                                            </div>
                                            <input type="hidden" id="{{ $imgKey }}-path"
                                                   name="{{ $imgKey }}"
                                                   value="{{ $imgVal }}">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer bg-light-subtle border-top p-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary px-4">
                                    <i class="fa fa-undo me-2"></i>
                                    {{ __('admin.common.cancel') }}
                                </button>
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fa fa-save me-2"></i>
                                    {{ __('admin.common.save') }}
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
    <script src="/build/js/plugins/tinymce/tinymce.min.js" ></script>
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        const uploadUrl = '{{ route('admin.pages.about-us.upload-image') }}';
        const csrfToken = "{{ csrf_token() }}";

        const init_dropzone = (img) => {
            const pathInput   = document.getElementById(`${img}-path`);
            const existingDiv = document.getElementById(`${img}-existing`);
            const wrapperDiv  = document.getElementById(`${img}-dropzone-wrapper`);
            const previewImg  = document.getElementById(`${img}-preview-img`);

            if (typeof Dropzone === 'undefined') return;

            const showDropzone = () => { existingDiv.style.display = 'none'; wrapperDiv.style.display = ''; };
            const showExisting = () => { wrapperDiv.style.display  = 'none'; existingDiv.style.display = ''; };

            const changeBtn = existingDiv ? existingDiv.querySelector('.about-img-change-btn') : null;
            const cancelBtn = wrapperDiv  ? wrapperDiv.querySelector('.about-img-cancel-btn')  : null;

            if (changeBtn) changeBtn.addEventListener('click', showDropzone);
            if (cancelBtn) cancelBtn.addEventListener('click', showExisting);

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

            dz.on('sending', (file, xhr, formData) => {
                formData.append('key', img);
            });

            dz.on('addedfile', () => {
                dz.files
                    .filter((f, i) => i < dz.files.length - 1)
                    .forEach((f) => dz.removeFile(f));
            });

            dz.on('success', (file, response) => {
                if (response.path) {
                    pathInput.value = response.path;
                    previewImg.src = response.url;
                    showExisting();
                }
            });

            dz.on('error', (file, message, xhr) => {
                console.error('Upload error for', img, ':', message, xhr ? xhr.responseText : '');
            });

            dz.on('removedfile', () => {
                if (dz.files.length === 0) {
                    pathInput.value = '';
                    existingDiv.style.display = 'none';
                    wrapperDiv.style.display = '';
                }
            });
        };

        @php
            $imageKeys = [ContentKey::ABOUT_HEADER_BG_IMG->value,ContentKey::SECTION_IMAGE->value,ContentKey::ORGANIGRAME->value,ContentKey::CARTOGRAPHIE->value]
        @endphp
        const imageKeys = @json($imageKeys);
        imageKeys.forEach((image) => {
            init_dropzone(image);
        })

        tinymce.init({
            selector: '#about_text_fr, #about_text_en, #why_us_text_fr, #why_us_text_en',
            plugins: 'lists link code',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link | code',
            menubar: false,
            height: 300,
            branding: false,
            language: 'fr_FR',
            paste_data_images: false,
            automatic_uploads: false,
            images_upload_handler: () => Promise.reject('Image uploads are disabled.'),
        });
    </script>
@endpush
