@extends('layouts.admin')
@section('title', 'Stock Ledger - ' . $item->name)
@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>
                            Stock Ledger (F10) - {{ $item->name }}
                        </h4>
                        <small class="text-muted">Item: {{ $item->name }} | Company: {{ $item->company_short_name }}</small>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.items.show', $item) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Back to Item
                        </a>
                        <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-list me-1"></i>Items List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Summary Panel -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Stock Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <h6 class="text-muted">Total Units</h6>
                                    <h3 class="text-primary">{{ number_format($item->getTotalQuantity(), 2) }}</h3>
                                    <small class="text-muted">From all batches</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <h6 class="text-muted">Pack Units</h6>
                                    <h3 class="text-success">{{ number_format($totalInMovements, 2) }}</h3>
                                    <small class="text-muted">Total IN movements</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <h6 class="text-muted">Loose Units</h6>
                                    <h3 class="text-danger">{{ number_format($totalOutMovements, 2) }}</h3>
                                    <small class="text-muted">Total OUT movements</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <h6 class="text-muted">Net Movement</h6>
                                    <h3 class="text-info">{{ number_format($totalInMovements - $totalOutMovements, 2) }}</h3>
                                    <small class="text-muted">IN - OUT</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" class="row g-2">
                            <div class="col-md-2">
                                <label class="form-label">From Date</label>
                                <input type="date" class="form-control form-control-sm" name="from_date" 
                                    value="{{ $fromDate }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">To Date</label>
                                <input type="date" class="form-control form-control-sm" name="to_date" 
                                    value="{{ $toDate }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Transaction Type</label>
                                <select class="form-select form-select-sm" name="transaction_type">
                                    <option value="">All</option>
                                    <option value="IN" {{ $transactionType == 'IN' ? 'selected' : '' }}>IN</option>
                                    <option value="OUT" {{ $transactionType == 'OUT' ? 'selected' : '' }}>OUT</option>
                                    <option value="ADJUSTMENT" {{ $transactionType == 'ADJUSTMENT' ? 'selected' : '' }}>ADJUSTMENT</option>
                                    <option value="RETURN" {{ $transactionType == 'RETURN' ? 'selected' : '' }}>RETURN</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Reference Type</label>
                                <select class="form-select form-select-sm" name="reference_type">
                                    <option value="">All</option>
                                    <option value="PURCHASE" {{ $referenceType == 'PURCHASE' ? 'selected' : '' }}>PURCHASE</option>
                                    <option value="SALE" {{ $referenceType == 'SALE' ? 'selected' : '' }}>SALE</option>
                                    <option value="ADJUSTMENT" {{ $referenceType == 'ADJUSTMENT' ? 'selected' : '' }}>ADJUSTMENT</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-1 align-items-end">
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.items.stock-ledger', $item) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Ledger Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Stock Movement History</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">Sr.</th>
                                    <th>Date</th>
                                    <th>Batch</th>
                                    <th>Transaction Type</th>
                                    <th>Quantity</th>
                                    <th>Opening Qty</th>
                                    <th>Closing Qty</th>
                                    <th>Reference Type</th>
                                    <th>Reference ID</th>
                                    <th>Godown</th>
                                    <th>Remarks</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ledgers as $index => $ledger)
                                    <tr>
                                        <td>{{ ($ledgers->currentPage() - 1) * $ledgers->perPage() + $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $ledger->transaction_date->format('d-m-Y') }}</strong>
                                        </td>
                                        <td>
                                            @if($ledger->batch)
                                                <span class="badge bg-info">{{ $ledger->batch->batch_number }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($ledger->transaction_type == 'IN')
                                                <span class="badge bg-success">IN</span>
                                            @elseif($ledger->transaction_type == 'OUT')
                                                <span class="badge bg-danger">OUT</span>
                                            @elseif($ledger->transaction_type == 'ADJUSTMENT')
                                                <span class="badge bg-warning">ADJUSTMENT</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $ledger->transaction_type }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($ledger->transaction_type == 'OUT' || $ledger->transaction_type == 'ADJUSTMENT')
                                                <span class="text-danger">-{{ number_format($ledger->quantity, 2) }}</span>
                                            @else
                                                <span class="text-success">+{{ number_format($ledger->quantity, 2) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($ledger->opening_qty, 2) }}</td>
                                        <td>
                                            <strong>{{ number_format($ledger->closing_qty, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($ledger->reference_type)
                                                <span class="badge bg-light text-dark">{{ $ledger->reference_type }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($ledger->reference_id)
                                                #{{ $ledger->reference_id }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $ledger->godown ?? '-' }}</td>
                                        <td>{{ $ledger->remarks ?? '-' }}</td>
                                        <td>
                                            @if($ledger->createdBy)
                                                <small>{{ $ledger->createdBy->name ?? 'System' }}</small>
                                            @else
                                                <small class="text-muted">System</small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted py-4">
                                            No stock movements found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $ledgers->links() }}
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Total IN</h6>
                        <h3 class="text-success">{{ number_format($totalInMovements, 2) }}</h3>
                        <small class="text-muted">Units received</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Total OUT</h6>
                        <h3 class="text-danger">{{ number_format($totalOutMovements, 2) }}</h3>
                        <small class="text-muted">Units sold/adjusted</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Net Stock</h6>
                        <h3 class="text-primary">{{ number_format($totalInMovements - $totalOutMovements, 2) }}</h3>
                        <small class="text-muted">Current balance</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Transactions</h6>
                        <h3 class="text-info">{{ $ledgers->total() }}</h3>
                        <small class="text-muted">Total movements</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .summary-item {
            padding: 15px;
            border-radius: 8px;
            background: #f8f9fa;
        }
    </style>
@endsection
