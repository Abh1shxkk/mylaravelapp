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

            <form action="{{ route('admin.items.store') }}" method="POST">
                @csrf
                
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
                                       name="name" value="{{ old('name') }}">
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
                                <label class="form-label">Compcode</label>
                                <input type="text" class="form-control" name="Compcode" value="{{ old('Compcode') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Compname <span class="text-danger">*</span></label>
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

                <!-- Composition & Strengths (DB fields) -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-capsule me-2"></i>Composition & Strengths</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Saltcode</label>
                                <input type="text" class="form-control" name="Saltcode" value="{{ old('Saltcode') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Strength</label>
                                <input type="text" class="form-control" name="Strength" value="{{ old('Strength') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">saltcode1</label>
                                <input type="text" class="form-control" name="saltcode1" value="{{ old('saltcode1') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Strength1</label>
                                <input type="text" class="form-control" name="Strength1" value="{{ old('Strength1') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">saltcode2</label>
                                <input type="text" class="form-control" name="saltcode2" value="{{ old('saltcode2') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Strength2</label>
                                <input type="text" class="form-control" name="Strength2" value="{{ old('Strength2') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">saltcode3</label>
                                <input type="text" class="form-control" name="saltcode3" value="{{ old('saltcode3') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Strength3</label>
                                <input type="text" class="form-control" name="Strength3" value="{{ old('Strength3') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Saltcode4</label>
                                <input type="text" class="form-control" name="Saltcode4" value="{{ old('Saltcode4') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Strength4</label>
                                <input type="text" class="form-control" name="Strength4" value="{{ old('Strength4') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Saltcode5</label>
                                <input type="text" class="form-control" name="Saltcode5" value="{{ old('Saltcode5') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Strength5</label>
                                <input type="text" class="form-control" name="Strength5" value="{{ old('Strength5') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Substitute</label>
                                <input type="text" class="form-control" name="Substitute" value="{{ old('Substitute') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Saltno</label>
                                <input type="number" class="form-control" name="Saltno" value="{{ old('Saltno', '0') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">SubStrenght</label>
                                <input type="text" class="form-control" name="SubStrenght" value="{{ old('SubStrenght') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">ItemRef</label>
                                <input type="text" class="form-control" name="ItemRef" value="{{ old('ItemRef') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing, Taxes & Scheme (DB fields) -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-percent me-2"></i>Pricing, Taxes & Scheme</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Prate</label>
                                <input type="number" step="0.01" class="form-control" name="Prate" value="{{ old('Prate','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Tsr</label>
                                <input type="number" step="0.01" class="form-control" name="Tsr" value="{{ old('Tsr','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Psc</label>
                                <input type="text" class="form-control" name="Psc" value="{{ old('Psc') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">ptax</label>
                                <input type="number" step="0.01" class="form-control" name="ptax" value="{{ old('ptax','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Excise</label>
                                <input type="number" step="0.01" class="form-control" name="Excise" value="{{ old('Excise','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Scm1</label>
                                <input type="text" class="form-control" name="Scm1" value="{{ old('Scm1') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Discount Amount</label>
                                <input type="number" step="0.01" class="form-control" name="discount_amount" value="{{ old('discount_amount','0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Discount Percent (%)</label>
                                <input type="number" step="0.01" class="form-control" name="discount_percent" value="{{ old('discount_percent','0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">scm2</label>
                                <input type="text" class="form-control" name="scm2" value="{{ old('scm2') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Srate</label>
                                <input type="number" step="0.01" class="form-control" name="Srate" value="{{ old('Srate','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Sc</label>
                                <input type="text" class="form-control" name="Sc" value="{{ old('Sc') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Saletype</label>
                                <input type="text" class="form-control" name="Saletype" value="{{ old('Saletype') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Stax</label>
                                <input type="number" step="0.01" class="form-control" name="Stax" value="{{ old('Stax','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Wsrate</label>
                                <input type="number" step="0.01" class="form-control" name="Wsrate" value="{{ old('Wsrate','0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Add_sc</label>
                                <input type="number" step="0.01" class="form-control" name="Add_sc" value="{{ old('Add_sc','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Add_tsr</label>
                                <input type="number" step="0.01" class="form-control" name="Add_tsr" value="{{ old('Add_tsr','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Costrate</label>
                                <input type="number" step="0.01" class="form-control" name="Costrate" value="{{ old('Costrate','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">ScmPer</label>
                                <input type="number" step="0.01" class="form-control" name="ScmPer" value="{{ old('ScmPer','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">currentScm</label>
                                <input type="text" class="form-control" name="currentScm" value="{{ old('currentScm') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Mrp</label>
                                <input type="number" step="0.01" class="form-control" name="Mrp" value="{{ old('Mrp','0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">ScmFrom</label>
                                <input type="date" class="form-control" name="ScmFrom" value="{{ old('ScmFrom') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">ScmTo</label>
                                <input type="date" class="form-control" name="ScmTo" value="{{ old('ScmTo') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">CurrScm1</label>
                                <input type="text" class="form-control" name="CurrScm1" value="{{ old('CurrScm1') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">CurrScm2</label>
                                <input type="text" class="form-control" name="CurrScm2" value="{{ old('CurrScm2') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock & Batch (DB fields) -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Stock & Batch</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">opqty</label>
                                <input type="number" step="0.01" class="form-control" name="opqty" value="{{ old('opqty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Clqty</label>
                                <input type="number" step="0.01" class="form-control" name="Clqty" value="{{ old('Clqty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Vdt</label>
                                <input type="date" class="form-control" name="Vdt" value="{{ old('Vdt') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Batchcode</label>
                                <input type="text" class="form-control" name="Batchcode" value="{{ old('Batchcode') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">cname_bc</label>
                                <input type="text" class="form-control" name="cname_bc" value="{{ old('cname_bc') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Defqty</label>
                                <input type="number" step="0.01" class="form-control" name="Defqty" value="{{ old('Defqty','0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">BarcodeQty</label>
                                <input type="number" class="form-control" name="BarcodeQty" value="{{ old('BarcodeQty','0') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">splrate</label>
                                <input type="number" step="0.01" class="form-control" name="splrate" value="{{ old('splrate','0.00') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Net & Flags (DB fields) -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Sales Net & Flags</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Ssc</label>
                                <input type="text" class="form-control" name="Ssc" value="{{ old('Ssc') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">WsNet</label>
                                <input type="number" step="0.01" class="form-control" name="WsNet" value="{{ old('WsNet','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">SplNet</label>
                                <input type="number" step="0.01" class="form-control" name="SplNet" value="{{ old('SplNet','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Hscm</label>
                                <input type="text" class="form-control" name="Hscm" value="{{ old('Hscm') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Box</label>
                                <input type="text" class="form-control" name="Box" value="{{ old('Box') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">CommonItem</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="CommonItem" id="CommonItem" {{ old('CommonItem') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="CommonItem">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Sscm1</label>
                                <input type="text" class="form-control" name="Sscm1" value="{{ old('Sscm1') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">FDis</label>
                                <input type="number" step="0.01" class="form-control" name="FDis" value="{{ old('FDis','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Sscm2</label>
                                <input type="text" class="form-control" name="Sscm2" value="{{ old('Sscm2') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">FDisP</label>
                                <input type="number" step="0.01" class="form-control" name="FDisP" value="{{ old('FDisP','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">TrimName</label>
                                <input type="text" class="form-control" name="TrimName" value="{{ old('TrimName') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">PresReq</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="PresReq" id="PresReq" {{ old('PresReq') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PresReq">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">QScm</label>
                                <input type="text" class="form-control" name="QScm" value="{{ old('QScm') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">SconMrp</label>
                                <input type="number" step="0.01" class="form-control" name="SconMrp" value="{{ old('SconMrp','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">VAT (%)</label>
                                <input type="number" step="0.01" class="form-control" name="VAT" value="{{ old('VAT','4.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Margin</label>
                                <input type="number" step="0.01" class="form-control" name="Margin" value="{{ old('Margin','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">Inclusive</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="Inclusive" id="Inclusive" {{ old('Inclusive') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Inclusive">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category & Description (DB fields) -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Category & Description</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">ItemCat</label>
                                <input type="text" class="form-control" name="ItemCat" value="{{ old('ItemCat') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Gdn</label>
                                <input type="text" class="form-control" name="Gdn" value="{{ old('Gdn') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">PRateCase</label>
                                <input type="number" step="0.01" class="form-control" name="PRateCase" value="{{ old('PRateCase','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">PRateBox</label>
                                <input type="number" step="0.01" class="form-control" name="PRateBox" value="{{ old('PRateBox','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Desc1</label>
                                <input type="text" class="form-control" name="Desc1" value="{{ old('Desc1') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Desc2</label>
                                <input type="text" class="form-control" name="Desc2" value="{{ old('Desc2') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">MinQty</label>
                                <input type="number" step="0.01" class="form-control" name="MinQty" value="{{ old('MinQty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">MaxQty</label>
                                <input type="number" step="0.01" class="form-control" name="MaxQty" value="{{ old('MaxQty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">ItCase</label>
                                <input type="text" class="form-control" name="ItCase" value="{{ old('ItCase') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">TRate</label>
                                <input type="number" step="0.01" class="form-control" name="TRate" value="{{ old('TRate','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Wr</label>
                                <input type="number" step="0.01" class="form-control" name="Wr" value="{{ old('Wr','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pic</label>
                                <input type="text" class="form-control" name="Pic" value="{{ old('Pic') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mfg</label>
                                <input type="text" class="form-control" name="Mfg" value="{{ old('Mfg') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Generic</label>
                                <input type="text" class="form-control" name="Generic" value="{{ old('Generic','N') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Expiry</label>
                                <input type="date" class="form-control" name="Expiry" value="{{ old('Expiry') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Temporary & Tax Flags (DB fields) -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-sliders me-2"></i>Temporary & Tax Flags</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">TempOpqty</label>
                                <input type="number" step="0.01" class="form-control" name="TempOpqty" value="{{ old('TempOpqty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">TempClqty</label>
                                <input type="number" step="0.01" class="form-control" name="TempClqty" value="{{ old('TempClqty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">TempAmt</label>
                                <input type="number" step="0.01" class="form-control" name="TempAmt" value="{{ old('TempAmt','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">TempAmt1</label>
                                <input type="number" step="0.01" class="form-control" name="TempAmt1" value="{{ old('TempAmt1','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">TempAmt2</label>
                                <input type="number" step="0.01" class="form-control" name="TempAmt2" value="{{ old('TempAmt2','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">TaxonMrp</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="TaxonMrp" id="TaxonMrp" {{ old('TaxonMrp') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="TaxonMrp">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">IWeight</label>
                                <input type="number" step="0.01" class="form-control" name="IWeight" value="{{ old('IWeight','0.00') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Misc Attributes (DB fields) -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Misc Attributes</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">MaxQtyWr</label>
                                <input type="number" step="0.01" class="form-control" name="MaxQtyWr" value="{{ old('MaxQtyWr','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">OpFreeQty</label>
                                <input type="number" step="0.01" class="form-control" name="OpFreeQty" value="{{ old('OpFreeQty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">VATonSrate</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="VATonSrate" id="VATonSrate" {{ old('VATonSrate') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="VATonSrate">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">Exon</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="Exon" id="Exon" {{ old('Exon') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Exon">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">ExPer</label>
                                <input type="number" step="0.01" class="form-control" name="ExPer" value="{{ old('ExPer','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">UnitType</label>
                                <input type="text" class="form-control" name="UnitType" value="{{ old('UnitType') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">MfgQty</label>
                                <input type="number" step="0.01" class="form-control" name="MfgQty" value="{{ old('MfgQty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">mTag</label>
                                <input type="text" class="form-control" name="mTag" value="{{ old('mTag') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">DisContinue</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="DisContinue" id="DisContinue" {{ old('DisContinue') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="DisContinue">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Vol</label>
                                <input type="number" step="0.01" class="form-control" name="Vol" value="{{ old('Vol','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">VDisP</label>
                                <input type="number" step="0.01" class="form-control" name="VDisP" value="{{ old('VDisP','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">VDisS</label>
                                <input type="number" step="0.01" class="form-control" name="VDisS" value="{{ old('VDisS','0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">FDisWR</label>
                                <input type="number" step="0.01" class="form-control" name="FDisWR" value="{{ old('FDisWR','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">LastYearCost</label>
                                <input type="number" step="0.01" class="form-control" name="LastYearCost" value="{{ old('LastYearCost','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">OpAddQty</label>
                                <input type="number" step="0.01" class="form-control" name="OpAddQty" value="{{ old('OpAddQty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">SaleLessQty</label>
                                <input type="number" step="0.01" class="form-control" name="SaleLessQty" value="{{ old('SaleLessQty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">SplDisQty</label>
                                <input type="number" step="0.01" class="form-control" name="SplDisQty" value="{{ old('SplDisQty','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">SplDisPer</label>
                                <input type="number" step="0.01" class="form-control" name="SplDisPer" value="{{ old('SplDisPer','0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">FullName</label>
                                <input type="text" class="form-control" name="FullName" value="{{ old('FullName') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">LockScm</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="LockScm" id="LockScm" {{ old('LockScm') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="LockScm">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">RateLock</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="RateLock" id="RateLock" {{ old('RateLock') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="RateLock">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">MinRate</label>
                                <input type="number" step="0.01" class="form-control" name="MinRate" value="{{ old('MinRate','0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">CostWFQ</label>
                                <input type="number" step="0.01" class="form-control" name="CostWFQ" value="{{ old('CostWFQ','0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PurExciseAsRate</label>
                                <input type="number" step="0.01" class="form-control" name="PurExciseAsRate" value="{{ old('PurExciseAsRate','0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PurNetRate</label>
                                <input type="number" step="0.01" class="form-control" name="PurNetRate" value="{{ old('PurNetRate','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">LockBilling</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="LockBilling" id="LockBilling" {{ old('LockBilling') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="LockBilling">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">SameBatchCost</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="SameBatchCost" id="SameBatchCost" {{ old('SameBatchCost') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="SameBatchCost">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">EsCode</label>
                                <input type="text" class="form-control" name="EsCode" value="{{ old('EsCode') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">FdisPWS</label>
                                <input type="number" step="0.01" class="form-control" name="FdisPWS" value="{{ old('FdisPWS','0.00') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">ItemType</label>
                                <input type="text" class="form-control" name="ItemType" value="{{ old('ItemType') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">ItemGroup</label>
                                <input type="text" class="form-control" name="ItemGroup" value="{{ old('ItemGroup') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">GST Cess (%)</label>
                                <input type="number" step="0.01" class="form-control" name="GSTCess" value="{{ old('GSTCess','0.00') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">IucCode</label>
                                <input type="text" class="form-control" name="IucCode" value="{{ old('IucCode') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">miscsettings</label>
                                <textarea class="form-control" name="miscsettings" rows="2">{{ old('miscsettings') }}</textarea>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">SyncMark</label>
                                <input type="text" class="form-control" name="SyncMark" value="{{ old('SyncMark') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Item Information -->
               

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
                        <i class="bi bi-save me-2"></i>Save Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection