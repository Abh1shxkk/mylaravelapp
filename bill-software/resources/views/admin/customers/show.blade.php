{{-- Enhanced Customer Details --}}
@extends('layouts.admin')
@section('title','Customer Details')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <div class="text-muted small">Detailed customer record</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-person me-2"></i> Customer Details</h4>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
      <i class="bi bi-pencil me-1"></i>Edit Customer
    </a>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-light">
      <i class="bi bi-arrow-left me-1"></i>Back to Customers
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0 rounded-lg">
      <div class="card-body p-4">
        
        <!-- Basic Information Section -->
        <div class="section-card mb-5">
          <div class="section-header mb-4">
            <i class="bi bi-info-circle text-primary me-2"></i>
            <h5 class="mb-0">Basic Information</h5>
          </div>
          <div class="row g-4">
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Name:</label>
                <div class="fw-semibold text-dark">{{ $customer->name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Code:</label>
                <div class="fw-semibold">{{ $customer->code ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Email:</label>
                <div class="fw-semibold">{{ $customer->email ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Mobile:</label>
                <div class="fw-semibold">{{ $customer->mobile ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Country:</label>
                <div class="fw-semibold">{{ $customer->country_name ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">State:</label>
                <div class="fw-semibold">{{ $customer->state_name ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">City:</label>
                <div class="fw-semibold">{{ $customer->city ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Status:</label>
                <div>
                  <span class="badge {{ $customer->status ? 'bg-success' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                    {{ $customer->status ? 'Active' : 'Inactive' }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Address Information Section -->
        <div class="section-card mb-5">
          <div class="section-header mb-4">
            <i class="bi bi-geo-alt text-primary me-2"></i>
            <h5 class="mb-0">Address Information</h5>
          </div>
          <div class="row g-4">
            <div class="col-md-9">
              <div class="detail-item">
                <label class="text-muted small mb-1">Address:</label>
                <div class="fw-semibold">{{ $customer->address ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="detail-item">
                <label class="text-muted small mb-1">Pin Code:</label>
                <div class="fw-semibold">{{ $customer->pin_code ?? '-' }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="section-card mb-5">
          <div class="section-header mb-4">
            <i class="bi bi-telephone text-primary me-2"></i>
            <h5 class="mb-0">Contact Information</h5>
          </div>
          <div class="row g-4">
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Contact Person 1:</label>
                <div class="fw-semibold">{{ $customer->contact_person1 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Contact Person 2:</label>
                <div class="fw-semibold">{{ $customer->contact_person2 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Mobile Contact 1:</label>
                <div class="fw-semibold">{{ $customer->mobile_contact1 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Mobile Contact 2:</label>
                <div class="fw-semibold">{{ $customer->mobile_contact2 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Telephone Office:</label>
                <div class="fw-semibold">{{ $customer->telephone_office ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Telephone Residence:</label>
                <div class="fw-semibold">{{ $customer->telephone_residence ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Fax Number:</label>
                <div class="fw-semibold">{{ $customer->fax_number ?? '-' }}</div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <!-- Financial Information Section -->
    <div class="card shadow-sm border-0 rounded-lg mb-4">
      <div class="card-body p-4">
        <div class="section-header mb-4">
          <i class="bi bi-cash-coin text-primary me-2"></i>
          <h5 class="mb-0">Financial Information</h5>
        </div>
        <div class="detail-grid">
          <div class="detail-item">
            <label class="text-muted small mb-1">Opening Balance:</label>
            <div class="fw-semibold text-success">₹{{ number_format($customer->opening_balance ?? 0, 2) }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Balance Type:</label>
            <div class="fw-semibold">{{ $customer->balance_type ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Local/Central:</label>
            <div class="fw-semibold">{{ $customer->local_central ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Credit Days:</label>
            <div class="fw-semibold">{{ $customer->credit_days ?? '0' }} days</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Business Information Section -->
    <div class="card shadow-sm border-0 rounded-lg mb-4">
      <div class="card-body p-4">
        <div class="section-header mb-4">
          <i class="bi bi-briefcase text-primary me-2"></i>
          <h5 class="mb-0">Business Information</h5>
        </div>
        <div class="detail-grid">
          <div class="detail-item">
            <label class="text-muted small mb-1">Business Type:</label>
            <div class="fw-semibold">{{ $customer->business_type ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Invoice Export:</label>
            <div>
              <span class="badge {{ $customer->invoice_export ? 'bg-info' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                {{ $customer->invoice_export ? 'Yes' : 'No' }}
              </span>
            </div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Order Required:</label>
            <div>
              <span class="badge {{ $customer->order_required ? 'bg-info' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                {{ $customer->order_required ? 'Yes' : 'No' }}
              </span>
            </div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Registration Status:</label>
            <div class="fw-semibold">{{ $customer->registration_status ?? '-' }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Information Section -->
    <div class="card shadow-sm border-0 rounded-lg">
      <div class="card-body p-4">
        <div class="section-header mb-4">
          <i class="bi bi-gear text-primary me-2"></i>
          <h5 class="mb-0">System Information</h5>
        </div>
        <div class="detail-grid">
          <div class="detail-item">
            <label class="text-muted small mb-1">Created Date:</label>
            <div class="fw-semibold">{{ $customer->created_at ? $customer->created_at->format('M d, Y H:i:s') : '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Modified Date:</label>
            <div class="fw-semibold">{{ $customer->updated_at ? $customer->updated_at->format('M d, Y H:i:s') : '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Created By:</label>
            <div class="fw-semibold">admin</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Modified By:</label>
            <div class="fw-semibold">admin</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- License & Registration Section -->
<div class="card shadow-sm border-0 rounded-lg mt-4">
  <div class="card-body p-4">
    <div class="section-header mb-4">
      <i class="bi bi-file-text text-primary me-2"></i>
      <h5 class="mb-0">License & Registration</h5>
    </div>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Tax Registration:</label>
          <div class="fw-semibold">{{ $customer->tax_registration ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">TAN Number:</label>
          <div class="fw-semibold">{{ $customer->tan_number ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">PAN Number:</label>
          <div class="fw-semibold">{{ $customer->pan_number ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">TIN Number:</label>
          <div class="fw-semibold">{{ $customer->tin_number ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">CST Number:</label>
          <div class="fw-semibold">{{ $customer->cst_number ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">GST Name:</label>
          <div class="fw-semibold">{{ $customer->gst_name ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">MSME License:</label>
          <div class="fw-semibold">{{ $customer->msme_license ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Food License:</label>
          <div class="fw-semibold">{{ $customer->food_license ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">DL Number:</label>
          <div class="fw-semibold">{{ $customer->dl_number ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Aadhar Number:</label>
          <div class="fw-semibold">{{ $customer->aadhar_number ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Salesman Code:</label>
          <div class="fw-semibold">{{ $customer->sales_man_code ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Area Code:</label>
          <div class="fw-semibold">{{ $customer->area_code ?? '-' }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Additional Information Section -->
<div class="card shadow-sm border-0 rounded-lg mt-4">
  <div class="card-body p-4">
    <div class="section-header mb-4">
      <i class="bi bi-plus-circle text-primary me-2"></i>
      <h5 class="mb-0">Additional Information</h5>
    </div>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Flag:</label>
          <div class="fw-semibold">{{ $customer->flag ?? '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Birth Day:</label>
          <div class="fw-semibold">{{ $customer->birth_day ? date('M d, Y', strtotime($customer->birth_day)) : '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">Registration Date:</label>
          <div class="fw-semibold">{{ $customer->registration_date ? date('M d, Y', strtotime($customer->registration_date)) : '-' }}</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="detail-item">
          <label class="text-muted small mb-1">End Date:</label>
          <div class="fw-semibold">{{ $customer->end_date ? date('M d, Y', strtotime($customer->end_date)) : '-' }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Description Section -->
@if($customer->description)
<div class="card shadow-sm border-0 rounded-lg mt-4">
  <div class="card-body p-4">
    <div class="section-header mb-4">
      <i class="bi bi-card-text text-primary me-2"></i>
      <h5 class="mb-0">Description</h5>
    </div>
    <div class="detail-item">
      <p class="mb-0 text-muted">{{ $customer->description }}</p>
    </div>
  </div>
</div>
@endif

<style>
.section-card {
  position: relative;
}

.section-header {
  display: flex;
  align-items: center;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #e9ecef;
}

.detail-item {
  padding: 0.75rem 0;
  border-bottom: 1px solid #f8f9fa;
}

.detail-item:last-child {
  border-bottom: none;
}

.detail-item label {
  font-size: 0.875rem;
  margin-bottom: 0.25rem;
  color: #6c757d;
}

.detail-item .fw-semibold {
  color: #2c3e50;
  font-size: 0.95rem;
}

.detail-grid .detail-item {
  padding: 0.5rem 0;
}

.rounded-lg {
  border-radius: 0.75rem !important;
}
</style>
@endsection