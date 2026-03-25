@php use App\Enums\CompanyInfoKey;use App\Enums\ContentKey;use App\Enums\Section; @endphp
@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush
@section('title', __('admin.section.title'))

@section('content')
    <div class="row">
        <div class="col-12">
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.sections.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h5 class="mb-0">{{ __('admin.section.title') }}</h5>
                                <p class="text-muted small mb-0">{{ __('admin.section.subtitle') }}</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    {{ __('admin.common.back_to_list') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i>
                                    {{ __('admin.common.save') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- Locale Tabs --}}
                        <ul class="nav nav-tabs mb-4" id="localeTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-fr" data-bs-toggle="tab" data-bs-target="#locale-fr" type="button" role="tab">
                                    {{ __('admin.common.locale.fr') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-en" data-bs-toggle="tab" data-bs-target="#locale-en" type="button" role="tab">
                                    {{ __('admin.common.locale.en') }}
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="localeTabsContent">
                            @foreach(['fr', 'en'] as $locale)
                                <div class="tab-pane fade {{ $locale === 'fr' ? 'show active' : '' }}" id="locale-{{ $locale }}" role="tabpanel">

                                    {{-- Hero --}}
                                    <div class="section-title mb-4">
                                        <h6 class="fw-bold text-primary">
                                            <i class="fa fa-home me-2"></i>
                                            {{ __('admin.section.'.Section::HERO->value) }}
                                        </h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="row g-3 mb-5">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::HERO_TITLE->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       name="{{ ContentKey::HERO_TITLE->value }}[{{ $locale }}]"
                                                       class="form-control @error(ContentKey::HERO_TITLE->value.'.'.$locale) is-invalid @enderror"
                                                       value="{{ old(ContentKey::HERO_TITLE->value.'.'.$locale, $contents->where('section',Section::HERO->value)->where('key',ContentKey::HERO_TITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::HERO_TITLE->value) }}"
                                                       required>
                                                @error(ContentKey::HERO_TITLE->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::HERO_SUBTITLE->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       name="{{ ContentKey::HERO_SUBTITLE->value }}[{{ $locale }}]"
                                                       class="form-control @error(ContentKey::HERO_SUBTITLE->value.'.'.$locale) is-invalid @enderror"
                                                       value="{{ old(ContentKey::HERO_SUBTITLE->value.'.'.$locale, $contents->where('section',Section::HERO->value)->where('key',ContentKey::HERO_SUBTITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::HERO_SUBTITLE->value) }}"
                                                       required>
                                                @error(ContentKey::HERO_SUBTITLE->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- About --}}
                                    <div class="section-title mb-4">
                                        <h6 class="fw-bold text-primary">
                                            <i class="fa fa-building me-2"></i>
                                            {{ __('admin.section.'.Section::ABOUT->value) }}
                                        </h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="row g-3">
                                        <div class=" col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::ABOUT_TITLE->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       name="{{ ContentKey::ABOUT_TITLE->value }}[{{ $locale }}]"
                                                       class="form-control @error(ContentKey::ABOUT_TITLE->value.'.'.$locale) is-invalid @enderror"
                                                       value="{{ old(ContentKey::ABOUT_TITLE->value.'.'.$locale, $contents->where('section',Section::ABOUT->value)->where('key',ContentKey::ABOUT_TITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::ABOUT_TITLE->value) }}"
                                                       required>
                                                @error(ContentKey::ABOUT_TITLE->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::ABOUT_TEXT->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea
                                                    name="{{ ContentKey::ABOUT_TEXT->value }}[{{ $locale }}]"
                                                    class="form-control @error(ContentKey::ABOUT_TEXT->value.'.'.$locale) is-invalid @enderror"
                                                    rows="2"
                                                    id="textarea-{{ContentKey::ABOUT_TEXT->value}}-{{ $locale }}"
                                                    placeholder="{{ __('admin.section.placeholders.'.ContentKey::ABOUT_TEXT->value) }}"
                                                >{!! old(ContentKey::ABOUT_TEXT->value.'.'.$locale, $contents->where('section',Section::ABOUT->value)->where('key',ContentKey::ABOUT_TEXT->value)->where('language',$locale)->first()?->value) !!}</textarea>
                                                @error(ContentKey::ABOUT_TEXT->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Domain --}}
                                    <div class="section-title mb-4 mt-5">
                                        <h6 class="fw-bold text-primary">
                                            <i class="fa fa-globe me-2"></i>
                                            {{ __('admin.section.'.Section::DOMAIN->value) }}
                                        </h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::DOMAIN_TITLE->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       name="{{ ContentKey::DOMAIN_TITLE->value }}[{{ $locale }}]"
                                                       class="form-control @error(ContentKey::DOMAIN_TITLE->value.'.'.$locale) is-invalid @enderror"
                                                       value="{{ old(ContentKey::DOMAIN_TITLE->value.'.'.$locale, $contents->where('section',Section::DOMAIN->value)->where('key',ContentKey::DOMAIN_TITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::DOMAIN_TITLE->value) }}"
                                                       required>
                                                @error(ContentKey::DOMAIN_TITLE->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::DOMAIN_TEXT->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea
                                                    name="{{ ContentKey::DOMAIN_TEXT->value }}[{{ $locale }}]"
                                                    class="form-control @error(ContentKey::DOMAIN_TEXT->value.'.'.$locale) is-invalid @enderror"
                                                    rows="2"
                                                    id="textarea-{{ContentKey::DOMAIN_TEXT->value}}-{{ $locale }}"
                                                    placeholder="{{ __('admin.section.placeholders.'.ContentKey::DOMAIN_TEXT->value) }}"
                                                >{!! old(ContentKey::DOMAIN_TEXT->value.'.'.$locale, $contents->where('section',Section::DOMAIN->value)->where('key',ContentKey::DOMAIN_TEXT->value)->where('language',$locale)->first()?->value) !!}</textarea>
                                                @error(ContentKey::DOMAIN_TEXT->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Projects --}}
                                    <div class="section-title mb-4 mt-5">
                                        <h6 class="fw-bold text-primary">
                                            <i class="fa fa-diagram-project me-2"></i>
                                            {{ __('admin.section.'.Section::PROJECTS->value) }}
                                        </h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::PROJECTS_SUBTITLE->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       name="{{ ContentKey::PROJECTS_SUBTITLE->value }}[{{ $locale }}]"
                                                       class="form-control @error(ContentKey::PROJECTS_SUBTITLE->value.'.'.$locale) is-invalid @enderror"
                                                       value="{{ old(ContentKey::PROJECTS_SUBTITLE->value.'.'.$locale, $contents->where('section',Section::PROJECTS->value)->where('key',ContentKey::PROJECTS_SUBTITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::PROJECTS_SUBTITLE->value) }}"
                                                       required>
                                                @error(ContentKey::PROJECTS_SUBTITLE->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::PROJECTS_TITLE->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       name="{{ ContentKey::PROJECTS_TITLE->value }}[{{ $locale }}]"
                                                       class="form-control @error(ContentKey::PROJECTS_TITLE->value.'.'.$locale) is-invalid @enderror"
                                                       value="{{ old(ContentKey::PROJECTS_TITLE->value.'.'.$locale, $contents->where('section',Section::PROJECTS->value)->where('key',ContentKey::PROJECTS_TITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::PROJECTS_TITLE->value) }}"
                                                       required>
                                                @error(ContentKey::PROJECTS_TITLE->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    {{ __('admin.section.contents.labels.'.ContentKey::PROJECTS_TEXT->value) }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea
                                                    name="{{ ContentKey::PROJECTS_TEXT->value }}[{{ $locale }}]"
                                                    class="form-control @error(ContentKey::PROJECTS_TEXT->value.'.'.$locale) is-invalid @enderror"
                                                    rows="2"
                                                    id="textarea-{{ContentKey::PROJECTS_TEXT->value}}-{{ $locale }}"
                                                    placeholder="{{ __('admin.section.placeholders.'.ContentKey::PROJECTS_TEXT->value) }}"
                                                >{!! old(ContentKey::PROJECTS_TEXT->value.'.'.$locale, $contents->where('section',Section::PROJECTS->value)->where('key',ContentKey::PROJECTS_TEXT->value)->where('language',$locale)->first()?->value) !!}</textarea>
                                                @error(ContentKey::PROJECTS_TEXT->value.'.'.$locale)
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Why Choose Us --}}
                                    <div class="section-title mb-4 mt-5">
                                        <h6 class="fw-bold text-primary">
                                            <i class="fa fa-star me-2"></i>
                                            {{ __('admin.section.'.Section::WHY_CHOOSE_US->value) }}
                                        </h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="row g-3 mb-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">{{ __('admin.section.contents.labels.'.ContentKey::WHY_SUBTITLE->value) }}</label>
                                                <input type="text"
                                                       name="{{ ContentKey::WHY_SUBTITLE->value }}[{{ $locale }}]"
                                                       class="form-control"
                                                       value="{{ old(ContentKey::WHY_SUBTITLE->value.'.'.$locale, $contents->where('section',Section::WHY_CHOOSE_US->value)->where('key',ContentKey::WHY_SUBTITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::WHY_SUBTITLE->value) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">{{ __('admin.section.contents.labels.'.ContentKey::WHY_TITLE->value) }}</label>
                                                <input type="text"
                                                       name="{{ ContentKey::WHY_TITLE->value }}[{{ $locale }}]"
                                                       class="form-control"
                                                       value="{{ old(ContentKey::WHY_TITLE->value.'.'.$locale, $contents->where('section',Section::WHY_CHOOSE_US->value)->where('key',ContentKey::WHY_TITLE->value)->where('language',$locale)->first()?->value) }}"
                                                       placeholder="{{ __('admin.section.placeholders.'.ContentKey::WHY_TITLE->value) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">{{ __('admin.section.contents.labels.'.ContentKey::WHY_TEXT->value) }}</label>
                                                <textarea name="{{ ContentKey::WHY_TEXT->value }}[{{ $locale }}]"
                                                          class="form-control" rows="2"
                                                          placeholder="{{ __('admin.section.placeholders.'.ContentKey::WHY_TEXT->value) }}"
                                                >{{ old(ContentKey::WHY_TEXT->value.'.'.$locale, $contents->where('section',Section::WHY_CHOOSE_US->value)->where('key',ContentKey::WHY_TEXT->value)->where('language',$locale)->first()?->value) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Why Features (dynamic) --}}
                                    @php
                                        $savedFeatures = json_decode(
                                            $contents->where('section', Section::WHY_CHOOSE_US->value)
                                                     ->where('key', ContentKey::WHY_FEATURES->value)
                                                     ->where('language', $locale)
                                                     ->first()?->value ?? '[]',
                                            true
                                        ) ?: [];
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="form-label fw-semibold mb-0">
                                            <i class="fa fa-list-ol me-1 text-primary"></i>{{ __('admin.section.contents.labels.why_features') }}
                                        </label>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-why-feature-btn" data-locale="{{ $locale }}">
                                            <i class="fa fa-plus me-1"></i>{{ __('admin.common.add') }}
                                        </button>
                                    </div>
                                    <div class="why-features-list row g-3 mb-4" data-locale="{{ $locale }}">
                                        @forelse($savedFeatures as $i => $feature)
                                        <div class="col-md-6 why-feature-item">
                                            <div class="card border h-100">
                                                <div class="card-header bg-transparent border-bottom py-2 d-flex align-items-center justify-content-between">
                                                    <span class="fw-semibold small feature-number"><i class="fa fa-list-ol me-1 text-primary"></i>{{ sprintf('%02d', $i + 1) }}</span>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-why-feature-btn"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="card-body py-2">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label small fw-semibold">{{ __('admin.section.contents.labels.why_feature_title') }}</label>
                                                        <input type="text"
                                                               name="why_features[{{ $locale }}][{{ $i }}][title]"
                                                               class="form-control form-control-sm"
                                                               value="{{ $feature['title'] ?? '' }}"
                                                               placeholder="{{ __('admin.section.placeholders.why_feature_title') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label small fw-semibold">{{ __('admin.section.contents.labels.why_feature_text') }}</label>
                                                        <textarea name="why_features[{{ $locale }}][{{ $i }}][text]"
                                                                  class="form-control form-control-sm" rows="2"
                                                                  placeholder="{{ __('admin.section.placeholders.why_feature_text') }}"
                                                        >{{ $feature['text'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="col-12 why-features-empty text-center text-secondary-emphasis small py-2">
                                            {{ __('admin.section.contents.labels.why_features_empty') }}
                                        </div>
                                        @endforelse
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        {{-- Hero Video --}}
                        <div class="section-title mb-4 mt-4">
                            <h6 class="fw-bold text-primary">
                                <i class="fa fa-film me-2"></i>
                                {{ __('admin.section.'.Section::HERO->value) }} - {{ __('admin.section.contents.labels.'.ContentKey::HERO_VIDEO->value) }}
                            </h6>
                            <hr class="mt-1">
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-body">
                                        {{-- Existing video preview (shown when video exists) --}}
                                        <div id="hero-video-existing" style="{{ empty($heroVideo) ? 'display:none' : '' }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="text-secondary-emphasis small mb-0"><i class="fa fa-check-circle text-success me-1"></i>@lang('admin.common.current')</p>
                                                <button type="button" class="btn btn-sm btn-outline-warning" id="hero-video-change-btn">
                                                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                </button>
                                            </div>
                                            <video id="hero-video-preview-player" controls class="rounded shadow-sm w-100" style="max-height:220px;"
                                                   src="{{ !empty($heroVideo) ? Storage::disk('public')->url($heroVideo) : '' }}">
                                            </video>
                                        </div>
                                        {{-- Dropzone (hidden when video exists, shown when no video or user clicks Change) --}}
                                        <div id="hero-video-dropzone-wrapper" style="{{ !empty($heroVideo) ? 'display:none' : '' }}">
                                            <div id="hero-video-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                <div class="dz-message needsclick">
                                                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload (MP4, WebM, OGG — max 100MB)</small>
                                                </div>
                                            </div>
                                            @if(!empty($heroVideo))
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="hero-video-cancel-btn">
                                                <i class="fa fa-times me-1"></i>Cancel
                                            </button>
                                            @endif
                                        </div>
                                        <input type="hidden" id="hero-video-path"
                                               name="{{ ContentKey::HERO_VIDEO->value }}"
                                               value="{{ $heroVideo ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- About Images --}}
                        <div class="section-title mb-4 mt-4">
                            <h6 class="fw-bold text-primary">
                                <i class="fa fa-images me-2"></i>
                                {{ __('admin.section.'.Section::ABOUT->value) }} - Images
                            </h6>
                            <hr class="mt-1">
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-header bg-transparent border-bottom">
                                        <h6 class="fw-semibold mb-0">
                                            <i class="fa fa-image me-2 text-primary"></i>
                                            {{ __('admin.section.contents.labels.'.ContentKey::ABOUT_IMAGE_1->value) }}
                                            <small class="text-muted fw-normal">(410x419)</small>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @php $img1 = $images[ContentKey::ABOUT_IMAGE_1->value] ?? ''; @endphp
                                        <div id="{{ContentKey::ABOUT_IMAGE_1->value}}-existing" style="{{ empty($img1) ? 'display:none' : '' }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="text-secondary-emphasis small mb-0"><i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}</p>
                                                <button type="button" class="btn btn-sm btn-outline-warning media-change-btn" data-key="{{ContentKey::ABOUT_IMAGE_1->value}}">
                                                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                </button>
                                            </div>
                                            <img id="{{ContentKey::ABOUT_IMAGE_1->value}}-preview-img"
                                                 src="{{ !empty($img1) ? Storage::disk('public')->url($img1) : '' }}"
                                                 alt="current" class="img-thumbnail shadow-sm w-100" style="max-height:160px; object-fit:cover;">
                                        </div>
                                        <div id="{{ContentKey::ABOUT_IMAGE_1->value}}-dropzone-wrapper" style="{{ !empty($img1) ? 'display:none' : '' }}">
                                            <div id="{{ContentKey::ABOUT_IMAGE_1->value}}-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                <div class="dz-message needsclick">
                                                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                                </div>
                                            </div>
                                            @if(!empty($img1))
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2 media-cancel-btn" data-key="{{ContentKey::ABOUT_IMAGE_1->value}}">
                                                <i class="fa fa-times me-1"></i>Cancel
                                            </button>
                                            @endif
                                        </div>
                                        <input type="hidden" id="{{ContentKey::ABOUT_IMAGE_1->value}}-path"
                                               name="{{ContentKey::ABOUT_IMAGE_1->value}}"
                                               value="{{ $img1 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card h-100 border">
                                    <div class="card-header bg-transparent border-bottom">
                                        <h6 class="fw-semibold mb-0">
                                            <i class="fa fa-image me-2 text-primary"></i>
                                            {{ __('admin.section.contents.labels.'.ContentKey::ABOUT_IMAGE_2->value) }}
                                            <small class="text-muted fw-normal">(193x185)</small>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @php $img2 = $images[ContentKey::ABOUT_IMAGE_2->value] ?? ''; @endphp
                                        <div id="{{ContentKey::ABOUT_IMAGE_2->value}}-existing" style="{{ empty($img2) ? 'display:none' : '' }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="text-secondary-emphasis small mb-0"><i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}</p>
                                                <button type="button" class="btn btn-sm btn-outline-warning media-change-btn" data-key="{{ContentKey::ABOUT_IMAGE_2->value}}">
                                                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                </button>
                                            </div>
                                            <img id="{{ContentKey::ABOUT_IMAGE_2->value}}-preview-img"
                                                 src="{{ !empty($img2) ? Storage::disk('public')->url($img2) : '' }}"
                                                 alt="current" class="img-thumbnail shadow-sm w-100" style="max-height:120px; object-fit:cover;">
                                        </div>
                                        <div id="{{ContentKey::ABOUT_IMAGE_2->value}}-dropzone-wrapper" style="{{ !empty($img2) ? 'display:none' : '' }}">
                                            <div id="{{ContentKey::ABOUT_IMAGE_2->value}}-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                <div class="dz-message needsclick">
                                                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                                </div>
                                            </div>
                                            @if(!empty($img2))
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2 media-cancel-btn" data-key="{{ContentKey::ABOUT_IMAGE_2->value}}">
                                                <i class="fa fa-times me-1"></i>Cancel
                                            </button>
                                            @endif
                                        </div>
                                        <input type="hidden" id="{{ContentKey::ABOUT_IMAGE_2->value}}-path"
                                               name="{{ContentKey::ABOUT_IMAGE_2->value}}"
                                               value="{{ $img2 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card h-100 border">
                                    <div class="card-header bg-transparent border-bottom">
                                        <h6 class="fw-semibold mb-0">
                                            <i class="fa fa-image me-2 text-primary"></i>
                                            {{ __('admin.section.contents.labels.'.ContentKey::ABOUT_IMAGE_3->value) }}
                                            <small class="text-muted fw-normal">(193x185)</small>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @php $img3 = $images[ContentKey::ABOUT_IMAGE_3->value] ?? ''; @endphp
                                        <div id="{{ContentKey::ABOUT_IMAGE_3->value}}-existing" style="{{ empty($img3) ? 'display:none' : '' }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="text-secondary-emphasis small mb-0"><i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}</p>
                                                <button type="button" class="btn btn-sm btn-outline-warning media-change-btn" data-key="{{ContentKey::ABOUT_IMAGE_3->value}}">
                                                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                </button>
                                            </div>
                                            <img id="{{ContentKey::ABOUT_IMAGE_3->value}}-preview-img"
                                                 src="{{ !empty($img3) ? Storage::disk('public')->url($img3) : '' }}"
                                                 alt="current" class="img-thumbnail shadow-sm w-100" style="max-height:120px; object-fit:cover;">
                                        </div>
                                        <div id="{{ContentKey::ABOUT_IMAGE_3->value}}-dropzone-wrapper" style="{{ !empty($img3) ? 'display:none' : '' }}">
                                            <div id="{{ContentKey::ABOUT_IMAGE_3->value}}-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                <div class="dz-message needsclick">
                                                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                                </div>
                                            </div>
                                            @if(!empty($img3))
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2 media-cancel-btn" data-key="{{ContentKey::ABOUT_IMAGE_3->value}}">
                                                <i class="fa fa-times me-1"></i>Cancel
                                            </button>
                                            @endif
                                        </div>
                                        <input type="hidden" id="{{ContentKey::ABOUT_IMAGE_3->value}}-path"
                                               name="{{ContentKey::ABOUT_IMAGE_3->value}}"
                                               value="{{ $img3 }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Why Choose Us Image --}}
                        <div class="section-title mb-4 mt-4">
                            <h6 class="fw-bold text-primary">
                                <i class="fa fa-star me-2"></i>
                                {{ __('admin.section.contents.labels.'.ContentKey::WHY_IMAGE->value) }}
                            </h6>
                            <hr class="mt-1">
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-header bg-transparent border-bottom">
                                        <h6 class="fw-semibold mb-0">
                                            <i class="fa fa-image me-2 text-primary"></i>
                                            {{ __('admin.section.contents.labels.'.ContentKey::WHY_IMAGE->value) }}
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="{{ContentKey::WHY_IMAGE->value}}-existing" style="{{ empty($whyImage) ? 'display:none' : '' }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="text-secondary-emphasis small mb-0"><i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}</p>
                                                <button type="button" class="btn btn-sm btn-outline-warning media-change-btn" data-key="{{ContentKey::WHY_IMAGE->value}}">
                                                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                </button>
                                            </div>
                                            <img id="{{ContentKey::WHY_IMAGE->value}}-preview-img"
                                                 src="{{ !empty($whyImage) ? Storage::disk('public')->url($whyImage) : '' }}"
                                                 alt="current" class="img-thumbnail shadow-sm w-100" style="max-height:160px; object-fit:cover;">
                                        </div>
                                        <div id="{{ContentKey::WHY_IMAGE->value}}-dropzone-wrapper" style="{{ !empty($whyImage) ? 'display:none' : '' }}">
                                            <div id="{{ContentKey::WHY_IMAGE->value}}-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                <div class="dz-message needsclick">
                                                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                                </div>
                                            </div>
                                            @if(!empty($whyImage))
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2 media-cancel-btn" data-key="{{ContentKey::WHY_IMAGE->value}}">
                                                <i class="fa fa-times me-1"></i>Cancel
                                            </button>
                                            @endif
                                        </div>
                                        <input type="hidden" id="{{ContentKey::WHY_IMAGE->value}}-path"
                                               name="{{ContentKey::WHY_IMAGE->value}}"
                                               value="{{ $whyImage ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">
                                <i class="fa fa-undo me-1"></i>
                                {{ __('admin.common.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                {{ __('admin.common.save') }}
                            </button>
                        </div>
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
        tinymce.init({
            selector: '#textarea-{{ContentKey::ABOUT_TEXT->value}}-en, #textarea-{{ContentKey::ABOUT_TEXT->value}}-fr, #textarea-{{ContentKey::DOMAIN_TEXT->value}}-en, #textarea-{{ContentKey::DOMAIN_TEXT->value}}-fr, #textarea-{{ContentKey::PROJECTS_TEXT->value}}-en, #textarea-{{ContentKey::PROJECTS_TEXT->value}}-fr',
            menubar: false,
            height: 200,
            branding: false,
            toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            plugins: [
                "advlist", "anchor", "autolink", "charmap", "code", "fullscreen",
                "help", "insertdatetime", "link", "lists",
                "preview", "searchreplace", "table", "visualblocks",
            ],
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        const uploadUrl = '{{ route('admin.sections.upload-image') }}';
        const csrfToken = "{{ csrf_token() }}";

        const init_dropzone = (img) => {
            const pathInput = document.getElementById(`${img}-path`);
            const existingDiv = document.getElementById(`${img}-existing`);
            const dropzoneWrapper = document.getElementById(`${img}-dropzone-wrapper`);
            const previewImg = document.getElementById(`${img}-preview-img`);

            if (typeof Dropzone === 'undefined') return;

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
                    // Show existing preview, hide dropzone
                    existingDiv.style.display = '';
                    dropzoneWrapper.style.display = 'none';
                    dz.removeAllFiles();
                }
            });

            dz.on('error', (file, message, xhr) => {
                console.error('Upload error for', img, ':', message, xhr ? xhr.responseText : '');
            });
        };

        @php
            $aboutImageKeys = [ContentKey::ABOUT_IMAGE_1->value, ContentKey::ABOUT_IMAGE_2->value, ContentKey::ABOUT_IMAGE_3->value, ContentKey::WHY_IMAGE->value];
        @endphp
        const aboutImageKeys = @json($aboutImageKeys);
        aboutImageKeys.forEach((image) => {
            init_dropzone(image);
        });

        // Change / Cancel buttons for images
        document.querySelectorAll('.media-change-btn').forEach(btn => {
            const key = btn.dataset.key;
            btn.addEventListener('click', () => {
                document.getElementById(`${key}-existing`).style.display = 'none';
                document.getElementById(`${key}-dropzone-wrapper`).style.display = '';
            });
        });
        document.querySelectorAll('.media-cancel-btn').forEach(btn => {
            const key = btn.dataset.key;
            btn.addEventListener('click', () => {
                document.getElementById(`${key}-dropzone-wrapper`).style.display = 'none';
                document.getElementById(`${key}-existing`).style.display = '';
            });
        });

        // Hero Video Dropzone
        const videoUploadUrl = '{{ route('admin.sections.upload-video') }}';
        const videoDz = new Dropzone('#hero-video-dropzone', {
            url: videoUploadUrl,
            autoProcessQueue: true,
            uploadMultiple: false,
            maxFiles: 1,
            paramName: 'video',
            acceptedFiles: 'video/mp4,video/webm,video/ogg',
            addRemoveLinks: true,
            maxFilesize: 100,
            headers: { 'X-CSRF-TOKEN': csrfToken },
        });

        videoDz.on('addedfile', () => {
            videoDz.files
                .filter((f, i) => i < videoDz.files.length - 1)
                .forEach((f) => videoDz.removeFile(f));
        });

        videoDz.on('success', (file, response) => {
            if (response.path) {
                document.getElementById('hero-video-path').value = response.path;
                const player = document.getElementById('hero-video-preview-player');
                player.src = response.url;
                // Show existing preview, hide dropzone
                document.getElementById('hero-video-existing').style.display = '';
                document.getElementById('hero-video-dropzone-wrapper').style.display = 'none';
                videoDz.removeAllFiles();
            }
        });

        videoDz.on('error', (file, message, xhr) => {
            console.error('Video upload error:', message, xhr ? xhr.responseText : '');
        });

        // Hero video Change / Cancel buttons
        const heroChangeBtn = document.getElementById('hero-video-change-btn');
        const heroCancelBtn = document.getElementById('hero-video-cancel-btn');
        if (heroChangeBtn) {
            heroChangeBtn.addEventListener('click', () => {
                document.getElementById('hero-video-existing').style.display = 'none';
                document.getElementById('hero-video-dropzone-wrapper').style.display = '';
            });
        }
        if (heroCancelBtn) {
            heroCancelBtn.addEventListener('click', () => {
                document.getElementById('hero-video-dropzone-wrapper').style.display = 'none';
                document.getElementById('hero-video-existing').style.display = '';
            });
        }

        // Dynamic Why Features
        function featureCardHtml(locale, index) {
            return `<div class="col-md-6 why-feature-item">
                <div class="card border h-100">
                    <div class="card-header bg-transparent border-bottom py-2 d-flex align-items-center justify-content-between">
                        <span class="fw-semibold small feature-number"><i class="fa fa-list-ol me-1 text-primary"></i>${String(index + 1).padStart(2, '0')}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-why-feature-btn"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="card-body py-2">
                        <div class="form-group mb-2">
                            <label class="form-label small fw-semibold">{{ __('admin.section.contents.labels.why_feature_title') }}</label>
                            <input type="text" name="why_features[${locale}][${index}][title]" class="form-control form-control-sm" placeholder="{{ __('admin.section.placeholders.why_feature_title') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label small fw-semibold">{{ __('admin.section.contents.labels.why_feature_text') }}</label>
                            <textarea name="why_features[${locale}][${index}][text]" class="form-control form-control-sm" rows="2" placeholder="{{ __('admin.section.placeholders.why_feature_text') }}"></textarea>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        function renumberFeatures(list) {
            list.querySelectorAll('.why-feature-item').forEach((item, idx) => {
                item.querySelector('.feature-number').innerHTML = `<i class="fa fa-list-ol me-1 text-primary"></i>${String(idx + 1).padStart(2, '0')}`;
                const locale = list.dataset.locale;
                item.querySelectorAll('input, textarea').forEach(el => {
                    el.name = el.name.replace(/why_features\[[^\]]+\]\[\d+\]/, `why_features[${locale}][${idx}]`);
                });
            });
            const empty = list.querySelector('.why-features-empty');
            if (empty) empty.style.display = list.querySelectorAll('.why-feature-item').length ? 'none' : '';
        }

        document.querySelectorAll('.add-why-feature-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const locale = btn.dataset.locale;
                const list = document.querySelector(`.why-features-list[data-locale="${locale}"]`);
                const count = list.querySelectorAll('.why-feature-item').length;
                const empty = list.querySelector('.why-features-empty');
                if (empty) empty.style.display = 'none';
                list.insertAdjacentHTML('beforeend', featureCardHtml(locale, count));
                list.querySelector('.why-feature-item:last-child .remove-why-feature-btn').addEventListener('click', function() {
                    this.closest('.why-feature-item').remove();
                    renumberFeatures(list);
                });
            });
        });

        document.querySelectorAll('.remove-why-feature-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const item = this.closest('.why-feature-item');
                const list = item.closest('.why-features-list');
                item.remove();
                renumberFeatures(list);
            });
        });
    </script>
@endpush
