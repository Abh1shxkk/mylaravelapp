@extends('layouts.admin')
@section('title','Edit Item')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <div class="text-muted small">Update item details</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-pencil-square me-2"></i> Edit Item</h4>
  </div>
  <a href="{{ route('admin.items.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i>Back to Items</a>
</div>

<div class="card shadow-sm border-0 rounded">
  <div class="card-body p-4">
    <form method="POST" action="{{ route('admin.items.update',$item) }}" class="row g-4">
      @csrf @method('PUT')
      
      <!-- General Item Information -->
      <div class="col-12">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-info-circle me-2"></i>General Item Information</h5>
      </div>
      
      <div class="col-md-6">
        <label class="form-label fw-medium">Name <span class="text-danger">*</span></label>
        <input name="name" class="form-control border-light-subtle" value="{{ $item->name }}" required>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Code</label>
        <input name="code" class="form-control border-light-subtle" value="{{ $item->code }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Barcode</label>
        <input name="Barcode" class="form-control border-light-subtle" value="{{ $item->Barcode }}">
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Company Code</label>
        <input name="Compcode" class="form-control border-light-subtle" value="{{ $item->Compcode }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Company Name</label>
        <input name="Compname" class="form-control border-light-subtle" value="{{ $item->Compname }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Pack</label>
        <input name="Pack" class="form-control border-light-subtle" value="{{ $item->Pack }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Unit</label>
        <input name="Unit" class="form-control border-light-subtle" value="{{ $item->Unit }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Location</label>
        <input name="Location" class="form-control border-light-subtle" value="{{ $item->Location }}">
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Mfg. By</label>
        <input name="MfgBy" class="form-control border-light-subtle" value="{{ $item->MfgBy }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Division</label>
        <input name="Division" class="form-control border-light-subtle" value="{{ $item->Division }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Box Qty.</label>
        <input type="number" name="BoxQty" class="form-control border-light-subtle" value="{{ $item->BoxQty }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Case Qty.</label>
        <input type="number" name="CaseQty" class="form-control border-light-subtle" value="{{ $item->CaseQty }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Schedule</label>
        <input name="Schedule" class="form-control border-light-subtle" value="{{ $item->Schedule }}">
      </div>
      
      <div class="col-md-2">
        <label class="form-label fw-medium">Min. Level</label>
        <input type="number" name="MinLevel" class="form-control border-light-subtle" value="{{ $item->MinLevel }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Max. Level</label>
        <input type="number" name="MaxLevel" class="form-control border-light-subtle" value="{{ $item->MaxLevel }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Flag</label>
        <input name="Flag" class="form-control border-light-subtle" value="{{ $item->Flag }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Status</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="status" {{ $item->status ? 'checked':'' }}>
        </div>
      </div>
      
      <!-- Sales Details -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-currency-rupee me-2"></i>Sales Details</h5>
      </div>
      
      <div class="col-md-2">
        <label class="form-label fw-medium">S. Rate</label>
        <input type="number" step="0.01" name="Srate" class="form-control border-light-subtle" value="{{ $item->Srate }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">MRP</label>
        <input type="number" step="0.01" name="Mrp" class="form-control border-light-subtle" value="{{ $item->Mrp }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Net</label>
        <input type="number" step="0.01" name="Net" class="form-control border-light-subtle" value="{{ $item->Net }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">W.S. Rate</label>
        <input type="number" step="0.01" name="Wsrate" class="form-control border-light-subtle" value="{{ $item->Wsrate }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Spl. Rate</label>
        <input type="number" step="0.01" name="SplRate" class="form-control border-light-subtle" value="{{ $item->SplRate }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Min. GP</label>
        <input type="number" step="0.01" name="MinGP" class="form-control border-light-subtle" value="{{ $item->MinGP }}">
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Commodity</label>
        <input name="Commodity" class="form-control border-light-subtle" value="{{ $item->Commodity }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Scheme</label>
        <input type="number" name="Scheme" class="form-control border-light-subtle" value="{{ $item->Scheme }}">
      </div>

      <!-- Purchase Details -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-cart me-2"></i>Purchase Details</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Pur. Rate</label>
        <input type="number" step="0.01" name="Prate" class="form-control border-light-subtle" value="{{ $item->Prate }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Cost</label>
        <input type="number" step="0.01" name="Cost" class="form-control border-light-subtle" value="{{ $item->Cost }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Scheme</label>
        <input type="number" name="PurScheme" class="form-control border-light-subtle" value="{{ $item->PurScheme }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">NR</label>
        <input type="number" step="0.01" name="NR" class="form-control border-light-subtle" value="{{ $item->NR }}">
      </div>

      <!-- GST Details -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-percent me-2"></i>GST Details</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">HSN Code</label>
        <input name="HSNCode" class="form-control border-light-subtle" value="{{ $item->HSNCode }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">CGST (%)</label>
        <input type="number" step="0.01" name="CGST" class="form-control border-light-subtle" value="{{ $item->CGST }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">SGST (%)</label>
        <input type="number" step="0.01" name="SGST" class="form-control border-light-subtle" value="{{ $item->SGST }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">IGST (%)</label>
        <input type="number" step="0.01" name="IGST" class="form-control border-light-subtle" value="{{ $item->IGST }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Cess (%)</label>
        <input type="number" step="0.01" name="Cess" class="form-control border-light-subtle" value="{{ $item->Cess }}">
      </div>

      <!-- Other Details -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-tags me-2"></i>Other Details</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">VAT (%)</label>
        <input type="number" step="0.01" name="VAT" class="form-control border-light-subtle" value="{{ $item->VAT }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Expiry</label>
        <input type="date" name="Expiry" class="form-control border-light-subtle" value="{{ $item->Expiry }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Generic</label>
        <input name="Generic" class="form-control border-light-subtle" value="{{ $item->Generic }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Sale Tax</label>
        <input type="number" step="0.01" name="Stax" class="form-control border-light-subtle" value="{{ $item->Stax }}">
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Fixed Dis. (Y/N/M)</label>
        <input type="number" step="0.01" name="FixedDis" class="form-control border-light-subtle" value="{{ $item->FixedDis }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Category</label>
        <input name="Category" class="form-control border-light-subtle" value="{{ $item->Category }}">
      </div>

      <!-- Inventory & Physical Properties -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-box me-2"></i>Inventory & Physical Properties</h5>
      </div>
      
      <div class="col-md-2">
        <label class="form-label fw-medium">Inclusive</label>
        <div class="form-check form-switch mt-2">
          <input type="checkbox" class="form-check-input" name="Inclusive" {{ $item->Inclusive ? 'checked':'' }}>
        </div>
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Max Inv. Qty</label>
        <input type="number" name="MaxInvQty" class="form-control border-light-subtle" value="{{ $item->MaxInvQty }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Weight</label>
        <input type="number" step="0.001" name="Weight" class="form-control border-light-subtle" value="{{ $item->Weight }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Volume</label>
        <input type="number" step="0.001" name="Volume" class="form-control border-light-subtle" value="{{ $item->Volume }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Lock</label>
        <input name="Lock" class="form-control border-light-subtle" value="{{ $item->Lock }}">
      </div>

      <!-- System Flags & Controls -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-gear me-2"></i>System Flags & Controls</h5>
      </div>
      
      <div class="col-md-2">
        <label class="form-label fw-medium">Bar Code</label>
        <input name="BarCodeFlag" class="form-control border-light-subtle" value="{{ $item->BarCodeFlag }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Det. Qty.</label>
        <input name="DetQty" class="form-control border-light-subtle" value="{{ $item->DetQty }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Comp. Name (BC)</label>
        <input name="CompNameBC" class="form-control border-light-subtle" value="{{ $item->CompNameBC }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">DPC Item</label>
        <input name="DPCItem" class="form-control border-light-subtle" value="{{ $item->DPCItem }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-medium">Lock Sale</label>
        <input name="LockSale" class="form-control border-light-subtle" value="{{ $item->LockSale }}">
      </div>

      <!-- Classification & Categorization -->
      <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="bi bi-diagram-3 me-2"></i>Classification & Categorization</h5>
      </div>
      
      <div class="col-md-3">
        <label class="form-label fw-medium">Commodity</label>
        <input name="CommodityClass" class="form-control border-light-subtle" value="{{ $item->CommodityClass }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Current Scheme</label>
        <input name="CurrentScheme" class="form-control border-light-subtle" value="{{ $item->CurrentScheme }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-medium">Category</label>
        <input name="CategoryClass" class="form-control border-light-subtle" value="{{ $item->CategoryClass }}">
      </div>

      <div class="col-12 mt-5">
        <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
        <button class="btn btn-primary">Update Item</button>
      </div>
    </form>
  </div>
</div>
@endsection