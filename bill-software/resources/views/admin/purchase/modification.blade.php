@extends('layouts.admin')

@section('title', 'Purchase Modification')

@section('content')
<style>
    body {
        font-size: 11px;
    }
    
    .compact-form {
        padding: 8px;
        background: #f5f5f5;
    }
    
    .compact-form label {
        font-weight: 600;
        font-size: 11px;
        margin-bottom: 0;
        white-space: nowrap;
    }
    
    .compact-form input,
    .compact-form select {
        font-size: 11px;
        padding: 2px 6px;
        height: 26px;
    }
    
    .compact-form .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    
    .header-section {
        background: white;
        border: 1px solid #dee2e6;
        padding: 10px;
        margin-bottom: 8px;
        border-radius: 4px;
    }
    
    .header-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 6px;
    }
    
    .field-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .inner-card {
        background: #e8f4f8;
        border: 1px solid #b8d4e0;
        padding: 8px;
        border-radius: 3px;
    }
    
    .table-compact {
        font-size: 10px;
        margin-bottom: 0;
    }
    
    .table-compact th,
    .table-compact td {
        padding: 4px;
        vertical-align: middle;
        height: 45px; /* Fixed row height for consistent 6-row display */
    }
    
    .table-compact th {
        background: #e9ecef;
        font-weight: 600;
        text-align: center;
        border: 1px solid #dee2e6;
        height: 40px; /* Fixed header height */
    }
    
    .table-compact input {
        font-size: 10px;
        padding: 2px 4px;
        height: 22px;
        border: 1px solid #ced4da;
        width: 100%;
    }
    
    /* Table container - Shows exactly 6 rows + header */
    #itemsTableContainer {
        /* Header: 40px + 6 Rows: 6 × 45px = 310px total */
        max-height: 310px !important;
    }
    
    .total-display {
        font-size: 16px;
        color: #0d6efd;
        text-align: right;
    }
    
    .readonly-field {
        background-color: #e9ecef !important;
        cursor: not-allowed;
    }
    
    /* Row selection highlight */
    .row-selected {
        background-color: #d4edff !important;
        border: 2px solid #007bff !important;
    }
    
    .row-selected td {
        background-color: #d4edff !important;
    }
    
    /* Row calculation status colors */
    .row-incomplete {
        background-color: #ffebee !important;
        color: #c62828 !important;
    }
    
    .row-incomplete td {
        background-color: #ffebee !important;
        color: #c62828 !important;
    }
    
    .row-incomplete input {
        background-color: #ffebee !important;
        color: #c62828 !important;
    }
    
    .row-complete {
        background-color: #e8f5e9 !important;
        color: #2e7d32 !important;
    }
    
    .row-complete td {
        background-color: #e8f5e9 !important;
        color: #2e7d32 !important;
    }
    
    .row-complete input {
        background-color: #e8f5e9 !important;
        color: #2e7d32 !important;
    }
    
    /* When all rows are complete, make them all green */
    .all-rows-complete .row-complete {
        background-color: #c8e6c9 !important;
        color: #1b5e20 !important;
    }
    
    .all-rows-complete .row-complete td {
        background-color: #c8e6c9 !important;
        color: #1b5e20 !important;
    }
    
    .all-rows-complete .row-complete input {
        background-color: #c8e6c9 !important;
        color: #1b5e20 !important;
    }
    
    /* Pending Orders Modal Styles */
    .pending-orders-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: calc(50% + 130px); /* Account for sidebar width (260px / 2 = 130px) */
        transform: translate(-50%, -50%) scale(0.7);
        width: 90%;
        max-width: 900px;
        max-height: 90vh;
        z-index: 10000; /* Higher than sidebar z-index (1030) */
        opacity: 0;
        transition: all 0.3s ease-in-out;
        overflow: hidden;
    }
    
    .pending-orders-modal.show {
        display: block;
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
    
    /* Specific styling for invoice list modal */
    #invoiceListModal {
        max-width: 1200px;
        max-height: 90vh;
        /* Adjust left position for invoice modal */
        left: calc(50% + 130px);
    }
    
    /* When sidebar is collapsed, adjust positioning */
    .collapsed .pending-orders-modal,
    .collapsed #invoiceListModal {
        left: calc(50% + 36px); /* Account for collapsed sidebar (72px / 2 = 36px) */
    }
    
    #invoiceListModal .pending-orders-content {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
    
    /* Mobile responsive - center modal on mobile */
    @media (max-width: 991.98px) {
        .pending-orders-modal,
        #invoiceListModal {
            left: 50%; /* Center on mobile since sidebar is hidden */
        }
    }
    
    .pending-orders-content {
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }
    
    .pending-orders-header {
        padding: 1rem 1.5rem;
        background: #ff6b35;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #e55a25;
    }
    
    .pending-orders-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    .btn-close-modal {
        background: transparent;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: background 0.2s;
    }
    
    .btn-close-modal:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .pending-orders-body {
        padding: 0;
        background: #fff;
    }
    
    .pending-orders-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .pending-orders-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999; /* Below modal but above everything else */
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .pending-orders-backdrop.show {
        display: block;
        opacity: 1;
    }
    
    /* Action buttons styling */
    #itemsTableBody td:last-child {
        white-space: nowrap;
        padding: 5px !important;
    }
    
    #itemsTableBody td:last-child button {
        display: inline-block;
        vertical-align: middle;
    }
</style>

<div class="container-fluid compact-form">
    <form id="purchaseForm" method="POST" autocomplete="off" onsubmit="return false;">
        @csrf
        
        <!-- Header Section -->
        <div class="header-section">
            <!-- Row 1: Date, Supplier -->
            <div class="header-row">
                <div class="field-group">
                    <label>Bill / Ledger Date</label>
                    <input type="date" class="form-control" name="bill_date" id="billDate" value="{{ date('Y-m-d') }}" style="width: 140px;" onchange="updateDayName()">
                    <input type="text" class="form-control readonly-field" id="dayName" value="{{ date('l') }}" readonly style="width: 90px;">
                </div>
                
                <div class="field-group">
                    <label>Supplier:</label>
                    <select class="form-control" name="supplier_id" id="supplierSelect" style="width: 250px;" autocomplete="off">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Row 2: Bill No, Trn No, Inner Card -->
            <div class="d-flex gap-3">
                <!-- Left Side -->
               
                
                <!-- Right Side - Inner Card -->
                <div class="inner-card flex-grow-1">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="field-group">
                                <label style="width: 100px;">Receive Date</label>
                                <input type="date" class="form-control" name="receive_date" id="receiveDate" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="field-group">
                                <label>Cash:</label>
                                <input type="text" class="form-control" name="cash" id="cash" value="N" maxlength="1" style="width: 50px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="field-group">
                                <label>Transfer:</label>
                                <input type="text" class="form-control" name="transfer" id="transfer" value="N" maxlength="1" style="width: 50px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-2 mt-1">
                        <div class="col-md-7">
                            <div class="field-group">
                                <label>Remarks:</label>
                                <input type="text" class="form-control" name="remarks" id="remarks">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="field-group">
                                <label style="width: 80px;">Due Date:</label>
                                <input type="date" class="form-control" name="due_date" id="dueDate" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
                 <div style="width: 200px;">
                    <div class="field-group mb-2">
                        <label style="width: 60px;">Bill No.:</label>
                        <input type="text" class="form-control" name="bill_no" id="billNo" placeholder="1111">
                    </div>
                    <div class="field-group mb-2">
                        <label style="width: 60px;">Trn.No.:</label>
                        <input type="text" class="form-control" name="trn_no" id="trnNo" placeholder="Enter Trn No">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-success" onclick="fetchBillByTrnNo()" style="width: 100%;">
                            <i class="bi bi-download"></i> Fetch Bill
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Items Table -->
        <div class="bg-white border rounded p-2 mb-2">
            <div class="table-responsive" style="overflow-y: auto;" id="itemsTableContainer">
                <table class="table table-bordered table-compact">
                    <thead style="position: sticky; top: 0; background: #e9ecef; z-index: 10;">
                        <tr>
                            <th style="width: 60px;">Code</th>
                            <th style="width: 250px;">Item Name</th>
                            <th style="width: 80px;">Batch</th>
                            <th style="width: 70px;">Exp.</th>
                            <th style="width: 60px;">Qty.</th>
                            <th style="width: 60px;">F.Qty.</th>
                            <th style="width: 80px;">Pur. Rate</th>
                            <th style="width: 60px;">Dis.%</th>
                            <th style="width: 80px;">MRP</th>
                            <th style="width: 90px;">Amount</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemsTableBody">
                        <!-- Rows will be added dynamically when pending order is loaded or via Add Row button -->
                    </tbody>
                </table>
            </div>
            <!-- Add Row Button -->
            <div class="text-center mt-2">
                <button type="button" class="btn btn-sm btn-success" onclick="addNewRow()">
                    <i class="fas fa-plus-circle"></i> Add Row
                </button>
            </div>
        </div>
        
        <!-- Calculation Section -->
        <div class="bg-white border rounded p-3 mb-2" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div class="d-flex align-items-start border rounded p-3" style="font-size: 11px; background: #fafafa; gap: 30px;">
                <!-- HSN Code Block (First) -->
                <div class="d-flex flex-column gap-2" style="min-width: 180px;">
                    <!-- HSN Code -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 80px;"><strong>HSN Code:</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_hsn_display" readonly style="width: 110px; height: 28px;" value="---">
                    </div>
                    
                    <!-- CGST(%) -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 80px;"><strong>CGST(%):</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_cgst" readonly style="width: 110px; height: 28px;" value="0">
                    </div>
                    
                    <!-- SGST(%) -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 80px;"><strong>SGST(%):</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_sgst" readonly style="width: 110px; height: 28px;" value="0">
                    </div>
                    
                    <!-- Cess (%) -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 80px;"><strong>Cess (%):</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_cess" readonly style="width: 110px; height: 28px;" value="0">
                    </div>
                </div>
                
                <!-- Right Side Fields (4 Columns) -->
                <div class="d-flex" style="gap: 25px; flex: 1;">
                    <!-- Column 1 -->
                    <div class="d-flex flex-column gap-2" style="min-width: 150px;">
                        <!-- Spl. Rate -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 70px;"><strong>Spl. Rate</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_spl_rate" readonly step="0.01" style="width: 90px; height: 28px;" value="0.00">
                        </div>
                        
                        <!-- W.S.Rate -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 70px;"><strong>W.S.Rate</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_ws_rate" readonly step="0.01" style="width: 90px; height: 28px;" value="0.00">
                        </div>
                        
                        <!-- TAX % -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 70px;"><strong>TAX %</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_tax_percent" readonly step="0.01" style="width: 90px; height: 28px;" value="0.000">
                        </div>
                    </div>
                    
                    <!-- Column 2 -->
                    <div class="d-flex flex-column gap-2" style="min-width: 160px;">
                        <!-- CGST Amt -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 80px;"><strong>CGST Amt:</strong></label>
                            <div class="border rounded px-2 py-1" style="background: #fff; min-width: 80px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                <strong id="calc_cgst_amount">0.00</strong>
                            </div>
                        </div>
                        
                        <!-- SGST Amt -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 80px;"><strong>SGST Amt:</strong></label>
                            <div class="border rounded px-2 py-1" style="background: #fff; min-width: 80px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                <strong id="calc_sgst_amount">0.00</strong>
                            </div>
                        </div>
                        
                        <!-- CESS Amt -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 80px;"><strong>CESS Amt:</strong></label>
                            <div class="border rounded px-2 py-1" style="background: #fff; min-width: 80px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                <strong id="calc_cess_amount">0.00</strong>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Column 3 -->
                    <div class="d-flex flex-column gap-2" style="min-width: 140px;">
                        <!-- Excise -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 55px;"><strong>Excise</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_excise" readonly step="0.01" style="width: 85px; height: 28px;" value="0.00">
                        </div>
                        
                        <!-- MRP -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 55px;"><strong>MRP</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_mrp" readonly step="0.01" style="width: 85px; height: 28px;" value="0.00">
                        </div>
                        
                        <!-- SC% -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 55px;"><strong>SC%</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_sc_percent" readonly step="0.01" style="width: 85px; height: 28px;" value="0.000">
                        </div>
                    </div>
                    
                    <!-- Column 4 (Inc, S.Rate, Less) -->
                    <div class="d-flex flex-column gap-2" style="min-width: 150px;">
                        <!-- Inc. -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 55px;"><strong>Inc.</strong></label>
                            <input type="text" class="form-control text-center readonly-field" id="calc_inc" readonly style="width: 70px; height: 28px;" value="Y">
                        </div>
                        
                        <!-- S.Rate -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 55px;"><strong>S.Rate</strong></label>
                            <input type="number" class="form-control text-end" id="calc_s_rate" step="0.01" style="width: 95px; height: 28px;" value="0.00">
                        </div>
                        
                        <!-- Less -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 55px;"><strong>Less</strong></label>
                            <input type="number" class="form-control text-end readonly-field" id="calc_less" readonly step="0.01" style="width: 95px; height: 28px;" value="0.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Summary Section -->
        <div class="bg-white border rounded p-2 mb-2">
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px; font-size: 11px; align-items: center;">
                <!-- Row 1 -->
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">N.T AMT</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="nt_amt" readonly step="0.01" style="width: 100%; height: 28px; background: #fff3cd;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">SC</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="sc_amt" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">SCM.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_amt" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">DIS.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="dis_amt" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">LESS</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="less_amt" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                </div>
                
                <div style="visibility: hidden;">
                    <div class="d-flex align-items-center" style="gap: 6px;">
                        <label class="mb-0" style="font-weight: bold;">Tax</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                    </div>
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">NET AMT.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="net_amt" readonly step="0.01" style="width: 100%; height: 28px; background: #fff3cd; font-weight: bold;" value="0.00">
                </div>
            </div>
            
            <!-- Row 2 -->
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px; font-size: 11px; align-items: center; margin-top: 12px;">
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">Tax</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="tax_amt" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">Scm.%</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_percent" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">TCS</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="tcs_amt" readonly step="0.01" style="width: 100%; height: 28px; background: #ffcccc;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">Dis1 Amt</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="dis1_amt" readonly step="0.01" style="width: 100%; height: 28px; background: #ffcccc;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold;">TOF</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="tof_amt" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                </div>
                
                <div style="visibility: hidden;">
                    <div class="d-flex align-items-center" style="gap: 6px;">
                        <label class="mb-0" style="font-weight: bold;">Tax</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" readonly step="0.01" style="width: 100%; height: 28px;" value="0.00">
                    </div>
                </div>
                
                <div class="d-flex align-items-center" style="gap: 6px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">INV.AMT.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="inv_amt" readonly step="0.01" style="width: 100%; height: 28px; background: #fff3cd; font-weight: bold;" value="0.00">
                </div>
            </div>
        </div>
        
        <!-- Detailed Info Section -->
        <div class="bg-white border rounded p-2 mb-2">
            <table style="width: 100%; font-size: 11px; border-collapse: collapse;">
                <tr>
                    <td style="padding: 3px;"><strong>Unit</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="unit" readonly value="1" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>N.T Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="nt_amt_detail" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Scm.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Tax Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="tax_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Cost</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="cost" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Srl.No.</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="srl_no1" readonly value="1" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="srl_no2" readonly value="1" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Lctn</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="lctn" readonly value="" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>SC Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="sc_amt_detail" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Dis1.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="dis1_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Net Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="net_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Cost+GST</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="cost_gst" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>P.SCM.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-center" id="p_scm1" readonly value="0" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px; text-align: center; font-weight: bold;">+</td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-center" id="p_scm2" readonly value="0" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Cl.Qty</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="cl_qty" readonly value="" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>Dis. Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="dis_amt_detail" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Less</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="less_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Comp :</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="comp" readonly value="" style="height: 22px; width: 100px;"></td>
                    <td style="padding: 3px;"><strong>Vol.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="vol" readonly value="0" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>S.SCM.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-center" id="s_scm1" readonly value="0" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px; text-align: center; font-weight: bold;">+</td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-center" id="s_scm2" readonly value="0" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Pack</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="pack_detail" readonly value="" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>Hs.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="hs_amt" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Gross Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="gross_amt" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Scm%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_percent_detail" readonly value="0.00" style="height: 22px; width: 60px;"></td>
                    <td style="padding: 3px;"><strong>Dis1.%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="dis1_percent" readonly value="0.00" style="height: 22px; width: 60px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="percent1" readonly value="0.00" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="percent2" readonly value="0.00" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="percent3" readonly value="0.00" style="height: 22px; width: 50px;"></td>
                </tr>
            </table>
        </div>
        
        <!-- Action Buttons -->
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary btn-sm" onclick="savePurchase()">
                <i class="bi bi-save"></i> Save
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
            <button type="button" class="btn btn-info btn-sm">
                <i class="bi bi-plus-circle"></i> Add Row
            </button>
        </div>
    </form>
