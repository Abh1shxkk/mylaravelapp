@extends('layouts.admin')
@section('title', 'Supplier Details')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <div class="text-muted small">Detailed supplier record</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-eye me-2"></i> Supplier Details</h4>
  </div>
  <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i>Back to Suppliers</a>
</div>

<div class="card shadow-sm border-0 rounded">
  <div class="card-body p-4">
    <div class="row g-4">
      
      <!-- Basic Information -->
      <div class="col-12">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Basic Information</h6>
      </div>
      
      <div class="col-md-6"><strong>Name:</strong> {{ $supplier->name }}</div>
      <div class="col-md-6"><strong>Code:</strong> {{ $supplier->code ?? '-' }}</div>
      <div class="col-md-6"><strong>Tax/Retail:</strong> {{ $supplier->tax_retail_flag }}</div>
      <div class="col-md-6"><strong>Full Name:</strong> {{ $supplier->full_name ?? '-' }}</div>
      <div class="col-12"><strong>Address:</strong> {{ $supplier->address ?? '-' }}</div>
      <div class="col-md-6"><strong>Telephone:</strong> {{ $supplier->telephone ?? '-' }}</div>
      <div class="col-md-6"><strong>Email:</strong> {{ $supplier->email ?? '-' }}</div>
      <div class="col-md-6"><strong>Fax:</strong> {{ $supplier->fax ?? '-' }}</div>
      <div class="col-md-6"><strong>Status:</strong> <span class="badge {{ $supplier->status ? 'bg-success' : 'bg-secondary' }}">{{ $supplier->status ? 'Active' : 'Inactive' }}</span></div>

      <!-- Contact Information -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Contact Information</h6>
      </div>
      
      <div class="col-md-6"><strong>B Day:</strong> {{ $supplier->b_day ? \Carbon\Carbon::parse($supplier->b_day)->format('d-m-Y') : '-' }}</div>
      <div class="col-md-6"><strong>A Day:</strong> {{ $supplier->a_day ? \Carbon\Carbon::parse($supplier->a_day)->format('d-m-Y') : '-' }}</div>
      <div class="col-md-6"><strong>Contact Person I:</strong> {{ $supplier->contact_person_1 ?? '-' }}</div>
      <div class="col-md-6"><strong>Contact Person II:</strong> {{ $supplier->contact_person_2 ?? '-' }}</div>
      <div class="col-md-6"><strong>Mobile:</strong> {{ $supplier->mobile ?? '-' }}</div>
      <div class="col-md-6"><strong>Mobile Additional:</strong> {{ $supplier->mobile_additional ?? '-' }}</div>
      <div class="col-md-6"><strong>Flag:</strong> {{ $supplier->flag ?? '-' }}</div>
      <div class="col-md-6"><strong>Visit Days:</strong> {{ $supplier->visit_days ?? '-' }}</div>

      <!-- License & Registration -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">License & Registration</h6>
      </div>
      
      <div class="col-md-6"><strong>D.L No.:</strong> {{ $supplier->dl_no ?? '-' }}</div>
      <div class="col-md-6"><strong>D.L No. 1:</strong> {{ $supplier->dl_no_1 ?? '-' }}</div>
      <div class="col-md-6"><strong>Food Lic.:</strong> {{ $supplier->food_lic ?? '-' }}</div>
      <div class="col-md-6"><strong>MSME Lic.:</strong> {{ $supplier->msme_lic ?? '-' }}</div>
      <div class="col-md-6"><strong>CST No.:</strong> {{ $supplier->cst_no ?? '-' }}</div>
      <div class="col-md-6"><strong>TIN No.:</strong> {{ $supplier->tin_no ?? '-' }}</div>
      <div class="col-md-6"><strong>GST No.:</strong> {{ $supplier->gst_no ?? '-' }}</div>
      <div class="col-md-6"><strong>PAN:</strong> {{ $supplier->pan ?? '-' }}</div>
      <div class="col-md-6"><strong>TAN No.:</strong> {{ $supplier->tan_no ?? '-' }}</div>
      <div class="col-md-6"><strong>State Code:</strong> {{ $supplier->state_code ?? '-' }}</div>
      <div class="col-md-6"><strong>Local/Central:</strong> {{ $supplier->local_central_flag }}</div>

      <!-- Financial Information -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Financial Information</h6>
      </div>
      
      <div class="col-md-6"><strong>Opening Balance:</strong> ₹{{ number_format($supplier->opening_balance, 2) }}</div>
      <div class="col-md-6"><strong>Credit Limit:</strong> ₹{{ number_format($supplier->credit_limit, 2) }}</div>
      <div class="col-md-6"><strong>Invoice Roff:</strong> ₹{{ number_format($supplier->invoice_roff, 2) }}</div>
      <div class="col-md-6"><strong>Direct/Indirect:</strong> {{ $supplier->direct_indirect }}</div>

      <!-- Bank Details -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Bank Details</h6>
      </div>
      
      <div class="col-md-6"><strong>Bank:</strong> {{ $supplier->bank ?? '-' }}</div>
      <div class="col-md-6"><strong>Branch:</strong> {{ $supplier->branch ?? '-' }}</div>
      <div class="col-md-6"><strong>A/c No.:</strong> {{ $supplier->account_no ?? '-' }}</div>
      <div class="col-md-6"><strong>IFSC Code:</strong> {{ $supplier->ifsc_code ?? '-' }}</div>

      <!-- System Flags -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">System Flags</h6>
      </div>
      
      <div class="col-md-6"><strong>Dis. On Excise:</strong> {{ $supplier->discount_on_excise ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Dis After Scheme:</strong> {{ $supplier->discount_after_scheme ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Sch. Type:</strong> {{ $supplier->scheme_type ?? '-' }}</div>
      <div class="col-md-6"><strong>Inv. on F.T. Rate:</strong> {{ $supplier->invoice_on_trade_rate ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Net Rate:</strong> {{ $supplier->net_rate_yn ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Scm. In Decimal:</strong> {{ $supplier->scheme_in_decimal ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>VAT on Br./Expiry:</strong> {{ $supplier->vat_on_bill_expiry ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Tax on FQty:</strong> {{ $supplier->tax_on_fqty ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Sale Pur. Status:</strong> {{ $supplier->sale_purchase_status }}</div>
      <div class="col-md-6"><strong>Composite Scheme:</strong> {{ $supplier->composite_scheme ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Stock Transfer:</strong> {{ $supplier->stock_transfer ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>Cash Purchase:</strong> {{ $supplier->cash_purchase ? 'Yes' : 'No' }}</div>

      <!-- Tax & Compliance -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Tax & Compliance</h6>
      </div>
      
      <div class="col-md-6"><strong>Aadhar:</strong> {{ $supplier->aadhar ?? '-' }}</div>
      <div class="col-md-6"><strong>Regd. Date:</strong> {{ $supplier->registration_date ? \Carbon\Carbon::parse($supplier->registration_date)->format('d-m-Y') : '-' }}</div>
      <div class="col-md-6"><strong>Registration Type:</strong> {{ $supplier->registered_unregistered_composite }}</div>
      <div class="col-md-6"><strong>TCS Applicable:</strong> {{ $supplier->tcs_applicable ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>TDS:</strong> {{ $supplier->tds_yn ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>TDS on Return:</strong> {{ $supplier->tds_on_return ? 'Yes' : 'No' }}</div>
      <div class="col-md-6"><strong>TDS/TCS on Bill Amt.:</strong> {{ $supplier->tds_tcs_on_bill_amount ? 'Yes' : 'No' }}</div>

    </div>
    <div class="mt-5 text-end">
      <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary me-2">Close</a>
      <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-primary">Edit Supplier</a>
    </div>
  </div>
</div>
@endsection