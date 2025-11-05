@extends('layouts.admin')

@section('title', 'Batch Management')

@section('content')
<style>
    /* Reset body font size to normal */
    .batch-management-page {
        font-size: 14px !important;
    }
    
    .batch-table {
        font-size: 14px !important;
        width: 100%;
    }
    
    .batch-table th {
        background: #e9ecef;
        font-weight: 600;
        text-align: center;
        border: 1px solid #dee2e6;
        padding: 10px 8px;
        font-size: 14px !important;
    }
    
    .batch-table td {
        padding: 10px 8px;
        text-align: center;
        border: 1px solid #dee2e6;
        vertical-align: middle;
        font-size: 14px !important;
    }
    
    .batch-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .item-header {
        background: #d4edff;
        font-weight: bold;
        padding: 12px;
        margin-bottom: 10px;
        border: 1px solid #b8d4e0;
        font-size: 15px !important;
    }
    
    .filter-section {
        background: white;
        border: 1px solid #dee2e6;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    
    .filter-section label {
        font-size: 14px !important;
    }
    
    .filter-section select,
    .filter-section input {
        font-size: 14px !important;
    }
    
    .btn-sm {
        padding: 6px 12px !important;
        font-size: 14px !important;
    }
    
    .btn-sm i {
        font-size: 16px !important;
    }
    
    /* Ensure icons are visible */
    .bi {
        font-size: 16px !important;
    }
    
    /* Table action buttons */
    .batch-table .btn {
        font-size: 14px !important;
        padding: 6px 12px !important;
    }
    
    .batch-table .btn i {
        font-size: 16px !important;
    }
</style>

<div class="batch-management-page">
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-box-seam me-2"></i> Batch Management</h4>
        <div class="text-muted">View and manage batches from purchase transactions</div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.batches.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="item_id" class="form-label">Filter by Item</label>
                    <select class="form-select" id="item_id" name="item_id" onchange="this.form.submit()">
                        <option value="">All Items</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ $itemId == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->bar_code ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button type="button" class="btn btn-primary btn-sm" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </form>
        </div>

        <!-- Batches Table -->
        @if($groupedBatches->count() > 0)
            @foreach($groupedBatches as $itemId => $batches)
                @php
                    $item = \App\Models\Item::find($itemId);
                    
                    // Skip if item not found
                    if (!$item) {
                        continue;
                    }
                    
                    // Get first batch for item name (only if batches exist)
                    $firstBatch = $batches->isNotEmpty() ? $batches->first() : null;
                    
                    // Filter out batches with null batch_no
                    $validBatches = $batches->filter(function($batch) {
                        return !empty($batch->batch_no);
                    });
                @endphp
                
                @if($validBatches->isNotEmpty() || $item)
                    <div class="item-header">
                        <strong>{{ $firstBatch->item_name ?? $item->name ?? 'N/A' }}</strong>
                        <span class="text-muted ms-2">(Packing: {{ $item->packing ?? '1*10' }})</span>
                    </div>
                    
                    @if($validBatches->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table batch-table">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Batch</th>
                                        <th>Exp.</th>
                                        <th>Qty.</th>
                                        <th>Rate</th>
                                        <th>F.T.Rate</th>
                                        <th>P.Rate</th>
                                        <th>MRP</th>
                                        <th>S.Rate</th>
                                        <th>WS.Rate</th>
                                        <th>Spl.Rate</th>
                                        <th>Scm.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($validBatches as $index => $batch)
                                        @php
                                            // Get all purchase transaction items for this batch
                                            $batchItems = \App\Models\PurchaseTransactionItem::where('item_id', $itemId)
                                                ->where('batch_no', $batch->batch_no);
                                            
                                            if ($batch->expiry_date) {
                                                $batchItems->whereDate('expiry_date', \Carbon\Carbon::parse($batch->expiry_date)->format('Y-m-d'));
                                            } else {
                                                $batchItems->whereNull('expiry_date');
                                            }
                                            
                                            $batchItems = $batchItems->get();
                                            
                                            // Calculate values
                                            $totalQty = $batch->total_qty ?? ($batchItems->sum('qty') ?? 0);
                                            $avgRate = $batch->avg_pur_rate ?? ($batchItems->avg('pur_rate') ?? 0);
                                            $avgMrp = $batch->avg_mrp ?? ($batchItems->avg('mrp') ?? 0);
                                            $maxRate = $batch->max_rate ?? ($batchItems->max('pur_rate') ?? 0);
                                            $avgSRate = $batchItems->avg('s_rate') ?? 0; // Average S.Rate from purchase_transaction_items
                                            
                                            // Format expiry date as MM/YY
                                            $expiryDisplay = $batch->expiry_date ? \Carbon\Carbon::parse($batch->expiry_date)->format('m/y') : '---';
                                            
                                            // Get first item ID for edit link
                                            $firstItemId = $batchItems->isNotEmpty() ? ($batchItems->first()->id ?? null) : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $batch->batch_no }}</td>
                                            <td>{{ $expiryDisplay }}</td>
                                            <td>{{ number_format($totalQty, 0) }}</td>
                                            <td>{{ number_format($avgRate, 2) }}</td>
                                            <td>{{ number_format($maxRate * 1.12, 2) }}</td> <!-- F.T.Rate (approx) -->
                                            <td>{{ number_format($avgRate, 2) }}</td>
                                            <td>{{ number_format($avgMrp, 2) }}</td>
                                            <td>{{ number_format($avgSRate, 2) }}</td> <!-- S.Rate from purchase_transaction_items -->
                                            <td>0.00</td> <!-- WS.Rate -->
                                            <td>0.00</td> <!-- Spl.Rate -->
                                            <td></td> <!-- Scheme -->
                                            <td>
                                                @if($firstItemId)
                                                    <a href="{{ route('admin.batches.edit', $firstItemId) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Edit Batch">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <p>No batches found for this item.</p>
                        </div>
                    @endif
                    <hr class="my-3">
                @endif
            @endforeach
        @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-3">No batches found</p>
                <p class="small">Batches will appear here once purchase transactions are created with batch numbers.</p>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Any additional JavaScript can go here
});
</script>
@endpush

