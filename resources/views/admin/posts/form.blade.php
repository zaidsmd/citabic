@extends('admin.layouts.master')

@php
    use App\Enums\PostStatus;

    $isEdit = isset($post) && $post->exists;
    $postTranslations = is_array($post->translations ?? null) ? $post->translations : [];
    $englishTranslations = is_array($postTranslations['en'] ?? null) ? $postTranslations['en'] : [];
    $arabicTranslations = is_array($postTranslations['ar'] ?? null) ? $postTranslations['ar'] : [];
    $featuredImageValue = old('featured_image', $post->featured_image ?? '');
    $blocksValue = old('blocks', json_encode($post->blocks ?? []));
    $blocksJson = is_string($blocksValue) ? $blocksValue : json_encode($blocksValue);
@endphp

@section('title', $isEdit ? __('admin.posts.edit_title') : __('admin.posts.create_title'))

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
    <style>
        /* Block Styles */
        .block-item {
            border: 2px dashed #e2e5ec;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            position: relative;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fff;
        }

        .block-item:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 3px rgba(70, 128, 255, 0.1);
        }

        .block-item .block-label {
            position: absolute;
            top: -11px;
            left: 16px;
            background: var(--bs-primary);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .block-item .block-label.type-hero { background: #343a40; }
        .block-item .block-label.type-heading { background: #6f42c1; }
        .block-item .block-label.type-subheading { background: #e83e8c; }
        .block-item .block-label.type-paragraph { background: #20c997; }
        .block-item .block-label.type-quote { background: #fd7e14; }
        .block-item .block-label.type-image { background: #0d6efd; }
        .block-item .block-label.type-gallery { background: #6610f2; }
        .block-item .block-label.type-list { background: #dc3545; }
        .block-item .block-label.type-video { background: #17a2b8; }

        .block-toolbar {
            display: flex;
            gap: 4px;
            position: absolute;
            top: -11px;
            right: 16px;
        }

        .block-toolbar .btn {
            padding: 1px 8px;
            font-size: 11px;
            line-height: 1.5;
        }

        .block-content {
            margin-top: 8px;
        }

        .add-block-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            margin-bottom: 16px;
            justify-content: center;
        }

        .add-block-bar .btn {
            font-size: 12px;
            padding: 4px 12px;
        }

        .block-dropzone {
            border: 2px dashed #dee2e6;
            border-radius: 6px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.2s;
            background: #fafbfc;
        }

        .block-dropzone:hover {
            border-color: var(--bs-primary);
        }

        .block-dropzone .dz-message {
            margin: 0;
        }

        .block-img-preview {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }

        .block-img-preview img {
            max-height: 120px;
            border-radius: 6px;
            object-fit: cover;
            width: 100%;
        }

        .block-img-preview .btn-change-img {
            position: absolute;
            top: 4px;
            right: 4px;
            font-size: 10px;
            padding: 2px 8px;
        }


        /* Gallery Styles */
        .gallery-images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 12px;
            margin-top: 8px;
        }

        .gallery-image-item {
            position: relative;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 8px;
            background: #f8f9fa;
        }

        .btn-remove-gallery-img {
            margin-top: 8px;
            font-size: 11px;
        }

        /* Preview Panel */
        .preview-panel {
            background: #f8f9fa;
            border: 1px solid var(--bs-gray-300);
            border-radius: 8px;
            padding: 0;
            font-size: 13px;
            position: sticky;
            top: 80px;
            overflow: hidden;
        }

        .preview-header {
            background: var(--bs-gray-100);
            color: #999;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-iframe {
            width: 100%;
            border: none;
            min-height: 400px;
            max-height: 70vh;
            display: block;
        }

        .preview-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            background: #fff;
            border-radius: 0;
            margin: 0;
            max-height: none;
        }

        .preview-fullscreen .preview-iframe {
            max-height: none;
            height: calc(100vh - 40px) !important;
            min-height: calc(100vh - 40px);
        }

        /* Language Tabs */
        .lang-tabs .nav-link {
            font-size: 13px;
            padding: 6px 16px;
        }

        .lang-tabs .nav-link.active {
            font-weight: 600;
        }

        /* Drag Handle */
        .drag-handle {
            cursor: grab;
            color: #adb5bd;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .block-item.dragging {
            opacity: 0.5;
        }

        /* Info Badge */
        .info-badge {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(0,0,0,0.6);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            pointer-events: none;
        }

        /* Rich Text Editor */
        .richtext-editor {
            min-height: 200px;
        }

        /* Character Counter */
        .char-counter {
            font-size: 11px;
            color: #6c757d;
            margin-top: 4px;
        }

        /* Loading State */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            z-index: 10;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <form action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" id="postForm">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <input type="hidden" name="blocks" id="blocks-json" value="{{ $blocksJson }}">

        <div class="card mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-light-secondary">
                        <i class="ti ti-arrow-left me-1"></i>{{ __('admin.common.back_to_list') }}
                    </a>
                    <h5 class="mb-0 ms-2">{{ $isEdit ? __('admin.posts.edit_title') : __('admin.posts.create_title') }}</h5>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>{{ __('admin.common.save') }}
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-tabs lang-tabs mb-3" id="langTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab">
                         {{ __('admin.common.language.fr') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab">
                           {{ __('admin.common.language.en') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar-content" type="button" role="tab">
                           {{ __('admin.common.language.ar') }}
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="langTabsContent">
                    <div class="tab-pane fade show active" id="fr-content" role="tabpanel">
                        <div id="blocks-container-fr"></div>

                        <div class="add-block-bar">
                            <span class="text-muted me-2 align-self-center" style="font-size:12px;">
                                <i class="ti ti-plus me-1"></i>{{ __('admin.posts.add_block') }}:
                            </span>
                            <button type="button" id="add-hero-block-btn" class="btn btn-sm btn-outline-dark" onclick="window.postBuilder.addBlock('hero')">
                                <i class="ti ti-panorama-horizontal me-1"></i>{{ __('admin.posts.block_types.hero') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="window.postBuilder.addBlock('heading')">
                                <i class="ti ti-heading me-1"></i>{{ __('admin.posts.block_types.heading') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="window.postBuilder.addBlock('subheading')">
                                <i class="ti ti-h-4 me-1"></i>{{ __('admin.posts.block_types.subheading') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="window.postBuilder.addBlock('paragraph')">
                                <i class="ti ti-align-left me-1"></i>{{ __('admin.posts.block_types.paragraph') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="window.postBuilder.addBlock('quote')">
                                <i class="ti ti-quote me-1"></i>{{ __('admin.posts.block_types.quote') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="window.postBuilder.addBlock('image')">
                                <i class="ti ti-photo me-1"></i>{{ __('admin.posts.block_types.image') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="window.postBuilder.addBlock('doubleImage')">
                                <i class="ti ti-photo-scan me-1"></i>{{ __('admin.posts.block_types.double_image') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.postBuilder.addBlock('gallery')">
                                <i class="ti ti-layout-grid-add me-1"></i>{{ __('admin.posts.block_types.gallery') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="window.postBuilder.addBlock('list')">
                                <i class="ti ti-list-check me-1"></i>{{ __('admin.posts.block_types.list') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-dark" onclick="window.postBuilder.addBlock('video')">
                                <i class="ti ti-video me-1"></i>{{ __('admin.posts.block_types.video') }}
                            </button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="en-content" role="tabpanel">
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <i class="ti ti-info-circle me-1"></i>
                            {{ __('admin.posts.en_translation_info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-sm btn-light-primary" id="translate-fr-en-btn">
                                <i class="ti ti-language me-1"></i>{{ __('admin.posts.translate_fr_to_en') }}
                            </button>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.posts.title') }} (EN)</label>
                                    <input type="text"
                                           name="en[title]"
                                           class="form-control"
                                           value="{{ old('en.title', $englishTranslations['title'] ?? '') }}"
                                           placeholder="{{ __('admin.posts.title_placeholder') }}">
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">{{ __('admin.posts.excerpt') }} (EN)</label>
                                    <textarea name="en[excerpt]"
                                              class="form-control"
                                              rows="3"
                                              placeholder="{{ __('admin.posts.excerpt_placeholder') }}">{{ old('en.excerpt', $englishTranslations['excerpt'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="blocks-container-en"></div>
                    </div>

                    <div class="tab-pane fade" id="ar-content" role="tabpanel">
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <i class="ti ti-info-circle me-1"></i>
                            {{ __('admin.posts.ar_translation_info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="card mb-3" dir="rtl">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.posts.title') }} (AR)</label>
                                    <input type="text"
                                           name="ar[title]"
                                           class="form-control"
                                           value="{{ old('ar.title', $arabicTranslations['title'] ?? '') }}"
                                           placeholder="{{ __('admin.posts.title_placeholder') }}"
                                           dir="rtl">
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">{{ __('admin.posts.excerpt') }} (AR)</label>
                                    <textarea name="ar[excerpt]"
                                              class="form-control"
                                              rows="3"
                                              placeholder="{{ __('admin.posts.excerpt_placeholder') }}"
                                              dir="rtl">{{ old('ar.excerpt', $arabicTranslations['excerpt'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="blocks-container-ar" dir="rtl"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Post Settings -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-settings me-2"></i>{{ __('admin.posts.post_settings') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.title') }} (FR) <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="input-title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $post->title ?? '') }}" required placeholder="{{ __('admin.posts.title_placeholder') }}">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="char-counter" id="title-counter">0/60 characters</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.excerpt') }} (FR)</label>
                            <textarea name="excerpt" id="input-excerpt" class="form-control" rows="3"
                                      placeholder="{{ __('admin.posts.excerpt_placeholder') }}">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                            <div class="char-counter" id="excerpt-counter">0/160 characters</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.status') }}</label>
                            <select name="status" class="form-select">
                                @php
                                    $selectedStatus = old('status', ($post->status instanceof PostStatus ? $post->status->value : $post->status) ?? PostStatus::Draft->value);
                                @endphp
                                @foreach(PostStatus::cases() as $status)
                                    <option value="{{ $status->value }}" {{ $selectedStatus === $status->value ? 'selected' : '' }}>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured"
                                {{ old('featured', $post->featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                {{ __('admin.posts.featured_post') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Categories & Tags -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-tags me-2"></i>{{ __('admin.posts.taxonomy') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.categories') }}</label>
                            <select id="post-categories" name="categories[]" class="form-select" multiple>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.tags') }}</label>
                            <select id="post-tags" name="tags[]" class="form-select" multiple>
                                @foreach($tags ?? [] as $tag)
                                    <option value="{{ $tag->id }}"
                                        {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-photo me-2"></i>{{ __('admin.posts.featured_image') }}</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="featured_image" id="featured-image-input" value="{{ $featuredImageValue }}">
                        <div id="featured-image-dropzone-wrapper" style="{{ !empty($featuredImageValue) ? 'display:none' : '' }}">
                            <div id="featured-image-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                <div class="dz-message needsclick">
                                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                </div>
                            </div>
                            @if(!empty($featuredImageValue))
                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2 media-cancel-btn" id="featured-image-cancel-btn">
                                    <i class="fa fa-times me-1"></i>Cancel
                                </button>
                            @endif
                        </div>
                        <div id="featured-image-preview" class="mt-2"></div>
                        <small class="text-muted">{{ __('admin.posts.featured_image_help') }}</small>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-chart-line me-2"></i>{{ __('admin.posts.seo_settings') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.meta_title') }}</label>
                            <input type="text" name="meta_title" class="form-control"
                                   value="{{ old('meta_title', $post->meta_title ?? '') }}" maxlength="255">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.meta_description') }}</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.posts.meta_keywords') }}</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                   value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}"
                                   placeholder="keyword 1, keyword 2, keyword 3">
                        </div>

                        <div class="mb-0">
                            <label class="form-label">{{ __('admin.posts.focus_keyword') }}</label>
                            <input type="text" name="focus_keyword" class="form-control"
                                   value="{{ old('focus_keyword', $post->focus_keyword ?? '') }}"
                                   placeholder="{{ __('admin.posts.focus_keyword_placeholder') }}">
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <i class="ti ti-info-circle me-1"></i>
                            Leave any field empty to let the backend auto-generate it.
                        </div>
                    </div>
                </div>

                @if($isEdit && !empty($post))
                    <div class="card mb-3 border-0 shadow-sm" style="background: #fdfdfe; border: 1px solid rgba(70, 128, 255, 0.2) !important;">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                            <h6 class="mb-0 fw-bold text-primary">
                                <i class="ti ti-share me-1"></i>{{ __("admin.posts.share_social") }}
                            </h6>
                            <span class="badge bg-light-primary text-primary" style="font-size: 10px;">{{ __("admin.posts.publish_action") }}</span>
                        </div>
                        <div class="card-body p-3">
                            @php
                                $postShareUrl = route("blog.show", $post->slug);
                                $postFbUrl = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($postShareUrl);
                                $postLiUrl = "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($postShareUrl);
                                $postShareCaption = $post instanceof \App\Models\Post
                                    ? $post->getShareCaption()
                                    : "Découvrez notre nouvel article : " . ($post["title"] ?? "") . "\n\n👉 " . $postShareUrl . "\n\n#CITABIC #Blog #Architecture #GénieCivil #Construction #Maroc";
                            @endphp

                            <p class="text-muted small mb-2" style="font-size: 12px;">
                                {{ __("admin.posts.share_card_description") }}
                            </p>

                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0 small text-secondary fw-semibold">{{ __("admin.posts.share_caption") }}</label>
                                    <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none" id="btnCopyEditCaption" style="font-size: 11px;">
                                        <i class="ti ti-copy me-1"></i><span id="copyEditCaptionText">{{ __("admin.posts.copy_caption") }}</span>
                                    </button>
                                </div>
                                <textarea class="form-control form-control-sm bg-light" id="editPageShareCaption" rows="3" readonly style="font-size: 12px;">{{ $postShareCaption }}</textarea>
                            </div>

                            <div class="d-grid gap-2 pt-1">
                                <a href="{{ $postFbUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-1 d-flex align-items-center justify-content-center btn-social-form-popup" data-platform="facebook" style="background-color: #1877F2; border-color: #1877F2;">
                                    <i class="fab fa-facebook-f me-2"></i> {{ __("admin.posts.share_facebook") }}
                                </a>
                                <a href="{{ $postLiUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-1 d-flex align-items-center justify-content-center btn-social-form-popup" data-platform="linkedin" style="background-color: #0A66C2; border-color: #0A66C2;">
                                    <i class="fab fa-linkedin-in me-2"></i> {{ __("admin.posts.share_linkedin") }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Live Preview -->
                <div class="preview-panel mb-3" id="preview-panel">
                    <div class="preview-header">
                        <span><i class="ti ti-eye me-1"></i>{{ __('admin.posts.live_preview') }}</span>
                        <button type="button" class="btn btn-sm btn-outline-light" id="btn-fullscreen-preview"
                                style="padding:1px 8px;font-size:11px;border-color:#555;color:#ccc;"
                                title="{{ __('admin.posts.toggle_fullscreen') }}">
                            <i class="ti ti-arrows-maximize"></i>
                        </button>
                    </div>
                    <iframe id="preview-iframe" class="preview-iframe" title="{{ __('admin.posts.preview_title') }}"></iframe>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="ti ti-device-floppy me-2"></i>{{ __('admin.common.save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script src="/build/js/plugins/choices.min.js"></script>
    <script src="/build/js/plugins/tinymce/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        if (window.Dropzone) {
            window.Dropzone.autoDiscover = false;
        }
        window.postFormConfig = {
            uploadUrl: '{{ route('admin.posts.upload-image') }}',
            translateUrl: '{{ route('admin.posts.translate-fr-en') }}',
            csrfToken: '{{ csrf_token() }}',
            isEdit: {{ $isEdit ? 'true' : 'false' }},
            blocksData: {!! $blocksJson !!},
            assets: {
                bootstrapCss: '{{ asset('guest/assets/css/bootstrap.min.css') }}',
                fontawesomeCss: '{{ asset('guest/assets/css/fontawesome.min.css') }}',
                guestCss: '{{ asset('build/css/guest.css') }}',
            },
            translations: {
                block_hero: @json(__('admin.posts.block_types.hero')),
                block_heading: @json(__('admin.posts.block_types.heading')),
                block_subheading: @json(__('admin.posts.block_types.subheading')),
                block_paragraph: @json(__('admin.posts.block_types.paragraph')),
                block_quote: @json(__('admin.posts.block_types.quote')),
                block_image: @json(__('admin.posts.block_types.image')),
                block_double_image: @json(__('admin.posts.block_types.double_image')),
                block_gallery: @json(__('admin.posts.block_types.gallery')),
                block_list: @json(__('admin.posts.block_types.list')),
                block_video: @json(__('admin.posts.block_types.video')),
                heading_placeholder: @json(__('admin.posts.heading_placeholder')),
                subheading_placeholder: @json(__('admin.posts.subheading_placeholder')),
                paragraph_placeholder: @json(__('admin.posts.paragraph_placeholder')),
                quote_placeholder: @json(__('admin.posts.quote_placeholder')),
                list_placeholder: @json(__('admin.posts.list_placeholder')),
                video_url_placeholder: @json(__('admin.posts.video_url_placeholder')),
                images_lang_independent: @json(__('admin.posts.images_lang_independent')),
                add_image: @json(__('admin.posts.add_image')),
                remove: @json(__('admin.posts.remove')),
                cancel: @json(__('admin.common.cancel')),
                change: @json(__('admin.posts.change')),
                drop_image: @json(__('admin.posts.drop_image')),
                drag_to_reorder: @json(__('admin.posts.drag_to_reorder')),
                move_up: @json(__('admin.posts.move_up')),
                move_down: @json(__('admin.posts.move_down')),
                remove_block: @json(__('admin.posts.remove_block')),
                confirm_remove_block: @json(__('admin.posts.confirm_remove_block')),
                confirm_remove_image: @json(__('admin.posts.confirm_remove_image')),
                add_list_item: @json(__('admin.posts.add_list_item')),
                add_gallery_image: @json(__('admin.posts.add_gallery_image')),
                translate_fr_to_en: @json(__('admin.posts.translate_fr_to_en')),
                translating: @json(__('admin.posts.translating')),
                translation_done: @json(__('admin.posts.translation_done')),
                translation_error: @json(__('admin.posts.translation_error')),
            }
        };
    </script>
    <script src="/build/js/post-builder.js"></script>
    <script src="/build/js/post-form-handler.js"></script>
    <script>
        $(document).on("click", ".btn-social-form-popup", function(e) {
            e.preventDefault();
            const url = $(this).attr("href");
            if (!url || url === "#") return;
            const w = 600, h = 650;
            const left = (window.innerWidth / 2) - (w / 2) + window.screenLeft;
            const top = (window.innerHeight / 2) - (h / 2) + window.screenTop;
            const popup = window.open(url, $(this).data("platform") || "SocialShare", `scrollbars=yes,width=${w},height=${h},top=${top},left=${left}`);
            if (popup && window.focus) {
                popup.focus();
            }
        });

        $(document).on("click", "#btnCopyEditCaption", function() {
            const text = $("#editPageShareCaption").val();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    const $label = $("#copyEditCaptionText");
                    const original = $label.text();
                    $label.text("✓ " + (@json(__("admin.posts.copied")) || "Copié !"));
                    setTimeout(() => $label.text(original), 2500);
                });
            }
        });
    </script>
@endpush
