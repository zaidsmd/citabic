<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'CITABIC')</title>
    <meta name="author" content="CITABIC">
    <meta name="description" content="@yield('meta_description', __('site.meta_description'))">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('guest/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('guest/assets/css/bootstrap.min.css') }}">
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
    </style>
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
                    <li><a href="{{ route('expertise') }}">{{ __('site.nav.expertise') }}</a></li>
                    <li><a href="{{ route('references.index') }}">{{ __('site.nav.references') }}</a></li>
                    <li><a href="{{ route('blog.index') }}">{{ __('site.nav.blog') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('site.nav.contact') }}</a></li>
                </ul>
                <div class="mobile-lang-switcher">
                    <div class="lang-switcher">
                        <div class="lang-switcher-track">
                            <a href="{{ route('locale.switch', 'fr') }}"
                               class="lang-switcher-link{{ $currentLocale === 'fr' ? ' is-active' : '' }}"
                               @if ($currentLocale === 'fr') aria-current="true" @endif>
                                {{ __('site.language.fr') }} <small>{{ __('site.language.fr_name') }}</small>
                            </a>
                            <a href="{{ route('locale.switch', 'en') }}"
                               class="lang-switcher-link{{ $currentLocale === 'en' ? ' is-active' : '' }}"
                               @if ($currentLocale === 'en') aria-current="true" @endif>
                                {{ __('site.language.en') }} <small>{{ __('site.language.en_name') }}</small>
                            </a>
                        </div>
                    </div>
                </div>
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
                                    <li><a href="{{ route('expertise') }}">{{ __('site.nav.expertise') }}</a></li>
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
                                <div class="lang-switcher me-3">
                                    <div class="lang-switcher-track">
                                        <a href="{{ route('locale.switch', 'fr') }}"
                                           class="lang-switcher-link{{ $currentLocale === 'fr' ? ' is-active' : '' }}"
                                           @if ($currentLocale === 'fr') aria-current="true" @endif>
                                            {{ __('site.language.fr') }} <small>{{ __('site.language.fr_name') }}</small>
                                        </a>
                                        <a href="{{ route('locale.switch', 'en') }}"
                                           class="lang-switcher-link{{ $currentLocale === 'en' ? ' is-active' : '' }}"
                                           @if ($currentLocale === 'en') aria-current="true" @endif>
                                            {{ __('site.language.en') }} <small>{{ __('site.language.en_name') }}</small>
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ route('contact') }}" class="th-btn style4 th-btn-icon">{{ __('site.actions.request_meeting') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="footer-wrapper footer-default bg-black2">
        <div class="container">
            <div class="footer-wrap ">
                <div class="widget-area">
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xl-4">
                            <div class="widget footer-widget">
                                <div class="th-widget-about">
                                    <div class="about-logo">
                                        <a href="{{ route('home') }}"><img src="{{ asset('guest/assets/img/logo-white.svg') }}" alt="CITABIC"></a>
                                    </div>
                                    <p class="about-text">{{ __('site.footer.about') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget footer-widget">
                                <h3 class="widget_title">{{ __('site.footer.coordinates') }}</h3>
                                <div class="th-widget-contact">
                                    <div class="info-box_text">
                                        <div class="icon"><img src="{{ asset('guest/assets/img/icon/location-dot.svg') }}" alt="img"></div>
                                        <div class="details">
                                            <p>{{ $company['head_office'] }}</p>
                                        </div>
                                    </div>
                                    <div class="info-box_text">
                                        <div class="icon"><img src="{{ asset('guest/assets/img/icon/phone.svg') }}" alt="img"></div>
                                        <div class="details">
                                            <p><a href="tel:{{ preg_replace('/\s+/', '', $company['phone']) }}" class="info-box_link">{{ $company['phone'] }}</a></p>
                                        </div>
                                    </div>
                                    <div class="info-box_text">
                                        <div class="icon"><img src="{{ asset('guest/assets/img/icon/envelope.svg') }}" alt="img"></div>
                                        <div class="details">
                                            <p><a href="mailto:{{ $company['email'] }}" class="info-box_link">{{ $company['email'] }}</a></p>
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
                                        <li><a href="{{ route('expertise') }}">{{ __('site.footer.activity_domains') }}</a></li>
                                        <li><a href="{{ route('references.index') }}">{{ __('site.nav.references') }}</a></li>
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
                                        <li><a href="{{ route('expertise') }}">{{ __('site.footer.certifications') }}</a></li>
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
        <div class="copyright-wrap bg-gray">
            <div class="container">
                <div class="row gy-2 align-items-center">
                    <div class="col-lg-6">
                        <p class="copyright-text text-white">Copyright <i class="fal fa-copyright"></i> 2026 <a href="{{ route('home') }}">CITABIC</a>, {{ __('site.footer.rights') }}</p>
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
