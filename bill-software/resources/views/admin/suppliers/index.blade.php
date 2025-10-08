@extends('layouts.admin')
@section('title', 'Suppliers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <div class="text-muted small">Manage your supplier list</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-truck me-2"></i> Suppliers</h4>
  </div>
  <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Supplier</a>
</div>

<div class="card shadow-sm border-0 rounded">
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
          <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Name, code, mobile, email...">
        </div>
        <div class="col-md-2">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="">All</option>
            <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="date_from" class="form-label">From Date</label>
          <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
          <label for="date_to" class="form-label">To Date</label>
          <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button type="submit" class="btn btn-outline-primary me-2"><i class="bi bi-search me-1"></i>Filter</button>
          <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x me-1"></i>Clear</a>
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
            <td><a href="{{ route('admin.suppliers.show', $supplier) }}" class="text-decoration-none">{{ $supplier->name }}</a></td>
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
  <div class="card-footer bg-light d-flex justify-content-between align-items-center">
    <div class="small text-muted">Showing {{ $suppliers->firstItem() ?? 0 }}-{{ $suppliers->lastItem() ?? 0 }} of {{ $suppliers->total() }}</div>
    @if($suppliers->hasMorePages())
      <div class="d-flex align-items-center gap-2">
        <div id="supplier-spinner" class="spinner-border spinner-border-sm text-primary d-none" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="supplier-load-text" class="small text-muted">Scroll for more</span>
      </div>
      <div id="supplier-sentinel" data-next-url="{{ $suppliers->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const filterInputs = document.querySelectorAll('select[name="status"], input[name="date_from"], input[name="date_to"]');
  filterInputs.forEach(function(el){ el.addEventListener('change', function(){ this.form.submit(); }); });

  const sentinel = document.getElementById('supplier-sentinel');
  const spinner = document.getElementById('supplier-spinner');
  const loadText = document.getElementById('supplier-load-text');
  const tbody = document.getElementById('supplier-table-body');
  
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
      const newRows = doc.querySelectorAll('#supplier-table-body tr');
      newRows.forEach(tr => tbody.appendChild(tr));
      
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
