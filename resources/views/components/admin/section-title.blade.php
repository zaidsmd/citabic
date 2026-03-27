@props([
    'icon' => 'fa fa-circle',
    'title',
    'subtitle' => null,
    'class' => '',
])

<div @class(['section-title', 'mb-4', $class])>
    <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap">
        <h6 class="fw-bold text-primary mb-0">
            <i class="{{ $icon }} me-2"></i>
            {{ $title }}
        </h6>
        @if(!empty($subtitle))
            <small class="text-secondary-emphasis">{{ $subtitle }}</small>
        @endif
    </div>
    <hr class="mt-3 mb-0 border-primary opacity-25 border-2">
</div>