</div>

<!-- MRP Details Modal Backdrop -->
<div id="mrpDetailsBackdrop" class="pending-orders-backdrop"></div>

<!-- MRP Details Modal -->
<div id="mrpDetailsModal" class="pending-orders-modal" style="max-width: 650px;">
    <div class="pending-orders-content">
        <div class="pending-orders-header" style="background: #ff6633; color: white; padding: 10px 15px;">
            <h5 class="pending-orders-title" style="margin: 0; font-size: 16px; font-weight: bold;">MRP - Purchase Rate details</h5>
            <button type="button" class="btn-close-modal" onclick="closeMrpDetailsModal()" title="Close" style="color: white; font-size: 20px;">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="pending-orders-body" style="padding: 15px; background: white;">
            <div class="mb-3">
                <div class="mb-2" style="font-size: 13px;">
                    <strong>Item Name : <span id="mrp_item_name" style="color: #8b008b;">---</span></strong>
                </div>
                <div class="mb-3" style="font-size: 13px;">
                    <strong>Pack : <span id="mrp_pack">---</span></strong>
                </div>
                
                <hr style="margin: 10px 0;">
                
                <table style="width: 100%; font-size: 13px;">
                    <tr>
                        <td style="padding: 5px 0; width: 50%;">
                            <label style="display: inline-block; width: 80px;"><strong>Case</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_case" style="width: 100px;" value="0">
                        </td>
                        <td style="padding: 5px 0;">
                            <label style="display: inline-block; width: 80px;"><strong>Box</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_box" style="width: 100px;" value="0">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <label style="display: inline-block; width: 80px;"><strong>MRP</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_value" step="0.01" style="width: 100px;" value="0.00">
                        </td>
                        <td style="padding: 5px 0;">
                            <label style="display: inline-block; width: 80px;"><strong>Pur. Rate</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_pur_rate" step="0.01" style="width: 100px;" value="0.00">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;" colspan="2">
                            <label style="display: inline-block; width: 80px;"><strong>Sale Rate</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_sale_rate" step="0.01" style="width: 100px;" value="0.00">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <label style="display: inline-block; width: 80px;"><strong>W.S. Rate</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_ws_rate" step="0.01" style="width: 100px;" value="0.00">
                        </td>
                        <td style="padding: 5px 0;">
                            <label style="display: inline-block; width: 80px;"><strong>SPL.Rate</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_spl_rate" step="0.01" style="width: 100px;" value="0.00">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;" colspan="2">
                            <label style="display: inline-block; width: 80px;"><strong>Excise</strong></label>
                            <span style="margin: 0 10px;">:</span>
                            <input type="number" class="form-control d-inline-block" id="mrp_excise" step="0.01" style="width: 100px;" value="0.00">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="pending-orders-footer" style="padding: 10px 15px; text-align: right; background: #f8f9fa;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeMrpDetailsModal()" style="margin-right: 10px;">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
            <button type="button" class="btn btn-primary btn-sm" id="saveMrpDetailsBtn">
                <i class="bi bi-check-circle"></i> Save
            </button>
        </div>
    </div>
</div>

<!-- Insert Item Modal Backdrop -->
<div id="insertItemBackdrop" class="pending-orders-backdrop"></div>

<!-- Insert Item Modal -->
<div id="insertItemModal" class="pending-orders-modal">
    <div class="pending-orders-content" style="max-width: 600px;">
        <div class="pending-orders-header">
            <h5 class="pending-orders-title">-- SELECT ITEM TO INSERT --</h5>
            <button type="button" class="btn-close-modal" onclick="closeInsertItemModal()" title="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="pending-orders-body">
            <!-- Search Box -->
            <div class="mb-3">
                <input type="text" class="form-control" id="itemSearchInput" placeholder="Search by Code or Name..." autocomplete="off">
            </div>
            
            <!-- Items List -->
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-hover mb-0" style="font-size: 11px;">
                    <thead style="position: sticky; top: 0; background: #f8f9fa; z-index: 10;">
                        <tr>
                            <th style="width: 80px;">CODE</th>
                            <th>ITEM NAME</th>
                            <th style="width: 100px;">MRP</th>
                            <th style="width: 100px;">S.RATE</th>
                        </tr>
                    </thead>
                    <tbody id="insertItemsBody">
                        <!-- Items will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pending-orders-footer" style="padding: 10px 15px; text-align: right; background: #f8f9fa;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeInsertItemModal()">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
        </div>
    </div>
</div>

<!-- Pending Orders Modal Backdrop -->
<div id="pendingOrdersBackdrop" class="pending-orders-backdrop"></div>

<!-- Pending Orders Modal -->
<div id="pendingOrdersModal" class="pending-orders-modal">
    <div class="pending-orders-content">
        <div class="pending-orders-header">
            <h5 class="pending-orders-title">-- PENDING ORDER :--</h5>
            <button type="button" class="btn-close-modal" onclick="closePendingOrdersModal()" title="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="pending-orders-body">
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-hover mb-0" style="font-size: 11px;">
                    <thead style="position: sticky; top: 0; background: #f8f9fa; z-index: 10;">
                        <tr>
                            <th style="width: 60px;">SRNO</th>
                            <th style="width: 80px;">CODE</th>
                            <th>NAME</th>
                            <th style="width: 80px;">QTY</th>
                            <th style="width: 100px;">O. DATE</th>
                            <th style="width: 100px;">ORD.NO</th>
                        </tr>
                    </thead>
                    <tbody id="pendingOrdersBody">
                        <!-- Orders will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pending-orders-footer">
            <button type="button" class="btn btn-secondary" onclick="closePendingOrdersModal()">
                <i class="bi bi-x-circle"></i> Exit ( Esc )
            </button>
            <button type="button" class="btn btn-primary" id="generateInvoiceBtn">
                <i class="bi bi-check-circle"></i> Generate Invoice
            </button>
        </div>
    </div>
</div>

<script>
// Update day name when date changes
function updateDayName() {
    const dateInput = document.getElementById('billDate');
    const dayNameInput = document.getElementById('dayName');
    if (dateInput.value) {
        const date = new Date(dateInput.value);
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        dayNameInput.value = days[date.getDay()];
    }
}

// Current selected row index
let currentSelectedRow = null;

// S.Rate Enter key navigation to next row
document.addEventListener('DOMContentLoaded', function() {
    // Add Enter key support for Bill No and Trn No fields
    const billNoField = document.getElementById('billNo');
    const trnNoField = document.getElementById('trnNo');
    
    if (billNoField) {
        billNoField.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                fetchBillByTrnNo();
            }
        });
    }
    
    if (trnNoField) {
        trnNoField.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                fetchBillByTrnNo();
            }
        });
    }
    
    const sRateField = document.getElementById('calc_s_rate');
    if (sRateField) {
        // Save s_rate when user changes it (input/change event)
        sRateField.addEventListener('input', function(e) {
            if (currentActiveRow !== null && currentActiveRow !== undefined) {
                const sRateValue = parseFloat(e.target.value) || 0;
                // Initialize rowGstData if it doesn't exist
                if (!rowGstData[currentActiveRow]) {
                    rowGstData[currentActiveRow] = {};
                }
                // Save s_rate for this row
                rowGstData[currentActiveRow].s_rate = sRateValue;
                console.log(`S.Rate saved for row ${currentActiveRow}:`, sRateValue);
            }
        });
        
        sRateField.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                console.log('S.Rate Enter pressed');
                console.log('currentActiveRow:', currentActiveRow);
                console.log('isRowSelected before:', isRowSelected);
                
                // Save s_rate before calculating GST
                if (currentActiveRow !== null && currentActiveRow !== undefined) {
                    const sRateValue = parseFloat(e.target.value) || 0;
                    if (!rowGstData[currentActiveRow]) {
                        rowGstData[currentActiveRow] = {};
                    }
                    rowGstData[currentActiveRow].s_rate = sRateValue;
                }
                
                // Calculate and save GST amounts for current row before moving
                calculateAndSaveGstForRow(currentActiveRow);
                
                // Small delay to ensure calculation is saved
                setTimeout(() => {
                    // Select next row (full row selection with blue highlight)
                    const rows = document.querySelectorAll('#itemsTableBody tr');
                    const nextRowIndex = currentActiveRow + 1;
                    console.log('nextRowIndex:', nextRowIndex, 'Total rows:', rows.length);
                    
                    if (nextRowIndex < rows.length) {
                        // Prevent default behavior completely
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        
                        // Select next row with full row highlight (blue background)
                        selectRow(nextRowIndex);
                        
                        console.log('After moving to next row - currentActiveRow:', currentActiveRow);
                        console.log('isRowSelected:', isRowSelected);
                    } else {
                        console.log('No more rows available');
                    }
                }, 100);
            }
        });
    }
});

// Setup on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update row colors for existing rows on page load
    setTimeout(() => {
        const rows = document.querySelectorAll('#itemsTableBody tr');
        rows.forEach((row, index) => {
            updateRowColor(index);
        });
        checkAllRowsComplete();
    }, 100);
    
    // Prevent form submission on Enter key (except for Save button)
    const form = document.getElementById('purchaseForm');
    if (form) {
        form.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.type !== 'submit' && e.target.type !== 'button') {
                // Don't prevent Enter in specific cases handled by other listeners
                if (!e.target.classList.contains('item-fqty') && 
                    !e.target.classList.contains('item-dis-percent') &&
                    e.target.id !== 'calc_s_rate') {
                    // Allow default behavior for navigation
                    return true;
                }
            }
        });
    }
    
    // Auto-uppercase for Cash and Transfer fields
    ['cash', 'transfer'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }
    });
    
    // Initialize focus listeners for initial rows
    const initialRows = document.querySelectorAll('#itemsTableBody tr');
    initialRows.forEach((row, rowIndex) => {
        const inputs = row.querySelectorAll('input:not([readonly])');
        inputs.forEach(input => {
            // Add focus listener to populate calculation section
            input.addEventListener('focus', function(e) {
                currentActiveRow = rowIndex;
                isRowSelected = false;
                
                // Get item code from current row
                const itemCode = row.querySelector('input[name*="[code]"]').value;
                
                if (itemCode && itemCode.trim() !== '') {
                    // Fetch and populate item details in calculation section
                    fetchItemDetailsForCalculation(itemCode.trim(), rowIndex);
                } else {
                    // Clear calculation section if no item code
                    clearCalculationSection();
                }
            });
        });
        
        // Add amount calculation listeners for initial rows
        addAmountCalculation(row, rowIndex);
    });
    
    // Row selection for calculation section
    addRowSelectionListeners();
    
    // Arrow key navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
            const rows = document.querySelectorAll('#itemsTableBody tr');
            if (currentSelectedRow !== null) {
                if (e.key === 'ArrowUp' && currentSelectedRow > 0) {
                    selectRow(currentSelectedRow - 1);
                } else if (e.key === 'ArrowDown' && currentSelectedRow < rows.length - 1) {
                    selectRow(currentSelectedRow + 1);
                }
            }
        }
    });
});

