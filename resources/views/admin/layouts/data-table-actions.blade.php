@forelse($actions ?? [] as $action)
    @switch($action['type'] ?? null)
        @case('button')
            <button class="btn {{ $action['classNames'] ?? '' }} me-1"
            @foreach($action['attributes'] ?? [] as $attr => $val) {{ $attr }}="{{ $val }}" @endforeach>
            @if($action['icon'] ?? false) <i class="{{$action['icon'] }}"></i> @endif
            {{ $action['label'] ?? '' }}
            </button>
            @break

        @case('link')
            <a href="{{ $action['link'] ?? '#' }}" target="{{ $action['target'] ?? '_self' }}"
               class="btn {{ $action['classNames'] ?? '' }} me-1"
            @foreach($action['attributes'] ?? [] as $attr => $val) {{ $attr }}="{{ $val }}" @endforeach>
            @if($action['icon'] ?? false) <i class="{{$action['icon'] }}"></i> @endif
            {{ $action['label'] ?? '' }}
            </a>
            @break

        @case('destroy')
            <button data-table-action="delete" data-href="{{ $action['link'] ?? '#' }}"
                    class="btn btn-sm btn-light-danger me-1" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="{{ __('admin.common.delete') }}"
                    aria-label="{{ __('admin.common.delete') }}">
                <i class="fa fa-trash-alt"></i>
                @if($action['label'] ?? false) {{ $action['label'] }} @endif
            </button>
            @break
    @endswitch
@empty
@endforelse
