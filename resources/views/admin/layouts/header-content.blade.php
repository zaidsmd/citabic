@php
    $currentLocale = app()->getLocale();
    $adminNotifications = auth()->check()
        ? auth()->user()->notifications()->latest()->limit(8)->get()
        : collect();
    $unreadCount = auth()->check()
        ? auth()->user()->unreadNotifications()->count()
        : 0;
@endphp

<!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item d-none d-md-inline-flex">
      <form class="form-search">
        <i class="search-icon">
          <svg class="pc-icon">
            <use xlink:href="#custom-search-normal-1"></use>
          </svg>
        </i>
        <input type="search" class="form-control" placeholder="Ctrl + K" />
      </form>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item">
      <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <svg class="pc-icon">
          <use xlink:href="#custom-sun-1"></use>
        </svg>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
          <svg class="pc-icon">
            <use xlink:href="#custom-moon"></use>
          </svg>
          <span>Dark</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
          <svg class="pc-icon">
            <use xlink:href="#custom-sun-1"></use>
          </svg>
          <span>Light</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
          <svg class="pc-icon">
            <use xlink:href="#custom-setting-2"></use>
          </svg>
          <span>Default</span>
        </a>
      </div>
    </li>
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <svg class="pc-icon">
          <use xlink:href="#custom-language"></use>
        </svg>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown lng-dropdown">
        <a href="{{ route('locale.switch', 'en') }}" class="dropdown-item {{ $currentLocale === 'en' ? 'active' : '' }}">
          <span>
            English
            <small>(UK)</small>
          </span>
        </a>
        <a href="{{ route('locale.switch', 'fr') }}" class="dropdown-item {{ $currentLocale === 'fr' ? 'active' : '' }}">
          <span>
            français
            <small>(French)</small>
          </span>
        </a>
      </div>
    </li>
    <li class="dropdown pc-h-item">
      <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <svg class="pc-icon">
          <use xlink:href="#custom-notification"></use>
        </svg>
        @if($unreadCount > 0)
          <span class="badge bg-success pc-h-badge">{{ min($unreadCount, 99) }}</span>
        @endif
      </a>
      <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
          <h5 class="m-0">{{ __('admin.notifications.title') }}</h5>
        </div>
        <div class="dropdown-body text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
          @forelse($adminNotifications as $notification)
            @php($notificationData = $notification->data ?? [])
            @php($notificationType = $notificationData['type'] ?? null)
            <div class="card mb-2">
              <div class="card-body">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <svg class="pc-icon text-primary">
                      <use xlink:href="{{ $notificationType === 'contact_submission' ? '#custom-sms' : '#book-icon' }}"></use>
                    </svg>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <span class="float-end text-sm text-muted">{{ $notification->created_at?->diffForHumans() }}</span>
                    <h5 class="text-body mb-2">{{ $notificationData['title'] ?? __('admin.notifications.fallback_title') }}</h5>
                    <p class="mb-0">{{ \Illuminate\Support\Str::limit((string) ($notificationData['message'] ?? ''), 120) }}</p>
                    @if(!empty($notificationData['url']))
                      <a href="{{ $notificationData['url'] }}" class="link-primary small">{{ __('admin.notifications.view') }}</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @empty
            <p class="text-muted mb-0 px-2 py-3">{{ __('admin.notifications.empty') }}</p>
          @endforelse
        </div>
      </div>
    </li>
  </ul>
</div>
