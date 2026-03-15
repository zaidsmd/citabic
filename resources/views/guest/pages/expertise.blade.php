@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . __('site.nav.expertise'))

@section('content')
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ __('site.breadcrumbs.expertise') }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                    <li>{{ __('site.breadcrumbs.expertise') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="space-top space-extra2-bottom">
        <div class="container">
            <div class="row gy-4">
                @foreach ($site['domains'] as $domain)
                    <div class="col-md-6 col-xl-4">
                        <div class="property-card6">
                            <div class="property-card-thumb img-shine">
                                <img src="{{ asset('guest/assets/img/property/property6-' . (($loop->index % 6) + 1) . '.png') }}" alt="img">
                            </div>
                            <div class="property-card-details">
                                <h4 class="property-card-title"><a href="{{ route('expertise') }}">{{ $domain['title'] }}</a></h4>
                                <p class="property-card-text">{{ implode(' . ', $domain['items']) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="space bg-smoke4">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="appointment-wrap2">
                        <span class="sub-title3">{{ __('site.expertise.certifications') }}</span>
                        <h2 class="form-title">{{ __('site.expertise.standards') }}</h2>
                        <div class="checklist style5">
                            <ul>
                                @foreach ($site['certifications'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                                @foreach ($site['compliance'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-wrap4 bg-smoke4 h-100">
                        <div class="title-area mb-30">
                            <span class="sub-title">{{ __('site.expertise.system') }}</span>
                            <h2 class="sec-title">{{ __('site.expertise.system_title') }}</h2>
                            <p class="sec-text">{{ $site['information_system'] }}</p>
                        </div>
                        <div class="checklist style5">
                            <ul>
                                @foreach ($site['partnerships'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
