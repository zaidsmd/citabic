@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css"/>
@endpush

@php($isEdit = $mission->exists)

@section('title', $isEdit ? __('admin.missions.form.title_edit') : __('admin.missions.form.title_create'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.missions.update', $mission) : route('admin.missions.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <x-admin.page-header
                    :title="$isEdit ? __('admin.missions.form.title_edit') : __('admin.missions.add_item')"
                    :subtitle="$isEdit ? __('admin.missions.form.subtitle_edit') : __('admin.missions.form.subtitle_create')"
                    :back-url="route('admin.missions.index')"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="border rounded p-3 h-100">
                                        <x-admin.text-input
                                            name="fr[title]"
                                            :label="__('admin.missions.form.title_fr')"
                                            :value="$form['fr']['title']"
                                            :error-key="'fr.title'"/>
                                        <x-admin.textarea
                                            name="fr[description]"
                                            :label="__('admin.missions.form.description_fr')"
                                            :value="$form['fr']['description']"
                                            :error-key="'fr.description'"
                                            :rows="5"
                                            :floating="true"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="border rounded p-3 h-100">
                                        <x-admin.text-input
                                            name="en[title]"
                                            :label="__('admin.missions.form.title_en')"
                                            :value="$form['en']['title']"
                                            :error-key="'en.title'"/>
                                        <x-admin.textarea
                                            name="en[description]"
                                            :label="__('admin.missions.form.description_en')"
                                            :value="$form['en']['description']"
                                            :error-key="'en.description'"
                                            :rows="5"
                                            :floating="true"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="border rounded p-3 h-100">
                                        <x-admin.text-input
                                            name="ar[title]"
                                            :label="__('admin.missions.form.title_ar')"
                                            :value="$form['ar']['title']"
                                            :error-key="'ar.title'"/>
                                        <x-admin.textarea
                                            name="ar[description]"
                                            :label="__('admin.missions.form.description_ar')"
                                            :value="$form['ar']['description']"
                                            :error-key="'ar.description'"
                                            :rows="5"
                                            :floating="true"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">{{ __('admin.missions.form.icon_image') }}</h6>
                                <input type="hidden" name="icon" id="icon-path" value="{{ $form['icon'] }}">
                                <div id="icon-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                                    <div class="dz-message needsclick">
                                        <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                                        <div class="fw-semibold">{{ __('admin.missions.form.drop_icon') }}</div>
                                    </div>
                                </div>
                                <div id="icon-preview" class="mt-3 text-center" style="{{ empty($form['icon']) ? 'display:none' : '' }}">
                                    <p class="text-secondary-emphasis small mb-2">{{ __('admin.missions.form.current_image') }}</p>
                                    <img id="icon-preview-img"
                                         src="{{ !empty($form['icon']) ? Storage::disk('public')->url($form['icon']) : '' }}"
                                         alt="current" class="img-thumbnail shadow-sm" style="max-height:80px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">{{ __('admin.common.save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/build/js/plugins/dropzone-amd-module.min.js')}}"></script>
    <script>
        Dropzone.autoDiscover = false;
        const uploadUrl = '{{ route('admin.missions.upload-image') }}';
        const csrfToken = "{{ csrf_token() }}";

        const init_dropzone = (img) => {
            const pathInput = document.getElementById(`${img}-path`);
            const previewDiv = document.getElementById(`${img}-preview`);
            const previewImg = document.getElementById(`${img}-preview-img`);

            if (typeof Dropzone === 'undefined') {
                return;
            }

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

            dz.on('addedfile', () => {
                dz.files
                    .filter((file, index) => index < dz.files.length - 1)
                    .forEach((file) => dz.removeFile(file));
            });

            dz.on('success', (file, response) => {
                if (response.path) {
                    pathInput.value = response.path;
                    previewImg.src = response.url;
                    previewDiv.style.display = '';
                }
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
