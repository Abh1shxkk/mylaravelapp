@extends('layouts.admin')
@section('title','Purchase Ledger')
@section('content')
<style>
  /* Scroll to Top Button Styles */
  #scrollToTop {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    background: #0d6efd;
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 1;
    visibility: visible;
  }
  
  #scrollToTop.hide {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
  }
  
  #scrollToTop.show {
    opacity: 1;
    visibility: visible;
  }
  
  #scrollToTop:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    background: #0b5ed7;
  }
  
  #scrollToTop i {
    font-size: 22px;
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-bag-check me-2"></i> Purchase Ledger</h4>
    <div class="text-muted small">Manage purchase ledger entries</div>
  </div>
  <a href="{{ route('admin.purchase-ledger.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle me-1"></i> Add Purchase Ledger Entry
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-sm">
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.purchase-ledger.index') }}" class="row g-3" id="purchase-ledger-filter-form">
        <div class="col-md-3">
          <label for="search_field" class="form-label">Search By</label>
          <select class="form-select" id="search_field" name="search_field">
            <option value="all" {{ request('search_field', 'all') == 'all' ? 'selected' : '' }}>All Fields</option>
            <option value="ledger_name" {{ request('search_field') == 'ledger_name' ? 'selected' : '' }}>Ledger Name</option>
            <option value="alter_code" {{ request('search_field') == 'alter_code' ? 'selected' : '' }}>Alter Code</option>
            <option value="contact_1" {{ request('search_field') == 'contact_1' ? 'selected' : '' }}>Contact</option>
            <option value="email" {{ request('search_field') == 'email' ? 'selected' : '' }}>Email</option>
            <option value="mobile_1" {{ request('search_field') == 'mobile_1' ? 'selected' : '' }}>Mobile</option>
          </select>
        </div>
        <div class="col-md-9">
          <label for="search" class="form-label">Search</label>
          <div class="input-group">
            <input type="text" class="form-control" id="purchase-ledger-search" name="search" value="{{ request('search') }}" placeholder="Type to search..." autocomplete="off">
            <button class="btn btn-outline-secondary" type="button" id="clear-search" title="Clear search">
              <i class="bi bi-x-circle"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="table-responsive" id="purchase-ledger-table-wrapper" style="position: relative;">
    <div id="search-loading" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 999; align-items: center; justify-content: center;">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Ledger Name</th>
          <th>Type</th>
          <th>Opening Balance</th>
          <th>Form Required</th>
          <th>Contact</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="purchase-ledger-table-body">
        @forelse($ledgers as $ledger)
        <tr>
          <td>{{ ($ledgers->currentPage() - 1) * $ledgers->perPage() + $loop->iteration }}</td>
          <td>{{ $ledger->ledger_name ?? 'N/A' }}</td>
          <td>
            @if($ledger->type)
              <span class="badge bg-light text-dark">{{ $ledger->type }}</span>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>₹{{ number_format($ledger->opening_balance ?? 0, 2) }}</td>
          <td>
            @if($ledger->form_required)
              <span class="badge bg-success">{{ $ledger->form_required }}</span>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>{{ $ledger->contact_1 ?? '-' }} ({{ $ledger->mobile_1 ?? '-' }})</td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-info" href="{{ route('admin.purchase-ledger.show', $ledger) }}" title="View"><i class="bi bi-eye"></i></a>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.purchase-ledger.edit', $ledger) }}" title="Edit"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.purchase-ledger.destroy', $ledger) }}" method="POST" class="d-inline ajax-delete-form">
              @csrf @method('DELETE')
              <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.purchase-ledger.destroy', $ledger) }}" data-delete-message="Delete this purchase ledger entry?" title="Delete"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">No data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-footer d-flex flex-column gap-2">
    <div class="align-self-start">Showing {{ $ledgers->firstItem() ?? 0 }}-{{ $ledgers->lastItem() ?? 0 }} of {{ $ledgers->total() }}</div>
    @if($ledgers->hasMorePages())
      <div class="d-flex align-items-center justify-content-center gap-2">
        <div id="purchase-ledger-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="purchase-ledger-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
      </div>
      <div id="purchase-ledger-sentinel" data-next-url="{{ $ledgers->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const searchInput = document.getElementById('purchase-ledger-search');
  const clearSearchBtn = document.getElementById('clear-search');
  const searchFieldSelect = document.getElementById('search_field');
  const filterForm = document.getElementById('purchase-ledger-filter-form');
  const sentinel = document.getElementById('purchase-ledger-sentinel');
  const spinner = document.getElementById('purchase-ledger-spinner');
  const loadText = document.getElementById('purchase-ledger-load-text');
  const tbody = document.getElementById('purchase-ledger-table-body');
  let searchTimeout;
  let isSearching = false;

  function performSearch() {
    if(isSearching) return;
    isSearching = true;
    
    const formData = new FormData(filterForm);
    const params = new URLSearchParams(formData);
    
    const loadingSpinner = document.getElementById('search-loading');
    if(loadingSpinner) {
      loadingSpinner.style.display = 'flex';
    }
    
    if(searchInput) {
      searchInput.style.opacity = '0.6';
    }
    
    fetch(`{{ route('admin.purchase-ledger.index') }}?${params.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelectorAll('#purchase-ledger-table-body tr');
      
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        const hasColspan = tr.querySelector('td[colspan]');
        return !(tds.length === 1 && hasColspan);
      });
      
      tbody.innerHTML = '';
      if(realRows.length) {
        realRows.forEach(tr => tbody.appendChild(tr));
      } else {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No purchase ledger entries found</td></tr>';
      }
      
      const newFooter = doc.querySelector('.card-footer');
      const currentFooter = document.querySelector('.card-footer');
      if(newFooter && currentFooter) {
        currentFooter.innerHTML = newFooter.innerHTML;
      }
      
      const updatedSentinel = document.getElementById('purchase-ledger-sentinel');
      if(updatedSentinel) {
        const newSentinel = doc.querySelector('#purchase-ledger-sentinel');
        if(newSentinel && newSentinel.getAttribute('data-next-url')) {
          updatedSentinel.setAttribute('data-next-url', newSentinel.getAttribute('data-next-url'));
        }
      }
      
      setupInfiniteScroll();
    })
    .catch(error => {
      tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>';
    })
    .finally(() => {
      isSearching = false;
      
      const loadingSpinner = document.getElementById('search-loading');
      if(loadingSpinner) {
        loadingSpinner.style.display = 'none';
      }
      
      if(searchInput) {
        searchInput.style.opacity = '1';
      }
      const s = document.getElementById('purchase-ledger-spinner');
      const t = document.getElementById('purchase-ledger-load-text');
      s && s.classList.add('d-none');
      t && (t.textContent = 'Scroll for more');
    });
  }

  if(searchInput) {
    searchInput.addEventListener('keyup', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(performSearch, 300);
    });
  }

  if(clearSearchBtn) {
    clearSearchBtn.addEventListener('click', function() {
      if(searchInput) {
        searchInput.value = '';
        searchInput.focus();
        performSearch();
      }
    });
  }

  if(searchFieldSelect) {
    searchFieldSelect.addEventListener('change', function() {
      performSearch();
    });
  }
  
  let isLoading = false;
  let observer = null;
  
  function setupInfiniteScroll() {
    const currentSentinel = document.getElementById('purchase-ledger-sentinel');
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
    const currentSentinel = document.getElementById('purchase-ledger-sentinel');
    if(!currentSentinel) return;
    
    const nextUrl = currentSentinel.getAttribute('data-next-url');
    if(!nextUrl) return;
    
    isLoading = true;
    const spinner = document.getElementById('purchase-ledger-spinner');
    const loadText = document.getElementById('purchase-ledger-load-text');
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
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelectorAll('#purchase-ledger-table-body tr');
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        return !(tds.length === 1 && tr.querySelector('td[colspan]'));
      });
      realRows.forEach(tr => tbody.appendChild(tr));
      
      const newSentinel = doc.querySelector('#purchase-ledger-sentinel');
      if(newSentinel){
        currentSentinel.setAttribute('data-next-url', newSentinel.getAttribute('data-next-url'));
        spinner && spinner.classList.add('d-none');
        loadText && (loadText.textContent = 'Scroll for more');
        isLoading = false;
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
@endpush
