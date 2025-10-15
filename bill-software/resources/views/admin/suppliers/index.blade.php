@extends('layouts.admin')
@section('title', 'Suppliers')
@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-truck me-2"></i> Suppliers</h4>
      <div class="text-muted small">Manage your supplier list</div>

    </div>
  </div>

  <div class="card shadow-sm border-0 rounded">
    <div class="card mb-4">
      <div class="card-body">
        <form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3" id="supplier-filter-form">
          <div class="col-md-3">
            <label for="search_field" class="form-label">Search By</label>
            <select class="form-select" id="search_field" name="search_field">
              <option value="all" {{ request('search_field', 'all') == 'all' ? 'selected' : '' }}>All Fields</option>
              <option value="name" {{ request('search_field') == 'name' ? 'selected' : '' }}>Split Name</option>
              <option value="code" {{ request('search_field') == 'code' ? 'selected' : '' }}>Alter Code</option>
              <option value="mobile" {{ request('search_field') == 'mobile' ? 'selected' : '' }}>Mobile</option>
              <option value="telephone" {{ request('search_field') == 'telephone' ? 'selected' : '' }}>Tel.</option>
              <option value="address" {{ request('search_field') == 'address' ? 'selected' : '' }}>Address</option>
              <option value="dl_no" {{ request('search_field') == 'dl_no' ? 'selected' : '' }}>DL No.</option>
              <option value="gst_no" {{ request('search_field') == 'gst_no' ? 'selected' : '' }}>GSTIN</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="search" class="form-label">Search</label>
            <div class="input-group">
              <input type="text" class="form-control" id="supplier-search" name="search" value="{{ request('search') }}"
                placeholder="Type to search..." autocomplete="off">
              <button class="btn btn-outline-secondary" type="button" id="clear-search" title="Clear search">
                <i class="bi bi-x-circle"></i>
              </button>
            </div>
          </div>



        </form>
      </div>
    </div>
    <div class="table-responsive" id="supplier-table-wrapper" style="position: relative;">
      <div id="search-loading"
        style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 999; align-items: center; justify-content: center;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <table class="table table-hover align-middle mb-0" id="suppliers-table">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Code</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Opening Balance</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="supplier-table-body">
          @forelse($suppliers as $supplier)
            <tr>
              <td>{{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $loop->iteration }}</td>
              <td>{{ $supplier->code }}</td>
              <td>{{ $supplier->name }}</td>
              <td>{{ $supplier->mobile ?: $supplier->telephone }}</td>
              <td>{{ $supplier->email }}</td>
              <td>₹{{ number_format($supplier->opening_balance, 2) }}</td>

              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.suppliers.show', $supplier) }}"
                  title="View"><i class="bi bi-eye"></i></a>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.suppliers.edit', $supplier) }}"
                  title="Edit"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
                  class="d-inline ajax-delete-form">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-sm btn-outline-danger ajax-delete"
                    data-delete-url="{{ route('admin.suppliers.destroy', $supplier) }}"
                    data-delete-message="Delete this supplier?" title="Delete"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">No suppliers found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer bg-light d-flex flex-column gap-2">
      <div class="align-self-start">Showing {{ $suppliers->firstItem() ?? 0 }}-{{ $suppliers->lastItem() ?? 0 }} of
        {{ $suppliers->total() }}
      </div>
      @if($suppliers->hasMorePages())
        <div class="d-flex align-items-center justify-content-center gap-2">
          <div id="supplier-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;"
            role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <span id="supplier-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
        </div>
        <div id="supplier-sentinel" data-next-url="{{ $suppliers->appends(request()->query())->nextPageUrl() }}"
          style="height: 1px;"></div>
      @endif
    </div>
  </div>
