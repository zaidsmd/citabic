@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
    <style>
        .media-preview {
            object-fit: cover;
        }
        .media-preview-tall {
            max-height: 160px;
        }
        .media-preview-compact {
            max-height: 120px;
        }
        .media-preview-standard {
            max-height: 160px;
        }
        .hero-video-preview {
            max-height: 220px;
        }
    </style>
@endpush
@section('title', __('admin.section.title'))

@section('content')
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-12">
                <x-admin.status-messages/>

                <form action="{{ route('admin.sections.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <x-admin.page-header
                        :title="__('admin.pages.home.title')"
                        :subtitle="__('admin.pages.home.subtitle')"
                        :submit-button="1"
                        :back-url="route('admin.dashboard')"/>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <x-admin.language-tabs id-prefix="home" />
                            </div>

                            <div class="tab-content" id="homeLangTabsContent">
                                @foreach($locales as $locale)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                         id="home-{{ $locale }}-content"
                                         role="tabpanel"
                                         aria-labelledby="home-{{ $locale }}-tab">
                                        <div class="d-grid gap-4">
                                            @foreach($contentSections as $section)
                                                <div class="rounded-3 border p-3 p-lg-4">
                                                    <x-admin.section-title :title="$section['title']" :icon="$section['icon']" class="mb-3"/>

                                                    <div class="row g-3 mb-2">
                                                        @foreach($section['fields'][$locale] ?? [] as $field)
                                                            <div class="{{ $field['columnClass'] }}">
                                                                @if($field['component'] === 'textarea')
                                                                    <x-admin.textarea
                                                                        :name="$field['name']"
                                                                        :id="$field['id']"
                                                                        :label="$field['label']"
                                                                        :value="$field['value']"
                                                                        :required="$field['required']"
                                                                        :rows="$field['rows']"
                                                                        :placeholder="$field['placeholder']"
                                                                        :error-key="$field['errorKey']"
                                                                        :locale="$locale"/>
                                                                @else
                                                                    <x-admin.text-input
                                                                        :name="$field['name']"
                                                                        :label="$field['label']"
                                                                        :value="$field['value']"
                                                                        :required="$field['required']"
                                                                        :placeholder="$field['placeholder']"
                                                                        :error-key="$field['errorKey']"
                                                                        :locale="$locale"/>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    @if($section['hasWhyFeatures'])
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <label class="form-label fw-semibold mb-0">
                                                                <i class="fa fa-list-ol me-1 text-primary"></i>{{ __('admin.section.contents.labels.why_features') }}
                                                            </label>
                                                            <button type="button" class="btn btn-sm btn-outline-primary add-why-feature-btn" data-locale="{{ $locale }}">
                                                                <i class="fa fa-plus me-1"></i>{{ __('admin.common.add') }}
                                                            </button>
                                                        </div>
                                                        <div class="why-features-list row g-3 mb-4" data-locale="{{ $locale }}">
                                                            @forelse(($savedWhyFeatures[$locale] ?? []) as $i => $feature)
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
                                                                                          class="form-control form-control-sm"
                                                                                          rows="2"
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
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        <x-admin.section-title
                            class="mt-4"
                            icon="fa fa-film"
                            :title="__('admin.section.hero') . ' - ' . __('admin.section.contents.labels.hero_video')"/>
                        <div class="row g-4 mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-body">
                                        <div id="hero-video-existing" class="{{ blank($heroVideo['path'] ?? null) ? 'd-none' : '' }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="text-secondary-emphasis small mb-0"><i class="fa fa-check-circle text-success me-1"></i>@lang('admin.common.current')</p>
                                                <button type="button" class="btn btn-sm btn-outline-warning" id="hero-video-change-btn">
                                                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                                                </button>
                                            </div>
                                            <video id="hero-video-preview-player" controls class="rounded shadow-sm w-100 hero-video-preview"
                                                   src="{{ $heroVideo['url'] ?? '' }}">
                                            </video>
                                        </div>
                                        <div id="hero-video-dropzone-wrapper" class="{{ filled($heroVideo['path'] ?? null) ? 'd-none' : '' }}">
                                            <div id="hero-video-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                                <div class="dz-message needsclick">
                                                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload (MP4, WebM, OGG - max 100MB)</small>
                                                </div>
                                            </div>
                                            @if(filled($heroVideo['path'] ?? null))
                                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="hero-video-cancel-btn">
                                                    <i class="fa fa-times me-1"></i>{{ __('admin.common.cancel') }}
                                                </button>
                                            @endif
                                        </div>
                                        <input type="hidden" id="hero-video-path" name="{{ $heroVideoField }}" value="{{ $heroVideo['path'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach($mediaSections as $mediaSection)
                            <x-admin.section-title
                                class="mt-4"
                                :icon="$mediaSection['icon']"
                                :title="$mediaSection['title']"/>
                            <div class="row g-4 mb-4">
                                @foreach($mediaSection['cards'] as $card)
                                    <div class="{{ $card['columnClass'] }}">
                                        @include('components.admin.media-upload-card', [
                                            'contentKey' => $card['contentKey'],
                                            'label' => $card['label'],
                                            'size' => $card['size'] ?? null,
                                            'path' => $card['path'] ?? null,
                                            'url' => $card['url'] ?? null,
                                            'maxHeightClass' => $card['maxHeightClass'] ?? 'media-preview-standard',
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                    <x-admin.form-actions
                        :show-reset="true"
                        :save-label="__('admin.common.save')"
                        :reset-label="__('admin.common.reset')"/>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/build/js/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('/build/js/plugins/dropzone-amd-module.min.js')}}"></script>
    <script id="section-content-config" type="application/json">
        @json($sectionContentConfig)
    </script>
    <script type="module" src="/build/js/pages/section-content-index.js"></script>
@endpush
