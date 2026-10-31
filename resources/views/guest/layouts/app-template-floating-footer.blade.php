<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'CITABIC')</title>
    <meta name="author" content="CITABIC">
    <meta name="description" content="@yield('meta_description', __('site.meta_description'))">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <meta name="robots" content="@yield('meta_robots', 'index,follow')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'article')">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_MA' : (app()->getLocale() === 'en' ? 'en_US' : 'fr_FR') }}">
    @foreach (config('localization.supported', ['fr', 'en', 'ar']) as $altLocale)
        <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ route('locale.switch', $altLocale) }}">
    @endforeach
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'CITABIC')))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('meta_description', __('site.meta_description'))))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', '')">
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', trim($__env->yieldContent('og_title', $__env->yieldContent('title', 'CITABIC'))))">
    <meta name="twitter:description" content="@yield('twitter_description', trim($__env->yieldContent('og_description', $__env->yieldContent('meta_description', __('site.meta_description')))))">
    <meta name="twitter:image" content="@yield('twitter_image', trim($__env->yieldContent('og_image', '')))">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('guest/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300..900&family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset(app()->getLocale() === 'ar' ? 'guest/assets/css/bootstrap.rtl.min.css' : 'guest/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/assets/css/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/guest.css') }}">
    <link rel="stylesheet" href="{{asset('build/js/app-guest.js')}}">
    <style>
        .lang-switcher {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .lang-switcher-label {
            color: rgba(255, 255, 255, 0.75);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .lang-switcher-track {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
        }

        .lang-switcher-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            padding: 7px 10px;
            border-radius: 999px;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: all 0.3s ease;
            line-height: 1;
        }

        .lang-switcher-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
        }

        .lang-switcher-link.is-active {
            background: var(--theme-color);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.28);
        }

        .lang-switcher-link small {
            display: none;
        }

        .mobile-lang-switcher {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .mobile-lang-switcher .lang-switcher {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .mobile-lang-switcher .lang-switcher-track {
            width: 100%;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.04);
        }

        .mobile-lang-switcher .lang-switcher-link {
            flex: 1 1 0;
            min-width: 0;
        }

        .mobile-lang-switcher .lang-switcher-link small {
            display: inline;
            margin-left: 6px;
            opacity: 0.7;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
        }

        /* RTL & Arabic Typography */
        html[dir="rtl"], [dir="rtl"] body {
            font-family: 'Cairo', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            text-align: right;
            direction: rtl;
        }

        [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3, [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6,
        [dir="rtl"] .sec-title, [dir="rtl"] .hero-title, [dir="rtl"] .box-title, [dir="rtl"] .title-area h2 {
            font-family: 'Cairo', 'Outfit', sans-serif;
            letter-spacing: normal;
        }

        [dir="rtl"] .lang-switcher-link {
            font-family: 'Cairo', sans-serif;
            letter-spacing: normal;
        }

        [dir="rtl"] .mobile-lang-switcher .lang-switcher-link small {
            margin-left: 0;
            margin-right: 6px;
        }

        /* Mirror directional indicators in RTL */
        [dir="rtl"] .th-btn-icon i,
        [dir="rtl"] .th-btn i.fa-arrow-right,
        [dir="rtl"] .th-btn i.fa-angle-right,
        [dir="rtl"] .th-btn i.fa-chevron-right,
        [dir="rtl"] .th-btn i.fa-arrow-left,
        [dir="rtl"] .th-btn i.fa-angle-left,
        [dir="rtl"] .slider-drag-cursor i,
        [dir="rtl"] .breadcumb-menu li:after,
        [dir="rtl"] .pagination li a i.fa-angle-right {
            transform: scaleX(-1);
            display: inline-block;
        }

        [dir="rtl"] .th-btn.th-btn-icon {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .main-menu ul li {
            margin: 0 0 0 34px;
        }

        [dir="rtl"] .header-button .lang-switcher {
            margin-right: 0 !important;
            margin-left: 1rem !important;
        }

        [dir="rtl"] .footer-widget .widget_title:after {
            right: 0;
            left: auto;
        }

        [dir="rtl"] .th-mobile-menu ul li {
            text-align: right;
        }

        [dir="rtl"] .counter-card .media-body,
        [dir="rtl"] .process-card2 .box-content,
        [dir="rtl"] .contact-feature .media-body,
        [dir="rtl"] .about-feature .media-body {
            text-align: right;
        }

        [dir="rtl"] .breadcumb-menu {
            direction: rtl;
        }

        [dir="rtl"] .breadcumb-menu li {
            margin-right: 0;
            margin-left: 15px;
        }

        [dir="rtl"] .breadcumb-menu li:after {
            right: auto;
            left: -10px;
        }

        /* RTL - Home: Pourquoi nous choisir */
        [dir="rtl"] .sub-title:before,
        [dir="rtl"] .sub-title:after {
            right: 0;
            left: auto;
        }
        [dir="rtl"] .title-area.text-center .sub-title:before,
        [dir="rtl"] .title-area.text-center .sub-title:after {
            left: 50%;
            right: auto;
        }
        [dir="rtl"] .why-sec2 .title-area {
            text-align: right;
        }
        [dir="rtl"] .why-img-box2 {
            margin-left: 0;
            margin-right: -315px;
            border-radius: 0 0 0 50px;
        }
        @media (max-width: 1500px) {
            [dir="rtl"] .why-img-box2 {
                margin-left: 0;
                margin-right: -200px;
            }
        }
        @media (max-width: 1399px) {
            [dir="rtl"] .why-img-box2 {
                margin-left: 0;
                margin-right: 0;
                margin-top: 0;
                border-radius: 20px;
            }
        }
        [dir="rtl"] .why-feature-list .why-feature-list-wrap:after {
            right: 20px;
            left: auto;
        }
        [dir="rtl"] .why-feature-list .why-feature-list-details,
        [dir="rtl"] .why-feature-list .feature-title,
        [dir="rtl"] .why-feature-list .feature-text {
            text-align: right;
        }

        /* RTL - Contact Page */
        [dir="rtl"] .about-contact-grid,
        [dir="rtl"] .about-contact-details {
            text-align: right;
        }
        [dir="rtl"] .contact-sec-map {
            left: 0;
            right: auto;
        }
        [dir="rtl"] .contact-sec-map .location-map-address {
            left: 15%;
            right: auto;
        }
        [dir="rtl"] .location-map-address .media-body {
            text-align: right;
        }
        @media (max-width: 991px) {
            [dir="rtl"] .contact-sec-map {
                position: relative;
                left: auto;
                right: auto;
            }
        }
        @media (max-width: 575px) {
            [dir="rtl"] .contact-sec-map .location-map-address {
                left: 15px;
                right: auto;
            }
        }
        [dir="rtl"] .contact-thumb6-1,
        [dir="rtl"] .contact-area-5 .contact-thumb6-1 {
            right: 0;
            left: auto;
        }
        @media (max-width: 991px) {
            [dir="rtl"] .contact-thumb6-1,
        [dir="rtl"] .contact-area-5 .contact-thumb6-1 {
                right: auto;
                left: auto;
                position: relative;
                width: 100%;
            }
        }
        [dir="rtl"] .contact-wrap6 {
            padding-right: 90px;
            padding-left: 0;
            margin-left: -120px;
            margin-right: 0;
            text-align: right;
        }
        [dir="rtl"] .contact-wrap6 .form-title {
            text-align: right;
        }
        @media (max-width: 1500px) {
            [dir="rtl"] .contact-wrap6 {
                margin-left: 0;
                padding-right: 50px;
                padding-left: 0;
            }
        }
        @media (max-width: 1399px) {
            [dir="rtl"] .contact-wrap6 {
                padding-right: 20px;
                padding-left: 0;
            }
        }
        @media (max-width: 1299px) {
            [dir="rtl"] .contact-wrap6 {
                padding-right: 30px;
                padding-left: 0;
            }
        }
        @media (max-width: 991px) {
            [dir="rtl"] .contact-wrap6 {
                padding-right: 0;
                padding-left: 0;
                margin-left: 0;
                margin-right: 0;
            }
        }

        /* RTL - Forms & Inputs */
        [dir="rtl"] .form-group {
            text-align: right;
        }
        [dir="rtl"] .form-group > i {
            left: 25px;
            right: auto;
        }
        [dir="rtl"] .form-control,
        [dir="rtl"] input,
        [dir="rtl"] textarea,
        [dir="rtl"] select,
        [dir="rtl"] .form-select {
            padding-left: 45px;
            padding-right: 25px;
            text-align: right;
        }
        [dir="rtl"] select.form-select,
        [dir="rtl"] .form-select {
            background-position: left 26px center;
        }
        [dir="rtl"] input[type=date]::-webkit-calendar-picker-indicator {
            left: 20px;
            right: auto;
        }
        [dir="rtl"] .th-btn .btn-icon img {
            transform: scaleX(-1);
            margin-right: 8px;
            margin-left: 0;
        }
    </style>
    @yield('structured_data')
    @stack('styles')
</head>
<body>
@php($currentLocale = app()->getLocale())
<div class="cursor-follower"></div>
<div class="slider-drag-cursor"><i class="fas fa-angle-left me-2"></i> {{ __('site.common.drag') }} <i class="fas fa-angle-right ms-2"></i></div>

<div class="th-menu-wrapper">
    <div class="th-menu-area text-center">
        <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('guest/assets/img/logo-white.svg') }}" alt="CITABIC">
            </a>
        </div>
        <div class="th-mobile-menu allow-natural-scroll">
            <ul>
                <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                <li><a href="{{ route('company') }}">{{ __('site.nav.company') }}</a></li>
                <li><a href="{{ route('references.index') }}">{{ __('site.nav.references') }}</a></li>
                <li><a href="{{ route('blog.index') }}">{{ __('site.nav.blog') }}</a></li>
                <li><a href="{{ route('contact') }}">{{ __('site.nav.contact') }}</a></li>
            </ul>
                @include('guest.partials.language-switcher', ['mobile' => true])
        </div>
    </div>
</div>

<header class="th-header header-layout5">
    <div class="sticky-wrapper">
        <div class="container">
            <div class="menu-area">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('guest/assets/img/logo-white.svg') }}" alt="CITABIC">
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu d-none d-lg-inline-block">
                            <ul>
                                <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                                <li><a href="{{ route('company') }}">{{ __('site.nav.company') }}</a></li>
                                <li><a href="{{ route('references.index') }}">{{ __('site.nav.references') }}</a></li>
                                <li><a href="{{ route('blog.index') }}">{{ __('site.nav.blog') }}</a></li>
                                <li><a href="{{ route('contact') }}">{{ __('site.nav.contact') }}</a></li>
                            </ul>
                        </nav>
                        <div class="header-button d-flex d-lg-none">
                            <button type="button" class="th-menu-toggle sidebar-btn">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-auto d-none d-xl-block">
                        <div class="header-button">
                                @include('guest.partials.language-switcher', ['mobile' => false])
                            <a href="{{ route('contact') }}" class="th-btn style4 th-btn-icon">{{ __('site.actions.request_meeting') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')
<footer class="footer-wrapper footer-layout3 bg-white">
    <div class="container th-container2">
        <div class="widget-area bg-black2">
            <div class="footer-container">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo">
                                    <a href="{{ route('home') }}"><img src="/guest/assets/img/logo-white.svg" alt="CITABIC"></a>
                                </div>
                                <p class="about-text">{{ __('site.footer.about') }}</p>
                                @if(!empty($company['facebook']) || !empty($company['linkedin']) || !empty($company['instagram']))
                                    <div class="th-social style5">
                                        @if(!empty($company['facebook']))
                                            <a href="{{ $company['facebook'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                                        @endif
                                        @if(!empty($company['linkedin']))
                                            <a href="{{ $company['linkedin'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                                        @endif
                                        @if(!empty($company['instagram']))
                                            <a href="{{ $company['instagram'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">{{ __('site.footer.coordinates') }}</h3>
                            <div class="th-widget-contact">
                                <div class="info-box_text">
                                    <div class="icon"><img src="/guest/assets/img/icon/location-dot.svg" alt="img"></div>
                                    <div class="details">
                                        <p>{{ $company['head_office'] ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="/guest/assets/img/icon/phone.svg" alt="img">
                                    </div>
                                    <div class="details">
                                        @if(!empty($company['phone'] ?? null))
                                            <p><a href="tel:{{ preg_replace('/\s+/', '', $company['phone']) }}" class="info-box_link">{{ $company['phone'] }}</a></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="/guest/assets/img/icon/envelope.svg" alt="img">
                                    </div>
                                    <div class="details">
                                        @if(!empty($company['email'] ?? null))
                                            <p><a href="mailto:{{ $company['email'] }}" class="info-box_link">{{ $company['email'] }}</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">{{ __('site.footer.navigation') }}</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="{{ route('company') }}">{{ __('site.footer.company_profile') }}</a></li>
                                    <li><a href="{{ route('references.index') }}">{{ __('site.nav.references') }}</a></li>
                                    <li><a href="{{ route('blog.index') }}">{{ __('site.nav.blog') }}</a></li>
                                    <li><a href="{{ route('contact') }}">{{ __('site.footer.get_in_touch') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">{{ __('site.footer.information') }}</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="{{ route('company') }}">{{ __('site.footer.mission_values') }}</a></li>
                                    <li><a href="{{ route('references.index') }}">{{ __('site.footer.projects') }}</a></li>
                                    <li><a href="{{ route('contact') }}">{{ __('site.footer.coordinates') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area" data-bg-src="{{Storage::disk('public')->url(\App\Models\SectionContent::where('section',\App\Enums\Section::FOOTER)->where('key',\App\Enums\ContentKey::SECTION_IMAGE)->first()?->value)}}">
        <div class="container th-container2">
            <div class="copyright-wrap bg-white">
                <div class="footer-container">
                    <div class="row gy-2 align-items-center">
                        <div class="col-lg-6">
                            <p class="copyright-text">
                                Copyright <i class="fal fa-copyright"></i> 2026 <a href="{{ route('home') }}">CITABIC</a>, {{ __('site.footer.rights') }} {{ __('site.footer.developed_by') }} <a href="https://devbyzaid.site" target="_blank" rel="noopener noreferrer">Zaid Samadi</a></p>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end">
                            <div class="footer-links">
                                <ul>
                                    <li><a href="{{ route('contact') }}">{{ __('site.nav.contact') }}</a></li>
                                    <li><a href="{{ route('company') }}">{{ __('site.nav.company') }}</a></li>
                                    <li><a href="{{ route('references.index') }}">{{ __('site.nav.references') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
    </svg>
</div>

<script src="{{ asset('guest/assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/gsap.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/lenis.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/jquery.datetimepicker.min.js') }}"></script>
<script src="{{ asset('guest/assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
