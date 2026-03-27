@props([
    'contentKey',
    'label',
    'path' => null,
    'url' => null,
    'size' => null,
    'maxHeightClass' => 'media-preview-standard',
])

<div class="card h-100 border">
    <div class="card-header bg-transparent border-bottom">
        <h6 class="fw-semibold mb-0">
            <i class="fa fa-image me-2 text-primary"></i>
            {{ $label }}
            @if ($size)
                <small class="text-muted fw-normal">{{ $size }}</small>
            @endif
        </h6>
    </div>
    <div class="card-body">
        <div id="{{ $contentKey }}-existing" @class(['d-none' => blank($path)])>
            <div class="d-flex align-items-center justify-content-between mb-2">
                <p class="text-secondary-emphasis small mb-0">
                    <i class="fa fa-check-circle text-success me-1"></i>{{ __('admin.common.current') }}
                </p>
                <button type="button" class="btn btn-sm btn-outline-warning media-change-btn" data-key="{{ $contentKey }}">
                    <i class="fa fa-pencil me-1"></i>@lang('admin.common.change')
                </button>
            </div>
            <img id="{{ $contentKey }}-preview-img"
                 src="{{ $url ?? '' }}"
                 alt="current"
                 class="img-thumbnail shadow-sm w-100 media-preview {{ $maxHeightClass }}">
        </div>
        <div id="{{ $contentKey }}-dropzone-wrapper" @class(['d-none' => filled($path)])>
            <div id="{{ $contentKey }}-dropzone" class="dropzone border-2 border-dashed rounded-3 p-4 text-center">
                <div class="dz-message needsclick">
                    <i class="fa fa-cloud-upload fs-1 text-secondary mb-3"></i>
                    <div class="fw-semibold">{{ __('admin.certification.form.dropzone.prompt') }}</div>
                    <small class="text-secondary-emphasis d-block mt-1">Click or drag to upload</small>
                </div>
            </div>
            @if (filled($path))
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2 media-cancel-btn" data-key="{{ $contentKey }}">
                    <i class="fa fa-times me-1"></i>{{ __('admin.common.cancel') }}
                </button>
            @endif
        </div>
        <input type="hidden" id="{{ $contentKey }}-path" name="{{ $contentKey }}" value="{{ $path ?? '' }}">
    </div>
</div>
