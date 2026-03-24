@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . $reference['title'])

@section('content')
    <div class="breadcumb-wrapper"
         data-bg-src="{{ asset(array_find($reference['blocks'],fn($item)=>$item['type'] === 'coverImage')['content']) }}">
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
            @php
                $blocks = $reference['blocks'] ?? [];
            @endphp

            {{-- Hero images render full-width above the grid --}}
            @foreach($blocks as $block)
                @if(($block['type'] ?? '') === 'heroImage' && !empty($block['content']))
                    <div class="page-img mb-40">
                        <img src="{{ $block['content'] }}" alt="{{ $reference['title'] }}">
                    </div>
                @endif
            @endforeach

            <div class="row">
                <div class="col-xxl-8 col-lg-8">
                    <div class="page-single mt-30">
                        @foreach($blocks as $block)
                            @switch($block['type'] ?? '')
                                @case('heroImage')
                                    {{-- Already rendered above --}}
                                    @break
                                @case('heading')
                                    <h2 class="fw-semibold mb-3">{{ $block['content'] ?? '' }}</h2>
                                    @break

                                @case('subheading')
                                    <h4 class="fw-semibold mb-20 mt-50">{{ $block['content'] ?? '' }}</h4>
                                    @break

                                @case('text')
                                    <div class="mb-40">{!! $block['content'] ?? '' !!}</div>
                                    @break

                                @case('image')
                                    <div class="page-img mb-30">
                                        <img src="{{ $block['content'] ?? '' }}" alt="{{ $reference['title'] }}">
                                    </div>
                                    @break
                                @case('coverImage')
                                    @break
                                @case('doubleImage')
                                    <div class="row gx-40 gy-40 align-items-center mb-40">
                                        <div class="col-lg-6">
                                            <div class="page-img">
                                                <img src="{{ $block['image1'] ?? '' }}"
                                                     alt="{{ $reference['title'] }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="page-img">
                                                <img src="{{ $block['image2'] ?? '' }}"
                                                     alt="{{ $reference['title'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    @break

                                @case('imageTextRow')
                                    <div class="row gx-40 gy-40 align-items-center mb-40">
                                        <div class="col-xl-5">
                                            <div class="page-img">
                                                <img src="{{ $block['image'] ?? '' }}"
                                                     alt="{{ $reference['title'] }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-7">
                                            <div class="checklist style5">
                                                <ul>
                                                    @foreach(preg_split('/\r\n|\r|\n/', $block['content'] ?? '') as $line)
                                                        @if(trim($line))
                                                            <li>{{ trim($line) }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('imageText')
                                    <div class="row gx-40 gy-40 align-items-center mb-40">
                                        <div class="col-xl-5">
                                            <div class="page-img">
                                                <img src="{{ $block['image'] ?? '' }}"
                                                     alt="{{ $reference['title'] }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-7">
                                            {!! $block['content'] ?? '' !!}
                                        </div>
                                    </div>
                                    @break

                                @case('list')
                                    <div class="checklist style5 mb-40">
                                        <ul>
                                            @foreach(preg_split('/\r\n|\r|\n/', $block['content'] ?? '') as $line)
                                                @if(trim($line))
                                                    <li>{{ trim($line) }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    @break

                                @case('gallery')
                                    @if(!empty($block['images']))
                                        @php
                                            $galleryImages = $block['images'];
                                            // Optional: Add captions if available
                                            $captions = $block['captions'] ?? [];
                                        @endphp

                                        @if(count($galleryImages) > 0)
                                            <div class="gallery-masonry">
                                                @foreach($galleryImages as $index => $img)
                                                    @php
                                                        $caption = $captions[$index] ?? '';
                                                    @endphp
                                                    <div class="gallery-item"
                                                         data-mfp-src="{{ $img }}">
                                                        <a class="popup-image" href="{{ $img }}">
                                                            <div class="gallery-img-wrapper">
                                                                <img src="{{ $img }}"
                                                                     alt="{{ $caption ?: $reference['title'] }}"
                                                                     loading="lazy">
                                                            </div>
                                                            <div class="gallery-overlay">
                                                                <div class="gallery-icon">
                                                                    <i class="fas fa-search-plus"></i>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                    @break
                            @endswitch
                        @endforeach
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-4">
                    <aside class="sidebar-area">
                        <div class="widget widget_info">
                            <h3 class="widget_title">{{ __('site.reference.project_info') }}</h3>
                            <div class="info-list">
                                <ul>
                                    <li>
                                        <div class="box-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <span class="text">{{ __('site.reference.client') }} :</span>
                                            <strong class="title">{{ $reference['client'] }}</strong>
                                        </div>
                                    </li>
                                    @isset($reference['surface'])
                                        <li>
                                            <div class="box-icon">
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                            <div>
                                                <span class="text">{{ __('site.reference.surface') }} :</span>
                                                <strong class="title">{{ $reference['surface'] }}</strong>
                                            </div>
                                        </li>
                                    @endisset
                                    @isset($reference['budget'])
                                        <li>
                                            <div class="box-icon">
                                                <i class="fas fa-cash-register"></i>
                                            </div>
                                            <div>
                                                <span class="text">{{ __('site.reference.budget') }} :</span>
                                                <strong class="title">{{ $reference['budget'] }}</strong>
                                            </div>
                                        </li>
                                    @endisset
                                    @isset($reference['year'])
                                        <li>
                                            <div class="box-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div>
                                                <span class="text">{{ __('site.reference.year') }} :</span>
                                                <strong class="title">{{ $reference['year'] }}</strong>
                                            </div>
                                        </li>
                                    @endisset
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
