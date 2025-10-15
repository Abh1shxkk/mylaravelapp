@extends('layouts.admin')
@section('title', 'Edit Item')
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

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

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

                <form action="{{ route('admin.items.update', $item) }}" method="POST">
                    @csrf
                    @method('PUT')



                    <!-- Header Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Header Section</h5>
                        </div>
                        <div class="card-body">
                            <!-- Row 1: Name and Company -->
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $item->name) }}" placeholder="Item name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company <span class="text-danger">*</span></label>
                                    <select class="form-select @error('company_id') is-invalid @enderror"
                                        name="company_id" id="company_id">
                                        <option value="">-- Select Company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"
                                                data-short-name="{{ $company->short_name }}" {{ old('company_id', $item->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }} ({{ $company->short_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Company Short Name</label>
                                    <input type="text" class="form-control" name="company_short_name"
                                        id="company_short_name" value="{{ old('company_short_name', $item->company_short_name) }}" readonly style="background-color: #f0f0f0;">
                                </div>
                            </div>

                            <!-- Row 2: Packing, Unit (Fixed), Unit Type, Mfg. By, Location, Status, Schedule -->
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Packing</label>
                                    <input type="text" class="form-control" name="packing" value="{{ old('packing', $item->packing) }}"
                                        placeholder="Packing">
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label class="form-label">Unit</label>
                                    <input type="number" class="form-control" name="unit" value="{{ old('unit', $item->unit ?? 1) }}"
                                        readonly style="background-color: #f0f0f0;">
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label class="form-label">Unit</label>
                                    <select class="form-select" name="unit_type">
                                        <option value="Unit" {{ old('unit_type', $item->unit_type ?? 'Unit') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                        <option value="Kg." {{ old('unit_type', $item->unit_type) == 'Kg.' ? 'selected' : '' }}>Kg.</option>
                                        <option value="L." {{ old('unit_type', $item->unit_type) == 'L.' ? 'selected' : '' }}>L.</option>
                                        <option value="Gm." {{ old('unit_type', $item->unit_type) == 'Gm.' ? 'selected' : '' }}>Gm.</option>
                                        <option value="Ml." {{ old('unit_type', $item->unit_type) == 'Ml.' ? 'selected' : '' }}>Ml.</option>
                                        <option value="Doz." {{ old('unit_type', $item->unit_type) == 'Doz.' ? 'selected' : '' }}>Doz.</option>
                                        <option value="Mtr." {{ old('unit_type', $item->unit_type) == 'Mtr.' ? 'selected' : '' }}>Mtr.</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Mfg. By</label>
                                    <input type="text" class="form-control" name="mfg_by" value="{{ old('mfg_by', $item->mfg_by) }}"
                                        placeholder="Manufacturer">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control" name="location" value="{{ old('location', $item->location) }}"
                                        placeholder="Location">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control" name="status" value="{{ old('status', $item->status) }}"
                                        placeholder="Status">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Schedule</label>
                                    <input type="text" class="form-control" name="schedule"
                                        value="{{ old('schedule', $item->schedule ?? '00') }}" placeholder="00">
                                </div>
                            </div>

                            <!-- Row 3: Box Qty, Case Qty, Min. Level, Max. Level, Bar Code, Division -->
                            <div class="row">
                                <div class="col-md-1 mb-3">
                                    <label class="form-label">Box Qty</label>
                                    <input type="number" class="form-control" name="box_qty" value="{{ old('box_qty', $item->box_qty ?? 0) }}"
                                        placeholder="0">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Case Qty</label>
                                    <input type="number" class="form-control" name="case_qty"
                                        value="{{ old('case_qty', $item->case_qty ?? 0) }}" placeholder="0">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Min. Level</label>
                                    <input type="number" step="0.01" class="form-control" name="min_level"
                                        value="{{ old('min_level', $item->min_level ?? 0) }}" placeholder="0">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Max. Level</label>
                                    <input type="number" step="0.01" class="form-control" name="max_level"
                                        value="{{ old('max_level', $item->max_level ?? 0) }}" placeholder="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Bar Code</label>
                                    <input type="text" class="form-control" name="bar_code" value="{{ old('bar_code', $item->bar_code) }}"
                                        placeholder="Bar code">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Division</label>
                                    <input type="text" class="form-control" name="division"
                                        value="{{ old('division', $item->division ?? '00') }}" placeholder="00">
                                </div>
                            </div>

                            <!-- Row 4: Flag, Narcotic Checkbox -->
                            <div class="row">
                                <div class="col-md-10 mb-3">
                                    <label class="form-label">Flag</label>
                                    <input type="text" class="form-control" name="flag" value="{{ old('flag', $item->flag) }}"
                                        placeholder="Flag">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label d-block">Narcotic</label>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="narcotic_flag"
                                            id="narcotic_flag" value="Y" {{ old('narcotic_flag', $item->narcotic_flag) == 'Y' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="narcotic_flag">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sale Details Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Sale Details</h5>
                        </div>
                        <div class="card-body">
                            <!-- Row 1: S. Rate -->
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">S. Rate</label>
                                    <input type="number" step="0.01" class="form-control" name="s_rate"
                                        value="{{ old('s_rate', $item->s_rate ?? '0.00') }}" placeholder="0.00">
                                </div>
                            </div>

                            <!-- Row 2: MRP with Net label -->
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">MRP</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" name="mrp"
                                            value="{{ old('mrp', $item->mrp ?? '0.00') }}" placeholder="0.00">
                                        <span class="input-group-text" style="background-color: #e3f2fd; color: #1976d2; font-weight: bold;">Net</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 3: W.S.Rate with Y Toggle -->
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">W.S.Rate</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" name="ws_rate"
                                            value="{{ old('ws_rate', $item->ws_rate ?? '0.00') }}" placeholder="0.00" style="max-width: 120px;">
                                        <select class="form-select" name="ws_net_toggle" style="max-width: 60px;">
                                            <option value="Y" {{ old('ws_net_toggle', $item->ws_net_toggle ?? 'Y') == 'Y' ? 'selected' : '' }}>Y</option>
                                            <option value="N" {{ old('ws_net_toggle', $item->ws_net_toggle) == 'N' ? 'selected' : '' }}>N</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 4: Spl.Rate with Y Toggle -->
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Spl.Rate</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" name="spl_rate"
                                            value="{{ old('spl_rate', $item->spl_rate ?? '0.00') }}" placeholder="0.00" style="max-width: 120px;">
                                        <select class="form-select" name="spl_net_toggle" style="max-width: 60px;">
                                            <option value="Y" {{ old('spl_net_toggle', $item->spl_net_toggle ?? 'Y') == 'Y' ? 'selected' : '' }}>Y</option>
                                            <option value="N" {{ old('spl_net_toggle', $item->spl_net_toggle) == 'N' ? 'selected' : '' }}>N</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 5: Scheme (0 + 0) -->
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Scheme</label>
                                    <div class="input-group">
                                        <input type="number" step="1" class="form-control" name="scheme_plus"
                                            value="{{ old('scheme_plus', $item->scheme_plus ?? 0) }}" placeholder="0" style="max-width: 80px;">
                                        <span class="input-group-text">+</span>
                                        <input type="number" step="1" class="form-control" name="scheme_minus"
                                            value="{{ old('scheme_minus', $item->scheme_minus ?? 0) }}" placeholder="0" style="max-width: 80px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Row 6: Min.GP -->
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Min.GP</label>
                                    <input type="number" step="0.01" class="form-control" name="min_gp"
                                        value="{{ old('min_gp', $item->min_gp ?? '0.00') }}" placeholder="0.00">
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
                                <!-- Pur. Rate -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Pur. Rate</label>
                                    <input type="number" step="0.01" class="form-control" name="pur_rate"
                                        value="{{ old('pur_rate', $item->pur_rate ?? '0.00') }}" placeholder="0.00">
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Cost -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cost</label>
                                    <input type="number" step="0.01" class="form-control" name="cost"
                                        value="{{ old('cost', $item->cost ?? '0.00') }}" placeholder="0.00">
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Scheme (+ and -) -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Scheme</label>
                                    <div class="input-group">
                                        <input type="number" step="1" class="form-control" name="pur_scheme_plus"
                                            value="{{ old('pur_scheme_plus', $item->pur_scheme_plus ?? 0) }}" placeholder="0" style="max-width: 80px;">
                                        <span class="input-group-text">+</span>
                                        <input type="number" step="1" class="form-control" name="pur_scheme_minus"
                                            value="{{ old('pur_scheme_minus', $item->pur_scheme_minus ?? 0) }}" placeholder="0" style="max-width: 80px;">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- NR -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">NR</label>
                                    <input type="number" step="0.01" class="form-control" name="nr"
                                        value="{{ old('nr', $item->nr ?? '0.00') }}" placeholder="0.00">
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
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="hsn_code_input" name="hsn_code" 
                                               value="{{ old('hsn_code', $item->hsn_code) }}" placeholder="Click to select HSN" readonly 
                                               style="cursor: pointer; background-color: #fff;">
                                        <button type="button" class="btn btn-outline-secondary" id="hsn_code_btn">
                                            <i class="bi bi-search"></i>
                                        </button>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">CGST (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="cgst_percent" name="cgst_percent"
                                        value="{{ old('cgst_percent', $item->cgst_percent ?? 0) }}" placeholder="0.00" readonly style="background-color: #f0f0f0;">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">SGST (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="sgst_percent" name="sgst_percent"
                                        value="{{ old('sgst_percent', $item->sgst_percent ?? 0) }}" placeholder="0.00" readonly style="background-color: #f0f0f0;">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">IGST (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="igst_percent" name="igst_percent"
                                        value="{{ old('igst_percent', $item->igst_percent ?? 0) }}" placeholder="0.00" readonly style="background-color: #f0f0f0;">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cess (%)</label>
                                    <input type="number" step="0.01" class="form-control" name="cess_percent"
                                        value="{{ old('cess_percent', $item->cess_percent ?? 0) }}" placeholder="0.00">
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
                                <!-- LEFT PARTITION -->
                                <div class="col-md-6">
                                    <!-- VAT -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">VAT(%)</label>
                                            <input type="number" step="0.01" class="form-control" name="vat_percent"
                                                value="{{ old('vat_percent', $item->vat_percent ?? 0) }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Fixed Dis. (Y/N/M)</label>
                                            <select class="form-select" name="fixed_dis">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('fixed_dis', $item->fixed_dis) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('fixed_dis', $item->fixed_dis) == 'N' ? 'selected' : '' }}>N</option>
                                                <option value="M" {{ old('fixed_dis', $item->fixed_dis) == 'M' ? 'selected' : '' }}>M</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Expiry, Inclusive -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Expiry</label>
                                            <select class="form-select" name="expiry_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('expiry_flag', $item->expiry_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('expiry_flag', $item->expiry_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Inclusive :</label>
                                            <select class="form-select" name="inclusive_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('inclusive_flag', $item->inclusive_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('inclusive_flag', $item->inclusive_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Generic, Bar Code -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Generic</label>
                                            <select class="form-select" name="generic_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('generic_flag', $item->generic_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('generic_flag', $item->generic_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Bar Code :</label>
                                            <select class="form-select" name="bar_code_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('bar_code_flag', $item->bar_code_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('bar_code_flag', $item->bar_code_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- H.Scm, Max Inv. Qty (Numeric) -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">H.Scm</label>
                                            <select class="form-select" name="h_scm_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('h_scm_flag', $item->h_scm_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('h_scm_flag', $item->h_scm_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Max Inv.Qty :</label>
                                            <input type="number" step="0.01" class="form-control" name="max_inv_qty_value"
                                                value="{{ old('max_inv_qty_value', $item->max_inv_qty_value ?? 0) }}" placeholder="21332">
                                        </div>
                                    </div>

                                    <!-- Q.Scm, Weight -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Q.Scm</label>
                                            <select class="form-select" name="q_scm_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('q_scm_flag', $item->q_scm_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('q_scm_flag', $item->q_scm_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Weight :</label>
                                            <input type="number" step="0.01" class="form-control" name="weight_new"
                                                value="{{ old('weight_new', $item->weight_new ?? 0) }}" placeholder="0.000">
                                        </div>
                                    </div>

                                    <!-- Locks, Bar Code (empty for spacing) -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Locks</label>
                                            <input type="text" class="form-control" name="locks_flag" value="S" readonly style="background-color: #f0f0f0;">
                                        </div>
                                    </div>
                                </div>

                                <!-- RIGHT PARTITION -->
                                <div class="col-md-6">
                                    <!-- Fixed Dis %, Fixed Dis Type -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">%</label>
                                            <input type="number" step="0.01" class="form-control" name="fixed_dis_percent"
                                                value="{{ old('fixed_dis_percent', $item->fixed_dis_percent ?? 0) }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Fixed Dis Type</label>
                                            <select class="form-select" name="fixed_dis_type">
                                                <option value="">-- Select --</option>
                                                <option value="W" {{ old('fixed_dis_type', $item->fixed_dis_type) == 'W' ? 'selected' : '' }}>W</option>
                                                <option value="R" {{ old('fixed_dis_type', $item->fixed_dis_type) == 'R' ? 'selected' : '' }}>R</option>
                                                <option value="I" {{ old('fixed_dis_type', $item->fixed_dis_type) == 'I' ? 'selected' : '' }}>I</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Def. Qty, Volume -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Def. Qty :</label>
                                            <select class="form-select" name="def_qty_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('def_qty_flag', $item->def_qty_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('def_qty_flag', $item->def_qty_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Volume :</label>
                                            <input type="number" step="0.01" class="form-control" name="volume_new"
                                                value="{{ old('volume_new', $item->volume_new ?? 0) }}" placeholder="0">
                                        </div>
                                    </div>

                                    <!-- Comp. Name (BC) -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="form-label">Comp.Name (BC) :</label>
                                            <select class="form-select" name="comp_name_bc_new">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('comp_name_bc_new', $item->comp_name_bc_new) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('comp_name_bc_new', $item->comp_name_bc_new) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- DPC Item, Lock Sale -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">DPC Item</label>
                                            <select class="form-select" name="dpc_item_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('dpc_item_flag', $item->dpc_item_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('dpc_item_flag', $item->dpc_item_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Lock Sale :</label>
                                            <select class="form-select" name="lock_sale_flag">
                                                <option value="">-- Select --</option>
                                                <option value="Y" {{ old('lock_sale_flag', $item->lock_sale_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                                <option value="N" {{ old('lock_sale_flag', $item->lock_sale_flag) == 'N' ? 'selected' : '' }}>N</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 1(Max) 2(Min), MRP for Sale -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">1.(Max) 2.(Min)</label>
                                            <select class="form-select" name="max_min_flag">
                                                <option value="">-- Select --</option>
                                                <option value="1" {{ old('max_min_flag', $item->max_min_flag) == '1' ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ old('max_min_flag', $item->max_min_flag) == '2' ? 'selected' : '' }}>2</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">MRP for Sale</label>
                                            <input type="number" step="0.01" class="form-control" name="mrp_for_sale_new"
                                                value="{{ old('mrp_for_sale_new', $item->mrp_for_sale_new ?? 0) }}" placeholder="0.00">
                                        </div>
                                    </div>

                                    <!-- Max Inv. Qty Type (W/R/I) -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="form-label">Max Inv. Qty Type</label>
                                            <select class="form-select" name="max_inv_qty_new">
                                                <option value="">-- Select --</option>
                                                <option value="W" {{ old('max_inv_qty_new', $item->max_inv_qty_new) == 'W' ? 'selected' : '' }}>W</option>
                                                <option value="R" {{ old('max_inv_qty_new', $item->max_inv_qty_new) == 'R' ? 'selected' : '' }}>R</option>
                                                <option value="I" {{ old('max_inv_qty_new', $item->max_inv_qty_new) == 'I' ? 'selected' : '' }}>I</option>
                                            </select>
                                        </div>
                                    </div>
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
                            <!-- Row 1: Commodity (left), Current Scheme (right) -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Commodity :</label>
                                    <input type="text" class="form-control" name="commodity" value="{{ old('commodity', $item->commodity) }}" placeholder="">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Current Scheme :</label>
                                    <select class="form-select" name="current_scheme_flag" id="current_scheme_flag">
                                        <option value="">-- Select --</option>
                                        <option value="Y" {{ old('current_scheme_flag', $item->current_scheme_flag) == 'Y' ? 'selected' : '' }}>Y</option>
                                        <option value="N" {{ old('current_scheme_flag', $item->current_scheme_flag) == 'N' ? 'selected' : '' }}>N</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 1.5: Scheme (0 + 0) -->
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Scheme</label>
                                    <div class="input-group">
                                        <input type="number" step="1" class="form-control" name="scheme_plus_value"
                                            value="{{ old('scheme_plus_value', $item->scheme_plus_value ?? 0) }}" placeholder="0" style="max-width: 80px;">
                                        <span class="input-group-text">+</span>
                                        <input type="number" step="1" class="form-control" name="scheme_minus_value"
                                            value="{{ old('scheme_minus_value', $item->scheme_minus_value ?? 0) }}" placeholder="0" style="max-width: 80px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Row 1.6: From/To dates -->
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">From</label>
                                    <input type="date" class="form-control" name="from_date" value="{{ old('from_date', $item->from_date) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">To</label>
                                    <input type="date" class="form-control" name="to_date" value="{{ old('to_date', $item->to_date) }}">
                                </div>
                            </div>

                            <!-- Row 2: Category (left with 2 fields), Empty (right) -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Category :</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="category" value="{{ old('category', $item->category) }}" placeholder="">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="category_2" value="{{ old('category_2', $item->category_2) }}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <!-- Row 3: UPC (left), Empty (right) -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">UPC</label>
                                    <input type="text" class="form-control" name="upc" value="{{ old('upc', $item->upc) }}" placeholder="">
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Item
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


    <!-- Simple Test Modal -->
    <div class="modal fade" id="testModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Test Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>This is a test modal to check if modals work at all.</p>
                    <button type="button" class="btn btn-success" onclick="alert('Button works!')">
                        Click Me to Test
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- HSN Code Selection Modal -->
    <div class="modal fade" id="hsnCodeModal" tabindex="-1" aria-labelledby="hsnCodeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 800px; width: 90%;">            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="hsnCodeModalLabel">
                        <i class="bi bi-upc-scan me-2"></i>Select HSN Code
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    
                    <!-- Search Box -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="hsn_modal_search" placeholder="Search HSN code or name...">
                    </div>
                    
                    <!-- Loading Spinner -->
                    <div id="hsn_modal_loading" class="text-center py-4">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading HSN codes...</p>
                    </div>
                    
                    
                    
                    <!-- HSN Codes Table -->
                    <div id="hsn_modal_table_container" style="display: none;">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover table-sm">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>Name</th>
                                        <th>HSN Code</th>
                                        <th>CGST %</th>
                                        <th>SGST %</th>
                                        <th>IGST %</th>
                                        <th>Total GST %</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hsn_modal_tbody">
                                    <!-- Rows will be populated via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <div id="hsn_modal_no_results" class="text-center py-4 text-muted" style="display: none;">
                            <i class="bi bi-search fs-1"></i>
                            <p class="mt-2">No HSN codes found</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Script loaded');
            
            // HSN Code Modal Functionality
            let hsnCodesData = [];
            const hsnModal = document.getElementById('hsnCodeModal');
            const hsnModalSearch = document.getElementById('hsn_modal_search');
            const hsnModalTbody = document.getElementById('hsn_modal_tbody');
            const hsnModalLoading = document.getElementById('hsn_modal_loading');
            const hsnModalTableContainer = document.getElementById('hsn_modal_table_container');
            const hsnModalNoResults = document.getElementById('hsn_modal_no_results');
            const hsnCodeInput = document.getElementById('hsn_code_input');
            
            // Load HSN codes when modal is opened
            hsnModal.addEventListener('show.bs.modal', function(e) {
                console.log('Modal opening...');
                if (hsnCodesData.length === 0) {
                    loadHsnCodes();
                }
                // AGGRESSIVE DEBUGGING AND FIXING
                setTimeout(() => {
                    console.log('=== DEBUGGING MODAL CLICK ISSUES ===');
                    
                    // Remove ALL potentially blocking elements
                    const elementsToRemove = [
                        '#scrollToTop',
                        '.sidebar-backdrop',
                        '[id*="backdrop"]',
                        '[class*="backdrop"]',
                        '[style*="position: fixed"]',
                        '[style*="position: absolute"]'
                    ];
                    
                    elementsToRemove.forEach(selector => {
                        const elements = document.querySelectorAll(selector);
                        elements.forEach(el => {
                            if (!el.closest('.modal') && el.id !== 'hsnCodeModal' && el.id !== 'testModal') {
                                el.remove();
                                console.log('REMOVED element:', selector, el);
                            }
                        });
                    });
                    
                    // Force modal to front
                    hsnModal.style.zIndex = '2147483647'; // Maximum z-index
                    hsnModal.style.position = 'fixed';
                    hsnModal.style.pointerEvents = 'auto';
                    
                    // Add click detection to modal
                    hsnModal.addEventListener('click', function(e) {
                        console.log('Modal clicked at:', e.clientX, e.clientY);
                        console.log('Target element:', e.target);
                        console.log('Current target:', e.currentTarget);
                    });
                    
                    console.log('Aggressive fix applied - modal z-index:', hsnModal.style.zIndex);
                }, 100);
            });
            
            // Modal closed - no need to restore scroll button since we removed it
            hsnModal.addEventListener('hidden.bs.modal', function(e) {
                console.log('Modal closed');
            });
            
            // Make HSN input clickable to open modal
            hsnCodeInput.addEventListener('click', function(e) {
                console.log('HSN input clicked');
                e.preventDefault();
                const modal = new bootstrap.Modal(hsnModal);
                modal.show();
            });
            
            // Also make the search button work
            const hsnSearchBtn = document.getElementById('hsn_code_btn');
            if (hsnSearchBtn) {
                hsnSearchBtn.addEventListener('click', function(e) {
                    console.log('HSN search button clicked');
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Try multiple ways to open modal
                    try {
                        const modal = new bootstrap.Modal(hsnModal, {
                            backdrop: true,
                            keyboard: true,
                            focus: true
                        });
                        modal.show();
                        console.log('Modal show() called successfully');
                    } catch (error) {
                        console.error('Error opening modal:', error);
                        alert('Error opening modal: ' + error.message);
                    }
                });
            }
            
            // Simple test modal function
            window.testSimpleModal = function() {
                console.log('Opening simple test modal...');
                const testModal = document.getElementById('testModal');
                const modal = new bootstrap.Modal(testModal);
                modal.show();
            };
            
            // Debug function to test HSN modal
            window.testHsnModal = function() {
                console.log('Testing HSN modal...');
                const modal = new bootstrap.Modal(hsnModal);
                modal.show();
                
                // Force load data if not loaded
                if (hsnCodesData.length === 0) {
                    console.log('Loading HSN codes for test...');
                    loadHsnCodes();
                }
            };
            
            // Debugging function to detect what's blocking clicks
            window.detectBlockingElement = function(event) {
                console.log('=== CLICK DETECTION DEBUG ===');
                console.log('Event:', event);
                console.log('Mouse position:', event.clientX, event.clientY);
                
                // Get element at mouse position
                const elementAtPoint = document.elementFromPoint(event.clientX, event.clientY);
                console.log('Element at click point:', elementAtPoint);
                
                // Check all elements with high z-index
                const allElements = document.querySelectorAll('*');
                const highZIndexElements = [];
                
                allElements.forEach(el => {
                    const zIndex = window.getComputedStyle(el).zIndex;
                    if (zIndex && parseInt(zIndex) > 1000) {
                        highZIndexElements.push({
                            element: el,
                            zIndex: zIndex,
                            id: el.id,
                            class: el.className
                        });
                    }
                });
                
                console.log('High z-index elements:', highZIndexElements);
                
                // Check modal's computed styles
                const modalStyles = window.getComputedStyle(hsnModal);
                console.log('Modal z-index:', modalStyles.zIndex);
                console.log('Modal position:', modalStyles.position);
                console.log('Modal pointer-events:', modalStyles.pointerEvents);
                
                alert('Check console for detailed debug info!');
            };
            
            // Load HSN codes from server
            function loadHsnCodes() {
                hsnModalLoading.style.display = 'block';
                hsnModalTableContainer.style.display = 'none';
                
                fetch('{{ route('admin.hsn-codes.index') }}?all=1', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    hsnCodesData = data;
                    renderHsnCodes(hsnCodesData);
                    hsnModalLoading.style.display = 'none';
                    hsnModalTableContainer.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error loading HSN codes:', error);
                    hsnModalLoading.innerHTML = '<p class="text-danger">Error loading HSN codes. Please try again.</p>';
                });
            }
            
            // Render HSN codes in table
            function renderHsnCodes(codes) {
                hsnModalTbody.innerHTML = '';
                
                if (codes.length === 0) {
                    hsnModalTableContainer.querySelector('.table-responsive').style.display = 'none';
                    hsnModalNoResults.style.display = 'block';
                    return;
                }
                
                hsnModalTableContainer.querySelector('.table-responsive').style.display = 'block';
                hsnModalNoResults.style.display = 'none';
                
                codes.forEach((code, index) => {
                    const row = document.createElement('tr');
                    row.style.cursor = 'pointer';
                    row.style.pointerEvents = 'auto';
                    row.style.position = 'relative';
                    row.style.zIndex = 'auto';
                    row.setAttribute('data-hsn-code', code.hsn_code);
                    row.setAttribute('data-index', index);
                    
                    row.innerHTML = `
                        <td><strong>${code.name || '-'}</strong></td>
                        <td>${code.hsn_code || '-'}</td>
                        <td>${parseFloat(code.cgst_percent || 0).toFixed(2)}%</td>
                        <td>${parseFloat(code.sgst_percent || 0).toFixed(2)}%</td>
                        <td>${parseFloat(code.igst_percent || 0).toFixed(2)}%</td>
                        <td><strong>${parseFloat(code.total_gst_percent || 0).toFixed(2)}%</strong></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary select-hsn-btn" 
                                    style="pointer-events: auto; position: relative; z-index: auto;"
                                    data-hsn-code="${code.hsn_code}" data-index="${index}">
                                <i class="bi bi-check-circle"></i> Select
                            </button>
                        </td>
                    `;
                    
                    // Add click event to select button with more debugging
                    const selectBtn = row.querySelector('.select-hsn-btn');
                    selectBtn.addEventListener('click', function(e) {
                        console.log('=== BUTTON CLICK DEBUG ===');
                        console.log('Event:', e);
                        console.log('Target:', e.target);
                        console.log('Button element:', this);
                        console.log('HSN Code:', code.hsn_code);
                        console.log('Code object:', code);
                        
                        e.preventDefault();
                        e.stopPropagation();
                        selectHsnCode(code);
                    });
                    
                    // Add mouseenter/mouseleave for debugging
                    selectBtn.addEventListener('mouseenter', function() {
                        console.log('Button hover - HSN:', code.hsn_code);
                        this.style.backgroundColor = '#0b5ed7';
                    });
                    
                    selectBtn.addEventListener('mouseleave', function() {
                        this.style.backgroundColor = '';
                    });
                    
                    // Also make row clickable with debugging
                    row.addEventListener('click', function(e) {
                        console.log('=== ROW CLICK DEBUG ===');
                        console.log('Event:', e);
                        console.log('Target:', e.target);
                        console.log('Row element:', this);
                        
                        if (!e.target.closest('.select-hsn-btn')) {
                            e.preventDefault();
                            e.stopPropagation();
                            console.log('Row clicked for:', code.hsn_code);
                            selectHsnCode(code);
                        }
                    });
                    
                    hsnModalTbody.appendChild(row);
                });
            }
            
            // Select HSN code and populate fields
            function selectHsnCode(code) {
                console.log('Selecting HSN code:', code);
                
                // Populate form fields
                document.getElementById('hsn_code_input').value = code.hsn_code || '';
                document.getElementById('cgst_percent').value = parseFloat(code.cgst_percent || 0).toFixed(2);
                document.getElementById('sgst_percent').value = parseFloat(code.sgst_percent || 0).toFixed(2);
                document.getElementById('igst_percent').value = parseFloat(code.igst_percent || 0).toFixed(2);
                
                // Close modal
                const modalInstance = bootstrap.Modal.getInstance(hsnModal);
                if (modalInstance) {
                    modalInstance.hide();
                } else {
                    // Fallback method
                    hsnModal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                }
                
                // Show success feedback
                const hsnInput = document.getElementById('hsn_code_input');
                hsnInput.classList.add('border-success');
                setTimeout(() => {
                    hsnInput.classList.remove('border-success');
                }, 1500);
                
                console.log('HSN code selected successfully');
            }
            
            // Search functionality
            hsnModalSearch.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                if (searchTerm === '') {
                    renderHsnCodes(hsnCodesData);
                    return;
                }
                
                const filtered = hsnCodesData.filter(code => {
                    return (code.name && code.name.toLowerCase().includes(searchTerm)) ||
                           (code.hsn_code && code.hsn_code.toLowerCase().includes(searchTerm));
                });
                
                renderHsnCodes(filtered);
            });
            
            // Wait for Select2 to initialize
            setTimeout(function() {
                const companySelect = $('#company_id'); // Use jQuery for Select2
                const shortNameInput = document.getElementById('company_short_name');

                console.log('Company Select:', companySelect);
                console.log('Short Name Input:', shortNameInput);

                if (companySelect.length > 0) {
                    // Use Select2's change event
                    companySelect.on('change', function () {
                        console.log('Company changed');
                        const selectedOption = $(this).find('option:selected');
                        const shortName = selectedOption.data('short-name');
                        console.log('Selected Option:', selectedOption);
                        console.log('Short Name from data attribute:', shortName);
                        
                        if (shortNameInput) {
                            shortNameInput.value = shortName || '';
                            console.log('Short name set to:', shortNameInput.value);
                        } else {
                            console.error('Short name input not found!');
                        }
                    });

                    // Trigger on page load if pre-selected
                    if (companySelect.val()) {
                        console.log('Triggering change on page load');
                        companySelect.trigger('change');
                    }
                } else {
                    console.error('Company select not found!');
                }
            }, 500); // Wait 500ms for Select2 to initialize
        });
    </script>
@endsection