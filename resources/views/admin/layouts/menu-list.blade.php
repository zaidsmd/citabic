<li class="pc-item pc-caption">
  <label>CMS</label>
</li>
<li class="pc-item">
  <a href="{{ route('admin.dashboard') }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-status-up"></use>
      </svg>
    </span>
    <span class="pc-mtext">Dashboard</span>
  </a>
</li>
<li class="pc-item">
    <a href="{{ route('admin.certifications.index') }}" class="pc-link">
        <span class="pc-micon">
          <i class="fa fa-certificate"></i>
        </span>
        <span class="pc-mtext">Certifications</span>
    </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.company-info.index') }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-user"></use>
      </svg>
    </span>
    <span class="pc-mtext">Company Profile</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.references.index') }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-layer"></use>
      </svg>
    </span>
    <span class="pc-mtext">References</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.processes.index') }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-status-up"></use>
      </svg>
    </span>
    <span class="pc-mtext">Processes</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.values.index', ['type' => 'values']) }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-shield"></use>
      </svg>
    </span>
    <span class="pc-mtext">Values</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.values.index', ['type' => 'human_values']) }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-user-square"></use>
      </svg>
    </span>
    <span class="pc-mtext">Human Values</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.domains.index') }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-document"></use>
      </svg>
    </span>
    <span class="pc-mtext">Domains</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.figures.index') }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-presentation-chart"></use>
      </svg>
    </span>
    <span class="pc-mtext">Figures</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.categories.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="fa fa-folder"></i>
    </span>
    <span class="pc-mtext">Categories</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.tags.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="fa fa-tags"></i>
    </span>
    <span class="pc-mtext">Tags</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('admin.posts.index') }}" class="pc-link">
    <span class="pc-micon">
      <svg class="pc-icon">
        <use xlink:href="#custom-book"></use>
      </svg>
    </span>
    <span class="pc-mtext">Blog</span>
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
<li class="pc-item">
  <a href="{{ route('admin.missions.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="fa fa-bullseye"></i>
    </span>
    <span class="pc-mtext">{{ __('admin.missions.title') }}</span>
  </a>
</li>
<li class="pc-item pc-caption">
    <label>Pages</label>
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
        <use xlink:href="#custom-building"></use>
      </svg>
    </span>
        <span class="pc-mtext">{{__('site.nav.company')}}</span>
    </a>
</li>

