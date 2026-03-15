@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . $reference['title'])

@section('content')
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $reference['title'] }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                    <li><a href="{{ route('references.index') }}">{{ __('site.breadcrumbs.references') }}</a></li>
                    <li>{{ $reference['title'] }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="project-details-page space-top space-extra2-bottom">
        <div class="container">
            <div class="row gy-40">
                <div class="col-xl-7">
                    <div class="project-details-thumb">
                        <img src="{{ $reference['image_url'] ?? asset($reference['image']) }}" alt="{{ $reference['title'] }}">
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="project-details-wrap">
                        <div class="title-area">
                            <h2 class="sec-title">{{ $reference['title'] }}</h2>
                            <p class="sec-text">{{ $reference['description'] }}</p>
                        </div>
                        <div class="checklist style5">
                            <ul>
                                @foreach ($reference['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="project-meta-wrap mt-30">
                            <div class="project-meta">
                                <span class="title">{{ __('site.reference.client') }}:</span>
                                <span>{{ $reference['client'] }}</span>
                            </div>
                            @isset($reference['surface'])
                                <div class="project-meta">
                                    <span class="title">{{ __('site.reference.surface') }}:</span>
                                    <span>{{ $reference['surface'] }}</span>
                                </div>
                            @endisset
                            @isset($reference['budget'])
                                <div class="project-meta">
                                    <span class="title">{{ __('site.reference.budget') }}:</span>
                                    <span>{{ $reference['budget'] }}</span>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
