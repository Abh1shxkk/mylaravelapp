@extends('layouts.admin')
@section('title','All Invoices')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">All Invoices</h2>
                <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus me-2"></i>Create New Invoice
                </a>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.invoices.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Invoice number, customer name...">
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
                        <div class="col-md-2">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x me-1"></i>Clear
                            </a>
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
                                                    <small class="text-muted">{{ $invoice->customer_email }}</small>
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
                                                    if($invoice->status == 'paid') {
                                                        $status = 'paid';
                                                    } elseif($invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status != 'paid') {
                                                        $status = 'overdue';
                                                    } elseif($invoice->status == 'sent') {
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
                                                        <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" data-delete-url="{{ route('admin.invoices.destroy', $invoice->invoice_id) }}" data-delete-message="Delete this invoice?" title="Delete">
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
                            <div class="small text-muted">Showing {{ $invoices->firstItem() ?? 0 }}-{{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }}</div>
                            @if($invoices->hasMorePages())
                                <div class="d-flex align-items-center gap-2">
                                    <div id="invoice-spinner" class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span id="invoice-load-text" class="small text-muted">Scroll for more</span>
                                </div>
                                <div id="invoice-sentinel" data-next-url="{{ $invoices->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
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
    $('#status').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'All Status',
        allowClear: true
    });
    
    const filterInputs = document.querySelectorAll('select[name="status"], input[name="date_from"], input[name="date_to"]');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            this.form.submit();
        });
    });

    const sentinel = document.getElementById('invoice-sentinel');
    const spinner = document.getElementById('invoice-spinner');
    const loadText = document.getElementById('invoice-load-text');
    const tbody = document.getElementById('invoice-table-body');
    
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
            const newRows = doc.querySelectorAll('#invoice-table-body tr');
            newRows.forEach(tr => tbody.appendChild(tr));
            
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