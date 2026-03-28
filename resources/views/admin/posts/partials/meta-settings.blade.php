<!-- Featured Image -->
<div class="mb-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-image"></i> Featured Image
    </label>
    <input type="hidden" id="featured_image" name="featured_image" value="{{ old('featured_image', $post->featured_image) }}">
    <div id="featured-image-dropzone" class="dropzone border rounded p-3">
        <div class="fallback">
            <input name="file" type="file" />
        </div>
        <div class="dz-message" data-dz-message>
            <i class="fas fa-cloud-upload-alt fa-2x"></i>
            <p>Drag & drop or click to upload featured image</p>
        </div>
    </div>
    <small class="form-text text-muted">Recommended size: 1200x630px. Max 5MB.</small>
    @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Categories -->
<div class="mb-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-tags"></i> Categories
    </label>
    <select id="post-categories" name="categories[]" class="form-select" multiple>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <small class="form-text text-muted">Select one or more categories.</small>
</div>
