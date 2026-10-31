document.addEventListener('DOMContentLoaded', function () {
    const config = window.referenceFormConfig || {};
    const trans = config.translations || {};
    const assets = config.assets || {};

    const blockTypes = {
        heroImage:    { label: trans.block_heroImage, icon: 'ti-panorama-horizontal', color: 'type-heroImage' },
        heading:      { label: trans.block_heading, icon: 'ti-heading', color: 'type-heading' },
        subheading:   { label: trans.block_subheading, icon: 'ti-h-4', color: 'type-subheading' },
        text:         { label: trans.block_text, icon: 'ti-align-left', color: 'type-text' },
        image:        { label: trans.block_image, icon: 'ti-photo', color: 'type-image' },
        doubleImage:  { label: trans.block_doubleImage, icon: 'ti-layout-columns', color: 'type-doubleImage' },
        imageTextRow: { label: trans.block_imageTextRow, icon: 'ti-layout-sidebar-right', color: 'type-imageTextRow' },
        coverImage:   { label: trans.block_coverImage, icon: 'ti-photo-filled', color: 'type-coverImage' },
        imageText:    { label: trans.block_imageText, icon: 'ti-layout-sidebar-left-collapse', color: 'type-imageText' },
        list:         { label: trans.block_list, icon: 'ti-list-check', color: 'type-list' },
        gallery:      { label: trans.block_gallery, icon: 'ti-photo-plus', color: 'type-gallery' },
    };

    let blocks = [];
    try {
        const blocksJson = document.getElementById('blocks-json').value;
        blocks = blocksJson ? JSON.parse(blocksJson) : [];
    } catch (e) { blocks = []; }
    if (!Array.isArray(blocks)) blocks = [];

    const container = document.getElementById('blocks-container');
    const containerEn = document.getElementById('blocks-container-en');
    const containerAr = document.getElementById('blocks-container-ar');

    function renderBlocks() {
        container.innerHTML = '';
        containerEn.innerHTML = '';
        if (containerAr) containerAr.innerHTML = '';
        blocks.forEach(function (block, index) {
            container.appendChild(createBlockElement(block, index, 'fr'));
            containerEn.appendChild(createBlockEnElement(block, index));
            if (containerAr) containerAr.appendChild(createBlockArElement(block, index));
        });
        syncJSON();
        updatePreview();
        setTimeout(initDragDrop, 100);
    }

    function confirmAction(message) {
        if (typeof Swal === 'undefined') {
            return Promise.resolve(confirm(message));
        }

        return Swal.fire({
            title: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: trans.remove || 'Remove',
            cancelButtonText: trans.cancel || 'Cancel',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-light-danger mx-2',
                cancelButton: 'btn btn-light-secondary mx-2',
            },
        }).then(function (result) {
            return result.isConfirmed;
        });
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
                contentHtml = '<input type="text" class="form-control" placeholder="' + trans.heading_placeholder + '" value="' + esc(block.content || '') + '" data-field="content">';
                break;
            case 'subheading':
                contentHtml = '<input type="text" class="form-control" placeholder="' + trans.subheading_placeholder + '" value="' + esc(block.content || '') + '" data-field="content">';
                break;
            case 'text':
                contentHtml = '<textarea class="form-control block-tinymce" id="tinymce-' + index + '-content" rows="5" placeholder="' + trans.text_placeholder + '" data-field="content" data-block-index="' + index + '">' + esc(block.content || '') + '</textarea>';
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
                    '<div class="col-7"><textarea class="form-control" rows="4" placeholder="' + trans.text_items_placeholder + '" data-field="content">' + esc(block.content || '') + '</textarea></div>' +
                    '</div>';
                break;
            case 'imageText':
                contentHtml =
                    '<div class="row g-2">' +
                    '<div class="col-5">' + buildDropzoneHtml(index, 'image', block.image || '', 'image') + '</div>' +
                    '<div class="col-7"><textarea class="form-control block-tinymce" id="tinymce-' + index + '-content" rows="4" placeholder="' + trans.text_placeholder + '" data-field="content" data-block-index="' + index + '">' + esc(block.content || '') + '</textarea></div>' +
                    '</div>';
                break;
            case 'list':
                contentHtml = '<textarea class="form-control" rows="5" placeholder="' + trans.list_placeholder + '" data-field="content">' + esc(block.content || '') + '</textarea>';
                break;
            case 'gallery':
                var images = block.images || [];
                contentHtml = '<div class="gallery-images-grid" data-block-index="' + index + '">';
                images.forEach(function (img, gi) {
                    contentHtml += '<div class="gallery-image-item" data-gi="' + gi + '">' +
                        buildDropzoneHtml(index, 'gallery_' + gi, img, 'gallery') +
                        '<button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remove-gallery-img" data-gi="' + gi + '"><i class="ti ti-trash me-1"></i>' + trans.remove + '</button>' +
                        '</div>';
                });
                contentHtml += '</div>';
                contentHtml += '<button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-gallery-img" data-block-index="' + index + '"><i class="ti ti-plus me-1"></i>' + trans.add_image + '</button>';
                break;
        }

        div.innerHTML =
            '<span class="block-label ' + typeConf.color + '"><i class="ti ' + typeConf.icon + ' me-1"></i>' + typeConf.label + '</span>' +
            '<div class="block-toolbar">' +
            '<button type="button" class="btn btn-sm btn-outline-secondary drag-handle" title="' + trans.drag_to_reorder + '"><i class="ti ti-grip-vertical"></i></button>' +
            '<button type="button" class="btn btn-sm btn-outline-secondary btn-move-up" title="' + trans.move_up + '"><i class="ti ti-arrow-up"></i></button>' +
            '<button type="button" class="btn btn-sm btn-outline-secondary btn-move-down" title="' + trans.move_down + '"><i class="ti ti-arrow-down"></i></button>' +
            '<button type="button" class="btn btn-sm btn-outline-danger btn-remove" title="' + trans.remove_block + '"><i class="ti ti-trash"></i></button>' +
            '</div>' +
            '<div class="block-content">' + contentHtml + '</div>';

        div.querySelector('.btn-remove').addEventListener('click', function () {
            confirmAction(trans.confirm_remove_block).then(function (confirmed) {
                if (!confirmed) {
                    return;
                }

                blocks.splice(index, 1);
                renderBlocks();
            });
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
                contentHtml = '<input type="text" class="form-control" placeholder="' + trans.heading_en_placeholder + '" value="' + esc(block.content_en || '') + '" data-field="content_en">';
                break;
            case 'subheading':
                contentHtml = '<input type="text" class="form-control" placeholder="' + trans.subheading_en_placeholder + '" value="' + esc(block.content_en || '') + '" data-field="content_en">';
                break;
            case 'text':
                contentHtml = '<textarea class="form-control block-tinymce" id="tinymce-en-' + index + '-content_en" rows="5" placeholder="' + trans.text_en_placeholder + '" data-field="content_en" data-block-index="' + index + '">' + esc(block.content_en || '') + '</textarea>';
                break;
            case 'imageTextRow':
                contentHtml = '<textarea class="form-control" rows="4" placeholder="' + trans.text_items_en_placeholder + '" data-field="content_en">' + esc(block.content_en || '') + '</textarea>';
                break;
            case 'imageText':
                contentHtml = '<textarea class="form-control block-tinymce" id="tinymce-en-' + index + '-content_en" rows="4" placeholder="' + trans.text_en_placeholder + '" data-field="content_en" data-block-index="' + index + '">' + esc(block.content_en || '') + '</textarea>';
                break;
            case 'list':
                contentHtml = '<textarea class="form-control" rows="5" placeholder="' + trans.list_en_placeholder + '" data-field="content_en">' + esc(block.content_en || '') + '</textarea>';
                break;
            default:
                contentHtml = '<div class="alert alert-secondary mb-0"><i class="ti ti-info-circle me-1"></i>' + trans.images_lang_independent + '</div>';
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

    function createBlockArElement(block, index) {
        const div = document.createElement('div');
        div.className = 'block-item';
        const typeConf = blockTypes[block.type] || { label: block.type, icon: 'ti-box', color: '' };

        let contentHtml = '';
        switch (block.type) {
            case 'heading':
                contentHtml = '<input type="text" class="form-control" dir="rtl" placeholder="' + esc(trans.heading_ar_placeholder || 'Heading (AR)...') + '" value="' + esc(block.content_ar || '') + '" data-field="content_ar">';
                break;
            case 'subheading':
                contentHtml = '<input type="text" class="form-control" dir="rtl" placeholder="' + esc(trans.subheading_ar_placeholder || 'Subheading (AR)...') + '" value="' + esc(block.content_ar || '') + '" data-field="content_ar">';
                break;
            case 'text':
                contentHtml = '<textarea class="form-control block-tinymce" dir="rtl" id="tinymce-ar-' + index + '-content_ar" rows="5" placeholder="' + esc(trans.text_ar_placeholder || 'Text (AR)...') + '" data-field="content_ar" data-block-index="' + index + '">' + esc(block.content_ar || '') + '</textarea>';
                break;
            case 'imageTextRow':
                contentHtml = '<textarea class="form-control" dir="rtl" rows="4" placeholder="' + esc(trans.text_items_ar_placeholder || 'Text (AR)...') + '" data-field="content_ar">' + esc(block.content_ar || '') + '</textarea>';
                break;
            case 'imageText':
                contentHtml = '<textarea class="form-control block-tinymce" dir="rtl" id="tinymce-ar-' + index + '-content_ar" rows="4" placeholder="' + esc(trans.text_ar_placeholder || 'Text (AR)...') + '" data-field="content_ar" data-block-index="' + index + '">' + esc(block.content_ar || '') + '</textarea>';
                break;
            case 'list':
                contentHtml = '<textarea class="form-control" dir="rtl" rows="5" placeholder="' + esc(trans.list_ar_placeholder || 'List (AR)...') + '" data-field="content_ar">' + esc(block.content_ar || '') + '</textarea>';
                break;
            default:
                contentHtml = '<div class="alert alert-secondary mb-0"><i class="ti ti-info-circle me-1"></i>' + (trans.images_lang_independent || 'Images are language independent.') + '</div>';
                break;
        }

        div.innerHTML =
            '<span class="block-label ' + typeConf.color + '"><i class="ti ' + typeConf.icon + ' me-1"></i>' + typeConf.label + ' (AR)</span>' +
            '<div class="block-content" dir="rtl">' + contentHtml + '</div>';

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
        const bootstrapLink = assets.bootstrapCss;
        const iframe = document.getElementById('preview-iframe');

        const getValue = (id) => document.getElementById(id)?.value || '';

        const client = getValue('input-client');
        const surface = getValue('input-surface');
        const budget = getValue('input-budget');

        const wrapImg = (src, alt = 'image', className = 'mb-40') => {
            if (!src) return '';
            return `
            <div class="page-img ${className}">
                <img src="${esc(src)}" alt="${alt}" style="width:100%;height:auto;">
            </div>
        `;
        };

        const renderList = (content) => {
            if (!content) return '';
            return content
                .split('\n')
                .filter(l => l.trim())
                .map(l => `<li>${esc(l.trim())}</li>`)
                .join('');
        };

        const blockRenderers = {
            heroImage: (b) => wrapImg(b.content, 'hero'),
            heading: (b) => `<h2 class="fw-semibold mb-3">${esc(b.content || '')}</h2>`,
            subheading: (b) => `<h4 class="fw-semibold mb-20 mt-50">${esc(b.content || '')}</h4>`,
            text: (b) => `<div class="mb-40">${b.content || ''}</div>`,
            image: (b) => wrapImg(b.content, 'image', 'mb-30'),

            doubleImage: (b) => `
            <div class="row gx-40 gy-40 align-items-center mb-40">
                <div class="col-lg-6">${wrapImg(b.image1, 'image1')}</div>
                <div class="col-lg-6">${wrapImg(b.image2, 'image2')}</div>
            </div>
        `,

            imageTextRow: (b) => `
            <div class="row gx-40 gy-40 align-items-center mb-40">
                <div class="col-xl-5">${wrapImg(b.image)}</div>
                <div class="col-xl-7">
                    <div class="checklist style5">
                        <ul>${renderList(b.content)}</ul>
                    </div>
                </div>
            </div>
        `,

            imageText: (b) => `
            <div class="row gx-40 gy-40 align-items-center mb-40">
                <div class="col-xl-5">${wrapImg(b.image)}</div>
                <div class="col-xl-7">${b.content || ''}</div>
            </div>
        `,

            list: (b) => `
            <div class="checklist style5 mb-40">
                <ul>${renderList(b.content)}</ul>
            </div>
        `,

            gallery: (b) => {
                if (!b.images?.length) return '';
                return `
                <div class="gallery-masonry">
                    ${b.images
                    .filter(Boolean)
                    .map(img => `
                            <div class="gallery-item">
                                <div class="gallery-img-wrapper">
                                    <img src="${esc(img)}" alt="gallery">
                                </div>
                            </div>
                        `).join('')}
                </div>
            `;
            }
        };

        const heroHtml = blocks
            .filter(b => b.type === 'heroImage' && b.content)
            .map(b => blockRenderers.heroImage(b))
            .join('');

        const contentHtml = blocks
            .filter(b => b.type !== 'heroImage')
            .map(b => blockRenderers[b.type]?.(b) || '')
            .join('');

        const buildSidebarItem = (icon, label, value) => `
        <li>
            <div class="box-icon"><i class="${icon}"></i></div>
            <div>
                <span class="text">${label} :</span>
                <strong class="title">${esc(value)}</strong>
            </div>
        </li>
    `;

        const sidebarHtml = `
        <aside class="sidebar-area">
            <div class="widget widget_info">
                <h3 class="widget_title">${trans.sidebar_project_info}</h3>
                <div class="info-list">
                    <ul>
                        ${client ? buildSidebarItem('fas fa-user', trans.sidebar_client, client) : ''}
                        ${surface ? buildSidebarItem('fas fa-layer-group', trans.sidebar_surface, surface) : ''}
                        ${budget ? buildSidebarItem('fas fa-cash-register', trans.sidebar_budget, budget) : ''}
                    </ul>
                </div>
            </div>
        </aside>
    `;

        const fullHtml = `
        <!DOCTYPE html>
        <html>
        <head>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="${bootstrapLink}">
            <link rel="stylesheet" href="${assets.fontawesomeCss}">
            <link rel="stylesheet" href="${assets.guestCss}">
            <style>
                body{padding:15px;overflow-x:hidden;}
                img{max-width:100%;height:auto;}
                .gallery-masonry{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.5rem;margin:2rem 0;}
                .gallery-item{position:relative;overflow:hidden;border-radius:1rem;cursor:pointer;transition:all .4s;background:#f5f5f5;box-shadow:0 8px 20px rgba(0,0,0,.08);}
                .gallery-img-wrapper img{transition:transform .6s ease;}
                .gallery-item:hover{transform:translateY(-6px);box-shadow:0 20px 35px rgba(0,0,0,.15);}
                .gallery-item:hover img{transform:scale(1.05);}
            </style>
        </head>
        <body>
            <section class="project-details-page">
                <div class="container">
                    ${heroHtml}
                    <div class="row">
                        <div class="col-xxl-8 col-lg-8">
                            <div class="page-single mt-30">${contentHtml}</div>
                        </div>
                        <div class="col-xxl-4 col-lg-4">${sidebarHtml}</div>
                    </div>
                </div>
            </section>
        </body>
        </html>
    `;

        const doc = iframe.contentDocument || iframe.contentWindow.document;
        doc.open();
        doc.write(fullHtml);
        doc.close();

        const resize = () => {
            try {
                iframe.style.height = doc.body.scrollHeight + 20 + 'px';
            } catch {}
        };

        iframe.onload = resize;
        setTimeout(resize, 300);
    }
    function initDragDrop() {
        let dragIndex = null;
        const items = container.querySelectorAll('.block-item');
        items.forEach(function (el) {
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

    const uploadUrl = config.uploadUrl;
    const csrfToken = config.csrfToken;

    function buildDropzoneHtml(blockIndex, field, currentValue, type) {
        const dzId = 'dz-' + blockIndex + '-' + field;
        if (currentValue) {
            return '<div class="block-img-preview" id="' + dzId + '-preview">' +
                '<img src="' + esc(currentValue) + '" alt="">' +
                '<button type="button" class="btn btn-sm btn-light btn-change-img" data-dz-id="' + dzId + '" data-block="' + blockIndex + '" data-field="' + field + '"><i class="ti ti-edit me-1"></i>' + trans.change + '</button>' +
                '</div>' +
                '<div id="' + dzId + '" class="block-dropzone" style="display:none">' +
                '<div class="dz-message"><i class="ti ti-cloud-upload" style="font-size:24px;display:block;margin-bottom:4px;"></i><small>' + trans.drop_image + '</small></div>' +
                '</div>';
        }
        return '<div class="block-img-preview" id="' + dzId + '-preview" style="display:none">' +
            '<img src="" alt="">' +
            '<button type="button" class="btn btn-sm btn-light btn-change-img" data-dz-id="' + dzId + '" data-block="' + blockIndex + '" data-field="' + field + '"><i class="ti ti-edit me-1"></i>' + trans.change + '</button>' +
            '</div>' +
            '<div id="' + dzId + '" class="block-dropzone">' +
            '<div class="dz-message"><i class="ti ti-cloud-upload" style="font-size:24px;display:block;margin-bottom:4px;"></i><small>' + trans.drop_image + '</small></div>' +
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
                confirmAction(trans.confirm_remove_image).then(function (confirmed) {
                    if (!confirmed) {
                        return;
                    }

                    var gi = parseInt(this.dataset.gi);
                    var container = this.closest('.gallery-images-grid');
                    var idx = parseInt(container.dataset.blockIndex);
                    blocks[idx].images.splice(gi, 1);
                    renderBlocks();
                }.bind(this));
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
