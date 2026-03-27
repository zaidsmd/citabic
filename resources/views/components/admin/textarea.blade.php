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
    'floating' => false,
])

@php
    $textareaId = $id ?? str_replace(['[', ']', '.'], '_', $name);
    $validationKey = $errorKey ?? $name;
@endphp

<div class="mb-3">
    @if($floating)
    <div class="form-floating">
        <textarea name="{{ $name }}"
                  id="{{ $textareaId }}"
                  class="form-control @error($validationKey) is-invalid @enderror"
                  rows="{{ $rows }}"
                  placeholder="{{ $placeholder }}"
                  @if($required) required @endif>{{ old($name, $value) }}</textarea>
        <label class="fw-semibold" for="{{ $textareaId }}">
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
    @else
    <label class="fw-semibold mb-2" for="{{ $textareaId }}">
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
    @endif
</div>
