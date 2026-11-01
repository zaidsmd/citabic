@extends('guest.layouts.app-template')

@php
    $rawPostDesc = ($post['og_description'] ?? null) ?: (($post['meta_description'] ?? null) ?: ($post['excerpt'] ?? ($post['content'] ?? '')));
    $cleanPostDesc = \Illuminate\Support\Str::limit(trim((string) preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $rawPostDesc), ENT_QUOTES | ENT_HTML5, 'UTF-8'))), 200);
@endphp

@section('title', 'CITABIC | ' . (($post['meta_title'] ?? null) ?: $post['title']))
@section('meta_description', $cleanPostDesc ?: __('site.meta_description'))
@section('meta_keywords', $post['meta_keywords'] ?? '')
@section('meta_robots', (($post['robots_index'] ?? true) ? 'index' : 'noindex') . ',' . (($post['robots_follow'] ?? true) ? 'follow' : 'nofollow'))
@section('canonical_url', (($post['canonical_url'] ?? null) ?: route('blog.show', $post['slug'])))
@section('og_type', 'article')
@section('og_title', (($post['og_title'] ?? null) ?: (($post['meta_title'] ?? null) ?: $post['title'])))
@section('og_description', $cleanPostDesc)
@section('og_url', route('blog.show', $post['slug']))
@section('og_image', (($post['og_image'] ?? null) ?: ($post['image_url'] ?? '')))
@section('twitter_card', (($post['twitter_card'] ?? null) ?: 'summary_large_image'))
@section('twitter_title', (($post['twitter_title'] ?? null) ?: (($post['og_title'] ?? null) ?: (($post['meta_title'] ?? null) ?: $post['title']))))
@section('twitter_description', $cleanPostDesc)
@section('twitter_image', (($post['twitter_image'] ?? null) ?: (($post['og_image'] ?? null) ?: ($post['image_url'] ?? ''))))

