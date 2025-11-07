@extends('layouts.admin')

@section('title', 'Batch Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-box-seam me-2"></i> Batch Management</h4>
        <div class="text-muted small">View and manage batches from purchase transactions</div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded">
    <div class="card mb-4">
        <div class="card-body">
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
    </div>

    <div class="table-responsive">
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
                    <div class="mb-3 p-2 bg-light rounded">
                        <strong>{{ $firstBatch->item_name ?? $item->name ?? 'N/A' }}</strong>
                        <span class="text-muted ms-2">(Packing: {{ $item->packing ?? '1*10' }})</span>
                    </div>
                    
                    @if($validBatches->isNotEmpty())
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr.</th>
                                    <th>Batch</th>
                                    <th>Exp.</th>
                                    <th>Qty.</th>
                                    <th>S.Rate</th>
                                    <th>F.T.Rate</th>
                                    <th>P.Rate</th>
                                    <th>MRP</th>
                                    <th>WS.Rate</th>
                                    <th>Spl.Rate</th>
                                    <th>Scm.</th>
                                    <th class="text-end">Actions</th>
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
                                        $avgWsRate = $batchItems->avg('ws_rate') ?? 0; // Average WS.Rate from purchase_transaction_items
                                        $avgSplRate = $batchItems->avg('spl_rate') ?? 0; // Average SPL.Rate from purchase_transaction_items
                                        
                                        // Calculate GST% (CGST + SGST) from batch items
                                        $avgCgst = $batchItems->avg('cgst_percent') ?? 0;
                                        $avgSgst = $batchItems->avg('sgst_percent') ?? 0;
                                        $totalGstPercent = $avgCgst + $avgSgst;
                                        
                                        // Calculate F.T.Rate: S.Rate × (1 + GST/100)
                                        // Formula: FT = s Rate × (1 + GST/100)
                                        $ftRate = $avgSRate > 0 ? ($avgSRate * (1 + ($totalGstPercent / 100))) : 0;
                                        
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
                                        <td>{{ number_format($avgSRate, 2) }}</td>
                                        <td>{{ number_format($ftRate, 2) }}</td>
                                        <td>{{ number_format($avgRate, 2) }}</td>
                                        <td>{{ number_format($avgMrp, 2) }}</td>
                                        <td>{{ number_format($avgWsRate, 2) }}</td>
                                        <td>{{ number_format($avgSplRate, 2) }}</td>
                                        <td></td>
                                        <td class="text-end">
                                            @if($firstItemId)
                                                <a href="{{ route('admin.batches.edit', $firstItemId) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Edit Batch">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Any additional JavaScript can go here
});
</script>
@endpush

