@extends('layouts.admin')
@section('title','Companies')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
   
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-grid-3x3-gap-fill me-2"></i> Companies</h4>
     <div class="text-muted small">Manage your company database</div>
  </div>
  </div>
<div class="card shadow-sm">
  <div class="card mb-4">
    <div class="card-body">
<form method="GET" action="{{ route('admin.companies.index') }}" class="row g-3" id="company-filter-form">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
<input type="text" class="form-control" id="company-search" name="search" value="{{ request('search') }}" placeholder="Name, email, phone..." autocomplete="off">
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
  <div class="table-responsive" id="company-table-wrapper">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Address</th>
          <th>Email</th>
          <th>Mobile 1</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="company-table-body">
        @forelse($companies as $company)
          <tr>
            <td>{{ ($companies->currentPage() - 1) * $companies->perPage() + $loop->iteration }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->address }}</td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->mobile_1 }}</td>
            <td>
              <span class="badge {{ $company->status ? 'bg-success':'bg-secondary' }}">{{ $company->status ? 'Active':'Inactive' }}</span>
            </td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.companies.show',$company) }}" title="View"><i class="bi bi-eye"></i></a>
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.companies.edit',$company) }}"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.companies.destroy',$company) }}" method="POST" class="d-inline ajax-delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.companies.destroy',$company) }}" data-delete-message="Delete this company?" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted">No data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer d-flex justify-content-between align-items-center">
    <div class="small text-muted">Showing {{ $companies->firstItem() ?? 0 }}-{{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }}</div>
    @if($companies->hasMorePages())
      <div class="d-flex align-items-center gap-2">
        <div id="company-spinner" class="spinner-border spinner-border-sm text-primary d-none" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="company-load-text" class="small text-muted">Scroll for more</span>
      </div>
      <div id="company-sentinel" data-next-url="{{ $companies->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){

  // YE CODE Line 86 ke baad add karna hai, DOMContentLoaded ke andar

// Real-time search implementation
const searchInput = document.getElementById('company-search');
const statusSelect = document.getElementById('status');
const filterForm = document.getElementById('company-filter-form');
let searchTimeout;

function performSearch() {
  const formData = new FormData(filterForm);
  const params = new URLSearchParams(formData);
  
  // Show loading state
  tbody.innerHTML = '<tr><td colspan="7" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
  
  fetch(`{{ route('admin.companies.index') }}?${params.toString()}`, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(html => {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const newRows = doc.querySelectorAll('#company-table-body tr');
    
    // Clear and update table
    tbody.innerHTML = '';
    newRows.forEach(tr => tbody.appendChild(tr));
    
    // Update pagination info
    const newFooter = doc.querySelector('.card-footer');
    const currentFooter = document.querySelector('.card-footer');
    if(newFooter && currentFooter) {
      currentFooter.innerHTML = newFooter.innerHTML;
    }
    
    // Reset infinite scroll
    if(sentinel) {
      const newSentinel = doc.querySelector('#company-sentinel');
      if(newSentinel) {
        sentinel.setAttribute('data-next-url', newSentinel.getAttribute('data-next-url'));
      } else {
        sentinel.remove();
      }
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

  const sentinel = document.getElementById('company-sentinel');
  const spinner = document.getElementById('company-spinner');
  const loadText = document.getElementById('company-load-text');
  const tbody = document.getElementById('company-table-body');
  
  if(!sentinel || !tbody) return;
  
  let isLoading = false;
  
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
      const newRows = doc.querySelectorAll('#company-table-body tr');
      newRows.forEach(tr => tbody.appendChild(tr));
      
      const newSentinel = doc.querySelector('#company-sentinel');
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
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting && !isLoading){
        loadMore();
      }
    });
  }, { rootMargin: '100px' });
  
  observer.observe(sentinel);
});
</script>
@endpush


