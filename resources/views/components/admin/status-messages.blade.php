@props(['status' => null, 'error' => null, 'errors' => []])

@php
    $status = $status ?? session('status');
    $error = $error ?? session('error');
    $errors = $errors ?? session('errors')?->all() ?? [];
@endphp

@if($status)
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fa fa-check-circle fs-5 me-2"></i>
            <span>{{ $status }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($error)
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fa fa-exclamation-triangle fs-5 me-2"></i>
            <span>{{ $error }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors && count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="fa fa-exclamation-triangle fs-5 me-2 mt-1"></i>
            <div>
                <strong>{{ __('admin.common.fix_errors') }}</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
