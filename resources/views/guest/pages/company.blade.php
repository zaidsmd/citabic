@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . __('site.nav.company'))

@section('content')
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
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

    <div class="overflow-hidden space-top bg-smoke3">
        <div class="container">
            <div class="row gy-40">
                <div class="col-lg-6">
                    <div class="img-box1">
                        <div class="img1 img-shine" data-mask-src="{{ asset('guest/assets/img/shape/about-1-mask.png') }}">
                            <img src="{{ asset('guest/assets/img/citabic/cover-01.png') }}" alt="CITABIC">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="title-area">
                        <h2 class="sec-title">{{ __('site.company.title') }}</h2>
                        <p class="sec-text">{{ __('site.company.intro') }}</p>
                    </div>
                    <div class="checklist style5">
                        <ul>
                            <li>{{ __('site.company.legal_name') }} : {{ $company['legal_name'] }}</li>
                            <li>{{ __('site.company.legal_form') }} : {{ $company['legal_form'] }}</li>
                            <li>{{ __('site.company.capital') }} : {{ $company['capital'] }}</li>
                            <li>{{ __('site.company.ice') }} : {{ $company['ice'] }}</li>
                            <li>{{ __('site.company.rc') }} : {{ $company['rc'] }}</li>
                            <li>{{ __('site.company.office') }} : {{ $company['head_office'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="service-area-1 overflow-hidden space-bottom bg-smoke3 pt-80">
        <div class="container">
            <div class="row gy-40">
                @foreach ($site['values'] as $value)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card">
                            <div class="service-card-icon">
                                <div class="icon">
                                    <img src="{{ asset('guest/assets/img/icon/checkmark2.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="box-content">
                                <h3 class="box-title">{{ $value['title'] }}</h3>
                                <p class="box-text text-body">{{ $value['text'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="space">
        <div class="container">
            <div class="counter-card-wrap">
                @foreach (array_slice($site['figures'], 0, 4) as $figure)
                    <div class="counter-card style4">
                        <div class="media-body">
                            <h2 class="box-number">{{ $figure['value'] }}</h2>
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
                        <h2 class="sec-title text-white">{{ __('site.company.mission_process') }}</h2>
                        <p class="sec-text text-white">{{ __('site.company.mission_process_text') }}</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                @foreach ($site['processes'] as $item)
                    <div class="col-xl-4 col-md-6">
                        <div class="process-card2" data-bg-src="{{ asset('guest/assets/img/bg/process-card2-bg.png') }}">
                            <div class="box-icon"><img src="{{ asset('guest/assets/img/icon/process_card_2_' . (($loop->index % 3) + 1) . '.svg') }}" alt="icon"></div>
                            <div class="box-content">
                                <h3 class="box-title">{{ $item['title'] }}</h3>
                                <p class="box-text">{{ $item['description'] }}</p>
                                <p class="box-number">{{ __('site.company.block_label') }} - {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
