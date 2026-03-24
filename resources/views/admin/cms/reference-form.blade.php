@extends('admin.layouts.master')

@php($isEdit = isset($reference))

@section('title', $isEdit ? __('admin.references.edit_title') : __('admin.references.create_title'))

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
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
        .block-img-preview .btn-change-img {
            position: absolute; top: 4px; right: 4px;
            font-size: 10px; padding: 2px 8px;
        }
        .block-item {
            border: 2px solid #e2e5ec;
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
    </style>
@endpush

@section('content')
    <x-breadcrumb item="CMS" active="{{ $isEdit ? __('admin.references.edit_title') : __('admin.references.create_title') }}"/>

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

        <div class="card mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.references.index') }}" class="btn btn-sm btn-light-secondary">
                        <i class="ti ti-arrow-left me-1"></i>{{ __('admin.common.back_to_list') }}
                    </a>
                    <h5 class="mb-0 ms-2">{{ $isEdit ? __('admin.references.edit_title') : __('admin.references.create_title') }}</h5>
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
                           </i>@lang('admin.common.language.fr')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab">
                             @lang('admin.common.language.en')
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

@section('scripts')
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script src="/build/js/plugins/tinymce/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const blockTypes = {
                heroImage:    { label: @json(__('admin.references.block_types.heroImage')), icon: 'ti-panorama-horizontal', color: 'type-heroImage' },
                heading:      { label: @json(__('admin.references.block_types.heading')), icon: 'ti-heading', color: 'type-heading' },
                subheading:   { label: @json(__('admin.references.block_types.subheading')), icon: 'ti-h-4', color: 'type-subheading' },
                text:         { label: @json(__('admin.references.block_types.text')), icon: 'ti-align-left', color: 'type-text' },
                image:        { label: @json(__('admin.references.block_types.image')), icon: 'ti-photo', color: 'type-image' },
                doubleImage:  { label: @json(__('admin.references.block_types.doubleImage')), icon: 'ti-layout-columns', color: 'type-doubleImage' },
                imageTextRow: { label: @json(__('admin.references.block_types.imageTextRow')), icon: 'ti-layout-sidebar-right', color: 'type-imageTextRow' },
                coverImage:   { label: @json(__('admin.references.block_types.coverImage')), icon: 'ti-photo-filled', color: 'type-coverImage' },
                imageText:    { label: @json(__('admin.references.block_types.imageText')), icon: 'ti-layout-sidebar-left-collapse', color: 'type-imageText' },
                list:         { label: @json(__('admin.references.block_types.list')), icon: 'ti-list-check', color: 'type-list' },
                gallery:      { label: @json(__('admin.references.block_types.gallery')), icon: 'ti-photo-plus', color: 'type-gallery' },
            };

            let blocks = [];
            try {
                blocks = JSON.parse(document.getElementById('blocks-json').value || '[]');
            } catch (e) { blocks = []; }
            if (!Array.isArray(blocks)) blocks = [];

            const container = document.getElementById('blocks-container');
            const containerEn = document.getElementById('blocks-container-en');

            function renderBlocks() {
                container.innerHTML = '';
                containerEn.innerHTML = '';
                blocks.forEach(function (block, index) {
                    container.appendChild(createBlockElement(block, index, 'fr'));
                    containerEn.appendChild(createBlockEnElement(block, index));
                });
                syncJSON();
                updatePreview();
                initDragDrop();
            }

            function createBlockElement(block, index, lang) {
                const div = document.createElement('div');
                div.className = 'block-item';
                div.dataset.index = index;
                div.setAttribute('draggable', 'true');

                const typeConf = blockTypes[block.type] || { label: block.type, icon: 'ti-box', color: '' };

                let contentHtml = '';
                switch (block.type) {
                    case 'heroImage':
                        contentHtml = buildDropzoneHtml(index, 'content', block.content || '', 'hero');
                        break;
                    case 'heading':
                        contentHtml = '<input type="text" class="form-control" placeholder="' + @json(__('admin.references.heading_placeholder')) + '" value="' + esc(block.content || '') + '" data-field="content">';
                        break;
                    case 'subheading':
                        contentHtml = '<input type="text" class="form-control" placeholder="' + @json(__('admin.references.subheading_placeholder')) + '" value="' + esc(block.content || '') + '" data-field="content">';
                        break;
                    case 'text':
                        contentHtml = '<textarea class="form-control block-tinymce" id="tinymce-' + index + '-content" rows="5" placeholder="' + @json(__('admin.references.text_placeholder')) + '" data-field="content" data-block-index="' + index + '">' + esc(block.content || '') + '</textarea>';
                        break;
                    case 'image':
                        contentHtml = buildDropzoneHtml(index, 'content', block.content || '', 'image');
                        break;
                    case 'coverImage':
                        contentHtml = buildDropzoneHtml(index, 'content', block.content || '', 'cover');
                        break;
                    case 'doubleImage':
                        contentHtml =
                            '<div class="row g-2">' +
                            '<div class="col-6">' + buildDropzoneHtml(index, 'image1', block.image1 || '', 'image1') + '</div>' +
                            '<div class="col-6">' + buildDropzoneHtml(index, 'image2', block.image2 || '', 'image2') + '</div>' +
                            '</div>';
                        break;
                    case 'imageTextRow':
                        contentHtml =
                            '<div class="row g-2">' +
                            '<div class="col-5">' + buildDropzoneHtml(index, 'image', block.image || '', 'image') + '</div>' +
                            '<div class="col-7"><textarea class="form-control" rows="4" placeholder="' + @json(__('admin.references.text_items_placeholder')) + '" data-field="content">' + esc(block.content || '') + '</textarea></div>' +
                            '</div>';
                        break;
                    case 'imageText':
                        contentHtml =
                            '<div class="row g-2">' +
                            '<div class="col-5">' + buildDropzoneHtml(index, 'image', block.image || '', 'image') + '</div>' +
                            '<div class="col-7"><textarea class="form-control block-tinymce" id="tinymce-' + index + '-content" rows="4" placeholder="' + @json(__('admin.references.text_placeholder')) + '" data-field="content" data-block-index="' + index + '">' + esc(block.content || '') + '</textarea></div>' +
                            '</div>';
                        break;
                    case 'list':
                        contentHtml = '<textarea class="form-control" rows="5" placeholder="' + @json(__('admin.references.list_placeholder')) + '" data-field="content">' + esc(block.content || '') + '</textarea>';
                        break;
                    case 'gallery':
                        var images = block.images || [];
                        contentHtml = '<div class="gallery-images-grid" data-block-index="' + index + '">';
                        images.forEach(function (img, gi) {
                            contentHtml += '<div class="gallery-image-item" data-gi="' + gi + '">' +
                                buildDropzoneHtml(index, 'gallery_' + gi, img, 'gallery') +
                                '<button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remove-gallery-img" data-gi="' + gi + '"><i class="ti ti-trash me-1"></i>' + @json(__('admin.references.remove')) + '</button>' +
                                '</div>';
                        });
                        contentHtml += '</div>';
                        contentHtml += '<button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-gallery-img" data-block-index="' + index + '"><i class="ti ti-plus me-1"></i>' + @json(__('admin.references.add_image')) + '</button>';
                        break;
                }

                div.innerHTML =
                    '<span class="block-label ' + typeConf.color + '"><i class="ti ' + typeConf.icon + ' me-1"></i>' + typeConf.label + '</span>' +
                    '<div class="block-toolbar">' +
                    '<button type="button" class="btn btn-sm btn-outline-secondary drag-handle" title="' + @json(__('admin.references.drag_to_reorder')) + '"><i class="ti ti-grip-vertical"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-outline-secondary btn-move-up" title="' + @json(__('admin.references.move_up')) + '"><i class="ti ti-arrow-up"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-outline-secondary btn-move-down" title="' + @json(__('admin.references.move_down')) + '"><i class="ti ti-arrow-down"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-outline-danger btn-remove" title="' + @json(__('admin.references.remove_block')) + '"><i class="ti ti-trash"></i></button>' +
                    '</div>' +
                    '<div class="block-content">' + contentHtml + '</div>';

                div.querySelector('.btn-remove').addEventListener('click', function () {
                    if (confirm(@json(__('admin.references.confirm_remove_block')))) {
                        blocks.splice(index, 1);
                        renderBlocks();
                    }
                });
                div.querySelector('.btn-move-up').addEventListener('click', function () {
                    if (index > 0) {
                        [blocks[index], blocks[index - 1]] = [blocks[index - 1], blocks[index]];
                        renderBlocks();
                    }
                });
                div.querySelector('.btn-move-down').addEventListener('click', function () {
                    if (index < blocks.length - 1) {
                        [blocks[index], blocks[index + 1]] = [blocks[index + 1], blocks[index]];
                        renderBlocks();
                    }
                });

                div.querySelectorAll('[data-field]').forEach(function (input) {
                    input.addEventListener('input', function () {
                        blocks[index][this.dataset.field] = this.value;
                        syncJSON();
                        updatePreview();
                    });
                });

                return div;
            }

            function createBlockEnElement(block, index) {
                const div = document.createElement('div');
                div.className = 'block-item';
                const typeConf = blockTypes[block.type] || { label: block.type, icon: 'ti-box', color: '' };

                let contentHtml = '';
                switch (block.type) {
                    case 'heading':
                        contentHtml = '<input type="text" class="form-control" placeholder="' + @json(__('admin.references.heading_en_placeholder')) + '" value="' + esc(block.content_en || '') + '" data-field="content_en">';
                        break;
                    case 'subheading':
                        contentHtml = '<input type="text" class="form-control" placeholder="' + @json(__('admin.references.subheading_en_placeholder')) + '" value="' + esc(block.content_en || '') + '" data-field="content_en">';
                        break;
                    case 'text':
                        contentHtml = '<textarea class="form-control block-tinymce" id="tinymce-en-' + index + '-content_en" rows="5" placeholder="' + @json(__('admin.references.text_en_placeholder')) + '" data-field="content_en" data-block-index="' + index + '">' + esc(block.content_en || '') + '</textarea>';
                        break;
                    case 'imageTextRow':
                        contentHtml = '<textarea class="form-control" rows="4" placeholder="' + @json(__('admin.references.text_items_en_placeholder')) + '" data-field="content_en">' + esc(block.content_en || '') + '</textarea>';
                        break;
                    case 'imageText':
                        contentHtml = '<textarea class="form-control block-tinymce" id="tinymce-en-' + index + '-content_en" rows="4" placeholder="' + @json(__('admin.references.text_en_placeholder')) + '" data-field="content_en" data-block-index="' + index + '">' + esc(block.content_en || '') + '</textarea>';
                        break;
                    case 'list':
                        contentHtml = '<textarea class="form-control" rows="5" placeholder="' + @json(__('admin.references.list_en_placeholder')) + '" data-field="content_en">' + esc(block.content_en || '') + '</textarea>';
                        break;
                    default:
                        contentHtml = '<div class="alert alert-secondary mb-0"><i class="ti ti-info-circle me-1"></i>' + @json(__('admin.references.images_lang_independent')) + '</div>';
                        break;
                }

                div.innerHTML =
                    '<span class="block-label ' + typeConf.color + '"><i class="ti ' + typeConf.icon + ' me-1"></i>' + typeConf.label + ' (EN)</span>' +
                    '<div class="block-content">' + contentHtml + '</div>';

                div.querySelectorAll('[data-field]').forEach(function (input) {
                    input.addEventListener('input', function () {
                        blocks[index][this.dataset.field] = this.value;
                        syncJSON();
                    });
                });

                return div;
            }

            function syncJSON() {
                document.getElementById('blocks-json').value = JSON.stringify(blocks);

                let title = '', summary = '', description = '', items = [], image = '';
                blocks.forEach(function (b) {
                    if (b.type === 'heading' && !title) title = b.content || '';
                    if (b.type === 'text' && !summary) summary = b.content || '';
                    if (b.type === 'heroImage' && !image) image = b.content || '';
                    if (b.type === 'coverImage' && !image) image = b.content || '';
                });
                document.getElementById('hidden-title').value = title;
                document.getElementById('hidden-summary').value = summary || title;
                document.getElementById('hidden-description').value = description || summary;
                document.getElementById('hidden-image').value = image;
            }

            function updatePreview() {
                const iframe = document.getElementById('preview-iframe');
                const client = document.getElementById('input-client')?.value || '';
                const surface = document.getElementById('input-surface')?.value || '';
                const budget = document.getElementById('input-budget')?.value || '';

                let heroHtml = '';
                let contentHtml = '';

                blocks.forEach(function (b) {
                    if (b.type === 'heroImage' && b.content) {
                        heroHtml += '<div class="page-img mb-40"><img src="' + esc(b.content) + '" alt="hero" style="width:100%;height:auto;"></div>';
                    }
                });

                blocks.forEach(function (b) {
                    switch (b.type) {
                        case 'heroImage': break;
                        case 'heading':
                            contentHtml += '<h2 class="fw-semibold mb-3">' + esc(b.content || '') + '</h2>';
                            break;
                        case 'subheading':
                            contentHtml += '<h4 class="fw-semibold mb-20 mt-50">' + esc(b.content || '') + '</h4>';
                            break;
                        case 'text':
                            contentHtml += '<div class="mb-40">' + (b.content || '') + '</div>';
                            break;
                        case 'image':
                            if (b.content) {
                                contentHtml += '<div class="page-img mb-30"><img src="' + esc(b.content) + '" alt="image" style="width:100%;height:auto;"></div>';
                            }
                            break;
                        case 'doubleImage':
                            contentHtml += '<div class="row gx-40 gy-40 align-items-center mb-40">';
                            contentHtml += '<div class="col-lg-6"><div class="page-img"><img src="' + esc(b.image1 || '') + '" alt="image1" style="width:100%;height:auto;"></div></div>';
                            contentHtml += '<div class="col-lg-6"><div class="page-img"><img src="' + esc(b.image2 || '') + '" alt="image2" style="width:100%;height:auto;"></div></div>';
                            contentHtml += '</div>';
                            break;
                        case 'imageTextRow':
                            contentHtml += '<div class="row gx-40 gy-40 align-items-center mb-40">';
                            contentHtml += '<div class="col-xl-5"><div class="page-img"><img src="' + esc(b.image || '') + '" alt="image" style="width:100%;height:auto;"></div></div>';
                            contentHtml += '<div class="col-xl-7"><div class="checklist style5"><ul>';
                            if (b.content) {
                                b.content.split('\n').filter(l => l.trim()).forEach(l => {
                                    contentHtml += '<li>' + esc(l.trim()) + '</li>';
                                });
                            }
                            contentHtml += '</ul></div></div></div>';
                            break;
                        case 'imageText':
                            contentHtml += '<div class="row gx-40 gy-40 align-items-center mb-40">';
                            contentHtml += '<div class="col-xl-5"><div class="page-img"><img src="' + esc(b.image || '') + '" alt="image" style="width:100%;height:auto;"></div></div>';
                            contentHtml += '<div class="col-xl-7">' + (b.content || '') + '</div>';
                            contentHtml += '</div>';
                            break;
                        case 'list':
                            contentHtml += '<div class="checklist style5 mb-40"><ul>';
                            if (b.content) {
                                b.content.split('\n').filter(l => l.trim()).forEach(l => {
                                    contentHtml += '<li>' + esc(l.trim()) + '</li>';
                                });
                            }
                            contentHtml += '</ul></div>';
                            break;
                        case 'gallery':
                            if (b.images && b.images.length) {
                                contentHtml += '<div class="gallery-masonry">';
                                b.images.filter(img => img).forEach(img => {
                                    contentHtml += '<div class="gallery-item">';
                                    contentHtml += '<div class="gallery-img-wrapper"><img src="' + esc(img) + '" alt="gallery" style="width:100%;height:auto;"></div>';
                                    contentHtml += '</div>';
                                });
                                contentHtml += '</div>';
                            }
                            break;
                    }
                });

                let sidebarHtml = '<aside class="sidebar-area"><div class="widget widget_info">';
                sidebarHtml += '<h3 class="widget_title">@lang('site.reference.project_info')</h3>';
                sidebarHtml += '<div class="info-list"><ul>';
                if (client) {
                    sidebarHtml += '<li><div class="box-icon"><i class="fas fa-user"></i></div><div><span class="text">@lang('site.reference.client') :</span><strong class="title">' + esc(client) + '</strong></div></li>';
                }
                if (surface) {
                    sidebarHtml += '<li><div class="box-icon"><i class="fas fa-layer-group"></i></div><div><span class="text">@lang('site.reference.surface') :</span><strong class="title">' + esc(surface) + '</strong></div></li>';
                }
                if (budget) {
                    sidebarHtml += '<li><div class="box-icon"><i class="fas fa-cash-register"></i></div><div><span class="text">@lang('site.reference.budget') :</span><strong class="title">' + esc(budget) + '</strong></div></li>';
                }
                sidebarHtml += '</ul></div></div></aside>';

                const fullHtml = '<!DOCTYPE html><html><head>' +
                    '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">' +
                    '<link rel="stylesheet" href="{{ asset('guest/assets/css/bootstrap.min.css') }}">' +
                    '<link rel="stylesheet" href="{{ asset('guest/assets/css/fontawesome.min.css') }}">' +
                    '<link rel="stylesheet" href="{{ asset('/build/css/guest.css') }}">' +
                    '<style>' +
                    'body{padding:15px;overflow-x:hidden;}' +
                    'img{max-width:100%;height:auto;}' +
                    '.gallery-masonry{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.5rem;margin:2rem 0;}' +
                    '.gallery-item{position:relative;overflow:hidden;border-radius:1rem;cursor:pointer;transition:all .4s;background:#f5f5f5;box-shadow:0 8px 20px rgba(0,0,0,.08);}' +
                    '.gallery-img-wrapper{position:relative;overflow:hidden;}' +
                    '.gallery-img-wrapper img{width:100%;height:auto;display:block;transition:transform .6s ease;}' +
                    '.gallery-item:hover{transform:translateY(-6px);box-shadow:0 20px 35px rgba(0,0,0,.15);}' +
                    '.gallery-item:hover .gallery-img-wrapper img{transform:scale(1.05);}' +
                    '</style>' +
                    '</head><body>' +
                    '<section class="project-details-page"><div class="container">' +
                    heroHtml +
                    '<div class="row"><div class="col-xxl-8 col-lg-8"><div class="page-single mt-30">' + contentHtml + '</div></div>' +
                    '<div class="col-xxl-4 col-lg-4">' + sidebarHtml + '</div></div>' +
                    '</div></section></body></html>';

                const doc = iframe.contentDocument || iframe.contentWindow.document;
                doc.open();
                doc.write(fullHtml);
                doc.close();

                iframe.onload = function () {
                    try {
                        iframe.style.height = iframe.contentDocument.body.scrollHeight + 20 + 'px';
                    } catch (e) {}
                };
                setTimeout(() => {
                    try {
                        iframe.style.height = iframe.contentDocument.body.scrollHeight + 20 + 'px';
                    } catch (e) {}
                }, 500);
            }

            function initDragDrop() {
                let dragIndex = null;
                container.querySelectorAll('.block-item').forEach(function (el) {
                    el.addEventListener('dragstart', function (e) {
                        dragIndex = parseInt(this.dataset.index);
                        this.classList.add('dragging');
                        e.dataTransfer.effectAllowed = 'move';
                    });
                    el.addEventListener('dragend', function () {
                        this.classList.remove('dragging');
                    });
                    el.addEventListener('dragover', function (e) {
                        e.preventDefault();
                        e.dataTransfer.dropEffect = 'move';
                    });
                    el.addEventListener('drop', function (e) {
                        e.preventDefault();
                        const dropIndex = parseInt(this.dataset.index);
                        if (dragIndex !== null && dragIndex !== dropIndex) {
                            const moved = blocks.splice(dragIndex, 1)[0];
                            blocks.splice(dropIndex, 0, moved);
                            renderBlocks();
                        }
                        dragIndex = null;
                    });
                });
            }

            window.addBlock = function (type) {
                const block = { type: type };
                switch (type) {
                    case 'heroImage':
                    case 'image':
                    case 'coverImage':
                        block.content = '';
                        break;
                    case 'heading':
                    case 'subheading':
                    case 'text':
                        block.content = '';
                        block.content_en = '';
                        break;
                    case 'doubleImage':
                        block.image1 = '';
                        block.image2 = '';
                        break;
                    case 'imageTextRow':
                    case 'imageText':
                        block.image = '';
                        block.content = '';
                        block.content_en = '';
                        break;
                    case 'list':
                        block.content = '';
                        block.content_en = '';
                        break;
                    case 'gallery':
                        block.images = [];
                        break;
                }
                blocks.push(block);
                renderBlocks();
                const lastBlock = container.querySelector('.block-item:last-child');
                if (lastBlock) lastBlock.scrollIntoView({ behavior: 'smooth', block: 'center' });
            };

            ['input-client', 'input-surface', 'input-budget'].forEach(function (id) {
                const el = document.getElementById(id);
                if (el) el.addEventListener('input', () => updatePreview());
            });

            function esc(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.appendChild(document.createTextNode(text));
                return div.innerHTML;
            }

            document.getElementById('referenceForm').addEventListener('submit', function (e) {
                syncJSON();
                const title = document.getElementById('hidden-title').value;
                if (!title) document.getElementById('hidden-title').value = 'Untitled';
            });

            const uploadUrl = '{{ route('admin.sections.upload-image') }}';
            const csrfToken = '{{ csrf_token() }}';

            function buildDropzoneHtml(blockIndex, field, currentValue, type) {
                const dzId = 'dz-' + blockIndex + '-' + field;
                if (currentValue) {
                    return '<div class="block-img-preview" id="' + dzId + '-preview">' +
                        '<img src="' + esc(currentValue) + '" alt="">' +
                        '<button type="button" class="btn btn-sm btn-light btn-change-img" data-dz-id="' + dzId + '" data-block="' + blockIndex + '" data-field="' + field + '"><i class="ti ti-edit me-1"></i>' + @json(__('admin.references.change')) + '</button>' +
                        '</div>' +
                        '<div id="' + dzId + '" class="block-dropzone" style="display:none">' +
                        '<div class="dz-message"><i class="ti ti-cloud-upload" style="font-size:24px;display:block;margin-bottom:4px;"></i><small>' + @json(__('admin.references.drop_image')) + '</small></div>' +
                        '</div>';
                }
                return '<div class="block-img-preview" id="' + dzId + '-preview" style="display:none">' +
                    '<img src="" alt="">' +
                    '<button type="button" class="btn btn-sm btn-light btn-change-img" data-dz-id="' + dzId + '" data-block="' + blockIndex + '" data-field="' + field + '"><i class="ti ti-edit me-1"></i>' + @json(__('admin.references.change')) + '</button>' +
                    '</div>' +
                    '<div id="' + dzId + '" class="block-dropzone">' +
                    '<div class="dz-message"><i class="ti ti-cloud-upload" style="font-size:24px;display:block;margin-bottom:4px;"></i><small>' + @json(__('admin.references.drop_image')) + '</small></div>' +
                    '</div>';
            }

            function initBlockDropzones() {
                if (typeof Dropzone === 'undefined') return;
                document.querySelectorAll('.block-dropzone').forEach(function (el) {
                    if (el.dropzone) return;
                    const dzId = el.id;
                    const parts = dzId.replace('dz-', '').split('-');
                    const blockIndex = parseInt(parts[0]);
                    const field = parts.slice(1).join('-') || parts[1];
                    const previewEl = document.getElementById(dzId + '-preview');

                    const dz = new Dropzone('#' + dzId, {
                        url: uploadUrl,
                        autoProcessQueue: true,
                        uploadMultiple: false,
                        maxFiles: 1,
                        paramName: 'image',
                        acceptedFiles: 'image/*',
                        addRemoveLinks: false,
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        createImageThumbnails: false,
                    });
                    dz.on('sending', function (file, xhr, formData) {
                        formData.append('key', 'reference_block_' + blockIndex + '_' + field);
                    });
                    dz.on('addedfile', function () {
                        dz.files.filter((f, i) => i < dz.files.length - 1).forEach(f => dz.removeFile(f));
                    });
                    dz.on('success', function (file, response) {
                        if (response.path) {
                            var imgPath = '/storage/' + response.path;
                            if (field.startsWith('gallery_')) {
                                var gi = parseInt(field.replace('gallery_', ''));
                                if (!blocks[blockIndex].images) blocks[blockIndex].images = [];
                                blocks[blockIndex].images[gi] = imgPath;
                            } else {
                                blocks[blockIndex][field] = imgPath;
                            }
                            previewEl.querySelector('img').src = imgPath;
                            previewEl.style.display = '';
                            el.style.display = 'none';
                            dz.removeAllFiles();
                            syncJSON();
                            updatePreview();
                        }
                    });
                });

                document.querySelectorAll('.btn-change-img').forEach(function (btn) {
                    if (btn._dzBound) return;
                    btn._dzBound = true;
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        const dzId = this.dataset.dzId;
                        const previewEl = document.getElementById(dzId + '-preview');
                        const dzEl = document.getElementById(dzId);
                        previewEl.style.display = 'none';
                        dzEl.style.display = '';
                    });
                });
            }

            const _origRenderBlocks = renderBlocks;
            renderBlocks = function () {
                if (typeof tinymce !== 'undefined') tinymce.remove('.block-tinymce');
                _origRenderBlocks();
                setTimeout(() => {
                    initBlockDropzones();
                    initGalleryButtons();
                    initTinyMCE();
                }, 50);
            };

            function initTinyMCE() {
                if (typeof tinymce === 'undefined') return;
                document.querySelectorAll('.block-tinymce').forEach(function (el) {
                    if (el.id && !tinymce.get(el.id)) {
                        tinymce.init({
                            selector: '#' + el.id,
                            menubar: false,
                            height: 200,
                            branding: false,
                            language: 'fr',
                            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link',
                            plugins: ['advlist', 'autolink', 'link', 'lists', 'searchreplace'],
                            setup: function (editor) {
                                editor.on('change keyup', function () {
                                    editor.save();
                                    var idx = parseInt(el.dataset.blockIndex);
                                    var field = el.dataset.field;
                                    blocks[idx][field] = editor.getContent();
                                    syncJSON();
                                    updatePreview();
                                });
                            }
                        });
                    }
                });
            }

            function initGalleryButtons() {
                document.querySelectorAll('.btn-add-gallery-img').forEach(function (btn) {
                    if (btn._bound) return;
                    btn._bound = true;
                    btn.addEventListener('click', function () {
                        var idx = parseInt(this.dataset.blockIndex);
                        if (!blocks[idx].images) blocks[idx].images = [];
                        blocks[idx].images.push('');
                        renderBlocks();
                    });
                });
                document.querySelectorAll('.btn-remove-gallery-img').forEach(function (btn) {
                    if (btn._bound) return;
                    btn._bound = true;
                    btn.addEventListener('click', function () {
                        if (confirm(@json(__('admin.references.confirm_remove_image')))) {
                            var gi = parseInt(this.dataset.gi);
                            var container = this.closest('.gallery-images-grid');
                            var idx = parseInt(container.dataset.blockIndex);
                            blocks[idx].images.splice(gi, 1);
                            renderBlocks();
                        }
                    });
                });
            }

            document.getElementById('btn-fullscreen-preview').addEventListener('click', function () {
                var panel = document.getElementById('preview-panel');
                panel.classList.toggle('preview-fullscreen');
                var icon = this.querySelector('i');
                icon.className = panel.classList.contains('preview-fullscreen') ? 'ti ti-arrows-minimize' : 'ti ti-arrows-maximize';
                updatePreview();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    var panel = document.getElementById('preview-panel');
                    if (panel.classList.contains('preview-fullscreen')) {
                        panel.classList.remove('preview-fullscreen');
                        document.querySelector('#btn-fullscreen-preview i').className = 'ti ti-arrows-maximize';
                        updatePreview();
                    }
                }
            });

            renderBlocks();
        });
    </script>
@endsection
