const configElement = document.getElementById("section-content-config");

if (!configElement) {
    throw new Error("Missing section-content-config element.");
}

const config = JSON.parse(configElement.textContent);

const showElement = (element) => {
    if (element) {
        element.classList.remove("d-none");
    }
};

const hideElement = (element) => {
    if (element) {
        element.classList.add("d-none");
    }
};

const keepSingleFile = (dropzoneInstance) => {
    dropzoneInstance.files
        .filter((file, index) => index < dropzoneInstance.files.length - 1)
        .forEach((file) => dropzoneInstance.removeFile(file));
};

const initTinyMce = () => {
    if (typeof tinymce === "undefined") {
        return;
    }

    tinymce.init({
        selector: config.tinyMceSelector,
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
};

const initImageDropzone = (imageKey) => {
    const pathInput = document.getElementById(`${imageKey}-path`);
    const existingElement = document.getElementById(`${imageKey}-existing`);
    const dropzoneWrapper = document.getElementById(`${imageKey}-dropzone-wrapper`);
    const previewImage = document.getElementById(`${imageKey}-preview-img`);
    const dropzoneElement = document.getElementById(`${imageKey}-dropzone`);

    if (!pathInput || !dropzoneElement || typeof Dropzone === "undefined") {
        return;
    }

    const dropzone = new Dropzone(`#${imageKey}-dropzone`, {
        url: config.uploadImageUrl,
        autoProcessQueue: true,
        uploadMultiple: false,
        maxFiles: 1,
        paramName: "image",
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        headers: { "X-CSRF-TOKEN": config.csrfToken },
    });

    dropzone.on("sending", (_, __, formData) => {
        formData.append("key", imageKey);
    });

    dropzone.on("addedfile", () => {
        keepSingleFile(dropzone);
    });

    dropzone.on("success", (_, response) => {
        if (!response?.path) {
            return;
        }

        pathInput.value = response.path;
        if (previewImage) {
            previewImage.src = response.url;
        }

        showElement(existingElement);
        hideElement(dropzoneWrapper);
        dropzone.removeAllFiles();
    });
};

const initVideoDropzone = () => {
    if (typeof Dropzone === "undefined" || !document.getElementById("hero-video-dropzone")) {
        return;
    }

    const dropzone = new Dropzone("#hero-video-dropzone", {
        url: config.uploadVideoUrl,
        autoProcessQueue: true,
        uploadMultiple: false,
        maxFiles: 1,
        paramName: "video",
        acceptedFiles: "video/mp4,video/webm,video/ogg",
        addRemoveLinks: true,
        maxFilesize: 100,
        headers: { "X-CSRF-TOKEN": config.csrfToken },
    });

    dropzone.on("addedfile", () => {
        keepSingleFile(dropzone);
    });

    dropzone.on("success", (_, response) => {
        if (!response?.path) {
            return;
        }

        const heroVideoPath = document.getElementById("hero-video-path");
        const player = document.getElementById("hero-video-preview-player");
        const existingElement = document.getElementById("hero-video-existing");
        const dropzoneWrapper = document.getElementById("hero-video-dropzone-wrapper");

        if (heroVideoPath) {
            heroVideoPath.value = response.path;
        }

        if (player) {
            player.src = response.url;
        }

        showElement(existingElement);
        hideElement(dropzoneWrapper);
        dropzone.removeAllFiles();
    });
};

const initMediaToggles = () => {
    document.querySelectorAll(".media-change-btn").forEach((button) => {
        button.addEventListener("click", () => {
            const key = button.dataset.key;
            hideElement(document.getElementById(`${key}-existing`));
            showElement(document.getElementById(`${key}-dropzone-wrapper`));
        });
    });

    document.querySelectorAll(".media-cancel-btn").forEach((button) => {
        button.addEventListener("click", () => {
            const key = button.dataset.key;
            hideElement(document.getElementById(`${key}-dropzone-wrapper`));
            showElement(document.getElementById(`${key}-existing`));
        });
    });

    const heroChangeButton = document.getElementById("hero-video-change-btn");
    const heroCancelButton = document.getElementById("hero-video-cancel-btn");

    if (heroChangeButton) {
        heroChangeButton.addEventListener("click", () => {
            hideElement(document.getElementById("hero-video-existing"));
            showElement(document.getElementById("hero-video-dropzone-wrapper"));
        });
    }

    if (heroCancelButton) {
        heroCancelButton.addEventListener("click", () => {
            hideElement(document.getElementById("hero-video-dropzone-wrapper"));
            showElement(document.getElementById("hero-video-existing"));
        });
    }
};

const featureCardHtml = (locale, index) => {
    const cardNumber = String(index + 1).padStart(2, "0");

    return `<div class="col-md-6 why-feature-item">
        <div class="card border h-100">
            <div class="card-header bg-transparent border-bottom py-2 d-flex align-items-center justify-content-between">
                <span class="fw-semibold small feature-number"><i class="fa fa-list-ol me-1 text-primary"></i>${cardNumber}</span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-why-feature-btn"><i class="fa fa-trash"></i></button>
            </div>
            <div class="card-body py-2">
                <div class="form-group mb-2">
                    <label class="form-label small fw-semibold">${config.i18n.whyFeatureTitleLabel}</label>
                    <input type="text" name="why_features[${locale}][${index}][title]" class="form-control form-control-sm" placeholder="${config.i18n.whyFeatureTitlePlaceholder}">
                </div>
                <div class="form-group">
                    <label class="form-label small fw-semibold">${config.i18n.whyFeatureTextLabel}</label>
                    <textarea name="why_features[${locale}][${index}][text]" class="form-control form-control-sm" rows="2" placeholder="${config.i18n.whyFeatureTextPlaceholder}"></textarea>
                </div>
            </div>
        </div>
    </div>`;
};

const renumberFeatures = (listElement) => {
    listElement.querySelectorAll(".why-feature-item").forEach((item, index) => {
        const numberElement = item.querySelector(".feature-number");
        if (numberElement) {
            numberElement.innerHTML = `<i class="fa fa-list-ol me-1 text-primary"></i>${String(index + 1).padStart(2, "0")}`;
        }

        const locale = listElement.dataset.locale;
        item.querySelectorAll("input, textarea").forEach((field) => {
            field.name = field.name.replace(/why_features\[[^\]]+\]\[\d+\]/, `why_features[${locale}][${index}]`);
        });
    });

    const emptyState = listElement.querySelector(".why-features-empty");
    if (!emptyState) {
        return;
    }

    if (listElement.querySelectorAll(".why-feature-item").length === 0) {
        showElement(emptyState);
        return;
    }

    hideElement(emptyState);
};

const bindRemoveFeatureButton = (button) => {
    button.addEventListener("click", () => {
        const item = button.closest(".why-feature-item");
        const list = item?.closest(".why-features-list");

        if (!item || !list) {
            return;
        }

        item.remove();
        renumberFeatures(list);
    });
};

const initWhyFeatures = () => {
    document.querySelectorAll(".add-why-feature-btn").forEach((button) => {
        button.addEventListener("click", () => {
            const locale = button.dataset.locale;
            const list = document.querySelector(`.why-features-list[data-locale="${locale}"]`);

            if (!list) {
                return;
            }

            const featureCount = list.querySelectorAll(".why-feature-item").length;
            const emptyState = list.querySelector(".why-features-empty");
            if (emptyState) {
                hideElement(emptyState);
            }

            list.insertAdjacentHTML("beforeend", featureCardHtml(locale, featureCount));
            const removeButton = list.querySelector(".why-feature-item:last-child .remove-why-feature-btn");
            if (removeButton) {
                bindRemoveFeatureButton(removeButton);
            }
        });
    });

    document.querySelectorAll(".remove-why-feature-btn").forEach((button) => {
        bindRemoveFeatureButton(button);
    });
};

const bootstrapPage = () => {
    if (typeof Dropzone !== "undefined") {
        Dropzone.autoDiscover = false;
    }

    initTinyMce();
    config.imageKeys.forEach((imageKey) => initImageDropzone(imageKey));
    initVideoDropzone();
    initMediaToggles();
    initWhyFeatures();
};

bootstrapPage();