// Add row selection listeners
function addRowSelectionListeners() {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    rows.forEach((row, index) => {
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking on pending orders modal trigger
            if (!e.target.closest('input[name*="[code]"]') && !e.target.closest('input[name*="[name]"]')) {
                selectRow(index);
            }
        });
    });
}

// Select row and populate calculation section
function selectRow(index) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    
    // Remove previous selection
    rows.forEach(r => r.classList.remove('row-selected'));
    
    // Add selection to current row
    rows[index].classList.add('row-selected');
    currentSelectedRow = index;
    isRowSelected = true;
    
    // Get item code from row
    const itemCode = rows[index].querySelector('input[name*="[code]"]').value;
    
    if (itemCode && itemCode.trim() !== '') {
        // Fetch item details and populate calculation section with saved GST amounts
        fetchItemDetailsForCalculation(itemCode.trim(), index);
    } else {
        clearCalculationSection();
    }
}

// Fetch item details from database
function fetchItemDetails(itemCode) {
    fetch(`/admin/items/get-by-code/${itemCode}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.item) {
                populateCalculationSection(data.item);
            } else {
                clearCalculationSection();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            clearCalculationSection();
        });
}

// Fetch item details for calculation section (when focusing on any cell in row)
function fetchItemDetailsForCalculation(itemCode, rowIndex) {
    fetch(`/admin/items/get-by-code/${itemCode}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.item) {
                populateCalculationSectionForRow(data.item, rowIndex);
            } else {
                clearCalculationSection();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            clearCalculationSection();
        });
}

// Populate calculation section with item data
function populateCalculationSection(item) {
    const row = document.querySelectorAll('#itemsTableBody tr')[currentSelectedRow];
    const amount = parseFloat(row.querySelector('input[name*="[amount]"]').value) || 0;
    
    // Populate fields
    document.getElementById('calc_hsn_display').value = item.hsn_code || '---';
    document.getElementById('calc_cgst').value = item.cgst_percent || 0;
    document.getElementById('calc_sgst').value = item.sgst_percent || 0;
    document.getElementById('calc_cess').value = item.cess_percent || 0;
    
    document.getElementById('calc_sc_percent').value = item.fixed_dis_percent || 0;
    document.getElementById('calc_spl_rate').value = item.spl_rate || 0;
    document.getElementById('calc_ws_rate').value = item.ws_rate || 0;
    document.getElementById('calc_tax_percent').value = (parseFloat(item.cgst_percent || 0) + parseFloat(item.sgst_percent || 0)).toFixed(2);
    document.getElementById('calc_excise').value = 0;
    document.getElementById('calc_mrp').value = item.mrp || 0;
    document.getElementById('calc_s_rate').value = item.s_rate || 0;
    
    // Calculate GST amounts
    const cgstPercent = parseFloat(item.cgst_percent) || 0;
    const sgstPercent = parseFloat(item.sgst_percent) || 0;
    const cessPercent = parseFloat(item.cess_percent) || 0;
    
    const cgstAmount = (amount * cgstPercent / 100).toFixed(2);
    const sgstAmount = (amount * sgstPercent / 100).toFixed(2);
    const cessAmount = (amount * cessPercent / 100).toFixed(2);
    
    document.getElementById('calc_cgst_amount').textContent = cgstAmount;
    document.getElementById('calc_sgst_amount').textContent = sgstAmount;
    document.getElementById('calc_cess_amount').textContent = cessAmount;
}

// Store calculated GST amounts for each row
const rowGstData = {};

// Store complete row data (for detailed info section)
const rowDetailedData = {};

// Populate calculation section for specific row (when focusing on any cell)
function populateCalculationSectionForRow(item, rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (!row) return;
    
    const amount = parseFloat(row.querySelector('input[name*="[amount]"').value) || 0;
    
    // Populate HSN Code and GST details (percentages always show)
    document.getElementById('calc_hsn_display').value = item.hsn_code || '---';
    document.getElementById('calc_cgst').value = item.cgst_percent || 0;
    document.getElementById('calc_sgst').value = item.sgst_percent || 0;
    document.getElementById('calc_cess').value = item.cess_percent || 0;
    
    // Populate rate fields
    document.getElementById('calc_sc_percent').value = parseFloat(item.fixed_dis_percent || 0).toFixed(3);
    document.getElementById('calc_spl_rate').value = parseFloat(item.spl_rate || 0).toFixed(2);
    document.getElementById('calc_ws_rate').value = parseFloat(item.ws_rate || 0).toFixed(2);
    document.getElementById('calc_tax_percent').value = (parseFloat(item.cgst_percent || 0) + parseFloat(item.sgst_percent || 0)).toFixed(3);
    document.getElementById('calc_excise').value = '0.00';
    document.getElementById('calc_mrp').value = parseFloat(item.mrp || 0).toFixed(2);
    
    // Check if this row has a saved s_rate (user-modified), otherwise use item's s_rate
    let sRateValue = parseFloat(item.s_rate || 0);
    if (rowGstData[rowIndex] && rowGstData[rowIndex].s_rate !== undefined) {
        sRateValue = rowGstData[rowIndex].s_rate;
    }
    document.getElementById('calc_s_rate').value = sRateValue.toFixed(2);
    
    // Save s_rate to rowGstData if not already saved
    if (!rowGstData[rowIndex]) {
        rowGstData[rowIndex] = {};
    }
    if (rowGstData[rowIndex].s_rate === undefined) {
        rowGstData[rowIndex].s_rate = sRateValue;
    }
    
    // Check if this row has saved GST calculations
    if (rowGstData[rowIndex] && rowGstData[rowIndex].calculated) {
        // Show saved calculated GST amounts
        document.getElementById('calc_cgst_amount').textContent = rowGstData[rowIndex].cgstAmount;
        document.getElementById('calc_sgst_amount').textContent = rowGstData[rowIndex].sgstAmount;
        document.getElementById('calc_cess_amount').textContent = rowGstData[rowIndex].cessAmount;
    } else {
        // Don't calculate yet - show 0.00 (will calculate after S.Rate is filled)
        document.getElementById('calc_cgst_amount').textContent = '0.00';
        document.getElementById('calc_sgst_amount').textContent = '0.00';
        document.getElementById('calc_cess_amount').textContent = '0.00';
    }
    
    // Populate Inc. field (inclusive flag)
    document.getElementById('calc_inc').value = item.inclusive_flag || 'Y';
    
    // Populate Less field (if available)
    document.getElementById('calc_less').value = '0.00';
    
    // Populate Detailed Info Section
    populateDetailedInfoSection(item, rowIndex);
    
    // Update Summary Section
    updateSummarySection();
}

