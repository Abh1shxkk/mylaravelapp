@extends('layouts.admin')
@section('title','Customers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <div class="text-muted small">Manage your customer database</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-people me-2"></i> Customers</h4>
  </div>
  <a href="{{ route('admin.customers.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Customer</a>
</div>

<div class="card shadow-sm">
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-3">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
          <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Name, code, city, mobile...">
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
          <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x me-1"></i>Clear</a>
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
            <td>{{ $loop->iteration }}</td>
            <td><a href="{{ route('admin.customers.show',$customer) }}" class="text-decoration-none fw-semibold">{{ $customer->name }}</a></td>
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
      <button id="load-more-customers" class="btn btn-outline-secondary btn-sm" data-next-url="{{ $customers->appends(request()->query())->nextPageUrl() }}">Load more</button>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const filterInputs = document.querySelectorAll('select[name="status"], input[name="date_from"], input[name="date_to"]');
  filterInputs.forEach(function(el){ el.addEventListener('change', function(){ this.form.submit(); }); });

  const loadBtn = document.getElementById('load-more-customers');
  if(!loadBtn) return;
  loadBtn.addEventListener('click', async function(){
    const btn = this;
    const nextUrl = btn.getAttribute('data-next-url');
    if(!nextUrl) return;
    btn.disabled = true; btn.textContent = 'Loading...';
    try{
      const res = await fetch(nextUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      const html = await res.text();
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelectorAll('#customer-table-body tr');
      const targetBody = document.querySelector('#customer-table-body');
      newRows.forEach(tr => targetBody.appendChild(tr));
      const newBtn = doc.querySelector('#load-more-customers');
      if(newBtn){
        btn.setAttribute('data-next-url', newBtn.getAttribute('data-next-url'));
        btn.disabled = false; btn.textContent = 'Load more';
      } else {
        btn.remove();
      }
    }catch(e){
      btn.disabled = false; btn.textContent = 'Load more';
    }
  });
});
</script>
@endpush
