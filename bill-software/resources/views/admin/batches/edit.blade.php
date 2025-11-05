@extends('layouts.admin')

@section('title', 'Edit Batch')

@section('content')
<style>
    /* Reset body font size to normal */
    .batch-edit-page {
        font-size: 14px !important;
    }
    
    .compact-form {
        padding: 15px;
        background: #f5f5f5;
    }
    
    .compact-form label {
        font-weight: 600;
        font-size: 14px !important;
        margin-bottom: 0;
        white-space: nowrap;
    }
    
    .compact-form input,
    .compact-form select {
        font-size: 14px !important;
        padding: 8px 12px;
        height: 38px;
    }
    
    .compact-form .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    
    .header-section {
        background: white;
        border: 1px solid #dee2e6;
        padding: 10px;
        margin-bottom: 8px;
        border-radius: 4px;
    }
    
    .header-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 6px;
    }
    
    .field-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .inner-card {
        background: #e8f4f8;
        border: 1px solid #b8d4e0;
        padding: 8px;
        border-radius: 3px;
    }
    
    .form-section {
        background: white;
        border: 1px solid #dee2e6;
        padding: 10px;
        margin-bottom: 8px;
        border-radius: 4px;
    }
    
    .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    
    .form-field {
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 150px;
    }
    
    .form-field label {
        min-width: 100px;
        font-size: 14px !important;
    }
    
    .form-field input,
    .form-field select {
        flex: 1;
        min-width: 120px;
        font-size: 14px !important;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        padding: 15px;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 8px 16px !important;
        font-size: 14px !important;
    }
    
    .btn-action i {
        font-size: 16px !important;
    }
    
    /* Ensure icons are visible */
    .bi {
        font-size: 16px !important;
    }
    
    .form-section h6 {
        font-size: 16px !important;
        font-weight: 600;
    }
</style>

