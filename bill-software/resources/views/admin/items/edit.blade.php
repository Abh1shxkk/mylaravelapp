@extends('layouts.admin')
@section('title','Edit Item')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Item</h2>
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Items
                </a>
            </div>

            <form action="{{ route('admin.items.update', $item) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- General Item Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>General Item Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $item->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Barcode</label>
                                <input type="text" class="form-control" name="Barcode" value="{{ old('Barcode') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Company Code</label>
                                <input type="text" class="form-control" name="Compcode" value="{{ old('Compcode') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('Compname') is-invalid @enderror" name="Compname" value="{{ old('Compname') }}">
                                @error('Compname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pack</label>
                                <input type="text" class="form-control" name="Pack" value="{{ old('Pack', '1') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" name="Unit" value="{{ old('Unit', 'PCS') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="Location" value="{{ old('Location') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mfg. By</label>
                                <input type="text" class="form-control" name="MfgBy" value="{{ old('MfgBy') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Division</label>
                                <input type="text" class="form-control" name="Division" value="{{ old('Division', '00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Box Qty.</label>
                                <input type="number" class="form-control" name="BoxQty" value="{{ old('BoxQty', '0') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Case Qty.</label>
                                <input type="number" class="form-control" name="CaseQty" value="{{ old('CaseQty', '0') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Schedule</label>
                                <input type="text" class="form-control" name="Schedule" value="{{ old('Schedule', '00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Min. Level</label>
                                <input type="number" class="form-control" name="MinLevel" value="{{ old('MinLevel', '0') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Max. Level</label>
                                <input type="number" class="form-control" name="MaxLevel" value="{{ old('MaxLevel', '0') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Flag</label>
                                <input type="text" class="form-control" name="Flag" value="{{ old('Flag', 'Narcotic') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="status" {{ old('status', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Details -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-currency-rupee me-2"></i>Sales Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">S. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="Srate" value="{{ old('Srate', '0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">MRP</label>
                                <input type="number" step="0.01" class="form-control" name="Mrp" value="{{ old('Mrp', '0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Net</label>
                                <input type="number" step="0.01" class="form-control" name="Net" value="{{ old('Net', '0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">W.S. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="Wsrate" value="{{ old('Wsrate', '0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Spl. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="SplRate" value="{{ old('SplRate', '0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Min. GP</label>
                                <input type="number" step="0.01" class="form-control" name="MinGP" value="{{ old('MinGP', '0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Commodity</label>
                                <input type="text" class="form-control" name="Commodity" value="{{ old('Commodity') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Scheme</label>
                                <input type="number" class="form-control" name="Scheme" value="{{ old('Scheme', '0') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Details -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-cart me-2"></i>Purchase Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Pur. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="Prate" value="{{ old('Prate', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cost</label>
                                <input type="number" step="0.01" class="form-control" name="Cost" value="{{ old('Cost', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Scheme</label>
                                <input type="number" class="form-control" name="PurScheme" value="{{ old('PurScheme', '0') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">NR</label>
                                <input type="number" step="0.01" class="form-control" name="NR" value="{{ old('NR', '0.00') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GST Details -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-percent me-2"></i>GST Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">HSN Code</label>
                                <input type="text" class="form-control" name="HSNCode" value="{{ old('HSNCode') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">CGST (%)</label>
                                <input type="number" step="0.01" class="form-control" name="CGST" value="{{ old('CGST', '0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">SGST (%)</label>
                                <input type="number" step="0.01" class="form-control" name="SGST" value="{{ old('SGST', '0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">IGST (%)</label>
                                <input type="number" step="0.01" class="form-control" name="IGST" value="{{ old('IGST', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cess (%)</label>
                                <input type="number" step="0.01" class="form-control" name="Cess" value="{{ old('Cess', '0.00') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Details -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-tags me-2"></i>Other Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">VAT (%)</label>
                                <input type="number" step="0.01" class="form-control" name="VAT" value="{{ old('VAT', '4.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Expiry</label>
                                <input type="date" class="form-control" name="Expiry" value="{{ old('Expiry') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Generic</label>
                                <input type="text" class="form-control" name="Generic" value="{{ old('Generic', 'N') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sale Tax</label>
                                <input type="number" step="0.01" class="form-control" name="Stax" value="{{ old('Stax', '0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Fixed Dis. (Y/N/M)</label>
                                <input type="number" step="0.01" class="form-control" name="FixedDis" value="{{ old('FixedDis', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="Category" value="{{ old('Category', '00') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory & Physical Properties -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-box me-2"></i>Inventory & Physical Properties</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">Inclusive</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="Inclusive" id="Inclusive" {{ old('Inclusive') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Inclusive">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Max Inv. Qty</label>
                                <input type="number" class="form-control" name="MaxInvQty" value="{{ old('MaxInvQty', '0') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Weight</label>
                                <input type="number" step="0.001" class="form-control" name="Weight" value="{{ old('Weight', '0.000') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Volume</label>
                                <input type="number" step="0.001" class="form-control" name="Volume" value="{{ old('Volume', '0.000') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Lock</label>
                                <input type="text" class="form-control" name="Lock" value="{{ old('Lock') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Flags & Controls -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>System Flags & Controls</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Bar Code</label>
                                <input type="text" class="form-control" name="BarCodeFlag" value="{{ old('BarCodeFlag', 'N') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Det. Qty.</label>
                                <input type="text" class="form-control" name="DetQty" value="{{ old('DetQty', 'N') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Comp. Name (BC)</label>
                                <input type="text" class="form-control" name="CompNameBC" value="{{ old('CompNameBC', 'Y') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">DPC Item</label>
                                <input type="text" class="form-control" name="DPCItem" value="{{ old('DPCItem', 'N') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Lock Sale</label>
                                <input type="text" class="form-control" name="LockSale" value="{{ old('LockSale', 'N') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Classification & Categorization -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Classification & Categorization</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Commodity</label>
                                <input type="text" class="form-control" name="CommodityClass" value="{{ old('CommodityClass') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Current Scheme</label>
                                <input type="text" class="form-control" name="CurrentScheme" value="{{ old('CurrentScheme') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="CategoryClass" value="{{ old('CategoryClass', '00') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection