@extends('layouts.admin')
@section('title', 'All Invoices')
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
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-receipt me-2"></i> All Invoices</h4>
    <div class="text-muted small">Manage your invoices</div>
  </div>
</div>

<div class="card shadow-sm">
  <!-- Filters -->
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.invoices.index') }}" class="row g-3" id="invoice-filter-form">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
          <input type="text" class="form-control" id="invoice-search" name="search" value="{{ request('search') }}" placeholder="Invoice number, customer name..." autocomplete="off">
        </div>
        <div class="col-md-2">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="">All Status</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
          </select>
        </div>
      </form>
    </div>
  </div>

  <!-- Invoices Table -->
  <div class="table-responsive" id="invoice-table-wrapper">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Invoice number</th>
          <th>Customer</th>
          <th>Date</th>
          <th>Due Date</th>
          <th>Amount</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="invoice-table-body">
        @forelse($invoices as $invoice)
          <tr>
            <td>{{ $invoice->invoice_id }}</td>
            <td>{{ $invoice->invoice_number }}</td>
            <td>
              <div>{{ $invoice->customer_name }}</div>
            </td>
            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
            <td>
              @if($invoice->due_date)
                {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>₹{{ number_format($invoice->total_amount, 2) }}</td>
            <td>
              @php
                $status = 'draft';
                if ($invoice->status == 'paid') {
                  $status = 'paid';
                } elseif ($invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status != 'paid') {
                  $status = 'overdue';
                } elseif ($invoice->status == 'sent') {
                  $status = 'sent';
                }
              @endphp

              @if($status == 'paid')
                <span class="badge bg-success">Paid</span>
              @elseif($status == 'overdue')
                <span class="badge bg-danger">Overdue</span>
              @elseif($status == 'sent')
                <span class="badge bg-warning">Sent</span>
              @else
                <span class="badge bg-secondary">Draft</span>
              @endif
            </td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.invoices.show', $invoice->invoice_id) }}" title="View"><i class="bi bi-eye"></i></a>
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.invoices.edit', $invoice->invoice_id) }}"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.invoices.destroy', $invoice->invoice_id) }}" method="POST" class="d-inline ajax-delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.invoices.destroy', $invoice->invoice_id) }}" data-delete-message="Delete this invoice?" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <i class="bi bi-receipt display-1 text-muted"></i>
              <h4 class="mt-3 text-muted">No Invoices Found</h4>
              <p class="text-muted">Get started by creating your first invoice.</p>
              <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
                <i class="bi bi-plus me-2"></i>Create First Invoice
              </a>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Footer with Pagination Info -->
  <div class="card-footer d-flex flex-column gap-2">
    <div class="align-self-start">Showing {{ $invoices->firstItem() ?? 0 }}-{{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }}</div>
    @if($invoices->hasMorePages())
      <div class="d-flex align-items-center justify-content-center gap-2">
        <div id="invoice-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="invoice-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
      </div>
      <div id="invoice-sentinel" data-next-url="{{ $invoices->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
    @endif
  </div>
</div>

<!-- Scroll to Top Button -->
<button id="scrollToTop" type="button" title="Scroll to top" onclick="scrollToTopNow()">
  <i class="bi bi-arrow-up"></i>
</button>

@endsection

@push('scripts')
<script>
// GLOBAL FUNCTION for smooth scroll to top
function scrollToTopNow() {
  const contentDiv = document.querySelector('.content');
  if(contentDiv) {
    contentDiv.scrollTo({ top: 0, behavior: 'smooth' });
  }
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
window.scrollToTopNow = scrollToTopNow;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 on status dropdown
    if(typeof $.fn.select2 !== 'undefined') {
        $('#status').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'All Status',
            allowClear: true
        });
    }
    
    // Scroll-to-Top is always visible now; no show/hide toggle required

    // REST OF YOUR CODE (search, infinite scroll, etc.)
    const tbody = document.getElementById('invoice-table-body');
    const searchInput = document.getElementById('invoice-search');
    const statusSelect = document.getElementById('status');
    const filterForm = document.getElementById('invoice-filter-form');
    
    let searchTimeout;
    let isLoading = false;
    let observer = null;

    // Real-time search implementation
    function performSearch() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        
        // Delayed footer spinner (avoid instant flash)
        const footerSpinner = document.getElementById('invoice-spinner');
        const footerLoadText = document.getElementById('invoice-load-text');
        let spinnerTimer = setTimeout(() => {
            footerSpinner && footerSpinner.classList.remove('d-none');
            footerLoadText && (footerLoadText.textContent = 'Loading...');
        }, 250);
        
        fetch(`{{ route('admin.invoices.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Get the new table body
            const newTbody = doc.querySelector('#invoice-table-body');
            const newRows = newTbody ? newTbody.querySelectorAll('tr') : [];
            
            // Clear and update table
            tbody.innerHTML = '';
            
            if (newRows.length > 0) {
                newRows.forEach(tr => tbody.appendChild(tr.cloneNode(true)));
            } else {
                // Show no results message
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">No invoices found matching your filters</td></tr>';
            }
            
            // Update pagination info and sentinel
            const newFooterContent = doc.querySelector('.card-footer');
            const currentFooterContent = document.querySelector('.card-footer');
            
            if(newFooterContent && currentFooterContent) {
                currentFooterContent.innerHTML = newFooterContent.innerHTML;
                // Reinitialize infinite scroll after updating footer
                initInfiniteScroll();
            } else if (currentFooterContent) {
                // Remove pagination if no more pages
                const oldSentinel = document.getElementById('invoice-sentinel');
                if (oldSentinel) oldSentinel.remove();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading data. Please try again.</td></tr>';
        })
        .finally(() => {
            typeof spinnerTimer !== 'undefined' && clearTimeout(spinnerTimer);
            const s = document.getElementById('invoice-spinner');
            const t = document.getElementById('invoice-load-text');
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

    // Status filter real-time - handle both regular change and Select2 change
    if(statusSelect) {
        statusSelect.addEventListener('change', performSearch);
        
        // Also handle Select2 change event if Select2 is initialized
        $(statusSelect).on('select2:select select2:clear', function() {
            performSearch();
        });
    }

    // Infinite scroll functionality
    function initInfiniteScroll() {
        // Disconnect previous observer if exists
        if(observer) {
            observer.disconnect();
        }

        const sentinel = document.getElementById('invoice-sentinel');
        const spinner = document.getElementById('invoice-spinner');
        const loadText = document.getElementById('invoice-load-text');
        
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
                
                const res = await fetch(url.toString(), { 
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    } 
                });
                
                if (!res.ok) throw new Error('Network response was not ok');
                
                const html = await res.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newTbody = doc.querySelector('#invoice-table-body');
                const newRows = newTbody ? newTbody.querySelectorAll('tr') : [];
                
                newRows.forEach(tr => tbody.appendChild(tr.cloneNode(true)));
                
                const newSentinel = doc.querySelector('#invoice-sentinel');
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
                console.error('Load more error:', e);
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
            performSearch();
        }); 
    });
});
</script>
@endpush