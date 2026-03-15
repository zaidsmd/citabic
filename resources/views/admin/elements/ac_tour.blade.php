@extends('admin.layouts.master-components')

@section('title', 'Tour')

@section('css')
    <!-- [Page specific CSS] start -->
    <!-- enjoyhint css -->
    <link rel="stylesheet" href="/build/css/plugins/introjs.min.css" />
@endsection

@section('css2')
    <link rel="stylesheet" href="/build/css/uikit.css" />
@endsection

@section('bodyClass', 'component-page')

@section('content')
    <!-- [ Main Content ] start -->
    @include('admin.layouts/loader')
    @include('admin.layouts/component-header')
    <section class="component-block">
      <div class="container">
        <div class="row">
          <div class="col-xl-3"> @include('admin.layouts/component-menu-list') </div>
          <div class="col-xl-9">
            <div class="row">
              <!-- prettier-ignore -->
              <x-component-breadcrumb item="Tour" text="Intro.js is a lightweight JavaScript library for creating step-by-step and powerful customer onboarding tours" link="https://introjs.com"/>
            </div>
            <!-- [ Main Content ] start -->
            <div class="row">
              <!-- [ rangeslider ] start -->
              <div class="col-sm-12">
                <div class="card step1">
                  <div class="card-header step2">
                    <h5 class="step3">Hello card</h5>
                  </div>
                  <div class="card-body step4">
                    <h1>H1 Admin Template</h1>
                    <h2>H2 Admin Template</h2>
                    <h3>H3 Admin Template</h3>
                    <h4>H4 Admin Template</h4>
                    <h5>H5 Admin Template</h5>
                    <h6>H6 Admin Template</h6>
                    <p>p Admin Template</p>
                    <strong>p Admin Template</strong>
                  </div>
                </div>
              </div>
              <!-- [ rangeslider ] end -->
            </div>
            <!-- [ Main Content ] end -->
          </div>
        </div>
      </div>
    </section>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <!-- [Page Specific JS] start -->
    <!-- tour Js -->
    <script src="/build/js/plugins/intro.min.js"></script>
    <script src="/build/js/elements/ac-tour.js"></script>
    <!-- [Page Specific JS] end -->
@endsection
