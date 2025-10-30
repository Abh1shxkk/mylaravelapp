@extends('layouts.admin')
@section('title', 'Batch Details')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Batch Details: {{ $batch->batch_number }}</h2>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>

                <!-- Batch Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Batch Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Batch Number:</strong></div>
                                    <div class="col-sm-7">{{ $batch->batch_number }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Item:</strong></div>
                                    <div class="col-sm-7">{{ $batch->item->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Status:</strong></div>
                                    <div class="col-sm-7">
                                        @if($batch->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($batch->status == 'expired')
                                            <span class="badge bg-danger">Expired</span>
                                        @else
                                            <span class="badge bg-secondary">Discontinued</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Godown:</strong></div>
                                    <div class="col-sm-7">{{ $batch->godown ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Dates</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Mfg. Date:</strong></div>
                                    <div class="col-sm-7">
                                        @if($batch->manufacturing_date)
                                            {{ $batch->manufacturing_date->format('d-m-Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Expiry Date:</strong></div>
                                    <div class="col-sm-7">
                                        @if($batch->expiry_date)
                                            @if($batch->isExpired())
                                                <span class="badge bg-danger">{{ $batch->expiry_date->format('d-m-Y') }}</span>
                                            @elseif($batch->isExpiringsoon())
                                                <span class="badge bg-warning">{{ $batch->expiry_date->format('d-m-Y') }}</span>
                                            @else
                                                {{ $batch->expiry_date->format('d-m-Y') }}
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Days to Expiry:</strong></div>
                                    <div class="col-sm-7">
                                        @if($batch->daysUntilExpiry() !== null)
                                            @if($batch->isExpired())
                                                <span class="badge bg-danger">Expired</span>
                                            @elseif($batch->isExpiringsoon())
                                                <span class="badge bg-warning">{{ $batch->daysUntilExpiry() }} days</span>
                                            @else
                                                {{ $batch->daysUntilExpiry() }} days
                                            @endif
                                        @else
                                            <span class="text-muted">No expiry</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quantity & Pricing -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Quantity & Pricing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted">Quantity</h6>
                                            <h3 class="text-primary">{{ number_format($batch->quantity, 2) }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted">Cost Price</h6>
                                            <h3 class="text-success">₹{{ number_format($batch->cost_price, 2) }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted">Selling Price</h6>
                                            <h3 class="text-info">₹{{ number_format($batch->selling_price, 2) }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted">Total Value</h6>
                                            <h3 class="text-warning">₹{{ number_format($batch->quantity * $batch->selling_price, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Ledger -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Stock Ledger Entries</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction Type</th>
                                    <th>Quantity</th>
                                    <th>Opening Qty</th>
                                    <th>Closing Qty</th>
                                    <th>Reference</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($batch->stockLedgers as $ledger)
                                    <tr>
                                        <td>{{ $ledger->transaction_date->format('d-m-Y') }}</td>
                                        <td>
                                            @if($ledger->transaction_type == 'IN')
                                                <span class="badge bg-success">IN</span>
                                            @elseif($ledger->transaction_type == 'OUT')
                                                <span class="badge bg-danger">OUT</span>
                                            @else
                                                <span class="badge bg-warning">{{ $ledger->transaction_type }}</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($ledger->quantity, 2) }}</td>
                                        <td>{{ number_format($ledger->opening_qty, 2) }}</td>
                                        <td>{{ number_format($ledger->closing_qty, 2) }}</td>
                                        <td>
                                            {{ $ledger->reference_type ?? '-' }}
                                            @if($ledger->reference_id)
                                                (#{{ $ledger->reference_id }})
                                            @endif
                                        </td>
                                        <td>{{ $ledger->remarks ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No stock ledger entries
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
