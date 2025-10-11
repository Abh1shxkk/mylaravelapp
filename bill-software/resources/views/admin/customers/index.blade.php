@extends('layouts.admin')
@section('title','Customers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-people me-2"></i> Customers</h4>    <div class="text-muted small">Manage your customer database</div>

  </div>
</div>

<div class="card shadow-sm">
  <div class="card mb-4">
    <div class="card-body">
<form method="GET" action="{{ route('admin.customers.index') }}" class="row g-3" id="customer-filter-form">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
<input type="text" class="form-control" id="customer-search" name="search" value="{{ request('search') }}" placeholder="Name, code, city, mobile..." autocomplete="off">
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
  <div class="table-responsive" id="customer-table-wrapper">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Code</th>
          <th>City</th>
          <th>Mobile</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="customer-table-body">
        @forelse($customers as $customer)
          <tr>
            <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->code ?? '-' }}</td>
            <td>{{ $customer->city ?? '-' }}</td>
            <td>{{ $customer->mobile ?? '-' }}</td>
            <td>
              <span class="badge {{ $customer->status ? 'bg-success' : 'bg-secondary' }}">
                {{ $customer->status ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.customers.show',$customer) }}" title="View">
                <i class="bi bi-eye"></i>
              </a>
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.customers.edit',$customer) }}" title="Edit">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.customers.destroy',$customer) }}" method="POST" class="d-inline ajax-delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.customers.destroy',$customer) }}" data-delete-message="Delete this customer?" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted py-4">
              <i class="bi bi-inbox fs-1 d-block mb-2"></i>
              No customers yet
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer d-flex justify-content-between align-items-center">
    <div class="small text-muted">Showing {{ $customers->firstItem() ?? 0 }}-{{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }}</div>
    @if($customers->hasMorePages())
      <div class="d-flex align-items-center gap-2">
        <div id="customer-spinner" class="spinner-border spinner-border-sm text-primary d-none" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="customer-load-text" class="small text-muted">Scroll for more</span>
      </div>
      <div id="customer-sentinel" data-next-url="{{ $customers->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.getElementById('customer-table-body');
  const searchInput = document.getElementById('customer-search');
  const statusSelect = document.getElementById('status');
  const filterForm = document.getElementById('customer-filter-form');
  
  let searchTimeout;
  let isLoading = false;
  let observer = null;

  // Real-time search implementation
  function performSearch() {
    const formData = new FormData(filterForm);
    const params = new URLSearchParams(formData);
    
    // Show loading state
    tbody.innerHTML = '<tr><td colspan="7" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
    
    fetch(`{{ route('admin.customers.index') }}?${params.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelectorAll('#customer-table-body tr');
      
      // Clear and update table
      tbody.innerHTML = '';
      newRows.forEach(tr => tbody.appendChild(tr));
      
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
      tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>';
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

    const sentinel = document.getElementById('customer-sentinel');
    const spinner = document.getElementById('customer-spinner');
    const loadText = document.getElementById('customer-load-text');
    
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
        const res = await fetch(nextUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newRows = doc.querySelectorAll('#customer-table-body tr');
        newRows.forEach(tr => tbody.appendChild(tr));
        
        const newSentinel = doc.querySelector('#customer-sentinel');
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
    }, { rootMargin: '100px' });
    
    observer.observe(sentinel);
  }

  // Initialize on page load
  initInfiniteScroll();

  // Auto-submit on filter change (REMOVE THIS if you want only real-time)
  const filterInputs = document.querySelectorAll('input[name="date_from"], input[name="date_to"]');
  filterInputs.forEach(function(el){ 
    el.addEventListener('change', function(){ 
      this.form.submit(); 
    }); 
  });
});
</script>
@endpush
