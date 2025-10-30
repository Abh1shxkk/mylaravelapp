@extends('layouts.admin')
@section('title', 'Edit Batch')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Edit Batch: {{ $batch->batch_number }}</h2>
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

                <form action="{{ route('admin.batches.update', $batch) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                        name="item_id" required>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}" {{ $batch->item_id == $item->id ? 'selected' : '' }}>
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
                                        name="batch_number" value="{{ $batch->batch_number }}" required>
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
                                        name="manufacturing_date" value="{{ $batch->manufacturing_date?->format('Y-m-d') }}">
                                    @error('manufacturing_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                        name="expiry_date" value="{{ $batch->expiry_date?->format('Y-m-d') }}">
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
                                        name="quantity" value="{{ $batch->quantity }}" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Cost Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" 
                                            name="cost_price" value="{{ $batch->cost_price }}" required>
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
                                            name="selling_price" value="{{ $batch->selling_price }}" required>
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Godown/Warehouse Location</label>
                                    <input type="text" class="form-control @error('godown') is-invalid @enderror" 
                                        name="godown" value="{{ $batch->godown }}">
                                    @error('godown')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                        <option value="active" {{ $batch->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="expired" {{ $batch->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="discontinued" {{ $batch->status == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                                    </select>
                                    @error('status')
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
                            <i class="bi bi-check-circle me-2"></i>Update Batch
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
