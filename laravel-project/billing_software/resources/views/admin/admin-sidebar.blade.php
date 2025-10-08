<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav d-flex flex-column h-100">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- Companies -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#companies-menu" aria-expanded="false" aria-controls="companies-menu">
        <i class="mdi mdi-office-building menu-icon"></i>
        <span class="menu-title">Companies</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="companies-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.companies.index') }}">All Companies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.companies.create') }}">Add Company</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Customers -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#customers-menu" aria-expanded="false" aria-controls="customers-menu">
        <i class="mdi mdi-account-multiple menu-icon"></i>
        <span class="menu-title">Customers</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="customers-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.customers.index') }}">All Customers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.customers.create') }}">Add Customer</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Items -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#items-menu" aria-expanded="false" aria-controls="items-menu">
        <i class="mdi mdi-package-variant menu-icon"></i>
        <span class="menu-title">Items</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="items-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.items.index') }}">All Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.items.create') }}">Add Item</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Suppliers -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#suppliers-menu" aria-expanded="false" aria-controls="suppliers-menu">
        <i class="mdi mdi-truck menu-icon"></i>
        <span class="menu-title">Suppliers</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="suppliers-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.suppliers.index') }}">All Suppliers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.suppliers.create') }}">Add Supplier</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Invoices -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#invoices-menu" aria-expanded="false" aria-controls="invoices-menu">
        <i class="mdi mdi-file-document menu-icon"></i>
        <span class="menu-title">Invoices</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="invoices-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.invoices.index') }}">All Invoices</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.invoices.create') }}">Add Invoice</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Account -->
    <li class="nav-item mt-auto pt-3 border-top">
      <div class="nav-link d-flex align-items-center p-0 mb-2" style="pointer-events:none">
        <div class="nav-profile-image me-2">
          <img src="{{ asset('dist') }}/images/faces/face1.jpg" alt="profile" style="width:36px;height:36px;border-radius:50%" />
        </div>
        <div class="d-flex flex-column">
          <span class="font-weight-bold small">{{ Auth::guard('admin')->user()->username ?? 'Admin' }}</span>
          <span class="text-secondary text-small">{{ Auth::guard('admin')->user()->email ?? '' }}</span>
        </div>
      </div>
      <!-- Place the collapse ABOVE the trigger so it expands upward -->
      <div class="collapse" id="account-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ Route::has('admin.settings') ? route('admin.settings') : '#' }}">Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="{{ Route::has('admin.logout') ? route('admin.logout') : '#' }}">Logout</a>
          </li>
        </ul>
      </div>
      <a class="nav-link" data-bs-toggle="collapse" href="#account-menu" aria-expanded="false" aria-controls="account-menu">
        <i class="mdi mdi-account-circle menu-icon"></i>
        <span class="menu-title">Account</span>
        <i class="menu-arrow"></i>
      </a>
    </li>

  </ul>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all dropdown toggles
    const dropdownToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const targetCollapse = document.querySelector(targetId);
            
            // Close all other dropdowns except the current one
            dropdownToggles.forEach(otherToggle => {
                const otherTargetId = otherToggle.getAttribute('href');
                if (otherTargetId !== targetId) {
                    const otherCollapse = document.querySelector(otherTargetId);
                    if (otherCollapse && otherCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(otherCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    }
                }
            });
        });
    });

    // Close all dropdowns when page loads
    dropdownToggles.forEach(toggle => {
        const targetId = toggle.getAttribute('href');
        const targetCollapse = document.querySelector(targetId);
        if (targetCollapse && targetCollapse.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(targetCollapse, {
                toggle: false
            });
            bsCollapse.hide();
        }
    });
});
</script>