@section('structured_data')
    @if(!empty($post['schema_json'] ?? null))
        <script type="application/ld+json">{!! $post['schema_json'] !!}</script>
    @else
        @php
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => (($post['schema_type'] ?? null) ?: 'Article'),
                'headline' => ((($post['meta_title'] ?? null) ?: $post['title'])),
                'description' => ((($post['meta_description'] ?? null) ?: ($post['excerpt'] ?? ''))),
                'datePublished' => ($post['published_at'] ?? null),
                'dateModified' => ($post['updated_at'] ?? null),
                'mainEntityOfPage' => route('blog.show', $post['slug']),
                'image' => ((($post['og_image'] ?? null) ?: ($post['image_url'] ?? null))),
            ];
        @endphp
        <script type="application/ld+json">
            {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endif
@endsection

@section('content')
    @php
        $locale = app()->getLocale();
        $isEnglish = $locale === 'en';
        $blocks = is_array($post['blocks'] ?? null) ? $post['blocks'] : [];

        $publishedAt = ! empty($post['published_at'] ?? null)
            ? \Carbon\Carbon::parse($post['published_at'])
            : (! empty($post['created_at'] ?? null) ? \Carbon\Carbon::parse($post['created_at']) : null);

        $resolveBlockText = function (array $block, string $field = 'content') use ($locale): string {
            $localizedField = $field . '_' . $locale;

            if ($locale !== 'fr' && ! empty($block[$localizedField])) {
                $value = $block[$localizedField];
            } else {
                $value = $block[$field] ?? '';
            }

            return is_string($value) ? $value : '';
        };

        $resolveListItems = function (array $block) use ($locale): array {
            $localizedField = 'items_' . $locale;

            if ($locale !== 'fr' && ! empty($block[$localizedField]) && is_array($block[$localizedField])) {
                return array_values(array_filter($block[$localizedField], fn ($item) => is_string($item) && trim($item) !== ''));
            }

            if (! empty($block['items']) && is_array($block['items'])) {
                return array_values(array_filter($block['items'], fn ($item) => is_string($item) && trim($item) !== ''));
            }

            return [];
        };

        $resolveMediaUrl = function (?string $path): ?string {
            if (! $path) {
                return null;
            }

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
                return $path;
            }

            if (str_starts_with($path, '/')) {
                return $path;
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            return asset('storage/' . ltrim($path, '/'));
        };

        $heroBlock = collect($blocks)->first(fn ($block) => ($block['type'] ?? '') === 'hero' && ! empty($block['image'] ?? null));
        $coverImage = $heroBlock['image'] ?? ($post['image_url'] ?? null);

        $postModel = null;
        $categories = collect();
        $tags = collect();
        $postComments = isset($comments) && $comments instanceof \Illuminate\Support\Collection
            ? $comments
            : collect($comments ?? []);

        if (! empty($post['id'] ?? null)) {
            $postModel = \App\Models\Post::query()
                ->with(['categories:id,name,slug', 'tags:id,name,slug'])
                ->find($post['id']);
            $categories = $postModel?->categories ?? collect();
            $tags = $postModel?->tags ?? collect();
        }
    @endphp

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $post['title'] }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li>{{ $post['title'] }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="th-blog-wrapper blog-details overflow-hidden space-top space-extra2-bottom">
        <div class="container">
            <div class="row gx-40">
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single mb-0 bg-transparent p-0 radius-none">
                        @if(!empty($coverImage))
                            <div class="blog-img">
                                <img src="{{ $resolveMediaUrl($coverImage) }}" alt="{{ $post['title'] }}">
                            </div>
                        @endif
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a class="author" href="#"><i class="far fa-user"></i>{{ $postModel?->author?->name ?? 'Admin' }}</a>
                                @if($publishedAt)
                                    <a href="#"><i class="far fa-clock"></i>{{ $publishedAt->format('d M, Y') }}</a>
                                @endif
                                @if($categories->isNotEmpty())
                                    @php
                                        $primaryCategory = $categories->first();
                                    @endphp
                                    <a href="{{ $primaryCategory ? route('blog.category', $primaryCategory->slug) : '#' }}">
                                        <i class="far fa-house-building"></i>{{ $categories->pluck('name')->join(', ') }}
                                    </a>
                                @endif
                            </div>
                            <h2 class="blog-title">{{ $post['title'] }}</h2>

                            @forelse($blocks as $block)
                                @php
                                    $type = $block['type'] ?? '';
                                @endphp

                                @switch($type)
                                    @case('hero')
                                        @break

                                    @case('heading')
                                        @php
                                            $headingText = $resolveBlockText($block, 'content');
                                        @endphp
                                        @if($headingText !== '')
                                            <h3 class="fw-semibold mb-20 mt-45">{{ $headingText }}</h3>
                                        @endif
                                        @break

                                    @case('subheading')
                                        @php
                                            $subheadingText = $resolveBlockText($block, 'content');
                                        @endphp
                                        @if($subheadingText !== '')
                                            <h4 class="fw-semibold mb-20 mt-35">{{ $subheadingText }}</h4>
                                        @endif
                                        @break

                                    @case('paragraph')
                                        @php
                                            $paragraphText = $resolveBlockText($block, 'content');
                                        @endphp
                                        @if($paragraphText !== '')
                                            <div class="blog-text mb-30">{!! $paragraphText !!}</div>
                                        @endif
                                        @break

                                    @case('quote')
                                        @php
                                            $quoteText = $resolveBlockText($block, 'content');
                                            $quoteAuthor = $resolveBlockText($block, 'author');
                                        @endphp
                                        @if($quoteText !== '')
                                            <blockquote>
                                                <p>{{ $quoteText }}</p>
                                                @if($quoteAuthor !== '')
                                                    <cite>{{ $quoteAuthor }}</cite>
                                                @endif
                                            </blockquote>
                                        @endif
                                        @break

                                    @case('image')
                                        @php
                                            $imageUrl = $resolveMediaUrl($block['image'] ?? ($block['content'] ?? null));
                                        @endphp
                                        @if(!empty($imageUrl))
                                            <div class="blog-img mb-30">
                                                <img src="{{ $imageUrl }}" alt="{{ $post['title'] }}">
                                            </div>
                                        @endif
                                        @break

                                    @case('doubleImage')
                                        @php
                                            $leftImage = $resolveMediaUrl($block['image1'] ?? null);
                                            $rightImage = $resolveMediaUrl($block['image2'] ?? null);
                                        @endphp
                                        @if(!empty($leftImage) || !empty($rightImage))
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    @if(!empty($leftImage))
                                                        <div class="blog-img mb-30">
                                                            <img src="{{ $leftImage }}" alt="{{ $post['title'] }}">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    @if(!empty($rightImage))
                                                        <div class="blog-img mb-30">
                                                            <img src="{{ $rightImage }}" alt="{{ $post['title'] }}">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @break

                                    @case('gallery')
                                        @php
                                            $galleryImages = is_array($block['images'] ?? null) ? $block['images'] : [];
                                        @endphp
                                        @if(count($galleryImages) > 0)
                                            <div class="row gy-4 mb-35">
                                                @foreach($galleryImages as $galleryImage)
                                                    @php
                                                        $galleryUrl = $resolveMediaUrl($galleryImage);
                                                    @endphp
                                                    @if(!empty($galleryUrl))
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="blog-img mb-0">
                                                                <a href="{{ $galleryUrl }}" class="popup-image">
                                                                    <img src="{{ $galleryUrl }}" alt="{{ $post['title'] }}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        @break

                                    @case('list')
                                        @php
                                            $items = $resolveListItems($block);
                                            $listType = $block['listType'] ?? 'unordered';
                                            $checklistClassMap = [
                                                'checklist_style2' => 'style2',
                                                'checklist_style3' => 'style3',
                                                'checklist_style4' => 'style4',
                                                'checklist_style5' => 'style5',
                                                'checklist_style6' => 'style6',
                                                'checklist' => 'style5',
                                            ];
                                            $checklistStyleClass = $checklistClassMap[$listType] ?? 'style5';
                                        @endphp
                                        @if(count($items) > 0)
                                            @if(str_starts_with($listType, 'checklist') || $listType === 'checklist')
                                                <div class="checklist {{ $checklistStyleClass }} mb-30">
                                                    <ul>
                                                        @foreach($items as $item)
                                                            <li>{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @elseif($listType === 'ordered')
                                                <ol class="mb-30 ps-4">
                                                    @foreach($items as $item)
                                                        <li class="mb-2">{{ $item }}</li>
                                                    @endforeach
                                                </ol>
                                            @else
                                                <ul class="mb-30 ps-4">
                                                    @foreach($items as $item)
                                                        <li class="mb-2">{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                        @break

                                    @case('video')
                                        @php
                                            $videoUrl = $block['url'] ?? null;
                                            $embedUrl = null;
                                            $videoId = null;

                                            if (is_string($videoUrl) && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{6,})/', $videoUrl, $matches)) {
                                                $videoId = $matches[1];
                                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                            } elseif (is_string($videoUrl) && preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
                                                $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                            }
                                        @endphp
                                        @if(!empty($videoUrl))
                                            <div class="mb-35">
                                                @if(!empty($embedUrl))
                                                    <div class="ratio ratio-16x9">
                                                        <iframe src="{{ $embedUrl }}" title="{{ $post['title'] }}" allowfullscreen></iframe>
                                                    </div>
                                                @else
                                                    <a href="{{ $videoUrl }}" class="th-btn btn-sm" target="_blank" rel="noopener noreferrer">
                                                        Watch Video
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                        @break
                                @endswitch
                            @empty
                                @if(!empty($post['content'] ?? null))
                                    <div class="blog-text">
                                        {!! nl2br(e($post['content'])) !!}
                                    </div>
                                @endif
                            @endforelse
                        </div>
                    </div>

                    @if($tags->isNotEmpty())
                        <div class="share-links clearfix">
                            <div class="row justify-content-between">
                                <div class="col-md-auto">
                                    <span class="share-links-title">Tags:</span>
                                    <div class="tagcloud">
                                        @foreach($tags as $tag)
                                            <a href="{{ route('blog.tag', $tag->slug) }}">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="th-comments-wrap">
                        <h3 class="blog-inner-title">{{ __('site.blog.comments.title', ['count' => $postComments->count()]) }}</h3>

                        @if($postComments->isEmpty())
                            <p class="mb-0">{{ __('site.blog.comments.empty') }}</p>
                        @else
                            <ul class="comment-list" id="comments-list">
                                @foreach($postComments as $comment)
                                    <li class="th-comment-item">
                                        <div class="th-post-comment">
                                            <div class="comment-avater">
                                                <img src="{{ asset('guest/assets/img/blog/comment-author-1.jpg') }}" alt="Comment Author">
                                            </div>
                                            <div class="comment-content">
                                                <span class="commented-on">{{ $comment->created_at?->format('d M, Y') }}</span>
                                                <h3 class="name">{{ $comment->name }}</h3>
                                                <p class="text">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="th-comment-form">
                        <div class="form-title">
                            <h3 class="blog-inner-title mb-0">{{ __('site.blog.comments.leave_reply') }}</h3>
                            <p class="form-text">{{ __('site.blog.comments.note') }}</p>
                        </div>

                        <div id="comment-success-box" class="alert alert-success mb-3 {{ session('comment_success') ? '' : 'd-none' }}">
                            @if(session('comment_success'))
                                {{ session('comment_success') }}
                            @endif
                        </div>
                        <div id="comment-error-box" class="alert alert-danger mb-3 d-none"></div>

                        <form method="post" action="{{ route('blog.comments.store', $post['slug']) }}" id="blog-comment-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group style-radius style-white">
                                    <i class="far fa-user"></i>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('site.blog.comments.name') }}" class="form-control @error('name') is-invalid @enderror" id="comment-name">
                                    <div class="invalid-feedback" id="error-name">@error('name'){{ $message }}@enderror</div>
                                </div>
                                <div class="col-md-6 form-group style-radius style-white">
                                    <i class="far fa-envelope"></i>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('site.blog.comments.email') }}" class="form-control @error('email') is-invalid @enderror" id="comment-email">
                                    <div class="invalid-feedback" id="error-email">@error('email'){{ $message }}@enderror</div>
                                </div>
                                <div class="col-12 form-group style-radius style-white">
                                    <i class="far fa-pencil"></i>
                                    <textarea name="content" placeholder="{{ __('site.blog.comments.content') }}" class="form-control @error('content') is-invalid @enderror" id="comment-content">{{ old('content') }}</textarea>
                                    <div class="invalid-feedback" id="error-content">@error('content'){{ $message }}@enderror</div>
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <button class="th-btn style-border2 th-btn-icon" type="submit" id="comment-submit-btn">{{ __('site.blog.comments.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_info">
                            <h3 class="widget_title">Post Information</h3>
                            <div class="info-list">
                                <ul>
                                    <li>
                                        <div class="box-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <span class="text">Author:</span>
                                            <strong class="title">{{ $postModel?->author?->name ?? 'Admin' }}</strong>
                                        </div>
                                    </li>
                                    @if($publishedAt)
                                        <li>
                                            <div class="box-icon">
                                                <i class="fas fa-calendar-days"></i>
                                            </div>
                                            <div>
                                                <span class="text">Published:</span>
                                                <strong class="title">{{ $publishedAt->format('d M, Y') }}</strong>
                                            </div>
                                        </li>
                                    @endif
                                    @if(!empty($post['reading_time'] ?? null))
                                        <li>
                                            <div class="box-icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div>
                                                <span class="text">Reading Time:</span>
                                                <strong class="title">{{ (int) $post['reading_time'] }} min</strong>
                                            </div>
                                        </li>
                                    @endif
                                    @if($categories->isNotEmpty())
                                        <li>
                                            <div class="box-icon">
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                            <div>
                                                <span class="text">Category:</span>
                                                <strong class="title">
                                                    @foreach($categories as $index => $category)
                                                        <a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }}</a>{{ $index < $categories->count() - 1 ? ', ' : '' }}
                                                    @endforeach
                                                </strong>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="widget">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                @php
                                    $recentPosts = \App\Models\Post::query()
                                        ->published()
                                        ->where('id', '!=', $post['id'])
                                        ->orderByDesc('published_at')
                                        ->limit(3)
                                        ->get();
                                @endphp
                                @foreach($recentPosts as $recent)
                                    @php
                                        $recentImage = $recent->featured_image;

                                        if (!empty($recentImage) && str_starts_with($recentImage, 'http')) {
                                            $recentImageUrl = $recentImage;
                                        } elseif (!empty($recentImage) && str_starts_with($recentImage, '/')) {
                                            $recentImageUrl = $recentImage;
                                        } elseif (!empty($recentImage) && str_starts_with($recentImage, 'storage/')) {
                                            $recentImageUrl = asset($recentImage);
                                        } elseif (!empty($recentImage)) {
                                            $recentImageUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($recentImage);
                                        } else {
                                            $recentImageUrl = asset('guest/assets/img/blog/recent-post-1-1.jpg');
                                        }
                                    @endphp
                                    <div class="recent-post">
                                        <div class="media-img">
                                            <a href="{{ route('blog.show', $recent->slug) }}">
                                                <img src="{{ $recentImageUrl }}" alt="{{ $recent->title }}">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="post-title"><a class="text-inherit" href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a></h4>
                                            <div class="recent-post-meta">
                                                <a href="#"><i class="fal fa-calendar-alt"></i>{{ $recent->published_at ? $recent->published_at->format('d M, Y') : $recent->created_at->format('d M, Y') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const form = document.getElementById('blog-comment-form');
            if (!form) {
                return;
            }

            const successBox = document.getElementById('comment-success-box');
            const errorBox = document.getElementById('comment-error-box');
            const submitButton = document.getElementById('comment-submit-btn');
            const commentsList = document.getElementById('comments-list');

            const fields = ['name', 'email', 'content'];

            const clearErrors = () => {
                fields.forEach((field) => {
                    const input = document.getElementById(`comment-${field}`);
                    const error = document.getElementById(`error-${field}`);
                    if (input) {
                        input.classList.remove('is-invalid');
                    }
                    if (error) {
                        error.textContent = '';
                    }
                });
                errorBox.classList.add('d-none');
                errorBox.textContent = '';
            };

            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                clearErrors();
                successBox.classList.add('d-none');

                submitButton.disabled = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new FormData(form),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        if (response.status === 422 && data.errors) {
                            Object.entries(data.errors).forEach(([field, messages]) => {
                                const input = document.getElementById(`comment-${field}`);
                                const error = document.getElementById(`error-${field}`);
                                if (input) {
                                    input.classList.add('is-invalid');
                                }
                                if (error) {
                                    error.textContent = Array.isArray(messages) ? messages[0] : messages;
                                }
                            });
                        } else {
                            errorBox.textContent = 'Unable to submit your comment right now.';
                            errorBox.classList.remove('d-none');
                        }

                        return;
                    }

                    successBox.textContent = data.message || 'Comment submitted.';
                    successBox.classList.remove('d-none');
                    form.reset();

                    if (commentsList && data.comment) {
                        const commentItem = document.createElement('li');
                        commentItem.className = 'th-comment-item';
                        commentItem.innerHTML = `
                            <div class="th-post-comment">
                                <div class="comment-avater">
                                    <img src="{{ asset('guest/assets/img/blog/comment-author-1.jpg') }}" alt="Comment Author">
                                </div>
                                <div class="comment-content">
                                    <span class="commented-on">${data.comment.created_at || ''}</span>
                                    <h3 class="name">${data.comment.name || ''}</h3>
                                    <p class="text">${data.comment.content || ''}</p>
                                </div>
                            </div>
                        `;
                        commentsList.prepend(commentItem);
                    }
                } catch (error) {
                    errorBox.textContent = 'Unable to submit your comment right now.';
                    errorBox.classList.remove('d-none');
                } finally {
                    submitButton.disabled = false;
                }
            });
        })();
    </script>
@endpush
