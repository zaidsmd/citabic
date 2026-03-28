<!doctype html>
<html lang="fr">
<!-- [Head] start -->

<head>
    <title>@yield('title') | CITABIC </title>
    @include('admin.layouts/head-page-meta')

    @yield('css')
    @stack('css')

    @include('admin.layouts/head-css')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->
<body data-pc-preset="{{config('app.preset_theme')}}" data-pc-sidebar-caption="{{config('app.caption_show')}}" data-pc-layout="{{config('app.theme_layout')}}" data-pc-direction="{{config('app.rtlflag')}}" data-pc-theme="{{config('app.dark_layout') ?  config('app.dark_layout') == 'default' ?? 'dark' : 'light'}}">

    @include('admin.layouts/layout-vertical')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->
    @include('admin.layouts/footer-block')

    @include('admin.layouts/footer-js')

    @hasSection('scripts')
        @yield('scripts')
    @else
        @stack('scripts')

    @endif
</body>
<!-- [Body] end -->

</html>
