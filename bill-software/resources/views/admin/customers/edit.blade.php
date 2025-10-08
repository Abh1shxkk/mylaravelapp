@extends('layouts.admin')
@section('title','Edit Customer')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <div class="text-muted small">Update customer information</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-pencil-square me-2"></i> Edit Customer</h4>
  </div>
  <a href="{{ route('admin.customers.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i>Back to Customers</a>
</div>

<div class="card shadow-sm">
  <div class="card-body p-4">
    <form method="POST" action="{{ route('admin.customers.update',$customer) }}">
      @csrf @method('PUT')
      
      <!-- Basic Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
            <input name="name" class="form-control" value="{{ $customer->name }}" required>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Code</label>
            <input name="code" class="form-control" value="{{ $customer->code }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Tax Registration</label>
            <input name="tax_registration" class="form-control" value="{{ $customer->tax_registration }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Flag</label>
            <input name="flag" class="form-control" value="{{ $customer->flag }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">City</label>
            <input name="city" class="form-control" value="{{ $customer->city }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">PIN Code</label>
            <input name="pin_code" class="form-control" value="{{ $customer->pin_code }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Address</label>
            <textarea name="address" class="form-control" rows="2">{{ $customer->address }}</textarea>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Mobile</label>
            <input name="mobile" class="form-control" value="{{ $customer->mobile }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Contact Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-telephone me-2"></i>Contact Information</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Telephone (Office)</label>
            <input name="telephone_office" class="form-control" value="{{ $customer->telephone_office }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Telephone (Residence)</label>
            <input name="telephone_residence" class="form-control" value="{{ $customer->telephone_residence }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Fax Number</label>
            <input name="fax_number" class="form-control" value="{{ $customer->fax_number }}">
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Contact Person 1</label>
            <input name="contact_person1" class="form-control" value="{{ $customer->contact_person1 }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Mobile Contact 1</label>
            <input name="mobile_contact1" class="form-control" value="{{ $customer->mobile_contact1 }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Contact Person 2</label>
            <input name="contact_person2" class="form-control" value="{{ $customer->contact_person2 }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Mobile Contact 2</label>
            <input name="mobile_contact2" class="form-control" value="{{ $customer->mobile_contact2 }}">
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Financial Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-cash-coin me-2"></i>Financial Information</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Opening Balance</label>
            <input name="opening_balance" class="form-control" value="{{ $customer->opening_balance }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Balance Type</label>
            <input name="balance_type" class="form-control" value="{{ $customer->balance_type }}" placeholder="Debit (D)/Credit (C)">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Local/Central</label>
            <input name="local_central" class="form-control" value="{{ $customer->local_central }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Credit Days</label>
            <input name="credit_days" type="number" class="form-control" value="{{ $customer->credit_days }}">
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Business Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-briefcase me-2"></i>Business Information</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Business Type</label>
            <input name="business_type" class="form-control" value="{{ $customer->business_type }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Registration Status</label>
            <input name="registration_status" class="form-control" value="{{ $customer->registration_status }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Birth Day</label>
            <input type="date" name="birth_day" class="form-control" value="{{ $customer->birth_day }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Due List Sequence</label>
            <input name="due_list_sequence" class="form-control" value="{{ $customer->due_list_sequence }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Registration Date</label>
            <input type="date" name="registration_date" class="form-control" value="{{ $customer->registration_date }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $customer->end_date }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Day Value</label>
            <input type="number" name="day_value" class="form-control" value="{{ $customer->day_value }}">
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">Order Required</label>
            <div class="form-check form-switch mt-2">
              <input type="checkbox" class="form-check-input" name="order_required" id="order_required" {{ $customer->order_required ? 'checked' : '' }}>
              <label class="form-check-label" for="order_required">Yes</label>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">Invoice Export</label>
            <div class="form-check form-switch mt-2">
              <input type="checkbox" class="form-check-input" name="invoice_export" id="invoice_export" {{ $customer->invoice_export ? 'checked' : '' }}>
              <label class="form-check-label" for="invoice_export">Yes</label>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">Status</label>
            <div class="form-check form-switch mt-2">
              <input type="checkbox" class="form-check-input" name="status" id="status" {{ $customer->status ? 'checked' : '' }}>
              <label class="form-check-label" for="status">Active</label>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- License & Registration -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-file-text me-2"></i>License & Registration</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">TAN Number</label>
            <input name="tan_number" class="form-control" value="{{ $customer->tan_number }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">PAN Number</label>
            <input name="pan_number" class="form-control" value="{{ $customer->pan_number }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">TIN Number</label>
            <input name="tin_number" class="form-control" value="{{ $customer->tin_number }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">CST Number</label>
            <input name="cst_number" class="form-control" value="{{ $customer->cst_number }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">CST Registration</label>
            <input name="cst_registration" class="form-control" value="{{ $customer->cst_registration }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">GST Name</label>
            <input name="gst_name" class="form-control" value="{{ $customer->gst_name }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">State Code (GST)</label>
            <input name="state_code_gst" class="form-control" value="{{ $customer->state_code_gst }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">MSME License</label>
            <input name="msme_license" class="form-control" value="{{ $customer->msme_license }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Food License</label>
            <input name="food_license" class="form-control" value="{{ $customer->food_license }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">DL Number</label>
            <input name="dl_number" class="form-control" value="{{ $customer->dl_number }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">DL Expiry</label>
            <input type="date" name="dl_expiry" class="form-control" value="{{ $customer->dl_expiry }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">DL Number 1</label>
            <input name="dl_number1" class="form-control" value="{{ $customer->dl_number1 }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Aadhar Number</label>
            <input name="aadhar_number" class="form-control" value="{{ $customer->aadhar_number }}">
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Codes & Routes -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-signpost me-2"></i>Codes & Routes</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Salesman Code</label>
            <input name="sales_man_code" class="form-control" value="{{ $customer->sales_man_code }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Area Code</label>
            <input name="area_code" class="form-control" value="{{ $customer->area_code }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Route Code</label>
            <input name="route_code" class="form-control" value="{{ $customer->route_code }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">State Code</label>
            <input name="state_code" class="form-control" value="{{ $customer->state_code }}">
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Description -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-card-text me-2"></i>Description</h5>
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $customer->description }}</textarea>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Form Actions -->
      <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.customers.index') }}" class="btn btn-light px-4">
          <i class="bi bi-x-lg me-1"></i>Cancel
        </a>
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-check-lg me-1"></i>Update Customer
        </button>
      </div>
    </form>
  </div>
</div>
@endsection