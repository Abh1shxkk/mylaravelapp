<nav id="appHeader" class="navbar navbar-expand-lg navbar-light app-header"
  style="background-color: white; border-bottom: 1px solid #dee2e6;">
  <div class="container-fluid">
    <button class="btn btn-outline-dark me-2" id="headerSidebarToggle" aria-label="Toggle sidebar">
      <i class="bi bi-list"></i>
    </button>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarNav"
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topbarNav">
      <ul class="navbar-nav mx-auto">
        <!-- Transaction Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Transaction
          </a>
          <ul class="dropdown-menu">
            <!-- Sale Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Sale</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.sale.transaction') }}">Transaction</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.sale.modification') }}">Modification</a></li>
              </ul>
            </li>
            
            <!-- Purchase Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Purchase</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.purchase.transaction') }}">Transaction</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.purchase.modification') }}">Modification</a></li>
              </ul>
            </li>
            
            <!-- Sale Return Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Sales Return</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.sale-return.transaction') }}">Transaction <span class="badge bg-secondary ms-1">Ctrl+F3</span></a></li>
                <li><a class="dropdown-item" href="{{ route('admin.sale-return.modification') }}">Modification <span class="badge bg-secondary ms-1">Shift+Ctrl+F3</span></a></li>
              </ul>
            </li>
            
            <!-- Breakage/Expiry from customer Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Breakage/Expiry from customer</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.breakage-expiry.transaction') }}">Transaction <span class="badge bg-secondary ms-1">Ctrl+E</span></a></li>
                <li><a class="dropdown-item" href="{{ route('admin.breakage-expiry.modification') }}">Modification <span class="badge bg-secondary ms-1">Shift+Ctrl+E</span></a></li>
                <li><a class="dropdown-item" href="{{ route('admin.breakage-expiry.expiry-date') }}">Expiry Date Modification</a></li>
              </ul>
            </li>
            
            <!-- Purchase Return Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Purchase Return</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.purchase-return.transaction') }}">Transaction</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.purchase-return.modification') }}">Modification</a></li>
              </ul>
            </li>
            
            <!-- Breakage/Expiry to Supplier Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Breakage/Expiry to Supplier</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.breakage-supplier.issued-transaction') }}">Issued - Transaction</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.breakage-supplier.issued-modification') }}">Issued - Modification</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.breakage-supplier.received-transaction') }}">Received - Transaction</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.breakage-supplier.received-modification') }}">Received - Modification</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.breakage-supplier.unused-dump-transaction') }}">Unused Dump - Transaction</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.breakage-supplier.unused-dump-modification') }}">Unused Dump - Modification</a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
      <li class="nav-item d-none d-sm-inline">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <img
            src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : 'https://i.pravatar.cc/32' }}"
            class="rounded-circle me-2" width="32" height="32" alt="avatar">
          <span class="d-none d-sm-inline">{{ auth()->user()->full_name ?? auth()->user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li class="px-3 py-2 small text-muted">
            {{ auth()->user()->email }}
          </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('profile.settings') }}"><i
                  class="bi bi-gear me-2"></i>Settings</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" class="px-3 py-1">
                @csrf
                <button class="btn btn-sm btn-outline-danger w-100"><i
                    class="bi bi-box-arrow-right me-2"></i>Logout</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  /* Header styling */
  .app-header {
    grid-area: header;
    z-index: 100;
    position: relative;
  }

  /* Sidebar toggle button */
  #headerSidebarToggle {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
  }

  #headerSidebarToggle:hover {
    background-color: rgba(0, 0, 0, 0.1);
    border: none !important;
  }

  #headerSidebarToggle:focus,
  #headerSidebarToggle:active {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    background-color: rgba(0, 0, 0, 0.15);
  }

  /* Navbar toggler */
  .navbar-toggler {
    border: none;
  }

  /* Dropdown menu styling */
  .dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.08);
    padding: 0.5rem 0;
  }

  .dropdown-item {
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
  }

  .dropdown-item:hover {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
  }

  /* Nested dropdown (submenu) */
  .dropdown-submenu {
    position: relative;
  }

  .dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
    margin-left: 2px;
  }

  .dropdown-submenu .dropdown-toggle::after {
    display: inline-block;
    margin-left: auto;
    vertical-align: 0.255em;
    content: "";
    border-top: 0.3em solid transparent;
    border-right: 0;
    border-bottom: 0.3em solid transparent;
    border-left: 0.3em solid;
    float: right;
    margin-top: 0.3em;
  }

  .dropdown-submenu:hover > .dropdown-menu {
    display: block;
  }
</style>
<script>
  // Sidebar toggle functionality
  document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('headerSidebarToggle');
    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', function () {
        document.body.classList.toggle('sidebar-collapsed');
      });
    }

    // Submenu functionality for nested dropdowns
    document.querySelectorAll('.dropdown-submenu').forEach(function (submenu) {
      submenu.addEventListener('mouseenter', function () {
        const submenuDropdown = this.querySelector('.dropdown-menu');
        if (submenuDropdown) {
          submenuDropdown.classList.add('show');
        }
      });

      submenu.addEventListener('mouseleave', function () {
        const submenuDropdown = this.querySelector('.dropdown-menu');
        if (submenuDropdown) {
          submenuDropdown.classList.remove('show');
        }
      });

      // Click support for mobile
      const toggle = submenu.querySelector('.dropdown-toggle');
      if (toggle) {
        toggle.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          const submenuDropdown = this.nextElementSibling;
          if (submenuDropdown) {
            submenuDropdown.classList.toggle('show');
          }
        });
      }
    });
  });
</script>