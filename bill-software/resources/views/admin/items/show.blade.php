@extends('layouts.admin')
@section('title','Item Details')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Item Details</h2>
                <div>
                    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-primary me-2">
                        <i class="bi bi-pencil me-2"></i>Edit Item
                    </a>
                    <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Items
                    </a>
                </div>
            </div>

            <!-- General Item Information -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>General Item Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <p class="form-control-plaintext">{{ $item->name }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Code</label>
                            <p class="form-control-plaintext">{{ $item->code ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Barcode</label>
                            <p class="form-control-plaintext">{{ $item->Barcode ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Compcode</label>
                            <p class="form-control-plaintext">{{ $item->Compcode ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Compname</label>
                            <p class="form-control-plaintext">{{ $item->Compname }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Pack</label>
                            <p class="form-control-plaintext">{{ $item->Pack ?? '1' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Unit</label>
                            <p class="form-control-plaintext">{{ $item->Unit ?? 'PCS' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Location</label>
                            <p class="form-control-plaintext">{{ $item->Location ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Mfg. By</label>
                            <p class="form-control-plaintext">{{ $item->MfgBy ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Division</label>
                            <p class="form-control-plaintext">{{ $item->Division ?? '00' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Box Qty.</label>
                            <p class="form-control-plaintext">{{ $item->BoxQty ?? '0' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Case Qty.</label>
                            <p class="form-control-plaintext">{{ $item->CaseQty ?? '0' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Schedule</label>
                            <p class="form-control-plaintext">{{ $item->Schedule ?? '00' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Min. Level</label>
                            <p class="form-control-plaintext">{{ $item->MinLevel ?? '0' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Max. Level</label>
                            <p class="form-control-plaintext">{{ $item->MaxLevel ?? '0' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Flag</label>
                            <p class="form-control-plaintext">{{ $item->Flag ?? 'Narcotic' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Composition & Strengths -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-capsule me-2"></i>Composition & Strengths</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Saltcode</label>
                            <p class="form-control-plaintext">{{ $item->Saltcode ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Strength</label>
                            <p class="form-control-plaintext">{{ $item->Strength ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">saltcode1</label>
                            <p class="form-control-plaintext">{{ $item->saltcode1 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Strength1</label>
                            <p class="form-control-plaintext">{{ $item->Strength1 ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">saltcode2</label>
                            <p class="form-control-plaintext">{{ $item->saltcode2 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Strength2</label>
                            <p class="form-control-plaintext">{{ $item->Strength2 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">saltcode3</label>
                            <p class="form-control-plaintext">{{ $item->saltcode3 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Strength3</label>
                            <p class="form-control-plaintext">{{ $item->Strength3 ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Saltcode4</label>
                            <p class="form-control-plaintext">{{ $item->Saltcode4 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Strength4</label>
                            <p class="form-control-plaintext">{{ $item->Strength4 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Saltcode5</label>
                            <p class="form-control-plaintext">{{ $item->Saltcode5 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Strength5</label>
                            <p class="form-control-plaintext">{{ $item->Strength5 ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Substitute</label>
                            <p class="form-control-plaintext">{{ $item->Substitute ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Saltno</label>
                            <p class="form-control-plaintext">{{ $item->Saltno ?? '0' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">SubStrenght</label>
                            <p class="form-control-plaintext">{{ $item->SubStrenght ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">ItemRef</label>
                            <p class="form-control-plaintext">{{ $item->ItemRef ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing, Taxes & Scheme -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-percent me-2"></i>Pricing, Taxes & Scheme</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Prate</label>
                            <p class="form-control-plaintext">{{ number_format($item->Prate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Tsr</label>
                            <p class="form-control-plaintext">{{ number_format($item->Tsr ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Psc</label>
                            <p class="form-control-plaintext">{{ $item->Psc ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">ptax</label>
                            <p class="form-control-plaintext">{{ number_format($item->ptax ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Excise</label>
                            <p class="form-control-plaintext">{{ number_format($item->Excise ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Scm1</label>
                            <p class="form-control-plaintext">{{ $item->Scm1 ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">scm2</label>
                            <p class="form-control-plaintext">{{ $item->scm2 ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Srate</label>
                            <p class="form-control-plaintext">{{ number_format($item->Srate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Sc</label>
                            <p class="form-control-plaintext">{{ $item->Sc ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Saletype</label>
                            <p class="form-control-plaintext">{{ $item->Saletype ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Stax</label>
                            <p class="form-control-plaintext">{{ number_format($item->Stax ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Wsrate</label>
                            <p class="form-control-plaintext">{{ number_format($item->Wsrate ?? 0, 2) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Add_sc</label>
                            <p class="form-control-plaintext">{{ number_format($item->Add_sc ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Add_tsr</label>
                            <p class="form-control-plaintext">{{ number_format($item->Add_tsr ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Costrate</label>
                            <p class="form-control-plaintext">{{ number_format($item->Costrate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">ScmPer</label>
                            <p class="form-control-plaintext">{{ number_format($item->ScmPer ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">currentScm</label>
                            <p class="form-control-plaintext">{{ $item->currentScm ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Mrp</label>
                            <p class="form-control-plaintext">{{ number_format($item->Mrp ?? 0, 2) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">ScmFrom</label>
                            <p class="form-control-plaintext">{{ $item->ScmFrom ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">ScmTo</label>
                            <p class="form-control-plaintext">{{ $item->ScmTo ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">CurrScm1</label>
                            <p class="form-control-plaintext">{{ $item->CurrScm1 ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">CurrScm2</label>
                            <p class="form-control-plaintext">{{ $item->CurrScm2 ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock & Batch -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Stock & Batch</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">opqty</label>
                            <p class="form-control-plaintext">{{ number_format($item->opqty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Clqty</label>
                            <p class="form-control-plaintext">{{ number_format($item->Clqty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Vdt</label>
                            <p class="form-control-plaintext">{{ $item->Vdt ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Batchcode</label>
                            <p class="form-control-plaintext">{{ $item->Batchcode ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">cname_bc</label>
                            <p class="form-control-plaintext">{{ $item->cname_bc ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Defqty</label>
                            <p class="form-control-plaintext">{{ number_format($item->Defqty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">BarcodeQty</label>
                            <p class="form-control-plaintext">{{ $item->BarcodeQty ?? '0' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">splrate</label>
                            <p class="form-control-plaintext">{{ number_format($item->splrate ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Net & Flags -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Sales Net & Flags</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Ssc</label>
                            <p class="form-control-plaintext">{{ $item->Ssc ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">WsNet</label>
                            <p class="form-control-plaintext">{{ number_format($item->WsNet ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">SplNet</label>
                            <p class="form-control-plaintext">{{ number_format($item->SplNet ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Hscm</label>
                            <p class="form-control-plaintext">{{ $item->Hscm ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Box</label>
                            <p class="form-control-plaintext">{{ $item->Box ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">CommonItem</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->CommonItem ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->CommonItem ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Sscm1</label>
                            <p class="form-control-plaintext">{{ $item->Sscm1 ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">FDis</label>
                            <p class="form-control-plaintext">{{ number_format($item->FDis ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Sscm2</label>
                            <p class="form-control-plaintext">{{ $item->Sscm2 ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">FDisP</label>
                            <p class="form-control-plaintext">{{ number_format($item->FDisP ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TrimName</label>
                            <p class="form-control-plaintext">{{ $item->TrimName ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">PresReq</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->PresReq ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->PresReq ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">QScm</label>
                            <p class="form-control-plaintext">{{ $item->QScm ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">SconMrp</label>
                            <p class="form-control-plaintext">{{ number_format($item->SconMrp ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">VAT (%)</label>
                            <p class="form-control-plaintext">{{ number_format($item->VAT ?? 4, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Margin</label>
                            <p class="form-control-plaintext">{{ number_format($item->Margin ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Inclusive</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->Inclusive ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->Inclusive ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category & Description -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Category & Description</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">ItemCat</label>
                            <p class="form-control-plaintext">{{ $item->ItemCat ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Gdn</label>
                            <p class="form-control-plaintext">{{ $item->Gdn ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">PRateCase</label>
                            <p class="form-control-plaintext">{{ number_format($item->PRateCase ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">PRateBox</label>
                            <p class="form-control-plaintext">{{ number_format($item->PRateBox ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Desc1</label>
                            <p class="form-control-plaintext">{{ $item->Desc1 ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Desc2</label>
                            <p class="form-control-plaintext">{{ $item->Desc2 ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">MinQty</label>
                            <p class="form-control-plaintext">{{ number_format($item->MinQty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">MaxQty</label>
                            <p class="form-control-plaintext">{{ number_format($item->MaxQty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">ItCase</label>
                            <p class="form-control-plaintext">{{ $item->ItCase ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TRate</label>
                            <p class="form-control-plaintext">{{ number_format($item->TRate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Wr</label>
                            <p class="form-control-plaintext">{{ number_format($item->Wr ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Pic</label>
                            <p class="form-control-plaintext">{{ $item->Pic ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Mfg</label>
                            <p class="form-control-plaintext">{{ $item->Mfg ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Generic</label>
                            <p class="form-control-plaintext">{{ $item->Generic ?? 'N' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Expiry</label>
                            <p class="form-control-plaintext">{{ $item->Expiry ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Temporary & Tax Flags -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-sliders me-2"></i>Temporary & Tax Flags</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TempOpqty</label>
                            <p class="form-control-plaintext">{{ number_format($item->TempOpqty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TempClqty</label>
                            <p class="form-control-plaintext">{{ number_format($item->TempClqty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TempAmt</label>
                            <p class="form-control-plaintext">{{ number_format($item->TempAmt ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TempAmt1</label>
                            <p class="form-control-plaintext">{{ number_format($item->TempAmt1 ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TempAmt2</label>
                            <p class="form-control-plaintext">{{ number_format($item->TempAmt2 ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">TaxonMrp</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->TaxonMrp ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->TaxonMrp ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">IWeight</label>
                            <p class="form-control-plaintext">{{ number_format($item->IWeight ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Misc Attributes -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Misc Attributes</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">MaxQtyWr</label>
                            <p class="form-control-plaintext">{{ number_format($item->MaxQtyWr ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">OpFreeQty</label>
                            <p class="form-control-plaintext">{{ number_format($item->OpFreeQty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">VATonSrate</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->VATonSrate ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->VATonSrate ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Exon</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->Exon ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->Exon ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">ExPer</label>
                            <p class="form-control-plaintext">{{ number_format($item->ExPer ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">UnitType</label>
                            <p class="form-control-plaintext">{{ $item->UnitType ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">MfgQty</label>
                            <p class="form-control-plaintext">{{ number_format($item->MfgQty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">mTag</label>
                            <p class="form-control-plaintext">{{ $item->mTag ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">DisContinue</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->DisContinue ? 'bg-danger' : 'bg-success' }}">
                                    {{ $item->DisContinue ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Vol</label>
                            <p class="form-control-plaintext">{{ number_format($item->Vol ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">VDisP</label>
                            <p class="form-control-plaintext">{{ number_format($item->VDisP ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">VDisS</label>
                            <p class="form-control-plaintext">{{ number_format($item->VDisS ?? 0, 2) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">FDisWR</label>
                            <p class="form-control-plaintext">{{ number_format($item->FDisWR ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">LastYearCost</label>
                            <p class="form-control-plaintext">{{ number_format($item->LastYearCost ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">OpAddQty</label>
                            <p class="form-control-plaintext">{{ number_format($item->OpAddQty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">SaleLessQty</label>
                            <p class="form-control-plaintext">{{ number_format($item->SaleLessQty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">SplDisQty</label>
                            <p class="form-control-plaintext">{{ number_format($item->SplDisQty ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">SplDisPer</label>
                            <p class="form-control-plaintext">{{ number_format($item->SplDisPer ?? 0, 2) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">FullName</label>
                            <p class="form-control-plaintext">{{ $item->FullName ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">LockScm</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->LockScm ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ $item->LockScm ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">RateLock</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->RateLock ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ $item->RateLock ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">MinRate</label>
                            <p class="form-control-plaintext">{{ number_format($item->MinRate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">CostWFQ</label>
                            <p class="form-control-plaintext">{{ number_format($item->CostWFQ ?? 0, 2) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">PurExciseAsRate</label>
                            <p class="form-control-plaintext">{{ number_format($item->PurExciseAsRate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">PurNetRate</label>
                            <p class="form-control-plaintext">{{ number_format($item->PurNetRate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">LockBilling</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->LockBilling ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ $item->LockBilling ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">SameBatchCost</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $item->SameBatchCost ? 'bg-info' : 'bg-secondary' }}">
                                    {{ $item->SameBatchCost ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">EsCode</label>
                            <p class="form-control-plaintext">{{ $item->EsCode ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">FdisPWS</label>
                            <p class="form-control-plaintext">{{ number_format($item->FdisPWS ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">ItemType</label>
                            <p class="form-control-plaintext">{{ $item->ItemType ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">ItemGroup</label>
                            <p class="form-control-plaintext">{{ $item->ItemGroup ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">GST Cess (%)</label>
                            <p class="form-control-plaintext">{{ number_format($item->GSTCess ?? 0, 2) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">IucCode</label>
                            <p class="form-control-plaintext">{{ $item->IucCode ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">miscsettings</label>
                            <p class="form-control-plaintext">{{ $item->miscsettings ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">SyncMark</label>
                            <p class="form-control-plaintext">{{ $item->SyncMark ?? '-' }}</p>
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
                            <label class="form-label fw-bold">Net</label>
                            <p class="form-control-plaintext">{{ number_format($item->Net ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Spl. Rate</label>
                            <p class="form-control-plaintext">{{ number_format($item->SplRate ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Min. GP</label>
                            <p class="form-control-plaintext">{{ number_format($item->MinGP ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Commodity</label>
                            <p class="form-control-plaintext">{{ $item->Commodity ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Scheme</label>
                            <p class="form-control-plaintext">{{ $item->Scheme ?? '0' }}</p>
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
                            <label class="form-label fw-bold">Cost</label>
                            <p class="form-control-plaintext">{{ number_format($item->Cost ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Pur. Scheme</label>
                            <p class="form-control-plaintext">{{ $item->PurScheme ?? '0' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">NR</label>
                            <p class="form-control-plaintext">{{ number_format($item->NR ?? 0, 2) }}</p>
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
                            <label class="form-label fw-bold">HSN Code</label>
                            <p class="form-control-plaintext">{{ $item->HSNCode ?? '-' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">CGST (%)</label>
                            <p class="form-control-plaintext">{{ number_format($item->CGST ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">SGST (%)</label>
                            <p class="form-control-plaintext">{{ number_format($item->SGST ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">IGST (%)</label>
                            <p class="form-control-plaintext">{{ number_format($item->IGST ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Cess (%)</label>
                            <p class="form-control-plaintext">{{ number_format($item->Cess ?? 0, 2) }}</p>
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
                            <label class="form-label fw-bold">Fixed Dis. (Y/N/M)</label>
                            <p class="form-control-plaintext">{{ number_format($item->FixedDis ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <p class="form-control-plaintext">{{ $item->Category ?? '00' }}</p>
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
                            <label class="form-label fw-bold">Max Inv. Qty</label>
                            <p class="form-control-plaintext">{{ $item->MaxInvQty ?? '0' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Weight</label>
                            <p class="form-control-plaintext">{{ number_format($item->Weight ?? 0, 3) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Volume</label>
                            <p class="form-control-plaintext">{{ number_format($item->Volume ?? 0, 3) }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Lock</label>
                            <p class="form-control-plaintext">{{ $item->Lock ?? '-' }}</p>
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
                            <label class="form-label fw-bold">Bar Code</label>
                            <p class="form-control-plaintext">{{ $item->BarCodeFlag ?? 'N' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Det. Qty.</label>
                            <p class="form-control-plaintext">{{ $item->DetQty ?? 'N' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Comp. Name (BC)</label>
                            <p class="form-control-plaintext">{{ $item->CompNameBC ?? 'Y' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">DPC Item</label>
                            <p class="form-control-plaintext">{{ $item->DPCItem ?? 'N' }}</p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold">Lock Sale</label>
                            <p class="form-control-plaintext">{{ $item->LockSale ?? 'N' }}</p>
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
                            <label class="form-label fw-bold">Commodity</label>
                            <p class="form-control-plaintext">{{ $item->CommodityClass ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Current Scheme</label>
                            <p class="form-control-plaintext">{{ $item->CurrentScheme ?? '-' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <p class="form-control-plaintext">{{ $item->CategoryClass ?? '00' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection