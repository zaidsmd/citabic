<!doctype html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    @include('admin.layouts/head-page-meta')

    @yield('css')

    @include('admin.layouts/head-css')

    @yield('css2')
  </head>
<!-- [Body] Start -->

<body class="@yield('bodyClass')" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme="light" data-pc-preset="preset-1">
    <!-- component-page -->
    @yield('content')

    <!-- [ Main Content ] end -->

    @include('admin.layouts/customizer')

    @include('admin.layouts/footer-js')

    @yield('scripts')
</body>
<!-- [Body] end -->

</html>
