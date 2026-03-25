@extends('guest.layouts.app-template')

@section('title', 'CITABIC | Blog')

@section('content')
    @php
        $postIds = collect($posts)->pluck('id')->filter()->all();
        $postMeta = \App\Models\Post::query()
            ->with(['author:id,name', 'categories:id,name,slug', 'tags:id,name,slug'])
            ->whereIn('id', $postIds)
            ->get()
            ->keyBy('id');

        $recentPosts = \App\Models\Post::query()
            ->published()
            ->with('author:id,name')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $popularCategories = \App\Models\Category::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(6)
            ->get();

        $popularTags = \App\Models\Tag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(8)
            ->get();

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
    @endphp

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Blog</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                    <li>Blog</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="th-blog-wrapper space-top space-extra2-bottom">
        <div class="container">
            <div class="row gx-40">
                <div class="col-xxl-8 col-lg-7">
                    @forelse ($posts as $post)
                        @php
                            $postModel = $postMeta->get($post['id'] ?? null);
                            $publishedAt = !empty($post['published_at'] ?? null)
                                ? \Carbon\Carbon::parse($post['published_at'])
                                : (!empty($post['created_at'] ?? null) ? \Carbon\Carbon::parse($post['created_at']) : null);
                            $excerpt = $post['excerpt'] ?? \Illuminate\Support\Str::limit(strip_tags($post['content'] ?? ''), 220);
                            $coverImage = $post['image_url'] ?? null;
                        @endphp
                        <div class="th-blog blog-single has-post-thumbnail">
                            @if(!empty($coverImage))
                                <div class="blog-img">
                                    <a href="{{ route('blog.show', $post['slug']) }}">
                                        <img src="{{ $resolveMediaUrl($coverImage) }}" alt="{{ $post['title'] }}">
                                    </a>
                                </div>
                            @endif
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <a class="author" href="#"><i class="far fa-user"></i>by {{ $postModel?->author?->name ?? 'Admin' }}</a>
                                    @if($publishedAt)
                                        <a href="#"><i class="far fa-clock"></i>{{ $publishedAt->format('d M, Y') }}</a>
                                    @endif
                                    @if($postModel && $postModel->categories->isNotEmpty())
                                        <a href="#"><i class="far fa-house-building"></i>{{ $postModel->categories->pluck('name')->first() }}</a>
                                    @endif
                                </div>
                                <h2 class="blog-title">
                                    <a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a>
                                </h2>
                                <p class="blog-text">{{ $excerpt }}</p>
                                <a href="{{ route('blog.show', $post['slug']) }}" class="th-btn style-border2 th-btn-icon">
                                    Read More
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="th-blog blog-single">
                            <div class="blog-content">
                                <h2 class="blog-title">No posts available</h2>
                                <p class="blog-text">No published articles were found.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search">
                            <form class="search-form" method="get" action="{{ route('blog.index') }}">
                                <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>

                        <div class="widget widget_categories">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                                @forelse($popularCategories as $category)
                                    <li>
                                        <a href="#">{{ $category->name }} <span><i class="far fa-arrow-right"></i></span></a>
                                    </li>
                                @empty
                                    <li><a href="#">No categories <span><i class="far fa-arrow-right"></i></span></a></li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="widget">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                @foreach($recentPosts as $recent)
                                    @php
                                        $recentImageUrl = $resolveMediaUrl($recent->featured_image) ?? asset('guest/assets/img/blog/recent-post-1-1.jpg');
                                    @endphp
                                    <div class="recent-post">
                                        <div class="media-img">
                                            <a href="{{ route('blog.show', $recent->slug) }}">
                                                <img src="{{ $recentImageUrl }}" alt="{{ $recent->title }}">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="recent-post-meta">
                                                <a href="#"><i class="fas fa-calendar-days"></i>{{ optional($recent->published_at ?? $recent->created_at)->format('d M, Y') }}</a>
                                            </div>
                                            <h4 class="post-title">
                                                <a class="text-inherit" href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="widget widget_tag_cloud">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
                                @forelse($popularTags as $tag)
                                    <a href="#">{{ $tag->name }}</a>
                                @empty
                                    <a href="#">Blog</a>
                                @endforelse
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