// Calculate and save GST amounts for current row (called after S.Rate is filled)
function calculateAndSaveGstForRow(rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (!row) return;
    
    const amount = parseFloat(row.querySelector('input[name*="[amount]"').value) || 0;
    const itemCode = row.querySelector('input[name*="[code]"').value;
    
    if (!itemCode || amount === 0) {
        console.log(`Row ${rowIndex}: No item code or amount is 0`);
        return;
    }
    
    console.log(`Calculating GST for row ${rowIndex}, amount: ${amount}, itemCode: ${itemCode}`);
    
    // Fetch item to get GST percentages
    fetch(`/admin/items/get-by-code/${itemCode}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.item) {
                const cgstPercent = parseFloat(data.item.cgst_percent) || 0;
                const sgstPercent = parseFloat(data.item.sgst_percent) || 0;
                const cessPercent = parseFloat(data.item.cess_percent) || 0;
                
                const cgstAmount = (amount * cgstPercent / 100).toFixed(2);
                const sgstAmount = (amount * sgstPercent / 100).toFixed(2);
                const cessAmount = (amount * cessPercent / 100).toFixed(2);
                const taxAmount = (parseFloat(cgstAmount) + parseFloat(sgstAmount) + parseFloat(cessAmount)).toFixed(2);
                const netAmount = (parseFloat(amount) + parseFloat(taxAmount)).toFixed(2);
                
                // Calculate Cost and Cost+GST
                const qty = parseFloat(row.querySelector('input[name*="[qty]"').value) || 1;
                const cost = qty > 0 ? (amount / qty).toFixed(2) : '0.00';
                const costGst = qty > 0 ? (netAmount / qty).toFixed(2) : '0.00';
                
                // Save calculated amounts for this row
                rowGstData[rowIndex] = {
                    calculated: true,
                    cgstAmount: cgstAmount,
                    sgstAmount: sgstAmount,
                    cessAmount: cessAmount,
                    taxAmount: taxAmount,
                    netAmount: netAmount,
                    amount: amount,
                    cgstPercent: cgstPercent,
                    sgstPercent: sgstPercent,
                    cessPercent: cessPercent,
                    cost: cost,
                    costGst: costGst
                };
                
                console.log(`✅ GST calculated and saved for row ${rowIndex}:`, rowGstData[rowIndex]);
                
                // Update display immediately if this is the current active row
                if (currentActiveRow === rowIndex) {
                    document.getElementById('calc_cgst_amount').textContent = cgstAmount;
                    document.getElementById('calc_sgst_amount').textContent = sgstAmount;
                    document.getElementById('calc_cess_amount').textContent = cessAmount;
                    console.log(`✅ Display updated for row ${rowIndex}`);
                    
                    // Update detailed info section with calculated values
                    updateDetailedInfoWithCalculatedData(rowIndex);
                }
                
                // Update row color based on calculation status
                updateRowColor(rowIndex);
                
                // Check if all rows are complete and update accordingly
                checkAllRowsComplete();
                
                // Update summary section
                updateSummarySection();
            }
        })
        .catch(error => {
            console.error('Error calculating GST:', error);
        });
}

// Clear calculation section
function clearCalculationSection() {
    document.getElementById('calc_hsn_display').value = '---';
    document.getElementById('calc_cgst').value = '0';
    document.getElementById('calc_sgst').value = '0';
    document.getElementById('calc_cess').value = '0';
    
    document.getElementById('calc_sc_percent').value = '0.000';
    document.getElementById('calc_spl_rate').value = '0.00';
    document.getElementById('calc_ws_rate').value = '0.00';
    document.getElementById('calc_tax_percent').value = '0.000';
    document.getElementById('calc_excise').value = '0.00';
    document.getElementById('calc_mrp').value = '0.00';
    document.getElementById('calc_s_rate').value = '0.00';
    
    document.getElementById('calc_cgst_amount').textContent = '0.00';
    document.getElementById('calc_sgst_amount').textContent = '0.00';
    document.getElementById('calc_cess_amount').textContent = '0.00';
    
    // Clear detailed info section
    clearDetailedInfoSection();
}

// Populate Detailed Info Section with item data
function populateDetailedInfoSection(item, rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (!row) return;
    
    // Get current row data
    const amount = parseFloat(row.querySelector('input[name*="[amount]"').value) || 0;
    const qty = parseFloat(row.querySelector('input[name*="[qty]"').value) || 1;
    
    // Populate basic fields (always show)
    document.getElementById('unit').value = item.unit || '1';
    document.getElementById('pack_detail').value = item.packing || '1*10';
    document.getElementById('comp').value = item.company?.short_name || item.company?.name || 'N/A';
    document.getElementById('cl_qty').value = qty || '0';
    
    // Check if row has complete calculated data
    if (rowGstData[rowIndex] && rowGstData[rowIndex].calculated) {
        // Show all calculated values
        document.getElementById('nt_amt_detail').value = rowGstData[rowIndex].amount;
        document.getElementById('tax_amt_detail').value = rowGstData[rowIndex].taxAmount;
        document.getElementById('net_amt_detail').value = rowGstData[rowIndex].netAmount;
        document.getElementById('cost').value = rowGstData[rowIndex].cost;
        document.getElementById('cost_gst').value = rowGstData[rowIndex].costGst;
        
        // Show other calculated fields
        document.getElementById('scm_amt_detail').value = '0.00';
        document.getElementById('sc_amt_detail').value = '0.00';
        document.getElementById('dis1_amt_detail').value = '0.00';
        document.getElementById('dis_amt_detail').value = '0.00';
        document.getElementById('less_detail').value = '0.00';
        document.getElementById('hs_amt').value = '0.00';
        document.getElementById('gross_amt').value = rowGstData[rowIndex].amount;
    } else {
        // Show only NT Amount and basic data (row not complete yet)
        document.getElementById('nt_amt_detail').value = amount.toFixed(2);
        document.getElementById('tax_amt_detail').value = '0.00';
        document.getElementById('net_amt_detail').value = '0.00';
        document.getElementById('cost').value = '0.00';
        document.getElementById('cost_gst').value = '0.00';
        document.getElementById('scm_amt_detail').value = '0.00';
        document.getElementById('sc_amt_detail').value = '0.00';
        document.getElementById('dis1_amt_detail').value = '0.00';
        document.getElementById('dis_amt_detail').value = '0.00';
        document.getElementById('less_detail').value = '0.00';
        document.getElementById('hs_amt').value = '0.00';
        document.getElementById('gross_amt').value = amount.toFixed(2);
    }
}

// Update detailed info section with calculated data (after S.Rate is filled)
function updateDetailedInfoWithCalculatedData(rowIndex) {
    if (rowGstData[rowIndex] && rowGstData[rowIndex].calculated) {
        document.getElementById('nt_amt_detail').value = rowGstData[rowIndex].amount;
        document.getElementById('tax_amt_detail').value = rowGstData[rowIndex].taxAmount;
        document.getElementById('net_amt_detail').value = rowGstData[rowIndex].netAmount;
        document.getElementById('cost').value = rowGstData[rowIndex].cost;
        document.getElementById('cost_gst').value = rowGstData[rowIndex].costGst;
        document.getElementById('gross_amt').value = rowGstData[rowIndex].amount;
    }
}

// Clear Detailed Info Section
function clearDetailedInfoSection() {
    document.getElementById('unit').value = '1';
    document.getElementById('nt_amt_detail').value = '0.00';
    document.getElementById('scm_amt_detail').value = '0.00';
    document.getElementById('tax_amt_detail').value = '0.00';
    document.getElementById('cost').value = '0.00';
    document.getElementById('lctn').value = '';
    document.getElementById('sc_amt_detail').value = '0.00';
    document.getElementById('dis1_amt_detail').value = '0.00';
    document.getElementById('net_amt_detail').value = '0.00';
    document.getElementById('cost_gst').value = '0.00';
    document.getElementById('cl_qty').value = '0';
    document.getElementById('dis_amt_detail').value = '0.00';
    document.getElementById('less_detail').value = '0.00';
    document.getElementById('comp').value = '';
    document.getElementById('vol').value = '0';
    document.getElementById('pack_detail').value = '1*10';
    document.getElementById('hs_amt').value = '0.00';
    document.getElementById('gross_amt').value = '0.00';
}

// Update Summary Section (accumulate all rows)
function updateSummarySection() {
    let totalNtAmt = 0;
    let totalTaxAmt = 0;
    let totalNetAmt = 0;
    let totalInvAmt = 0;
    
    // Loop through all rows and sum up calculated values
    const rows = document.querySelectorAll('#itemsTableBody tr');
    rows.forEach((row, index) => {
        if (rowGstData[index] && rowGstData[index].calculated) {
            totalNtAmt += parseFloat(rowGstData[index].amount) || 0;
            totalTaxAmt += parseFloat(rowGstData[index].taxAmount) || 0;
            totalNetAmt += parseFloat(rowGstData[index].netAmount) || 0;
            totalInvAmt += parseFloat(rowGstData[index].netAmount) || 0;
        }
    });
    
    // Update summary fields
    document.getElementById('nt_amt').value = totalNtAmt.toFixed(2);
    document.getElementById('tax_amt').value = totalTaxAmt.toFixed(2);
    document.getElementById('net_amt').value = totalNetAmt.toFixed(2);
    document.getElementById('inv_amt').value = totalInvAmt.toFixed(2);
    
    // Update other summary fields (default to 0 for now)
    document.getElementById('sc_amt').value = '0.00';
    document.getElementById('scm_amt').value = '0.00';
    document.getElementById('dis_amt').value = '0.00';
    document.getElementById('less_amt').value = '0.00';
    document.getElementById('scm_percent').value = '0.00';
    document.getElementById('tcs_amt').value = '0.00';
    document.getElementById('dis1_amt').value = '0.00';
    document.getElementById('tof_amt').value = '0.00';
}

// Load pending orders from supplier
function loadPendingOrders(supplierId) {
    fetch(`/admin/suppliers/${supplierId}/pending-orders-data`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayPendingOrders(data.orders);
                // Show modal
                showPendingOrdersModal();
            } else {
                alert('No pending orders found for this supplier');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading pending orders');
        });
}

// Helper function to position modal in content area (not over sidebar)
function positionModalInContentArea(modalElement) {
    if (!modalElement) return;
    
    // Calculate sidebar width dynamically
    const sidebar = document.querySelector('.sidebar');
    let sidebarWidth = 260; // Default sidebar width
    if (sidebar) {
        sidebarWidth = sidebar.offsetWidth;
    }
    
    // Adjust modal position to center in content area (not viewport)
    // Content area starts after sidebar, so we need to shift modal right by half sidebar width
    const leftOffset = sidebarWidth / 2;
    modalElement.style.left = `calc(50% + ${leftOffset}px)`;
}

// Show pending orders modal (internal function)
function showPendingOrdersModal() {
    const modal = document.getElementById('pendingOrdersModal');
    const backdrop = document.getElementById('pendingOrdersBackdrop');
    
    if (!modal || !backdrop) return;
    
    // Position modal in content area
    positionModalInContentArea(modal);
    
    backdrop.style.display = 'block';
    modal.style.display = 'block';
    
    setTimeout(() => {
        backdrop.classList.add('show');
        modal.classList.add('show');
    }, 10);
}

// Open pending orders modal (called from Insert Orders button)
function openPendingOrdersModal() {
    const supplierId = document.getElementById('supplierSelect').value;
    
    if (!supplierId) {
        alert('Please select a supplier first!');
        return;
    }
    
    // Load pending orders for selected supplier
    loadPendingOrders(supplierId);
}

// Close pending orders modal
function closePendingOrdersModal() {
    const modal = document.getElementById('pendingOrdersModal');
    const backdrop = document.getElementById('pendingOrdersBackdrop');
    
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    setTimeout(() => {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
    }, 300);
}

// Close modal on backdrop click
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'pendingOrdersBackdrop') {
        closePendingOrdersModal();
    }
    if (e.target && e.target.id === 'mrpDetailsBackdrop') {
        closeMrpDetailsModal();
    }
});

// Global variable to track current active row
let currentActiveRow = 0;
let currentItemData = null;
let isRowSelected = false; // Track if entire row is selected vs cell focus

// Global variable to store current transaction ID (for update mode)
let currentTransactionId = null;

// Open MRP Details Modal
function openMrpDetailsModal() {
    const modal = document.getElementById('mrpDetailsModal');
    const backdrop = document.getElementById('mrpDetailsBackdrop');
    
    if (!modal || !backdrop) return;
    
    // Position modal in content area
    positionModalInContentArea(modal);
    
    backdrop.style.display = 'block';
    modal.style.display = 'block';
    
    setTimeout(() => {
        backdrop.classList.add('show');
        modal.classList.add('show');
        // Focus on MRP input
        document.getElementById('mrp_value').focus();
        document.getElementById('mrp_value').select();
    }, 10);
}

// Close MRP Details Modal
function closeMrpDetailsModal() {
    const modal = document.getElementById('mrpDetailsModal');
    const backdrop = document.getElementById('mrpDetailsBackdrop');
    
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    setTimeout(() => {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
    }, 300);
}

// Open empty MRP modal with default values
function openEmptyMrpModal() {
    currentItemData = null;
    
    document.getElementById('mrp_item_name').textContent = '---';
    document.getElementById('mrp_pack').textContent = '---';
    document.getElementById('mrp_case').value = 0;
    document.getElementById('mrp_box').value = 0;
    document.getElementById('mrp_value').value = 0;
    document.getElementById('mrp_pur_rate').value = 0;
    document.getElementById('mrp_sale_rate').value = 0;
    document.getElementById('mrp_ws_rate').value = 0;
    document.getElementById('mrp_spl_rate').value = 0;
    document.getElementById('mrp_excise').value = 0;
    
    console.log('Opening empty MRP modal...');
    openMrpDetailsModal();
}

// Populate MRP modal with item data
function populateMrpModal(itemCode) {
    console.log('populateMrpModal called with itemCode:', itemCode);
    
    fetch(`/admin/items/get-by-code/${itemCode}`)
        .then(response => response.json())
        .then(data => {
            console.log('Item data received:', data);
            if (data.success && data.item) {
                currentItemData = data.item;
                
                document.getElementById('mrp_item_name').textContent = data.item.name || '---';
                document.getElementById('mrp_pack').textContent = data.item.packing || '---';
                document.getElementById('mrp_case').value = data.item.case_qty || 0;
                document.getElementById('mrp_box').value = data.item.box_qty || 0;
                document.getElementById('mrp_value').value = data.item.mrp || 0;
                document.getElementById('mrp_pur_rate').value = data.item.pur_rate || 0;
                document.getElementById('mrp_sale_rate').value = data.item.s_rate || 0;
                document.getElementById('mrp_ws_rate').value = data.item.ws_rate || 0;
                document.getElementById('mrp_spl_rate').value = data.item.spl_rate || 0;
                document.getElementById('mrp_excise').value = 0;
                
                console.log('Opening MRP modal...');
                openMrpDetailsModal();
            } else {
                console.log('Item not found, opening empty modal');
                openEmptyMrpModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            console.log('Error loading item, opening empty modal');
            openEmptyMrpModal();
        });
}

// Save MRP details and focus on Purchase Rate
document.getElementById('saveMrpDetailsBtn').addEventListener('click', function() {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const currentRow = rows[currentActiveRow];
    
    // Update current row with MRP and Purchase Rate
    const mrp = document.getElementById('mrp_value').value || 0;
    const purRate = document.getElementById('mrp_pur_rate').value || 0;
    
    currentRow.querySelector('input[name*="[mrp]"]').value = mrp;
    currentRow.querySelector('input[name*="[pur_rate]"]').value = purRate;
    
    // Recalculate amount
    const qty = parseFloat(currentRow.querySelector('input[name*="[qty]"]').value) || 0;
    const disPercent = parseFloat(currentRow.querySelector('input[name*="[dis_percent]"]').value) || 0;
    let amount = qty * parseFloat(purRate || 0);
    if (disPercent > 0) {
        amount = amount - (amount * disPercent / 100);
    }
    currentRow.querySelector('input[name*="[amount]"]').value = amount > 0 ? amount.toFixed(2) : '';
    
    closeMrpDetailsModal();
    
    // Focus on Purchase Rate field
    const purRateInput = currentRow.querySelector('input[name*="[pur_rate]"]');
    if (purRateInput) {
        setTimeout(() => {
            purRateInput.focus();
            purRateInput.select();
        }, 100);
    }
});

// Enable specific row for editing
function enableRow(rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (row) {
        const inputs = row.querySelectorAll('input:not([readonly])');
        inputs.forEach(input => {
            input.removeAttribute('disabled');
        });
    }
}

// Disable all rows except specified
function disableAllRowsExcept(rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    rows.forEach((row, index) => {
        if (index !== rowIndex) {
            const inputs = row.querySelectorAll('input:not([readonly])');
            inputs.forEach(input => {
                input.setAttribute('disabled', 'disabled');
            });
        }
    });
}

// Select entire row (highlight without focusing any cell)
function selectRow(rowIndex) {
    console.log('selectRow called for:', rowIndex);
    const rows = document.querySelectorAll('#itemsTableBody tr');
    
    // Remove selection from all rows
    rows.forEach(r => r.classList.remove('row-selected'));
    
    // Select the target row
    if (rows[rowIndex]) {
        rows[rowIndex].classList.add('row-selected');
        currentActiveRow = rowIndex;
        isRowSelected = true;
        
        console.log('Row selected, isRowSelected set to:', isRowSelected);
        
        // Scroll into view without smooth behavior to avoid focus issues
        rows[rowIndex].scrollIntoView({ block: 'nearest', behavior: 'auto' });
        
        // Remove focus from any active element
        if (document.activeElement) {
            document.activeElement.blur();
        }
        
        // Populate Calculation and Detailed Info sections for this row
        const itemCode = rows[rowIndex].querySelector('input[name*="[code]"]').value;
        
        if (itemCode && itemCode.trim() !== '') {
            // Fetch item details and populate both sections
            fetchItemDetailsForCalculation(itemCode.trim(), rowIndex);
        } else {
            // Clear sections if no item code
            clearCalculationSection();
        }
    }
}

// Focus first input of row (removes row selection, focuses cell)
function focusFirstInput(rowIndex) {
    console.log('focusFirstInput called for row:', rowIndex);
    console.trace('Call stack:');
    
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    // Remove row selection
    rows.forEach(r => r.classList.remove('row-selected'));
    isRowSelected = false;
    
    if (row) {
        const firstInput = row.querySelector('input:not([readonly]):not([disabled])');
        if (firstInput) {
            currentActiveRow = rowIndex;
            firstInput.focus();
            firstInput.select();
        }
    }
}

// Global keyboard listener for row selection mode
document.addEventListener('keydown', function(e) {
    // Only handle if row is selected (not in cell edit mode)
    if (isRowSelected) {
        const rows = document.querySelectorAll('#itemsTableBody tr');
        
        if (e.key === 'Enter') {
            e.preventDefault();
            // Enter key - focus first cell of selected row
            focusFirstInput(currentActiveRow);
        }
        else if (e.key === 'ArrowDown') {
            e.preventDefault();
            // Move to next row
            const nextRowIndex = currentActiveRow + 1;
            if (nextRowIndex < rows.length) {
                selectRow(nextRowIndex);
            }
        }
        else if (e.key === 'ArrowUp') {
            e.preventDefault();
            // Move to previous row
            const prevRowIndex = currentActiveRow - 1;
            if (prevRowIndex >= 0) {
                selectRow(prevRowIndex);
            }
        }
    }
    
    // Close modal on Esc key
    if (e.key === 'Escape') {
        const modal = document.getElementById('pendingOrdersModal');
        if (modal && modal.classList.contains('show')) {
            closePendingOrdersModal();
        }
        const mrpModal = document.getElementById('mrpDetailsModal');
        if (mrpModal && mrpModal.classList.contains('show')) {
            closeMrpDetailsModal();
        }
    }
});

// Display pending orders in modal
function displayPendingOrders(orders) {
    const tbody = document.getElementById('pendingOrdersBody');
    tbody.innerHTML = '';
    
    if (orders.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No pending orders found</td></tr>';
        return;
    }
    
    orders.forEach((order, index) => {
        const row = document.createElement('tr');
        row.style.cursor = 'pointer';
        row.setAttribute('data-order-no', order.order_no);
        
        // Highlight on click
        row.addEventListener('click', function() {
            tbody.querySelectorAll('tr').forEach(r => r.classList.remove('table-primary'));
            this.classList.add('table-primary');
        });
        
        row.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td class="text-center">${order.item_code || '---'}</td>
            <td>${order.item_name || '---'}</td>
            <td class="text-center">${order.order_qty || 0}</td>
            <td class="text-center">${order.order_date || '---'}</td>
            <td class="text-center">${order.order_no || '---'}</td>
        `;
        
        tbody.appendChild(row);
    });
}

