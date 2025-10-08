{{-- Enhanced Invoice Details --}}
@extends('layouts.admin')
@section('title','View Invoice')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div class="text-muted small">Invoice management</div>
                    <h2 class="mb-0 d-flex align-items-center"><i class="bi bi-receipt me-2"></i> Invoice #{{ $invoice->invoice_number }}</h2>
                </div>
                <div class="d-flex gap-2">
                        <a href="{{ route('admin.invoices.edit', $invoice->invoice_id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit Invoice
                    </a>
                    <button class="btn btn-success" onclick="printInvoice()">
                        <i class="bi bi-printer me-2"></i>Print
                    </button>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Invoices
                    </a>
                </div>
            </div>

            <!-- Invoice Status -->
            <div class="row mb-4">
                <div class="col-12">
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
                    
                    <div class="alert alert-{{ $status == 'paid' ? 'success' : ($status == 'overdue' ? 'danger' : ($status == 'sent' ? 'warning' : 'secondary')) }} d-flex justify-content-between align-items-center rounded-lg border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-{{ $status == 'paid' ? 'check-circle' : ($status == 'overdue' ? 'exclamation-triangle' : ($status == 'sent' ? 'send' : 'file-text')) }} me-2 fs-5"></i>
                            <div>
                                <strong class="me-2">Status:</strong> 
                                @if($status == 'paid')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Paid</span>
                                @elseif($status == 'overdue')
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Overdue</span>
                                @elseif($status == 'sent')
                                    <span class="badge bg-warning px-3 py-2 rounded-pill">Sent</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">Draft</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Total Amount</div>
                            <strong class="fs-4">₹{{ number_format($invoice->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company & Customer Information -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white rounded-top">
                            <h5 class="mb-0 d-flex align-items-center"><i class="bi bi-building me-2"></i>From (Company)</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">{{ $invoice->company_name }}</h6>
                            <div class="contact-info">
                                @if($invoice->company_email)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-envelope text-muted me-2"></i>
                                        <span>{{ $invoice->company_email }}</span>
                                    </div>
                                @endif
                                @if($invoice->company_phone)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-telephone text-muted me-2"></i>
                                        <span>{{ $invoice->company_phone }}</span>
                                    </div>
                                @endif
                                @if($invoice->company_address)
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="bi bi-geo-alt text-muted me-2 mt-1"></i>
                                        <span class="flex-fill">{{ $invoice->company_address }}</span>
                                    </div>
                                @endif
                                @if($invoice->company_gst)
                                    <div class="d-flex align-items-center mb-0">
                                        <i class="bi bi-receipt text-muted me-2"></i>
                                        <span>GST: {{ $invoice->company_gst }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-success text-white rounded-top">
                            <h5 class="mb-0 d-flex align-items-center"><i class="bi bi-person me-2"></i>To (Customer)</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">{{ $invoice->customer_name }}</h6>
                            <div class="contact-info">
                                @if($invoice->customer_email)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-envelope text-muted me-2"></i>
                                        <span>{{ $invoice->customer_email }}</span>
                                    </div>
                                @endif
                                @if($invoice->customer_phone)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-telephone text-muted me-2"></i>
                                        <span>{{ $invoice->customer_phone }}</span>
                                    </div>
                                @endif
                                @if($invoice->customer_address)
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="bi bi-geo-alt text-muted me-2 mt-1"></i>
                                        <span class="flex-fill">{{ $invoice->customer_address }}</span>
                                    </div>
                                @endif
                                @if($invoice->customer_gst)
                                    <div class="d-flex align-items-center mb-0">
                                        <i class="bi bi-receipt text-muted me-2"></i>
                                        <span>GST: {{ $invoice->customer_gst }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Information -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white rounded-top">
                            <h5 class="mb-0 d-flex align-items-center"><i class="bi bi-receipt me-2"></i>Invoice Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="invoice-info-item">
                                        <div class="text-muted small mb-1">Invoice Number</div>
                                        <div class="fw-bold text-primary fs-5">{{ $invoice->invoice_number }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="invoice-info-item">
                                        <div class="text-muted small mb-1">Invoice Date</div>
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="invoice-info-item">
                                        <div class="text-muted small mb-1">Due Date</div>
                                        <div class="fw-bold {{ $invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status != 'paid' ? 'text-danger' : '' }}">
                                            @if($invoice->due_date)
                                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="invoice-info-item">
                                        <div class="text-muted small mb-1">Created</div>
                                        <div class="fw-bold">{{ $invoice->created_at->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark rounded-top">
                            <h5 class="mb-0 d-flex align-items-center"><i class="bi bi-list-ul me-2"></i>Invoice Items</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Item</th>
                                            <th class="border-0">Description</th>
                                            <th class="border-0">HSN Code</th>
                                            <th class="border-0 text-end">Qty</th>
                                            <th class="border-0">Unit</th>
                                            <th class="border-0 text-end">Rate</th>
                                            <th class="border-0 text-end">Discount %</th>
                                            <th class="border-0 text-end">GST %</th>
                                            <th class="border-0 text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->items as $item)
                                            <tr>
                                                <td class="fw-semibold">{{ $item->item->name ?? 'N/A' }}</td>
                                                <td class="text-muted">{{ $item->description ?: '-' }}</td>
                                                <td class="text-muted">{{ $item->hsn_code ?: '-' }}</td>
                                                <td class="text-end">{{ number_format($item->qty, 2) }}</td>
                                                <td class="text-muted">{{ $item->unit ?: '-' }}</td>
                                                <td class="text-end">₹{{ number_format($item->rate, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->discount, 2) }}%</td>
                                                <td class="text-end">{{ number_format($item->gst, 2) }}%</td>
                                                <td class="text-end fw-bold text-success">₹{{ number_format($item->amount, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Totals -->
            <div class="row mb-4">
                <div class="col-md-6 offset-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-secondary text-white rounded-top">
                            <h5 class="mb-0 d-flex align-items-center"><i class="bi bi-calculator me-2"></i>Invoice Totals</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3 py-2 border-bottom">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-semibold">₹{{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 py-2 border-bottom">
                                <span class="text-muted">Discount:</span>
                                <span class="fw-semibold text-danger">-₹{{ number_format($invoice->discount_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 py-2 border-bottom">
                                <span class="text-muted">Tax Amount:</span>
                                <span class="fw-semibold text-info">₹{{ number_format($invoice->tax_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2 mt-3 border-top">
                                <strong class="fs-5">Total Amount:</strong>
                                <strong class="fs-4 text-primary">₹{{ number_format($invoice->total_amount, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            @if($invoice->notes || $invoice->terms_conditions)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-dark text-white rounded-top">
                                <h5 class="mb-0 d-flex align-items-center"><i class="bi bi-info-circle me-2"></i>Additional Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($invoice->notes)
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">Notes</h6>
                                            <div class="bg-light p-3 rounded">
                                                <p class="mb-0 text-muted">{{ $invoice->notes }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($invoice->terms_conditions)
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">Terms & Conditions</h6>
                                            <div class="bg-light p-3 rounded">
                                                <p class="mb-0 text-muted">{{ $invoice->terms_conditions }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="row no-print">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('admin.invoices.edit', $invoice->invoice_id) }}" class="btn btn-warning px-4">
                                    <i class="bi bi-pencil me-2"></i>Edit Invoice
                                </a>
                                <button class="btn btn-success px-4" onclick="printInvoice()">
                                    <i class="bi bi-printer me-2"></i>Print Invoice
                                </button>
                                <button class="btn btn-info px-4" onclick="sendInvoice()">
                                    <i class="bi bi-envelope me-2"></i>Send Invoice
                                </button>
                                <a href="{{ route('admin.invoices.index') }}" class="btn btn-light px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Invoices
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rounded-lg {
    border-radius: 0.75rem !important;
}

.contact-info div {
    min-height: 24px;
}

.invoice-info-item {
    padding: 0.5rem 0;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        font-size: 12px;
    }
    
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    
    .table {
        font-size: 11px;
    }

    .btn {
        display: none !important;
    }
}
</style>
@endsection

@push('scripts')
<script>
function printInvoice() {
    window.print();
}

function sendInvoice() {
    if (confirm('Are you sure you want to send this invoice to the customer?')) {
        // AJAX implementation would go here
        alert('Invoice sending functionality would be implemented here.');
    }
}
</script>
@endpush