@extends('layouts.admin')
@section('title','General Ledger')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-journal-text me-2"></i> General Ledger</h4>
    <div class="text-muted small">Manage general ledger accounts</div>
  </div>
  <a href="{{ route('admin.general-ledger.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle me-1"></i> Add Account
  </a>
</div>

<div class="card shadow-sm">
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.general-ledger.index') }}" class="row g-3" id="ledger-filter-form">
        <div class="col-md-3">
          <label for="search_field" class="form-label">Search By</label>
          <select class="form-select" id="search_field" name="search_field">
            <option value="all" {{ request('search_field', 'all') == 'all' ? 'selected' : '' }}>All Fields</option>
            <option value="name" {{ request('search_field') == 'name' ? 'selected' : '' }}>Name</option>
            <option value="under" {{ request('search_field') == 'under' ? 'selected' : '' }}>Under</option>
            <option value="telephone" {{ request('search_field') == 'telephone' ? 'selected' : '' }}>Telephone</option>
            <option value="email" {{ request('search_field') == 'email' ? 'selected' : '' }}>Email</option>
            <option value="mobile_1" {{ request('search_field') == 'mobile_1' ? 'selected' : '' }}>Mobile 1</option>
          </select>
        </div>
        <div class="col-md-9">
          <label for="search" class="form-label">Search</label>
          <div class="input-group">
            <input type="text" class="form-control" id="ledger-search" name="search" value="{{ request('search') }}" placeholder="Type to search..." autocomplete="off">
            <button class="btn btn-outline-secondary" type="button" id="clear-search" title="Clear search">
              <i class="bi bi-x-circle"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive" id="ledger-table-wrapper" style="position: relative;">
    <div id="search-loading" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 999; align-items: center; justify-content: center;">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Under</th>
          <th>Opening Balance</th>
          <th>Dr / Cr</th>
          <th>Telephone</th>
          <th>Email</th>
          <th>Mobile</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="ledger-table-body">
        @forelse($ledgers as $ledger)
          <tr>
            <td>{{ ($ledgers->currentPage() - 1) * $ledgers->perPage() + $loop->iteration }}</td>
            <td>{{ $ledger->account_name }}</td>
            <td>{{ $ledger->under ?? '-' }}</td>
            <td>₹{{ number_format($ledger->opening_balance ?? 0, 2) }}</td>
            <td><span class="badge {{ $ledger->balance_type == 'D' ? 'bg-danger' : 'bg-success' }}">{{ $ledger->balance_type == 'D' ? 'Dr' : 'Cr' }}</span></td>
            <td>{{ $ledger->telephone ?? '-' }}</td>
            <td>{{ $ledger->email ?? '-' }}</td>
            <td>{{ $ledger->mobile_1 ?? '-' }}</td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.general-ledger.show',$ledger) }}" title="View"><i class="bi bi-eye"></i></a>
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.general-ledger.edit',$ledger) }}"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.general-ledger.destroy',$ledger) }}" method="POST" class="d-inline ajax-delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.general-ledger.destroy',$ledger) }}" data-delete-message="Delete this account?" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center text-muted">No ledger accounts found</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  
  <div class="card-footer d-flex flex-column gap-2">
    <div class="align-self-start">Showing {{ $ledgers->firstItem() ?? 0 }}-{{ $ledgers->lastItem() ?? 0 }} of {{ $ledgers->total() }}</div>
    @if($ledgers->hasMorePages())
      <div class="d-flex align-items-center justify-content-center gap-2">
        <div id="ledger-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="ledger-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
      </div>
      <div id="ledger-sentinel" data-next-url="{{ $ledgers->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('ledger-search');
  const clearSearchBtn = document.getElementById('clear-search');
  const searchFieldSelect = document.getElementById('search_field');
  const filterForm = document.getElementById('ledger-filter-form');
  const tbody = document.getElementById('ledger-table-body');
  let searchTimeout;
  let isSearching = false;

  function performSearch() {
    if(isSearching) return;
    isSearching = true;
    
    const formData = new FormData(filterForm);
    const params = new URLSearchParams(formData);
    
    // Show loading spinner
    const loadingSpinner = document.getElementById('search-loading');
    if(loadingSpinner) {
      loadingSpinner.style.display = 'flex';
    }
    
    // Add visual feedback
    if(searchInput) {
      searchInput.style.opacity = '0.6';
    }
    
    fetch(`{{ route('admin.general-ledger.index') }}?${params.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = html;
      const tempTbody = tempDiv.querySelector('#ledger-table-body');
      const tempRows = tempTbody.querySelectorAll('tr');
      
      const realRows = Array.from(tempRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        const hasColspan = tr.querySelector('td[colspan]');
        return !(tds.length === 1 && hasColspan);
      });
      
      tbody.innerHTML = '';
      if(realRows.length) {
        realRows.forEach(tr => tbody.appendChild(tr.cloneNode(true)));
      } else {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No ledger accounts found</td></tr>';
      }
      
      // Update footer with pagination info
      const newFooter = tempDiv.querySelector('.card-footer');
      const currentFooter = document.querySelector('.card-footer');
      if(newFooter && currentFooter) {
        currentFooter.innerHTML = newFooter.innerHTML;
      }
      
      // Re-setup infinite scroll observer
      isLoading = false;
      if(observer) {
        observer.disconnect();
        observer = null;
      }
      setupInfiniteScroll();
    })
    .catch(error => {
      tbody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>';
    })
    .finally(() => {
      isSearching = false;
      
      // Hide loading spinner
      const loadingSpinner = document.getElementById('search-loading');
      if(loadingSpinner) {
        loadingSpinner.style.display = 'none';
      }
      
      if(searchInput) {
        searchInput.style.opacity = '1';
      }
    });
  }

  // Attach debounced keyup on search input
  if(searchInput) {
    searchInput.addEventListener('keyup', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(performSearch, 300);
    });
  }

  // Clear search button
  if(clearSearchBtn) {
    clearSearchBtn.addEventListener('click', function() {
      if(searchInput) {
        searchInput.value = '';
        searchInput.focus();
        performSearch();
      }
    });
  }

  // Trigger search when search field dropdown changes
  if(searchFieldSelect) {
    searchFieldSelect.addEventListener('change', function() {
      performSearch();
    });
  }

  // Infinite scroll setup
  let isLoading = false;
  let observer = null;

  function setupInfiniteScroll() {
    const currentSentinel = document.getElementById('ledger-sentinel');
    if(!currentSentinel || !tbody) return;

    if(observer) {
      observer.disconnect();
    }

    const contentDiv = document.querySelector('.content');

    observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if(entry.isIntersecting && !isLoading) {
          loadMore();
        }
      });
    }, {
      root: contentDiv,
      threshold: 0.1,
      rootMargin: '100px'
    });

    observer.observe(currentSentinel);
  }

  async function loadMore(){
    if(isLoading) return;
    const currentSentinel = document.getElementById('ledger-sentinel');
    if(!currentSentinel) return;

    const nextUrl = currentSentinel.getAttribute('data-next-url');
    if(!nextUrl) return;

    isLoading = true;
    const spinner = document.getElementById('ledger-spinner');
    const loadText = document.getElementById('ledger-load-text');
    spinner && spinner.classList.remove('d-none');
    loadText && (loadText.textContent = 'Loading...');

    try{
      const formData = new FormData(filterForm);
      const params = new URLSearchParams(formData);
      const url = new URL(nextUrl, window.location.origin);
      params.forEach((value, key) => {
        if(value) url.searchParams.set(key, value);
      });
      const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      const html = await res.text();
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = html;
      const newRows = tempDiv.querySelectorAll('#ledger-table-body tr');
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        return !(tds.length === 1 && tr.querySelector('td[colspan]'));
      });
      realRows.forEach(tr => tbody.appendChild(tr.cloneNode(true)));

      const newSentinel = tempDiv.querySelector('#ledger-sentinel');
      if(newSentinel){
        currentSentinel.setAttribute('data-next-url', newSentinel.getAttribute('data-next-url'));
        const newFooter = tempDiv.querySelector('.card-footer');
        const currentFooter = document.querySelector('.card-footer');
        if(newFooter && currentFooter) {
          currentFooter.innerHTML = newFooter.innerHTML;
        }
        spinner && spinner.classList.add('d-none');
        loadText && (loadText.textContent = 'Scroll for more');
        isLoading = false;
        setupInfiniteScroll();
      } else {
        observer && observer.disconnect();
        currentSentinel.remove();
        spinner && spinner.remove();
        loadText && loadText.remove();
      }
    }catch(e){
      spinner && spinner.classList.add('d-none');
      loadText && (loadText.textContent = 'Error loading');
      isLoading = false;
    }
  }

  setupInfiniteScroll();
});
</script>
@endsection
