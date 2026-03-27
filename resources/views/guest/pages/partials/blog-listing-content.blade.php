@php
    $pageTitle = $pageTitle ?? 'Blog';
    $activeFilterType = $activeFilterType ?? null;
    $activeFilterLabel = $activeFilterLabel ?? null;
    $activeFilterName = $activeFilterName ?? null;
    $activeFilterSlug = $activeFilterSlug ?? null;
    $postMeta = $postMeta ?? collect();
    $recentPosts = $recentPosts ?? collect();
    $popularCategories = $popularCategories ?? collect();
    $popularTags = $popularTags ?? collect();
    $search = $search ?? request('q');

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

    $searchAction = route('blog.index');
    if ($activeFilterType === 'category' && ! empty($activeFilterSlug)) {
        $searchAction = route('blog.category', $activeFilterSlug);
    }
    if ($activeFilterType === 'tag' && ! empty($activeFilterSlug)) {
        $searchAction = route('blog.tag', $activeFilterSlug);
    }
@endphp

<div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
    <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $pageTitle }}</h1>
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                <li><a href="{{ route('blog.index') }}">{{ __('site.blog.listing.title') }}</a></li>
                @if($activeFilterType && $activeFilterName)
                    <li>{{ $activeFilterLabel }}: {{ $activeFilterName }}</li>
                @endif
            </ul>
        </div>
    </div>
</div>

<section class="th-blog-wrapper space-top space-extra2-bottom">
    <div class="container">
        <div class="row gx-40">
            <div class="col-xxl-8 col-lg-7">
                @if($activeFilterType && $activeFilterName)
                    <div class="alert alert-light border mb-4">
                        <strong>{{ $activeFilterLabel }}:</strong> {{ $activeFilterName }}
                        <a href="{{ route('blog.index') }}" class="ms-2 text-decoration-underline">{{ __('site.blog.listing.clear_filter') }}</a>
                    </div>
                @endif

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
                                <a class="author" href="#"><i class="far fa-user"></i>{{ __('site.blog.listing.by') }} {{ $postModel?->author?->name ?? 'Admin' }}</a>
                                @if($publishedAt)
                                    <a href="#"><i class="far fa-clock"></i>{{ $publishedAt->format('d M, Y') }}</a>
                                @endif
                                @if($postModel && $postModel->categories->isNotEmpty())
                                    <a href="{{ route('blog.category', $postModel->categories->first()->slug) }}"><i class="far fa-house-building"></i>{{ $postModel->categories->pluck('name')->first() }}</a>
                                @endif
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a>
                            </h2>
                            <p class="blog-text">{{ $excerpt }}</p>
                            <a href="{{ route('blog.show', $post['slug']) }}" class="th-btn style-border2 th-btn-icon">
                                {{ __('site.blog.listing.read_more') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="th-blog blog-single">
                        <div class="blog-content">
                            <h2 class="blog-title">{{ __('site.blog.listing.empty_title') }}</h2>
                            <p class="blog-text">{{ __('site.blog.listing.empty_text') }}</p>
                        </div>
                    </div>
                @endforelse

                @if($posts instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="th-pagination text-center mt-40">
                        {{ $posts->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>

            <div class="col-xxl-4 col-lg-5">
                <aside class="sidebar-area">
                    <div class="widget widget_search">
                        <form class="search-form" method="get" action="{{ $searchAction }}">
                            <input type="text" name="q" placeholder="{{ __('site.blog.listing.search_placeholder') }}" value="{{ $search }}">
                            <button type="submit"><i class="far fa-search"></i></button>
                        </form>
                    </div>

                    <div class="widget widget_categories">
                        <h3 class="widget_title">{{ __('site.blog.listing.categories') }}</h3>
                        <ul>
                            @forelse($popularCategories as $category)
                                <li>
                                    <a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }} <span><i class="far fa-arrow-right"></i></span></a>
                                </li>
                            @empty
                                <li><a href="#">{{ __('site.blog.listing.empty_categories') }} <span><i class="far fa-arrow-right"></i></span></a></li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="widget">
                        <h3 class="widget_title">{{ __('site.blog.listing.recent_posts') }}</h3>
                        <div class="recent-post-wrap">
                            @foreach($recentPosts as $recent)
                                @php
                                    $recentImageUrl = $resolveMediaUrl($recent['image_url'] ?? null) ?? asset('guest/assets/img/blog/recent-post-1-1.jpg');
                                @endphp
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('blog.show', $recent['slug']) }}">
                                            <img src="{{ $recentImageUrl }}" alt="{{ $recent['title'] }}">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="recent-post-meta">
                                            <a href="#"><i class="fas fa-calendar-days"></i>{{ !empty($recent['published_at'] ?? null) ? \Carbon\Carbon::parse($recent['published_at'])->format('d M, Y') : (!empty($recent['created_at'] ?? null) ? \Carbon\Carbon::parse($recent['created_at'])->format('d M, Y') : '') }}</a>
                                        </div>
                                        <h4 class="post-title">
                                            <a class="text-inherit" href="{{ route('blog.show', $recent['slug']) }}">{{ $recent['title'] }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="widget widget_tag_cloud">
                        <h3 class="widget_title">{{ __('site.blog.listing.popular_tags') }}</h3>
                        <div class="tagcloud">
                            @forelse($popularTags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}">{{ $tag->name }}</a>
                            @empty
                                <a href="#">{{ __('site.blog.listing.title') }}</a>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
