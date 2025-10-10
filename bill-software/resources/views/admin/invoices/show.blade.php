@extends('layouts.admin')
@section('title','View Invoice')
@section('content')
<div class="container-fluid py-4">
  <!-- Action Buttons (No Print) -->
  <div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
      <h2 class="mb-1 fw-bold text-dark">Invoice #{{ $invoice->invoice_number }}</h2>
      <div class="text-muted small">Invoice management</div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.invoices.edit', $invoice->invoice_id) }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-pencil me-1"></i> Edit
      </a>
      <a href="{{ route('admin.invoices.print', $invoice->invoice_id) }}" target="_blank" class="btn btn-outline-success btn-sm">
        <i class="bi bi-printer me-1"></i> Print
      </a>
      <button class="btn btn-outline-danger btn-sm" onclick="downloadPDF()">
        <i class="bi bi-file-pdf me-1"></i> PDF
      </button>
      <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
      </a>
    </div>
  </div>

  <!-- Invoice Document -->
  <div class="invoice-document bg-white border w-100">
    <!-- Invoice Header -->
    <div class="invoice-header p-4 border-bottom bg-gradient" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="d-flex align-items-center mb-3">
            <div class="invoice-icon me-3">
              <i class="bi bi-receipt-cutoff text-primary" style="font-size: 2.5rem;"></i>
            </div>
            <div>
              <h1 class="invoice-title mb-1">TAX INVOICE</h1>
              <small class="text-muted">Professional Invoice Document</small>
            </div>
          </div>
          <div class="invoice-meta">
            <div class="row g-2">
              <div class="col-sm-6">
                <div class="info-item p-2 bg-white rounded border">
                  <small class="text-muted d-block">Invoice Number</small>
                  <strong class="text-primary">{{ $invoice->invoice_number }}</strong>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="info-item p-2 bg-white rounded border">
                  <small class="text-muted d-block">Invoice Date</small>
                  <strong>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</strong>
                </div>
              </div>
              @if($invoice->due_date)
              <div class="col-sm-6">
                <div class="info-item p-2 bg-white rounded border">
                  <small class="text-muted d-block">Due Date</small>
                  <strong class="text-warning">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M, Y') }}</strong>
                </div>
              </div>
              @endif
              @if($invoice->reference)
              <div class="col-sm-6">
                <div class="info-item p-2 bg-white rounded border">
                  <small class="text-muted d-block">Reference</small>
                  <strong>{{ $invoice->reference }}</strong>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6 text-end">
          @php
            $status = 'DRAFT';
            $statusClass = 'bg-secondary';
            $statusIcon = 'bi-file-earmark';
            if($invoice->status == 'paid') {
                $status = 'PAID';
                $statusClass = 'bg-success';
                $statusIcon = 'bi-check-circle';
            } elseif($invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status != 'paid') {
                $status = 'OVERDUE';
                $statusClass = 'bg-danger';
                $statusIcon = 'bi-exclamation-triangle';
            } elseif($invoice->status == 'sent') {
                $status = 'SENT';
                $statusClass = 'bg-warning';
                $statusIcon = 'bi-send';
            }
          @endphp
          <div class="status-badge mb-3">
            <span class="badge {{ $statusClass }} fs-6 px-3 py-2 rounded-pill">
              <i class="{{ $statusIcon }} me-1"></i>{{ $status }}
            </span>
          </div>
          <div class="invoice-total-preview p-3 bg-white rounded border shadow-sm">
            <div class="text-muted small mb-1">Total Invoice Amount</div>
            <h2 class="mb-0 text-primary fw-bold">
              <i class="bi bi-currency-rupee"></i>{{ number_format($invoice->total_amount, 2) }}
            </h2>
            @if($invoice->balance_amount && $invoice->balance_amount > 0)
            <small class="text-warning">
              <i class="bi bi-exclamation-circle me-1"></i>Balance: ₹{{ number_format($invoice->balance_amount, 2) }}
            </small>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Bill To / Ship To Section -->
    <div class="invoice-parties p-4 border-bottom">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="party-card h-100">
            <div class="party-header d-flex align-items-center mb-3">
              <div class="party-icon me-2">
                <i class="bi bi-building text-primary fs-5"></i>
              </div>
              <h5 class="party-title mb-0 text-primary">Bill From</h5>
            </div>
            <div class="party-details p-3 bg-light rounded">
              <div class="company-name mb-2">
                <strong class="fs-6 text-dark">{{ $invoice->company_name }}</strong>
              </div>
              @if($invoice->company_address)
              <div class="address mb-2 text-muted">
                <i class="bi bi-geo-alt me-1"></i>{{ $invoice->company_address }}
              </div>
              @endif
              <div class="contact-info">
                @if($invoice->company_email)
                <div class="email mb-1 small">
                  <i class="bi bi-envelope me-1 text-primary"></i>{{ $invoice->company_email }}
                </div>
                @endif
                @if($invoice->company_phone)
                <div class="phone mb-1 small">
                  <i class="bi bi-telephone me-1 text-success"></i>{{ $invoice->company_phone }}
                </div>
                @endif
                @if($invoice->company_gst)
                <div class="gst small">
                  <i class="bi bi-card-text me-1 text-warning"></i><strong>GST:</strong> {{ $invoice->company_gst }}
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="party-card h-100">
            <div class="party-header d-flex align-items-center mb-3">
              <div class="party-icon me-2">
                <i class="bi bi-person-circle text-success fs-5"></i>
              </div>
              <h5 class="party-title mb-0 text-success">Bill To</h5>
            </div>
            <div class="party-details p-3 bg-light rounded">
              <div class="customer-name mb-2">
                <strong class="fs-6 text-dark">{{ $invoice->customer_name }}</strong>
              </div>
              @if($invoice->customer_address)
              <div class="address mb-2 text-muted">
                <i class="bi bi-geo-alt me-1"></i>{{ $invoice->customer_address }}
              </div>
              @endif
              <div class="contact-info">
                @if($invoice->customer_email)
                <div class="email mb-1 small">
                  <i class="bi bi-envelope me-1 text-primary"></i>{{ $invoice->customer_email }}
                </div>
                @endif
                @if($invoice->customer_phone)
                <div class="phone mb-1 small">
                  <i class="bi bi-telephone me-1 text-success"></i>{{ $invoice->customer_phone }}
                </div>
                @endif
                @if($invoice->customer_gst)
                <div class="gst small">
                  <i class="bi bi-card-text me-1 text-warning"></i><strong>GST:</strong> {{ $invoice->customer_gst }}
                </div>
                @endif
                @if($invoice->customer_state)
                <div class="state small">
                  <i class="bi bi-map me-1 text-info"></i><strong>State:</strong> {{ $invoice->customer_state }}
                  @if($invoice->customer_state_code)
                  ({{ $invoice->customer_state_code }})
                  @endif
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Items Table -->
    <div class="invoice-items p-4">
      <div class="d-flex align-items-center mb-3">
        <i class="bi bi-list-ul text-primary me-2 fs-5"></i>
        <h5 class="mb-0 fw-bold text-primary">Invoice Items</h5>
      </div>
        <table class="table table-hover mb-0">
          <thead class="table-primary">
            <tr>
              <th style="width: 5%;" class="text-center">#</th>
              <th style="width: 25%;"><i class="bi bi-box me-1"></i>Item Description</th>
              <th style="width: 10%;"><i class="bi bi-upc me-1"></i>HSN Code</th>
              <th style="width: 8%;" class="text-center"><i class="bi bi-123 me-1"></i>Qty</th>
              <th style="width: 8%;"><i class="bi bi-rulers me-1"></i>Unit</th>
              <th style="width: 12%;" class="text-end"><i class="bi bi-currency-rupee me-1"></i>Rate</th>
              <th style="width: 8%;" class="text-center"><i class="bi bi-percent me-1"></i>Disc</th>
              <th style="width: 8%;" class="text-center"><i class="bi bi-receipt me-1"></i>GST</th>
              <th style="width: 16%;" class="text-end"><i class="bi bi-calculator me-1"></i>Amount</th>
            </tr>
          </thead>
        <tbody>
          @forelse($invoice->items as $index => $item)
            <tr class="item-row">
              <td class="text-center align-middle">
                <span class="badge bg-light text-dark rounded-circle">{{ $index + 1 }}</span>
              </td>
              <td class="align-middle">
                <div class="item-info">
                  <div class="fw-semibold text-dark mb-1">{{ $item->product_name ?? ($item->item->name ?? 'N/A') }}</div>
                  @if($item->product_description)
                  <small class="text-muted d-block"><i class="bi bi-info-circle me-1"></i>{{ $item->product_description }}</small>
                  @endif
                </div>
              </td>
              <td class="text-center align-middle">
                <span class="badge bg-secondary">{{ $item->hsn_code ?: 'N/A' }}</span>
              </td>
              <td class="text-center align-middle">
                <span class="fw-semibold text-primary">{{ number_format($item->quantity, 0) }}</span>
              </td>
              <td class="align-middle">
                <span class="badge bg-info text-white">{{ $item->unit ?: 'PCS' }}</span>
              </td>
              <td class="text-end align-middle">
                <span class="fw-semibold">₹{{ number_format($item->unit_price, 2) }}</span>
              </td>
              <td class="text-center align-middle">
                @if($item->discount_percent > 0)
                <span class="badge bg-warning text-dark">{{ number_format($item->discount_percent, 1) }}%</span>
                @else
                <span class="text-muted">-</span>
                @endif
              </td>
              <td class="text-center align-middle">
                <span class="badge bg-success">{{ number_format($item->tax_rate ?? 0, 1) }}%</span>
              </td>
              <td class="text-end align-middle">
                <span class="fw-bold text-success">₹{{ number_format($item->line_total ?? ($item->quantity * $item->unit_price), 2) }}</span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-5">
                <div class="text-muted">
                  <i class="bi bi-inbox display-4 d-block mb-2"></i>
                  <p class="mb-0">No items found for this invoice</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
        </table>
    </div>

    <!-- HSN/SAC Summary Table -->
    <div class="hsn-summary-section p-4 border-bottom">
      <div class="d-flex align-items-center mb-3">
        <i class="bi bi-table text-success me-2 fs-5"></i>
        <h6 class="mb-0 fw-bold text-success">HSN/SAC Tax Summary</h6>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
        <thead class="table-success">
          <tr>
            <th><i class="bi bi-upc-scan me-1"></i>HSN/SAC</th>
            <th class="text-end"><i class="bi bi-currency-rupee me-1"></i>Taxable Value</th>
            <th class="text-center">CGST Rate</th>
            <th class="text-end">CGST Amount</th>
            <th class="text-center">SGST Rate</th>
            <th class="text-end">SGST Amount</th>
            <th class="text-end"><i class="bi bi-calculator me-1"></i>Total Amount</th>
          </tr>
        </thead>
        <tbody>
          @php
            $hsnGroups = [];
            foreach($invoice->items as $item) {
              $hsn = $item->hsn_code ?: 'N/A';
              if (!isset($hsnGroups[$hsn])) {
                $hsnGroups[$hsn] = [
                  'taxable_value' => 0,
                  'cgst_rate' => $item->cgst_rate ?? ($item->tax_rate / 2),
                  'sgst_rate' => $item->sgst_rate ?? ($item->tax_rate / 2),
                  'cgst_amount' => 0,
                  'sgst_amount' => 0,
                  'total_amount' => 0
                ];
              }
              
              $itemAmount = $item->quantity * $item->unit_price;
              $hsnGroups[$hsn]['taxable_value'] += $itemAmount;
              $hsnGroups[$hsn]['cgst_amount'] += ($itemAmount * $hsnGroups[$hsn]['cgst_rate']) / 100;
              $hsnGroups[$hsn]['sgst_amount'] += ($itemAmount * $hsnGroups[$hsn]['sgst_rate']) / 100;
              $hsnGroups[$hsn]['total_amount'] += $itemAmount + $hsnGroups[$hsn]['cgst_amount'] + $hsnGroups[$hsn]['sgst_amount'];
            }
          @endphp
          @foreach($hsnGroups as $hsn => $group)
            <tr>
              <td>{{ $hsn }}</td>
              <td class="text-end">₹{{ number_format($group['taxable_value'], 2) }}</td>
              <td class="text-center">{{ number_format($group['cgst_rate'], 1) }}%</td>
              <td class="text-end">₹{{ number_format($group['cgst_amount'], 2) }}</td>
              <td class="text-center">{{ number_format($group['sgst_rate'], 1) }}%</td>
              <td class="text-end">₹{{ number_format($group['sgst_amount'], 2) }}</td>
              <td class="text-end">₹{{ number_format($group['total_amount'], 2) }}</td>
            </tr>
          @endforeach
        </tbody>
        </table>
      </div>
    </div>

    <!-- Invoice Totals -->
    <div class="invoice-totals p-4">
      <div class="row">
        <div class="col-md-7">
          <div class="amount-in-words p-3 border rounded bg-light">
            <h6 class="mb-2 text-primary"><i class="bi bi-currency-rupee me-1"></i>Amount in Words:</h6>
            <p class="mb-0 fw-bold text-dark">{{ $amountInWords }}</p>
          </div>
        </div>
        <div class="col-md-5">
          <div class="totals-section">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Subtotal:</span>
                  <span class="fw-semibold">₹{{ number_format($invoice->subtotal ?? 0, 2) }}</span>
                </div>
                @if($invoice->discount_amount > 0)
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Discount:</span>
                  <span class="text-danger">-₹{{ number_format($invoice->discount_amount, 2) }}</span>
                </div>
                @endif
                @if($invoice->tax_amount > 0)
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Tax Amount:</span>
                  <span class="fw-semibold">₹{{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
                @endif
                <hr class="my-2">
                <div class="d-flex justify-content-between mb-2">
                  <span class="fw-bold text-primary">Total Amount:</span>
                  <span class="fw-bold text-primary fs-5">₹{{ number_format($invoice->total_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Paid Amount:</span>
                  <span class="text-success fw-semibold">₹{{ number_format($invoice->paid_amount ?? 0, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="fw-bold text-warning">Balance Amount:</span>
                  <span class="fw-bold text-warning fs-6">₹{{ number_format($invoice->balance_amount ?? $invoice->total_amount, 2) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Notes and Terms -->
    @if($invoice->notes || $invoice->terms_conditions)
    <div class="invoice-footer border-top p-4">
      <div class="row">
        @if($invoice->notes)
        <div class="col-md-6">
          <h6 class="mb-2">Notes:</h6>
          <p class="text-muted small">{{ $invoice->notes }}</p>
        </div>
        @endif
        @if($invoice->terms_conditions)
        <div class="col-md-6">
          <h6 class="mb-2">Terms & Conditions:</h6>
          <p class="text-muted small">{{ $invoice->terms_conditions }}</p>
        </div>
        @endif
      </div>
    </div>
    @endif

    <!-- Invoice Footer -->
    <div class="invoice-signature border-top p-4">
      <div class="row">
        <div class="col-6">
          <div class="signature-section">
            <p class="mb-1">Thank you for your business!</p>
            <small class="text-muted">This is a computer generated invoice.</small>
          </div>
        </div>
        <div class="col-6 text-end">
          <div class="signature-section">
            <div class="signature-line mb-3" style="border-bottom: 1px solid #000; width: 200px; margin-left: auto;"></div>
            <p class="mb-0"><strong>Authorized Signature</strong></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<style>
/* Invoice Document Styling */
.invoice-document {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  line-height: 1.5;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
  border-radius: 8px;
  overflow: hidden;
}

.invoice-title {
  font-size: 2.2rem;
  font-weight: 700;
  color: #2c3e50;
  margin: 0;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
}

/* Enhanced styling for better UI */
.info-item {
  transition: all 0.3s ease;
}

.info-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.party-card {
  transition: all 0.3s ease;
}

.party-card:hover {
  transform: translateY(-2px);
}

.item-row:hover {
  background-color: #f8f9fa;
  transform: scale(1.01);
  transition: all 0.2s ease;
}

.status-badge .badge {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}

.invoice-meta {
  font-size: 0.95rem;
  line-height: 1.6;
}

.invoice-total-preview h3 {
  font-size: 1.8rem;
  font-weight: bold;
  color: #333;
}

.party-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #333;
  border-bottom: 2px solid #eee;
  padding-bottom: 0.5rem;
}

.party-details {
  font-size: 0.9rem;
  line-height: 1.5;
}

.invoice-items .table {
  font-size: 0.9rem;
}

.invoice-items .table th {
  background-color: #f8f9fa;
  font-weight: 600;
  border: 1px solid #dee2e6;
  padding: 0.75rem 0.5rem;
}

.invoice-items .table td {
  border: 1px solid #dee2e6;
  padding: 0.75rem 0.5rem;
  vertical-align: middle;
}

.totals-section .table td {
  padding: 0.5rem 0.75rem;
  font-size: 0.95rem;
}

.signature-line {
  height: 50px;
}

/* Badge Styling */
.badge-secondary { background-color: #6c757d; }
.badge-success { background-color: #28a745; }
.badge-danger { background-color: #dc3545; }
.badge-warning { background-color: #ffc107; color: #212529; }

/* Print Styles */
@media print {
  .no-print {
    display: none !important;
  }
  
  body {
    font-size: 12px;
    background: white !important;
    color: black !important;
    margin: 0;
    padding: 0;
  }
  
  .container-fluid {
    padding: 0 !important;
    margin: 0 !important;
    max-width: 100% !important;
  }
  
  .invoice-document {
    box-shadow: none !important;
    border: none !important;
    max-width: 100% !important;
    width: 100% !important;
    margin: 0 !important;
  }
  
  .invoice-title {
    font-size: 2rem !important;
  }
  
  .invoice-total-preview h3 {
    font-size: 1.5rem !important;
  }
  
  .table {
    font-size: 11px !important;
  }
  
  .table th, .table td {
    padding: 0.4rem !important;
    border: 1px solid #000 !important;
  }
  
  .table thead th {
    background: #f0f0f0 !important;
    -webkit-print-color-adjust: exact;
  }
  
  .badge {
    border: 1px solid #000 !important;
    background: white !important;
    color: black !important;
    -webkit-print-color-adjust: exact;
  }
  
  .border, .border-bottom, .border-top {
    border-color: #000 !important;
  }
  
  .signature-line {
    border-bottom: 1px solid #000 !important;
  }
  
  /* Page break controls */
  .invoice-header, .invoice-parties {
    page-break-inside: avoid;
  }
  
  .invoice-items {
    page-break-inside: auto;
  }
  
  .invoice-totals, .invoice-footer, .invoice-signature {
    page-break-inside: avoid;
  }
}

/* Full width styling */
.invoice-document {
  width: 100% !important;
  max-width: none !important;
  margin: 0 !important;
}

/* Responsive */
@media (max-width: 768px) {
  .invoice-document {
    margin: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
  }
  
  .invoice-title {
    font-size: 2rem;
  }
  
  .party-details {
    font-size: 0.85rem;
  }
  
  .table {
    font-size: 0.8rem;
  }
}
</style>
@endsection

@push('scripts')
<script>
function printInvoice() {
  // Hide all non-essential elements for printing
  const elementsToHide = document.querySelectorAll('.no-print, .btn, .alert');
  elementsToHide.forEach(el => el.style.display = 'none');
  
  // Add print-specific styling
  document.body.classList.add('printing');
  
  // Print the page
  window.print();
  
  // Restore elements after printing
  setTimeout(() => {
    elementsToHide.forEach(el => el.style.display = '');
    document.body.classList.remove('printing');
  }, 1000);
}

function sendInvoice() {
  if (confirm('Are you sure you want to send this invoice to the customer?')) {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-spinner-border spinner-border-sm me-2"></i>Sending...';
    btn.disabled = true;
    
    // Simulate sending (replace with actual AJAX call)
    setTimeout(() => {
      alert('Invoice sent successfully to customer email!');
      btn.innerHTML = originalText;
      btn.disabled = false;
    }, 2000);
  }
}

// Add download PDF functionality
function downloadPDF() {
  // This would integrate with a PDF generation library
  alert('PDF download functionality would be implemented here using libraries like jsPDF or server-side PDF generation.');
}
</script>
@endpush
