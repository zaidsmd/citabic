@extends('admin.layouts.master-auth')

@section('title', __('admin.errors.500.code'))

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
                  <div class="row justify-content-center">
                    <div class="col-10">
                      <img class="img-fluid" src="{{asset('/build/images/pages/img-error-500.svg')}}" alt="img" />
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <h1 class="mt-4"><b>{{ __('admin.errors.500.title') }}</b></h1>
                  <p class="mt-2 mb-4 text-sm text-muted">
                      {!! __('admin.errors.500.message') !!}
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
