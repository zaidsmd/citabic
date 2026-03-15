@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . $post['title'])

@section('content')
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

    <section class="th-blog-wrapper blog-details space-top space-extra2-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single">
                        <div class="blog-img">
                            <img src="{{ $post['image_url'] ?? asset('guest/assets/img/blog/blog-s-1-1.jpg') }}" alt="{{ $post['title'] }}">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a class="author" href="#"><i class="far fa-user"></i>By Admin</a>
                                <a href="#"><i class="far fa-calendar"></i>{{ \Carbon\Carbon::parse($post['published_at'])->format('d M, Y') }}</a>
                            </div>
                            <h2 class="blog-title">{{ $post['title'] }}</h2>
                            <div class="content">
                                {!! nl2br(e($post['content'])) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                @php
                                    $recentPosts = \App\Models\CitabicBlogPost::where('is_published', true)
                                        ->where('id', '!=', $post['id'])
                                        ->orderByDesc('published_at')
                                        ->limit(3)
                                        ->get();
                                @endphp
                                @foreach($recentPosts as $recent)
                                    <div class="recent-post">
                                        <div class="media-img">
                                            <a href="{{ route('blog.show', $recent->slug) }}">
                                                <img src="{{ $recent->image ? asset('storage/' . $recent->image) : asset('guest/assets/img/blog/recent-post-1-1.jpg') }}" alt="{{ $recent->title }}">
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
