@props(['key', 'label', 'value' => null, 'uploadRoute', 'size' => null])

<div class="card h-100 border">
    <div class="card-header bg-transparent border-bottom">
        <h6 class="fw-semibold mb-0">
            <i class="fa fa-image me-2 text-primary"></i>
            {{ $label }}
            @if($size)<small class="text-muted fw-normal ms-1">({{ $size }})</small>@endif
        </h6>
    </div>
    <div class="card-body">
        <div id="{{ $key }}-existing" style="{{ empty($value) ? 'display:none' : '' }}">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <p class="text-secondary-emphasis small mb-0">
                    <i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}
                </p>
                <button type="button"
                        class="btn btn-sm btn-outline-warning image-change-btn"
                        data-key="{{ $key }}">
                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                </button>
            </div>
            <img id="{{ $key }}-preview-img"
                 src="{{ !empty($value) ? Storage::disk('public')->url($value) : '' }}"
                 alt="current"
                 class="img-thumbnail shadow-sm w-100"
                 style="max-height:120px; object-fit:cover;">
        </div>
        <div id="{{ $key }}-dropzone-wrapper" style="{{ !empty($value) ? 'display:none' : '' }}">
            <div id="{{ $key }}-dropzone"
                 class="dropzone border-2 border-dashed rounded-3 p-4 text-center"
                 data-key="{{ $key }}"
                 data-upload-url="{{ route($uploadRoute) }}">
                <div class="dz-message needsclick">
                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                </div>
            </div>
            @if(!empty($value))
                <button type="button"
                        class="btn btn-sm btn-outline-secondary mt-2 image-cancel-btn"
                        data-key="{{ $key }}">
                    <i class="fa fa-times me-1"></i>Cancel
                </button>
            @endif
        </div>
        <input type="hidden"
               id="{{ $key }}-path"
               name="{{ $key }}"
               value="{{ $value }}">
    </div>
</div>
