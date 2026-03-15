@extends('admin.layouts.master')

@section('title', 'Date Range Picker')
@section('css')
<!-- [Page specific CSS] start -->
    <link rel="stylesheet" href="/build/css/plugins/flatpickr.min.css" />

<!-- [Page specific CSS] end -->
@endsection

@section('content')
<x-breadcrumb item="Forms" active="Date Range Picker"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- prettier-ignore -->
          <x-link title="Date Range Picker" text="flatpickr is a lightweight and powerful datetime picker. Lean, UX-driven, and extensible, yet it doesn’t depend on any libraries. There’s minimal UI but many themes. Rich, exposed APIs and event system make it suitable for any environment." link="https://flatpickr.js.org/examples/"/>
        </div>
        <div class="row">
          <!-- [ form-element ] start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>Preview</h5>
              </div>
              <div class="card-body">
                <form>
                  <div class="mb-3 row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Simple Input</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <input type="text" class="form-control" id="pc-date_range_picker-1" placeholder="Select date range" />
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">With Input Group</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <div class="input-group">
                        <input type="text" id="pc-date_range_picker-2" class="form-control" placeholder="Select date range" />
                        <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Disable date</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <input type="text" class="form-control" id="pc-date_range_picker-3" />
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Predefined Ranges</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <input type="text" class="form-control" id="pc-date_range_picker-4" placeholder="Select date range" />
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- [ form-element ] end -->
        </div>
        <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <!-- [Page Specific JS] start -->
    <!-- daterangepicker -->
    <script src="/build/js/plugins/flatpickr.min.js"></script>
    <script>
      // minimum setup
      flatpickr(document.querySelector('#pc-date_range_picker-1'), {
        mode: 'range'
      });
      flatpickr(document.querySelector('#pc-date_range_picker-2'), {
        mode: 'range'
      });
      flatpickr(document.querySelector('#pc-date_range_picker-3'), {
        mode: 'range',
        minDate: 'today',
        dateFormat: 'Y-m-d',
        disable: [
          function (date) {
            return !(date.getDate() % 8);
          }
        ]
      });
      flatpickr(document.querySelector('#pc-date_range_picker-4'), {
        mode: 'range',
        dateFormat: 'Y-m-d',
        defaultDate: ['2016-10-10', '2016-10-20']
      });
    </script>
    <!-- [Page Specific JS] end -->
@endsection
