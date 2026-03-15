@extends('admin.layouts.master-components')

@section('title', 'Tree View')

@section('css')
<!-- [Page specific CSS] start -->
    <!-- jstree css -->
    <link rel="stylesheet" href="/build/css/plugins/vanillatree.css" />
    <!-- Page specific CSS end  -->
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
              <x-component-breadcrumb item="Tree View" text="Standalone tree view library" link="https://github.com/finom/vanillatree"/>
            </div>
            <!-- [ Main Content ] start -->
            <div class="row">
              <!-- [ rangeslider ] start -->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>HTML Demo</h5>
                  </div>
                  <div class="card-body">
                    <div id="tree-demo"> </div>
                    <p id="tree-msg"></p>
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
    <!-- jstree Js -->
    <script src="/build/js/plugins/vanillatree.min.js"></script>
    <script src="/build/js/elements/ac-treeview.js"></script>
    <!-- [Page Specific JS] end -->
@endsection
