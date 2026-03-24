@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush
@php($isEdit = $mission->exists)
@section('title', $isEdit ? 'Edit Mission' : 'Create Mission')
@section('content')
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <x-breadcrumb item="Missions" active="{{ $isEdit ? 'Edit Mission' : 'Create Mission' }}"/>
                <form action="{{ $isEdit ? route('admin.missions.update', $mission) : route('admin.missions.store') }}" method="POST">
                    @csrf
                    @if($isEdit) @method('PUT') @endif

                    <!-- Header Card -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
                                <div>
                                    <h4 class="fw-bold mb-1">
                                        <i class="fa fa-flag me-2 text-primary"></i>
                                        {{ $isEdit ? 'Edit Mission' : 'Add New Mission' }}
                                    </h4>
                                    <p class="text-secondary-emphasis mb-0 small">
                                        {{ $isEdit ? 'Update mission information below' : 'Create a new mission with its content' }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.missions.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa fa-arrow-left me-2"></i>Back to List
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fa fa-save me-2"></i>{{ $isEdit ? 'Update Mission' : 'Save Mission' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row g-4">
                        <!-- Left Column: Language Content -->
                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <!-- Language Tabs -->
                                    <ul class="nav nav-tabs border-bottom mb-4" id="missionTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active fw-semibold" id="fr-tab" data-bs-toggle="tab"
                                                    data-bs-target="#fr-content" type="button" role="tab">
                                                <i class="fa fa-language me-2"></i>French (Default)
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link fw-semibold" id="en-tab" data-bs-toggle="tab"
                                                    data-bs-target="#en-content" type="button" role="tab">
                                                <i class="fa fa-language me-2"></i>English
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="missionTabsContent">
                                        <!-- French -->
                                        <div class="tab-pane fade show active" id="fr-content" role="tabpanel">
                                            <div class="mb-3">
                                                <label for="titleFr" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                                <input type="text" name="fr[title]" id="titleFr"
                                                       class="form-control @error('fr.title') is-invalid @enderror"
                                                       value="{{ $form['fr']['title'] }}" placeholder="Mission title in French">
                                                @error('fr.title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="descFr" class="form-label fw-semibold">Description</label>
                                                <textarea name="fr[description]" id="descFr" rows="5"
                                                          class="form-control @error('fr.description') is-invalid @enderror"
                                                          placeholder="Mission description in French">{{ $form['fr']['description'] }}</textarea>
                                                @error('fr.description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- English -->
                                        <div class="tab-pane fade" id="en-content" role="tabpanel">
                                            <div class="mb-3">
                                                <label for="titleEn" class="form-label fw-semibold">Title</label>
                                                <input type="text" name="en[title]" id="titleEn"
                                                       class="form-control @error('en.title') is-invalid @enderror"
                                                       value="{{ $form['en']['title'] }}" placeholder="Mission title in English">
                                                @error('en.title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="descEn" class="form-label fw-semibold">Description</label>
                                                <textarea name="en[description]" id="descEn" rows="5"
                                                          class="form-control @error('en.description') is-invalid @enderror"
                                                          placeholder="Mission description in English">{{ $form['en']['description'] }}</textarea>
                                                @error('en.description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Images & Settings -->
                        <div class="col-lg-4">
                            <!-- Order -->
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold mb-3"><i class="fa fa-sort me-2 text-primary"></i>Display Order</h6>
                                    <input type="number" name="order" id="order"
                                           class="form-control @error('order') is-invalid @enderror"
                                           value="{{ $form['order'] }}" min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Icon Image -->
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold mb-3"><i class="fa fa-star me-2 text-primary"></i>Icon Image</h6>
                                    <input type="hidden" name="icon" id="icon-path" value="{{ $form['icon'] }}">
                                    <div id="icon-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                        <div class="dz-message needsclick">
                                            <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                            <div class="fw-semibold">Drop icon here or click to upload</div>
                                            <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                                        </div>
                                    </div>
                                    <div id="icon-preview" class="mt-3 text-center" style="{{ empty($form['icon']) ? 'display:none' : '' }}">
                                        <p class="text-secondary-emphasis small mb-2">Current Image</p>
                                        <img id="icon-preview-img"
                                             src="{{ !empty($form['icon']) ? Storage::disk('public')->url($form['icon']) : '' }}"
                                             alt="current" class="img-thumbnail shadow-sm" style="max-height:80px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        const uploadUrl = '{{ route('admin.missions.upload-image') }}';
        const csrfToken = "{{ csrf_token() }}";

        const init_dropzone = (img) => {
            const pathInput = document.getElementById(`${img}-path`);
            const previewDiv = document.getElementById(`${img}-preview`);
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
                    previewDiv.style.display = '';
                }
            });

            dz.on('error', (file, message, xhr) => {
                console.error('Upload error for', img, ':', message, xhr ? xhr.responseText : '');
            });

            dz.on('removedfile', () => {
                if (dz.files.length === 0) {
                    pathInput.value = '';
                    previewDiv.style.display = 'none';
                }
            });
        };

        init_dropzone('icon');
    </script>
@endpush
