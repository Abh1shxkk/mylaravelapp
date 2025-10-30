@extends('layouts.admin')
@section('title', 'All Batches')
@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-0">
                                    <strong>All Batches - Complete Overview</strong>
                                </h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('admin.batches.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>New Batch
                                </a>
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
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" name="search" 
                                    value="{{ $search }}" placeholder="Search batch/item...">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select form-select-sm" name="status">
                                    <option value="">All Status</option>
                                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="expiring_soon" {{ $status == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-search me-1"></i>Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.batches.all') }}" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Batches Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Batch Details - All Items</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">Sr.</th>
                                    <th>Item</th>
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
                                            <strong>{{ $batch->item->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $batch->item->company_short_name }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $batch->batch_number }}</strong>
                                        </td>
                                        <td>
                                            @if($batch->expiry_date)
                                                @if($batch->isExpired())
                                                    <span class="badge bg-danger" title="Expired">
                                                        {{ $batch->expiry_date->format('d/m/Y') }}
                                                    </span>
                                                @elseif($batch->isExpiringsoon())
                                                    <span class="badge bg-warning" title="Expiring Soon">
                                                        {{ $batch->expiry_date->format('d/m/Y') }}
                                                    </span>
                                                @else
                                                    {{ $batch->expiry_date->format('d/m/Y') }}
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($batch->quantity, 2) }}</td>
                                        <td>{{ number_format($batch->item->s_rate ?? 0, 2) }}</td>
                                        <td>{{ number_format(($batch->item->s_rate ?? 0) * (1 + ($batch->item->cgst_percent ?? 0) / 100), 2) }}</td>
                                        <td>{{ number_format($batch->cost_price, 2) }}</td>
                                        <td>{{ number_format($batch->item->mrp ?? 0, 2) }}</td>
                                        <td>{{ number_format($batch->item->ws_rate ?? 0, 2) }}</td>
                                        <td>{{ number_format($batch->item->spl_rate ?? 0, 2) }}</td>
                                        <td>{{ $batch->item->scheme_plus ?? 0 }}+{{ $batch->item->scheme_minus ?? 0 }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.batches.edit', $batch) }}" 
                                                    class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('admin.batches.show', $batch) }}" 
                                                    class="btn btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-4">
                                            No batches found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $batches->links() }}
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Total Batches</h6>
                        <h3 class="text-primary">{{ $totalBatches }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Active Batches</h6>
                        <h3 class="text-success">{{ $activeBatches }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Expiring Soon</h6>
                        <h3 class="text-warning">{{ $expiringSoon }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Expired</h6>
                        <h3 class="text-danger">{{ $expiredBatches }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.batch-row').forEach(row => {
            row.addEventListener('click', function() {
                document.querySelectorAll('.batch-row').forEach(r => r.style.backgroundColor = '');
                this.style.backgroundColor = '#e3f2fd';
            });
        });
    </script>
@endsection
