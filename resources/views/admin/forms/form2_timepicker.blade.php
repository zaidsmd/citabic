@extends('admin.layouts.master')

@section('title', 'Timepicker')
@section('css')
<!-- \[Page specific CSS\] start -->
    <link rel="stylesheet" href="/build/css/plugins/flatpickr.min.css" />

<!-- [Page specific CSS] end -->
@endsection

@section('content')
<x-breadcrumb item="Forms" active="Timepicker"/>


        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- prettier-ignore -->
          <x-link title="Time Picker" text="flatpickr is a lightweight and powerful datetime picker. Lean, UX-driven, and extensible, yet it doesn’t depend on any libraries. There’s minimal UI but many themes. Rich, exposed APIs and event system make it suitable for any environment." link="https://flatpickr.js.org/examples/"/>
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
                      <input class="form-control" id="pc-timepicker-1" placeholder="Select time" type="text" />
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">With Input Group</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <div class="input-group timepicker">
                        <input class="form-control" id="pc-timepicker-2" placeholder="Select time" type="text" />
                        <span class="input-group-text">
                          <i class="feather icon-clock"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">24 Hours</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <input class="form-control" id="pc-timepicker-3" type="text" placeholder="Select time" />
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Time Picker w/ Limits</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <input class="form-control" id="pc-timepicker-4" type="text" placeholder="Select time" />
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Preloading Time</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <input class="form-control" id="pc-timepicker-5" type="text" placeholder="Select time" />
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
    <!-- Time picker -->
    <script src="/build/js/plugins/flatpickr.min.js"></script>
    <script>
      document.querySelector('#pc-timepicker-1').flatpickr({
        enableTime: true,
        noCalendar: true
      });
      document.querySelector('#pc-timepicker-2').flatpickr({
        enableTime: true,
        noCalendar: true
      });
      document.querySelector('#pc-timepicker-3').flatpickr({
        enableTime: true,
        noCalendar: true,
        time_24hr: true
      });
      document.querySelector('#pc-timepicker-4').flatpickr({
        enableTime: true,
        noCalendar: true,
        minTime: '16:00',
        maxTime: '22:30'
      });
      document.querySelector('#pc-timepicker-5').flatpickr({
        enableTime: true,
        noCalendar: true,
        defaultDate: '13:45'
      });
    </script>
    <!-- [Page Specific JS] end -->
@endsection
