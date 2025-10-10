{{-- Enhanced Customer Details --}}
@extends('layouts.admin')
@section('title','Customer Details')
@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-1 fw-bold text-dark d-flex align-items-center">
        <i class="bi bi-person me-2"></i> {{ $customer->name }}
      </h2>
      <div class="text-muted small">Detailed customer record</div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary btn-sm fw-semibold">
        <i class="bi bi-pencil me-1"></i> Edit Customer
      </a>
      <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Back to Customers
      </a>
    </div>
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
              <p class="fw-medium text-dark mb-0">{{ $customer->name }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Code</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->code ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Email</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->email ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Mobile</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->mobile ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Country</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->country_name ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">State</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->state_name ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">City</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->city ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Status</label>
              <span class="badge {{ $customer->status ? 'bg-success' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $customer->status ? 'Active' : 'Inactive' }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Address Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-geo-alt text-primary me-2"></i> Address Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-9">
              <label class="form-label small text-muted mb-1">Address</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->address ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Pin Code</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->pin_code ?? '-' }}</p>
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
              <label class="form-label small text-muted mb-1">Contact Person 1</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->contact_person1 ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Contact Person 2</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->contact_person2 ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Mobile Contact 1</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->mobile_contact1 ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Mobile Contact 2</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->mobile_contact2 ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Telephone Office</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->telephone_office ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Telephone Residence</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->telephone_residence ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Fax Number</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->fax_number ?? '-' }}</p>
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
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Tax Registration</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->tax_registration ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">TAN Number</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->tan_number ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">PAN Number</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->pan_number ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">TIN Number</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->tin_number ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">CST Number</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->cst_number ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">GST Name</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->gst_name ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">MSME License</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->msme_license ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Food License</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->food_license ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">DL Number</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->dl_number ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Aadhar Number</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->aadhar_number ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Salesman Code</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->sales_man_code ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Area Code</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->area_code ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-plus-circle text-primary me-2"></i> Additional Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Flag</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->flag ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Birth Day</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->birth_day ? date('M d, Y', strtotime($customer->birth_day)) : '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Registration Date</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->registration_date ? date('M d, Y', strtotime($customer->registration_date)) : '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">End Date</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->end_date ? date('M d, Y', strtotime($customer->end_date)) : '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Description Card -->
      @if($customer->description)
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-card-text text-primary me-2"></i> Description
          </h5>
        </div>
        <div class="card-body p-4">
          <p class="mb-0 text-muted">{{ $customer->description }}</p>
        </div>
      </div>
      @endif
    </div>

    <div class="col-lg-4">
      <!-- Financial Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-cash-coin text-primary me-2"></i> Financial Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Opening Balance</label>
              <p class="fw-medium text-success mb-0">₹{{ number_format($customer->opening_balance ?? 0, 2) }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Balance Type</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->balance_type ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Local/Central</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->local_central ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Credit Days</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->credit_days ?? '0' }} days</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Business Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-briefcase text-primary me-2"></i> Business Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Business Type</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->business_type ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Invoice Export</label>
              <span class="badge {{ $customer->invoice_export ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $customer->invoice_export ? 'Yes' : 'No' }}
              </span>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Order Required</label>
              <span class="badge {{ $customer->order_required ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $customer->order_required ? 'Yes' : 'No' }}
              </span>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Registration Status</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->registration_status ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- System Information Card -->
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-gear text-primary me-2"></i> System Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Created Date</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->created_at ? $customer->created_at->format('M d, Y H:i:s') : '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Modified Date</label>
              <p class="fw-medium text-dark mb-0">{{ $customer->updated_at ? $customer->updated_at->format('M d, Y H:i:s') : '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Created By</label>
              <p class="fw-medium text-dark mb-0">admin</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Modified By</label>
              <p class="fw-medium text-dark mb-0">admin</p>
            </div>
          </div>
        </div>
      </div>
    </div>
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