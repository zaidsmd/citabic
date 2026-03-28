@can('manage cms content')
    <!-- ==================== DASHBOARD ==================== -->
    <li class="pc-item pc-caption">
        <label>{{ __('admin.menu.caption_dashboard') }}</label>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.dashboard') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-status-up"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.dashboard') }}</span>
        </a>
    </li>

    <!-- ==================== COMPANY PROFILE ==================== -->
    <li class="pc-item pc-caption">
        <label>{{ __('admin.menu.caption_company') }}</label>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.company-info.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-user"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.company_profile') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.missions.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#target-icon"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.missions.title') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.values.index', ['type' => 'values']) }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-shield"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.values') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.certifications.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#certification-icon"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.certifications') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.processes.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-status-up"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.processes') }}</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="{{ route('admin.domains.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-document"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.domains') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.figures.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-presentation-chart"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.figures') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.references.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-layer"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.references') }}</span>
        </a>
    </li>
@endcan

<!-- ==================== BLOG & CONTENT ==================== -->
@can('manage blog posts')
    <li class="pc-item pc-caption">
        <label>{{ __('admin.menu.caption_blog') }}</label>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.posts.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#book-icon"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.blog') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.categories.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#folder-icon"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.categories') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.tags.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#pause-icon"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.tags') }}</span>
        </a>
    </li>
@endcan

@can('manage users')
    <li class="pc-item">
        <a href="{{ route('admin.users.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-user"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.menu.users') }}</span>
        </a>
    </li>
@endcan

@can('manage cms content')
    <!-- ==================== WEBSITE PAGES ==================== -->
    <li class="pc-item pc-caption">
        <label>{{ __('admin.menu.caption_pages') }}</label>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.sections.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-home"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{__('site.nav.home')}}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.pages.about-us') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#info-icon"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{__('site.nav.company')}}</span>
        </a>
    </li>

    <!-- ==================== COMMUNICATIONS ==================== -->
    <li class="pc-item pc-caption">
        <label>{{ __('admin.menu.caption_communications') }}</label>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.contact-submissions.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#letter-icon"></use>
                </svg>
            </span>
            <span class="pc-mtext">{{ __('admin.contact_submissions.title') }}</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.settings.google-translate.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="fa fa-language"></i>
            </span>
            <span class="pc-mtext">{{ __('admin.google_translate_settings.nav') }}</span>
        </a>
    </li>
@endcan
