{{-- Enhanced Item Details --}}
@extends('layouts.admin')
@section('title','Item Details')
@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-1 fw-bold text-dark d-flex align-items-center">
        <i class="bi bi-box-seam me-2"></i> {{ $item->name }}
      </h2>
      <div class="text-muted small">Detailed item record</div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-primary btn-sm fw-semibold">
        <i class="bi bi-pencil me-1"></i> Edit Item
      </a>
      <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Back to Items
      </a>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <!-- General Item Information Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-info-circle text-primary me-2"></i> General Item Information
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small text-muted mb-1">Name</label>
              <p class="fw-medium text-dark mb-0">{{ $item->name }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Code</label>
              <p class="fw-medium text-dark mb-0">{{ $item->code ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Barcode</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Barcode ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Compcode</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Compcode ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Compname</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Compname }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Pack</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Pack ?? '1' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Unit</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Unit ?? 'PCS' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Location</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Location ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Mfg. By</label>
              <p class="fw-medium text-dark mb-0">{{ $item->MfgBy ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Division</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Division ?? '00' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Box Qty.</label>
              <p class="fw-medium text-dark mb-0">{{ $item->BoxQty ?? '0' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Case Qty.</label>
              <p class="fw-medium text-dark mb-0">{{ $item->CaseQty ?? '0' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Schedule</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Schedule ?? '00' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Min. Level</label>
              <p class="fw-medium text-dark mb-0">{{ $item->MinLevel ?? '0' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Max. Level</label>
              <p class="fw-medium text-dark mb-0">{{ $item->MaxLevel ?? '0' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Flag</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Flag ?? 'Narcotic' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Status</label>
              <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $item->status ? 'Active' : 'Inactive' }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Composition & Strengths Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-capsule text-primary me-2"></i> Composition & Strengths
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Saltcode</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Saltcode ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Strength</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Strength ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">saltcode1</label>
              <p class="fw-medium text-dark mb-0">{{ $item->saltcode1 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Strength1</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Strength1 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">saltcode2</label>
              <p class="fw-medium text-dark mb-0">{{ $item->saltcode2 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Strength2</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Strength2 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">saltcode3</label>
              <p class="fw-medium text-dark mb-0">{{ $item->saltcode3 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Strength3</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Strength3 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Saltcode4</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Saltcode4 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Strength4</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Strength4 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Saltcode5</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Saltcode5 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Strength5</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Strength5 ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Substitute</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Substitute ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Saltno</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Saltno ?? '0' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">SubStrenght</label>
              <p class="fw-medium text-dark mb-0">{{ $item->SubStrenght ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">ItemRef</label>
              <p class="fw-medium text-dark mb-0">{{ $item->ItemRef ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Pricing, Taxes & Scheme Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-percent text-primary me-2"></i> Pricing, Taxes & Scheme
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Prate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Prate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Tsr</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Tsr ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Psc</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Psc ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">ptax</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->ptax ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Excise</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Excise ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Scm1</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Scm1 ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">scm2</label>
              <p class="fw-medium text-dark mb-0">{{ $item->scm2 ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Srate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Srate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Sc</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Sc ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Saletype</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Saletype ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Stax</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Stax ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Wsrate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Wsrate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Add_sc</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Add_sc ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Add_tsr</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Add_tsr ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Costrate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Costrate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">ScmPer</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->ScmPer ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">currentScm</label>
              <p class="fw-medium text-dark mb-0">{{ $item->currentScm ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Mrp</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Mrp ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Discount Amount</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->discount_amount ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Discount Percent (%)</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->discount_percent ?? 0, 2) }}%</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">ScmFrom</label>
              <p class="fw-medium text-dark mb-0">{{ $item->ScmFrom ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">ScmTo</label>
              <p class="fw-medium text-dark mb-0">{{ $item->ScmTo ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">CurrScm1</label>
              <p class="fw-medium text-dark mb-0">{{ $item->CurrScm1 ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">CurrScm2</label>
              <p class="fw-medium text-dark mb-0">{{ $item->CurrScm2 ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Stock & Batch Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-box-seam text-primary me-2"></i> Stock & Batch
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">opqty</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->opqty ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Clqty</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Clqty ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Vdt</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Vdt ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Batchcode</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Batchcode ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">cname_bc</label>
              <p class="fw-medium text-dark mb-0">{{ $item->cname_bc ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Defqty</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Defqty ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">mTag</label>
              <p class="fw-medium text-dark mb-0">{{ $item->mTag ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">DisContinue</label>
              <span class="badge {{ $item->DisContinue ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $item->DisContinue ? 'Yes' : 'No' }}
              </span>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Vol</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Vol ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">VDisP</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->VDisP ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">VDisS</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->VDisS ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">FDisWR</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->FDisWR ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">LastYearCost</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->LastYearCost ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">OpAddQty</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->OpAddQty ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">SaleLessQty</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->SaleLessQty ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">SplDisQty</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->SplDisQty ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">SplDisPer</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->SplDisPer ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">FullName</label>
              <p class="fw-medium text-dark mb-0">{{ $item->FullName ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">LockScm</label>
              <span class="badge {{ $item->LockScm ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $item->LockScm ? 'Yes' : 'No' }}
              </span>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">RateLock</label>
              <span class="badge {{ $item->RateLock ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $item->RateLock ? 'Yes' : 'No' }}
              </span>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">MinRate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->MinRate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">CostWFQ</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->CostWFQ ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">PurExciseAsRate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->PurExciseAsRate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">PurNetRate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->PurNetRate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">LockBilling</label>
              <span class="badge {{ $item->LockBilling ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $item->LockBilling ? 'Yes' : 'No' }}
              </span>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">SameBatchCost</label>
              <span class="badge {{ $item->SameBatchCost ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2 py-1">
                {{ $item->SameBatchCost ? 'Yes' : 'No' }}
              </span>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">EsCode</label>
              <p class="fw-medium text-dark mb-0">{{ $item->EsCode ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">FdisPWS</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->FdisPWS ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">ItemType</label>
              <p class="fw-medium text-dark mb-0">{{ $item->ItemType ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">ItemGroup</label>
              <p class="fw-medium text-dark mb-0">{{ $item->ItemGroup ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">GST Cess (%)</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->GSTCess ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">IucCode</label>
              <p class="fw-medium text-dark mb-0">{{ $item->IucCode ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">miscsettings</label>
              <p class="fw-medium text-dark mb-0">{{ $item->miscsettings ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">SyncMark</label>
              <p class="fw-medium text-dark mb-0">{{ $item->SyncMark ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Sales Details Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-currency-rupee text-primary me-2"></i> Sales Details
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Net</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Net ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Spl. Rate</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->SplRate ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">Min. GP</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->MinGP ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Commodity</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Commodity ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Scheme</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Scheme ?? '0' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Purchase Details Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-cart text-primary me-2"></i> Purchase Details
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Cost</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Cost ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Pur. Scheme</label>
              <p class="fw-medium text-dark mb-0">{{ $item->PurScheme ?? '0' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">NR</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->NR ?? 0, 2) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- GST Details Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-percent text-primary me-2"></i> GST Details
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">HSN Code</label>
              <p class="fw-medium text-dark mb-0">{{ $item->HSNCode ?? '-' }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">CGST (%)</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->CGST ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">SGST (%)</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->SGST ?? 0, 2) }}</p>
            </div>
            <div class="col-md-2">
              <label class="form-label small text-muted mb-1">IGST (%)</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->IGST ?? 0, 2) }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted mb-1">Cess (%)</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Cess ?? 0, 2) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Other Details Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-tags text-primary me-2"></i> Other Details
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Fixed Dis. (Y/N/M)</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->FixedDis ?? 0, 2) }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Category</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Category ?? '00' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Inventory & Physical Properties Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-box text-primary me-2"></i> Inventory & Physical Properties
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Max Inv. Qty</label>
              <p class="fw-medium text-dark mb-0">{{ $item->MaxInvQty ?? '0' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Weight</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Weight ?? 0, 3) }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Volume</label>
              <p class="fw-medium text-dark mb-0">{{ number_format($item->Volume ?? 0, 3) }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Lock</label>
              <p class="fw-medium text-dark mb-0">{{ $item->Lock ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- System Flags & Controls Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-gear text-primary me-2"></i> System Flags & Controls
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Bar Code</label>
              <p class="fw-medium text-dark mb-0">{{ $item->BarCodeFlag ?? 'N' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Det. Qty.</label>
              <p class="fw-medium text-dark mb-0">{{ $item->DetQty ?? 'N' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Comp. Name (BC)</label>
              <p class="fw-medium text-dark mb-0">{{ $item->CompNameBC ?? 'Y' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">DPC Item</label>
              <p class="fw-medium text-dark mb-0">{{ $item->DPCItem ?? 'N' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Lock Sale</label>
              <p class="fw-medium text-dark mb-0">{{ $item->LockSale ?? 'N' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Classification & Categorization Card -->
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="mb-0 fw-semibold d-flex align-items-center">
            <i class="bi bi-diagram-3 text-primary me-2"></i> Classification & Categorization
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Commodity</label>
              <p class="fw-medium text-dark mb-0">{{ $item->CommodityClass ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Current Scheme</label>
              <p class="fw-medium text-dark mb-0">{{ $item->CurrentScheme ?? '-' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label small text-muted mb-1">Category</label>
              <p class="fw-medium text-dark mb-0">{{ $item->CategoryClass ?? '00' }}</p>
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