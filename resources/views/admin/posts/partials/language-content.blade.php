@php
    $lang = $lang ?? 'fr';
    $isFrench = $lang === 'fr';
    $titleField = $isFrench ? 'title' : 'en[title]';
    $excerptField = $isFrench ? 'excerpt' : 'en[excerpt]';
    $titleValue = $isFrench
        ? old('title', $post->title)
        : old('en.title', $post->translations['en']['title'] ?? '');
    $excerptValue = $isFrench
        ? old('excerpt', $post->excerpt)
        : old('en.excerpt', $post->translations['en']['excerpt'] ?? '');
@endphp

<div class="p-4">
    <!-- Title -->
    <div class="mb-4">
        <label class="form-label fw-semibold fs-5">
            Title <span class="text-danger">*</span>
        </label>
        <input type="text"
               name="{{ $titleField }}"
               class="form-control form-control-lg @if($isFrench && $errors->has('title')) is-invalid @endif"
               value="{{ $titleValue }}"
               placeholder="Enter post title..."
               autocomplete="off"
               @if($isFrench) required @endif>
        <div class="form-text">A compelling title grabs attention. Keep it under 60 characters for best SEO.</div>
        @if($isFrench && $errors->has('title'))
            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
        @endif
    </div>

    <!-- Excerpt -->
    <div class="mb-4">
        <label class="form-label fw-semibold">
            Excerpt
        </label>
        <textarea name="{{ $excerptField }}"
                  class="form-control"
                  rows="3"
                  placeholder="Write a short summary of your post...">{{ $excerptValue }}</textarea>
        <div class="form-text">A brief summary that appears in post listings and search results.</div>
    </div>
</div>
