@extends('layouts.admin')
@section('title', 'Suppliers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-truck me-2"></i> Suppliers</h4>    <div class="text-muted small">Manage your supplier list</div>

  </div>
</div>

<div class="card shadow-sm border-0 rounded">
  <div class="card mb-4">
    <div class="card-body">
<form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3" id="supplier-filter-form">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
<input type="text" class="form-control" id="supplier-search" name="search" value="{{ request('search') }}" placeholder="Name, code, mobile, email..." autocomplete="off">
        </div>
        <div class="col-md-2">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="">All</option>
            <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
      
       
        
      </form>
    </div>
  </div>
  <div class="table-responsive" id="supplier-table-wrapper">
    <table class="table table-hover align-middle mb-0" id="suppliers-table">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Opening Balance</th>
          <th>Status</th>
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
            <td><span class="badge {{ $supplier->status ? 'bg-success' : 'bg-secondary' }}">{{ $supplier->status ? 'Active' : 'Inactive' }}</span></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.suppliers.show', $supplier) }}" title="View"><i class="bi bi-eye"></i></a>
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.suppliers.edit', $supplier) }}" title="Edit"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="d-inline ajax-delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.suppliers.destroy', $supplier) }}" data-delete-message="Delete this supplier?" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted">No suppliers found</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer bg-light d-flex flex-column gap-2">
    <div class="align-self-start">Showing {{ $suppliers->firstItem() ?? 0 }}-{{ $suppliers->lastItem() ?? 0 }} of {{ $suppliers->total() }}</div>
    @if($suppliers->hasMorePages())
      <div class="d-flex align-items-center justify-content-center gap-2">
        <div id="supplier-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="supplier-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
      </div>
      <div id="supplier-sentinel" data-next-url="{{ $suppliers->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>
<!-- Scroll to Top Button -->
<button id="scrollToTop" type="button" title="Scroll to top" onclick="scrollToTopNow()" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; border-radius: 50%; width: 50px; height: 50px; background: #0d6efd; color: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; visibility: hidden;">
  <i class="bi bi-arrow-up"></i>
</button>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.getElementById('supplier-table-body');
  const searchInput = document.getElementById('supplier-search');
  const statusSelect = document.getElementById('status');
  const filterForm = document.getElementById('supplier-filter-form');
  
  let searchTimeout;
  let isLoading = false;
  let observer = null;

  // Scroll to Top function and visibility handlers
  function scrollToTopNow() {
    const contentDiv = document.querySelector('.content');
    if(contentDiv) {
      contentDiv.scrollTo({ top: 0, behavior: 'smooth' });
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
  window.scrollToTopNow = scrollToTopNow;

  const scrollBtn = document.getElementById('scrollToTop');
  const contentDiv = document.querySelector('.content');
  if(scrollBtn && contentDiv) {
    contentDiv.addEventListener('scroll', function(){
      const y = contentDiv.scrollTop;
      if (y > 200) {
        scrollBtn.style.opacity = '1';
        scrollBtn.style.visibility = 'visible';
      } else {
        scrollBtn.style.opacity = '0';
        scrollBtn.style.visibility = 'hidden';
      }
    });
  }
  if(scrollBtn) {
    window.addEventListener('scroll', function(){
      const y = window.scrollY || document.documentElement.scrollTop;
      if (y > 200) {
        scrollBtn.style.opacity = '1';
        scrollBtn.style.visibility = 'visible';
      } else {
        scrollBtn.style.opacity = '0';
        scrollBtn.style.visibility = 'hidden';
      }
    });
  }

  // Real-time search implementation
  function performSearch() {
    const formData = new FormData(filterForm);
    const params = new URLSearchParams(formData);
    
    // Delayed footer spinner (avoid instant flash)
    const footerSpinner = document.getElementById('supplier-spinner');
    const footerLoadText = document.getElementById('supplier-load-text');
    let spinnerTimer = setTimeout(() => {
      footerSpinner && footerSpinner.classList.remove('d-none');
      footerLoadText && (footerLoadText.textContent = 'Loading...');
    }, 250);
    
    fetch(`{{ route('admin.suppliers.index') }}?${params.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelectorAll('#supplier-table-body tr');
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        return !(tds.length === 1 && tr.querySelector('td[colspan]'));
      });
      
      // Clear and update table
      tbody.innerHTML = '';
      if(realRows.length) {
        realRows.forEach(tr => tbody.appendChild(tr));
      } else {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">No suppliers found</td></tr>';
      }
      
      // Update pagination info and reinitialize infinite scroll
      const newFooter = doc.querySelector('.card-footer');
      const currentFooter = document.querySelector('.card-footer');
      if(newFooter && currentFooter) {
        currentFooter.innerHTML = newFooter.innerHTML;
        // Reinitialize infinite scroll after updating footer
        initInfiniteScroll();
      }
    })
    .catch(error => {
      tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>';
    })
    .finally(() => {
      typeof spinnerTimer !== 'undefined' && clearTimeout(spinnerTimer);
      const s = document.getElementById('supplier-spinner');
      const t = document.getElementById('supplier-load-text');
      s && s.classList.add('d-none');
      t && (t.textContent = 'Scroll for more');
    });
  }

  // Search input with debounce
  if(searchInput) {
    searchInput.addEventListener('keyup', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(performSearch, 500);
    });
  }

  // Status filter real-time - Use jQuery for Select2 compatibility
  if(statusSelect) {
    $(statusSelect).on('change', performSearch);
  }

  // Infinite scroll functionality
  function initInfiniteScroll() {
    // Disconnect previous observer if exists
    if(observer) {
      observer.disconnect();
    }

    const sentinel = document.getElementById('supplier-sentinel');
    const spinner = document.getElementById('supplier-spinner');
    const loadText = document.getElementById('supplier-load-text');
    
    if(!sentinel || !tbody) return;
    
    isLoading = false;
    
    async function loadMore(){
      if(isLoading) return;
      const nextUrl = sentinel.getAttribute('data-next-url');
      if(!nextUrl) return;
      
      isLoading = true;
      spinner && spinner.classList.remove('d-none');
      loadText && (loadText.textContent = 'Loading...');
      
      try{
        // Add current search/filter params to nextUrl
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        const url = new URL(nextUrl, window.location.origin);
        
        // Merge current filter params with pagination URL
        params.forEach((value, key) => {
          if(value) url.searchParams.set(key, value);
        });
        
        const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newRows = doc.querySelectorAll('#supplier-table-body tr');
        const realRows = Array.from(newRows).filter(tr => {
          const tds = tr.querySelectorAll('td');
          return !(tds.length === 1 && tr.querySelector('td[colspan]'));
        });
        realRows.forEach(tr => tbody.appendChild(tr));
        
        const newSentinel = doc.querySelector('#supplier-sentinel');
        if(newSentinel){
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
      }catch(e){
        spinner && spinner.classList.add('d-none');
        loadText && (loadText.textContent = 'Error loading');
        isLoading = false;
      }
    }
    
    observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if(entry.isIntersecting && !isLoading){
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
  filterInputs.forEach(function(el){ 
    el.addEventListener('change', function(){ 
      this.form.submit(); 
    }); 
  });
});
</script>
@endpush
