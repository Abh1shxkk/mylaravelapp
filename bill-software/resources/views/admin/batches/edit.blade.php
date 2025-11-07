@extends('layouts.admin')

@section('title', 'Edit Batch')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-pencil me-2"></i> Edit Batch</h4>
        <div class="text-muted small">Update batch information</div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
    <form id="batchEditForm" method="POST" action="{{ route('admin.batches.update', $purchaseItem->id) }}">
        @csrf
        @method('PUT')
        
        <!-- Summary Quantities Section -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fifo Qty.</label>
                        <input type="text" class="form-control" value="{{ number_format($fifoQty, 0) }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mst.Qty.</label>
                        <input type="text" class="form-control" value="{{ number_format($mstQty, 0) }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Actual</label>
                        <input type="text" class="form-control" value="{{ number_format($actualQty, 0) }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice and Supplier Information -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Inv.No.</label>
                        <input type="text" class="form-control" value="{{ $purchaseItem->transaction->bill_no ?? '---' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control" value="{{ $purchaseItem->transaction->bill_date ? $purchaseItem->transaction->bill_date->format('d-M-y') : '---' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Supplier/Manufacturer</label>
                        <input type="text" class="form-control" value="{{ $purchaseItem->transaction->supplier->name ?? '---' }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Batch Code</label>
                        <input type="text" class="form-control" value="{{ $purchaseItem->transaction->id ?? '---' }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Batch Details -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Batch Details</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Batch <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="batch_no" id="batch_no" value="{{ $purchaseItem->batch_no }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Qty. <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="qty" id="qty" value="{{ $purchaseItem->qty }}" step="0.01" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">T.Qty.</label>
                        <input type="text" class="form-control" value="{{ number_format($totalQty, 0) }}" readonly>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">BC</label>
                        <input type="text" class="form-control" value="N" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">DATE</label>
                        <input type="date" class="form-control" value="{{ $purchaseItem->transaction->bill_date ? $purchaseItem->transaction->bill_date->format('Y-m-d') : '' }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Exp</label>
                        <input type="text" class="form-control" name="expiry_date" id="expiry_date" value="{{ $purchaseItem->expiry_date ? $purchaseItem->expiry_date->format('m/Y') : '' }}" placeholder="MM/YYYY" maxlength="7">
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing and Financial Details -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Pricing Details</h6>
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Sale Rate</label>
                        <input type="number" class="form-control" name="s_rate" id="sale_rate" value="{{ $purchaseItem->s_rate ?? 0 }}" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">P.Rate <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="pur_rate" id="pur_rate" value="{{ $purchaseItem->pur_rate }}" step="0.01" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">MRP</label>
                        <input type="number" class="form-control" name="mrp" id="mrp" value="{{ $purchaseItem->mrp }}" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Pur.Dis</label>
                        <input type="number" class="form-control" name="dis_percent" id="dis_percent" value="{{ $purchaseItem->dis_percent ?? 0 }}" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Unit</label>
                        <input type="text" class="form-control" value="{{ $purchaseItem->unit ?? '1' }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-sm btn-outline-secondary">Location</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">History (F5)</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Costing</button>
            <button type="submit" class="btn btn-sm btn-primary">Modify (Enter)</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Print Labels</button>
            <button type="submit" class="btn btn-sm btn-success">Save</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">FiFo Adjst. Report</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Update GST Rate</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">GST Margin Rep.</button>
            <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-outline-danger">Exit</a>
        </div>
    </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('batchEditForm');
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        // Convert expiry_date from MM/YYYY to YYYY-MM-DD format
        const expiryDate = document.getElementById('expiry_date').value;
        if (expiryDate && expiryDate.includes('/')) {
            const [month, year] = expiryDate.split('/');
            if (month && year && year.length === 4) {
                const fullDate = `${year}-${month.padStart(2, '0')}-01`;
                formData.set('expiry_date', fullDate);
            } else {
                formData.set('expiry_date', '');
            }
        } else if (expiryDate) {
            // If already in YYYY-MM-DD format, use as is
            formData.set('expiry_date', expiryDate);
        } else {
            formData.set('expiry_date', '');
        }
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                window.location.href = '{{ route("admin.batches.index") }}';
            } else {
                alert('❌ ' + (data.message || 'Error updating batch'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ An error occurred while updating the batch.');
        });
    });
    
    // Format expiry date input (MM/YYYY)
    const expiryInput = document.getElementById('expiry_date');
    if (expiryInput) {
        expiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 6);
            }
            e.target.value = value;
        });
    }
});
</script>
@endpush

