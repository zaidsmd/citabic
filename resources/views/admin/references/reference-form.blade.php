@extends('admin.layouts.master')

<?php $isEdit = isset($reference); ?>

@section('title', $isEdit ? __('admin.references.edit_title') : __('admin.references.create_title'))

@push('css')
    <link rel="stylesheet" href="{{asset('/build/css/plugins/dropzone.min.css')}}"/>
    <style>
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
        .block-dropzone:hover { border-color: var(--bs-primary); }
        .block-dropzone .dz-message { margin: 0; }
        .block-img-preview { position: relative; display: inline-block; max-width: 100%; }
        .block-img-preview img { max-height: 160px; border-radius: 6px; object-fit: cover; width: 100%; }
        .block-img-preview video { max-height: 160px; border-radius: 6px; object-fit: cover; width: 100%; background: #000; }
        .block-img-preview .btn-change-img {
            position: absolute; top: 4px; right: 4px;
            font-size: 10px; padding: 2px 8px;
        }
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
        .block-item .block-label.type-heading { background: #6f42c1; }
        .block-item .block-label.type-subheading { background: #e83e8c; }
        .block-item .block-label.type-text { background: #20c997; }
        .block-item .block-label.type-image { background: #fd7e14; }
        .block-item .block-label.type-video { background: #d63384; }
        .block-item .block-label.type-doubleImage { background: #dc3545; }
        .block-item .block-label.type-imageTextRow { background: #17a2b8; }
        .block-item .block-label.type-list { background: #0d6efd; }
        .block-item .block-label.type-gallery { background: #6610f2; }
        .block-item .block-label.type-heroImage { background: #343a40; }
        .block-item .block-label.type-coverImage { background: #7952b3; }
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
        .block-content { margin-top: 8px; }

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
            top: 0; left: 0; right: 0; bottom: 0;
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
        .preview-fullscreen .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lang-tabs .nav-link { font-size: 13px; padding: 6px 16px; }
        .lang-tabs .nav-link.active { font-weight: 600; }

        .drag-handle { cursor: grab; color: #adb5bd; }
        .drag-handle:active { cursor: grabbing; }
        .block-item.dragging { opacity: 0.5; }

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

        .gallery-images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <form action="{{ $isEdit ? route('admin.references.update', $reference) : route('admin.references.store') }}" method="POST" id="referenceForm">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <input type="hidden" name="blocks" id="blocks-json" value="{{ json_encode($form['blocks']) }}">
        <input type="hidden" name="title" id="hidden-title" value="{{ old('title', $form['title']) }}">
        <input type="hidden" name="summary" id="hidden-summary" value="{{ old('summary', $form['summary']) }}">
        <input type="hidden" name="description" id="hidden-description" value="{{ old('description', $form['description']) }}">
        <input type="hidden" name="items" id="hidden-items" value="{{ old('items', $form['items']) }}">
        <input type="hidden" name="image" id="hidden-image" value="{{ old('image', $form['image']) }}">

        <x-admin.page-header :title="$isEdit ? __('admin.references.edit_title') : __('admin.references.create_title')"
                             :subtitle="$isEdit ? __('admin.references.edit_subtitle') : __('admin.references.create_subtitle')"
                             :submit-button="true"

                             :back-url="route('admin.references.index')"
        />

        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-tabs lang-tabs mb-3" id="langTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab">
                            <i class="ti ti-language me-1"></i>@lang('admin.common.language.fr')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab">
                            <i class="ti ti-language me-1"></i>@lang('admin.common.language.en')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar-content" type="button" role="tab">
                            <i class="ti ti-language me-1"></i>@lang('admin.common.language.ar')
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="langTabsContent">
                    <div class="tab-pane fade show active" id="fr-content" role="tabpanel">
                        <div class="add-block-bar">
                            <span class="text-muted me-2 align-self-center" style="font-size:12px;">
                                <i class="ti ti-plus me-1"></i>{{ __('admin.references.add_block') }}:
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-dark" onclick="addBlock('heroImage')">
                                <i class="ti ti-panorama-horizontal me-1"></i>{{ __('admin.references.block_types.heroImage') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addBlock('heading')">
                                <i class="ti ti-heading me-1"></i>{{ __('admin.references.block_types.heading') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="addBlock('subheading')">
                                <i class="ti ti-h-4 me-1"></i>{{ __('admin.references.block_types.subheading') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="addBlock('text')">
                                <i class="ti ti-align-left me-1"></i>{{ __('admin.references.block_types.text') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="addBlock('image')">
                                <i class="ti ti-photo me-1"></i>{{ __('admin.references.block_types.image') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="addBlock('video')">
                                <i class="ti ti-video me-1"></i>{{ __('admin.references.block_types.video') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="addBlock('doubleImage')">
                                <i class="ti ti-layout-columns me-1"></i>{{ __('admin.references.block_types.doubleImage') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addBlock('imageTextRow')">
                                <i class="ti ti-layout-sidebar-right me-1"></i>{{ __('admin.references.block_types.imageTextRow') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-purple" onclick="addBlock('coverImage')">
                                <i class="ti ti-live-photo me-1"></i>{{ __('admin.references.block_types.coverImage') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-teal" onclick="addBlock('imageText')">
                                <i class="ti ti-layout-sidebar-right me-1"></i>{{ __('admin.references.block_types.imageText') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addBlock('list')">
                                <i class="ti ti-list-check me-1"></i>{{ __('admin.references.block_types.list') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-dark" onclick="addBlock('gallery')">
                                <i class="ti ti-layout-grid-add me-1"></i>{{ __('admin.references.block_types.gallery') }}
                            </button>
                        </div>

                        <div id="blocks-container"></div>
                    </div>

                    <div class="tab-pane fade" id="en-content" role="tabpanel">
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <i class="ti ti-info-circle me-1"></i>
                            {{ __('admin.references.en_translation_info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div id="blocks-container-en"></div>
                    </div>

                    <div class="tab-pane fade" id="ar-content" role="tabpanel">
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <i class="ti ti-info-circle me-1"></i>
                            {{ __('admin.references.ar_translation_info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div id="blocks-container-ar" dir="rtl"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-settings me-2"></i>{{ __('admin.references.project_settings') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.references.client') }} <span class="text-danger">*</span></label>
                            <input type="text" name="client" id="input-client" class="form-control @error('client') is-invalid @enderror"
                                   value="{{ old('client', $form['client']) }}" required placeholder="{{ __('admin.references.client_placeholder') }}">
                            @error('client') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.references.surface') }}</label>
                                    <input type="text" name="surface" id="input-surface" class="form-control @error('surface') is-invalid @enderror"
                                           value="{{ old('surface', $form['surface']) }}" placeholder="{{ __('admin.references.surface_placeholder') }}">
                                    @error('surface') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.references.budget') }}</label>
                                    <input type="text" name="budget" id="input-budget" class="form-control @error('budget') is-invalid @enderror"
                                           value="{{ old('budget', $form['budget']) }}" placeholder="{{ __('admin.references.budget_placeholder') }}">
                                    @error('budget') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        @if($isEdit && isset($reference['year']))
                            <div class="mb-3">
                                <label class="form-label">{{ __('admin.references.year') }}</label>
                                <input type="text" name="year" class="form-control" value="{{ $reference['year'] }}" readonly disabled>
                                <small class="text-muted">{{ __('admin.references.year_readonly') }}</small>
                            </div>
                        @endif
                    </div>
                </div>

                                @if($isEdit && !empty($reference))
                    <div class="card mb-3 border-0 shadow-sm" style="background: #fdfdfe; border: 1px solid rgba(70, 128, 255, 0.2) !important;">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                            <h6 class="mb-0 fw-bold text-primary">
                                <i class="ti ti-share me-1"></i>{{ __("admin.references.share_social") }}
                            </h6>
                            <span class="badge bg-light-primary text-primary" style="font-size: 10px;">{{ __("admin.references.publish_action") }}</span>
                        </div>
                        <div class="card-body p-3">
                            @php
                                $refShareUrl = route("references.show", $reference->slug);
                                $refFbUrl = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($refShareUrl);
                                $refLiUrl = "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($refShareUrl);
                                $refShareCaption = $reference instanceof \App\Models\CitabicReference
                                    ? $reference->getShareCaption()
                                    : "Découvrez notre réalisation : " . ($reference["title"] ?? "") . "\n\n👉 " . $refShareUrl . "\n\n#CITABIC #Architecture #GénieCivil #Construction #Maroc";
                            @endphp

                            <p class="text-muted small mb-2" style="font-size: 12px;">
                                {{ __("admin.references.share_card_description") }}
                            </p>

                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0 small text-secondary fw-semibold">{{ __("admin.references.share_caption") }}</label>
                                    <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none" id="btnCopyEditCaption" style="font-size: 11px;">
                                        <i class="ti ti-copy me-1"></i><span id="copyEditCaptionText">{{ __("admin.references.copy_caption") }}</span>
                                    </button>
                                </div>
                                <textarea class="form-control form-control-sm bg-light" id="editPageShareCaption" rows="3" readonly style="font-size: 12px;">{{ $refShareCaption }}</textarea>
                            </div>

                            <div class="d-grid gap-2 pt-1">
                                <a href="{{ $refFbUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-1 d-flex align-items-center justify-content-center btn-social-form-popup" data-platform="facebook" style="background-color: #1877F2; border-color: #1877F2;">
                                    <i class="fab fa-facebook-f me-2"></i> {{ __("admin.references.share_facebook") }}
                                </a>
                                <a href="{{ $refLiUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-1 d-flex align-items-center justify-content-center btn-social-form-popup" data-platform="linkedin" style="background-color: #0A66C2; border-color: #0A66C2;">
                                    <i class="fab fa-linkedin-in me-2"></i> {{ __("admin.references.share_linkedin") }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="preview-panel mb-3" id="preview-panel">
                    <div class="preview-header">
                        <span><i class="ti ti-eye me-1"></i>{{ __('admin.references.live_preview') }}</span>
                        <button type="button" class="btn btn-sm btn-outline-light" id="btn-fullscreen-preview" style="padding:1px 8px;font-size:11px;border-color:#555;color:#ccc;" title="{{ __('admin.references.toggle_fullscreen') }}">
                            <i class="ti ti-arrows-maximize"></i>
                        </button>
                    </div>
                    <iframe id="preview-iframe" class="preview-iframe" title="{{ __('admin.references.preview_title') }}"></iframe>
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
    <script src="/build/js/plugins/tinymce/tinymce.min.js"></script>
    <script>
        window.referenceFormConfig = {
            uploadUrl: '{{ route('admin.sections.upload-image') }}',
            uploadVideoUrl: '{{ route('admin.sections.upload-video') }}',
            csrfToken: '{{ csrf_token() }}',
            assets: {
                bootstrapCss: '{{ asset('guest/assets/css/bootstrap.min.css') }}',
                fontawesomeCss: '{{ asset('guest/assets/css/fontawesome.min.css') }}',
                guestCss: '{{ asset('build/css/guest.css') }}',
            },
            translations: {
                block_heroImage: @json(__('admin.references.block_types.heroImage')),
                block_heading: @json(__('admin.references.block_types.heading')),
                block_subheading: @json(__('admin.references.block_types.subheading')),
                block_text: @json(__('admin.references.block_types.text')),
                block_image: @json(__('admin.references.block_types.image')),
                block_video: @json(__('admin.references.block_types.video')),
                block_doubleImage: @json(__('admin.references.block_types.doubleImage')),
                block_imageTextRow: @json(__('admin.references.block_types.imageTextRow')),
                block_coverImage: @json(__('admin.references.block_types.coverImage')),
                block_imageText: @json(__('admin.references.block_types.imageText')),
                block_list: @json(__('admin.references.block_types.list')),
                block_gallery: @json(__('admin.references.block_types.gallery')),
                heading_placeholder: @json(__('admin.references.heading_placeholder')),
                subheading_placeholder: @json(__('admin.references.subheading_placeholder')),
                text_placeholder: @json(__('admin.references.text_placeholder')),
                text_items_placeholder: @json(__('admin.references.text_items_placeholder')),
                list_placeholder: @json(__('admin.references.list_placeholder')),
                heading_en_placeholder: @json(__('admin.references.heading_en_placeholder')),
                subheading_en_placeholder: @json(__('admin.references.subheading_en_placeholder')),
                text_en_placeholder: @json(__('admin.references.text_en_placeholder')),
                text_items_en_placeholder: @json(__('admin.references.text_items_en_placeholder')),
                list_en_placeholder: @json(__('admin.references.list_en_placeholder')),
                heading_ar_placeholder: @json(__('admin.references.heading_ar_placeholder')),
                subheading_ar_placeholder: @json(__('admin.references.subheading_ar_placeholder')),
                text_ar_placeholder: @json(__('admin.references.text_ar_placeholder')),
                text_items_ar_placeholder: @json(__('admin.references.text_items_ar_placeholder')),
                list_ar_placeholder: @json(__('admin.references.list_ar_placeholder')),
                images_lang_independent: @json(__('admin.references.images_lang_independent')),
                add_image: @json(__('admin.references.add_image')),
                add_video: @json(__('admin.references.add_video')),
                drop_video: @json(__('admin.references.drop_video')),
                remove: @json(__('admin.references.remove')),
                change: @json(__('admin.references.change')),
                drop_image: @json(__('admin.references.drop_image')),
                drag_to_reorder: @json(__('admin.references.drag_to_reorder')),
                move_up: @json(__('admin.references.move_up')),
                move_down: @json(__('admin.references.move_down')),
                remove_block: @json(__('admin.references.remove_block')),
                confirm_remove_block: @json(__('admin.references.confirm_remove_block')),
                confirm_remove_image: @json(__('admin.references.confirm_remove_image')),
                sidebar_project_info: @json(__('site.reference.project_info')),
                sidebar_client: @json(__('site.reference.client')),
                sidebar_surface: @json(__('site.reference.surface')),
                sidebar_budget: @json(__('site.reference.budget')),
            },
        };
    </script>
    <script src="/build/js/reference-form.js"></script>
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
                    $label.text("✓ " + (@json(__("admin.references.copied")) || "Copié !"));
                    setTimeout(() => $label.text(original), 2500);
                });
            }
        });
    </script>
@endpush
