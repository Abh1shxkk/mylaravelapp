@extends('layouts.admin')
@section('title','Companies')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <div class="text-muted small">Manage your company database</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-grid-3x3-gap-fill me-2"></i> Companies</h4>
  </div>
  <a href="{{ route('admin.companies.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Company</a>
  </div>
<div class="card shadow-sm">
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.companies.index') }}" class="row g-3">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
          <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Name, email, phone...">
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
          <a href="{{ route('admin.companies.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x me-1"></i>Clear</a>
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
            <td>{{ $loop->iteration }}</td>
            <td><a href="{{ route('admin.companies.show',$company) }}">{{ $company->name }}</a></td>
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
      <button id="load-more-companies" class="btn btn-outline-secondary btn-sm" data-next-url="{{ $companies->appends(request()->query())->nextPageUrl() }}">Load more</button>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const filterInputs = document.querySelectorAll('select[name="status"], input[name="date_from"], input[name="date_to"]');
  filterInputs.forEach(function(el){ el.addEventListener('change', function(){ this.form.submit(); }); });

  const loadBtn = document.getElementById('load-more-companies');
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
      const newRows = doc.querySelectorAll('#company-table-body tr');
      const targetBody = document.querySelector('#company-table-body');
      newRows.forEach(tr => targetBody.appendChild(tr));
      const newBtn = doc.querySelector('#load-more-companies');
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


