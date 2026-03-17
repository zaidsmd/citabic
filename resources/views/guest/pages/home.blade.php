@php use App\Helpers\NumberWrapper; @endphp
@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . __('site.nav.home'))

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
            background: linear-gradient(0deg, rgba(249, 99, 20, 0.24), rgba(249, 99, 20, 0.24)),
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
                            <img src="{{asset('guest/assets/img/about/1.JPG')}}" style="width: 410px; min-height: 419px ; object-fit: cover" alt="img">
                        </div>
                        <div class="img2">
                            <img src="{{asset('guest/assets/img/about/2.JPG')}}" style="width: 193px; min-height: 185px; object-fit: cover"  alt="img">
                        </div>
                        <div class="img3">
                            <img src="{{asset('guest/assets/img/about/3.JPG')}}" style="width: 193px; min-height: 185px; object-fit: cover"  alt="img">
                        </div>
                        <div class="about-tag">
                            <div class="about-experience-tag">
                                <span class="circle-title-anime">CITABIC</span>
                            </div>
                            <a href="{{asset('guest/assets/video/citabic-hero.mp4')}}" class="play-btn popup-video"><i class="fa-sharp fa-solid fa-play"></i></a>
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
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="title-area">
                        <span class="sub-title">{{ __('site.home.domains_eyebrow') }}</span>
                        <h2 class="sec-title">{{ __('site.home.domains_title') }}</h2>
                        <p>{{ __('site.home.domains_text') }}</p>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="sec-btn">
                        <a href="{{ route('expertise') }}"
                           class="th-btn style4 th-btn-icon">{{ __('site.actions.all_expertise') }}</a>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach ($site['domains'] as $domain)
                    <div class="col-md-6 col-xl-4">
                        <div class="service-card style6">
                            <div class="service-card-icon">
                                <img
                                    src="{{ asset('guest/assets/img/icon/service-icon3-' . (($loop->index % 3) + 1) . '.svg') }}"
                                    alt="Icon">
                            </div>
                            <h3 class="box-title"><a href="{{ route('expertise') }}">{{ $domain['title'] }}</a></h3>
                            <p class="box-text">{{ implode(' . ', array_slice($domain['items'], 0, 3)) }}</p>
                            <div class="service-img img-shine">
                                <img
                                    src="{{ asset('guest/assets/img/service/3-' . (($loop->index % 3) + 1) . '.png') }}"
                                    alt="img">
                                <a href="{{ route('expertise') }}" class="icon-btn"><img
                                        src="{{ asset('guest/assets/img/icon/arrow-right.svg') }}" alt="img"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="space bg-black2 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="title-area text-center">
                        <h2 class="sec-title text-white">{{ __('site.home.why_title') }}</h2>
                        <p class="sec-text text-white">{{ __('site.home.why_text') }}</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                @php($valuesCount = count($site['values'] ?? []))
                @foreach ($site['why_choose_us'] as $item)
                    <div class="col-xl-4 col-md-6">
                        <div class="process-card2"
                             data-bg-src="{{ asset('guest/assets/img/bg/process-card2-bg.png') }}">
                            <div class="box-icon"><img
                                    src="{{ asset('guest/assets/img/icon/process_card_2_' . (($loop->index % 3) + 1) . '.svg') }}"
                                    alt="icon"></div>
                            <div class="box-content">
                                <h3 class="box-title">{{ $item }}</h3>
                                <p class="box-text">{{ $valuesCount > 0 ? ($site['values'][$loop->index % $valuesCount]['text'] ?? '') : '' }}</p>
                                <p class="box-number">{{ __('site.home.point_label') }}
                                    - {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="space bg-smoke3">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="title-area">
                        <span class="sub-title">{{ __('site.home.references_eyebrow') }}</span>
                        <h2 class="sec-title">{{ __('site.home.references_title') }}</h2>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="sec-btn">
                        <a href="{{ route('references.index') }}"
                           class="th-btn style4 th-btn-icon">{{ __('site.actions.all_references') }}</a>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach (array_slice($references, 0, 4) as $reference)
                    <div class="col-xl-3 col-md-6">
                        <div class="team-card style9">
                            <div class="team-card-thumb img-shine">
                                <img src="{{ $reference['image_url'] ?? asset($reference['image']) }}"
                                     alt="{{ $reference['title'] }}">
                            </div>
                            <div class="team-card-content">
                                <h3 class="box-title"><a
                                        href="{{ route('references.show', $reference['slug']) }}">{{ $reference['title'] }}</a>
                                </h3>
                                <span class="team-desig">{{ $reference['client'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
