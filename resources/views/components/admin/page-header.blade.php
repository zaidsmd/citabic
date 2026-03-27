@props([
    'title',
    'subtitle' => null,
    'backUrl' => null,
    'backLabel' => null,
    'actionUrl' => null,
    'actionLabel' => null
])

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
            <div>
                <h4 class="fw-bold mb-1">{{ $title }}</h4>
                @if($subtitle)
                    <p class="text-secondary-emphasis mb-0 small">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="d-flex gap-2">
                @if($backUrl)
                    <a href="{{ $backUrl }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-2"></i>
                        {{ $backLabel }}
                    </a>
                @endif

                @if($actionUrl)
                    <a href="{{ $actionUrl }}" class="btn btn-primary px-4">
                        <i class="fa fa-plus me-2"></i>
                        {{ $actionLabel }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
