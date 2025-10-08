@extends('layouts.admin')
@section('title','Edit Company')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <div class="text-muted small">Update company information</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-pencil-square me-2"></i> Edit Company</h4>
  </div>
  <a href="{{ route('admin.companies.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i>Back to Companies</a>
</div>

<div class="card shadow-sm">
  <div class="card-body p-4">
    <form method="POST" action="{{ route('admin.companies.update',$company) }}">
      @csrf @method('PUT')
      
      <!-- Basic Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
            <input name="name" class="form-control" value="{{ $company->name }}" required>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Short Name</label>
            <input name="short_name" class="form-control" value="{{ $company->short_name }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Alter Code</label>
            <input name="alter_code" class="form-control" value="{{ $company->alter_code }}">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Email</label>
            <input name="email" type="email" class="form-control" value="{{ $company->email }}">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Website</label>
            <input name="website" class="form-control" value="{{ $company->website }}" placeholder="https://">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Location</label>
            <input name="location" class="form-control" value="{{ $company->location }}">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Address</label>
            <textarea name="address" class="form-control" rows="2">{{ $company->address }}</textarea>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Contact Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-telephone me-2"></i>Contact Information</h5>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Contact Person I</label>
            <input name="contact_person_1" class="form-control" value="{{ $company->contact_person_1 }}">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Mobile 1</label>
            <input name="mobile_1" class="form-control" value="{{ $company->mobile_1 }}">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Telephone</label>
            <input name="telephone" class="form-control" value="{{ $company->telephone }}">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Contact Person II</label>
            <input name="contact_person_2" class="form-control" value="{{ $company->contact_person_2 }}">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Mobile 2</label>
            <input name="mobile_2" class="form-control" value="{{ $company->mobile_2 }}">
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Financial Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-cash-coin me-2"></i>Financial Information</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Pur S.C.</label>
            <input name="pur_sc" class="form-control" value="{{ $company->pur_sc }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Sale S.C.</label>
            <input name="sale_sc" class="form-control" value="{{ $company->sale_sc }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Pur Tax</label>
            <input name="pur_tax" class="form-control" value="{{ $company->pur_tax }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Sale Tax</label>
            <input name="sale_tax" class="form-control" value="{{ $company->sale_tax }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Dis. on Sale %</label>
            <input name="dis_on_sale_percent" class="form-control" value="{{ $company->dis_on_sale_percent }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Min GP</label>
            <input name="min_gp" class="form-control" value="{{ $company->min_gp }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">VAT %</label>
            <input name="vat_percent" class="form-control" value="{{ $company->vat_percent }}" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Discount</label>
            <input name="discount" class="form-control" value="{{ $company->discount }}" type="number" step="0.01">
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Business Information -->
      <div class="mb-4">
        <h5 class="mb-3 text-primary"><i class="bi bi-briefcase me-2"></i>Business Information</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Expiry</label>
            <input name="expiry" class="form-control" value="{{ $company->expiry }}" maxlength="1">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Generic</label>
            <input name="generic" class="form-control" value="{{ $company->generic }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">D(irect) / I(ndirect)</label>
            <input name="direct_indirect" class="form-control" value="{{ $company->direct_indirect }}" maxlength="1">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Invoice Print Order</label>
            <input name="invoice_print_order" class="form-control" value="{{ $company->invoice_print_order }}" type="number">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Disallow Expiry After (months)</label>
            <input name="disallow_expiry_after_months" class="form-control" value="{{ $company->disallow_expiry_after_months }}" type="number">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Flag</label>
            <input name="flag" class="form-control" value="{{ $company->flag }}">
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">F(ixed) / M(aximum)</label>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" name="fixed_maximum" id="fixed_maximum" {{ $company->fixed_maximum ? 'checked' : '' }}>
              <label class="form-check-label" for="fixed_maximum">Enable</label>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">Surcharge After Dis.</label>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" name="surcharge_after_dis_yn" id="surcharge_after_dis_yn" {{ $company->surcharge_after_dis_yn ? 'checked' : '' }}>
              <label class="form-check-label" for="surcharge_after_dis_yn">Yes</label>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">Add Surcharge</label>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" name="add_surcharge_yn" id="add_surcharge_yn" {{ $company->add_surcharge_yn ? 'checked' : '' }}>
              <label class="form-check-label" for="add_surcharge_yn">Yes</label>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">Inclusive</label>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" name="inclusive_yn" id="inclusive_yn" {{ $company->inclusive_yn ? 'checked' : '' }}>
              <label class="form-check-label" for="inclusive_yn">Yes</label>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold d-block">Status</label>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" name="status" id="status" {{ $company->status ? 'checked' : '' }}>
              <label class="form-check-label" for="status">Active</label>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Form Actions -->
      <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.companies.index') }}" class="btn btn-light px-4">
          <i class="bi bi-x-lg me-1"></i>Cancel
        </a>
        <button type="submit" class="btn btn-primary px-4">
          <i class="bi bi-check-lg me-1"></i>Update Company
        </button>
      </div>
    </form>
  </div>
</div>
@endsection