// Generate Invoice button
document.getElementById('generateInvoiceBtn').addEventListener('click', function() {
    const selectedRow = document.querySelector('#pendingOrdersBody tr.table-primary');
    
    if (!selectedRow) {
        alert('Please select an order first!');
        return;
    }
    
    const orderNo = selectedRow.getAttribute('data-order-no');
    
    if (confirm(`Generate invoice for Order No: ${orderNo}?`)) {
        // Load order items
        loadOrderItems(orderNo);
    }
});

// Load order items and populate table
function loadOrderItems(orderNo) {
    const supplierId = document.getElementById('supplierSelect').value;
    
    fetch(`/admin/suppliers/${supplierId}/pending-orders/${orderNo}/items`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateItemsTable(data.items);
                
                // Close modal
                closePendingOrdersModal();
                
                // Focus on first cell
                setTimeout(() => {
                    const firstInput = document.querySelector('#itemsTableBody tr:first-child input');
                    if (firstInput) {
                        firstInput.focus();
                        firstInput.select();
                    }
                }, 300);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading order items');
        });
}

// Populate items table
function populateItemsTable(items) {
    const tbody = document.getElementById('itemsTableBody');
    tbody.innerHTML = '';
    
    // Ensure minimum 10 rows
    const minRows = 10;
    const totalRows = Math.max(items.length, minRows);
    
    for (let index = 0; index < totalRows; index++) {
        const item = items[index] || {}; // Empty object if no item data
        
        // Calculate amount: pur_rate * qty
        const qty = parseFloat(item.order_qty) || 0;
        const purRate = parseFloat(item.pur_rate) || 0;
        const amount = (qty * purRate).toFixed(2);
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" class="form-control" name="items[${index}][code]" value="${item.item_code || ''}" tabindex="${index * 10 + 1}" autocomplete="off"></td>
            <td><input type="text" class="form-control" name="items[${index}][name]" value="${item.item_name || ''}" tabindex="${index * 10 + 2}" autocomplete="off"></td>
            <td><input type="text" class="form-control" name="items[${index}][batch]" tabindex="${index * 10 + 3}" autocomplete="off"></td>
            <td><input type="text" class="form-control" name="items[${index}][exp]" tabindex="${index * 10 + 4}" autocomplete="off"></td>
            <td><input type="number" class="form-control item-qty" name="items[${index}][qty]" value="${item.order_qty || ''}" tabindex="${index * 10 + 5}" autocomplete="off" data-row="${index}"></td>
            <td><input type="number" class="form-control item-fqty" name="items[${index}][free_qty]" value="${item.free_qty || ''}" tabindex="${index * 10 + 6}" autocomplete="off" data-row="${index}"></td>
            <td><input type="number" class="form-control item-pur-rate" name="items[${index}][pur_rate]" value="${item.pur_rate || ''}" step="0.01" tabindex="${index * 10 + 7}" autocomplete="off" data-row="${index}"></td>
            <td><input type="number" class="form-control item-dis-percent" name="items[${index}][dis_percent]" step="0.01" tabindex="${index * 10 + 8}" autocomplete="off" data-row="${index}"></td>
            <td><input type="number" class="form-control" name="items[${index}][mrp]" value="${item.mrp || ''}" step="0.01" tabindex="${index * 10 + 9}" autocomplete="off"></td>
            <td><input type="number" class="form-control readonly-field item-amount" name="items[${index}][amount]" value="${amount || ''}" readonly tabindex="-1"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-primary" onclick="openInsertItemModal(${index})" title="Insert Item" style="padding: 4px 8px; margin-right: 5px; font-weight: bold;">+</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(${index})" title="Delete Row" style="padding: 4px 8px; font-weight: bold;">×</button>
            </td>
        `;
        tbody.appendChild(row);
        
        // Add Enter key navigation for this row
        addRowNavigationWithMrpModal(row, index);
        
        // Add amount calculation listeners
        addAmountCalculation(row, index);
        
        // Add focus listeners
        const inputs = row.querySelectorAll('input:not([readonly])');
        inputs.forEach(input => {
            input.addEventListener('focus', function(e) {
                currentActiveRow = index;
                isRowSelected = false;
                
                const itemCode = row.querySelector('input[name*="[code]"]').value;
                
                if (itemCode && itemCode.trim() !== '') {
                    fetchItemDetailsForCalculation(itemCode.trim(), index);
                } else {
                    clearCalculationSection();
                }
            });
        });
        
        // Update row color initially
        updateRowColor(index);
    }
    
    // Check all rows after populating
    checkAllRowsComplete();
    
    // Set first row as selected (full row selection mode)
    currentActiveRow = 0;
    selectRow(0);
}

// Add Enter key navigation with MRP modal trigger
function addRowNavigationWithMrpModal(row, rowIndex) {
    const inputs = row.querySelectorAll('input:not([readonly])');
    
    inputs.forEach((input, colIndex) => {
        // Add focus listener to populate calculation section when entering any cell
        input.addEventListener('focus', function(e) {
            currentActiveRow = rowIndex;
            isRowSelected = false;
            
            // Get item code from current row
            const itemCode = row.querySelector('input[name*="[code]"]').value;
            
            if (itemCode && itemCode.trim() !== '') {
                // Fetch and populate item details in calculation section
                fetchItemDetailsForCalculation(itemCode.trim(), rowIndex);
            } else {
                // Clear calculation section if no item code
                clearCalculationSection();
            }
        });
        
        // Add keyboard navigation listener
        input.addEventListener('keydown', function(e) {
            // Enter key navigation
            if (e.key === 'Enter') {
                e.preventDefault();
                
                // Check if this is the F.Qty field
                if (input.classList.contains('item-fqty')) {
                    console.log('F.Qty Enter pressed, rowIndex:', rowIndex);
                    // Get item code from current row
                    const itemCode = row.querySelector('input[name*="[code]"]').value;
                    console.log('Item code:', itemCode);
                    
                    // Always open modal, even if no item code
                    currentActiveRow = rowIndex;
                    
                    if (itemCode && itemCode.trim() !== '') {
                        console.log('Calling populateMrpModal with code:', itemCode);
                        populateMrpModal(itemCode.trim());
                    } else {
                        console.log('No item code, opening empty modal');
                        // Open modal with empty/default values
                        openEmptyMrpModal();
                    }
                }
                // Check if this is the Dis% field
                else if (input.classList.contains('item-dis-percent')) {
                    console.log('Dis% Enter pressed, moving to S.Rate in calculation section');
                    console.log('Current row index:', rowIndex);
                    // Update current active row before moving to S.Rate
                    currentActiveRow = rowIndex;
                    
                    // Calculate and save GST amounts for this row
                    calculateAndSaveGstForRow(rowIndex);
                    
                    // Move to S.Rate in calculation section
                    const sRateField = document.getElementById('calc_s_rate');
                    if (sRateField) {
                        sRateField.focus();
                        sRateField.select();
                    }
                } else {
                    // Move to next input in same row
                    const nextIndex = colIndex + 1;
                    if (nextIndex < inputs.length) {
                        // Check if next input is disabled
                        if (!inputs[nextIndex].disabled) {
                            inputs[nextIndex].focus();
                            inputs[nextIndex].select();
                        }
                    }
                }
            }
            // Arrow Right - Move to next cell
            else if (e.key === 'ArrowRight') {
                e.preventDefault();
                const nextIndex = colIndex + 1;
                if (nextIndex < inputs.length) {
                    if (!inputs[nextIndex].disabled) {
                        inputs[nextIndex].focus();
                        inputs[nextIndex].select();
                    }
                }
            }
            // Arrow Left - Move to previous cell
            else if (e.key === 'ArrowLeft') {
                e.preventDefault();
                const prevIndex = colIndex - 1;
                if (prevIndex >= 0) {
                    if (!inputs[prevIndex].disabled) {
                        inputs[prevIndex].focus();
                        inputs[prevIndex].select();
                    }
                }
            }
            // Arrow Up/Down disabled in cell edit mode - only works in row selection mode
        });
        
        // Add blur event for F.Qty to trigger modal (optional - only on Tab)
        if (input.classList.contains('item-fqty')) {
            input.addEventListener('blur', function(e) {
                // Only trigger on Tab key, not on Enter
                if (e.relatedTarget && e.relatedTarget.tagName === 'INPUT') {
                    setTimeout(() => {
                        const modal = document.getElementById('mrpDetailsModal');
                        const isModalOpen = modal && modal.classList.contains('show');
                        
                        if (!isModalOpen) {
                            const itemCode = row.querySelector('input[name*="[code]"]').value;
                            if (itemCode && itemCode.trim() !== '') {
                                currentActiveRow = rowIndex;
                                console.log('F.Qty blur event, opening modal for:', itemCode);
                                populateMrpModal(itemCode.trim());
                            }
                        }
                    }, 100);
                }
            });
        }
    });
}

// Add amount calculation to row
function addAmountCalculation(row, rowIndex) {
    const qtyInput = row.querySelector('.item-qty');
    const purRateInput = row.querySelector('.item-pur-rate');
    const disPercentInput = row.querySelector('.item-dis-percent');
    const amountInput = row.querySelector('.item-amount');
    
    function calculateAmount() {
        const qty = parseFloat(qtyInput.value) || 0;
        const purRate = parseFloat(purRateInput.value) || 0;
        const disPercent = parseFloat(disPercentInput.value) || 0;
        
        // Calculate: (pur_rate * qty) - discount
        let amount = qty * purRate;
        
        // Apply discount if any
        if (disPercent > 0) {
            const discount = (amount * disPercent) / 100;
            amount = amount - discount;
        }
        
        amountInput.value = amount.toFixed(2);
        
        // Update row color based on completion status
        updateRowColor(rowIndex);
        
        // If this row was already calculated, recalculate GST with new amount
        if (rowGstData[rowIndex] && rowGstData[rowIndex].calculated) {
            const cgstPercent = rowGstData[rowIndex].cgstPercent || 0;
            const sgstPercent = rowGstData[rowIndex].sgstPercent || 0;
            const cessPercent = rowGstData[rowIndex].cessPercent || 0;
            
            const cgstAmount = (amount * cgstPercent / 100).toFixed(2);
            const sgstAmount = (amount * sgstPercent / 100).toFixed(2);
            const cessAmount = (amount * cessPercent / 100).toFixed(2);
            const taxAmount = (parseFloat(cgstAmount) + parseFloat(sgstAmount) + parseFloat(cessAmount)).toFixed(2);
            const netAmount = (parseFloat(amount) + parseFloat(taxAmount)).toFixed(2);
            
            // Recalculate Cost and Cost+GST
            const cost = qty > 0 ? (amount / qty).toFixed(2) : '0.00';
            const costGst = qty > 0 ? (netAmount / qty).toFixed(2) : '0.00';
            
            // Update saved data
            rowGstData[rowIndex].cgstAmount = cgstAmount;
            rowGstData[rowIndex].sgstAmount = sgstAmount;
            rowGstData[rowIndex].cessAmount = cessAmount;
            rowGstData[rowIndex].taxAmount = taxAmount;
            rowGstData[rowIndex].netAmount = netAmount;
            rowGstData[rowIndex].amount = amount;
            rowGstData[rowIndex].cost = cost;
            rowGstData[rowIndex].costGst = costGst;
            
            // Update display if this is the current active row
            if (currentActiveRow === rowIndex) {
                document.getElementById('calc_cgst_amount').textContent = cgstAmount;
                document.getElementById('calc_sgst_amount').textContent = sgstAmount;
                document.getElementById('calc_cess_amount').textContent = cessAmount;
                
                // Update detailed info section
                updateDetailedInfoWithCalculatedData(rowIndex);
            }
            
            // Update summary section
            updateSummarySection();
            
            // Update row color
            updateRowColor(rowIndex);
            
            console.log(`GST recalculated for row ${rowIndex} with new amount ${amount}`);
        }
    }
    
    // Add listeners
    if (qtyInput) qtyInput.addEventListener('input', calculateAmount);
    if (purRateInput) purRateInput.addEventListener('input', calculateAmount);
    if (disPercentInput) disPercentInput.addEventListener('input', calculateAmount);
}

// Check if a row is complete (has all required data and GST calculated)
function isRowComplete(rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (!row) return false;
    
    const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
    const qty = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
    const purRate = parseFloat(row.querySelector('input[name*="[pur_rate]"]')?.value) || 0;
    const amount = parseFloat(row.querySelector('input[name*="[amount]"]')?.value) || 0;
    
    // Row is complete if:
    // 1. Has item code
    // 2. Has quantity > 0
    // 3. Has purchase rate > 0
    // 4. Has amount > 0
    // 5. GST has been calculated (rowGstData exists and is calculated)
    const hasBasicData = itemCode && qty > 0 && purRate > 0 && amount > 0;
    const hasGstCalculated = rowGstData[rowIndex] && rowGstData[rowIndex].calculated;
    
    return hasBasicData && hasGstCalculated;
}

// Update row color based on completion status
function updateRowColor(rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (!row) return;
    
    // Remove existing status classes
    row.classList.remove('row-incomplete', 'row-complete');
    
    if (isRowComplete(rowIndex)) {
        row.classList.add('row-complete');
    } else {
        // Check if row has any data (incomplete)
        const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
        const qty = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
        const purRate = parseFloat(row.querySelector('input[name*="[pur_rate]"]')?.value) || 0;
        
        if (itemCode || qty > 0 || purRate > 0) {
            row.classList.add('row-incomplete');
        }
    }
}

// Check if all rows with data are complete, and turn all green if last row is complete
function checkAllRowsComplete() {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    let lastRowWithData = -1;
    let allRowsWithDataComplete = true;
    
    // Find last row with data
    for (let i = rows.length - 1; i >= 0; i--) {
        const row = rows[i];
        const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
        const qty = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
        const purRate = parseFloat(row.querySelector('input[name*="[pur_rate]"]')?.value) || 0;
        
        if (itemCode || qty > 0 || purRate > 0) {
            lastRowWithData = i;
            break;
        }
    }
    
    // If no rows with data, return
    if (lastRowWithData === -1) {
        document.getElementById('itemsTableBody').classList.remove('all-rows-complete');
        return;
    }
    
    // Check if last row with data is complete
    const lastRowComplete = isRowComplete(lastRowWithData);
    
    // Check if all rows with data are complete
    for (let i = 0; i <= lastRowWithData; i++) {
        const row = rows[i];
        const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
        const qty = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
        const purRate = parseFloat(row.querySelector('input[name*="[pur_rate]"]')?.value) || 0;
        
        if (itemCode || qty > 0 || purRate > 0) {
            if (!isRowComplete(i)) {
                allRowsWithDataComplete = false;
                break;
            }
        }
    }
    
    // If last row is complete AND all rows with data are complete, make all green
    if (lastRowComplete && allRowsWithDataComplete) {
        document.getElementById('itemsTableBody').classList.add('all-rows-complete');
        // Ensure all rows with data are marked as complete
        for (let i = 0; i <= lastRowWithData; i++) {
            const row = rows[i];
            const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
            const qty = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
            const purRate = parseFloat(row.querySelector('input[name*="[pur_rate]"]')?.value) || 0;
            
            if (itemCode || qty > 0 || purRate > 0) {
                row.classList.add('row-complete');
                row.classList.remove('row-incomplete');
            }
        }
    } else {
        document.getElementById('itemsTableBody').classList.remove('all-rows-complete');
    }
}

// Add Enter key navigation to row
function addRowNavigation(row, rowIndex) {
    const inputs = row.querySelectorAll('input:not([readonly])');
    inputs.forEach((input, colIndex) => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                
                // Move to next input
                if (colIndex < inputs.length - 1) {
                    inputs[colIndex + 1].focus();
                    inputs[colIndex + 1].select();
                } else {
                    // Last column, move to next row
                    const nextRow = row.nextElementSibling;
                    if (nextRow) {
                        const nextInput = nextRow.querySelector('input:not([readonly])');
                        if (nextInput) {
                            nextInput.focus();
                            nextInput.select();
                        }
                    }
                }
            }
        });
    });
}

// Save button click handler
function savePurchase() {
    // 1. Collect Header Data
    const headerData = {
        bill_date: document.getElementById('billDate').value,
        supplier_id: document.getElementById('supplierSelect').value,
        bill_no: document.getElementById('billNo').value,
        // trn_no will be auto-generated by backend
        receive_date: document.getElementById('receiveDate').value,
        cash_flag: document.getElementById('cash').value,
        transfer_flag: document.getElementById('transfer').value,
        remarks: document.getElementById('remarks').value,
        due_date: document.getElementById('dueDate').value,
        
        // Summary amounts
        nt_amount: document.getElementById('nt_amt').value || 0,
        sc_amount: document.getElementById('sc_amt').value || 0,
        scm_amount: document.getElementById('scm_amt').value || 0,
        dis_amount: document.getElementById('dis_amt').value || 0,
        less_amount: document.getElementById('less_amt').value || 0,
        tax_amount: document.getElementById('tax_amt').value || 0,
        net_amount: document.getElementById('net_amt').value || 0,
        scm_percent: document.getElementById('scm_percent').value || 0,
        tcs_amount: document.getElementById('tcs_amt').value || 0,
        dis1_amount: document.getElementById('dis1_amt').value || 0,
        tof_amt: document.getElementById('tof_amt').value || 0,
        inv_amount: document.getElementById('inv_amt').value || 0
    };
    
    // Validate required fields
    if (!headerData.bill_date) {
        alert('⚠️ Please select Bill Date');
        return;
    }
    
    if (!headerData.supplier_id) {
        alert('⚠️ Please select Supplier');
        return;
    }
    
    if (!headerData.bill_no || headerData.bill_no.trim() === '') {
        alert('⚠️ Bill No. is required!\n\nPlease enter Bill No. before saving.');
        document.getElementById('billNo').focus();
        return;
    }
    
    // 2. Collect Items Data (only rows with ACTUAL data)
    const items = [];
    const rows = document.querySelectorAll('#itemsTableBody tr');
    
    rows.forEach((row, index) => {
        const itemCode = row.querySelector(`input[name="items[${index}][code]"]`)?.value?.trim();
        const itemName = row.querySelector(`input[name="items[${index}][name]"]`)?.value?.trim();
        const qty = parseFloat(row.querySelector(`input[name="items[${index}][qty]"]`)?.value) || 0;
        const purRate = parseFloat(row.querySelector(`input[name="items[${index}][pur_rate]"]`)?.value) || 0;
        
        // Only add rows that have meaningful data
        // Must have: (item_code OR item_name) AND (qty > 0 OR pur_rate > 0)
        const hasItemInfo = itemCode || itemName;
        const hasQuantityOrRate = qty > 0 || purRate > 0;
        
        if (hasItemInfo && hasQuantityOrRate) {
            // Get calculated data from rowGstData
            const calculatedData = rowGstData[index] || {};
            
            items.push({
                item_code: itemCode || '',
                item_name: itemName || '',
                batch_no: row.querySelector(`input[name="items[${index}][batch]"]`)?.value?.trim() || '',
                expiry_date: row.querySelector(`input[name="items[${index}][exp]"]`)?.value || null,
                qty: qty,
                free_qty: parseFloat(row.querySelector(`input[name="items[${index}][free_qty]"]`)?.value) || 0,
                pur_rate: purRate,
                dis_percent: parseFloat(row.querySelector(`input[name="items[${index}][dis_percent]"]`)?.value) || 0,
                mrp: parseFloat(row.querySelector(`input[name="items[${index}][mrp]"]`)?.value) || 0,
                amount: parseFloat(row.querySelector(`input[name="items[${index}][amount]"]`)?.value) || 0,
                
                // S.Rate from rowGstData (user-modified or from item)
                s_rate: calculatedData.s_rate !== undefined ? calculatedData.s_rate : 0,
                
                // Calculated GST data
                cgst_percent: calculatedData.cgstPercent || 0,
                sgst_percent: calculatedData.sgstPercent || 0,
                cess_percent: calculatedData.cessPercent || 0,
                cgst_amount: calculatedData.cgstAmount || 0,
                sgst_amount: calculatedData.sgstAmount || 0,
                cess_amount: calculatedData.cessAmount || 0,
                tax_amount: calculatedData.taxAmount || 0,
                net_amount: calculatedData.netAmount || 0,
                cost: calculatedData.cost || 0,
                cost_gst: calculatedData.costGst || 0,
                
                row_order: index
            });
        }
    });
    
    console.log('Total rows:', rows.length, 'Valid items:', items.length);
    
    // Validate items
    if (items.length === 0) {
        alert('⚠️ Please add at least one item with quantity and rate.\n\nUse "Add Row" button to add items.');
        return;
    }
    
    // 3. Prepare final payload
    const payload = {
        header: headerData,
        items: items
    };
    
    console.log('=== SAVING PURCHASE TRANSACTION ===');
    console.log('Current Transaction ID:', currentTransactionId);
    console.log('Header Data:', headerData);
    console.log('Items Count:', items.length);
    console.log('Items Data:', items);
    console.log('Full Payload:', payload);
    console.log('===================================');
    
    // 4. Determine if this is UPDATE or CREATE
    const isUpdate = currentTransactionId !== null && currentTransactionId !== undefined;
    const url = isUpdate 
        ? `/admin/purchase/transactions/${currentTransactionId}`
        : '/admin/purchase/transaction/store';
    const method = isUpdate ? 'PUT' : 'POST';
    
    console.log(`Using ${isUpdate ? 'UPDATE' : 'CREATE'} mode:`, url, method);
    
    // Send to backend
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(async response => {
        const text = await response.text();
        console.log('Raw response:', text);
        
        try {
            const data = JSON.parse(text);
            if (!response.ok) {
                return Promise.reject(data);
            }
            return data;
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Response text:', text);
            return Promise.reject({ message: 'Invalid JSON response: ' + text.substring(0, 200) });
        }
    })
    .then(data => {
        if (data.success) {
            const action = isUpdate ? 'updated' : 'saved';
            alert(`✅ Purchase Transaction ${action} successfully!\n\nTransaction No: ${data.trn_no || headerData.trn_no || 'N/A'}\nBill No: ${data.bill_no || headerData.bill_no}`);
            // Reload the page to start fresh
            window.location.reload();
        } else {
            // Check if it's a duplicate bill no error (only for CREATE mode)
            if (!isUpdate && data.error === 'DUPLICATE_BILL_NO' && data.existing_transaction) {
                const existing = data.existing_transaction;
                const confirmMsg = `⚠️ RECORD ALREADY EXISTS!\n\n` +
                    `Bill No: ${existing.bill_no}\n` +
                    `Transaction No: ${existing.trn_no}\n` +
                    `Bill Date: ${existing.bill_date}\n\n` +
                    `${data.suggestion}\n\n` +
                    `Click OK to open Modification page, or Cancel to stay here.`;
                
                if (confirm(confirmMsg)) {
                    // Redirect to modification page with transaction ID
                    window.location.href = `/admin/purchase/transactions/${existing.id}/edit`;
                }
            } else {
                // Show detailed error for other errors
                let errorMsg = `❌ Error ${isUpdate ? 'updating' : 'saving'} purchase transaction:\n\n`;
                errorMsg += 'Message: ' + (data.message || data.error || 'Unknown error') + '\n';
                if (data.file) errorMsg += 'File: ' + data.file + '\n';
                if (data.line) errorMsg += 'Line: ' + data.line + '\n';
                if (data.trace) errorMsg += 'Trace: ' + data.trace + '\n';
                
                console.error('Full error:', data);
                alert(errorMsg);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ An error occurred while saving the purchase transaction.\n\nPlease check console for details.');
    });
}

// ============ ADD ROW, DELETE ROW, INSERT ITEM FUNCTIONS ============

let insertRowIndex = null; // Store which row to insert item into

// Add new row to table
function addNewRow() {
    const tbody = document.getElementById('itemsTableBody');
    const rowCount = tbody.querySelectorAll('tr').length;
    const newIndex = rowCount;
    
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="text" class="form-control" name="items[${newIndex}][code]" autocomplete="off"></td>
        <td><input type="text" class="form-control" name="items[${newIndex}][name]" autocomplete="off"></td>
        <td><input type="text" class="form-control" name="items[${newIndex}][batch]" autocomplete="off"></td>
        <td><input type="text" class="form-control" name="items[${newIndex}][exp]" autocomplete="off"></td>
        <td><input type="number" class="form-control item-qty" name="items[${newIndex}][qty]" autocomplete="off"></td>
        <td><input type="number" class="form-control item-fqty" name="items[${newIndex}][free_qty]" autocomplete="off"></td>
        <td><input type="number" class="form-control item-pur-rate" name="items[${newIndex}][pur_rate]" step="0.01" autocomplete="off"></td>
        <td><input type="number" class="form-control item-dis-percent" name="items[${newIndex}][dis_percent]" step="0.01" autocomplete="off"></td>
        <td><input type="number" class="form-control" name="items[${newIndex}][mrp]" step="0.01" autocomplete="off"></td>
        <td><input type="number" class="form-control readonly-field item-amount" name="items[${newIndex}][amount]" readonly></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-primary" onclick="openInsertItemModal(${newIndex})" title="Insert Item" style="padding: 4px 8px; margin-right: 5px; font-weight: bold;">+</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(${newIndex})" title="Delete Row" style="padding: 4px 8px; font-weight: bold;">×</button>
        </td>
    `;
    
    tbody.appendChild(row);
    
    // Add event listeners to new row
    addRowNavigationWithMrpModal(row, newIndex);
    addAmountCalculation(row, newIndex);
    
    // Update row color initially
    updateRowColor(newIndex);
    
    // Add focus listeners
    const inputs = row.querySelectorAll('input:not([readonly])');
    inputs.forEach(input => {
        input.addEventListener('focus', function(e) {
            currentActiveRow = newIndex;
            isRowSelected = false;
            
            const itemCode = row.querySelector('input[name*="[code]"]').value;
            
            if (itemCode && itemCode.trim() !== '') {
                fetchItemDetailsForCalculation(itemCode.trim(), newIndex);
            } else {
                clearCalculationSection();
            }
        });
    });
    
    console.log(`New row ${newIndex} added`);
}

// Delete row from table
function deleteRow(rowIndex) {
    const tbody = document.getElementById('itemsTableBody');
    const rows = tbody.querySelectorAll('tr');
    
    if (rows.length <= 10) {
        alert('Cannot delete! Minimum 10 rows required.');
        return;
    }
    
    if (confirm('Are you sure you want to delete this row?')) {
        rows[rowIndex].remove();
        
        // Delete saved GST data for this row
        if (rowGstData[rowIndex]) {
            delete rowGstData[rowIndex];
        }
        
        // Reindex all rows
        reindexRows();
        
        console.log(`Row ${rowIndex} deleted`);
    }
}

// Reindex rows after deletion
function reindexRows() {
    const tbody = document.getElementById('itemsTableBody');
    const rows = tbody.querySelectorAll('tr');
    
    rows.forEach((row, newIndex) => {
        // Update all input names
        row.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${newIndex}]`);
                input.setAttribute('name', newName);
            }
        });
        
        // Update button onclick attributes
        const insertBtn = row.querySelector('button[onclick*="openInsertItemModal"]');
        const deleteBtn = row.querySelector('button[onclick*="deleteRow"]');
        
        if (insertBtn) insertBtn.setAttribute('onclick', `openInsertItemModal(${newIndex})`);
        if (deleteBtn) deleteBtn.setAttribute('onclick', `deleteRow(${newIndex})`);
    });
}

// Open Insert Item Modal
function openInsertItemModal(rowIndex) {
    console.log('Opening insert modal for row:', rowIndex);
    insertRowIndex = rowIndex;
    
    const modal = document.getElementById('insertItemModal');
    const backdrop = document.getElementById('insertItemBackdrop');
    
    if (!modal) {
        console.error('Modal element not found!');
        return;
    }
    
    if (!backdrop) {
        console.error('Backdrop element not found!');
        return;
    }
    
    // Position modal in content area
    positionModalInContentArea(modal);
    
    backdrop.style.display = 'block';
    modal.style.display = 'block';
    
    setTimeout(() => {
        backdrop.classList.add('show');
        modal.classList.add('show');
    }, 10);
    
    // Load all items
    loadAllItems();
    
    // Focus on search input
    setTimeout(() => {
        const searchInput = document.getElementById('itemSearchInput');
        if (searchInput) {
            searchInput.focus();
        }
    }, 300);
}

// Close Insert Item Modal
function closeInsertItemModal() {
    const modal = document.getElementById('insertItemModal');
    const backdrop = document.getElementById('insertItemBackdrop');
    
    if (!modal || !backdrop) return;
    
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    setTimeout(() => {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
    }, 300);
    
    insertRowIndex = null;
}

// Load all items for insert modal
function loadAllItems() {
    console.log('🔄 Fetching items from backend...');
    
    // Try to fetch from backend
    fetch('/admin/items/all')
        .then(response => {
            console.log('📡 Response status:', response.status);
            if (!response.ok) {
                throw new Error(`Backend route failed with status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Data received:', data);
            if (data.success && data.items && data.items.length > 0) {
                console.log(`✅ Loading ${data.items.length} items from database`);
                displayItemsInModal(data.items);
            } else {
                console.error('❌ No items found in response');
                loadDummyItems(); // Fallback to dummy data
            }
        })
        .catch(error => {
            console.error('❌ Error loading items:', error);
            console.log('⚠️ Loading dummy items as fallback...');
            loadDummyItems(); // Fallback to dummy data
        });
}

