@extends('layouts.admin')
@section('title','Companies')
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
  <div class="card-footer d-flex flex-column gap-2">
    <div class="align-self-start">Showing {{ $companies->firstItem() ?? 0 }}-{{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }}</div>
    @if($companies->hasMorePages())
      <div class="d-flex align-items-center justify-content-center gap-2">
        <div id="company-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="company-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
      </div>
      <div id="company-sentinel" data-next-url="{{ $companies->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>
<!-- Scroll to Top Button -->
<button id="scrollToTop" type="button" title="Scroll to top" onclick="scrollToTopNow()" style="display: block !important; opacity: 1 !important; visibility: visible !important;">
  <i class="bi bi-arrow-up"></i>
</button>

@endsection


@push('scripts')

<script>
// GLOBAL FUNCTION for smooth scroll to top
function scrollToTopNow() {
  console.log('Scrolling to top...');
  
  // Main content scrollable container
  const contentDiv = document.querySelector('.content');
  if(contentDiv) {
    // Smooth scroll with animation
    contentDiv.scrollTo({ 
      top: 0, 
      behavior: 'smooth' 
    });
  }
  
  // Fallback for window scroll (bhi smooth)
  window.scrollTo({ 
    top: 0, 
    behavior: 'smooth' 
  });
  
  console.log('Smooth scrolling...');
}

document.addEventListener('DOMContentLoaded', function(){
  
  const scrollBtn = document.getElementById('scrollToTop');
  const contentDiv = document.querySelector('.content');
  
  if(scrollBtn && contentDiv) {
    // Show/hide button based on .content scroll
    contentDiv.addEventListener('scroll', function() {
      const scrollPos = contentDiv.scrollTop;
      
      if (scrollPos > 200) {
        scrollBtn.style.display = 'flex';
        scrollBtn.style.opacity = '1';
        scrollBtn.style.visibility = 'visible';
      } else {
        scrollBtn.style.opacity = '0';
        scrollBtn.style.visibility = 'hidden';
      }
    });
    
    // Initial check
    if(contentDiv.scrollTop > 200) {
      scrollBtn.style.display = 'flex';
      scrollBtn.style.opacity = '1';
      scrollBtn.style.visibility = 'visible';
    }
  }

  // REST OF YOUR CODE (search, infinite scroll, etc.)
  const searchInput = document.getElementById('company-search');
  const statusSelect = document.getElementById('status');
  const filterForm = document.getElementById('company-filter-form');
  const sentinel = document.getElementById('company-sentinel');
  const spinner = document.getElementById('company-spinner');
  const loadText = document.getElementById('company-load-text');
  const tbody = document.getElementById('company-table-body');
  let searchTimeout;

  function performSearch() {
    const formData = new FormData(filterForm);
    const params = new URLSearchParams(formData);
    
    // Delayed footer spinner (avoid instant flash)
    const footerSpinner = document.getElementById('company-spinner');
    const footerLoadText = document.getElementById('company-load-text');
    let spinnerTimer = setTimeout(() => {
      footerSpinner && footerSpinner.classList.remove('d-none');
      footerLoadText && (footerLoadText.textContent = 'Loading...');
    }, 250);
    
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
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        return !(tds.length === 1 && tr.querySelector('td[colspan]'));
      });
      
      tbody.innerHTML = '';
      if(realRows.length) {
        realRows.forEach(tr => tbody.appendChild(tr));
      } else {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No companies found</td></tr>';
      }
      
      const newFooter = doc.querySelector('.card-footer');
      const currentFooter = document.querySelector('.card-footer');
      if(newFooter && currentFooter) {
        currentFooter.innerHTML = newFooter.innerHTML;
      }
      
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
    })
    .finally(() => {
      typeof spinnerTimer !== 'undefined' && clearTimeout(spinnerTimer);
      const s = document.getElementById('company-spinner');
      const t = document.getElementById('company-load-text');
      s && s.classList.add('d-none');
      t && (t.textContent = 'Scroll for more');
    });
  }

  if(searchInput) {
    searchInput.addEventListener('keyup', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(performSearch, 500);
    });
  }

  if(statusSelect) {
    $(statusSelect).on('change', performSearch);
  }
  
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
      // Add current search/filter params to nextUrl
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
      const newRows = doc.querySelectorAll('#company-table-body tr');
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        return !(tds.length === 1 && tr.querySelector('td[colspan]'));
      });
      realRows.forEach(tr => tbody.appendChild(tr));
      
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



