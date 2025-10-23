@extends('layouts.admin')
@section('title','Items')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-box-seam me-2"></i> Items</h4>    <div class="text-muted small">Manage your item/master list</div>

  </div>
</div>
<div class="card shadow-sm border-0 rounded">
  <div class="card mb-4">
    <div class="card-body">
<form method="GET" action="{{ route('admin.items.index') }}" class="row g-3" id="item-filter-form">
        <div class="col-md-3">
          <label for="search_field" class="form-label">Search By</label>
          <select class="form-select" id="search_field" name="search_field">
            <option value="all" {{ request('search_field', 'all') == 'all' ? 'selected' : '' }}>All Fields</option>
            <option value="name" {{ request('search_field') == 'name' ? 'selected' : '' }}>1. Split Name</option>
            <option value="bar_code" {{ request('search_field') == 'bar_code' ? 'selected' : '' }}>2. BarCode</option>
            <option value="location" {{ request('search_field') == 'location' ? 'selected' : '' }}>3. Location</option>
            <option value="packing" {{ request('search_field') == 'packing' ? 'selected' : '' }}>4. Pack</option>
            <option value="mrp" {{ request('search_field') == 'mrp' ? 'selected' : '' }}>5. Mrp</option>
            <option value="code" {{ request('search_field') == 'code' ? 'selected' : '' }}>6. BtCode</option>
            <option value="hsn_code" {{ request('search_field') == 'hsn_code' ? 'selected' : '' }}>7. HSN</option>
          </select>
        </div>
        <div class="col-md-7">
          <label for="search" class="form-label">Search</label>
          <div class="input-group">
            <input type="text" class="form-control" id="item-search" name="search" value="{{ request('search') }}" placeholder="Type to search..." autocomplete="off">
            <button class="btn btn-outline-secondary" type="button" id="clear-search" title="Clear search">
              <i class="bi bi-x-circle"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive" id="item-table-wrapper" style="position: relative; min-height: 400px;">
    <div id="search-loading" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 999; align-items: center; justify-content: center;">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>HSN Code</th>
          <th>Pack</th>
          <th>Company</th>
          <th>Qty</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="item-table-body">
        @forelse($items as $item)
          <tr>
            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->hsn_code ?? '-' }}</td>
            <td>{{ $item->packing ?? '-' }}</td>
            <td>{{ $item->company->short_name ?? '-' }}</td>
            <td>
              <span class="badge bg-light text-dark">{{ $item->unit ?? '1' }}</span>
              <small class="text-muted">{{ $item->unit_type ?? 'Unit' }}</small>
            </td>
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
          <tr><td colspan="7" class="text-center text-muted">No items found</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer bg-light d-flex flex-column gap-2">
    <div class="d-flex justify-content-between align-items-center w-100">
      <div>Showing {{ $items->firstItem() ?? 0 }}-{{ $items->lastItem() ?? 0 }} of {{ $items->total() }}</div>
      <div class="text-muted">Page {{ $items->currentPage() }} of {{ $items->lastPage() }}</div>
    </div>
    @if($items->hasMorePages())
      <div class="d-flex align-items-center justify-content-center gap-2">
        <div id="item-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="item-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
      </div>
      <div id="item-sentinel" data-next-url="{{ $items->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.getElementById('item-table-body');
  const searchInput = document.getElementById('item-search');
  const searchFieldSelect = document.getElementById('search_field');
  const clearSearchBtn = document.getElementById('clear-search');
  const filterForm = document.getElementById('item-filter-form');
  
  let searchTimeout;
  let isLoading = false;
  let observer = null;
  let isSearching = false;

  // Real-time search implementation
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
    
    fetch(`{{ route('admin.items.index') }}?${params.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelectorAll('#item-table-body tr');
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        return !(tds.length === 1 && tr.querySelector('td[colspan]'));
      });
      
      // Clear and update table
      tbody.innerHTML = '';
      if(realRows.length) {
        realRows.forEach(tr => tbody.appendChild(tr));
      } else {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No items found</td></tr>';
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
      tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>';
    })
    .finally(() => {
      isSearching = false;
      
      // Hide loading spinner
      const loadingSpinner = document.getElementById('search-loading');
      if(loadingSpinner) {
        loadingSpinner.style.display = 'none';
      }
      
      // Restore search input opacity
      if(searchInput) {
        searchInput.style.opacity = '1';
      }
      
      const s = document.getElementById('item-spinner');
      const t = document.getElementById('item-load-text');
      s && s.classList.add('d-none');
      t && (t.textContent = 'Scroll for more');
    });
  }

  // Search input with debounce
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

  // Toast notification helper
  function showToast(message, type = 'danger') {
    const toastContainer = document.getElementById('ajaxToastContainer');
    if (!toastContainer) return;
    
    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center text-bg-${type} border-0`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
    toastContainer.appendChild(toastEl);
    const bToast = new bootstrap.Toast(toastEl, { delay: 3000 });
    bToast.show();
    
    // Remove toast element after it's hidden
    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
  }

  // Page jump functionality (AJAX - no page refresh)
  function jumpToPage() {
    // Get fresh references each time
    const pageJumpInput = document.getElementById('page-jump');
    const pageJumpBtn = document.getElementById('page-jump-btn');
    
    if(!pageJumpInput || !pageJumpBtn) return;
    
    const pageNum = parseInt(pageJumpInput.value);
    const maxPage = parseInt(pageJumpInput.getAttribute('max'));
    
    if(!pageNum || pageNum < 1) {
      showToast('Please enter a valid page number', 'warning');
      return;
    }
    
    if(pageNum > maxPage) {
      showToast(`Page number cannot exceed ${maxPage}`, 'warning');
      return;
    }
    
    // Build URL with current filters and page number
    const formData = new FormData(filterForm);
    const params = new URLSearchParams(formData);
    params.set('page', pageNum);
    
    // Show loading state
    pageJumpBtn.disabled = true;
    pageJumpBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    // Fetch page via AJAX
    fetch(`{{ route('admin.items.index') }}?${params.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelectorAll('#item-table-body tr');
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        return !(tds.length === 1 && tr.querySelector('td[colspan]'));
      });
      
      // Clear and update table
      tbody.innerHTML = '';
      if(realRows.length) {
        realRows.forEach(tr => tbody.appendChild(tr));
      } else {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No items found</td></tr>';
      }
      
      // Update pagination info and footer
      const newFooter = doc.querySelector('.card-footer');
      const currentFooter = document.querySelector('.card-footer');
      if(newFooter && currentFooter) {
        currentFooter.innerHTML = newFooter.innerHTML;
        // Reinitialize infinite scroll after updating footer
        initInfiniteScroll();
        // Reinitialize page jump after footer update
        initPageJump();
      }
      
      // Scroll to top
      const contentDiv = document.querySelector('.content');
      if(contentDiv) {
        contentDiv.scrollTo({ top: 0, behavior: 'smooth' });
      }
      window.scrollTo({ top: 0, behavior: 'smooth' });
    })
    .catch(error => {
      showToast('Error loading page. Please try again.', 'danger');
      console.error(error);
      // Re-enable button on error
      const btn = document.getElementById('page-jump-btn');
      if(btn) {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-arrow-right-circle"></i>';
      }
    })
    .finally(() => {
      // Get fresh reference for finally block
      const btn = document.getElementById('page-jump-btn');
      if(btn) {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-arrow-right-circle"></i>';
      }
    });
  }
  
  function initPageJump() {
    const jumpInput = document.getElementById('page-jump');
    const jumpBtn = document.getElementById('page-jump-btn');
    
    if(jumpBtn) {
      // Remove old listeners by cloning
      const newBtn = jumpBtn.cloneNode(true);
      jumpBtn.parentNode.replaceChild(newBtn, jumpBtn);
      newBtn.addEventListener('click', jumpToPage);
    }
    
    if(jumpInput) {
      // Remove old listeners by cloning
      const newInput = jumpInput.cloneNode(true);
      jumpInput.parentNode.replaceChild(newInput, jumpInput);
      newInput.addEventListener('keypress', function(e) {
        if(e.key === 'Enter') {
          e.preventDefault();
          jumpToPage();
        }
      });
    }
  }
  
  // Initialize page jump on load
  initPageJump();

  // Infinite scroll functionality
  function initInfiniteScroll() {
    // Disconnect previous observer if exists
    if(observer) {
      observer.disconnect();
    }

    const sentinel = document.getElementById('item-sentinel');
    const spinner = document.getElementById('item-spinner');
    const loadText = document.getElementById('item-load-text');
    
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
        const newRows = doc.querySelectorAll('#item-table-body tr');
        const realRows = Array.from(newRows).filter(tr => {
          const tds = tr.querySelectorAll('td');
          return !(tds.length === 1 && tr.querySelector('td[colspan]'));
        });
        realRows.forEach(tr => tbody.appendChild(tr));
        
        const newSentinel = doc.querySelector('#item-sentinel');
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