<div class="batch-edit-page">
<div class="container-fluid compact-form">
    <form id="batchEditForm" method="POST" action="{{ route('admin.batches.update', $purchaseItem->id) }}">
        @csrf
        @method('PUT')
        
        <!-- Summary Quantities Section -->
        <div class="form-section">
            <div class="form-row">
                <div class="form-field">
                    <label>Fifo Qty.:</label>
                    <input type="text" class="form-control readonly-field" value="{{ number_format($fifoQty, 0) }}" readonly>
                </div>
                <div class="form-field">
                    <label>Mst.Qty.:</label>
                    <input type="text" class="form-control readonly-field" value="{{ number_format($mstQty, 0) }}" readonly>
                </div>
                <div class="form-field">
                    <label>Actual:</label>
                    <input type="text" class="form-control readonly-field" value="{{ number_format($actualQty, 0) }}" readonly>
                </div>
            </div>
        </div>

        <!-- Invoice and Supplier Information -->
        <div class="form-section">
            <div class="form-row">
                <div class="form-field">
                    <label>Inv.No.:</label>
                    <input type="text" class="form-control readonly-field" value="{{ $purchaseItem->transaction->bill_no ?? '---' }}" readonly>
                </div>
                <div class="form-field">
                    <label>Date:</label>
                    <input type="text" class="form-control readonly-field" value="{{ $purchaseItem->transaction->bill_date ? $purchaseItem->transaction->bill_date->format('d-M-y') : '---' }}" readonly>
                </div>
                <div class="form-field" style="flex: 1;">
                    <label>Supplier/Manufacturer:</label>
                    <input type="text" class="form-control readonly-field" value="{{ $purchaseItem->transaction->supplier->name ?? '---' }}" readonly>
                </div>
                <div class="form-field">
                    <label>Batch Code:</label>
                    <input type="text" class="form-control readonly-field" value="{{ $purchaseItem->transaction->id ?? '---' }}" readonly>
                </div>
            </div>
        </div>

        <!-- Selected Batch Details -->
        <div class="form-section">
            <h6 class="mb-2">Batch Details</h6>
            <div class="form-row">
                <div class="form-field">
                    <label>Batch:</label>
                    <input type="text" class="form-control" name="batch_no" id="batch_no" value="{{ $purchaseItem->batch_no }}" required>
                </div>
                <div class="form-field">
                    <label>Qty.:</label>
                    <input type="number" class="form-control" name="qty" id="qty" value="{{ $purchaseItem->qty }}" step="0.01" required>
                </div>
                <div class="form-field">
                    <label>T.Qty.:</label>
                    <input type="text" class="form-control readonly-field" value="{{ number_format($totalQty, 0) }}" readonly>
                </div>
                <div class="form-field">
                    <label>BC:</label>
                    <input type="text" class="form-control" value="N" readonly>
                </div>
                <div class="form-field">
                    <label>DATE:</label>
                    <input type="date" class="form-control" value="{{ $purchaseItem->transaction->bill_date ? $purchaseItem->transaction->bill_date->format('Y-m-d') : '' }}" readonly>
                </div>
                <div class="form-field">
                    <label>Exp:</label>
                    <input type="text" class="form-control" name="expiry_date" id="expiry_date" value="{{ $purchaseItem->expiry_date ? $purchaseItem->expiry_date->format('m/Y') : '' }}" placeholder="MM/YYYY" maxlength="7">
                </div>
                <div class="form-field">
                    <label>Mfg:</label>
                    <input type="text" class="form-control" value="/" readonly>
                </div>
            </div>
        </div>

        <!-- Pricing and Financial Details -->
        <div class="form-section">
            <h6 class="mb-2">Pricing Details</h6>
            <div class="form-row">
                <div class="form-field">
                    <label>Sale Rate:</label>
                    <input type="number" class="form-control" name="s_rate" id="sale_rate" value="{{ $purchaseItem->s_rate ?? 0 }}" step="0.01">
                </div>
                <div class="form-field">
                    <label>P.Rate:</label>
                    <input type="number" class="form-control" name="pur_rate" id="pur_rate" value="{{ $purchaseItem->pur_rate }}" step="0.01" required>
                </div>
                <div class="form-field">
                    <label>S.C.(Rs):</label>
                    <input type="number" class="form-control" value="0.00" step="0.01" readonly>
                </div>
                <div class="form-field">
                    <label>Sale Scheme:</label>
                    <input type="text" class="form-control" value="0 + 0" readonly>
                </div>
                <div class="form-field">
                    <label>MRP:</label>
                    <input type="number" class="form-control" name="mrp" id="mrp" value="{{ $purchaseItem->mrp }}" step="0.01">
                </div>
                <div class="form-field">
                    <label>W.S.Rate:</label>
                    <input type="number" class="form-control" value="0.00" step="0.01" readonly>
                </div>
                <div class="form-field">
                    <label>Spl.Rate:</label>
                    <input type="number" class="form-control" value="0.00" step="0.01" readonly>
                </div>
                <div class="form-field">
                    <label>GST Rate:</label>
                    <input type="number" class="form-control" value="0.00" step="0.01" readonly>
                </div>
                <div class="form-field">
                    <label>GST PTS:</label>
                    <input type="number" class="form-control" value="0.00" step="0.01" readonly>
                </div>
                <div class="form-field">
                    <label>Pur.Dis:</label>
                    <input type="number" class="form-control" name="dis_percent" id="dis_percent" value="{{ $purchaseItem->dis_percent ?? 0 }}" step="0.01">
                </div>
                <div class="form-field">
                    <label>VAT:</label>
                    <input type="text" class="form-control readonly-field" value="12%" readonly>
                </div>
                <div class="form-field">
                    <label>Unit:</label>
                    <input type="text" class="form-control readonly-field" value="{{ $purchaseItem->unit ?? '1' }}" readonly>
                </div>
                <div class="form-field">
                    <label>Inc.:</label>
                    <input type="text" class="form-control readonly-field" value="N" readonly>
                </div>
                <div class="form-field">
                    <label>N.Rate:</label>
                    <input type="text" class="form-control readonly-field" value="N" readonly>
                </div>
                <div class="form-field">
                    <label>Margin:</label>
                    <input type="text" class="form-control" value="10.00 %" readonly>
                </div>
            </div>
        </div>

        <!-- Costing Information -->
        <div class="form-section">
            <h6 class="mb-2">Costing Information</h6>
            <div class="form-row">
                <div class="form-field">
                    <label>Cost:</label>
                    <input type="text" class="form-control readonly-field" value="{{ number_format($purchaseItem->pur_rate, 8) }}" readonly>
                </div>
                <div class="form-field">
                    <label>Cost WFQ:</label>
                    <input type="text" class="form-control readonly-field" value="{{ number_format($purchaseItem->pur_rate, 8) }}" readonly>
                </div>
                <div class="form-field">
                    <label>H (old) / B (rk.) / E (xpiry):</label>
                    <input type="text" class="form-control readonly-field" value="0" readonly>
                </div>
                <div class="form-field">
                    <label>Rate Diff.:</label>
                    <input type="text" class="form-control readonly-field" value="0.00" readonly>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="button" class="btn btn-sm btn-outline-secondary btn-action">Location</button>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-action">History (F5)</button>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-action">Costing</button>
            <button type="submit" class="btn btn-sm btn-primary btn-action">Modify (Enter)</button>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-action">Print Labels</button>
            <button type="submit" class="btn btn-sm btn-success btn-action">Save</button>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-action">FiFo Adjst. Report</button>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-action">Update GST Rate</button>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-action">GST Margin Rep.</button>
            <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-outline-danger btn-action">Exit</a>
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

