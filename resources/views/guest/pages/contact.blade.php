@extends('guest.layouts.app-template')

@section('title', $contactPage['seo']['title'])
@section('meta_description', $contactPage['seo']['description'])
@section('meta_keywords', $contactPage['seo']['keywords'])
@section('og_title', $contactPage['seo']['og_title'])
@section('og_description', $contactPage['seo']['og_description'])
@section('og_image', $contactPage['seo']['og_image'])
@section('twitter_title', $contactPage['seo']['og_title'])
@section('twitter_description', $contactPage['seo']['og_description'])
@section('twitter_image', $contactPage['seo']['og_image'])
@section('twitter_card', $contactPage['seo']['twitter_card'])

@section('content')
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="breadcumb-overlay" data-bg-src="{{ asset('guest/assets/img/bg/breadcumb-bg-overlay.png') }}"></div>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ __('site.breadcrumbs.contact') }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">{{ __('site.nav.home') }}</a></li>
                    <li>{{ __('site.breadcrumbs.contact') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="space" id="contact-sec">
        <div class="contact-bg-shape1-1 jump shape-mockup" data-bottom="30%" data-left="2%">
            <img src="{{asset('guest/assets/img/shape/section_shape_2_3.jpg')}}" alt="img">
        </div>
        <div class="container">
            <div class="row gx-35">
                <div class="col-lg-5">
                    <div class="about-contact-grid">
                        <div class="about-contact-icon text-white">
                            <img src="{{asset('guest/assets/img/icon/location-dot.svg')}}" alt="icon">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="about-contact-details-title">{{ __('site.contact.address') }}:</h6>
                            <p class="about-contact-details-text">{{$company['head_office']}}</p>
                        </div>
                    </div>
                    <div class="about-contact-grid">
                        <div class="about-contact-icon text-white">
                            <img src="{{asset('guest/assets/img/icon/phone.svg')}}" alt="icon">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="about-contact-details-title">{{ __('site.contact.phone') }}:</h6>
                            <p class="about-contact-details-text"><a href="tel:{{ preg_replace('/\s+/', '', $company['phone']) }}">{{ $company['phone'] }}</a></p>
                        </div>
                    </div>
                    <div class="about-contact-grid">
                        <div class="about-contact-icon text-white">
                            <img src="{{asset('guest/assets/img/icon/envelope.svg')}}" alt="icon">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="about-contact-details-title">Email:</h6>
                            <p class="about-contact-details-text"><a href="mailto:{{ $company['email'] }}">{{ $company['email'] }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="location-map contact-sec-map">
            <div class="contact-map">
                {!! $contactPage['map_embed'] !!}
            </div>
            <div class="location-map-address">
                <div class="thumb">
                    <img src="{{asset('guest/assets/img/logo.svg')}}" alt="img">
                </div>
                <div class="media-body">
                    <h4 class="title">{{ __('site.contact.address') }}:</h4>
                    <p class="text">{{$company['head_office']}}</p>
                </div>
            </div>
        </div>
    </div>


    <div class="space contact-area-5 z-index-common" id="contact-sec">
        <div class="contact-thumb6-1">
            <img src="{{ $contactPage['contact_image_url'] }}" alt="img">
        </div>
        <div class="container">
            <div class="row gx-60 gy-60 justify-content-end">
                <div class="col-lg-6">
                    <div class="appointment-wrap contact-wrap6">
                        <h2 class="form-title fw-semibold mb-35">{!! $contactPage['form_title'] !!}</h2>
                        <form action="{{ route('contact.submit') }}" method="POST" class="appointment-form ajax-contact">
                            @csrf
                            <div class="row">
                                <div class="form-group style-border2 style-radius col-lg-6">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('site.contact.name_placeholder') }}">
                                    <i class="fal fa-user"></i>
                                </div>
                                <div class="form-group style-border2 style-radius col-lg-6">
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
                                    <textarea name="message" placeholder="{{ __('site.contact.message_placeholder') }}" class="form-control"></textarea>
                                </div>
                                <div class="col-12 form-btn">
                                    <button class="th-btn style4">{{ __('site.actions.send') }} <span class="btn-icon"><img src="{{ asset('guest/assets/img/icon/paper-plane.svg') }}" alt="img"></span></button>
                                </div>
                            </div>
                            <p class="form-messages mb-0 mt-3"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
