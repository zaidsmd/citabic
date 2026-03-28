<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{route('admin.dashboard')}}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{asset('guest/assets/img/logo.svg')}}" class="img-fluid logo-lg" alt="logo"/>
                <span
                    class="badge bg-light-success rounded-pill ms-2 theme-version">{{ config('app.APP_VERSION') }}</span>
            </a>
        </div>
        <div class="navbar-content">
            <div class="card pc-user-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="rounded-circle wid-40 bg-primary ratio-1x1 d-flex align-items-center justify-content-center"
                                style="height: 40px;">
                                <p class="m-0 fw-bold text-white">
                                    {{auth()->user()->name ? str_split(auth()->user()->name,1)[0] : 'A'}}
                                </p>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <h6 class="mb-0">{{auth()->user()->name}}</h6>
                            <small>{{auth()->user()->email}}</small>
                        </div>
                        <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse"
                           href="#pc_sidebar_userlink">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sort-outline"></use>
                            </svg>
                        </a>
                    </div>
                    <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                        <div class="pt-3">
                            <form method="post" action="{{route('admin.logout')}}">
                                @csrf
                                <a href="#"  role="button" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="ti ti-power"></i>
                                    <span >@lang('admin.common.logout')</span>
                                </a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <ul class="pc-navbar">
                @include('admin.layouts.menu-list')
            </ul>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
