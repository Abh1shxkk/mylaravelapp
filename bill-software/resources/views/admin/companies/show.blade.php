{{-- Enhanced Company Details --}}
@extends('layouts.admin')
@section('title','Company Details')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <div class="text-muted small">Detailed company record</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-building me-2"></i> Company Details</h4>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-primary">
      <i class="bi bi-pencil me-1"></i>Edit Company
    </a>
    <a href="{{ route('admin.companies.index') }}" class="btn btn-light">
      <i class="bi bi-arrow-left me-1"></i>Back to Companies
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
                <div class="fw-semibold text-dark">{{ $company->name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Code:</label>
                <div class="fw-semibold">{{ $company->alter_code ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Short Name:</label>
                <div class="fw-semibold">{{ $company->short_name ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Email:</label>
                <div class="fw-semibold">{{ $company->email ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">GST Number:</label>
                <div class="fw-semibold">{{ $company->gst_number ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Website:</label>
                <div class="fw-semibold">{{ $company->website ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Location:</label>
                <div class="fw-semibold">{{ $company->location ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Status:</label>
                <div>
                  <span class="badge {{ $company->status ? 'bg-success' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                    {{ $company->status ? 'Active' : 'Inactive' }}
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
            <div class="col-12">
              <div class="detail-item">
                <label class="text-muted small mb-1">Address:</label>
                <div class="fw-semibold">{{ $company->address ?? '-' }}</div>
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
                <div class="fw-semibold">{{ $company->contact_person_1 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Contact Person 2:</label>
                <div class="fw-semibold">{{ $company->contact_person_2 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Mobile Contact 1:</label>
                <div class="fw-semibold">{{ $company->mobile_1 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Mobile Contact 2:</label>
                <div class="fw-semibold">{{ $company->mobile_2 ?? '-' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Telephone Office:</label>
                <div class="fw-semibold">{{ $company->telephone ?? '-' }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Financial Information Section -->
        <div class="section-card mb-5">
          <div class="section-header mb-4">
            <i class="bi bi-cash-coin text-primary me-2"></i>
            <h5 class="mb-0">Financial Information</h5>
          </div>
          <div class="row g-4">
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Pur S.C.:</label>
                <div class="fw-semibold text-success">{{ $company->pur_sc ?? '0.00' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Sale S.C.:</label>
                <div class="fw-semibold text-success">{{ $company->sale_sc ?? '0.00' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Pur Tax:</label>
                <div class="fw-semibold text-success">{{ $company->pur_tax ?? '0.00' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Sale Tax:</label>
                <div class="fw-semibold text-success">{{ $company->sale_tax ?? '0.00' }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Dis. on Sale %:</label>
                <div class="fw-semibold">{{ $company->dis_on_sale_percent ?? '0.00' }}%</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Min GP:</label>
                <div class="fw-semibold">{{ $company->min_gp ?? '0.00' }}%</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">VAT %:</label>
                <div class="fw-semibold">{{ $company->vat_percent ?? '0.00' }}%</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-item">
                <label class="text-muted small mb-1">Discount:</label>
                <div class="fw-semibold text-success">{{ $company->discount ?? '0.00' }}</div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <!-- Business Information Section -->
    <div class="card shadow-sm border-0 rounded-lg mb-4">
      <div class="card-body p-4">
        <div class="section-header mb-4">
          <i class="bi bi-briefcase text-primary me-2"></i>
          <h5 class="mb-0">Business Information</h5>
        </div>
        <div class="detail-grid">
          <div class="detail-item">
            <label class="text-muted small mb-1">Expiry:</label>
            <div class="fw-semibold">{{ $company->expiry ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Generic:</label>
            <div class="fw-semibold">{{ $company->generic ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Direct/Indirect:</label>
            <div class="fw-semibold">{{ $company->direct_indirect ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Invoice Print Order:</label>
            <div class="fw-semibold">{{ $company->invoice_print_order ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Disallow Expiry After:</label>
            <div class="fw-semibold">{{ $company->disallow_expiry_after_months ?? '0' }} months</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Flag:</label>
            <div class="fw-semibold">{{ $company->flag ?? '-' }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Fixed/Maximum:</label>
            <div>
              <span class="badge {{ $company->fixed_maximum ? 'bg-info' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                {{ $company->fixed_maximum ? 'Yes' : 'No' }}
              </span>
            </div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Surcharge After Dis.:</label>
            <div>
              <span class="badge {{ $company->surcharge_after_dis_yn ? 'bg-info' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                {{ $company->surcharge_after_dis_yn ? 'Yes' : 'No' }}
              </span>
            </div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Add Surcharge:</label>
            <div>
              <span class="badge {{ $company->add_surcharge_yn ? 'bg-info' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                {{ $company->add_surcharge_yn ? 'Yes' : 'No' }}
              </span>
            </div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Inclusive:</label>
            <div>
              <span class="badge {{ $company->inclusive_yn ? 'bg-info' : 'bg-secondary' }} px-2 py-1 rounded-pill">
                {{ $company->inclusive_yn ? 'Yes' : 'No' }}
              </span>
            </div>
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
            <div class="fw-semibold">{{ $company->created_at->format('M d, Y H:i:s') }}</div>
          </div>
          <div class="detail-item">
            <label class="text-muted small mb-1">Modified Date:</label>
            <div class="fw-semibold">{{ $company->updated_at->format('M d, Y H:i:s') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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