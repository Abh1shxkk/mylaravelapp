@extends('layouts.admin')

@section('title', 'Breakage/Expiry - Transaction')

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
        background: #90EE90;
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
    <form id="breakageExpiryForm">
        @csrf
        
        <!-- Header Section -->
        <div class="header-section">
            <div class="row g-2">
                <!-- Left Column -->
                <div class="col-md-3">
                    <div class="mb-1 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">Series:</label>
                        <input type="text" class="form-control form-control-xs" value="BE" readonly style="width: 60px;">
                    </div>
                    <div class="mb-1 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">Date :</label>
                        <input type="date" class="form-control form-control-xs" value="{{ date('Y-m-d') }}" style="width: 130px;">
                    </div>
                    <div class="mb-1 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">S.R.No:</label>
                        <input type="text" class="form-control form-control-xs" placeholder="1" style="width: 80px;">
                    </div>
                    <div class="mb-0 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">E.Date:</label>
                        <input type="date" class="form-control form-control-xs" value="{{ date('Y-m-d') }}" style="width: 130px;">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-9">
                    <div class="row g-1 mb-1">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 80px;">Name</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <label class="form-label-sm">GST Vno:</label>
                                <input type="text" class="form-control form-control-xs" style="width: 120px;">
                                <label class="form-label-sm">R (epl.) / C (redit) Note:</label>
                                <input type="text" class="form-control form-control-xs" style="width: 40px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-1 mb-1">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label-sm" style="width: 80px;">Sales Man</label>
                                <input type="text" class="form-control form-control-xs" placeholder="00" style="width: 80px;">
                                <label class="form-label-sm ms-3">With GST[Y/N]</label>
                                <input type="text" class="form-control form-control-xs" style="width: 30px;" value="N">
                                <label class="form-label-sm ms-2">Inc.</label>
                                <input type="text" class="form-control form-control-xs" style="width: 30px;" value="N">
                                <label class="form-label-sm ms-2 text-danger fw-bold">Rev.Charge</label>
                                <input type="text" class="form-control form-control-xs" style="width: 30px;" value="Y">
                                <label class="form-label-sm ms-2">To be Adjusted?[Y/N],&lt;X&gt; for Imm. Posting</label>
                                <input type="text" class="form-control form-control-xs" style="width: 30px;">
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label-sm" style="width: 80px;">Dis :</label>
                                <input type="text" class="form-control form-control-xs" style="width: 80px;">
                                <label class="form-label-sm ms-2">Rpl :</label>
                                <input type="text" class="form-control form-control-xs" style="width: 80px;">
                                <label class="form-label-sm ms-2">Brk. :</label>
                                <input type="text" class="form-control form-control-xs" style="width: 80px;">
                                <label class="form-label-sm ms-2">Exp :</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1">
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
                            <th style="width: 80px;">Code</th>
                            <th style="width: 200px;">Item Name</th>
                            <th style="width: 100px;">Batch</th>
                            <th style="width: 80px;">Exp.</th>
                            <th style="width: 80px;">Br/Ex</th>
                            <th style="width: 60px;">Qty.</th>
                            <th style="width: 60px;">F.Qty.</th>
                            <th style="width: 80px;">MRP</th>
                            <th style="width: 60px;">Scm.%</th>
                            <th style="width: 60px;">Dis.%</th>
                            <th style="width: 100px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < 12; $i++)
                        <tr>
                            <td><input type="text" class="form-control-plaintext"></td>
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
                <div class="col-md-2">
                    <div class="text-danger fw-bold" style="font-size: 12px;">
                        CGST(%):<br>
                        SGST(%):
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label-sm">TAX %</label>
                        <input type="number" class="form-control form-control-xs" style="width: 80px;" step="0.01">
                        <label class="form-label-sm ms-2">P.Rate</label>
                        <input type="number" class="form-control form-control-xs" style="width: 100px;" step="0.01">
                        <label class="form-label-sm ms-2">S.Rate</label>
                        <input type="number" class="form-control form-control-xs" style="width: 100px;" step="0.01">
                        <label class="form-label-sm ms-2">MRP</label>
                        <input type="number" class="form-control form-control-xs" style="width: 100px;" step="0.01">
                        <label class="form-label-sm ms-2">Pack</label>
                        <input type="text" class="form-control form-control-xs" style="width: 80px;">
                        <label class="form-label-sm ms-2">Disallow</label>
                        <input type="text" class="form-control form-control-xs" style="width: 40px;" value="N">
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <label class="form-label-sm">Payable Amount</label>
                        <input type="number" class="form-control form-control-xs" style="width: 150px;" step="0.01">
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section 1 (Pink) -->
        <div class="summary-section">
            <div class="row g-1">
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 80px;">MRP Value</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">Gross</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 40px;">Dis.</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 40px;">Scm.</label>
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
                        <label class="form-label-sm me-2 text-danger fw-bold" style="width: 40px;">Net</label>
                        <input type="number" class="form-control form-control-xs bg-danger bg-opacity-10" step="0.01">
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
                                <label class="form-label-sm me-2" style="width: 70px;">Gross</label>
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
                                <label class="form-label-sm me-2" style="width: 70px;">Scm. Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Cl. Qty</label>
                                <input type="number" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Dis. Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row g-1">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Sub Tot.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Less Pcnt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Tax Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 70px;">Inv.Amt.</label>
                                <input type="number" class="form-control form-control-xs" value="0.00" step="0.01" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Net Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">Srino</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 70px;">SCM.</label>
                                <input type="text" class="form-control form-control-xs">
                                <span class="ms-1">+</span>
                            </div>
                        </div>
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
