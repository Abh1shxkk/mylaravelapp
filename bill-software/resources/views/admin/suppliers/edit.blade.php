@extends('layouts.admin')
@section('title', 'Edit Supplier')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <div class="text-muted small">Update supplier details</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-pencil-square me-2"></i> Edit Supplier</h4>
  </div>
  <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i>Back to Suppliers</a>
</div>

<div class="card shadow-sm border-0 rounded">
  <div class="card-body p-4">
    <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}" class="row g-4">
      @csrf @method('PUT')
      
      <!-- Basic Information -->
      <div class="col-12">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
      </div>
      
      <div class="col-md-6">
        <label class="form-label fw-medium">Name <span class="text-danger">*</span></label>
        <input name="name" class="form-control border-light-subtle" value="{{ $supplier->name }}" required>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Code</label>
        <input name="code" class="form-control border-light-subtle" value="{{ $supplier->code }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">T(ax)/R(etail)</label>
        <select name="tax_retail_flag" class="form-select border-light-subtle">
          <option value="T" {{ $supplier->tax_retail_flag == 'T' ? 'selected' : '' }}>T</option>
          <option value="R" {{ $supplier->tax_retail_flag == 'R' ? 'selected' : '' }}>R</option>
        </select>
      </div>
      
      <div class="col-12">
        <label class="form-label fw-medium">Address</label>
        <textarea name="address" class="form-control border-light-subtle" rows="2">{{ $supplier->address }}</textarea>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Telephone</label>
        <input name="telephone" class="form-control border-light-subtle" value="{{ $supplier->telephone }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Email</label>
        <input type="email" name="email" class="form-control border-light-subtle" value="{{ $supplier->email }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Fax</label>
        <input name="fax" class="form-control border-light-subtle" value="{{ $supplier->fax }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Status</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="status" {{ $supplier->status ? 'checked' : '' }}>
        </div>
      </div>

      <!-- Contact Information -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-person-lines-fill me-2"></i>Contact Information</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">B* Day</label>
        <input type="date" name="b_day" class="form-control border-light-subtle" value="{{ $supplier->b_day }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">A* Day</label>
        <input type="date" name="a_day" class="form-control border-light-subtle" value="{{ $supplier->a_day }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Contact Person I</label>
        <input name="contact_person_1" class="form-control border-light-subtle" value="{{ $supplier->contact_person_1 }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Contact Person II</label>
        <input name="contact_person_2" class="form-control border-light-subtle" value="{{ $supplier->contact_person_2 }}">
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Mobile</label>
        <input name="mobile" class="form-control border-light-subtle" value="{{ $supplier->mobile }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Mobile Additional</label>
        <input name="mobile_additional" class="form-control border-light-subtle" value="{{ $supplier->mobile_additional }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Flag</label>
        <input name="flag" class="form-control border-light-subtle" value="{{ $supplier->flag }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Visit Days</label>
        <input name="visit_days" class="form-control border-light-subtle" value="{{ $supplier->visit_days }}">
      </div>

      <!-- License & Registration -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-card-checklist me-2"></i>License & Registration</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">D.L No.</label>
        <input name="dl_no" class="form-control border-light-subtle" value="{{ $supplier->dl_no }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">D.L No. 1</label>
        <input name="dl_no_1" class="form-control border-light-subtle" value="{{ $supplier->dl_no_1 }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Food Lic.</label>
        <input name="food_lic" class="form-control border-light-subtle" value="{{ $supplier->food_lic }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">MSME Lic.</label>
        <input name="msme_lic" class="form-control border-light-subtle" value="{{ $supplier->msme_lic }}">
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">CST No.</label>
        <input name="cst_no" class="form-control border-light-subtle" value="{{ $supplier->cst_no }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">TIN No.</label>
        <input name="tin_no" class="form-control border-light-subtle" value="{{ $supplier->tin_no }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">GST No.</label>
        <input name="gst_no" class="form-control border-light-subtle" value="{{ $supplier->gst_no }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">PAN</label>
        <input name="pan" class="form-control border-light-subtle" value="{{ $supplier->pan }}">
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">TAN No.</label>
        <input name="tan_no" class="form-control border-light-subtle" value="{{ $supplier->tan_no }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">State Code</label>
        <input name="state_code" class="form-control border-light-subtle" value="{{ $supplier->state_code }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Local/Central</label>
        <select name="local_central_flag" class="form-select border-light-subtle">
          <option value="L" {{ $supplier->local_central_flag == 'L' ? 'selected' : '' }}>Local</option>
          <option value="C" {{ $supplier->local_central_flag == 'C' ? 'selected' : '' }}>Central</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Full Name</label>
        <input name="full_name" class="form-control border-light-subtle" value="{{ $supplier->full_name }}">
      </div>

      <!-- Financial Information -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-currency-rupee me-2"></i>Financial Information</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Opening Balance</label>
        <input type="number" step="0.01" name="opening_balance" class="form-control border-light-subtle" value="{{ $supplier->opening_balance }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Credit Limit</label>
        <input type="number" step="0.01" name="credit_limit" class="form-control border-light-subtle" value="{{ $supplier->credit_limit }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Invoice Roff</label>
        <input type="number" step="0.01" name="invoice_roff" class="form-control border-light-subtle" value="{{ $supplier->invoice_roff }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Direct/Indirect</label>
        <select name="direct_indirect" class="form-select border-light-subtle">
          <option value="D" {{ $supplier->direct_indirect == 'D' ? 'selected' : '' }}>Direct</option>
          <option value="I" {{ $supplier->direct_indirect == 'I' ? 'selected' : '' }}>Indirect</option>
        </select>
      </div>

      <!-- Bank Details -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-bank me-2"></i>Bank Details</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Bank</label>
        <input name="bank" class="form-control border-light-subtle" value="{{ $supplier->bank }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Branch</label>
        <input name="branch" class="form-control border-light-subtle" value="{{ $supplier->branch }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">A/c No.</label>
        <input name="account_no" class="form-control border-light-subtle" value="{{ $supplier->account_no }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">IFSC Code</label>
        <input name="ifsc_code" class="form-control border-light-subtle" value="{{ $supplier->ifsc_code }}">
      </div>

      <!-- System Flags -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-gear me-2"></i>System Flags</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Dis. On Excise</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="discount_on_excise" {{ $supplier->discount_on_excise ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Dis After Scheme</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="discount_after_scheme" {{ $supplier->discount_after_scheme ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Sch. Type</label>
        <input name="scheme_type" class="form-control border-light-subtle" value="{{ $supplier->scheme_type }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Inv. on F.T. Rate</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="invoice_on_trade_rate" {{ $supplier->invoice_on_trade_rate ? 'checked' : '' }}>
        </div>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Net Rate [Y/N/M]</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="net_rate_yn" {{ $supplier->net_rate_yn ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Scm. In Decimal</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="scheme_in_decimal" {{ $supplier->scheme_in_decimal ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">VAT on Br./Expiry</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="vat_on_bill_expiry" {{ $supplier->vat_on_bill_expiry ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Tax on FQty</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="tax_on_fqty" {{ $supplier->tax_on_fqty ? 'checked' : '' }}>
        </div>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Sale Pur. Status</label>
        <select name="sale_purchase_status" class="form-select border-light-subtle">
          <option value="P" {{ $supplier->sale_purchase_status == 'P' ? 'selected' : '' }}>Purchase</option>
          <option value="S" {{ $supplier->sale_purchase_status == 'S' ? 'selected' : '' }}>Sale</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Expiry on M(RP)/S(ale)/P(ur.)</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="expiry_on_mrp_sale_rate_purchase_rate" {{ $supplier->expiry_on_mrp_sale_rate_purchase_rate ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Composite Scheme</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="composite_scheme" {{ $supplier->composite_scheme ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Stock Transfer</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="stock_transfer" {{ $supplier->stock_transfer ? 'checked' : '' }}>
        </div>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Cash Purchase</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="cash_purchase" {{ $supplier->cash_purchase ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Add Charges with GST</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="add_charges_with_gst" {{ $supplier->add_charges_with_gst ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Pur. Import Box Conversion</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="purchase_import_box_conversion" {{ $supplier->purchase_import_box_conversion ? 'checked' : '' }}>
        </div>
      </div>

      <!-- Tax & Compliance -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-percent me-2"></i>Tax & Compliance</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Aadhar</label>
        <input name="aadhar" class="form-control border-light-subtle" value="{{ $supplier->aadhar }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Regd. Date</label>
        <input type="date" name="registration_date" class="form-control border-light-subtle" value="{{ $supplier->registration_date }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">R(egistered)/U(nregistered)/C(omposite)</label>
        <select name="registered_unregistered_composite" class="form-select border-light-subtle">
          <option value="R" {{ $supplier->registered_unregistered_composite == 'R' ? 'selected' : '' }}>Registered</option>
          <option value="U" {{ $supplier->registered_unregistered_composite == 'U' ? 'selected' : '' }}>Unregistered</option>
          <option value="C" {{ $supplier->registered_unregistered_composite == 'C' ? 'selected' : '' }}>Composite</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">TCS Applicable [Y/N/#]</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="tcs_applicable" {{ $supplier->tcs_applicable ? 'checked' : '' }}>
        </div>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">TDS [Y/N]</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="tds_yn" {{ $supplier->tds_yn ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">TDS on Return</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="tds_on_return" {{ $supplier->tds_on_return ? 'checked' : '' }}>
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">TDS / TCS on Bill Amt.</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="tds_tcs_on_bill_amount" {{ $supplier->tds_tcs_on_bill_amount ? 'checked' : '' }}>
        </div>
      </div>

      <div class="col-12 mt-5">
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
        <button class="btn btn-primary">Update Supplier</button>
      </div>
    </form>
  </div>
</div>
@endsection