<nav id="appHeader" class="navbar navbar-expand-lg navbar-dark app-header" style="background-color:#0d1b2a;">
  <div class="container-fluid">
    <button class="btn btn-outline-light me-2" id="headerSidebarToggle" aria-label="Toggle sidebar">
      <i class="bi bi-list"></i>
    </button>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarNav" aria-controls="topbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topbarNav">
      <div class="mx-lg-auto my-2 my-lg-0 w-100 w-lg-50 px-lg-3">
        <form action="#" method="GET" class="d-none d-md-block" role="search">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-transparent text-white border-secondary"><i class="bi bi-search"></i></span>
            <input type="search" name="q" class="form-control bg-dark text-white border-secondary" placeholder="Search..." aria-label="Search">
          </div>
        </form>
      </div>

      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item d-none d-md-block">
          <a class="nav-link position-relative" href="#" aria-label="Notifications">
            <i class="bi bi-bell fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : 'https://i.pravatar.cc/32' }}" class="rounded-circle me-2" width="32" height="32" alt="avatar">
            <span class="d-none d-sm-inline">{{ auth()->user()->full_name ?? auth()->user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="px-3 py-2 small text-muted">
              {{ auth()->user()->email }}
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('profile.settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" class="px-3 py-1">
                @csrf
                <button class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
