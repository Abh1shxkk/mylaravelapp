@extends('layouts.admin')
@section('title','Add Item')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Add New Item</h2>
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Items
                </a>
            </div>

            <form action="{{ route('admin.items.store') }}" method="POST" novalidate>
                @csrf
                
               

                <!-- Header Section -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Header Section</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Item name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <select class="form-select @error('company_id') is-invalid @enderror" name="company_id" id="company_id">
                                    <option value="">-- Select Company --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" data-short-name="{{ $company->short_name }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }} ({{ $company->short_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Short Name</label>
                                <input type="text" class="form-control" name="company_short_name" id="company_short_name" value="{{ old('company_short_name') }}" readonly>
                            </div>
                        </div>
                    </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Packing</label>
                                <input type="text" class="form-control" name="Pack" value="{{ old('Pack') }}" placeholder="Packing">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Unit 1</label>
                                <input type="text" class="form-control" name="unit_1" value="{{ old('unit_1') }}" placeholder="Unit 1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Unit 2</label>
                                <input type="text" class="form-control" name="unit_2" value="{{ old('unit_2') }}" placeholder="Unit 2">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mfg. By</label>
                                <input type="text" class="form-control" name="MfgBy" value="{{ old('MfgBy') }}" placeholder="Manufacturer">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="Location" value="{{ old('Location') }}" placeholder="Location">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Schedule</label>
                                <input type="text" class="form-control" name="Schedule" value="{{ old('Schedule', '00') }}" placeholder="Schedule">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Box Qty</label>
                                <input type="number" class="form-control" name="BoxQty" value="{{ old('BoxQty', 0) }}" placeholder="0">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Case Qty</label>
                                <input type="number" class="form-control" name="CaseQty" value="{{ old('CaseQty', 0) }}" placeholder="0">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Min. Level</label>
                                <input type="number" step="0.01" class="form-control" name="min_level" value="{{ old('min_level', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Max. Level</label>
                                <input type="number" step="0.01" class="form-control" name="max_level" value="{{ old('max_level', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Bar Code</label>
                                <input type="text" class="form-control" name="Barcode" value="{{ old('Barcode') }}" placeholder="Bar code">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Division</label>
                                <input type="text" class="form-control" name="Division" value="{{ old('Division', '00') }}" placeholder="Division">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Flag</label>
                                <input type="text" class="form-control" name="Flag" value="{{ old('Flag') }}" placeholder="Flag">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Narcotic</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="narcotic_flag" id="narcotic_flag" value="Y" {{ old('narcotic_flag') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="narcotic_flag">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sale Details Section -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Sale Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">S. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="s_rate" value="{{ old('s_rate', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">MRP</label>
                                <input type="number" step="0.01" class="form-control" name="Mrp" value="{{ old('Mrp', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Net (Toggle)</label>
                                <input type="number" step="0.01" class="form-control" name="net_toggle" value="{{ old('net_toggle', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">W.S. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="ws_rate" value="{{ old('ws_rate', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">N (Toggle)</label>
                                <select class="form-select" name="ws_net_toggle">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('ws_net_toggle') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('ws_net_toggle') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Spl. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="spl_rate" value="{{ old('spl_rate', 0) }}" placeholder="0.00">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">N (Toggle)</label>
                                <select class="form-select" name="spl_net_toggle">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('spl_net_toggle') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('spl_net_toggle') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Scheme (+ / -)</label>
                                <input type="number" step="0.01" class="form-control" name="sale_scheme" value="{{ old('sale_scheme', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Min. GP</label>
                                <input type="number" step="0.01" class="form-control" name="min_gp" value="{{ old('min_gp', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">&nbsp;</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Details Section -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-cart me-2"></i>Purchase Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Pur. Rate</label>
                                <input type="number" step="0.01" class="form-control" name="pur_rate" value="{{ old('pur_rate', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cost</label>
                                <input type="number" step="0.01" class="form-control" name="cost" value="{{ old('cost', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Scheme (+ / -)</label>
                                <input type="number" step="0.01" class="form-control" name="pur_scheme" value="{{ old('pur_scheme', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">NR</label>
                                <input type="number" step="0.01" class="form-control" name="nr" value="{{ old('nr', 0) }}" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GST Details Section -->
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-percent me-2"></i>GST Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">HSN Code</label>
                                <input type="text" class="form-control" name="hsn_code" value="{{ old('hsn_code') }}" placeholder="HSN Code">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">CGST (%)</label>
                                <input type="number" step="0.01" class="form-control" name="cgst_percent" value="{{ old('cgst_percent', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">SGST (%)</label>
                                <input type="number" step="0.01" class="form-control" name="sgst_percent" value="{{ old('sgst_percent', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">IGST (%)</label>
                                <input type="number" step="0.01" class="form-control" name="igst_percent" value="{{ old('igst_percent', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cess (%)</label>
                                <input type="number" step="0.01" class="form-control" name="cess_percent" value="{{ old('cess_percent', 0) }}" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Details Section -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-sliders me-2"></i>Other Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">VAT (%)</label>
                                <input type="number" step="0.01" class="form-control" name="vat_percent" value="{{ old('vat_percent', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Fixed Dis</label>
                                <select class="form-select" name="fixed_dis">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('fixed_dis') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('fixed_dis') == 'N' ? 'selected' : '' }}>N</option>
                                    <option value="M" {{ old('fixed_dis') == 'M' ? 'selected' : '' }}>M</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">%</label>
                                <input type="number" step="0.01" class="form-control" name="fixed_dis_percent" value="{{ old('fixed_dis_percent', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Expiry</label>
                                <select class="form-select" name="expiry_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('expiry_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('expiry_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Inclusive</label>
                                <select class="form-select" name="inclusive_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('inclusive_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('inclusive_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Generic</label>
                                <select class="form-select" name="generic_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('generic_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('generic_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">H. Scm</label>
                                <select class="form-select" name="h_scm_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('h_scm_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('h_scm_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Q. Scm</label>
                                <select class="form-select" name="q_scm_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('q_scm_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('q_scm_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Locks</label>
                                <select class="form-select" name="locks_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('locks_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('locks_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Max Inv. Qty</label>
                                <input type="number" step="0.01" class="form-control" name="max_inv_qty_new" value="{{ old('max_inv_qty_new', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Weight</label>
                                <input type="number" step="0.01" class="form-control" name="weight_new" value="{{ old('weight_new', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Bar Code</label>
                                <select class="form-select" name="bar_code_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('bar_code_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('bar_code_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Def. Qty</label>
                                <select class="form-select" name="def_qty_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('def_qty_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('def_qty_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Volume</label>
                                <input type="number" step="0.01" class="form-control" name="volume_new" value="{{ old('volume_new', 0) }}" placeholder="0.00">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Comp. Name (BC)</label>
                                <input type="text" class="form-control" name="comp_name_bc_new" value="{{ old('comp_name_bc_new') }}" placeholder="Company name">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">DPC Item</label>
                                <select class="form-select" name="dpc_item_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('dpc_item_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('dpc_item_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Lock Sale</label>
                                <select class="form-select" name="lock_sale_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('lock_sale_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('lock_sale_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label class="form-label">1/2</label>
                                <select class="form-select" name="max_min_flag">
                                    <option value="">-- Select --</option>
                                    <option value="1" {{ old('max_min_flag') == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ old('max_min_flag') == '2' ? 'selected' : '' }}>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">MRP for Sale</label>
                                <input type="number" step="0.01" class="form-control" name="mrp_for_sale_new" value="{{ old('mrp_for_sale_new', 0) }}" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-box me-2"></i>Bottom Section</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Commodity</label>
                                <input type="text" class="form-control" name="commodity" value="{{ old('commodity') }}" placeholder="Commodity">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Current Scheme</label>
                                <select class="form-select" name="current_scheme_flag">
                                    <option value="">-- Select --</option>
                                    <option value="Y" {{ old('current_scheme_flag') == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ old('current_scheme_flag') == 'N' ? 'selected' : '' }}>N</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" value="{{ old('category') }}" placeholder="Category">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">UPC</label>
                                <input type="text" class="form-control" name="upc" value="{{ old('upc') }}" placeholder="UPC">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Item
                        </button>
                        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const companySelect = document.getElementById('company_id');
    const shortNameInput = document.getElementById('company_short_name');
    
    if (companySelect) {
        companySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const shortName = selectedOption.getAttribute('data-short-name');
            if (shortNameInput) {
                shortNameInput.value = shortName || '';
            }
        });
        
        // Trigger on page load if pre-selected
        if (companySelect.value) {
            companySelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endsection
