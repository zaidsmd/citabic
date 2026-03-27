@props([
    'name',
    'label',
    'value' => null,
    'required' => false,
    'locale' => null,
    'type' => 'text',
    'errorKey' => null,
    'id' => null,
    'placeholder' => null,
])

@php
    $inputId = $id ?? str_replace(['[', ']', '.'], '_', $name);
    $validationKey = $errorKey ?? $name;
    $inputPlaceholder = $placeholder ?? $label;
@endphp

<div class="form-floating mb-3">
    <input type="{{ $type }}"
           name="{{ $name }}"
           class="form-control @error($validationKey) is-invalid @enderror"
           id="{{ $inputId }}"
           value="{{ old($name, $value) }}"
           placeholder="{{ $inputPlaceholder }}"
           @if($required) required @endif>
    <label class="fw-semibold">
        {{ $label }}
        @if($required)<span class="text-danger">*</span>@endif
    </label>
    @error($validationKey)
    <div class="invalid-feedback">
        <i class="fa fa-exclamation-circle me-1"></i>
        {{ $message }}
    </div>
    @enderror
</div>
