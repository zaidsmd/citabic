@extends('guest.layouts.app-template-floating-footer')

@php
    $statusCode = (int) ($statusCode ?? 404);
    $statusCode = in_array($statusCode, [404, 500], true) ? $statusCode : 404;
    $translationPrefix = "site.errors.{$statusCode}";
@endphp

@section('title', __('site.errors.page_title', ['code' => $statusCode]))

@section('content')
    <section class="space overflow-hidden error-area-1">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="error-img mb-60">
                        <img src="{{ asset('guest/assets/img/normal/error_1_1.svg') }}" alt="{{ __('site.errors.image_alt') }}">
                    </div>
                    <div class="error-content">
                        <h2 class="error-title">{{ __($translationPrefix . '.title') }}</h2>
                        <p class="error-text">{{ __($translationPrefix . '.description') }}</p>
                        <a href="{{ route('home') }}" class="th-btn style4">
                            <i class="far fa-home"></i> {{ __('site.errors.back_home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
