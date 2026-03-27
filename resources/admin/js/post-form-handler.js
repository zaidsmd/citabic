(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const config = window.postFormConfig || {};
        const trans = config.translations || {};

        if (window.Dropzone) {
            window.Dropzone.autoDiscover = false;
        }

        const postBuilder = new window.PostBuilder(config);
        window.postBuilder = postBuilder;
        postBuilder.init();

        initChoices();
        initFeaturedImageDropzone();
        initTranslationButton();
        initCounters();
        bindFormSubmit();
        bindPreviewTriggers();

        function initChoices() {
            if (typeof Choices === 'undefined') {
                return;
            }

            const choicesConfig = {
                removeItemButton: true,
                duplicateItemsAllowed: false,
                shouldSort: false,
                addItems: true,
                addChoices: true,
                editItems: true,
                placeholder: true,
                placeholderValue: 'Select...',
                searchPlaceholderValue: 'Search...',
                noResultsText: 'No results found',
                noChoicesText: 'No choices available',
                itemSelectText: '',
            };

            const categories = document.getElementById('post-categories');
            const tags = document.getElementById('post-tags');

            if (categories) {
                new Choices(categories, choicesConfig);
            }

            if (tags) {
                new Choices(tags, choicesConfig);
            }
        }

        function resolveMediaUrl(path) {
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

        function initFeaturedImageDropzone() {
            const input = document.getElementById('featured-image-input');
            const previewContainer = document.getElementById('featured-image-preview');
            const dropzoneWrapper = document.getElementById('featured-image-dropzone-wrapper');
            const dropzoneElement = document.getElementById('featured-image-dropzone');
            const cancelButton = document.getElementById('featured-image-cancel-btn');
            if (!input || !previewContainer || !dropzoneWrapper || !dropzoneElement || typeof Dropzone === 'undefined') {
                return;
            }

            const renderPreview = () => {
                const path = input.value;
                if (!path) {
                    previewContainer.innerHTML = '';
                    dropzoneWrapper.style.display = '';
                    return;
                }

                previewContainer.innerHTML = `
                    <div class="block-img-preview">
                        <img src="${resolveMediaUrl(path)}" class="img-thumbnail w-100" style="max-height:180px;object-fit:cover;" alt="">
                        <button type="button" class="btn btn-sm btn-light btn-change-featured">
                            <i class="ti ti-edit me-1"></i>${trans.change || 'Change'}
                        </button>
                    </div>
                `;
                dropzoneWrapper.style.display = 'none';

                const changeButton = previewContainer.querySelector('.btn-change-featured');
                if (changeButton) {
                    changeButton.addEventListener('click', () => {
                        previewContainer.innerHTML = '';
                        dropzoneWrapper.style.display = '';
                    });
                }
            };

            const dropzone = new Dropzone('#featured-image-dropzone', {
                url: config.uploadUrl,
                autoProcessQueue: true,
                uploadMultiple: false,
                maxFiles: 1,
                paramName: 'file',
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                headers: { 'X-CSRF-TOKEN': config.csrfToken || '' },
            });

            dropzone.on('addedfile', () => {
                dropzone.files
                    .filter((file, position) => position < dropzone.files.length - 1)
                    .forEach((file) => dropzone.removeFile(file));
            });

            dropzone.on('success', (file, response) => {
                if (!response || !response.path) {
                    return;
                }

                input.value = response.path;
                dropzone.removeAllFiles();
                renderPreview();
                postBuilder.updatePreview();
            });

            if (cancelButton) {
                cancelButton.addEventListener('click', () => {
                    dropzoneWrapper.style.display = 'none';
                    renderPreview();
                });
            }

            renderPreview();
        }

        function showToast(message, icon) {
            if (typeof Swal === 'undefined') {
                window.alert(message);
                return;
            }

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon || 'success',
                title: message,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });
        }

        function initTranslationButton() {
            const button = document.getElementById('translate-fr-en-btn');
            if (!button || !config.translateUrl) {
                return;
            }

            const titleEn = document.querySelector('input[name="en[title]"]');
            const excerptEn = document.querySelector('textarea[name="en[excerpt]"]');

            button.addEventListener('click', async () => {
                const titleFr = document.getElementById('input-title')?.value || '';
                const excerptFr = document.getElementById('input-excerpt')?.value || '';

                button.disabled = true;
                const originalContent = button.innerHTML;
                button.innerHTML = `<i class="ti ti-loader me-1"></i>${trans.translating || 'Translating...'}`;

                try {
                    const response = await fetch(config.translateUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': config.csrfToken || '',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            title: titleFr,
                            excerpt: excerptFr,
                            blocks: postBuilder.getBlocks(),
                        }),
                    });

                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data?.message || trans.translation_error || 'Translation failed.');
                    }

                    const translated = data?.data || {};
                    if (titleEn) {
                        titleEn.value = translated.title_en || '';
                    }
                    if (excerptEn) {
                        excerptEn.value = translated.excerpt_en || '';
                    }

                    if (Array.isArray(translated.blocks)) {
                        postBuilder.applyTranslatedBlocks(translated.blocks);
                    }

                    showToast(trans.translation_done || 'Translation completed.', 'success');
                } catch (error) {
                    showToast(error?.message || trans.translation_error || 'Translation failed.', 'error');
                } finally {
                    button.disabled = false;
                    button.innerHTML = originalContent;
                }
            });
        }

        function initCounters() {
            const titleInput = document.getElementById('input-title');
            const excerptInput = document.getElementById('input-excerpt');
            const titleCounter = document.getElementById('title-counter');
            const excerptCounter = document.getElementById('excerpt-counter');

            const updateCounter = (input, counter, max) => {
                if (!input || !counter) {
                    return;
                }
                const length = (input.value || '').length;
                counter.textContent = `${length}/${max} characters`;
                counter.classList.toggle('text-danger', length > max);
            };

            if (titleInput) {
                titleInput.addEventListener('input', () => updateCounter(titleInput, titleCounter, 60));
            }
            if (excerptInput) {
                excerptInput.addEventListener('input', () => updateCounter(excerptInput, excerptCounter, 160));
            }

            updateCounter(titleInput, titleCounter, 60);
            updateCounter(excerptInput, excerptCounter, 160);
        }

        function bindFormSubmit() {
            const form = document.getElementById('postForm');
            if (!form) {
                return;
            }

            form.addEventListener('submit', () => {
                postBuilder.sync();
            });
        }

        function bindPreviewTriggers() {
            const previewDrivers = ['input-title', 'input-excerpt'];
            previewDrivers.forEach((id) => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', () => postBuilder.updatePreview());
                }
            });
        }
    });
})();
