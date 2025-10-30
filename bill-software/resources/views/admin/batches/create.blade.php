@extends('layouts.admin')
@section('title', 'Create Batch')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Create New Batch</h2>
                    <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Batches
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Validation Errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.batches.store') }}" method="POST">
                    @csrf

                    <!-- Basic Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Item <span class="text-danger">*</span></label>
                                    <select class="form-select @error('item_id') is-invalid @enderror" 
                                        name="item_id" id="item_id" required>
                                        <option value="">-- Select Item --</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }} ({{ $item->company_short_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('item_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Batch Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('batch_number') is-invalid @enderror" 
                                        name="batch_number" value="{{ old('batch_number') }}" 
                                        placeholder="e.g., BATCH-001" required>
                                    @error('batch_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-calendar me-2"></i>Manufacturing & Expiry Dates</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Manufacturing Date</label>
                                    <input type="date" class="form-control @error('manufacturing_date') is-invalid @enderror" 
                                        name="manufacturing_date" value="{{ old('manufacturing_date') }}">
                                    @error('manufacturing_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                        name="expiry_date" value="{{ old('expiry_date') }}">
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity & Pricing -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-box me-2"></i>Quantity & Pricing</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('quantity') is-invalid @enderror" 
                                        name="quantity" value="{{ old('quantity', 0) }}" placeholder="0.00" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Cost Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" 
                                            name="cost_price" value="{{ old('cost_price', 0) }}" placeholder="0.00" required>
                                    </div>
                                    @error('cost_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" 
                                            name="selling_price" value="{{ old('selling_price', 0) }}" placeholder="0.00" required>
                                    </div>
                                    @error('selling_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Storage Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-building me-2"></i>Storage Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Godown/Warehouse Location</label>
                                    <input type="text" class="form-control @error('godown') is-invalid @enderror" 
                                        name="godown" value="{{ old('godown') }}" placeholder="e.g., Godown A, Shelf 1">
                                    @error('godown')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex gap-2 justify-content-end mb-4">
                        <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Batch
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
