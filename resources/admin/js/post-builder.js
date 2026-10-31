(function () {
    function esc(text) {
        if (!text) {
            return '';
        }

        const div = document.createElement('div');
        div.appendChild(document.createTextNode(String(text)));

        return div.innerHTML;
    }

    function toArray(value) {
        return Array.isArray(value) ? value : [];
    }

    class PostBuilder {
        constructor(config) {
            this.config = config || {};
            this.trans = this.config.translations || {};
            this.assets = this.config.assets || {};
            this.uploadUrl = this.config.uploadUrl || '';
            this.csrfToken = this.config.csrfToken || '';

            this.blocks = toArray(this.config.blocksData).map((block) => this.normalizeBlock(block));
            this.frContainer = document.getElementById('blocks-container-fr');
            this.enContainer = document.getElementById('blocks-container-en');
            this.arContainer = document.getElementById('blocks-container-ar');
            this.blocksInput = document.getElementById('blocks-json');
            this.previewIframe = document.getElementById('preview-iframe');
            this.heroButton = document.getElementById('add-hero-block-btn');
        }

        init() {
            this.render();
            this.bindPreviewFullscreen();
        }

        blockTypes() {
            return {
                hero: { label: this.trans.block_hero || 'Hero', icon: 'ti-panorama-horizontal', color: 'type-hero' },
                heading: { label: this.trans.block_heading || 'Header', icon: 'ti-heading', color: 'type-heading' },
                subheading: { label: this.trans.block_subheading || 'SubHeader', icon: 'ti-h-4', color: 'type-subheading' },
                paragraph: { label: this.trans.block_paragraph || 'Paragraph', icon: 'ti-align-left', color: 'type-paragraph' },
                quote: { label: this.trans.block_quote || 'Quote', icon: 'ti-quote', color: 'type-quote' },
                image: { label: this.trans.block_image || 'Image', icon: 'ti-photo', color: 'type-image' },
                doubleImage: { label: this.trans.block_double_image || 'Double Image', icon: 'ti-photo-scan', color: 'type-image' },
                gallery: { label: this.trans.block_gallery || 'Gallery', icon: 'ti-layout-grid-add', color: 'type-gallery' },
                list: { label: this.trans.block_list || 'List', icon: 'ti-list-check', color: 'type-list' },
                video: { label: this.trans.block_video || 'Video', icon: 'ti-video', color: 'type-video' },
            };
        }

        defaultBlock(type) {
            switch (type) {
                case 'hero':
                    return { type, image: '' };
                case 'heading':
                case 'subheading':
                    return { type, content: '', content_en: '', content_ar: '' };
                case 'paragraph':
                    return { type, content: '', content_en: '', content_ar: '' };
                case 'quote':
                    return { type, content: '', author: '', content_en: '', author_en: '', content_ar: '', author_ar: '' };
                case 'image':
                    return { type, image: '' };
                case 'doubleImage':
                    return { type, image1: '', image2: '' };
                case 'gallery':
                    return { type, images: [] };
                case 'list':
                    return { type, listType: 'unordered', items: [''], items_en: [''], items_ar: [''] };
                case 'video':
                    return { type, url: '', url_en: '', url_ar: '' };
                default:
                    return { type };
            }
        }

        normalizeBlock(block) {
            const type = block?.type || '';
            const base = this.defaultBlock(type);
            const merged = Object.assign({}, base, block || {});

            if (type === 'list') {
                merged.items = toArray(merged.items);
                merged.items_en = toArray(merged.items_en);
                merged.items_ar = toArray(merged.items_ar);
                if (merged.items.length === 0) {
                    merged.items = [''];
                }
            }

            if (type === 'gallery') {
                merged.images = toArray(merged.images);
            }

            return merged;
        }

        hasHero() {
            return this.blocks.some((block) => block.type === 'hero');
        }

        addBlock(type) {
            if (type === 'hero' && this.hasHero()) {
                return;
            }

            this.blocks.push(this.defaultBlock(type));
            this.render();
        }

        removeBlock(index) {
            this.confirm(this.trans.confirm_remove_block || 'Remove this block?')
                .then((confirmed) => {
                    if (!confirmed) {
                        return;
                    }

                    this.blocks.splice(index, 1);
                    this.render();
                });
        }

        moveBlock(index, direction) {
            const newIndex = direction === 'up' ? index - 1 : index + 1;
            if (newIndex < 0 || newIndex >= this.blocks.length) {
                return;
            }

            const moved = this.blocks.splice(index, 1)[0];
            this.blocks.splice(newIndex, 0, moved);
            this.render();
        }

        updateBlockField(index, field, value) {
            if (!this.blocks[index]) {
                return;
            }
            this.blocks[index][field] = value;
            this.sync();
            this.updatePreview();
        }

        updateListItem(index, lang, itemIndex, value) {
            const field = lang === 'en' ? 'items_en' : (lang === 'ar' ? 'items_ar' : 'items');
            if (!Array.isArray(this.blocks[index][field])) {
                this.blocks[index][field] = [];
            }

            this.blocks[index][field][itemIndex] = value;
            this.sync();
            this.updatePreview();
        }

        addListItem(index, lang) {
            const field = lang === 'en' ? 'items_en' : (lang === 'ar' ? 'items_ar' : 'items');
            if (!Array.isArray(this.blocks[index][field])) {
                this.blocks[index][field] = [];
            }

            this.blocks[index][field].push('');
            this.render();
        }

        removeListItem(index, lang, itemIndex) {
            const field = lang === 'en' ? 'items_en' : (lang === 'ar' ? 'items_ar' : 'items');
            if (!Array.isArray(this.blocks[index][field])) {
                return;
            }

            this.blocks[index][field].splice(itemIndex, 1);
            if (this.blocks[index][field].length === 0 && field === 'items') {
                this.blocks[index][field].push('');
            }
            this.render();
        }

        addGalleryImage(index) {
            if (!Array.isArray(this.blocks[index].images)) {
                this.blocks[index].images = [];
            }
            this.blocks[index].images.push('');
            this.render();
        }

        removeGalleryImage(index, imageIndex) {
            this.confirm(this.trans.confirm_remove_image || 'Remove this image?')
                .then((confirmed) => {
                    if (!confirmed) {
                        return;
                    }

                    this.blocks[index].images.splice(imageIndex, 1);
                    this.render();
                });
        }

        buildToolbar(index) {
            return [
                `<button type="button" class="btn btn-sm btn-outline-secondary btn-move-up" data-index="${index}" title="${esc(this.trans.move_up || 'Move up')}"><i class="ti ti-arrow-up"></i></button>`,
                `<button type="button" class="btn btn-sm btn-outline-secondary btn-move-down" data-index="${index}" title="${esc(this.trans.move_down || 'Move down')}"><i class="ti ti-arrow-down"></i></button>`,
                `<button type="button" class="btn btn-sm btn-outline-danger btn-remove-block" data-index="${index}" title="${esc(this.trans.remove_block || 'Remove')}"><i class="ti ti-trash"></i></button>`,
            ].join('');
        }

        buildImageField(index, field, currentPath) {
            const id = `post-block-${index}-${field}`;
            const hasImage = Boolean(currentPath);
            const imagePreview = hasImage ? this.mediaUrl(currentPath) : '';

            return `
                <div id="${id}-existing" style="${hasImage ? '' : 'display:none'}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-secondary-emphasis">${esc(this.trans.change || 'Change')}</small>
                        <button type="button" class="btn btn-sm btn-outline-warning btn-change-image" data-field-id="${id}">
                            <i class="ti ti-edit me-1"></i>${esc(this.trans.change || 'Change')}
                        </button>
                    </div>
                    <img id="${id}-preview-img" src="${esc(imagePreview)}" class="img-thumbnail shadow-sm w-100" style="max-height:160px;object-fit:cover;" alt="">
                </div>
                <div id="${id}-dropzone-wrapper" style="${hasImage ? 'display:none' : ''}">
                    <div id="${id}-dropzone" class="block-dropzone">
                        <div class="dz-message needsclick">
                            <i class="ti ti-cloud-upload" style="font-size:24px;display:block;margin-bottom:4px;"></i>
                            <small>${esc(this.trans.drop_image || 'Drop image or click to upload')}</small>
                        </div>
                    </div>
                    ${hasImage ? `<button type="button" class="btn btn-sm btn-outline-secondary mt-2 btn-cancel-image" data-field-id="${id}"><i class="ti ti-x me-1"></i>${esc(this.trans.cancel || 'Cancel')}</button>` : ''}
                </div>
            `;
        }

        buildFrBlockContent(block, index) {
            switch (block.type) {
                case 'hero':
                    return this.buildImageField(index, 'image', block.image || '');
                case 'heading':
                    return `<input type="text" class="form-control block-input" data-index="${index}" data-field="content" placeholder="${esc(this.trans.heading_placeholder || 'Header text...')}" value="${esc(block.content || '')}">`;
                case 'subheading':
                    return `<input type="text" class="form-control block-input" data-index="${index}" data-field="content" placeholder="${esc(this.trans.subheading_placeholder || 'SubHeader text...')}" value="${esc(block.content || '')}">`;
                case 'paragraph':
                    return `<textarea class="form-control block-tinymce" id="tinymce-fr-${index}" data-index="${index}" data-field="content" rows="6" placeholder="${esc(this.trans.paragraph_placeholder || 'Paragraph...')}">${esc(block.content || '')}</textarea>`;
                case 'quote':
                    return `
                        <textarea class="form-control mb-2 block-input" data-index="${index}" data-field="content" rows="4" placeholder="${esc(this.trans.quote_placeholder || 'Quote...')}">${esc(block.content || '')}</textarea>
                        <input type="text" class="form-control block-input" data-index="${index}" data-field="author" placeholder="Author" value="${esc(block.author || '')}">
                    `;
                case 'image':
                    return this.buildImageField(index, 'image', block.image || block.content || '');
                case 'doubleImage':
                    return `
                        <div class="row g-2">
                            <div class="col-6">${this.buildImageField(index, 'image1', block.image1 || '')}</div>
                            <div class="col-6">${this.buildImageField(index, 'image2', block.image2 || '')}</div>
                        </div>
                    `;
                case 'gallery': {
                    const images = toArray(block.images);
                    const items = images.map((image, imageIndex) => {
                        return `
                            <div class="gallery-image-item">
                                ${this.buildImageField(index, `gallery_${imageIndex}`, image)}
                                <button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remove-gallery-image mt-2" data-index="${index}" data-image-index="${imageIndex}">
                                    <i class="ti ti-trash me-1"></i>${esc(this.trans.remove || 'Remove')}
                                </button>
                            </div>
                        `;
                    }).join('');

                    return `
                        <div class="gallery-images-grid">${items}</div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-gallery-image" data-index="${index}">
                            <i class="ti ti-plus me-1"></i>${esc(this.trans.add_gallery_image || this.trans.add_image || 'Add image')}
                        </button>
                    `;
                }
                case 'list': {
                    const items = toArray(block.items);
                    const options = [
                        ['unordered', 'Unordered'],
                        ['ordered', 'Ordered'],
                        ['checklist_style2', 'Checklist Style 2'],
                        ['checklist_style3', 'Checklist Style 3'],
                        ['checklist_style4', 'Checklist Style 4'],
                        ['checklist_style5', 'Checklist Style 5'],
                        ['checklist_style6', 'Checklist Style 6'],
                    ];

                    return `
                        <div class="mb-2">
                            <label class="form-label">List Type</label>
                            <select class="form-select block-input" data-index="${index}" data-field="listType">
                                ${options.map(([value, label]) => `<option value="${value}" ${block.listType === value ? 'selected' : ''}>${label}</option>`).join('')}
                            </select>
                        </div>
                        <div class="list-items-group">
                            ${items.map((item, itemIndex) => `
                                <div class="d-flex gap-2 mb-2">
                                    <input type="text" class="form-control list-item-input" data-lang="fr" data-index="${index}" data-item-index="${itemIndex}" value="${esc(item || '')}" placeholder="${esc(this.trans.list_placeholder || 'List item...')}">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-list-item" data-lang="fr" data-index="${index}" data-item-index="${itemIndex}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-list-item" data-lang="fr" data-index="${index}">
                            <i class="ti ti-plus me-1"></i>${esc(this.trans.add_list_item || 'Add item')}
                        </button>
                    `;
                }
                case 'video':
                    return `<input type="url" class="form-control block-input" data-index="${index}" data-field="url" placeholder="${esc(this.trans.video_url_placeholder || 'Video URL')}" value="${esc(block.url || '')}">`;
                default:
                    return '';
            }
        }

        buildEnBlockContent(block, index) {
            switch (block.type) {
                case 'heading':
                case 'subheading':
                    return `<input type="text" class="form-control block-input" data-index="${index}" data-field="content_en" placeholder="${esc(this.trans.heading_placeholder || 'Header text...')} (EN)" value="${esc(block.content_en || '')}">`;
                case 'paragraph':
                    return `<textarea class="form-control block-tinymce" id="tinymce-en-${index}" data-index="${index}" data-field="content_en" rows="6" placeholder="${esc(this.trans.paragraph_placeholder || 'Paragraph...')} (EN)">${esc(block.content_en || '')}</textarea>`;
                case 'quote':
                    return `
                        <textarea class="form-control mb-2 block-input" data-index="${index}" data-field="content_en" rows="4" placeholder="${esc(this.trans.quote_placeholder || 'Quote...')} (EN)">${esc(block.content_en || '')}</textarea>
                        <input type="text" class="form-control block-input" data-index="${index}" data-field="author_en" placeholder="Author (EN)" value="${esc(block.author_en || '')}">
                    `;
                case 'list': {
                    const items = toArray(block.items_en);
                    return `
                        <div class="list-items-group">
                            ${items.map((item, itemIndex) => `
                                <div class="d-flex gap-2 mb-2">
                                    <input type="text" class="form-control list-item-input" data-lang="en" data-index="${index}" data-item-index="${itemIndex}" value="${esc(item || '')}" placeholder="${esc(this.trans.list_placeholder || 'List item...')} (EN)">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-list-item" data-lang="en" data-index="${index}" data-item-index="${itemIndex}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-list-item" data-lang="en" data-index="${index}">
                            <i class="ti ti-plus me-1"></i>${esc(this.trans.add_list_item || 'Add item')}
                        </button>
                    `;
                }
                case 'video':
                    return `<input type="url" class="form-control block-input" data-index="${index}" data-field="url_en" placeholder="${esc(this.trans.video_url_placeholder || 'Video URL')} (EN)" value="${esc(block.url_en || '')}">`;
                default:
                    return `<div class="alert alert-secondary mb-0"><i class="ti ti-info-circle me-1"></i>${esc(this.trans.images_lang_independent || 'Images are shared across languages.')}</div>`;
            }
        }

        buildArBlockContent(block, index) {
            switch (block.type) {
                case 'heading':
                case 'subheading':
                    return `<input type="text" class="form-control block-input" dir="rtl" data-index="${index}" data-field="content_ar" placeholder="${esc(this.trans.heading_placeholder || 'Header text...')} (AR)" value="${esc(block.content_ar || '')}">`;
                case 'paragraph':
                    return `<textarea class="form-control block-tinymce" dir="rtl" id="tinymce-ar-${index}" data-index="${index}" data-field="content_ar" rows="6" placeholder="${esc(this.trans.paragraph_placeholder || 'Paragraph...')} (AR)">${esc(block.content_ar || '')}</textarea>`;
                case 'quote':
                    return `
                        <textarea class="form-control mb-2 block-input" dir="rtl" data-index="${index}" data-field="content_ar" rows="4" placeholder="${esc(this.trans.quote_placeholder || 'Quote...')} (AR)">${esc(block.content_ar || '')}</textarea>
                        <input type="text" class="form-control block-input" dir="rtl" data-index="${index}" data-field="author_ar" placeholder="Author (AR)" value="${esc(block.author_ar || '')}">
                    `;
                case 'list': {
                    const items = toArray(block.items_ar);
                    return `
                        <div class="list-items-group" dir="rtl">
                            ${items.map((item, itemIndex) => `
                                <div class="d-flex gap-2 mb-2">
                                    <input type="text" class="form-control list-item-input" dir="rtl" data-lang="ar" data-index="${index}" data-item-index="${itemIndex}" value="${esc(item || '')}" placeholder="${esc(this.trans.list_placeholder || 'List item...')} (AR)">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-list-item" data-lang="ar" data-index="${index}" data-item-index="${itemIndex}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-list-item" data-lang="ar" data-index="${index}">
                            <i class="ti ti-plus me-1"></i>${esc(this.trans.add_list_item || 'Add item')}
                        </button>
                    `;
                }
                case 'video':
                    return `<input type="url" class="form-control block-input" dir="rtl" data-index="${index}" data-field="url_ar" placeholder="${esc(this.trans.video_url_placeholder || 'Video URL')} (AR)" value="${esc(block.url_ar || '')}">`;
                default:
                    return `<div class="alert alert-secondary mb-0"><i class="ti ti-info-circle me-1"></i>${esc(this.trans.images_lang_independent || 'Images are shared across languages.')}</div>`;
            }
        }

        createBlockElement(block, index, lang) {
            const types = this.blockTypes();
            const typeConfig = types[block.type] || { label: block.type, icon: 'ti-box', color: '' };
            const element = document.createElement('div');
            element.className = 'block-item';
            element.dataset.index = String(index);

            let contentHtml = '';
            if (lang === 'fr') {
                contentHtml = this.buildFrBlockContent(block, index);
            } else if (lang === 'ar') {
                contentHtml = this.buildArBlockContent(block, index);
            } else {
                contentHtml = this.buildEnBlockContent(block, index);
            }

            const langLabel = lang === 'en' ? ' (EN)' : (lang === 'ar' ? ' (AR)' : '');

            element.innerHTML = `
                <span class="block-label ${esc(typeConfig.color)}">
                    <i class="ti ${esc(typeConfig.icon)} me-1"></i>${esc(typeConfig.label)}${langLabel}
                </span>
                ${lang === 'fr' ? `<div class="block-toolbar">${this.buildToolbar(index)}</div>` : ''}
                <div class="block-content"${lang === 'ar' ? ' dir="rtl"' : ''}>${contentHtml}</div>
            `;

            return element;
        }

        render() {
            if (!this.frContainer || !this.enContainer) {
                return;
            }

            if (typeof tinymce !== 'undefined') {
                tinymce.remove('.block-tinymce');
            }

            this.frContainer.innerHTML = '';
            this.enContainer.innerHTML = '';
            if (this.arContainer) {
                this.arContainer.innerHTML = '';
            }

            this.blocks.forEach((block, index) => {
                this.frContainer.appendChild(this.createBlockElement(block, index, 'fr'));
                this.enContainer.appendChild(this.createBlockElement(block, index, 'en'));
                if (this.arContainer) {
                    this.arContainer.appendChild(this.createBlockElement(block, index, 'ar'));
                }
            });

            this.bindBlockEvents();
            this.initDropzones();
            this.initTinyMCE();
            this.initSortable();
            this.updateHeroButtonState();
            this.sync();
            this.updatePreview();
        }

        updateHeroButtonState() {
            if (!this.heroButton) {
                return;
            }
            this.heroButton.disabled = this.hasHero();
        }

        bindBlockEvents() {
            this.frContainer.querySelectorAll('.btn-remove-block').forEach((button) => {
                button.addEventListener('click', () => this.removeBlock(Number(button.dataset.index)));
            });

            this.frContainer.querySelectorAll('.btn-move-up').forEach((button) => {
                button.addEventListener('click', () => this.moveBlock(Number(button.dataset.index), 'up'));
            });

            this.frContainer.querySelectorAll('.btn-move-down').forEach((button) => {
                button.addEventListener('click', () => this.moveBlock(Number(button.dataset.index), 'down'));
            });

            document.querySelectorAll('.block-input').forEach((input) => {
                const index = Number(input.dataset.index);
                const field = input.dataset.field;
                if (!field || Number.isNaN(index)) {
                    return;
                }

                input.addEventListener('input', () => this.updateBlockField(index, field, input.value));
                input.addEventListener('change', () => this.updateBlockField(index, field, input.value));
            });

            document.querySelectorAll('.btn-change-image').forEach((button) => {
                button.addEventListener('click', () => {
                    const id = button.dataset.fieldId;
                    const existing = document.getElementById(`${id}-existing`);
                    const dropzone = document.getElementById(`${id}-dropzone-wrapper`);
                    if (existing && dropzone) {
                        existing.style.display = 'none';
                        dropzone.style.display = '';
                    }
                });
            });

            document.querySelectorAll('.btn-cancel-image').forEach((button) => {
                button.addEventListener('click', () => {
                    const id = button.dataset.fieldId;
                    const existing = document.getElementById(`${id}-existing`);
                    const dropzone = document.getElementById(`${id}-dropzone-wrapper`);
                    if (existing && dropzone) {
                        dropzone.style.display = 'none';
                        existing.style.display = '';
                    }
                });
            });

            document.querySelectorAll('.btn-add-gallery-image').forEach((button) => {
                button.addEventListener('click', () => this.addGalleryImage(Number(button.dataset.index)));
            });

            document.querySelectorAll('.btn-remove-gallery-image').forEach((button) => {
                button.addEventListener('click', () => this.removeGalleryImage(Number(button.dataset.index), Number(button.dataset.imageIndex)));
            });

            document.querySelectorAll('.btn-add-list-item').forEach((button) => {
                button.addEventListener('click', () => this.addListItem(Number(button.dataset.index), button.dataset.lang || 'fr'));
            });

            document.querySelectorAll('.btn-remove-list-item').forEach((button) => {
                button.addEventListener('click', () => this.removeListItem(Number(button.dataset.index), button.dataset.lang || 'fr', Number(button.dataset.itemIndex)));
            });

            document.querySelectorAll('.list-item-input').forEach((input) => {
                input.addEventListener('input', () => this.updateListItem(Number(input.dataset.index), input.dataset.lang || 'fr', Number(input.dataset.itemIndex), input.value));
            });
        }

        mediaUrl(path) {
            if (!path) {
                return '';
            }

            if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('//')) {
                return path;
            }

            if (path.startsWith('/')) {
                return path;
            }

            if (path.startsWith('storage/')) {
                return `/${path}`;
            }

            return `/storage/${path}`;
        }

        initDropzones() {
            if (typeof Dropzone === 'undefined') {
                return;
            }

            document.querySelectorAll('.block-dropzone').forEach((element) => {
                if (element.dropzone) {
                    return;
                }

                const id = element.id;
                const match = id.match(/^post-block-(\d+)-(.+)-dropzone$/);
                if (!match) {
                    return;
                }

                const index = Number(match[1]);
                const field = match[2];
                const fieldId = `post-block-${index}-${field}`;

                const dz = new Dropzone(`#${id}`, {
                    url: this.uploadUrl,
                    autoProcessQueue: true,
                    uploadMultiple: false,
                    maxFiles: 1,
                    paramName: 'file',
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    headers: { 'X-CSRF-TOKEN': this.csrfToken },
                    createImageThumbnails: false,
                });

                dz.on('addedfile', () => {
                    dz.files
                        .filter((file, position) => position < dz.files.length - 1)
                        .forEach((file) => dz.removeFile(file));
                });

                dz.on('success', (file, response) => {
                    if (!response || !response.path) {
                        return;
                    }

                    if (field.startsWith('gallery_')) {
                        const imageIndex = Number(field.replace('gallery_', ''));
                        if (!Array.isArray(this.blocks[index].images)) {
                            this.blocks[index].images = [];
                        }
                        this.blocks[index].images[imageIndex] = response.path;
                    } else {
                        this.blocks[index][field] = response.path;
                    }

                    const existing = document.getElementById(`${fieldId}-existing`);
                    const wrapper = document.getElementById(`${fieldId}-dropzone-wrapper`);
                    const preview = document.getElementById(`${fieldId}-preview-img`);
                    if (preview) {
                        preview.src = response.url || this.mediaUrl(response.path);
                    }
                    if (existing) {
                        existing.style.display = '';
                    }
                    if (wrapper) {
                        wrapper.style.display = 'none';
                    }

                    dz.removeAllFiles();
                    this.sync();
                    this.updatePreview();
                });
            });
        }

        initTinyMCE() {
            if (typeof tinymce === 'undefined') {
                return;
            }

            document.querySelectorAll('.block-tinymce').forEach((element) => {
                if (!element.id || tinymce.get(element.id)) {
                    return;
                }

                tinymce.init({
                    selector: `#${element.id}`,
                    menubar: false,
                    height: 220,
                    branding: false,
                    toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                    plugins: ['advlist', 'autolink', 'link', 'lists', 'searchreplace', 'table', 'visualblocks', 'code'],
                    setup: (editor) => {
                        editor.on('change keyup', () => {
                            editor.save();
                            const index = Number(element.dataset.index);
                            const field = element.dataset.field;
                            this.updateBlockField(index, field, editor.getContent());
                        });
                    },
                });
            });
        }

        initSortable() {
            if (typeof Sortable === 'undefined' || !this.frContainer) {
                return;
            }

            if (this.sortable) {
                this.sortable.destroy();
            }

            this.sortable = Sortable.create(this.frContainer, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: (event) => {
                    if (event.oldIndex === event.newIndex) {
                        return;
                    }

                    const moved = this.blocks.splice(event.oldIndex, 1)[0];
                    this.blocks.splice(event.newIndex, 0, moved);
                    this.render();
                },
            });
        }

        sync() {
            if (this.blocksInput) {
                this.blocksInput.value = JSON.stringify(this.blocks);
            }
        }

        renderPreviewBlock(block) {
            const fr = (value) => value || '';

            switch (block.type) {
                case 'hero':
                    return block.image ? `<div class="blog-img mb-4"><img src="${esc(this.mediaUrl(block.image))}" alt=""></div>` : '';
                case 'heading':
                    return `<h2 class="blog-title">${fr(block.content)}</h2>`;
                case 'subheading':
                    return `<h4 class="fw-semibold mb-3">${fr(block.content)}</h4>`;
                case 'paragraph':
                    return `<div class="blog-text mb-3">${fr(block.content)}</div>`;
                case 'quote':
                    return `<blockquote><p>${esc(fr(block.content))}</p>${block.author ? `<cite>${esc(block.author)}</cite>` : ''}</blockquote>`;
                case 'image':
                    return block.image ? `<div class="blog-img mb-4"><img src="${esc(this.mediaUrl(block.image))}" alt=""></div>` : '';
                case 'doubleImage':
                    return `
                        <div class="row g-3 mb-4">
                            <div class="col-6">${block.image1 ? `<img class="img-fluid rounded" src="${esc(this.mediaUrl(block.image1))}" alt="">` : ''}</div>
                            <div class="col-6">${block.image2 ? `<img class="img-fluid rounded" src="${esc(this.mediaUrl(block.image2))}" alt="">` : ''}</div>
                        </div>
                    `;
                case 'gallery': {
                    const images = toArray(block.images).filter(Boolean).map((image) => `<div class="col-4"><img class="img-fluid rounded" src="${esc(this.mediaUrl(image))}" alt=""></div>`).join('');
                    return images ? `<div class="row g-3 mb-4">${images}</div>` : '';
                }
                case 'list': {
                    const items = toArray(block.items).filter((item) => String(item).trim() !== '');
                    const isChecklist = String(block.listType || '').startsWith('checklist');
                    if (items.length === 0) {
                        return '';
                    }
                    if (isChecklist) {
                        return `<div class="checklist style5 mb-3"><ul>${items.map((item) => `<li>${esc(item)}</li>`).join('')}</ul></div>`;
                    }
                    if (block.listType === 'ordered') {
                        return `<ol class="mb-3">${items.map((item) => `<li>${esc(item)}</li>`).join('')}</ol>`;
                    }

                    return `<ul class="mb-3">${items.map((item) => `<li>${esc(item)}</li>`).join('')}</ul>`;
                }
                case 'video':
                    return block.url ? `<p><a href="${esc(block.url)}" target="_blank" rel="noopener noreferrer">${esc(block.url)}</a></p>` : '';
                default:
                    return '';
            }
        }

        updatePreview() {
            if (!this.previewIframe) {
                return;
            }

            const title = document.getElementById('input-title')?.value || '';
            const excerpt = document.getElementById('input-excerpt')?.value || '';
            const content = this.blocks.map((block) => this.renderPreviewBlock(block)).join('');

            const html = `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <link rel="stylesheet" href="${esc(this.assets.bootstrapCss || '')}">
                    <link rel="stylesheet" href="${esc(this.assets.fontawesomeCss || '')}">
                    <link rel="stylesheet" href="${esc(this.assets.guestCss || '')}">
                    <style>
                        body { padding: 16px; overflow-x: hidden; }
                        .preview-wrapper { max-width: 900px; margin: 0 auto; }
                        img { max-width: 100%; height: auto; }
                    </style>
                </head>
                <body>
                    <div class="preview-wrapper th-blog blog-single">
                        <div class="blog-content">
                            <h2 class="blog-title">${esc(title)}</h2>
                            ${excerpt ? `<p class="blog-text">${esc(excerpt)}</p>` : ''}
                            ${content}
                        </div>
                    </div>
                </body>
                </html>
            `;

            const doc = this.previewIframe.contentDocument || this.previewIframe.contentWindow.document;
            doc.open();
            doc.write(html);
            doc.close();

            setTimeout(() => {
                try {
                    this.previewIframe.style.height = `${doc.body.scrollHeight + 30}px`;
                } catch (error) {
                    // No-op.
                }
            }, 180);
        }

        bindPreviewFullscreen() {
            const button = document.getElementById('btn-fullscreen-preview');
            const panel = document.getElementById('preview-panel');
            if (!button || !panel) {
                return;
            }

            button.addEventListener('click', () => {
                panel.classList.toggle('preview-fullscreen');
                const icon = button.querySelector('i');
                if (icon) {
                    icon.className = panel.classList.contains('preview-fullscreen')
                        ? 'ti ti-arrows-minimize'
                        : 'ti ti-arrows-maximize';
                }
                this.updatePreview();
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && panel.classList.contains('preview-fullscreen')) {
                    panel.classList.remove('preview-fullscreen');
                    const icon = button.querySelector('i');
                    if (icon) {
                        icon.className = 'ti ti-arrows-maximize';
                    }
                    this.updatePreview();
                }
            });
        }

        applyTranslatedBlocks(translatedBlocks) {
            if (!Array.isArray(translatedBlocks)) {
                return;
            }

            this.blocks = translatedBlocks.map((block) => this.normalizeBlock(block));
            this.render();
        }

        getBlocks() {
            return this.blocks;
        }

        confirm(message) {
            if (typeof Swal === 'undefined') {
                return Promise.resolve(window.confirm(message));
            }

            return Swal.fire({
                title: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans.remove || 'Remove',
                cancelButtonText: this.trans.cancel || 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-light-danger mx-2',
                    cancelButton: 'btn btn-light-secondary mx-2',
                },
            }).then((result) => result.isConfirmed);
        }
    }

    window.PostBuilder = PostBuilder;
})();
