@props([
    'saveLabel' => null,
    'cancelLabel' => null,
    'cancelUrl' => null,
    'showReset' => true,
    'resetLabel' => null,
    'additionalActions' => []
])

<div class="card-footer bg-light-subtle border-top p-4">
    <div class="d-flex justify-content-end gap-2">
        @foreach($additionalActions as $action)
            @if(isset($action['url']))
                <a href="{{ $action['url'] }}"
                   class="btn {{ $action['class'] ?? 'btn-outline-secondary' }} px-4">
                    @if(isset($action['icon']))
                        <i class="{{ $action['icon'] }} me-2"></i>
                    @endif
                    {{ $action['label'] }}
                </a>
            @elseif(isset($action['type']) && $action['type'] === 'button')
                <button type="button"
                        class="btn {{ $action['class'] ?? 'btn-outline-secondary' }} px-4"
                        @if(isset($action['onclick'])) onclick="{{ $action['onclick'] }}" @endif>
                    @if(isset($action['icon']))
                        <i class="{{ $action['icon'] }} me-2"></i>
                    @endif
                    {{ $action['label'] }}
                </button>
            @endif
        @endforeach

        @if($showReset)
            <button type="reset" class="btn btn-outline-secondary px-4">
                <i class="fa fa-undo me-2"></i>
                {{ $resetLabel }}
            </button>
        @endif

        @if($cancelUrl)
            <a href="{{ $cancelUrl }}" class="btn btn-outline-secondary px-4">
                <i class="fa fa-times me-2"></i>
                {{ $cancelLabel }}
            </a>
        @endif

        <button type="submit" class="btn btn-primary px-5">
            <i class="fa fa-save me-2"></i>
            {{ $saveLabel }}
        </button>
    </div>
</div>
