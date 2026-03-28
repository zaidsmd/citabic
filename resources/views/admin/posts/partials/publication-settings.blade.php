<!-- Status -->
<div class="mb-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-circle"></i> Status
    </label>
    <select name="status" class="form-select">
        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>📝 Draft</option>
        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>✅ Published</option>
        <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>📦 Archived</option>
    </select>
</div>

<!-- Published At -->
<div class="mb-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-calendar-alt"></i> Published At
    </label>
    <input type="datetime-local"
           name="published_at"
           class="form-control @error('published_at') is-invalid @enderror"
           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
    @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <small class="form-text text-muted">Leave empty for current date/time when publishing.</small>
</div>

<!-- Featured Flag -->
<div class="mb-3 form-check">
    <input type="checkbox"
           name="featured"
           value="1"
           class="form-check-input"
           id="featured"
        {{ old('featured', $post->featured) ? 'checked' : '' }}>
    <label class="form-check-label fw-semibold" for="featured">
        <i class="fas fa-star"></i> Is Featured
    </label>
    <div class="form-text">Feature this post on the homepage or featured sections.</div>
</div>

<!-- Tags -->
<div class="mb-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-hashtag"></i> Tags
    </label>
    <select id="post-tags" name="tags[]" class="form-select" multiple>
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}"
                {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    <small class="form-text text-muted">Add relevant tags to improve discoverability.</small>
</div>
