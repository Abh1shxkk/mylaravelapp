@extends('layouts.admin')
@section('title','Item Details')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <div class="text-muted small">Detailed record</div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-eye me-2"></i> Item Details</h4>
  </div>
  <a href="{{ route('admin.items.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i>Back to Items</a>
</div>

<div class="card shadow-sm border-0 rounded">
  <div class="card-body p-4">
    <div class="row g-4">
      <!-- General Information -->
      <div class="col-12">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">General Information</h6>
      </div>
      <div class="col-md-6"><strong>Name:</strong> {{ $item->name }}</div>
      <div class="col-md-6"><strong>Company:</strong> {{ $item->Compname }}</div>
      <div class="col-md-6"><strong>Packing:</strong> {{ $item->Pack }}</div>
      <div class="col-md-6"><strong>Unit:</strong> {{ $item->Unit }}</div>
      <div class="col-md-6"><strong>Manufacturer:</strong> {{ $item->MfgBy }}</div>
      <div class="col-md-6"><strong>Location:</strong> {{ $item->Location }}</div>
      <div class="col-md-6"><strong>Status:</strong> <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }}">{{ $item->status ? 'Active' : 'Inactive' }}</span></div>
      <div class="col-md-6"><strong>Bar Code:</strong> {{ $item->Barcode ?? '-' }}</div>
      <div class="col-md-6"><strong>Generic:</strong> {{ $item->Generic }}</div>

      <!-- Pricing Information -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Pricing Information</h6>
      </div>
      <div class="col-md-6"><strong>Sale Rate:</strong> ₹{{ number_format($item->Srate, 2) }}</div>
      <div class="col-md-6"><strong>Purchase Rate:</strong> ₹{{ number_format($item->Prate, 2) }}</div>
      <div class="col-md-6"><strong>MRP:</strong> ₹{{ number_format($item->Mrp, 2) }}</div>
      <div class="col-md-6"><strong>W.S. Rate:</strong> ₹{{ number_format($item->Wsrate, 2) }}</div>
      <div class="col-md-6"><strong>Special Rate:</strong> ₹{{ number_format($item->SplRate, 2) }}</div>
      <div class="col-md-6"><strong>Cost Rate:</strong> ₹{{ number_format($item->Cost, 2) }}</div>
      <div class="col-md-6"><strong>Min GP:</strong> {{ $item->MinGP }}%</div>

      <!-- Inventory Details -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Inventory Details</h6>
      </div>
      <div class="col-md-6"><strong>Box Qty:</strong> {{ $item->BoxQty }}</div>
      <div class="col-md-6"><strong>Min Qty:</strong> {{ $item->MinLevel }}</div>
      <div class="col-md-6"><strong>Max Qty:</strong> {{ $item->MaxLevel }}</div>
      <div class="col-md-6"><strong>Max Inv Qty:</strong> {{ $item->MaxInvQty }}</div>
      <div class="col-md-6"><strong>Opening Qty:</strong> {{ $item->opening_qty ?? 0 }}</div>
      <div class="col-md-6"><strong>Closing Qty:</strong> {{ $item->closing_qty ?? 0 }}</div>

      <!-- Tax Information -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Tax Information</h6>
      </div>
      <div class="col-md-6"><strong>HSN Code:</strong> {{ $item->HSNCode ?? '-' }}</div>
      <div class="col-md-6"><strong>CGST:</strong> {{ $item->CGST }}%</div>
      <div class="col-md-6"><strong>SGST:</strong> {{ $item->SGST }}%</div>
      <div class="col-md-6"><strong>IGST:</strong> {{ $item->IGST }}%</div>
      <div class="col-md-6"><strong>GST Cess:</strong> {{ $item->Cess }}%</div>
      <div class="col-md-6"><strong>VAT:</strong> {{ $item->VAT }}%</div>

      <!-- Additional Information -->
      <div class="col-12 mt-4">
        <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">Additional Information</h6>
      </div>
      <div class="col-md-6"><strong>Item Type:</strong> {{ $item->item_type ?? '00' }}</div>
      <div class="col-md-6"><strong>Item Group:</strong> {{ $item->item_group ?? '-' }}</div>
      <div class="col-md-6"><strong>Weight:</strong> {{ $item->Weight }} kg</div>
      <div class="col-md-6"><strong>Volume:</strong> {{ $item->Volume }}</div>
      <div class="col-md-6"><strong>Expiry:</strong> {{ $item->Expiry ? $item->Expiry : 'Y' }}</div>
      <div class="col-md-6"><strong>Division:</strong> {{ $item->Division ?? 'SPECIALTY' }}</div>
      <div class="col-md-6"><strong>Created:</strong> {{ $item->created_at->format('M d, Y H:i') }}</div>
    </div>
    <div class="mt-5 text-end">
      <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary me-2">Close</a>
      <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-primary">Edit Item</a>
    </div>
  </div>
</div>
@endsection