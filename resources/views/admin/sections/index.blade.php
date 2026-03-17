@php use App\Enums\CompanyInfoKey;use App\Enums\ContentKey;use App\Enums\Section; @endphp
@extends('admin.layouts.master')

@push('css')

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

                            </div>
                            @endforeach
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
    <script>
        tinymce.init({
            selector: '#textarea-{{ContentKey::ABOUT_TEXT->value}}-en, #textarea-{{ContentKey::ABOUT_TEXT->value}}-fr',
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
@endpush
