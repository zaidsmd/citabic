@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . __('site.nav.references'))

@section('content')
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ __('site.breadcrumbs.references') }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                    <li>{{ __('site.breadcrumbs.references') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="space-top space-extra2-bottom">
        <div class="container">
            <div class="row gy-40">
                @foreach ($references as $reference)
                    <div class="col-md-6 col-xl-4">
                        <div class="property-card7 style2">
                            <div class="property-card-thumb img-shine">
                                <img src="{{ $reference['image_url'] ?? asset($reference['image']) }}" alt="{{ $reference['title'] }}">
                            </div>
                            <div class="property-card-details">
                                <div class="media-left">
                                    <h4 class="property-card-title"><a href="{{ route('references.show', $reference['slug']) }}">{{ $reference['title'] }}</a></h4>
                                    <p class="property-card-subtitle">{{ $reference['client'] }}</p>
                                </div>
                                <div class="btn-wrap">
                                    <a href="{{ route('references.show', $reference['slug']) }}" class="icon-btn"><img src="{{ asset('guest/assets/img/icon/arrow-right.svg') }}" alt=""></a>
                                </div>
                            </div>
                            <div class="property-card-details pt-0">
                                <p class="property-card-text">{{ $reference['summary'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
