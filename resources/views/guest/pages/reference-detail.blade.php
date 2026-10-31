@extends('guest.layouts.app-template')

@section('title', 'CITABIC | ' . $reference['title'])

@push('styles')
<style>
    .gallery-video-play-badge {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 54px;
        height: 54px;
        background: rgba(0, 0, 0, 0.65);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: transform 0.3s ease, background 0.3s ease;
        pointer-events: none;
        box-shadow: 0 4px 16px rgba(0,0,0,0.35);
        z-index: 2;
    }
    .gallery-item:hover .gallery-video-play-badge {
        background: var(--theme-color, #c82333);
        transform: translate(-50%, -50%) scale(1.15);
    }
    .gallery-video-modal {
        max-width: 900px;
        margin: 0 auto;
        background: #000;
        border-radius: 8px;
        overflow: hidden;
        padding: 0;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }
    .gallery-video-modal video {
        display: block;
        width: 100%;
        max-height: 80vh;
        background: #000;
    }
</style>
@endpush

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

                                @case('video')
                                    @php
                                        $videoSrc = $block['stream_url'] ?? $block['content'] ?? '';
                                        $videoPoster = $block['poster_url'] ?? $block['poster'] ?? '';
                                    @endphp
                                    @if($videoSrc)
                                        <div class="page-img mb-40">
                                            <video controls preload="metadata" playsinline class="w-100 rounded" poster="{{ $videoPoster }}" style="max-height: 520px; background: #000; object-fit: cover;">
                                                <source src="{{ $videoSrc }}" type="video/mp4">
                                                Your browser does not support HTML5 video.
                                            </video>
                                        </div>
                                    @endif
                                    @break

                                @case('gallery')
                                    @if(!empty($block['images']))
                                        @php
                                            $galleryImages = $block['images'];
                                            $galleryItems = $block['items'] ?? [];
                                            $captions = $block['captions'] ?? [];
                                        @endphp

                                        @if(count($galleryImages) > 0)
                                            <div class="gallery-masonry">
                                                @foreach($galleryImages as $index => $img)
                                                    @php
                                                        $caption = $captions[$index] ?? '';
                                                        $item = $galleryItems[$index] ?? null;
                                                        $cleanPath = is_string($img) ? str_replace('storage/', '', ltrim(parse_url($img, PHP_URL_PATH) ?? '', '/')) : '';
                                                        $isVideo = ($item['type'] ?? '') === 'video' || (is_string($img) && preg_match('/\.(mp4|webm|ogg|mov)$/i', $cleanPath));
                                                        $videoStream = $item['stream_url'] ?? ($cleanPath ? route('media.stream', ['path' => $cleanPath]) : $img);
                                                        $videoPoster = $item['poster_url'] ?? null;
                                                        $modalId = 'gallery-video-modal-' . $loop->parent->index . '-' . $index;
                                                    @endphp
                                                    <div class="gallery-item">
                                                        @if($isVideo)
                                                            <a class="popup-content" href="#{{ $modalId }}">
                                                                <div class="gallery-img-wrapper position-relative">
                                                                    @if($videoPoster)
                                                                        <img src="{{ $videoPoster }}" alt="{{ $caption ?: $reference['title'] }}" loading="lazy">
                                                                    @else
                                                                        <video preload="metadata" muted playsinline style="width: 100%; height: 100%; object-fit: cover; display: block; min-height: 220px; background: #000;">
                                                                            <source src="{{ $videoStream }}#t=0.5" type="video/mp4">
                                                                        </video>
                                                                    @endif
                                                                    <span class="gallery-video-play-badge">
                                                                        <i class="fas fa-play"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="gallery-overlay">
                                                                    <div class="gallery-icon">
                                                                        <i class="fas fa-play"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div id="{{ $modalId }}" class="mfp-hide white-popup-block gallery-video-modal">
                                                                <video controls preload="metadata" playsinline class="w-100" poster="{{ $videoPoster }}">
                                                                    <source src="{{ $videoStream }}" type="video/mp4">
                                                                    Your browser does not support HTML5 video.
                                                                </video>
                                                            </div>
                                                        @else
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
                                                        @endif
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.jQuery) {
            window.jQuery(document).on('mfpClose', function () {
                document.querySelectorAll('.gallery-video-modal video').forEach(function (v) {
                    v.pause();
                });
            });
        }
    });
</script>
@endpush
