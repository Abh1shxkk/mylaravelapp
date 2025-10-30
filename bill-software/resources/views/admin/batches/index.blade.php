@extends('layouts.admin')
@section('title', 'Batches')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Batch Management</h2>
                    <a href="{{ route('admin.batches.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>New Batch
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search & Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" name="search" 
                                    value="{{ $search }}" placeholder="Batch number...">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Search In</label>
                                <select class="form-select" name="search_field">
                                    <option value="all" {{ $searchField == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="batch_number" {{ $searchField == 'batch_number' ? 'selected' : '' }}>Batch Number</option>
                                    <option value="status" {{ $searchField == 'status' ? 'selected' : '' }}>Status</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Item</label>
                                <select class="form-select" name="item_id">
                                    <option value="">All Items</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" {{ $itemId == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">All</option>
                                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="discontinued" {{ $status == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex gap-2 align-items-end">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-search me-2"></i>Search
                                </button>
                                <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Batches Table -->
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Batch Number</th>
                                    <th>Item Name</th>
                                    <th>Mfg. Date</th>
                                    <th>Expiry Date</th>
                                    <th>Quantity</th>
                                    <th>Cost Price</th>
                                    <th>Selling Price</th>
                                    <th>Godown</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($batches as $batch)
                                    <tr>
                                        <td>
                                            <strong>{{ $batch->batch_number }}</strong>
                                        </td>
                                        <td>{{ $batch->item->name }}</td>
                                        <td>
                                            @if($batch->manufacturing_date)
                                                {{ $batch->manufacturing_date->format('d-m-Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($batch->expiry_date)
                                                @if($batch->isExpired())
                                                    <span class="badge bg-danger">
                                                        {{ $batch->expiry_date->format('d-m-Y') }}
                                                    </span>
                                                @elseif($batch->isExpiringsoon())
                                                    <span class="badge bg-warning">
                                                        {{ $batch->expiry_date->format('d-m-Y') }}
                                                    </span>
                                                @else
                                                    {{ $batch->expiry_date->format('d-m-Y') }}
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($batch->quantity, 2) }}</td>
                                        <td>₹{{ number_format($batch->cost_price, 2) }}</td>
                                        <td>₹{{ number_format($batch->selling_price, 2) }}</td>
                                        <td>{{ $batch->godown ?? '-' }}</td>
                                        <td>
                                            @if($batch->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($batch->status == 'expired')
                                                <span class="badge bg-danger">Expired</span>
                                            @else
                                                <span class="badge bg-secondary">Discontinued</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.batches.show', $batch) }}" 
                                                    class="btn btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.batches.edit', $batch) }}" 
                                                    class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.batches.destroy', $batch) }}" 
                                                    style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            No batches found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $batches->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
