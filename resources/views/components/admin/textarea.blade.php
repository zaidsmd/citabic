@props([
    'name',
    'label',
    'value' => null,
    'required' => false,
    'locale' => null,
    'rows' => 6,
    'errorKey' => null,
    'id' => null,
    'placeholder' => null,
])

@php
    $textareaId = $id ?? str_replace(['[', ']', '.'], '_', $name);
    $validationKey = $errorKey ?? $name;
@endphp

<div class="mb-3">
    <label class="fw-semibold mb-2">
        {{ $label }}
        @if($required)<span class="text-danger">*</span>@endif
    </label>
    <textarea name="{{ $name }}"
              id="{{ $textareaId }}"
              class="form-control @error($validationKey) is-invalid @enderror"
              rows="{{ $rows }}"
              placeholder="{{ $placeholder }}"
              @if($required) required @endif>{{ old($name, $value) }}</textarea>
    @error($validationKey)
    <div class="invalid-feedback">
        <i class="fa fa-exclamation-circle me-1"></i>
        {{ $message }}
    </div>
    @enderror
</div>
