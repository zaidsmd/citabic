@extends('guest.layouts.app-template')

@section('title', 'CITABIC | Blog')

@section('content')
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

    <section class="space-top space-extra2-bottom">
        <div class="container">
            <div class="row gy-40">
                @foreach ($posts as $post)
                    <div class="col-md-6 col-xl-4">
                        <div class="blog-card style2">
                            <div class="blog-img img-shine">
                                <img src="{{ $post['image_url'] ?? asset('guest/assets/img/blog/blog_s_1_1.jpg') }}" alt="{{ $post['title'] }}">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <a href="#"><i class="fal fa-calendar-alt"></i>{{ \Carbon\Carbon::parse($post['published_at'])->format('d M, Y') }}</a>
                                </div>
                                <h3 class="blog-title"><a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a></h3>
                                <p class="blog-text">{{ $post['summary'] }}</p>
                                <a href="{{ route('blog.show', $post['slug']) }}" class="th-btn btn-sm">Read More<i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
