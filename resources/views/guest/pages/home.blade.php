@php use App\Helpers\NumberWrapper; @endphp
@extends('guest.layouts.app-template-floating-footer')

@section('title', 'CITABIC | ' . __('site.nav.home'))
@push('styles')

@endpush
@section('content')
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

    </style>
    <div class="th-hero-wrapper hero-10 bg-smoke2" id="hero">
        <div class="swiper th-slider hero-slider10" id="heroSlide10"
             data-slider-options='{"effect":"fade","loop":false,"autoHeight": true}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="th-hero-bg" data-bg-src="{{asset('guest/assets/img/hero/hero_bg_10_1.jpg')}}"
                         data-mask-src="{{asset('guest/assets/img/hero/hero_10_bg_mask.png')}}">
                        <div class="hero-video-bg-wrap">
                            <video data-hero-video data-playback-rate="0.7" autoplay muted loop playsinline
                                   poster="{{ asset('guest/assets/img/hero/hero_bg_10_1.jpg') }}">
                                @if (! empty($site['hero_video_url']))
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
                                              data-ani-delay="0.3s">{{\App\Models\SectionContent::where('section',\App\Enums\Section::HERO->value)->where('language',config('app.locale'))->where('key',\App\Enums\ContentKey::HERO_SUBTITLE->value)->first()?->value}}</span>
                                        <h1 class="hero-title text-white">
                                            <span class="title1" data-ani="slideinup" data-ani-delay="0.4s">
                                                {{\App\Models\SectionContent::where('section',\App\Enums\Section::HERO->value)->where('language',config('app.locale'))->where('key',\App\Enums\ContentKey::HERO_TITLE->value)->first()?->value}} </span>
                                        </h1>
                                        <div class="btn-wrap justify-content-center" data-ani="slideinup"
                                             data-ani-delay="0.7s">
                                            <a href="contact.html" class="th-btn style4 th-btn-icon">Discover More</a>
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
                    <span class="circle-title-anime">Explore and find Your Dream place</span>
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
                                src="{{\Illuminate\Support\Facades\Storage::disk('public')->url(\App\Models\SectionContent::where('section',\App\Enums\Section::ABOUT)->where('key',\App\Enums\ContentKey::ABOUT_IMAGE_1)->first()?->value)}}"
                                style="width: 410px; min-height: 419px ; object-fit: cover" alt="img">
                        </div>
                        <div class="img2">
                            <img
                                src="{{\Illuminate\Support\Facades\Storage::disk('public')->url(\App\Models\SectionContent::where('section',\App\Enums\Section::ABOUT)->where('key',\App\Enums\ContentKey::ABOUT_IMAGE_2)->first()?->value)}}"
                                style="width: 193px; min-height: 185px; object-fit: cover" alt="img">
                        </div>
                        <div class="img3">
                            <img
                                src="{{\Illuminate\Support\Facades\Storage::disk('public')->url(\App\Models\SectionContent::where('section',\App\Enums\Section::ABOUT)->where('key',\App\Enums\ContentKey::ABOUT_IMAGE_3)->first()?->value)}}"
                                style="width: 193px; min-height: 185px; object-fit: cover" alt="img">
                        </div>
                        <div class="about-tag">
                            <div class="about-experience-tag">
                                <span
                                    class="circle-title-anime">{{\App\Models\SectionContent::where('section',\App\Enums\Section::ABOUT_PAGE)->where('key',\App\Enums\ContentKey::ROUNDED_TEXT)->where('language',config('app.locale'))->first()?->value}}</span>
                            </div>
                            <a href="{{asset('guest/assets/video/citabic-hero.mp4')}}" class="play-btn popup-video"><i
                                    class="fa-sharp fa-solid fa-play"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="title-area mb-32">
                        <span class="sub-title">{{ __('site.sections.about') }}</span>
                        <h2 class="sec-title">{{ \App\Models\SectionContent::where('section',\App\Enums\Section::ABOUT->value)->where('key',\App\Enums\ContentKey::ABOUT_TITLE)->where('language',config('app.locale'))->first()?->value }}</h2>
                        <p class="sec-text">{!!  \App\Models\SectionContent::where('section',\App\Enums\Section::ABOUT->value)->where('key',\App\Enums\ContentKey::ABOUT_TEXT)->where('language',config('app.locale'))->first()?->value !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="service-area-3 space overflow-hidden bg-gray3">
        <div class="sec-bg-shape2-3 jump shape-mockup d-xl-block d-none" style="top: -2%; right: 30%;">
            <img src="/guest/assets/img/shape/section_shape_2_3.jpg" alt="img">
        </div>
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="title-area">
                        <span class="sub-title">{{ __('site.home.domains_eyebrow') }}</span>
                        <h2 class="sec-title">{{ \App\Models\SectionContent::where('section',\App\Enums\Section::DOMAIN->value)->where('key',\App\Enums\ContentKey::DOMAIN_TITLE)->where('language',config('app.locale'))->first()?->value}}</h2>
                        {!!  \App\Models\SectionContent::where('section',\App\Enums\Section::DOMAIN->value)->where('key',\App\Enums\ContentKey::DOMAIN_TEXT)->where('language',config('app.locale'))->first()?->value!!}
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach (\App\Models\CitabicDomain::all() as $domain)
                    <div class="col-md-6 col-xl-4 d-flex">
                        <div class="service-card style6 w-100">
                            <div class="service-card-icon">
                                <img
                                    class="service-card-icon-img"
                                    src="{{Storage::disk('public')->url($domain->icon)}}"
                                    alt="Icon">
                            </div>
                            <h3 class="box-title">{{ $domain->title }}</h3>
                            <div class="checklist style5 box-text text-body">
                                <ul>
                                    @foreach($domain->items as $item)
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
                            <img src="{{\Illuminate\Support\Facades\Storage::disk('public')->url(\App\Models\SectionContent::where('section',\App\Enums\Section::WHY_CHOOSE_US)->where('key',\App\Enums\ContentKey::WHY_IMAGE)->where('language',config('app.locale'))->first()?->value)}}" alt="Why">
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="title-area mb-40">
                        <span class="sub-title">{{\App\Models\SectionContent::where('section',\App\Enums\Section::WHY_CHOOSE_US)->where('key',\App\Enums\ContentKey::WHY_SUBTITLE)->where('language',config('app.locale'))->first()?->value}}</span>
                        <h2 class="sec-title">{{\App\Models\SectionContent::where('section',\App\Enums\Section::WHY_CHOOSE_US)->where('key',\App\Enums\ContentKey::WHY_TITLE)->where('language',config('app.locale'))->first()?->value}}</h2>
                        <p class="sec-text">{!! \App\Models\SectionContent::where('section',\App\Enums\Section::WHY_CHOOSE_US)->where('key',\App\Enums\ContentKey::WHY_TEXT)->where('language',config('app.locale'))->first()?->value!!}</p>
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
                        <span class="sub-title">{{ \App\Models\SectionContent::where('section',\App\Enums\Section::PROJECTS->value)->where('key',\App\Enums\ContentKey::PROJECTS_SUBTITLE->value)->where('language',config('app.locale'))->first()?->value }}</span>
                        <h2 class="sec-title text-white">{{ \App\Models\SectionContent::where('section',\App\Enums\Section::PROJECTS->value)->where('key',\App\Enums\ContentKey::PROJECTS_TITLE->value)->where('language',config('app.locale'))->first()?->value }}</h2>
                        <p class="sec-text text-white">{!! \App\Models\SectionContent::where('section',\App\Enums\Section::PROJECTS->value)->where('key',\App\Enums\ContentKey::PROJECTS_TEXT->value)->where('language',config('app.locale'))->first()?->value !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container th-container2">
            <div class="slider-area property-slider2 slider-drag-wrap">
                <div class="swiper th-slider" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1500":{"slidesPerView":"4"}},"spaceBetween":"32","grabCursor":"true","slideToClickedSlide":"true"}'>
                    <div class="swiper-wrapper">
                        @foreach(\App\Models\CitabicReference::all() as $reference)
                            <div class="swiper-slide">
                                <div class="property-card7">
                                    <div class="property-card-thumb img-shine">

                                        <img src="{{Storage::disk('public')->url(str_replace('storage/','',array_filter($reference->blocks,fn($item)=>$item['type']=== 'coverImage')[0]['content']))}}" alt="img">
                                    </div>
                                    <div class="property-card-details">
                                        <div class="media-left">
                                            <h4 class="property-card-title"><a href="{{route('references.show',$reference->slug)}}">{{$reference->title}}</a></h4>
                                            <p class="property-card-subtitle">{{$reference->client}}</p>
                                        </div>
                                        <div class="btn-wrap">
                                            <a href="{{route('references.show',$reference->slug)}}" class="icon-btn"><img src="/guest/assets/img/icon/arrow-right.svg" alt=""></a>
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
                            <span class="sub-title3">Contact Us</span>
                            <h2 class="form-title">{{ \App\Models\SectionContent::where('section',\App\Enums\Section::CONTACT)->where('key',\App\Enums\ContentKey::CONTACT_FORM_TEXT)->where('language',config('app.locale'))->first()?->value }}</h2>
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
                                        <textarea placeholder="Type Your Message" class="form-control"></textarea>
                                    </div>
                                    <div class="col-12 form-btn mt-4">
                                        <button class="th-btn style3">Submit Message <span class="btn-icon"><img src="/guest/assets/img/icon/paper-plane.svg" alt="img"></span></button>
                                    </div>
                                </div>
                                <p class="form-messages mb-0 mt-3"></p>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-thumb4-1">
                            <img class="w-100" src="{{ Storage::disk('public')->url(\App\Models\SectionContent::where('section',\App\Enums\Section::CONTACT)->where('key',\App\Enums\ContentKey::CONTACT_IMAGE)->where('language',config('app.locale'))->first()?->value) }}" alt="img" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-map-area overflow-hidden">
        <div class="contact-map">
            {!! \App\Models\SectionContent::where('section',\App\Enums\Section::CONTACT)->where('key',\App\Enums\ContentKey::MAP_EMBED)->first()?->value !!}
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
                        <span class="sub-title3 ">News & Blog</span>
                        <h2 class="sec-title">Read Our Insights</h2>
                        <p class="sec-text">Architects and engineers collaborate to create detailed design plans that translate concepts into feasible structures. </p>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="sec-btn">
                        <a href="blog.html" class="th-btn style4 th-btn-icon">Browse All Blog</a>
                    </div>
                </div>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow slider-drag-wrap" id="blogSlider3" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1500":{"slidesPerView":"4"}},"autoHeight":true}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_1.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">April 22, 2025</a>
                                        <a href="blog.html">08 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Innovative structures rise, blending Construction and project</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_2.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">June 16, 2025</a>
                                        <a href="blog.html">10 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">What trends do we expect to start growing in the coming future?</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_3.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">April 22, 2025</a>
                                        <a href="blog.html">08 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Living sustainability: A day in the life at builda residence</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_4.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">June 16, 2025</a>
                                        <a href="blog.html">08 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">The workplace tells and screams for more top story bloggers.</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_1.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">April 22, 2025</a>
                                        <a href="blog.html">08 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Innovative structures rise, blending Construction and project</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_2.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">June 16, 2025</a>
                                        <a href="blog.html">10 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">What trends do we expect to start growing in the coming future?</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_3.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">April 22, 2025</a>
                                        <a href="blog.html">08 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Living sustainability: A day in the life at builda residence</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="blog-card style3">
                                <div class="blog-img">
                                    <img src="/guest/assets/img/blog/blog_3_4.jpg" alt="blog image">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <a href="blog.html">June 16, 2025</a>
                                        <a href="blog.html">08 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">The workplace tells and screams for more top story bloggers.</a></h3>
                                    <a href="blog-details.html" class="th-btn style-border2 th-btn-icon">Read More</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
