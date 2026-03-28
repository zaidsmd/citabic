<!doctype html>
<html lang="en">
  <head>
    <title>@yield('title') | Able Pro Dashboard Template</title>
    @include('admin.layouts/head-page-meta')

    @yield('css')

    @include('admin.layouts/head-css')
  </head>
<!-- [Body] Start -->
<body class="@yield('bodyClass')" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme="light" data-pc-preset="preset-1">
    <!-- component-page -->
    @yield('content')

    <!-- [ Main Content ] end -->


    @include('admin.layouts/footer-js')

    @yield('scripts')
</body>
<!-- [Body] end -->

</html>
