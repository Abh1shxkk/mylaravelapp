@extends('layouts.admin')

@section('title', 'Sale Return - Transaction')

@section('content')
<style>
    .form-label-sm {
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .form-control-xs {
        font-size: 11px;
        padding: 2px 6px;
        height: 24px;
    }
    .form-select-xs {
        font-size: 11px;
        padding: 2px 6px;
        height: 24px;
    }
    .header-section {
        background: #f8f9fa;
        border: 2px solid #000;
        padding: 8px;
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
    }
    .summary-section {
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
    <form id="saleReturnForm">
        @csrf
        
        <!-- Header Section -->
        <div class="header-section mb-2">
            <div class="row g-2">
                <!-- Left Column -->
                <div class="col-md-3">
                    <div class="mb-1 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">Series :</label>
                        <input type="text" class="form-control form-control-xs me-2" value="SR" readonly style="width: 50px;">
                        <strong class="text-danger" style="font-size: 12px;">SALES RETURN - CREDIT</strong>
                    </div>
                    <div class="mb-1 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">Date :</label>
                        <input type="date" class="form-control form-control-xs me-2" value="{{ date('Y-m-d') }}" style="width: 120px;">
                        <span class="badge bg-secondary" style="font-size: 10px;">{{ date('l') }}</span>
                    </div>
                    <div class="mb-0 d-flex align-items-center">
                        <label class="form-label-sm me-2" style="width: 60px;">S.R.No :</label>
                        <input type="text" class="form-control form-control-xs" value="{{ $nextReturnNo }}" readonly style="width: 80px;">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-9">
                    <div class="row g-1 mb-1">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 80px;">Name</label>
                                <select class="form-select form-select-xs flex-grow-1" name="customer_id">
                                    <option value="">...</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->code }} - {{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2">Fixed Dis. :</label>
                                <input type="text" class="form-control form-control-xs" value="0.00" style="width: 80px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-1 mb-1">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 80px;">Sales Man</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1" placeholder="00 - DIRECT">
                            </div>
                        </div>
                    </div>

                    <div class="row g-1 mb-1">
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-1">Inv.No. :</label>
                                <input type="text" class="form-control form-control-xs" placeholder="14865">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-1">Series :</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-1">Date :</label>
                                <input type="date" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2">Cash :</label>
                                <input type="checkbox" class="form-check-input me-3">
                                <label class="form-label-sm me-2">Tax :</label>
                                <input type="checkbox" class="form-check-input" checked>
                            </div>
                        </div>
                    </div>

                    <div class="row g-1">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 80px;">Remarks :</label>
                                <input type="text" class="form-control form-control-xs flex-grow-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-2">
            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table class="table table-bordered table-items mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Code</th>
                            <th style="width: 200px;">Item Name</th>
                            <th style="width: 100px;">Batch</th>
                            <th style="width: 80px;">Exp.</th>
                            <th style="width: 60px;">Qty.</th>
                            <th style="width: 60px;">F.Qty.</th>
                            <th style="width: 80px;">Sale Rate</th>
                            <th style="width: 60px;">Dis.%</th>
                            <th style="width: 80px;">MRP</th>
                            <th style="width: 100px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        @for($i = 0; $i < 15; $i++)
                        <tr class="{{ $i == 0 ? 'bg-warning bg-opacity-25' : '' }}">
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
        <div class="tax-section mb-2">
            <div class="row g-2">
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2 text-danger fw-bold">CGST(%):</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2 text-danger fw-bold">SGST(%):</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2 text-danger fw-bold">Cess (%):</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2">TAX %:</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2">SC %:</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2">Excise:</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label class="form-label-sm me-2">TSR:</label>
                        <input type="number" class="form-control form-control-xs" step="0.01">
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="row g-2 mb-2">
            <!-- Left Summary -->
            <div class="col-md-6">
                <div class="summary-section">
                    <div class="row g-1">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">N.T.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 40px;">SC</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Scm.%</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 40px;">F.T.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Dis.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 40px;">Scm.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Tax</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2 text-danger fw-bold" style="width: 40px;">Net</label>
                                <input type="number" class="form-control form-control-xs bg-danger bg-opacity-10" step="0.01">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 60px;">TCS</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Summary -->
            <div class="col-md-6">
                <div class="summary-section">
                    <div class="row g-1">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Packing</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">N.T.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Unit</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">SC Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Cl. Qty</label>
                                <input type="number" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Dis. Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Lctn :</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">HS. Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Scm. %</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Sub.Tot.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Scm.Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Comp :</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Tax Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Srino</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">Net Amt.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label-sm me-2" style="width: 60px;">SCM.</label>
                                <input type="text" class="form-control form-control-xs">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="form-label-sm me-2" style="width: 60px;">Vol.</label>
                                <input type="number" class="form-control form-control-xs" step="0.01">
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
                <button type="button" class="btn btn-sm btn-primary btn-action">
                    <span class="text-primary">Change Remarks [F3]</span>
                </button>
            </div>
            <button type="button" class="btn btn-sm btn-secondary btn-action">Cancel Invoice</button>
        </div>
    </form>
</div>
@endsection