// Fallback: Load dummy items (temporary solution)
function loadDummyItems() {
    const dummyItems = [
        { code: '1', name: 'amarsingh', mrp: 200.00, s_rate: 180.00 },
        { code: '16', name: 'paracetamol', mrp: 25.00, s_rate: 22.00 },
        { code: '19', name: 'cipla1', mrp: 15.00, s_rate: 13.50 },
        { code: '20', name: 'cipla2', mrp: 25.00, s_rate: 22.50 },
        { code: '21', name: 'cipla3', mrp: 35.00, s_rate: 31.50 },
        { code: '22', name: 'para', mrp: 20.00, s_rate: 18.00 }
    ];
    displayItemsInModal(dummyItems);
}

// Display items in modal
function displayItemsInModal(items) {
    const tbody = document.getElementById('insertItemsBody');
    tbody.innerHTML = '';
    
    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No items found</td></tr>';
        return;
    }
    
    items.forEach(item => {
        const row = document.createElement('tr');
        row.style.cursor = 'pointer';
        
        row.innerHTML = `
            <td>${item.code || '---'}</td>
            <td>${item.name || '---'}</td>
            <td class="text-end">${parseFloat(item.mrp || 0).toFixed(2)}</td>
            <td class="text-end">${parseFloat(item.s_rate || 0).toFixed(2)}</td>
        `;
        
        // Click to select item
        row.addEventListener('click', function() {
            selectItemForInsertion(item);
        });
        
        // Highlight on hover
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#e9ecef';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
        
        tbody.appendChild(row);
    });
}

