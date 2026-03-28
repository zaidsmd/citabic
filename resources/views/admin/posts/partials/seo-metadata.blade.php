<h5 class="mb-3">
    <i class="fas fa-chart-line"></i> SEO Metadata
</h5>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="fas fa-tag"></i> Meta Title
            </label>
            <input type="text"
                   name="meta_title"
                   class="form-control"
                   value="{{ old('meta_title', $post->meta_title) }}"
                   maxlength="60">
            <small class="form-text text-muted">Recommended: 50-60 characters. Leave empty to use post title.</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="fas fa-link"></i> Canonical URL
            </label>
            <input type="url"
                   name="canonical_url"
                   class="form-control"
                   value="{{ old('canonical_url', $post->canonical_url) }}"
                   placeholder="https://example.com/canonical-url">
            <small class="form-text text-muted">Specify the canonical URL to avoid duplicate content.</small>
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="fas fa-align-left"></i> Meta Description
            </label>
            <textarea name="meta_description"
                      class="form-control"
                      rows="2"
                      maxlength="160">{{ old('meta_description', $post->meta_description) }}</textarea>
            <small class="form-text text-muted">Recommended: 150-160 characters. Briefly describe the post for search engines.</small>
        </div>
    </div>
</div>
