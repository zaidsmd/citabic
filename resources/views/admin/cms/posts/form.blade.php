@extends('admin.layouts.master')

@php($isEdit = isset($post) && $post->exists)
@php($featuredImageValue = old('featured_image', $post->featured_image))

@section('title', $isEdit ? 'Edit Post' : 'Create Post')

@section('css')
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css" />
@endsection

@section('content')
    <x-breadcrumb item="CMS" active="{{ $isEdit ? 'Edit Post' : 'Create Post' }}"/>

    <div class="row">
        <div class="col-sm-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form id="post-form" action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $isEdit ? 'Edit Post' : 'Add New Post' }}</h5>
                        <div>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-light-secondary me-1">Back to List</a>
                            <button type="submit" class="btn btn-sm btn-primary">Save Post</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="postTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content" aria-selected="true">French (Default)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="false">English</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="postTabsContent">
                            <div class="tab-pane fade show active" id="fr-content" role="tabpanel" aria-labelledby="fr-tab">
                                <div class="mb-3">
                                    <label class="form-label">Title (FR)</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Excerpt (FR)</label>
                                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                                    @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Content (FR)</label>
                                    <textarea id="post-content-fr" name="content" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content', $post->content) }}</textarea>
                                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="tab-pane fade" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                                <div class="mb-3">
                                    <label class="form-label">Title (EN)</label>
                                    <input type="text" name="en[title]" class="form-control" value="{{ old('en.title', $post->translations['en']['title'] ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Excerpt (EN)</label>
                                    <textarea name="en[excerpt]" class="form-control" rows="3">{{ old('en.excerpt', $post->translations['en']['excerpt'] ?? '') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Content (EN)</label>
                                    <textarea id="post-content-en" name="en[content]" class="form-control" rows="10">{{ old('en.content', $post->translations['en']['content'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Slug (Optional, auto-generated if empty)</label>
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug) }}">
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Featured Image</label>
                                    <input type="hidden" id="featured_image" name="featured_image" value="{{ $featuredImageValue }}">
                                    <div id="featured-image-dropzone" class="dropzone border rounded p-3">
                                        <div class="fallback">
                                            <input name="file" type="file" />
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Upload one image (max 5MB). Uploading a new file replaces the current image.</small>
                                    @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categories</label>
                                    <select id="post-categories" name="categories[]" class="form-select" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Published At</label>
                                            <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                                            @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" {{ old('featured', $post->featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">Is Featured</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tags (Optional)</label>
                                    <select id="post-tags" name="tags[]" class="form-select" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>SEO Metadata</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Canonical URL</label>
                                    <input type="text" name="canonical_url" class="form-control" value="{{ old('canonical_url', $post->canonical_url) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $post->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/build/js/plugins/tinymce/tinymce.min.js"></script>
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <script src="/build/js/plugins/choices.min.js"></script>
    <script>
      Dropzone.autoDiscover = false;

      document.addEventListener('DOMContentLoaded', function () {
        tinymce.init({
          selector: '#post-content-fr, #post-content-en',
          height: 360,
          menubar: false,
          plugins: 'advlist autolink link image lists charmap print preview code',
          toolbar: [
            'styleselect fontselect fontsizeselect',
            'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
            'bullist numlist | outdent indent | blockquote | charmap | print preview | code'
          ],
          content_style: 'body { font-family: "Inter", sans-serif; }'
        });

        ['#post-categories', '#post-tags'].forEach(function (selector) {
          var element = document.querySelector(selector);
          if (!element) {
            return;
          }

          new Choices(element, {
            removeItemButton: true,
            searchPlaceholderValue: 'Search...',
            noResultsText: 'No results found'
          });
        });

        var featuredInput = document.getElementById('featured_image');
        var currentImage = featuredInput ? featuredInput.value : '';
        var existingMockFile = null;

        var featuredDropzone = new Dropzone('#featured-image-dropzone', {
          url: '{{ route('admin.posts.upload-featured-image') }}',
          maxFiles: 1,
          acceptedFiles: 'image/*',
          addRemoveLinks: true,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        });

        featuredDropzone.on('success', function (file, response) {
          featuredInput.value = response.path || '';

          if (existingMockFile && file !== existingMockFile) {
            featuredDropzone.removeFile(existingMockFile);
            existingMockFile = null;
          }

          featuredDropzone.files.forEach(function (dzFile) {
            if (dzFile !== file) {
              featuredDropzone.removeFile(dzFile);
            }
          });
        });

        featuredDropzone.on('maxfilesexceeded', function (file) {
          featuredDropzone.removeAllFiles(true);
          featuredDropzone.addFile(file);
        });

        featuredDropzone.on('removedfile', function (file) {
          if (file === existingMockFile || file.status === 'success') {
            featuredInput.value = '';
          }
        });

        if (currentImage) {
          var existingUrl = currentImage;
          if (!currentImage.startsWith('http') && !currentImage.startsWith('/')) {
            existingUrl = currentImage.startsWith('storage/') ? '/' + currentImage : '/storage/' + currentImage;
          }
          existingMockFile = { name: 'featured-image', size: 1234, accepted: true };
          featuredDropzone.emit('addedfile', existingMockFile);
          featuredDropzone.emit('thumbnail', existingMockFile, existingUrl);
          featuredDropzone.emit('complete', existingMockFile);
          existingMockFile.status = 'success';
          existingMockFile.previewElement.classList.add('dz-success', 'dz-complete');
          featuredDropzone.files.push(existingMockFile);
        }

        var postForm = document.getElementById('post-form');
        if (postForm) {
          postForm.addEventListener('submit', function () {
            tinymce.triggerSave();
          });
        }
      });
    </script>
@endsection