// Select item and insert into row
function selectItemForInsertion(item) {
    if (insertRowIndex === null) return;
    
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[insertRowIndex];
    
    if (!row) return;
    
    // Populate row with item data
    row.querySelector('input[name*="[code]"]').value = item.code || '';
    row.querySelector('input[name*="[name]"]').value = item.name || '';
    row.querySelector('input[name*="[mrp]"]').value = item.mrp || '';
    
    // Close modal
    closeInsertItemModal();
    
    // Focus on Batch field
    setTimeout(() => {
        const batchInput = row.querySelector('input[name*="[batch]"]');
        if (batchInput) {
            batchInput.focus();
            batchInput.select();
        }
    }, 100);
    
    console.log(`Item ${item.code} inserted into row ${insertRowIndex}`);
}

// Search items in modal
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('itemSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#insertItemsBody tr');
            
            rows.forEach(row => {
                const code = row.cells[0]?.textContent.toLowerCase() || '';
                const name = row.cells[1]?.textContent.toLowerCase() || '';
                
                if (code.includes(searchTerm) || name.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

// ============================================
// MODIFICATION BLADE SPECIFIC FUNCTIONS
// ============================================

// Fetch Bill by Transaction Number or Bill Number
function fetchBillByTrnNo() {
    const trnNo = document.getElementById('trnNo').value.trim();
    const billNo = document.getElementById('billNo').value.trim();
    
    // Check if either Trn No or Bill No is entered
    if (!trnNo && !billNo) {
        // If neither entered, show invoice list modal
        openInvoiceListModal();
        return;
    }
    
    // Priority: Trn No first, then Bill No
    const identifier = trnNo || billNo;
    const searchType = trnNo ? 'Trn No' : 'Bill No';
    
    // Show loading
    console.log(`Fetching bill with ${searchType}:`, identifier);
    
    // Disable button and show loading
    const fetchBtn = document.querySelector('button[onclick*="fetchBillByTrnNo"]');
    const originalText = fetchBtn?.innerHTML;
    if (fetchBtn) {
        fetchBtn.disabled = true;
        fetchBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Loading...';
    }
    
    // Fetch bill data from backend
    fetch(`/admin/purchase/fetch-bill/${encodeURIComponent(identifier)}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                populateBillData(data.bill);
                // Show success message
                console.log(`✅ Bill fetched successfully using ${searchType}: ${identifier}`);
            } else {
                alert(data.message || 'Bill not found');
            }
        })
        .catch(error => {
            console.error('Error fetching bill:', error);
            if (error.message.includes('Failed to fetch') || error.message.includes('ERR_CONNECTION_REFUSED')) {
                alert('❌ Server connection error!\n\nPlease check:\n1. Laravel server is running (php artisan serve)\n2. Server is accessible at http://127.0.0.1:8000\n3. Check browser console for details');
            } else {
                alert('❌ Error fetching bill: ' + error.message);
            }
        })
        .finally(() => {
            // Re-enable button
            if (fetchBtn && originalText) {
                fetchBtn.disabled = false;
                fetchBtn.innerHTML = originalText;
            }
        });
}

// Open Invoice List Modal
function openInvoiceListModal() {
    const modal = document.getElementById('invoiceListModal');
    const backdrop = document.getElementById('invoiceListBackdrop');
    
    if (!modal || !backdrop) {
        console.error('Invoice list modal elements not found!');
        return;
    }
    
    // Position modal in content area
    positionModalInContentArea(modal);
    
    backdrop.style.display = 'block';
    modal.style.display = 'block';
    
    setTimeout(() => {
        backdrop.classList.add('show');
        modal.classList.add('show');
    }, 10);
    
    // Load invoices
    loadInvoiceList();
}

// Close Invoice List Modal
function closeInvoiceListModal() {
    const modal = document.getElementById('invoiceListModal');
    const backdrop = document.getElementById('invoiceListBackdrop');
    
    if (!modal || !backdrop) return;
    
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    setTimeout(() => {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
    }, 300);
}

// Load Invoice List
function loadInvoiceList() {
    console.log('Loading invoice list...');
    
    fetch('/admin/purchase/invoice-list')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayInvoiceList(data.invoices);
            } else {
                console.error('Failed to load invoices');
            }
        })
        .catch(error => {
            console.error('Error loading invoices:', error);
        });
}

// Helper function to format date
function formatDate(dateValue) {
    if (!dateValue) return '---';
    
    // If it's already a formatted date string, return as is
    if (typeof dateValue === 'string' && dateValue.length <= 10 && !dateValue.includes('T')) {
        return dateValue;
    }
    
    // Parse ISO date string
    try {
        const date = new Date(dateValue);
        if (isNaN(date.getTime())) return '---';
        
        // Format as DD-MM-YYYY
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    } catch (e) {
        return '---';
    }
}

// Display Invoice List in Modal
function displayInvoiceList(invoices) {
    const tbody = document.getElementById('invoiceListBody');
    tbody.innerHTML = '';
    
    if (invoices.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No invoices found</td></tr>';
        return;
    }
    
    invoices.forEach(invoice => {
        const row = document.createElement('tr');
        row.style.cursor = 'pointer';
        row.classList.add('invoice-row');
        
        // Format dates properly
        const billDate = formatDate(invoice.bill_date);
        const receiveDate = formatDate(invoice.receive_date);
        
        row.innerHTML = `
            <td>${invoice.bill_no || '---'}</td>
            <td class="text-center">${billDate}</td>
            <td class="text-center">${receiveDate}</td>
            <td>${invoice.supplier_name || '---'}</td>
            <td class="text-center">${invoice.created_by || 'MASTER'}</td>
            <td class="text-center">${invoice.modified_by || 'MASTER'}</td>
            <td class="text-end">₹${parseFloat(invoice.net_amount || 0).toFixed(2)}</td>
            <td class="text-center"><strong>${invoice.trn_no}</strong></td>
        `;
        
        // Click to select invoice
        row.addEventListener('click', function() {
            selectInvoice(invoice.trn_no);
        });
        
        // Highlight on hover
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#d4edff';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
        
        tbody.appendChild(row);
    });
}

// Select Invoice from Modal
function selectInvoice(trnNo) {
    document.getElementById('trnNo').value = trnNo;
    closeInvoiceListModal();
    fetchBillByTrnNo();
}

// Reset form to clear modification mode
function resetForm() {
    currentTransactionId = null;
    rowGstData = {};
    rowDetailedData = {};
    window.location.reload();
}

// Helper function to format date for HTML date input (YYYY-MM-DD)
function formatDateForInput(dateValue) {
    if (!dateValue) return '';
    
    // If already in YYYY-MM-DD format, return as is
    if (typeof dateValue === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(dateValue)) {
        return dateValue;
    }
    
    // If it's a date string, try to parse it
    const date = new Date(dateValue);
    if (isNaN(date.getTime())) return '';
    
    // Format as YYYY-MM-DD
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Fetch supplier name by supplier_id
async function fetchSupplierName(supplierId) {
    if (!supplierId) return null;
    
    try {
        // Try to get from existing dropdown options first
        const supplierSelect = document.getElementById('supplierSelect');
        if (supplierSelect) {
            const option = Array.from(supplierSelect.options).find(opt => opt.value === String(supplierId));
            if (option && option.textContent.trim() !== '') {
                return option.textContent;
            }
        }
        
        // If not found, try to fetch from backend API
        try {
            const response = await fetch(`/admin/purchase/supplier/${supplierId}/name`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                if (data.success && data.name) {
                    console.log('✅ Supplier name fetched from API:', data.name);
                    return data.name;
                }
            }
        } catch (err) {
            console.error('Error fetching supplier name from API:', err);
        }
        
        console.warn('⚠️ Could not fetch supplier name from any endpoint');
        return null;
    } catch (error) {
        console.error('❌ Error fetching supplier name:', error);
        return null;
    }
}

// Populate Bill Data into Form
function populateBillData(bill) {
    console.log('Populating bill data:', bill);
    console.log('Bill date:', bill.bill_date, 'Type:', typeof bill.bill_date);
    console.log('Receive date:', bill.receive_date, 'Type:', typeof bill.receive_date);
    console.log('Due date:', bill.due_date, 'Type:', typeof bill.due_date);
    console.log('Supplier ID:', bill.supplier_id, 'Type:', typeof bill.supplier_id);
    console.log('Cash:', bill.cash, 'Transfer:', bill.transfer);
    console.log('Transaction ID:', bill.transaction_id);
    
    // Store transaction ID for update mode
    currentTransactionId = bill.transaction_id || null;
    console.log('Current Transaction ID set to:', currentTransactionId);
    
    // Header Section - Format dates properly
    const billDateInput = document.getElementById('billDate');
    const receiveDateInput = document.getElementById('receiveDate');
    const dueDateInput = document.getElementById('dueDate');
    const supplierSelect = document.getElementById('supplierSelect');
    const billNoInput = document.getElementById('billNo');
    const trnNoInput = document.getElementById('trnNo');
    const cashInput = document.getElementById('cash');
    const transferInput = document.getElementById('transfer');
    const remarksInput = document.getElementById('remarks');
    
    // Set Bill Date
    if (billDateInput) {
        const formattedBillDate = formatDateForInput(bill.bill_date);
        billDateInput.value = formattedBillDate;
        console.log('Set billDate to:', formattedBillDate);
        updateDayName();
    }
    
    // Set Supplier - Ensure proper selection
    if (supplierSelect) {
        const supplierId = String(bill.supplier_id || ''); // Convert to string to match option values
        console.log('Setting supplier_id to:', supplierId, 'Type:', typeof supplierId);
        
        // Check if option exists in dropdown
        const optionExists = Array.from(supplierSelect.options).some(option => option.value === supplierId);
        
        if (optionExists) {
            supplierSelect.value = supplierId;
            console.log('✅ Supplier selected:', supplierSelect.options[supplierSelect.selectedIndex]?.text);
        } else {
            // If supplier not in dropdown, use supplier_name from bill or fetch from backend
            console.log('⚠️ Supplier ID not found in dropdown');
            
            // First try to use supplier_name from bill data
            let supplierName = bill.supplier_name || '';
            
            if (supplierName) {
                // Add option with supplier name from bill
                const option = document.createElement('option');
                option.value = supplierId;
                option.textContent = supplierName;
                supplierSelect.appendChild(option);
                supplierSelect.value = supplierId;
                console.log('✅ Supplier option added using bill data:', supplierName);
            } else if (supplierId) {
                // If no supplier_name in bill, fetch from backend
                console.log('Fetching supplier name from backend...');
                fetchSupplierName(supplierId).then(name => {
                    if (name) {
                        // Check if option was already added
                        const existingOption = Array.from(supplierSelect.options).find(opt => opt.value === supplierId);
                        if (!existingOption) {
                            const option = document.createElement('option');
                            option.value = supplierId;
                            option.textContent = name;
                            supplierSelect.appendChild(option);
                        }
                        supplierSelect.value = supplierId;
                        console.log('✅ Supplier option added from backend:', name);
                    } else {
                        console.error('❌ Could not fetch supplier name for ID:', supplierId);
                        // Add option with just ID as fallback
                        const option = document.createElement('option');
                        option.value = supplierId;
                        option.textContent = `Supplier ${supplierId}`;
                        supplierSelect.appendChild(option);
                        supplierSelect.value = supplierId;
                    }
                });
            }
        }
        
        // Trigger change event to ensure any listeners are notified
        supplierSelect.dispatchEvent(new Event('change', { bubbles: true }));
    }
    
    // Set Bill No and Trn No
    if (billNoInput) {
        billNoInput.value = bill.bill_no || '';
        console.log('Set bill_no to:', bill.bill_no);
    }
    if (trnNoInput) {
        trnNoInput.value = bill.trn_no || '';
        console.log('Set trn_no to:', bill.trn_no);
    }
    
    // Set Receive Date
    if (receiveDateInput) {
        const formattedReceiveDate = formatDateForInput(bill.receive_date);
        receiveDateInput.value = formattedReceiveDate;
        console.log('Set receiveDate to:', formattedReceiveDate);
    }
    
    // Set Cash and Transfer (uppercase)
    if (cashInput) {
        const cashValue = (bill.cash || 'N').toString().toUpperCase();
        cashInput.value = cashValue;
        console.log('Set cash to:', cashValue);
    }
    if (transferInput) {
        const transferValue = (bill.transfer || 'N').toString().toUpperCase();
        transferInput.value = transferValue;
        console.log('Set transfer to:', transferValue);
    }
    
    // Set Remarks
    if (remarksInput) {
        remarksInput.value = bill.remarks || '';
        console.log('Set remarks to:', bill.remarks);
    }
    
    // Set Due Date
    if (dueDateInput) {
        const formattedDueDate = formatDateForInput(bill.due_date);
        dueDateInput.value = formattedDueDate;
        console.log('Set dueDate to:', formattedDueDate);
    }
    
    // Clear existing items
    document.getElementById('itemsTableBody').innerHTML = '';
    
    // Populate Items
    if (bill.items && bill.items.length > 0) {
        bill.items.forEach((item, index) => {
            addNewRow();
            const rows = document.querySelectorAll('#itemsTableBody tr');
            const row = rows[rows.length - 1];
            const rowIndex = rows.length - 1;
            
            // Fix field names to match actual form field names
            row.querySelector('input[name*="[code]"]').value = item.item_code || '';
            row.querySelector('input[name*="[name]"]').value = item.item_name || '';
            row.querySelector('input[name*="[batch]"]').value = item.batch_number || '';
            row.querySelector('input[name*="[exp]"]').value = item.expiry_date || ''; // Fixed: was [expiry]
            row.querySelector('input[name*="[qty]"]').value = item.quantity || '';
            row.querySelector('input[name*="[free_qty]"]').value = item.free_quantity || '';
            row.querySelector('input[name*="[pur_rate]"]').value = item.p_rate || ''; // Fixed: was [rate]
            row.querySelector('input[name*="[dis_percent]"]').value = item.discount_percent || ''; // Fixed: was [discount]
            row.querySelector('input[name*="[mrp]"]').value = item.mrp || '';
            row.querySelector('input[name*="[amount]"]').value = item.amount || '';
            
            // Store s_rate in rowGstData for this row (from saved data)
            if (item.s_rate !== undefined && item.s_rate !== null) {
                if (!rowGstData[rowIndex]) {
                    rowGstData[rowIndex] = {};
                }
                rowGstData[rowIndex].s_rate = parseFloat(item.s_rate) || 0;
            }
            
            // Trigger amount calculation for this row
            setTimeout(() => {
                // Recalculate amount if needed
                const qtyInput = row.querySelector('input[name*="[qty]"]');
                const purRateInput = row.querySelector('input[name*="[pur_rate]"]');
                const disPercentInput = row.querySelector('input[name*="[dis_percent]"]');
                if (qtyInput && purRateInput) {
                    // Trigger input event to recalculate
                    qtyInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }, 100);
        });
    }
    
    // Populate Summary Section
    document.getElementById('nt_amt').value = parseFloat(bill.nt_amt || 0).toFixed(2);
    document.getElementById('sc_amt').value = parseFloat(bill.sc_amt || 0).toFixed(2);
    document.getElementById('scm_amt').value = parseFloat(bill.scm_amt || 0).toFixed(2);
    document.getElementById('dis_amt').value = parseFloat(bill.dis_amt || 0).toFixed(2);
    document.getElementById('less_amt').value = parseFloat(bill.less_amt || 0).toFixed(2);
    document.getElementById('tax_amt').value = parseFloat(bill.tax_amt || 0).toFixed(2);
    document.getElementById('net_amt').value = parseFloat(bill.net_amt || 0).toFixed(2);
    document.getElementById('scm_percent').value = parseFloat(bill.scm_percent || 0).toFixed(2);
    document.getElementById('tcs_amt').value = parseFloat(bill.tcs_amt || 0).toFixed(2);
    document.getElementById('dis1_amt').value = parseFloat(bill.dis1_amt || 0).toFixed(2);
    document.getElementById('tof_amt').value = parseFloat(bill.tof_amt || 0).toFixed(2);
    document.getElementById('inv_amt').value = parseFloat(bill.inv_amt || 0).toFixed(2);
    
    // Populate Detailed Info Section
    document.getElementById('unit').value = bill.unit || '1';
    document.getElementById('nt_amt_detail').value = parseFloat(bill.nt_amt || 0).toFixed(2);
    document.getElementById('scm_amt_detail').value = parseFloat(bill.scm_amt || 0).toFixed(2);
    document.getElementById('tax_amt_detail').value = parseFloat(bill.tax_amt || 0).toFixed(2);
    document.getElementById('cost').value = parseFloat(bill.cost || 0).toFixed(2);
    document.getElementById('lctn').value = bill.location || '';
    document.getElementById('sc_amt_detail').value = parseFloat(bill.sc_amt || 0).toFixed(2);
    document.getElementById('dis1_amt_detail').value = parseFloat(bill.dis1_amt || 0).toFixed(2);
    document.getElementById('net_amt_detail').value = parseFloat(bill.net_amt || 0).toFixed(2);
    document.getElementById('cost_gst').value = parseFloat(bill.cost_gst || 0).toFixed(2);
    document.getElementById('cl_qty').value = bill.cl_qty || '';
    document.getElementById('dis_amt_detail').value = parseFloat(bill.dis_amt || 0).toFixed(2);
    document.getElementById('less_detail').value = parseFloat(bill.less_amt || 0).toFixed(2);
    document.getElementById('comp').value = bill.company || '';
    document.getElementById('vol').value = bill.volume || '0';
    document.getElementById('pack_detail').value = bill.packing || '';
    document.getElementById('hs_amt').value = parseFloat(bill.hs_amt || 0).toFixed(2);
    document.getElementById('gross_amt').value = parseFloat(bill.gross_amt || 0).toFixed(2);
    document.getElementById('scm_percent_detail').value = parseFloat(bill.scm_percent || 0).toFixed(2);
    document.getElementById('dis1_percent').value = parseFloat(bill.dis1_percent || 0).toFixed(2);
    
    // Recalculate GST for all rows that have items (with delay to ensure DOM is ready)
    setTimeout(() => {
        const rows = document.querySelectorAll('#itemsTableBody tr');
        rows.forEach((row, index) => {
            const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
            const amount = parseFloat(row.querySelector('input[name*="[amount]"]')?.value) || 0;
            
            if (itemCode && amount > 0) {
                // Fetch item details and calculate GST
                fetchItemDetailsForCalculation(itemCode, index);
                // Calculate GST after a short delay to allow item details to load
                setTimeout(() => {
                    calculateAndSaveGstForRow(index);
                }, 200);
            }
        });
        
        // Update summary section after all calculations
        setTimeout(() => {
            updateSummarySection();
            
            // Update row colors after all calculations
            const rows = document.querySelectorAll('#itemsTableBody tr');
            rows.forEach((row, index) => {
                updateRowColor(index);
            });
            checkAllRowsComplete();
        }, 500);
    }, 300);
    
    // Show appropriate message based on mode
    if (currentTransactionId) {
        alert('✅ Bill fetched successfully!\n\nYou are in MODIFICATION mode.\nChanges will UPDATE the existing transaction.');
    } else {
        alert('✅ Bill fetched successfully!');
    }
}
</script>

<!-- Invoice List Modal Backdrop -->
<div id="invoiceListBackdrop" class="pending-orders-backdrop"></div>

<!-- Invoice List Modal -->
<div id="invoiceListModal" class="pending-orders-modal" style="max-width: 1200px; max-height: 90vh;">
    <div class="pending-orders-content" style="display: flex; flex-direction: column; max-height: 90vh;">
        <div class="pending-orders-header" style="background: #ff6b35; color: white; flex-shrink: 0;">
            <h5 class="pending-orders-title">List of Purchase Invoices</h5>
            <button type="button" class="btn-close-modal" onclick="closeInvoiceListModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="pending-orders-body" style="padding: 0; overflow: hidden; flex: 1; display: flex; flex-direction: column;">
            <div class="table-responsive" style="flex: 1; overflow-y: auto; max-height: calc(90vh - 150px);">
                <table class="table table-bordered table-hover mb-0" style="font-size: 12px;">
                    <thead style="position: sticky; top: 0; background: #f8f9fa; z-index: 10;">
                        <tr>
                            <th style="width: 120px;">Pur Inv. No</th>
                            <th style="width: 110px;">Inv. Date</th>
                            <th style="width: 110px;">Entry Date</th>
                            <th>Supplier</th>
                            <th style="width: 80px;">UID</th>
                            <th style="width: 80px;">F UID</th>
                            <th style="width: 100px;">Amount</th>
                            <th style="width: 100px;">Trn.No.</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceListBody">
                        <tr>
                            <td colspan="8" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pending-orders-footer" style="flex-shrink: 0; padding: 10px 15px;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeInvoiceListModal()">
                <i class="bi bi-x-circle"></i> Close
            </button>
        </div>
    </div>
</div>

@endsection
