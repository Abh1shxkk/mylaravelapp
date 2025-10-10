@extends('layouts.admin')
@section('title', 'Supplier Details')
@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-1 fw-bold text-dark d-flex align-items-center">
        <i class="bi bi-eye me-2"></i> Supplier Details
      </h2>
      <div class="text-muted small">Detailed supplier record</div>
    </div>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
      <i class="bi bi-arrow-left me-1"></i> Back to Suppliers
    </a>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <!-- Basic Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-info-circle text-primary me-2"></i> Basic Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Name</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->name }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Code</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->code ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Tax/Retail</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tax_retail_flag }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Full Name</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->full_name ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Address</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->address ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Telephone</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->telephone ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Email</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->email ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Fax</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->fax ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Status</label>
              <span class="badge {{ $supplier->status ? 'bg-success' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $supplier->status ? 'Active' : 'Inactive' }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-telephone text-primary me-2"></i> Contact Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">B Day</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->b_day ? \Carbon\Carbon::parse($supplier->b_day)->format('d-m-Y') : '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">A Day</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->a_day ? \Carbon\Carbon::parse($supplier->a_day)->format('d-m-Y') : '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Contact Person I</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->contact_person_1 ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Contact Person II</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->contact_person_2 ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Mobile</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->mobile ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Mobile Additional</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->mobile_additional ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Flag</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->flag ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Visit Days</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->visit_days ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- License & Registration Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-file-text text-primary me-2"></i> License & Registration
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">D.L No.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->dl_no ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">D.L No. 1</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->dl_no_1 ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Food Lic.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->food_lic ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">MSME Lic.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->msme_lic ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">CST No.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->cst_no ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">TIN No.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tin_no ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">GST No.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->gst_no ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">PAN</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->pan ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">TAN No.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tan_no ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">State Code</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->state_code ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Local/Central</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->local_central_flag }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Financial Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-cash-coin text-primary me-2"></i> Financial Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Opening Balance</label>
              <p class="fw-medium text-success mb-0">₹{{ number_format($supplier->opening_balance, 2) }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Credit Limit</label>
              <p class="fw-medium text-success mb-0">₹{{ number_format($supplier->credit_limit, 2) }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Invoice Roff</label>
              <p class="fw-medium text-success mb-0">₹{{ number_format($supplier->invoice_roff, 2) }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Direct/Indirect</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->direct_indirect }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tax & Compliance Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-shield-check text-primary me-2"></i> Tax & Compliance
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Aadhar</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->aadhar ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Regd. Date</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->registration_date ? \Carbon\Carbon::parse($supplier->registration_date)->format('d-m-Y') : '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Registration Type</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->registered_unregistered_composite }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">TCS Applicable</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tcs_applicable ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">TDS</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tds_yn ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">TDS on Return</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tds_on_return ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">TDS/TCS on Bill Amt.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tds_tcs_on_bill_amount ? 'Yes' : 'No' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Bank Details Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-bank text-primary me-2"></i> Bank Details
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Bank</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->bank ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Branch</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->branch ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">A/c No.</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->account_no ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">IFSC Code</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->ifsc_code ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- System Flags Card -->
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-gear text-primary me-2"></i> System Flags
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Dis. On Excise</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->discount_on_excise ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Dis After Scheme</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->discount_after_scheme ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Sch. Type</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->scheme_type ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Inv. on F.T. Rate</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->invoice_on_trade_rate ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Net Rate</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->net_rate_yn ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Scm. In Decimal</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->scheme_in_decimal ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">VAT on Br./Expiry</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->vat_on_bill_expiry ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Tax on FQty</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->tax_on_fqty ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Sale Pur. Status</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->sale_purchase_status }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Composite Scheme</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->composite_scheme ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Stock Transfer</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->stock_transfer ? 'Yes' : 'No' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Cash Purchase</label>
              <p class="fw-medium text-dark mb-0">{{ $supplier->cash_purchase ? 'Yes' : 'No' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5 text-end">
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary me-2">Close</a>
    <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-primary">Edit Supplier</a>
  </div>
</div>

<style>
body {
  background-color: #f5f7fa;
  font-family: 'Inter', sans-serif;
}

.card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
}

.card-header {
  background-color: #f8f9fa !important;
  border-bottom: none !important;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  transition: background-color 0.2s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.btn-outline-secondary {
  border-color: #dee2e6;
  color: #495057;
}

.btn-outline-secondary:hover {
  background-color: #f8f9fa;
  color: #212529;
}

.badge {
  font-size: 0.85rem;
  font-weight: 500;
}

.form-label {
  font-size: 0.85rem;
  color: #6c757d;
}

.fw-medium {
  font-weight: 500;
  color: #212529;
}

.text-success {
  color: #28a745 !important;
}

@media (max-width: 767.98px) {
  .container-fluid {
    padding: 1rem;
  }

  .card-body {
    padding: 1.5rem !important;
  }

  .btn-sm {
    padding: 0.4rem 0.75rem;
    font-size: 0.85rem;
  }

  h2 {
    font-size: 1.5rem;
  }

  h5 {
    font-size: 1.1rem;
  }
}
</style>
@endsection