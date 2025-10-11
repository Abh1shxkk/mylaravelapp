@extends('layouts.admin')
@section('title', 'All Invoices')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">All Invoices</h2>
                   
                </div>

                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.invoices.index') }}" class="row g-3"
                            id="invoice-filter-form">
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
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue
                                    </option>
                                </select>
                            </div>


                           
                        </form>
                    </div>
                </div>

                <!-- Invoices Table -->
                <div class="card">
                    <div class="card-body">
                        @if($invoices->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice-table-body">
                                        @foreach($invoices as $invoice)
                                            <tr>
                                                <td>
                                                    <strong>{{ $invoice->invoice_number }}</strong>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="fw-medium">{{ $invoice->customer_name }}</div>
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
                                                <td>
                                                    @if($invoice->due_date)
                                                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>₹{{ number_format($invoice->total_amount, 2) }}</strong>
                                                </td>
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
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.invoices.show', $invoice->invoice_id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.invoices.edit', $invoice->invoice_id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ajax-delete"
                                                            data-delete-url="{{ route('admin.invoices.destroy', $invoice->invoice_id) }}"
                                                            data-delete-message="Delete this invoice?" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Load More -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="small text-muted">Showing
                                    {{ $invoices->firstItem() ?? 0 }}-{{ $invoices->lastItem() ?? 0 }} of
                                    {{ $invoices->total() }}</div>
                                @if($invoices->hasMorePages())
                                    <div class="d-flex align-items-center gap-2">
                                        <div id="invoice-spinner" class="spinner-border spinner-border-sm text-primary d-none"
                                            role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span id="invoice-load-text" class="small text-muted">Scroll for more</span>
                                    </div>
                                    <div id="invoice-sentinel"
                                        data-next-url="{{ $invoices->appends(request()->query())->nextPageUrl() }}"
                                        style="height: 1px;"></div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-receipt display-1 text-muted"></i>
                                <h4 class="mt-3 text-muted">No Invoices Found</h4>
                                <p class="text-muted">Get started by creating your first invoice.</p>
                                <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus me-2"></i>Create First Invoice
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
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
        
        // Show loading state
        tbody.innerHTML = '<tr><td colspan="7" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
        
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
            const newFooterContent = doc.querySelector('.d-flex.justify-content-between.align-items-center.mt-3');
            const currentFooterContent = document.querySelector('.d-flex.justify-content-between.align-items-center.mt-3');
            
            if(newFooterContent && currentFooterContent) {
                currentFooterContent.innerHTML = newFooterContent.innerHTML;
                // Reinitialize infinite scroll after updating footer
                initInfiniteScroll();
            } else if (currentFooterContent) {
                // Remove pagination if no more pages
                const oldSentinel = document.getElementById('invoice-sentinel');
                if (oldSentinel) oldSentinel.remove();
            }
            
            // Reinitialize delete buttons
            initDeleteButtons();
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading data. Please try again.</td></tr>';
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

    // Initialize delete buttons
    function initDeleteButtons() {
        document.querySelectorAll('.ajax-delete').forEach(button => {
            button.addEventListener('click', function() {
                const deleteUrl = this.getAttribute('data-delete-url');
                const deleteMessage = this.getAttribute('data-delete-message');
                
                if (confirm(deleteMessage || 'Are you sure you want to delete this?')) {
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the row from table
                            this.closest('tr').remove();
                            
                            // Show success message (if you have a notification system)
                            alert('Invoice deleted successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting invoice');
                    });
                }
            });
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
                
                // Reinitialize delete buttons for new rows
                initDeleteButtons();
                
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
        }, { rootMargin: '100px' });
        
        observer.observe(sentinel);
    }

    // Initialize on page load
    initInfiniteScroll();
    initDeleteButtons();

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