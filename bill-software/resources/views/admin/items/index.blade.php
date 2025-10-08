@extends('layouts.admin')
@section('title','Items')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <div class="text-muted small">Manage your item/master list</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-box-seam me-2"></i> Items</h4>
  </div>
  <a href="{{ route('admin.items.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Item</a>
</div>

<div class="card shadow-sm border-0 rounded">
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.items.index') }}" class="row g-3">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
          <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Name, code, barcode...">
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
          <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x me-1"></i>Clear</a>
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Name</th>
          <th>Pack</th>
          <th>Unit</th>
          <th>MRP</th>
          <th>S. Rate</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="item-table-body">
        @forelse($items as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->code }}</td>
            <td><a href="{{ route('admin.items.show',$item) }}" class="text-decoration-none">{{ $item->name }}</a></td>
            <td>{{ $item->Pack }}</td>
            <td>{{ $item->Unit }}</td>
            <td>₹{{ number_format($item->Mrp, 2) }}</td>
            <td>₹{{ number_format($item->Srate, 2) }}</td>
            <td><span class="badge {{ $item->status ? 'bg-success':'bg-secondary' }}">{{ $item->status ? 'Active':'Inactive' }}</span></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.items.show',$item) }}" title="View"><i class="bi bi-eye"></i></a>
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.items.edit',$item) }}" title="Edit"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.items.destroy',$item) }}" method="POST" class="d-inline ajax-delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.items.destroy',$item) }}" data-delete-message="Delete this item?" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center text-muted">No items found</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer bg-light d-flex justify-content-between align-items-center">
    <div class="small text-muted">Showing {{ $items->firstItem() ?? 0 }}-{{ $items->lastItem() ?? 0 }} of {{ $items->total() }}</div>
    @if($items->hasMorePages())
      <button id="load-more-items" class="btn btn-outline-secondary btn-sm" data-next-url="{{ $items->appends(request()->query())->nextPageUrl() }}">Load more</button>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const filterInputs = document.querySelectorAll('select[name="status"], input[name="date_from"], input[name="date_to"]');
  filterInputs.forEach(function(el){ el.addEventListener('change', function(){ this.form.submit(); }); });

  const loadBtn = document.getElementById('load-more-items');
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
      const newRows = doc.querySelectorAll('#item-table-body tr');
      const targetBody = document.querySelector('#item-table-body');
      newRows.forEach(tr => targetBody.appendChild(tr));
      const newBtn = doc.querySelector('#load-more-items');
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
