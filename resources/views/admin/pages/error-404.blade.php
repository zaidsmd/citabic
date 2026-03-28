@extends('admin.layouts.master-auth')

@section('title', __('admin.errors.404.code'))

@section('content')

    @include('admin.layouts/loader')
    <!-- [ Main Content ] start -->
    <div class="maintenance-block">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="card error-card">
              <div class="card-body">
                <div class="error-image-block">
                  <img class="img-fluid" src="{{asset('build/images/pages/img-error-404.svg')}}" alt="img" />
                </div>
                <div class="text-center">
                  <h1 class="mt-5"><b>{{ __('admin.errors.404.title') }}</b></h1>
                  <p class="mt-2 mb-4 text-muted">
                      {!! __('admin.errors.404.message') !!}
                  </p>
                  <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3">{{ __('admin.errors.back_home') }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
