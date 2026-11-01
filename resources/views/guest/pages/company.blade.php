@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . __('site.nav.company'))

@section('content')
    <div class="breadcumb-wrapper"
         data-bg-src="{{ Storage::disk('public')->url($cp['about_header_bg']) }}">
        <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ __('site.breadcrumbs.company') }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                    <li>{{ __('site.breadcrumbs.company') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="overflow-hidden space-top " id="about-sec">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-8">
                    <div class="title-area">
                        <h2 class="sec-title pb-2">{!! $cp['about_title'] !!}</h2>
                        <p class="sec-text justify">{!! $cp['about_text'] !!}</p>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="about-tag">
                        <div class="about-experience-tag">
                            <span class="circle-title-anime text-title">{!! $cp['rounded_text'] !!}</span>
                        </div>
                        <div class="about-tag-thumb">
                            <img src="{{ Storage::disk('public')->url($cp['section_image']) }}" alt="img" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="service-area-1 overflow-hidden space-bottom  pt-80">
        <div class="container">
            <div class="row gy-40">
                @foreach($cp['domains'] as $domain)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card">
                            <div class="service-card-icon">
                                <div class="icon border rounded-2 p-2" style="border-color:rgba(0,0,0,0.1) !important;">
                                    <img src="{{ Storage::disk('public')->url($domain->icon) }}" alt="Icon"
                                         style="max-width: 48px; max-height: 48px;" loading="lazy" decoding="async">
                                </div>
                            </div>
                            <div class="box-content">
                                <h3 class="box-title">{{ $domain->title }}</h3>
                                <div class="checklist style5 box-text text-body">
                                    <ul>
                                        @foreach($domain->items as $service)
                                            <li>{{ $service }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="space bg-smoke2">
        <div class="container">
            <div class="counter-card-wrap">
                @foreach ($site['figures'] as $figure)
                    <div class="counter-card style4">
                        <div class="media-body">
                            <h2 class="box-number">{!! \App\Helpers\NumberWrapper::wrapNumbers($figure['value']) !!}</h2>
                            <p class="box-text">{{ $figure['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <section class="space bg-black2 position-relative" id="process-area2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="title-area text-center">
                        <h2 class="sec-title text-white">{{ $cp['mission_title'] }}</h2>
                        <p class="sec-text text-white">{!! $cp['mission_text'] !!}</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                @foreach ($cp['missions'] as $item)
                    <div class="col-xl-4 col-md-6">
                        <div class="process-card2"
                             data-bg-src="{{ asset('guest/assets/img/bg/process-card2-bg.png') }}">
                            <div class="box-icon overflow-hidden">
                                <img src="{{ Storage::disk('public')->url($item->icon) }}" alt="icon" loading="lazy" decoding="async">
                            </div>
                            @php
                                $missionTrans = $item->translations->firstWhere('locale', app()->getLocale())
                                    ?? $item->translations->firstWhere('locale', 'fr')
                                    ?? $item->translations->first();
                            @endphp
                            <div class="box-content">
                                <h3 class="box-title">{{ $missionTrans?->title }}</h3>
                                <p class="box-text">{{ $missionTrans?->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="bg-white">
        <div class="container">
            <div class="video-area-1-1 space-bottom position-relative" data-sec-pos="top-half"
                 data-pos-for="#process-area2">
                <div class="video-wrap1 style2 overflow-hidden shadow-lg">
                    <div class="p-5 bg-white">
                        <div class="title-area mb-45">
                            <h2 class="sec-title">{{ $cp['why_us_title'] }}</h2>
                            <p class="sec-text">{!! $cp['why_us_text'] !!}</p>
                        </div>
                        <div class="row gy-4">
                            @foreach($cp['why_us_cards'] as $item)
                                <div class="col-lg-4 col-sm-6">
                                    <div class="why-info-card style2">
                                        <div class="box-icon">
                                            <img src="/guest/assets/img/icon/checkmark2.svg" alt="img">
                                        </div>
                                        <h4 class="box-title">{{ $item }}</h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-end">
                            <a href="/contact" class="th-btn">Contact Us <span class="btn-icon"><img src="/guest/assets/img/icon/paper-plane.svg" alt="img"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-smoke2 space-bottom shape-mockup-wrap d-none">
        <div class="container">
            <div class="title-area">
                <h2 class="sec-title pb-2">{!! $cp['organigrame_title'] !!}</h2>
            </div>
            <div class="pt-2">
                <img class="rounded"
                     src="{{ Storage::disk('public')->url($cp['organigrame']) }}"
                     alt="ORGANIGRAME" loading="lazy" decoding="async">
            </div>
        </div>
    </section>

    <section class="bg-smoke4 space shape-mockup-wrap d-none">
        <div class="sec-bg-shape9-1 spin shape-mockup d-xxl-block d-none" style="top: 4%; right: -2%;">
            <img src="/guest/assets/img/shape/section_shape_2_1.jpg" alt="img">
        </div>
        <div class="sec-bg-shape9-2 jump shape-mockup d-xxl-block d-none __web-inspector-hide-shortcut__"
             style="bottom: 7%; left: 2%;">
            <img src="/guest/assets/img/shape/section_shape_2_3.jpg" alt="img">
        </div>
        <div class="container">
            <div class="title-area">
                <h2 class="sec-title pb-2">{!! $cp['cartographie_title'] !!}</h2>
            </div>
            <div class="pt-2 d-flex justify-content-center">
                <img class="rounded img-fluid"
                     src="{{ Storage::disk('public')->url($cp['cartographie']) }}"
                     alt="ORGANIGRAME" loading="lazy" decoding="async">
            </div>
        </div>
    </section>

    <div class="client-area-4 space">
        <div class="container">
            <div class="title-area">
                <h2 class="sec-title pb-2 text-center">@lang('site.expertise.certifications')</h2>
            </div>
            <div class="swiper th-slider has-shadow" id="clientSlider1" data-slider-options='{
        "centeredSlides": true,
        "centeredSlidesBounds": true,
        "breakpoints":{
            "0":{"slidesPerView":2},
            "576":{"slidesPerView":"3"},
            "768":{"slidesPerView":"4"},
            "992":{"slidesPerView":"5"},
            "1200":{"slidesPerView":"6"}
        }
    }'>
                <div class="swiper-wrapper" style="justify-content: center;">
                    @foreach ($cp['certifications'] as $certif)
                        <div class="swiper-slide d-flex align-items-center justify-content-center">
                            <div class="w-100">
                                <img style="max-width: 90%"
                                     src="{{ Storage::disk('public')->url($certif->image) }}"
                                     alt="{{ $certif->name }}" loading="lazy" decoding="async">
                                <p class="box-text text-center text-sm">{{ $certif->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden contact-area-4-2 z-index-common" id="contact-sec">
        <div class="container th-container2">
            <div class="contact-wrap4 bg-smoke4">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="appointment-wrap2">
                            <span class="sub-title3">Contact Us</span>
                            <h2 class="form-title">{{ $cp['contact_form_text'] }}</h2>
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
                            <img class="w-100" src="{{ Storage::disk('public')->url($cp['contact_image']) }}" alt="img" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-map-area overflow-hidden">
        <div class="contact-map">
            {!! $cp['map_embed'] !!}
        </div>
    </div>
@endsection
