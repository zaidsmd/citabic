@extends('admin.layouts.master')

@section('title', 'ReCaptcha')

@section('content')

<x-breadcrumb item="Forms" active="ReCaptcha"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- prettier-ignore -->
          <x-link title="ReCaptcha" text="reCAPTCHA uses an advanced risk analysis engine and adaptive challenges to keep malicious software from engaging in abusive activities on your website." link="https://www.google.com/recaptcha/about/"/>
        </div>
        <div class="row">
          <!-- [ form-element ] start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <form>
                  <div class="row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">reCaptcha</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                      <div class="g-recaptcha" data-sitekey="6LdnLwgUAAAAAAIb9L3PQlHQgvSCi16sYgbMIMFR"></div>
                    </div>
                    <script src="https://www.google.com/recaptcha/api.js"></script>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- [ form-element ] end -->

@endsection
