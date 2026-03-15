@extends('admin.layouts.master')

@section('title', 'File Upload')

@section('css')
    <!-- [Page specific CSS] start -->
    <!-- fileupload-custom css -->
    <link rel="stylesheet" href="/build/css/plugins/dropzone.min.css" />
    <!-- [Page specific CSS] end -->
@endsection

@section('content')

    <!-- [ Main Content ] start -->
    <section class="pc-container">
      <div class="pc-content">
        <x-breadcrumb item="Forms" active="File Upload"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- prettier-ignore -->
          <x-link title="Dropzone" text="Dropzone.js is one of the most popular drag and drop JavaScript libraries. It is free, fully open source, and makes it easy for you to handle dropped files on your website." link="https://www.dropzone.dev/"/>
        </div>
        <div class="row">
          <!-- [ file-upload ] start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>File Upload</h5>
              </div>
              <div class="card-body">
                <form action="/build/json/file-upload.php" class="dropzone">
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                </form>
                <div class="text-center m-t-20">
                  <button class="btn btn-primary">Upload Now</button>
                </div>
              </div>
            </div>
          </div>
          <!-- [ file-upload ] end -->
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </section>
@endsection

@section('scripts')
    <!-- [Page Specific JS] start -->
    <!-- file-upload Js -->
    <script src="/build/js/plugins/dropzone-amd-module.min.js"></script>
    <!-- [Page Specific JS] end -->
@endsection
