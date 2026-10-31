@php use App\Helpers\NumberWrapper; @endphp
@extends('guest.layouts.app-template-floating-footer')

@section('title', $homePage['seo']['title'])
@section('meta_description', $homePage['seo']['description'])
@section('meta_keywords', $homePage['seo']['keywords'])
@section('og_title', $homePage['seo']['og_title'])
@section('og_description', $homePage['seo']['og_description'])
@section('og_image', $homePage['seo']['og_image'])
@section('twitter_card', $homePage['seo']['twitter_card'])
@section('twitter_title', $homePage['seo']['og_title'])
@section('twitter_description', $homePage['seo']['og_description'])
@section('twitter_image', $homePage['seo']['og_image'])
@push('styles')
    @if (! empty($site['hero_video_poster_url']))
        <link rel="preload" as="image" href="{{ $site['hero_video_poster_url'] }}">
    @endif
    <style>
        .hero-video-bg-wrap {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .hero-video-bg-wrap video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-video-bg-wrap::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(212, 175, 55, 0.24), rgba(212, 175, 55, 0.24)),
            linear-gradient(90deg, rgba(11, 16, 27, 0.56) 0%, rgba(11, 16, 27, 0.34) 48%, rgba(11, 16, 27, 0.56) 100%);
        }

        .hero-slider10 .swiper-slide {
            overflow: hidden;
        }

        .hero-slider10 .swiper-slide > .container,
        .hero-slider10 .hero-style10 {
            position: relative;
            z-index: 2;
        }

        .hero-style10 .th-btn.style-border {
            border: 1px solid var(--white-color);
            background: transparent;
            color: var(--white-color);
        }

        .hero-style10 .th-btn.style-border:hover {
            background: var(--white-color);
            color: var(--title-color);
        }

        .team-area-9 .team-card.style6 .team-img {
            position: relative;
        }

        .team-area-9 .team-card.style6 .team-img::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.28);
            pointer-events: none;
        }

        .team-area-9 .team-card.style6 .team-img img {
            display: block;
            width: 100%;
        }

    </style>
