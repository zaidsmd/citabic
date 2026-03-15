@extends('admin.layouts.master-components')

@section('title', 'DatePicker')

@section('css')
    <!-- [Page specific CSS] start -->
    <!-- Bootstrap DatePicker -->
    <link rel="stylesheet" href="/build/css/plugins/datepicker-bs5.min.css" />
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
              <x-component-breadcrumb item="DatePicker" text="Bootstrap-datepicker provides a flexible datepicker widget in the Bootstrap style." link="https://bootstrap-datepicker.readthedocs.io/en/latest"/>
            </div>
            <!-- [ Main Content ] start -->
            <div class="row">
              <!-- [ bootstrap-datetimepicker ] start -->
              <div class="col-xl-4 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Days of Week Disabled</h5>
                  </div>
                  <div class="card-body">
                    <input type="text" class="form-control" id="d_week" />
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Days of Week Highlighted</h5>
                  </div>
                  <div class="card-body">
                    <input type="text" class="form-control" id="d_highlight" />
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>AutoClose</h5>
                  </div>
                  <div class="card-body">
                    <input type="text" class="form-control" id="d_auto" />
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>DatesDisabled</h5>
                  </div>
                  <div class="card-body">
                    <input type="text" class="form-control" id="d_disable" />
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Today Highlight</h5>
                  </div>
                  <div class="card-body">
                    <input type="text" class="form-control" id="d_today" />
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Calendar Weeks</h5>
                  </div>
                  <div class="card-body">
                    <input type="text" class="form-control" id="disp_week" />
                  </div>
                </div>
              </div>
              <div class="col-xl-8 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Date Range</h5>
                  </div>
                  <div class="card-body">
                    <div class="input-daterange input-group" id="datepicker_range">
                      <input type="text" class="form-control text-left" placeholder="Start date" name="range-start" />
                      <input type="text" class="form-control text-end" placeholder="End date" name="range-end" />
                    </div>
                  </div>
                </div>
              </div>
              <!-- [ bootstrap-datetimepicker ] End -->
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
    <!-- DatePicker js -->
    <script src="/build/js/plugins/datepicker-full.min.js"></script>
    <script src="/build/js/elements/ac-datepicker.js"></script>
    <!-- [Page Specific JS] end -->
@endsection
