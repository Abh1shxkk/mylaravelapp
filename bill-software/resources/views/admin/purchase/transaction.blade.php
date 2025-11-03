@extends('layouts.admin')

@section('title', 'Purchase Transaction')

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
    }
    
    .table-compact th {
        background: #e9ecef;
        font-weight: 600;
        text-align: center;
        border: 1px solid #dee2e6;
    }
    
    .table-compact input {
        font-size: 10px;
        padding: 2px 4px;
        height: 22px;
        border: 1px solid #ced4da;
        width: 100%;
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
    
    /* Pending Orders Modal Styles */
    .pending-orders-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.7);
        width: 90%;
        max-width: 900px;
        z-index: 9999;
        opacity: 0;
        transition: all 0.3s ease-in-out;
    }
    
    .pending-orders-modal.show {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
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
        z-index: 9998;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .pending-orders-backdrop.show {
        opacity: 1;
    }
</style>

<div class="container-fluid compact-form">
    <form id="purchaseForm" method="POST" autocomplete="off">
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
                <div style="width: 200px;">
                    <div class="field-group mb-2">
                        <label style="width: 60px;">Bill No.:</label>
                        <input type="text" class="form-control" name="bill_no" id="billNo" placeholder="1111">
                    </div>
                    <div class="field-group">
                        <label style="width: 60px;">Trn.No.:</label>
                        <input type="text" class="form-control readonly-field" name="trn_no" id="trnNo" value="{{ $nextTrnNo ?? 1 }}" readonly>
                    </div>
                </div>
                
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
            </div>
        </div>
        
        <!-- Items Table -->
        <div class="bg-white border rounded p-2 mb-2">
            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
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
                        </tr>
                    </thead>
                    <tbody id="itemsTableBody">
                        <tr>
                            <td><input type="text" class="form-control" name="items[0][code]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[0][name]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[0][batch]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[0][exp]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-qty" name="items[0][qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-fqty" name="items[0][free_qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-pur-rate" name="items[0][pur_rate]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-dis-percent" name="items[0][dis_percent]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control" name="items[0][mrp]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control readonly-field item-amount" name="items[0][amount]" readonly></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" name="items[1][code]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[1][name]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[1][batch]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[1][exp]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-qty" name="items[1][qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-fqty" name="items[1][free_qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-pur-rate" name="items[1][pur_rate]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-dis-percent" name="items[1][dis_percent]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control" name="items[1][mrp]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control readonly-field item-amount" name="items[1][amount]" readonly></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" name="items[2][code]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[2][name]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[2][batch]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[2][exp]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-qty" name="items[2][qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-fqty" name="items[2][free_qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-pur-rate" name="items[2][pur_rate]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-dis-percent" name="items[2][dis_percent]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control" name="items[2][mrp]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control readonly-field item-amount" name="items[2][amount]" readonly></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" name="items[3][code]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[3][name]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[3][batch]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[3][exp]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-qty" name="items[3][qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-fqty" name="items[3][free_qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-pur-rate" name="items[3][pur_rate]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-dis-percent" name="items[3][dis_percent]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control" name="items[3][mrp]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control readonly-field item-amount" name="items[3][amount]" readonly></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" name="items[4][code]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[4][name]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[4][batch]" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="items[4][exp]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-qty" name="items[4][qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-fqty" name="items[4][free_qty]" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-pur-rate" name="items[4][pur_rate]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control item-dis-percent" name="items[4][dis_percent]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control" name="items[4][mrp]" step="0.01" autocomplete="off"></td>
                            <td><input type="number" class="form-control readonly-field item-amount" name="items[4][amount]" readonly></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Calculation Section -->
        <div class="bg-white border rounded p-2 mb-2">
            <div class="row g-2" style="font-size: 11px;">
                <!-- Row 1 -->
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 40px;">SC%</label>
                    <input type="number" class="form-control readonly-field" id="calc_sc_percent" readonly step="0.01" style="width: 70px;" value="0.000">
                </div>
                
                <div class="col-auto">
                    <div class="border rounded p-1" style="background: #ff0000; color: white; text-align: center; min-width: 100px;">
                        <strong id="calc_hsn_code">---</strong>
                    </div>
                </div>
                
                <div class="col-auto">
                    <div class="d-flex flex-column" style="line-height: 1.2;">
                        <div><strong>HSN Code: <span id="calc_hsn_display">---</span></strong></div>
                        <div><strong>CGST(%): <span id="calc_cgst">0</span></strong></div>
                        <div><strong>SGST(%): <span id="calc_sgst">0</span></strong></div>
                        <div><strong>Cess (%): <span id="calc_cess">0</span></strong></div>
                    </div>
                </div>
                
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 70px;">Spl. Rate</label>
                    <input type="number" class="form-control readonly-field" id="calc_spl_rate" readonly step="0.01" style="width: 80px;" value="0.00">
                </div>
                
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 70px;">W.S.Rate</label>
                    <input type="number" class="form-control readonly-field" id="calc_ws_rate" readonly step="0.01" style="width: 80px;" value="0.00">
                </div>
                
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 50px;">TAX %</label>
                    <input type="number" class="form-control readonly-field" id="calc_tax_percent" readonly step="0.01" style="width: 70px;" value="0.000">
                </div>
                
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 50px;">Excise</label>
                    <input type="number" class="form-control readonly-field" id="calc_excise" readonly step="0.01" style="width: 70px;" value="0.00">
                </div>
                
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 40px;">MRP</label>
                    <input type="number" class="form-control readonly-field" id="calc_mrp" readonly step="0.01" style="width: 80px;" value="0.00">
                </div>
            </div>
            
            <!-- Row 2 -->
            <div class="row g-2 mt-1" style="font-size: 11px;">
                <div class="col-auto">
                    <div class="d-flex gap-2">
                        <div style="background: #ff0000; color: white; padding: 2px 8px; border-radius: 3px; min-width: 80px; text-align: center;">
                            <strong id="calc_cgst_amount">0.00</strong>
                        </div>
                        <div style="background: #ff0000; color: white; padding: 2px 8px; border-radius: 3px; min-width: 80px; text-align: center;">
                            <strong id="calc_sgst_amount">0.00</strong>
                        </div>
                        <div style="background: #ff0000; color: white; padding: 2px 8px; border-radius: 3px; min-width: 60px; text-align: center;">
                            <strong id="calc_cess_amount">0.00</strong>
                        </div>
                    </div>
                </div>
                
                <div class="col-auto ms-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 80px; text-align: right;"><strong>Inc.</strong></label>
                    <input type="text" class="form-control text-center readonly-field" id="calc_inc" readonly style="width: 40px;" value="Y">
                </div>
                
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 60px; text-align: right;"><strong>S.Rate</strong></label>
                    <input type="number" class="form-control text-end" id="calc_s_rate" step="0.01" style="width: 80px;" value="0.00">
                </div>
                
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="mb-0" style="min-width: 40px; text-align: right;"><strong>Less</strong></label>
                    <input type="number" class="form-control text-end readonly-field" id="calc_less" readonly step="0.01" style="width: 80px;" value="0.00">
                </div>
            </div>
        </div>
        
        <!-- Summary Section -->
        <div class="bg-white border rounded p-2 mb-2">
            <!-- Row 1: 6 fields -->
            <div class="d-flex align-items-center" style="font-size: 11px; gap: 10px;">
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">N.T AMT</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="nt_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #fff3cd;" value="1227.90">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">SC</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="sc_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">SCM.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">DIS.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="dis_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">LESS</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="less_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">Tax</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="tax_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="147.34">
                </div>
            </div>
            
            <!-- Row 2: 6 fields -->
            <div class="d-flex align-items-center mt-2" style="font-size: 11px; gap: 10px;">
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">NET AMT.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="net_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #fff3cd; font-weight: bold;" value="1375.24">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">Scm.%</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_percent" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">TCS</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="tcs_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #ffcccc;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">Dis1 Amt</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="dis1_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #ffcccc;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold;">TOF</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="tof_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                </div>
                
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">INV.AMT.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="inv_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #fff3cd; font-weight: bold;" value="1375.24">
                </div>
            </div>
        </div>
        
        <!-- Detailed Info Section -->
        <div class="bg-white border rounded p-2 mb-2">
            <table style="width: 100%; font-size: 11px; border-collapse: collapse;">
                <tr>
                    <td style="padding: 3px;"><strong>Unit</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="unit" value="1" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>N.T Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="nt_amt_detail" readonly value="1227.90" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Scm.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Tax Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="tax_amt_detail" readonly value="147.34" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Cost</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="cost" readonly value="122.79" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Srl.No.</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm text-center" id="srl_no1" value="1" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm text-center" id="srl_no2" value="1" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Lctn</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="lctn" value="" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>SC Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="sc_amt_detail" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Dis1.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="dis1_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Net Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="net_amt_detail" readonly value="1375.24" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Cost+GST</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="cost_gst" readonly value="137.52" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>P.SCM.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="p_scm1" value="0" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px; text-align: center; font-weight: bold;">+</td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="p_scm2" value="0" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Cl.Qty</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="cl_qty" value="25" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>Dis. Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="dis_amt_detail" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Less</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="less_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Comp :</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="comp" value="INTAS" style="height: 22px; width: 100px;"></td>
                    <td style="padding: 3px;"><strong>Vol.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="vol" value="0" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>S.SCM.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="s_scm1" value="0" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px; text-align: center; font-weight: bold;">+</td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="s_scm2" value="0" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Pack</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="pack_detail" value="1*10" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>Hs.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="hs_amt" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Gross Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="gross_amt" readonly value="1227.90" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Scm%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="scm_percent_detail" value="0.00" style="height: 22px; width: 60px;"></td>
                    <td style="padding: 3px;"><strong>Dis1.%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="dis1_percent" value="0.00" style="height: 22px; width: 60px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="percent1" value="20.00" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="percent2" value="10.00" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="percent3" value="10.00" style="height: 22px; width: 50px;"></td>
                </tr>
            </table>
        </div>
        
        <!-- Action Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-save"></i> Save
            </button>
            <button type="button" class="btn btn-secondary btn-sm">
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
    const sRateField = document.getElementById('calc_s_rate');
    if (sRateField) {
        sRateField.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                console.log('S.Rate Enter pressed');
                console.log('currentActiveRow:', currentActiveRow);
                console.log('isRowSelected before:', isRowSelected);
                
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
    
    // Table cell click - Open pending orders modal
    const tableInputs = document.querySelectorAll('#itemsTableBody input');
    tableInputs.forEach(input => {
        input.addEventListener('click', function(e) {
            const supplierId = document.getElementById('supplierSelect').value;
            
            if (!supplierId) {
                alert('Please select a supplier first!');
                return;
            }
            
            // Load pending orders for selected supplier
            loadPendingOrders(supplierId);
        });
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
    document.getElementById('calc_hsn_code').textContent = item.hsn_code || '---';
    document.getElementById('calc_hsn_display').textContent = item.hsn_code || '---';
    document.getElementById('calc_cgst').textContent = item.cgst_percent || 0;
    document.getElementById('calc_sgst').textContent = item.sgst_percent || 0;
    document.getElementById('calc_cess').textContent = item.cess_percent || 0;
    
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

// Populate calculation section for specific row (when focusing on any cell)
function populateCalculationSectionForRow(item, rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (!row) return;
    
    const amount = parseFloat(row.querySelector('input[name*="[amount]"]').value) || 0;
    
    // Populate HSN Code and GST details (percentages always show)
    document.getElementById('calc_hsn_code').textContent = item.hsn_code || '---';
    document.getElementById('calc_hsn_display').textContent = item.hsn_code || '---';
    document.getElementById('calc_cgst').textContent = item.cgst_percent || 0;
    document.getElementById('calc_sgst').textContent = item.sgst_percent || 0;
    document.getElementById('calc_cess').textContent = item.cess_percent || 0;
    
    // Populate rate fields
    document.getElementById('calc_sc_percent').value = parseFloat(item.fixed_dis_percent || 0).toFixed(3);
    document.getElementById('calc_spl_rate').value = parseFloat(item.spl_rate || 0).toFixed(2);
    document.getElementById('calc_ws_rate').value = parseFloat(item.ws_rate || 0).toFixed(2);
    document.getElementById('calc_tax_percent').value = (parseFloat(item.cgst_percent || 0) + parseFloat(item.sgst_percent || 0)).toFixed(3);
    document.getElementById('calc_excise').value = '0.00';
    document.getElementById('calc_mrp').value = parseFloat(item.mrp || 0).toFixed(2);
    document.getElementById('calc_s_rate').value = parseFloat(item.s_rate || 0).toFixed(2);
    
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
}

// Calculate and save GST amounts for current row (called after S.Rate is filled)
function calculateAndSaveGstForRow(rowIndex) {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const row = rows[rowIndex];
    
    if (!row) return;
    
    const amount = parseFloat(row.querySelector('input[name*="[amount]"]').value) || 0;
    const itemCode = row.querySelector('input[name*="[code]"]').value;
    
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
                
                // Save calculated amounts for this row
                rowGstData[rowIndex] = {
                    calculated: true,
                    cgstAmount: cgstAmount,
                    sgstAmount: sgstAmount,
                    cessAmount: cessAmount,
                    amount: amount,
                    cgstPercent: cgstPercent,
                    sgstPercent: sgstPercent,
                    cessPercent: cessPercent
                };
                
                console.log(`✅ GST calculated and saved for row ${rowIndex}:`, rowGstData[rowIndex]);
                
                // Update display immediately if this is the current active row
                if (currentActiveRow === rowIndex) {
                    document.getElementById('calc_cgst_amount').textContent = cgstAmount;
                    document.getElementById('calc_sgst_amount').textContent = sgstAmount;
                    document.getElementById('calc_cess_amount').textContent = cessAmount;
                    console.log(`✅ Display updated for row ${rowIndex}`);
                }
            }
        })
        .catch(error => {
            console.error('Error calculating GST:', error);
        });
}

// Clear calculation section
function clearCalculationSection() {
    document.getElementById('calc_hsn_code').textContent = '---';
    document.getElementById('calc_hsn_display').textContent = '---';
    document.getElementById('calc_cgst').textContent = '0';
    document.getElementById('calc_sgst').textContent = '0';
    document.getElementById('calc_cess').textContent = '0';
    
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
}

// Load pending orders from supplier
function loadPendingOrders(supplierId) {
    fetch(`/admin/suppliers/${supplierId}/pending-orders-data`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayPendingOrders(data.orders);
                // Show modal
                openPendingOrdersModal();
            } else {
                alert('No pending orders found for this supplier');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading pending orders');
        });
}

// Open pending orders modal
function openPendingOrdersModal() {
    const modal = document.getElementById('pendingOrdersModal');
    const backdrop = document.getElementById('pendingOrdersBackdrop');
    
    backdrop.style.display = 'block';
    modal.style.display = 'block';
    
    setTimeout(() => {
        backdrop.classList.add('show');
        modal.classList.add('show');
    }, 10);
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

// Open MRP Details Modal
function openMrpDetailsModal() {
    const modal = document.getElementById('mrpDetailsModal');
    const backdrop = document.getElementById('mrpDetailsBackdrop');
    
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
    
    // Ensure minimum 5 rows
    const minRows = 5;
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
        `;
        tbody.appendChild(row);
        
        // Add Enter key navigation for this row
        addRowNavigationWithMrpModal(row, index);
        
        // Add amount calculation listeners
        addAmountCalculation(row, index);
    }
    
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
        
        // If this row was already calculated, recalculate GST with new amount
        if (rowGstData[rowIndex] && rowGstData[rowIndex].calculated) {
            const cgstPercent = rowGstData[rowIndex].cgstPercent || 0;
            const sgstPercent = rowGstData[rowIndex].sgstPercent || 0;
            const cessPercent = rowGstData[rowIndex].cessPercent || 0;
            
            const cgstAmount = (amount * cgstPercent / 100).toFixed(2);
            const sgstAmount = (amount * sgstPercent / 100).toFixed(2);
            const cessAmount = (amount * cessPercent / 100).toFixed(2);
            
            // Update saved data
            rowGstData[rowIndex].cgstAmount = cgstAmount;
            rowGstData[rowIndex].sgstAmount = sgstAmount;
            rowGstData[rowIndex].cessAmount = cessAmount;
            rowGstData[rowIndex].amount = amount;
            
            // Update display if this is the current active row
            if (currentActiveRow === rowIndex) {
                document.getElementById('calc_cgst_amount').textContent = cgstAmount;
                document.getElementById('calc_sgst_amount').textContent = sgstAmount;
                document.getElementById('calc_cess_amount').textContent = cessAmount;
            }
            
            console.log(`GST recalculated for row ${rowIndex} with new amount ${amount}`);
        }
    }
    
    // Add listeners
    if (qtyInput) qtyInput.addEventListener('input', calculateAmount);
    if (purRateInput) purRateInput.addEventListener('input', calculateAmount);
    if (disPercentInput) disPercentInput.addEventListener('input', calculateAmount);
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

// Form submission
document.getElementById('purchaseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Collect items data
    const items = [];
    const rows = document.querySelectorAll('#itemsTableBody tr');
    rows.forEach((row, index) => {
        const code = row.querySelector(`input[name="items[${index}][code]"]`)?.value;
        const name = row.querySelector(`input[name="items[${index}][name]"]`)?.value;
        
        // Only add row if it has data
        if (code || name) {
            items.push({
                code: code || '',
                name: name || '',
                batch: row.querySelector(`input[name="items[${index}][batch]"]`)?.value || '',
                exp: row.querySelector(`input[name="items[${index}][exp]"]`)?.value || '',
                qty: row.querySelector(`input[name="items[${index}][qty]"]`)?.value || 0,
                free_qty: row.querySelector(`input[name="items[${index}][free_qty]"]`)?.value || 0,
                pur_rate: row.querySelector(`input[name="items[${index}][pur_rate]"]`)?.value || 0,
                dis_percent: row.querySelector(`input[name="items[${index}][dis_percent]"]`)?.value || 0,
                mrp: row.querySelector(`input[name="items[${index}][mrp]"]`)?.value || 0,
                amount: row.querySelector(`input[name="items[${index}][amount]"]`)?.value || 0
            });
        }
    });
    
    // Add items as JSON
    formData.append('items_json', JSON.stringify(items));
    
    // Send AJAX request
    fetch('{{ route("admin.purchase.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Purchase saved successfully! Transaction No: ' + data.trn_no);
            // Reload or reset form
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to save purchase'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the purchase');
    });
});
</script>

@endsection
