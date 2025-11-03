@extends('layouts.admin')

@section('title', 'Purchase Return - Modification')

@section('content')
<style>
    .form-label-sm {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .form-control-xs {
        font-size: 11px;
        padding: 2px 6px;
        height: 24px;
    }
    .header-section {
        background: #f8f9fa;
        border: 2px solid #000;
        padding: 10px;
        margin-bottom: 10px;
    }
    .table-items {
        font-size: 11px;
    }
    .table-items th {
        background: #E6E6FA;
        color: #000;
        font-weight: 600;
        padding: 4px;
        border: 1px solid #000;
    }
    .table-items td {
        padding: 2px;
        border: 1px solid #ccc;
    }
    .table-items input {
        border: none;
        width: 100%;
        font-size: 11px;
        padding: 2px 4px;
    }
    .tax-section {
        background: #FFE4E1;
        padding: 8px;
        border: 1px solid #000;
        margin-bottom: 10px;
    }
    .summary-section {
        background: #FFB6C1;
        border: 1px solid #000;
        padding: 6px;
        margin-bottom: 10px;
    }
    .summary-section-2 {
        background: #FFF8DC;
        border: 1px solid #000;
        padding: 6px;
    }
    .btn-action {
        font-size: 11px;
        padding: 4px 12px;
    }
</style>

<div class="container-fluid p-2">
    <form id="purchaseReturnModForm">
        @csrf
        
        <!-- Header Section -->
        <div class="header-section">
            <div class="row g-2">
                <!-- Left Column -->
                <div class="col-md-3">
                    <div class="mb-1 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 50px;">Date :</label>
                        <input type="date" class="form-control form-control-xs" value="{{ date('Y-m-d') }}" style="width: 130px;">
                        <span class="badge bg-secondary ms-2" style="font-size: 10px;">{{ date('l') }}</span>
                    </div>
                    <div class="mb-0 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 50px;">T. No. :</label>
                        <input type="text" class="form-control form-control-xs" placeholder="165" style="width: 80px;">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-9">
                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Supplier :</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <label class="form-label-sm">Tax :</label>
                                <input type="text" class="form-control form-control-xs" style="width: 40px;" value="Y">
                                <label class="form-label-sm">Rate Diff :</label>
                                <input type="text" class="form-control form-control-xs" style="width: 40px;" value="N">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Inv.No. :</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 50px;">Date :</label>
                                <input type="date" class="form-control form-control-xs flex-grow-1">
                            </div>
                        </div>
                    </div>

                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">GST Vno :</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Remarks :</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1">
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-sm btn-danger" style="font-size: 11px; padding: 2px 8px;">
                                    <span class="text-danger fw-bold">Show Purchase Inv.(F2)</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-2">
            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                <table class="table table-bordered table-items mb-0">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Item Code</th>
                            <th style="width: 200px;">Item Name</th>
                            <th style="width: 100px;">Batch</th>
                            <th style="width: 80px;">Exp.</th>
                            <th style="width: 60px;">Qty.</th>
                            <th style="width: 60px;">F.Qty.</th>
                            <th style="width: 80px;">Pur. Rate</th>
                            <th style="width: 60px;">Dis.%</th>
                            <th style="width: 80px;">F.T. Rate</th>
                            <th style="width: 100px;">F.T. Amt.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < 10; $i++)
                        <tr>
                            <td><input type="text" class="form-control-plaintext"></td>
                            <td><input type="text" class="form-control-plaintext"></td>
                            <td><input type="text" class="form-control-plaintext"></td>
                            <td><input type="text" class="form-control-plaintext"></td>
                            <td><input type="number" class="form-control-plaintext text-end"></td>
                            <td><input type="number" class="form-control-plaintext text-end"></td>
                            <td><input type="number" class="form-control-plaintext text-end" step="0.01"></td>
                            <td><input type="number" class="form-control-plaintext text-end" step="0.01"></td>
                            <td><input type="number" class="form-control-plaintext text-end" step="0.01"></td>
                            <td><input type="number" class="form-control-plaintext text-end" step="0.01"></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tax Section -->
        <div class="tax-section">
            <div class="row g-2 align-items-center">
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label-sm">SC %</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                        <label class="form-label-sm">EXCISE</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-danger fw-bold text-center" style="font-size: 12px; background: #FF0000; color: white !important; padding: 4px;">
                        CGST(%):<br>
                        SGST(%):<br>
                        Cess (%):
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label-sm">W.S.RATE</label>
                        <input type="number" class="form-control form-control-xs" style="width: 100px;" step="0.01">
                        <label class="form-label-sm ms-2">S.RATE</label>
                        <input type="number" class="form-control form-control-xs" style="width: 100px;" step="0.01">
                    </div>
                </div>
            </div>
            <div class="row g-2 mt-1">
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label-sm">TAX %</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                        <label class="form-label-sm">TSR</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label-sm">MRP</label>
                        <input type="number" class="form-control form-control-xs flex-grow-1" step="0.01">
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section 1 (Pink) -->
        <div class="summary-section">
            <div class="row g-1">
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 70px;">N.T AMT</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 40px;">SC</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 70px;">DIS. AMT</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 70px;">SCM. AMT</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 40px;">Tax</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 70px;">INV. AMT</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
            </div>
            <div class="row g-1 mt-1">
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 70px;">Scm.%</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 40px;">TCS</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 70px;">DIS1 AMT</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section 2 (Yellow) -->
        <div class="summary-section-2">
            <div class="row g-1">
                <div class="col-md-6">
                    <div class="row g-1">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Packing</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">N.T.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Unit</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">SC Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Cl. Qty</label>
                                <input type="number" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Dis1.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Lctn :</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Hs. Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row g-1">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Scm.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Net Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Dis1.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Comp :</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Gross Tot.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Srino.</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Tax Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">SCM.</label>
                                <input type="text" class="form-control form-control-xs">
                                <span class="ms-1">+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-1 mt-1">
                <div class="col-md-12">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label-sm">Scm. %</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                        <label class="form-label-sm ms-2">Dis1. %</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                        <label class="form-label-sm ms-2">%</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                        <label class="form-label-sm ms-2">%</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center p-2 border">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-secondary btn-action">Save (End)</button>
                <button type="button" class="btn btn-sm btn-danger btn-action">Delete Item</button>
                <button type="button" class="btn btn-sm btn-success btn-action">Insert Item</button>
                <button type="button" class="btn btn-sm btn-info btn-action">View On Screen</button>
            </div>
            <button type="button" class="btn btn-sm btn-secondary btn-action">Cancel</button>
        </div>
    </form>
</div>
@endsection