@endpush
@section('content')
    <div class="th-hero-wrapper hero-10 bg-smoke2" id="hero">
        <div class="swiper th-slider hero-slider10" id="heroSlide10"
             data-slider-options='{"effect":"fade","loop":false,"autoHeight": true}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="th-hero-bg" data-bg-src="{{ $site['hero_video_poster_url'] ?? asset('guest/assets/img/hero/hero_bg_14_1.jpg') }}"
                         data-mask-src="{{asset('guest/assets/img/hero/hero_10_bg_mask.png')}}">
                        <div class="hero-video-bg-wrap">
                            <video data-hero-video data-playback-rate="0.7" autoplay muted loop playsinline preload="auto"
                                   poster="{{ $site['hero_video_poster_url'] ?? asset('guest/assets/img/hero/hero_bg_14_1.jpg') }}">
                                @if (! empty($site['hero_video_webm_url']))
                                    <source src="{{ $site['hero_video_webm_url'] }}" type="video/webm">
                                @endif
                                @if (! empty($site['hero_video_stream_url']))
                                    <source src="{{ $site['hero_video_stream_url'] }}" type="video/mp4">
                                @elseif (! empty($site['hero_video_url']))
                                    <source src="{{ $site['hero_video_url'] }}" type="video/mp4">
                                @endif
                            </video>
                        </div>
                    </div>
                    <div class="container">
                        <div class="hero-inner">
                            <div class="row justify-content-center">
                                <div class="col-xl-10">
                                    <div class="hero-style10 text-center">
                                        <span class="hero-sub-title text-theme" data-ani="slideinup"
                                              data-ani-delay="0.3s">{{ $homePage['hero']['subtitle'] }}</span>
                                        <h1 class="hero-title text-white">
                                            <span class="title1" data-ani="slideinup" data-ani-delay="0.4s">
                                                {{ $homePage['hero']['title'] }} </span>
                                        </h1>
                                        <div class="btn-wrap justify-content-center" data-ani="slideinup"
                                             data-ani-delay="0.7s">
                                            <a href="#about-sec" class="th-btn style4 th-btn-icon">{{ $homePage['hero']['cta_text'] }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="hero-bottom-wrap">
            <div class="about-tag">
                <div class="about-experience-tag">
                    <span class="circle-title-anime">{{ $homePage['hero']['circle_text'] }}</span>
                </div>
                <div class="about-tag-thumb scroll-down">
                    <a href="#about-sec" class="hero-scroll-wrap"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-smoke2 overflow-hidden pt-60  pb-60">
        <div class="container">
            <div class="counter-card-wrap">
                @foreach ($site['figures'] as $figure)
                    <div class="counter-card style4">
                        <div class="media-body">
                            <h2 class="box-number">{!! NumberWrapper::wrapNumbers($figure['value']) !!}</h2>
                            <p class="box-text">{{ $figure['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="about-area-10 z-index-common position-relative space overflow-hidden" id="about-sec">
        <div class="container">
            <div class="row gx-80 justify-content-between align-items-center">
                <div class="col-xl-6 mb-40 mb-xl-0">
                    <div class="img-box10">
                        <div class="img1">
                            <img
                                src="{{ $homePage['about']['image_1_url'] }}"
                                style="width: 410px; min-height: 419px ; object-fit: cover" alt="img">
                        </div>
                        <div class="img2">
                            <img
                                src="{{ $homePage['about']['image_2_url'] }}"
                                style="width: 193px; min-height: 185px; object-fit: cover" alt="img">
                        </div>
                        <div class="img3">
                            <img
                                src="{{ $homePage['about']['image_3_url'] }}"
                                style="width: 193px; min-height: 185px; object-fit: cover" alt="img">
                        </div>
                        <div class="about-tag">
                            <div class="about-experience-tag">
                                <span
                                    class="circle-title-anime">{{ $homePage['about']['rounded_text'] }}</span>
                            </div>
                            <a href="{{asset('guest/assets/video/citabic-hero.mp4')}}" class="play-btn popup-video"><i
                                    class="fa-sharp fa-solid fa-play"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="title-area mb-32">
                        <span class="sub-title">{{ $homePage['about']['subtitle'] }}</span>
                        <h2 class="sec-title">{{ $homePage['about']['title'] }}</h2>
                        <p class="sec-text">{!! $homePage['about']['text'] !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="service-area-3 space overflow-hidden bg-gray3">
        <div class="sec-bg-shape2-3 jump shape-mockup d-xl-block d-none" style="top: -2%; right: 30%;">
            <img src="{{asset('/guest/assets/img/shape/section_shape_2_3.jpg')}}" alt="img">
        </div>
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="title-area">
                        <span class="sub-title">{{ $homePage['domains']['subtitle'] }}</span>
                        <h2 class="sec-title">{{ $homePage['domains']['title'] }}</h2>
                        {!! $homePage['domains']['text'] !!}
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach ($homePage['domains']['items'] as $domain)
                    <div class="col-md-6 col-xl-4 d-flex">
                        <div class="service-card style6 w-100">
                            <div class="service-card-icon">
                                <img
                                    class="service-card-icon-img"
                                    src="{{ $domain['icon_url'] }}"
                                    alt="Icon">
                            </div>
                            <h3 class="box-title">{{ $domain['title'] }}</h3>
                            <div class="checklist style5 box-text text-body">
                                <ul>
                                    @foreach($domain['items'] as $item)
                                        <li class="box-text">
                                            {{$item}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="why-sec2 space overflow-hidden">
        <div class="container">
            <div class="row gx-80 gy-60">
                <div class="col-xl-4 col-lg-8">
                    <div class="why-img-box2">
                        <div class="img1">
                            <img src="{{ $homePage['why']['image_url'] }}" alt="Why">
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="title-area mb-40">
                        <span class="sub-title">{{ $homePage['why']['subtitle'] }}</span>
                        <h2 class="sec-title">{{ $homePage['why']['title'] }}</h2>
                        <p class="sec-text">{!! $homePage['why']['text'] !!}</p>
                    </div>
                    <ul class="why-feature-list">
                        @forelse($why_features as $i => $feature)
                        <li class="why-feature-list-wrap">
                            <div class="number">{{ sprintf('%02d', $i + 1) }}</div>
                            <div class="why-feature-list-details">
                                <h4 class="feature-title">{{ $feature['title'] ?? '' }}</h4>
                                <p class="feature-text">{{ $feature['text'] ?? '' }}</p>
                            </div>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="team-area-9 overflow-hidden bg-smoke2 space" id="team-sec">
        <div class="sec-bg-shape9-1 spin shape-mockup d-xxl-block d-none" data-top="4%" data-right="-2%">
            <img src="/guest/assets/img/shape/section_shape_2_1.jpg" alt="img">
        </div>
        <div class="sec-bg-shape9-2 jump shape-mockup d-xxl-block d-none" data-bottom="7%" data-left="2%">
            <img src="/guest/assets/img/shape/section_shape_2_3.jpg" alt="img">
        </div>
        <div class="container z-index-common">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7">
                    <div class="title-area text-center">
                        <span class="sub-title">{{ $homePage['values']['subtitle'] }}</span>
                        <h2 class="sec-title">{{ $homePage['values']['title'] }}</h2>
                        <p class="sec-text">{!! $homePage['values']['text'] !!}</p>
                    </div>
                </div>
            </div>
            <div class="swiper th-slider team-slider9" id="teamSlider9" data-slider-options='{"paginationType":"progressbar","breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
                <div class="swiper-wrapper">
                    @forelse($site['values'] ?: $site['human_values'] as $valueItem)
                        <div class="swiper-slide">
                            <div class="th-team team-card style6">
                                <div class="img-wrap">
                                    <div class="team-img">
                                        <img src="{{ $valueItem['image_url'] ?? asset('guest/assets/img/team/team_8_1.png') }}" alt="{{ $valueItem['title'] ?? 'Value' }}">
                                    </div>
                                </div>
                                <div class="team-card-content">
                                    <div class="media">
                                        <div class="media-left">
                                            <h3 class="box-title">{{ $valueItem['title'] ?? '' }}</h3>
                                        </div>
                                    </div>
                                    <p class="text-white-50 mb-0 mt-2">{!! $valueItem['text']  !!}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="th-team team-card style6">
                                <div class="team-card-content">
                                    <h3 class="box-title">{{ $homePage['values']['empty_text'] }}</h3>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>
                <div class="slider-pagination"></div>
                <button data-slider-prev="#teamSlider9" class="slider-arrow slider-prev"><img src="/guest/assets/img/icon/arrow-left.svg" alt="icon"></button>
                <button data-slider-next="#teamSlider9" class="slider-arrow slider-next"><img src="/guest/assets/img/icon/arrow-right.svg" alt="icon"></button>
            </div>
        </div>
    </section>

    <section class="space overflow-hidden bg-black2" id="property-sec">
        <div class="sec-bg-shape2-1 spin shape-mockup d-xl-block d-none" data-top="10%" data-left="-2%">
            <img src="/guest/assets/img/shape/section_shape_2_1.jpg" alt="img">
        </div>
        <div class="sec-bg-shape2-3 jump shape-mockup d-xl-block d-none" data-bottom="35%" data-right="2%">
            <img src="/guest/assets/img/shape/section_shape_2_3.jpg" alt="img">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="title-area text-center">
                        <span class="sub-title">{{ $homePage['projects']['subtitle'] }}</span>
                        <h2 class="sec-title text-white">{{ $homePage['projects']['title'] }}</h2>
                        <p class="sec-text text-white">{!! $homePage['projects']['text'] !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container th-container2">
            <div class="slider-area property-slider2 slider-drag-wrap">
                <div class="swiper th-slider" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1500":{"slidesPerView":"4"}},"spaceBetween":"32","grabCursor":"true","slideToClickedSlide":"true"}'>
                    <div class="swiper-wrapper">
                        @foreach($homePage['projects']['items'] as $reference)
                            <div class="swiper-slide">
                                <div class="property-card7">
                                    <div class="property-card-thumb img-shine">
                                        <img src="{{ $reference['cover_image_url'] }}" alt="img">
                                    </div>
                                    <div class="property-card-details">
                                        <div class="media-left">
                                            <h4 class="property-card-title"><a href="{{route('references.show',$reference['slug'])}}">{{$reference['title']}}</a></h4>
                                            <p class="property-card-subtitle">{{$reference['client']}}</p>
                                        </div>
                                        <div class="btn-wrap">
                                            <a href="{{route('references.show',$reference['slug'])}}" class="icon-btn"><img src="/guest/assets/img/icon/arrow-right.svg" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="overflow-hidden  contact-area-4-2 z-index-common" id="contact-sec">
        <div class="sec-bg-shape2-1 spin shape-mockup d-xl-block d-none" data-top="10%" data-left="-2%">
            <img src="/guest/assets/img/shape/section_shape_2_1.jpg" alt="img">
        </div>
        <div class="sec-bg-shape2-3 jump shape-mockup d-xl-block d-none" data-bottom="35%" data-right="2%">
            <img src="/guest/assets/img/shape/section_shape_2_3.jpg" alt="img">
        </div>
        <div class="bg-black2 position-absolute w-100" style="height: 100%;margin-top:-164px; z-index: -99;"></div>
        <div class="container th-container2">
            <div class="contact-wrap4 bg-smoke4">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="appointment-wrap2">
                            <span class="sub-title3">{{ $homePage['contact']['subtitle'] }}</span>
                            <h2 class="form-title">{{ $homePage['contact']['form_title'] }}</h2>
                            <form action="mail.php" method="POST" class="appointment-form ajax-contact">
                                <div class="row">
                                    <div class="form-group style-border2 style-radius col-12">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('site.contact.name_placeholder') }}">
                                        <i class="fal fa-user"></i>
                                    </div>
                                    <div class="form-group style-border2 style-radius col-12">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('site.contact.email_placeholder') }}">
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                    <div class="form-group style-border2 style-radius col-md-12">
                                        <select name="subject" id="subject" class="form-select">
                                            <option value="" disabled selected hidden>{{ __('site.contact.subject_placeholder') }}</option>
                                            <option value="{{ __('site.contact.subjects.civil') }}">{{ __('site.contact.subjects.civil') }}</option>
                                            <option value="{{ __('site.contact.subjects.building') }}">{{ __('site.contact.subjects.building') }}</option>
                                            <option value="{{ __('site.contact.subjects.real_estate') }}">{{ __('site.contact.subjects.real_estate') }}</option>
                                            <option value="{{ __('site.contact.subjects.general') }}">{{ __('site.contact.subjects.general') }}</option>
                                        </select>
                                        <i class="fal fa-angle-down"></i>
                                    </div>
                                    <div class="col-12 form-group style-border2 style-radius">
                                        <i class="far fa-comments"></i>
                                        <textarea placeholder="{{ $homePage['contact']['message_placeholder'] }}" class="form-control"></textarea>
                                    </div>
                                    <div class="col-12 form-btn mt-4">
                                        <button class="th-btn style3">{{ $homePage['contact']['submit_text'] }} <span class="btn-icon"><img src="/guest/assets/img/icon/paper-plane.svg" alt="img"></span></button>
                                    </div>
                                </div>
                                <p class="form-messages mb-0 mt-3"></p>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-thumb4-1">
                            <img class="w-100" src="{{ $homePage['contact']['contact_image_url'] }}" alt="img" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-map-area overflow-hidden">
        <div class="contact-map">
            {!! $homePage['contact']['map_embed'] !!}
        </div>
    </div>
    <section class="overflow-hidden space" id="blog-sec">
        <div class="sec-bg-shape2-3 jump shape-mockup d-xl-block d-none" data-bottom="0%" data-right="4%">
            <img src="/guest/assets/img/shape/section_shape_2_3.jpg" alt="img">
        </div>
        <div class="container th-container2">
            <div class="row justify-content-lg-between align-items-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7">
                    <div class="title-area">
                        <span class="sub-title3 ">{{ $homePage['blog']['subtitle'] }}</span>
                        <h2 class="sec-title">{{ $homePage['blog']['title'] }}</h2>
                        <p class="sec-text">{!! $homePage['blog']['text'] !!}</p>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="sec-btn">
                        <a href="{{ route('blog.index') }}" class="th-btn style4 th-btn-icon">{{ $homePage['blog']['browse_text'] }}</a>
                    </div>
                </div>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow slider-drag-wrap" id="blogSlider3" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1500":{"slidesPerView":"4"}},"autoHeight":true}'>
                    <div class="swiper-wrapper">
                        @forelse($homePage['blog']['posts'] as $blogPost)
                            <div class="swiper-slide">
                                <div class="blog-card style3">
                                    <div class="blog-img">
                                        <a href="{{ route('blog.show', $blogPost['slug']) }}">
                                            <img src="{{ $blogPost['image_url'] }}" alt="blog image">
                                        </a>
                                    </div>
                                    <div class="blog-content">
                                        <div class="blog-meta">
                                            <a href="{{ route('blog.show', $blogPost['slug']) }}">{{ $blogPost['published_at_label'] }}</a>
                                            <a href="{{ route('blog.show', $blogPost['slug']) }}">{{ $blogPost['reading_time'] > 0 ? str_pad((string) $blogPost['reading_time'], 2, '0', STR_PAD_LEFT) : '01' }} {{ $homePage['blog']['min_read_text'] }}</a>
                                        </div>
                                        <h3 class="box-title"><a href="{{ route('blog.show', $blogPost['slug']) }}">{{ $blogPost['title'] }}</a></h3>
                                        <a href="{{ route('blog.show', $blogPost['slug']) }}" class="th-btn style-border2 th-btn-icon">{{ $homePage['blog']['read_more_text'] }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="blog-card style3">
                                    <div class="blog-content">
                                        <h3 class="box-title">{{ $homePage['blog']['empty_text'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