@endsection
@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const tbody = document.getElementById('supplier-table-body');
      const searchInput = document.getElementById('supplier-search');
      const clearSearchBtn = document.getElementById('clear-search');
      const searchFieldSelect = document.getElementById('search_field');
      const filterForm = document.getElementById('supplier-filter-form');

      let searchTimeout;
      let isLoading = false;
      let observer = null;

      // Real-time search implementation
      let isSearching = false;

      function performSearch() {
        if (isSearching) return;
        isSearching = true;

        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);

        // Show loading overlay
        const loadingSpinner = document.getElementById('search-loading');
        if (loadingSpinner) {
          loadingSpinner.style.display = 'flex';
        }

        // Add visual feedback to search input
        if (searchInput) {
          searchInput.style.opacity = '0.6';
        }

        fetch(`{{ route('admin.suppliers.index') }}?${params.toString()}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
          .then(response => response.text())
          .then(html => {
            // Create a temporary container to parse HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            // Find the tbody in the temporary container
            const tempTbody = tempDiv.querySelector('#supplier-table-body');

            if (!tempTbody) {
              console.error('Could not find supplier-table-body in response');
              tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error: Table not found in response</td></tr>';
              return;
            }

            // **FIX: Clear tbody FIRST before adding anything**
            tbody.innerHTML = '';

            // Get all rows from the temporary tbody
            const tempRows = tempTbody.querySelectorAll('tr');

            // Add all rows (including "no suppliers found" message if any)
            if (tempRows.length > 0) {
              tempRows.forEach(tr => {
                tbody.appendChild(tr.cloneNode(true));
              });
            } else {
              tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">No suppliers found</td></tr>';
            }

            // Update footer with pagination info
            const newFooter = tempDiv.querySelector('.card-footer');
            const currentFooter = document.querySelector('.card-footer');
            if (newFooter && currentFooter) {
              currentFooter.innerHTML = newFooter.innerHTML;
            }

            // **FIX: Reset infinite scroll observer completely**
            isLoading = false;
            if (observer) {
              observer.disconnect();
              observer = null;
            }

            // Reinitialize infinite scroll after DOM update
            setTimeout(() => {
              initInfiniteScroll();
            }, 100);
          })
          .catch(error => {
            console.error('Search error:', error);
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>';
          })
          .finally(() => {
            isSearching = false;

            // Hide loading overlay
            const loadingSpinner = document.getElementById('search-loading');
            if (loadingSpinner) {
              loadingSpinner.style.display = 'none';
            }

            // Restore search input opacity
            if (searchInput) {
              searchInput.style.opacity = '1';
            }
          });
      }

      // Search input with debounce
      if (searchInput) {
        searchInput.addEventListener('keyup', function () {
          clearTimeout(searchTimeout);
          searchTimeout = setTimeout(performSearch, 300);
        });
      }

      // Clear search button
      if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function () {
          if (searchInput) {
            searchInput.value = '';
            searchInput.focus();
            performSearch();
          }
        });
      }

      // Trigger search when search field dropdown changes
      if (searchFieldSelect) {
        searchFieldSelect.addEventListener('change', function () {
          performSearch();
        });
      }

      // Infinite scroll functionality
      function initInfiniteScroll() {
        // Disconnect previous observer if exists
        if (observer) {
          observer.disconnect();
        }

        const sentinel = document.getElementById('supplier-sentinel');
        const spinner = document.getElementById('supplier-spinner');
        const loadText = document.getElementById('supplier-load-text');

        if (!sentinel || !tbody) return;

        isLoading = false;

        async function loadMore() {
          if (isLoading) return;
          const nextUrl = sentinel.getAttribute('data-next-url');
          if (!nextUrl) return;

          isLoading = true;
          spinner && spinner.classList.remove('d-none');
          loadText && (loadText.textContent = 'Loading...');

          try {
            // Add current search/filter params to nextUrl
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            const url = new URL(nextUrl, window.location.origin);

            // Merge current filter params with pagination URL
            params.forEach((value, key) => {
              if (value) url.searchParams.set(key, value);
            });

            const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const html = await res.text();

            // Use safer HTML parsing method
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const tempTbody = tempDiv.querySelector('#supplier-table-body');

            if (tempTbody) {
              const newRows = tempTbody.querySelectorAll('tr');
              const realRows = Array.from(newRows).filter(tr => {
                const tds = tr.querySelectorAll('td');
                return !(tds.length === 1 && tr.querySelector('td[colspan]'));
              });
              realRows.forEach(tr => tbody.appendChild(tr.cloneNode(true)));
            }

            const newSentinel = tempDiv.querySelector('#supplier-sentinel');
            if (newSentinel) {
              sentinel.setAttribute('data-next-url', newSentinel.getAttribute('data-next-url'));
              spinner && spinner.classList.add('d-none');
              loadText && (loadText.textContent = 'Scroll for more');
              isLoading = false;
            } else {
              observer.disconnect();
              sentinel.remove();
              spinner && spinner.remove();
              loadText && loadText.remove();
            }
          } catch (e) {
            spinner && spinner.classList.add('d-none');
            loadText && (loadText.textContent = 'Error loading');
            isLoading = false;
          }
        }

        observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading) {
              loadMore();
            }
          });
        }, { rootMargin: '300px' });

        observer.observe(sentinel);
      }

      // Initialize on page load
      initInfiniteScroll();

      // Auto-submit on filter change (date filters only)
      const filterInputs = document.querySelectorAll('input[name="date_from"], input[name="date_to"]');
      filterInputs.forEach(function (el) {
        el.addEventListener('change', function () {
          this.form.submit();
        });
      });
    });
  </script>
@endpush