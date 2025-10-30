@extends('layouts.admin')
@section('title', 'Item Batches - ' . $item->name)
@section('content')
    <div class="container-fluid">
        <!-- Item Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-0">
                                    <strong>Item:</strong> 
                                    <span class="text-primary">{{ $item->name }}</span>
                                </h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <h5 class="mb-0">
                                    <strong>Packing:</strong> 
                                    <span class="text-success">{{ $item->packing ?? '1*1 UNIT' }}</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Batches Table -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Batch Details</h5>
                        <a href="{{ route('admin.batches.create', ['item_id' => $item->id]) }}" class="btn btn-light btn-sm">
                            <i class="bi bi-plus-circle me-1"></i>New Batch
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">Sr.</th>
                                    <th>Batch</th>
                                    <th>Exp.</th>
                                    <th>Qty.</th>
                                    <th>Rate</th>
                                    <th>F.T.Rate</th>
                                    <th>P.Rate</th>
                                    <th>MRP</th>
                                    <th>WS.Rate</th>
                                    <th>Spl.Rate</th>
                                    <th>Scm.</th>
                                    <th style="width: 8%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($batches as $index => $batch)
                                    <tr class="batch-row" data-batch-id="{{ $batch->id }}" style="cursor: pointer;">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $batch->batch_number }}</strong>
                                        </td>
                                        <td>
                                            @if($batch->expiry_date)
                                                @if($batch->isExpired())
                                                    <span class="badge bg-danger">{{ $batch->expiry_date->format('d/m/Y') }}</span>
                                                @elseif($batch->isExpiringsoon())
                                                    <span class="badge bg-warning">{{ $batch->expiry_date->format('d/m/Y') }}</span>
                                                @else
                                                    {{ $batch->expiry_date->format('d/m/Y') }}
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($batch->quantity, 2) }}</td>
                                        <td>{{ number_format($item->s_rate ?? 0, 2) }}</td>
                                        <td>{{ number_format(($item->s_rate ?? 0) * (1 + ($item->cgst_percent ?? 0) / 100), 2) }}</td>
                                        <td>{{ number_format($batch->cost_price, 2) }}</td>
                                        <td>{{ number_format($item->mrp ?? 0, 2) }}</td>
                                        <td>{{ number_format($item->ws_rate ?? 0, 2) }}</td>
                                        <td>{{ number_format($item->spl_rate ?? 0, 2) }}</td>
                                        <td>{{ $item->scheme_plus ?? 0 }}+{{ $item->scheme_minus ?? 0 }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-info edit-batch" 
                                                    data-batch-id="{{ $batch->id }}" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger delete-batch" 
                                                    data-batch-id="{{ $batch->id }}" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted py-4">
                                            No batches found for this item
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Batch Details Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Batch Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Sale Rate:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->s_rate ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>P.Rate:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->pur_rate ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>MRP:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->mrp ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>W.S.Rate:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->ws_rate ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Spl.Rate:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->spl_rate ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Cost:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->cost ?? '' }}" readonly style="color: red;">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Location:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->location ?? '' }}" readonly style="color: red;">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Batch:</strong></label>
                                        <input type="text" class="form-control form-control-sm" id="batch_number" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Qty.:</strong></label>
                                        <input type="text" class="form-control form-control-sm" id="batch_qty" readonly>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>T.Qty.:</strong></label>
                                        <input type="text" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>BC:</strong></label>
                                        <input type="text" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>DATE:</strong></label>
                                        <input type="date" class="form-control form-control-sm" id="batch_date" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Exp:</strong></label>
                                        <input type="date" class="form-control form-control-sm" id="batch_expiry" readonly>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Mfg:</strong></label>
                                        <input type="date" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GST & Additional Info -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong style="color: red;">GST Rate:</strong></label>
                                        <input type="text" class="form-control form-control-sm" 
                                            value="{{ $item->cgst_percent ?? '' }}" readonly style="color: red;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong style="color: red;">GST PTS:</strong></label>
                                        <input type="text" class="form-control form-control-sm" readonly style="color: red;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Cost WFQ:</strong></label>
                                        <input type="text" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>H (old) / B (rk.) / E (xpiry):</strong></label>
                                        <input type="text" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Buttons -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-between">
                    <div>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-clock-history me-1"></i>History (F5)
                        </button>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-calculator me-1"></i>Costing
                        </button>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-primary">Modify (Enter)</button>
                        <button class="btn btn-sm btn-outline-info">Print Labels</button>
                        <button class="btn btn-sm btn-outline-success">Save</button>
                        <button class="btn btn-sm btn-outline-warning">FiFo Adjst. Report</button>
                        <button class="btn btn-sm btn-outline-secondary">Update GST Rate</button>
                        <button class="btn btn-sm btn-outline-secondary">GST Margin Rep.</button>
                        <a href="{{ route('admin.items.index') }}" class="btn btn-sm btn-outline-danger">Exit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.batch-row').forEach(row => {
            row.addEventListener('click', function() {
                const batchId = this.dataset.batchId;
                const cells = this.querySelectorAll('td');
                
                document.getElementById('batch_number').value = cells[1].textContent.trim();
                document.getElementById('batch_qty').value = cells[3].textContent.trim();
                document.getElementById('batch_date').value = '{{ now()->format("Y-m-d") }}';
                
                // Highlight selected row
                document.querySelectorAll('.batch-row').forEach(r => r.style.backgroundColor = '');
                this.style.backgroundColor = '#e3f2fd';
            });
        });

        document.querySelectorAll('.edit-batch').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const batchId = this.dataset.batchId;
                window.location.href = `/admin/batches/${batchId}/edit`;
            });
        });

        document.querySelectorAll('.delete-batch').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                if(confirm('Are you sure?')) {
                    const batchId = this.dataset.batchId;
                    // Delete via AJAX or form
                }
            });
        });
    </script>
@endsection
