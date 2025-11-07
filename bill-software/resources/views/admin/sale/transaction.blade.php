@extends('layouts.admin')

@section('title', 'Sale Transaction')

@section('content')
<style>
    /* Compact form adjustments - preserving original functionality */
    .compact-form {
        font-size: 11px;
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
    
    .field-group label {
        font-weight: 600;
        font-size: 11px;
        margin-bottom: 0;
        white-space: nowrap;
    }
    
    .field-group input,
    .field-group select {
        font-size: 11px;
        padding: 2px 6px;
        height: 26px;
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
        height: 45px;
    }
    
    .table-compact th {
        background: #e9ecef;
        font-weight: 600;
        text-align: center;
        border: 1px solid #dee2e6;
        height: 40px;
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

    /* Row validation colors */
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

    .row-selected {
        background-color: #d4edff !important;
        border: 2px solid #007bff !important;
    }

    .row-selected td {
        background-color: #d4edff !important;
    }

    /* Pending Orders Modal Styles (matching purchase transaction) */
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
        display: block;
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
        display: block;
        opacity: 1;
    }
    
    /* Legacy modal classes for backward compatibility */
    .choose-items-modal {
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

    .choose-items-modal.show {
        display: block;
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }

    .choose-items-content {
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .choose-items-header {
        padding: 1rem 1.5rem;
        background: #ff6b35;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #e55a25;
    }

    .choose-items-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .choose-items-body {
        padding: 0;
        background: #fff;
    }

    .choose-items-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-backdrop {
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

    .modal-backdrop.show {
        display: block;
        opacity: 1;
    }

    .item-row-selected {
        background-color: #007bff !important;
        color: white !important;
    }

    .item-row-selected td {
        background-color: #007bff !important;
        color: white !important;
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

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-receipt me-2"></i> Sale Transaction</h4>
        <div class="text-muted small">Create new sale transaction</div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded">
    <div class="card-body">
        <form id="saleTransactionForm" method="POST" autocomplete="off" onsubmit="return false;">
            @csrf
            
            <!-- Header Section -->
            <div class="header-section">
                <!-- Row 1: Series, Date, Customer -->
                <div class="header-row">
                    <div class="field-group">
                        <label>Series:</label>
                        <select class="form-control" name="series" id="seriesSelect" style="width: 60px;" onchange="updateInvoiceType()">
                            <option value="SB" selected>SB</option>
                            <option value="S2">S2</option>
                        </select>
                        <input type="text" class="form-control readonly-field" id="invoiceTypeDisplay" value="TAX INVOICE" readonly style="width: 130px; text-align: center; font-weight: bold;">
                    </div>
                    
                    <div class="field-group">
                        <label>Sale Date</label>
                        <input type="date" class="form-control" name="date" id="saleDate" value="{{ date('Y-m-d') }}" style="width: 140px;" onchange="updateDayName()">
                        <input type="text" class="form-control readonly-field" id="dayName" value="{{ date('l') }}" readonly style="width: 90px;">
                    </div>
                    
                    <div class="field-group">
                        <label>Customer:</label>
                        <select class="form-control" name="customer_id" id="customerSelect" style="width: 250px;" autocomplete="off" onchange="updateCustomerName()">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" data-name="{{ $customer->name }}">{{ $customer->code ?? '' }} - {{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Row 2: Invoice No, Sales Man, Inner Card -->
                <div class="d-flex gap-3">
                    <!-- Left Side - Invoice & Salesman -->
                    <div style="width: 250px;">
                        <div class="field-group mb-2">
                            <label style="width: 70px;">Inv.No.:</label>
                            <input type="text" class="form-control" name="invoice_no" id="invoiceNo" value="{{ $nextInvoiceNo }}">
                        </div>
                        <div class="field-group mb-2">
                            <label style="width: 70px;">Sales Man:</label>
                            <select class="form-control" name="salesman_id" id="salesmanSelect" autocomplete="off" onchange="updateSalesmanName()">
                                <option value="">Select</option>
                                @foreach($salesmen as $salesman)
                                    <option value="{{ $salesman->id }}" data-name="{{ $salesman->name }}">{{ $salesman->code ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-info" onclick="openChooseItemsModal()" style="width: 100%;">
                                <i class="bi bi-list-check"></i> Choose Items
                            </button>
                        </div>
                    </div>
                    
                    <!-- Right Side - Inner Card -->
                    <div class="inner-card flex-grow-1">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label style="width: 80px;">Due Date</label>
                                    <input type="date" class="form-control" name="due_date" id="dueDate" value="{{ date('Y-m-d') }}">
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
                            <div class="col-md-12">
                                <div class="field-group">
                                    <label>Remarks:</label>
                                    <input type="text" class="form-control" name="remarks" id="remarks">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-2 mt-1">
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <div class="field-group flex-grow-1">
                                        <label>DUE:</label>
                                        <input type="text" class="form-control readonly-field" name="due" readonly value="0.00">
                                    </div>
                                    <div class="field-group flex-grow-1">
                                        <label>PDC:</label>
                                        <input type="text" class="form-control readonly-field" name="pdc" readonly value="0.00">
                                    </div>
                                    <div class="field-group flex-grow-1">
                                        <label>TOTAL:</label>
                                        <input type="text" class="form-control readonly-field" name="total" id="totalAmount" readonly value="0.00" style="font-weight: bold;">
                                    </div>
                                </div>
                            </div>
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
                                <th style="width: 60px;">F.Qty</th>
                                <th style="width: 80px;">Sale Rate</th>
                                <th style="width: 60px;">Dis.%</th>
                                <th style="width: 80px;">MRP</th>
                                <th style="width: 90px;">Amount</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            <!-- Items will be added dynamically -->
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

            
            <!-- Calculation Section (matching purchase module structure) -->
            <div class="bg-white border rounded p-3 mb-2" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div class="d-flex align-items-start gap-3 border rounded p-2" style="font-size: 11px; background: #fafafa;">
                    <!-- Left Section: Case, Box, HSN Code Block -->
                    <div class="d-flex flex-column gap-2" style="min-width: 200px;">
                        <!-- Case -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px;"><strong>Case</strong></label>
                            <input type="text" class="form-control readonly-field text-end" id="calc_case" readonly style="width: 80px; height: 28px;" value="0">
                        </div>
                        
                        <!-- Box -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px;"><strong>Box</strong></label>
                            <input type="text" class="form-control readonly-field text-end" id="calc_box" readonly style="width: 80px; height: 28px;" value="0">
                        </div>
                        
                        <!-- HSN Code -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px;"><strong>HSN Code:</strong></label>
                            <input type="text" class="form-control readonly-field text-center" id="calc_hsn_code" readonly style="width: 100px; height: 28px; background: #ffcccc; font-weight: bold;" value="---">
                        </div>
                    </div>
                    
                    <!-- Middle Section: GST Details -->
                    <div class="d-flex flex-column gap-2">
                        <!-- CGST(%) -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px; background: #ffcccc; padding: 4px 8px; border-radius: 3px;"><strong>CGST(%):</strong></label>
                            <input type="text" class="form-control readonly-field text-center" id="calc_cgst" readonly style="width: 80px; height: 28px;" value="0">
                        </div>
                        
                        <!-- SGST(%) -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px; background: #ffcccc; padding: 4px 8px; border-radius: 3px;"><strong>SGST(%):</strong></label>
                            <input type="text" class="form-control readonly-field text-center" id="calc_sgst" readonly style="width: 80px; height: 28px;" value="0">
                        </div>
                        
                        <!-- Cess (%) -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px; background: #ffcccc; padding: 4px 8px; border-radius: 3px;"><strong>Cess (%):</strong></label>
                            <input type="text" class="form-control readonly-field text-center" id="calc_cess" readonly style="width: 80px; height: 28px;" value="0">
                        </div>
                    </div>
                    
                    <!-- Right Side: GST Amounts and Other Fields -->
                    <div class="d-flex gap-3">
                        <!-- Column 1: GST Amounts -->
                        <div class="d-flex flex-column gap-2">
                            <!-- CGST Amt -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="min-width: 75px;"><strong>CGST Amt:</strong></label>
                                <div class="border rounded px-2 py-1" style="background: #fff; min-width: 80px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                    <strong id="calc_cgst_amount">0.00</strong>
                                </div>
                            </div>
                            
                            <!-- SGST Amt -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="min-width: 75px;"><strong>SGST Amt:</strong></label>
                                <div class="border rounded px-2 py-1" style="background: #fff; min-width: 80px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                    <strong id="calc_sgst_amount">0.00</strong>
                                </div>
                            </div>
                            
                            <!-- CESS Amt -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="min-width: 75px;"><strong>CESS Amt:</strong></label>
                                <div class="border rounded px-2 py-1" style="background: #fff; min-width: 80px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                    <strong id="calc_cess_amount">0.00</strong>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Column 2: TAX %, Excise, TCS, SC% -->
                        <div class="d-flex flex-column gap-2">
                            <!-- TAX % -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="min-width: 60px;"><strong>TAX %</strong></label>
                                <input type="number" class="form-control readonly-field" id="calc_tax_percent" readonly step="0.01" style="width: 80px; height: 28px;" value="0.000">
                            </div>
                            
                            <!-- Excise -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="min-width: 60px;"><strong>Excise</strong></label>
                                <input type="number" class="form-control readonly-field" id="calc_excise" readonly step="0.01" style="width: 80px; height: 28px;" value="0.00">
                            </div>
                            
                            <!-- TCS -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="min-width: 60px;"><strong>TCS</strong></label>
                                <input type="number" class="form-control readonly-field" id="calc_tcs" readonly step="0.01" style="width: 80px; height: 28px;" value="0.00">
                            </div>
                        </div>
                        
                        <!-- Column 3: SC%, N -->
                        <div class="d-flex flex-column gap-2">
                            <!-- SC% -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="min-width: 50px;"><strong>SC%</strong></label>
                                <input type="number" class="form-control readonly-field" id="calc_sc_percent" readonly step="0.01" style="width: 70px; height: 28px;" value="0.000">
                            </div>
                            
                            <!-- Empty space for alignment -->
                            <div style="height: 28px;"></div>
                            
                            <!-- N -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="mb-0" style="font-weight: bold;">N</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Summary Section (matching image - pink background) -->
            <div class="bg-white border rounded p-2 mb-2" style="background: #ffcccc;">
                <!-- Row 1: 7 fields -->
                <div class="d-flex align-items-center" style="font-size: 11px; gap: 10px;">
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold; white-space: nowrap;">N.T.Amt.</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="nt_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                    
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold;">SC</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="sc_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                    
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold;">F.T.Amt.</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="ft_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                    
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold;">Dis.</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="dis_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                    
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold;">Scm.</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                    
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold;">Tax</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="tax_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                    
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold;">Net</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="net_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                </div>
                
                <!-- Row 2: Only Scm.% -->
                <div class="d-flex align-items-center mt-2" style="font-size: 11px; gap: 10px;">
                    <div class="d-flex align-items-center" style="gap: 5px;">
                        <label class="mb-0" style="font-weight: bold;">Scm.%</label>
                        <input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_percent" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                    </div>
                </div>
            </div>
            
            <!-- Detailed Info Section (matching image - orange background) -->
            <div class="bg-white border rounded p-2 mb-2" style="background: #ffe6cc;">
                <table style="width: 100%; font-size: 11px; border-collapse: collapse;">
                    <!-- Row 1: Packing | N.T.Amt. | Scm. % | Sub.Tot. | Comp | Srino -->
                    <tr>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Packing</strong></td>
                        <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field" id="detailPacking" readonly value="" style="height: 22px; width: 60px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>N.T.Amt.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailNtAmt" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Scm. %</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailScmPercent" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Sub.Tot.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailSubTot" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Comp</strong></td>
                        <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field" id="detailCompany" readonly value="" style="height: 22px; width: 100px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Srino</strong></td>
                        <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="detailSrIno" readonly value="" style="height: 22px; width: 60px;"></td>
                    </tr>
                    
                    <!-- Row 2: Unit | SC Amt. | Scm.Amt. | Tax Amt. | SCM. -->
                    <tr>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Unit</strong></td>
                        <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-center" id="detailUnit" readonly value="1" style="height: 22px; width: 60px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>SC Amt.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailScAmt" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Scm.Amt.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailScmAmt" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Tax Amt.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailTaxAmt" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;" colspan="2"><strong>SCM.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-center" id="detailScm1" readonly value="0" style="height: 22px; width: 40px;"></td>
                        <td style="padding: 3px; text-align: center; font-weight: bold;">+</td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-center" id="detailScm2" readonly value="0" style="height: 22px; width: 40px;"></td>
                    </tr>
                    
                    <!-- Row 3: Cl. Qty | Dis. Amt. | Net Amt. | COST + GST | Vol. | Batch Code -->
                    <tr>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Cl. Qty</strong></td>
                        <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field text-end" id="detailClQty" readonly value="" style="height: 22px; width: 60px; background: #add8e6;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Dis. Amt.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailDisAmt" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Net Amt.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailNetAmt" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>COST + GST</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailCostGst" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Vol.</strong></td>
                        <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailVol" readonly value="0" style="height: 22px; width: 40px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Batch Code</strong></td>
                        <td style="padding: 3px;" colspan="2"><input type="text" class="form-control form-control-sm readonly-field text-center" id="detailBatchCode" readonly value="" style="height: 22px; width: 100px;"></td>
                    </tr>
                    
                    <!-- Row 4: Lctn | HS Amt. -->
                    <tr>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>Lctn</strong></td>
                        <td style="padding: 3px;"><input type="text" class="form-control form-control-sm readonly-field" id="detailLctn" readonly value="" style="height: 22px; width: 60px;"></td>
                        <td style="padding: 3px; background: #ffe6cc;"><strong>HS Amt.</strong></td>
                        <td style="padding: 3px;" colspan="9"><input type="number" class="form-control form-control-sm readonly-field text-end" id="detailHsAmt" readonly value="0.00" style="height: 22px; width: 100px;"></td>
                    </tr>
                </table>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary btn-sm" onclick="saveSale()">
                    <i class="bi bi-save"></i> Save
                </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.reload()">
                    <i class="bi bi-x-circle"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Choose Items Modal Backdrop -->
<div id="chooseItemsBackdrop" class="pending-orders-backdrop"></div>

<!-- Choose Items Modal -->
<div id="chooseItemsModal" class="pending-orders-modal">
    <div class="pending-orders-content">
        <div class="pending-orders-header">
            <h5 class="pending-orders-title">Choose Items</h5>
            <button type="button" class="btn-close-modal" onclick="closeChooseItemsModal()" title="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="pending-orders-body">
            <div class="p-3">
                <input type="text" class="form-control mb-3" id="itemSearchInput" placeholder="Search by Name, HSN Code, Company..." autocomplete="off" style="font-size: 12px;">
            </div>
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-hover mb-0" style="font-size: 11px;">
                    <thead style="position: sticky; top: 0; background: #f8f9fa; z-index: 10;">
                        <tr style="background: #ffcccc;">
                            <th style="width: 200px;">Name</th>
                            <th style="width: 120px;">HSN Code</th>
                            <th style="width: 100px;">Pack</th>
                            <th style="width: 150px;">Company</th>
                            <th style="width: 80px;">Qty</th>
                        </tr>
                    </thead>
                    <tbody id="chooseItemsBody">
                        <!-- Items will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pending-orders-footer">
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeChooseItemsModal()">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
        </div>
    </div>
</div>

<!-- Batch Selection Modal Backdrop -->
<div id="batchSelectionBackdrop" class="pending-orders-backdrop"></div>

<!-- Batch Selection Modal -->
<div id="batchSelectionModal" class="pending-orders-modal" style="max-width: 900px;">
    <div class="pending-orders-content">
        <div class="pending-orders-header">
            <h5 class="pending-orders-title">Select Batch</h5>
            <button type="button" class="btn-close-modal" onclick="closeBatchSelectionModal()" title="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="pending-orders-body">
            <div class="p-3 bg-light border-bottom">
                <div class="mb-2">
                    <strong style="font-size: 14px;">Item: <span id="batchItemName" style="color: #7c3aed; font-size: 16px;">---</span></strong>
                </div>
                <input type="text" class="form-control mb-0" id="batchSearchInput" placeholder="Search by Batch No..." autocomplete="off" oninput="filterBatchesInModal()" style="font-size: 12px;">
            </div>
            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table class="table table-bordered mb-0" style="font-size: 11px;">
                    <thead style="position: sticky; top: 0; background: #ffcccc; z-index: 10; font-weight: bold;">
                        <tr>
                            <th style="width: 120px; text-align: left; padding: 8px;">BATCH</th>
                            <th style="width: 80px; text-align: center; padding: 8px;">DATE</th>
                            <th style="width: 90px; text-align: right; padding: 8px;">RATE</th>
                            <th style="width: 90px; text-align: right; padding: 8px;">PRATE</th>
                            <th style="width: 90px; text-align: right; padding: 8px;">MRP</th>
                            <th style="width: 70px; text-align: right; padding: 8px;">QTY.</th>
                            <th style="width: 70px; text-align: right; padding: 8px;">EXP.</th>
                            <th style="width: 80px; text-align: center; padding: 8px;">CODE</th>
                        </tr>
                    </thead>
                    <tbody id="batchSelectionBody">
                        <!-- Batches will be loaded here -->
                    </tbody>
                </table>
            </div>
            
            <!-- Batch Details Section (like in image) -->
            <div class="p-3 bg-white border-top">
                <div class="mb-2" style="font-weight: bold; font-size: 13px; color: #000;">
                    <strong>BRAND : </strong><span id="batchBrand" style="color: #7c3aed;">---</span>
                    <span class="float-end"><strong>Packing : </strong><span id="batchPacking" style="color: #7c3aed;">---</span></span>
                </div>
                <table class="table table-bordered mb-0" style="font-size: 11px;">
                    <thead style="background: #ffcccc; font-weight: bold;">
                        <tr>
                            <th style="padding: 5px;">BATCH</th>
                            <th style="padding: 5px; text-align: center;">DATE</th>
                            <th style="padding: 5px; text-align: right;">RATE</th>
                            <th style="padding: 5px; text-align: right;">PRATE</th>
                            <th style="padding: 5px; text-align: right;">MRP</th>
                            <th style="padding: 5px; text-align: right;">QTY.</th>
                            <th style="padding: 5px; text-align: center;">EXP.</th>
                            <th style="padding: 5px; text-align: center;">CODE</th>
                            <th style="padding: 5px; text-align: right;">Cost+GST</th>
                            <th style="padding: 5px; text-align: center;">SCM</th>
                        </tr>
                    </thead>
                    <tbody id="batchDetailsBody" style="background: #ffcccc;">
                        <tr>
                            <td colspan="10" class="text-center" style="padding: 8px;">Select a batch to view details</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-2" style="font-size: 11px;">
                    <strong>Supplier : </strong><span id="batchSupplier" style="color: #0066cc; font-weight: bold;">---</span>
                </div>
            </div>
        </div>
        <div class="pending-orders-footer">
            <button type="button" class="btn btn-primary btn-sm" onclick="if(window.selectedBatch) selectBatchFromModal(window.selectedBatch); else alert('Please select a batch first');">
                <i class="bi bi-check-circle"></i> Select Batch
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeBatchSelectionModal()">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
        </div>
    </div>
</div>

<script>
// Global variables
let itemsData = [];
let itemIndex = -1;
let currentSelectedRowIndex = null;
let pendingItemSelection = null; // Store item data when waiting for batch selection
let rowGstData = {}; // Store GST calculations for each row

// Load items on page load
document.addEventListener('DOMContentLoaded', function() {
    loadItems();
    
    // Customer name update
    const customerSelect = document.getElementById('customerSelect');
    if (customerSelect) {
        customerSelect.addEventListener('change', updateCustomerName);
    }
    
    // Salesman name update
    const salesmanSelect = document.getElementById('salesmanSelect');
    if (salesmanSelect) {
        salesmanSelect.addEventListener('change', updateSalesmanName);
    }
    
    // Item search in modal
    const itemSearchInput = document.getElementById('itemSearchInput');
    if (itemSearchInput) {
        itemSearchInput.addEventListener('input', filterItemsInModal);
    }
    
    // Batch search in modal
    const batchSearchInput = document.getElementById('batchSearchInput');
    if (batchSearchInput) {
        batchSearchInput.addEventListener('input', filterBatchesInModal);
    }
});

// Load items from server
function loadItems() {
    fetch('{{ route("admin.sale.getItems") }}')
        .then(response => response.json())
        .then(data => {
            itemsData = data;
            console.log('Items loaded:', itemsData.length);
        })
        .catch(error => console.error('Error loading items:', error));
}

// Update invoice type based on series
function updateInvoiceType() {
    const series = document.getElementById('seriesSelect').value;
    const display = document.getElementById('invoiceTypeDisplay');
    if (series === 'S2') {
        display.value = 'GST INVOICE';
    } else if (series === 'SB') {
        display.value = 'TAX INVOICE';
    }
}

// Update customer name (no separate field needed - name shown in dropdown)
function updateCustomerName() {
    // Customer name already displayed in dropdown, no separate field needed
}

// Update salesman name (no separate field needed - name shown in dropdown)
function updateSalesmanName() {
    // Salesman name already displayed in dropdown, no separate field needed
}

// Update day name
function updateDayName() {
    const dateInput = document.getElementById('saleDate');
    const dayNameInput = document.getElementById('dayName');
    if (dateInput.value) {
        const date = new Date(dateInput.value);
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        dayNameInput.value = days[date.getDay()];
    }
}

// Open Choose Items Modal
function openChooseItemsModal() {
    const modal = document.getElementById('chooseItemsModal');
    const backdrop = document.getElementById('chooseItemsBackdrop');
    
    // Load and display items
    displayItemsInModal();
    
    // Show modal
    setTimeout(() => {
        modal.classList.add('show');
        backdrop.classList.add('show');
    }, 10);
}

// Close Choose Items Modal
function closeChooseItemsModal() {
    const modal = document.getElementById('chooseItemsModal');
    const backdrop = document.getElementById('chooseItemsBackdrop');
    modal.classList.remove('show');
    backdrop.classList.remove('show');
}

// Display items in modal
function displayItemsInModal() {
    const tbody = document.getElementById('chooseItemsBody');
    tbody.innerHTML = '';
    
    if (itemsData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No items found</td></tr>';
        return;
    }
    
    itemsData.forEach(item => {
        const row = document.createElement('tr');
        row.style.cursor = 'pointer';
        
        // Get company name (assuming it's in item data, adjust as needed)
        const company = item.company_name || item.company || 'N/A';
        const pack = item.packing || 'N/A';
        const qty = item.qty || item.available_qty || 0;
        
        row.innerHTML = `
            <td>${item.name || 'N/A'}</td>
            <td>${item.hsn_code || 'N/A'}</td>
            <td>${pack}</td>
            <td>${company}</td>
            <td>${qty}</td>
        `;
        
        row.addEventListener('click', function() {
            selectItemFromModal(item);
        });
        
        row.addEventListener('mouseenter', function() {
            if (!this.classList.contains('item-row-selected')) {
                this.style.backgroundColor = '#f8f9fa';
            }
        });
        
        row.addEventListener('mouseleave', function() {
            if (!this.classList.contains('item-row-selected')) {
                this.style.backgroundColor = '';
            }
        });
        
        tbody.appendChild(row);
    });
}

// Filter items in modal
function filterItemsInModal() {
    const searchText = document.getElementById('itemSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#chooseItemsBody tr');
    
    rows.forEach(row => {
        const name = (row.cells[0]?.textContent || '').toLowerCase();
        const hsn = (row.cells[1]?.textContent || '').toLowerCase();
        const company = (row.cells[3]?.textContent || '').toLowerCase();
        
        if (name.includes(searchText) || hsn.includes(searchText) || company.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Select item from modal
function selectItemFromModal(item) {
    // Store item data for batch selection
    pendingItemSelection = item;
    
    // Close items modal
    closeChooseItemsModal();
    
    // Open batch selection modal
    openBatchSelectionModal(item);
}

// Open Batch Selection Modal
function openBatchSelectionModal(item) {
    const modal = document.getElementById('batchSelectionModal');
    const backdrop = document.getElementById('batchSelectionBackdrop');
    
    // Set item name in header
    document.getElementById('batchItemName').textContent = item.name || 'N/A';
    
    // Set initial Brand and Packing (will be updated when batch is selected)
    document.getElementById('batchBrand').textContent = item.name || '---';
    document.getElementById('batchPacking').textContent = item.packing || '---';
    
    // Clear batch details initially
    document.getElementById('batchSupplier').textContent = '---';
    document.getElementById('batchDetailsBody').innerHTML = '<tr><td colspan="10" class="text-center" style="padding: 8px;">Select a batch to view details</td></tr>';
    
    // Load batches for this item
    loadBatchesForItem(item.id);
    
    // Show modal
    setTimeout(() => {
        modal.classList.add('show');
        backdrop.classList.add('show');
    }, 10);
}

// Close Batch Selection Modal
function closeBatchSelectionModal() {
    const modal = document.getElementById('batchSelectionModal');
    const backdrop = document.getElementById('batchSelectionBackdrop');
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    pendingItemSelection = null;
}

// Load batches for item
function loadBatchesForItem(itemId) {
    console.log('🔄 Loading batches for item ID:', itemId);
    
    fetch(`/admin/api/item-batches/${itemId}`)
        .then(response => {
            console.log('📡 Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('✅ Batch data received:', data);
            
            // Handle different response formats
            let batches = [];
            if (Array.isArray(data)) {
                batches = data;
            } else if (data.success && Array.isArray(data.batches)) {
                batches = data.batches;
            } else if (data.batches && Array.isArray(data.batches)) {
                batches = data.batches;
            } else {
                console.warn('⚠️ Unexpected data format:', data);
            }
            
            console.log('📦 Processed batches:', batches);
            displayBatchesInModal(batches);
        })
        .catch(error => {
            console.error('❌ Error loading batches:', error);
            document.getElementById('batchSelectionBody').innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error loading batches</td></tr>';
        });
}

// Display batches in modal (Sale transaction format with correct columns)
function displayBatchesInModal(batches) {
    const tbody = document.getElementById('batchSelectionBody');
    tbody.innerHTML = '';
    
    if (!batches || !Array.isArray(batches) || batches.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No batches found for this item</td></tr>';
        return;
    }
    
    console.log(`✅ Displaying ${batches.length} batches in modal`);
    
    batches.forEach(batch => {
        const row = document.createElement('tr');
        row.style.cursor = 'pointer';
        row.style.background = '#ffcccc'; // Pink background like in image
        row.setAttribute('data-batch', JSON.stringify(batch)); // Store batch data for details
        
        // Purchase date (from transaction) - prioritize display format
        let purchaseDate = 'N/A';
        if (batch.purchase_date_display && batch.purchase_date_display !== 'N/A') {
            purchaseDate = batch.purchase_date_display;
        } else if (batch.purchase_date) {
            // If we have raw date, format it
            try {
                const dateObj = new Date(batch.purchase_date);
                purchaseDate = dateObj.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: '2-digit' }).replace(/\//g, '-');
            } catch (e) {
                purchaseDate = batch.purchase_date;
            }
        }
        
        console.log('Batch date:', { 
            batch_no: batch.batch_no, 
            purchase_date_display: batch.purchase_date_display, 
            purchase_date: batch.purchase_date,
            final_date: purchaseDate 
        });
        
        // Expiry date in MM/YY format
        let expiryDate = 'N/A';
        if (batch.expiry_display) {
            expiryDate = batch.expiry_display;
        } else if (batch.expiry_date) {
            try {
                const date = new Date(batch.expiry_date);
                expiryDate = date.toLocaleDateString('en-GB', { month: '2-digit', year: '2-digit' }).replace('/', '/');
            } catch (e) {
                expiryDate = batch.expiry_date;
            }
        }
        
        // Sale rate (s_rate) - if not available, use item's sale rate
        const saleRate = parseFloat(batch.avg_s_rate || batch.s_rate || 0).toFixed(2);
        
        // Purchase rate
        const purRate = parseFloat(batch.avg_pur_rate || batch.pur_rate || 0).toFixed(2);
        
        // MRP
        const mrp = parseFloat(batch.avg_mrp || batch.mrp || 0).toFixed(2);
        
        // Quantity
        const qty = batch.total_qty || batch.qty || 0;
        
        row.innerHTML = `
            <td style="text-align: left; padding: 5px;">${batch.batch_no || 'N/A'}</td>
            <td style="text-align: center; padding: 5px;">${purchaseDate}</td>
            <td style="text-align: right; padding: 5px;">${saleRate}</td>
            <td style="text-align: right; padding: 5px;">${purRate}</td>
            <td style="text-align: right; padding: 5px;">${mrp}</td>
            <td style="text-align: right; padding: 5px;">${qty}</td>
            <td style="text-align: center; padding: 5px;">${expiryDate}</td>
            <td style="text-align: center; padding: 5px;">---</td>
        `;
        
        row.addEventListener('click', function() {
            // Highlight selected row
            document.querySelectorAll('#batchSelectionBody tr').forEach(r => {
                r.classList.remove('item-row-selected');
            });
            this.classList.add('item-row-selected');
            
            // Populate batch details section
            populateBatchDetails(batch);
            
            // Store selected batch for when user confirms selection
            window.selectedBatch = batch;
        });
        
        // Double-click to select and add to table
        row.addEventListener('dblclick', function() {
            if (pendingItemSelection && window.selectedBatch) {
                selectBatchFromModal(window.selectedBatch);
            }
        });
        
        row.addEventListener('mouseenter', function() {
            if (!this.classList.contains('item-row-selected')) {
                this.style.backgroundColor = '#ffb3b3'; // Darker pink on hover
            }
        });
        
        row.addEventListener('mouseleave', function() {
            if (!this.classList.contains('item-row-selected')) {
                this.style.backgroundColor = '#ffcccc'; // Back to original pink
            }
        });
        
        tbody.appendChild(row);
    });
}

// Populate batch details section when batch is selected
function populateBatchDetails(batch) {
    // Update Brand and Packing
    document.getElementById('batchBrand').textContent = batch.item_name || '---';
    document.getElementById('batchPacking').textContent = batch.packing || '---';
    
    // Update Supplier
    document.getElementById('batchSupplier').textContent = batch.supplier_name || '---';
    
    // Populate details table
    const detailsBody = document.getElementById('batchDetailsBody');
    detailsBody.innerHTML = '';
    
    const row = document.createElement('tr');
    row.style.background = '#ffcccc';
    
    // Purchase date - prioritize display format
    let purchaseDate = 'N/A';
    if (batch.purchase_date_display && batch.purchase_date_display !== 'N/A') {
        purchaseDate = batch.purchase_date_display;
    } else if (batch.purchase_date) {
        // If we have raw date, format it
        try {
            const dateObj = new Date(batch.purchase_date);
            purchaseDate = dateObj.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: '2-digit' }).replace(/\//g, '-');
        } catch (e) {
            purchaseDate = batch.purchase_date;
        }
    }
    
    // Expiry date
    const expiryDate = batch.expiry_display || 'N/A';
    
    // Sale rate
    const saleRate = parseFloat(batch.avg_s_rate || batch.s_rate || 0).toFixed(2);
    
    // Purchase rate
    const purRate = parseFloat(batch.avg_pur_rate || batch.pur_rate || 0).toFixed(2);
    
    // MRP
    const mrp = parseFloat(batch.avg_mrp || batch.mrp || 0).toFixed(2);
    
    // Quantity
    const qty = batch.total_qty || batch.qty || 0;
    
    // Cost+GST
    const costGst = parseFloat(batch.avg_cost_gst || batch.cost_gst || 0).toFixed(2);
    
    row.innerHTML = `
        <td style="padding: 5px;">${batch.batch_no || 'N/A'}</td>
        <td style="padding: 5px; text-align: center;">${purchaseDate}</td>
        <td style="padding: 5px; text-align: right;">${saleRate}</td>
        <td style="padding: 5px; text-align: right;">${purRate}</td>
        <td style="padding: 5px; text-align: right;">${mrp}</td>
        <td style="padding: 5px; text-align: right;">${qty}</td>
        <td style="padding: 5px; text-align: center;">${expiryDate}</td>
        <td style="padding: 5px; text-align: center;">---</td>
        <td style="padding: 5px; text-align: right;">${costGst}</td>
        <td style="padding: 5px; text-align: center;"></td>
    `;
    
    detailsBody.appendChild(row);
}

// Filter batches in modal
function filterBatchesInModal() {
    const searchText = document.getElementById('batchSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#batchSelectionBody tr');
    
    rows.forEach(row => {
        const batchNo = (row.cells[0]?.textContent || '').toLowerCase();
        if (batchNo.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Select batch from modal (called when batch row is double-clicked or confirm button is clicked)
function selectBatchFromModal(batch) {
    if (!pendingItemSelection) return;
    
    // Use the batch from window.selectedBatch if available, otherwise use passed batch
    const selectedBatch = window.selectedBatch || batch;
    
    if (!selectedBatch) {
        alert('Please select a batch first');
        return;
    }
    
    // Add item to table with batch
    addItemToTable(pendingItemSelection, selectedBatch);
    
    // Close batch modal
    closeBatchSelectionModal();
    
    // Clear selected batch
    window.selectedBatch = null;
}

// Add item to table
function addItemToTable(item, batch) {
    itemIndex++;
    const tbody = document.getElementById('itemsTableBody');
    
    const newRow = document.createElement('tr');
    newRow.setAttribute('data-row-index', itemIndex);
    newRow.setAttribute('data-item-id', item.id);
    newRow.style.cursor = 'pointer';
    newRow.addEventListener('click', function(e) {
        const clickedRow = e.currentTarget;
        const rowIdx = parseInt(clickedRow.getAttribute('data-row-index'));
        selectRow(rowIdx);
    });
    
    // Don't populate qty - user will enter it manually
    const qty = 0;
    // Use batch's sale rate if available, otherwise use item's sale rate
    const rate = parseFloat(batch.avg_s_rate || batch.s_rate || item.s_rate || 0);
    const amount = 0.00;  // Will be calculated when user enters qty
    
    // Format expiry date for display
    let expiryDisplay = '';
    if (batch.expiry_display) {
        expiryDisplay = batch.expiry_display;
    } else if (batch.expiry_date) {
        try {
            const date = new Date(batch.expiry_date);
            expiryDisplay = date.toLocaleDateString('en-GB', { month: '2-digit', year: '2-digit' }).replace('/', '/');
        } catch (e) {
            expiryDisplay = batch.expiry_date;
        }
    }
    
    newRow.innerHTML = `
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][code]" value="${item.bar_code || ''}" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][item_name]" value="${item.name || ''}" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][batch]" value="${batch.batch_no || ''}" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][expiry]" value="${expiryDisplay}" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0 item-qty" name="items[${itemIndex}][qty]" id="qty_${itemIndex}" value="" placeholder="0" style="font-size: 10px;" data-row="${itemIndex}" onchange="calculateRowAmount(${itemIndex})" oninput="calculateRowAmount(${itemIndex})"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][free_qty]" id="free_qty_${itemIndex}" value="0" style="font-size: 10px;"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0 item-rate" name="items[${itemIndex}][rate]" id="rate_${itemIndex}" value="${rate.toFixed(2)}" step="0.01" style="font-size: 10px;" data-row="${itemIndex}" onchange="calculateRowAmount(${itemIndex})" oninput="calculateRowAmount(${itemIndex})"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0 item-discount" name="items[${itemIndex}][discount]" id="discount_${itemIndex}" value="0" step="0.01" style="font-size: 10px;" data-row="${itemIndex}" onchange="calculateRowAmount(${itemIndex})" oninput="calculateRowAmount(${itemIndex})"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][mrp]" id="mrp_${itemIndex}" value="${parseFloat(batch.avg_mrp || batch.mrp || item.mrp || 0).toFixed(2)}" step="0.01" style="font-size: 10px;" readonly></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][amount]" id="amount_${itemIndex}" value="0.00" style="font-size: 10px;" readonly></td>
        <td class="p-0 text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${itemIndex})" title="Delete Row" style="font-size: 9px; padding: 2px 5px;">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    
    // Store item data in row attributes
    newRow.setAttribute('data-hsn-code', item.hsn_code || '');
    newRow.setAttribute('data-cgst', item.cgst_percent || 0);
    newRow.setAttribute('data-sgst', item.sgst_percent || 0);
    newRow.setAttribute('data-cess', item.cess_percent || 0);
    newRow.setAttribute('data-packing', item.packing || '');
    newRow.setAttribute('data-unit', item.unit || '');
    newRow.setAttribute('data-company', item.company_name || item.company || '');
    newRow.setAttribute('data-batch-code', batch.batch_no || '');
    newRow.setAttribute('data-case-qty', item.case_qty || 0);
    newRow.setAttribute('data-box-qty', item.box_qty || 0);
    
    // Store batch purchase details
    newRow.setAttribute('data-batch-purchase-rate', batch.avg_pur_rate || batch.pur_rate || 0);
    newRow.setAttribute('data-batch-cost-gst', batch.avg_cost_gst || batch.cost_gst || 0);
    newRow.setAttribute('data-batch-supplier', batch.supplier_name || '');
    
    // Mark row as incomplete initially
    newRow.setAttribute('data-complete', 'false');
    newRow.classList.add('table-danger'); // Red background for incomplete
    newRow.setAttribute('data-batch-purchase-date', batch.purchase_date_display || batch.purchase_date || '');
    
    tbody.appendChild(newRow);
    
    // Add event listeners for editing
    addRowEventListeners(newRow, itemIndex);
    
    // Update row color
    updateRowColor(itemIndex);
    
    // Select the row (this will populate detailed summary immediately)
    selectRow(itemIndex);
    
    // Update detailed summary immediately since item is populated
    updateDetailedSummary(itemIndex);
    
    // Scroll row into view
    newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    
    // Focus on Qty field after a small delay to ensure DOM is ready
    setTimeout(() => {
        const qtyField = document.getElementById(`qty_${itemIndex}`);
        if (qtyField) {
            qtyField.focus();
            // Don't select - let user type directly
        }
    }, 100);
    
    // Calculate totals
    calculateTotal();
}

// Add event listeners to row for editing functionality
function addRowEventListeners(row, rowIndex) {
    // Get all input fields in order
    const qtyInput = row.querySelector('input[name*="[qty]"]');
    const freeQtyInput = row.querySelector('input[name*="[free_qty]"]');
    const rateInput = row.querySelector('input[name*="[rate]"]');
    const discountInput = row.querySelector('input[name*="[discount]"]');
    
    // Qty field - Enter moves to Free Qty
    if (qtyInput) {
        qtyInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                calculateRowAmount(rowIndex);
                if (freeQtyInput) freeQtyInput.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                navigateToRow(rowIndex - 1);
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                navigateToRow(rowIndex + 1);
            }
        });
    }
    
    // Free Qty field - Enter moves to Rate
    if (freeQtyInput) {
        freeQtyInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (rateInput) rateInput.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                navigateToRow(rowIndex - 1);
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                navigateToRow(rowIndex + 1);
            }
        });
    }
    
    // Rate field - Enter moves to Discount
    if (rateInput) {
        rateInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                calculateRowAmount(rowIndex);
                if (discountInput) discountInput.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                navigateToRow(rowIndex - 1);
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                navigateToRow(rowIndex + 1);
            }
        });
    }
    
    // Discount field - Enter finalizes row and moves to next
    if (discountInput) {
        discountInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                calculateRowAmount(rowIndex);
                calculateTotal();
                
                // Move to next row (this will mark row complete, turn green, and update summary)
                moveToNextRow(rowIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                navigateToRow(rowIndex - 1);
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                navigateToRow(rowIndex + 1);
            }
        });
    }
    
    // Listen for code changes to fetch item details
    const codeInput = row.querySelector('input[name*="[code]"]');
    if (codeInput) {
        codeInput.addEventListener('blur', function() {
            const itemCode = this.value.trim();
            if (itemCode) {
                fetchItemDetailsForRow(itemCode, rowIndex);
            } else {
                clearDetailedSummary();
            }
        });
        
        codeInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const itemCode = this.value.trim();
                if (itemCode) {
                    fetchItemDetailsForRow(itemCode, rowIndex);
                }
                // Move to next field
                const nextInput = row.querySelector('input[name*="[item_name]"]');
                if (nextInput) nextInput.focus();
            }
        });
    }
    
    // Listen for item name changes
    const nameInput = row.querySelector('input[name*="[item_name]"]');
    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            updateDetailedSummary(rowIndex);
        });
    }
    
    // Listen for batch changes
    const batchInput = row.querySelector('input[name*="[batch]"]');
    if (batchInput) {
        batchInput.addEventListener('blur', function() {
            updateDetailedSummary(rowIndex);
        });
    }
    
    // Listen for expiry changes
    const expiryInput = row.querySelector('input[name*="[expiry]"]');
    if (expiryInput) {
        expiryInput.addEventListener('blur', function() {
            updateDetailedSummary(rowIndex);
        });
    }
}

// Navigate to specific row
function navigateToRow(targetRowIndex) {
    // Check if row exists by data-row-index
    const targetRow = document.querySelector(`tr[data-row-index="${targetRowIndex}"]`);
    if (!targetRow) {
        return; // Row doesn't exist
    }
    
    // Select the row
    selectRow(targetRowIndex);
    
    // Focus on qty field
    const qtyField = document.getElementById(`qty_${targetRowIndex}`);
    if (qtyField) {
        qtyField.focus();
        // Don't select - let user continue typing
    }
}

// Move to next row (create new if needed)
function moveToNextRow(currentRowIndex) {
    // Mark current row as complete (will turn green if complete)
    updateRowColor(currentRowIndex);
    
    // Recalculate summary section (now that row might be complete)
    calculateSummary();
    
    // Find next row by checking all rows and their data-row-index
    const allRows = document.querySelectorAll('#itemsTableBody tr');
    let nextRowIndex = null;
    let currentRowFound = false;
    
    allRows.forEach(row => {
        const rowIdx = parseInt(row.getAttribute('data-row-index'));
        if (currentRowFound && nextRowIndex === null) {
            nextRowIndex = rowIdx;
        }
        if (rowIdx === currentRowIndex) {
            currentRowFound = true;
        }
    });
    
    // Check if next row exists
    if (nextRowIndex !== null) {
        // Next row exists, navigate to it
        navigateToRow(nextRowIndex);
    } else {
        // No next row, create a new one
        addNewRow();
        // Navigate to the newly created row
        setTimeout(() => {
            navigateToRow(itemIndex);
        }, 100);
    }
}

// Fetch item details when code is entered/changed
function fetchItemDetailsForRow(itemCode, rowIndex) {
    fetch(`/admin/items/get-by-code/${itemCode}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.item) {
                // Update row with item data
                const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
                if (row) {
                    // Update item name if empty
                    const nameInput = row.querySelector('input[name*="[item_name]"]');
                    if (nameInput && !nameInput.value.trim()) {
                        nameInput.value = data.item.name || '';
                    }
                    
                    // Update MRP if empty
                    const mrpInput = row.querySelector('input[name*="[mrp]"]');
                    if (mrpInput) {
                        mrpInput.value = parseFloat(data.item.mrp || 0).toFixed(2);
                    }
                    
                    // Update row attributes
                    row.setAttribute('data-hsn-code', data.item.hsn_code || '');
                    row.setAttribute('data-cgst', data.item.cgst_percent || 0);
                    row.setAttribute('data-sgst', data.item.sgst_percent || 0);
                    row.setAttribute('data-cess', data.item.cess_percent || 0);
                    row.setAttribute('data-packing', data.item.packing || '');
                    row.setAttribute('data-unit', data.item.unit || '1');
                    row.setAttribute('data-company', data.item.company_name || data.item.company || '');
                    row.setAttribute('data-case-qty', data.item.case_qty || 0);
                    row.setAttribute('data-box-qty', data.item.box_qty || 0);
                    
                    // Update sale rate if empty
                    const rateInput = row.querySelector('input[name*="[rate]"]');
                    if (rateInput && (!rateInput.value || parseFloat(rateInput.value) === 0)) {
                        rateInput.value = parseFloat(data.item.s_rate || 0).toFixed(2);
                        calculateRowAmount(rowIndex);
                    }
                }
                
                // Update detailed summary
                updateDetailedSummary(rowIndex);
                
                // Update calculation section
                updateCalculationSection(rowIndex);
            } else {
                console.log('Item not found:', itemCode);
            }
        })
        .catch(error => {
            console.error('Error fetching item:', error);
        });
}


// Select row
function selectRow(rowIndex) {
    // Find the actual row by data-row-index attribute
    const targetRow = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
    if (!targetRow) {
        return; // Row doesn't exist
    }
    
    // Remove previous selection from all rows
    const allRows = document.querySelectorAll('#itemsTableBody tr');
    allRows.forEach(r => r.classList.remove('row-selected'));
    
    // Add selection to target row
    targetRow.classList.add('row-selected');
    currentSelectedRowIndex = rowIndex;
    
    // Scroll row into view if needed
    targetRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    
    // Update calculation section (HSN, GST, Case, Box)
    updateCalculationSection(rowIndex);
    
    // Update detailed summary section
    updateDetailedSummary(rowIndex);
}

// Update calculation section with current row data
function updateCalculationSection(rowIndex) {
    const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
    if (!row) {
        clearCalculationSection();
        return;
    }
    
    // Get item data
    const hsnCode = row.getAttribute('data-hsn-code') || '---';
    const cgst = parseFloat(row.getAttribute('data-cgst') || 0);
    const sgst = parseFloat(row.getAttribute('data-sgst') || 0);
    const cess = parseFloat(row.getAttribute('data-cess') || 0);
    const caseQty = parseFloat(row.getAttribute('data-case-qty') || 0);
    const boxQty = parseFloat(row.getAttribute('data-box-qty') || 0);
    
    // Get current values from inputs
    const qty = parseFloat(document.getElementById(`qty_${rowIndex}`)?.value) || 0;
    const rate = parseFloat(document.getElementById(`rate_${rowIndex}`)?.value) || 0;
    const discount = parseFloat(document.getElementById(`discount_${rowIndex}`)?.value) || 0;
    
    // Calculate total amount (before discount)
    const totalAmount = qty * rate;
    
    // Calculate discount amount
    const discountAmount = totalAmount * (discount / 100);
    
    // Calculate discounted amount (amount after discount)
    const discountedAmount = totalAmount - discountAmount;
    
    // Calculate Case and Box
    const cases = caseQty > 0 ? Math.floor(qty / caseQty) : 0;
    const boxes = boxQty > 0 ? Math.floor((qty % caseQty) / boxQty) : 0;
    
    // Update Case and Box
    document.getElementById('calc_case').value = cases;
    document.getElementById('calc_box').value = boxes;
    
    // Update HSN Code
    document.getElementById('calc_hsn_code').value = hsnCode;
    
    // Update GST percentages
    document.getElementById('calc_cgst').value = cgst.toFixed(2);
    document.getElementById('calc_sgst').value = sgst.toFixed(2);
    document.getElementById('calc_cess').value = cess.toFixed(2);
    
    // Calculate total tax percentage
    const totalTaxPercent = cgst + sgst + cess;
    document.getElementById('calc_tax_percent').value = totalTaxPercent.toFixed(3);
    
    // Calculate GST amounts on DISCOUNTED AMOUNT
    if (discountedAmount > 0) {
        const cgstAmount = (discountedAmount * cgst / 100).toFixed(2);
        const sgstAmount = (discountedAmount * sgst / 100).toFixed(2);
        const cessAmount = (discountedAmount * cess / 100).toFixed(2);
        
        document.getElementById('calc_cgst_amount').textContent = cgstAmount;
        document.getElementById('calc_sgst_amount').textContent = sgstAmount;
        document.getElementById('calc_cess_amount').textContent = cessAmount;
    } else {
        document.getElementById('calc_cgst_amount').textContent = '0.00';
        document.getElementById('calc_sgst_amount').textContent = '0.00';
        document.getElementById('calc_cess_amount').textContent = '0.00';
    }
}

// Clear calculation section
function clearCalculationSection() {
    document.getElementById('calc_case').value = '0';
    document.getElementById('calc_box').value = '0';
    document.getElementById('calc_hsn_code').value = '---';
    document.getElementById('calc_cgst').value = '0';
    document.getElementById('calc_sgst').value = '0';
    document.getElementById('calc_cess').value = '0';
    document.getElementById('calc_tax_percent').value = '0.000';
    document.getElementById('calc_cgst_amount').textContent = '0.00';
    document.getElementById('calc_sgst_amount').textContent = '0.00';
    document.getElementById('calc_cess_amount').textContent = '0.00';
}

// Update detailed summary section (shows when item is populated)
function updateDetailedSummary(rowIndex) {
    const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
    if (!row) {
        clearDetailedSummary();
        return;
    }
    
    // Get item code to check if item is populated
    const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim() || '';
    const itemName = row.querySelector('input[name*="[item_name]"]')?.value?.trim() || '';
    
    // Only show details if item is populated (has code or name)
    if (!itemCode && !itemName) {
        clearDetailedSummary();
        return;
    }
    
    // Get data from row attributes
    const packing = row.getAttribute('data-packing') || '';
    const unit = row.getAttribute('data-unit') || '1';
    const company = row.getAttribute('data-company') || '';
    const cgst = row.getAttribute('data-cgst') || 0;
    const sgst = row.getAttribute('data-sgst') || 0;
    const cess = row.getAttribute('data-cess') || 0;
    const caseQty = row.getAttribute('data-case-qty') || 0;
    const boxQty = row.getAttribute('data-box-qty') || 0;
    
    // Get batch purchase details
    const batchPurchaseRate = parseFloat(row.getAttribute('data-batch-purchase-rate') || 0);
    
    // Calculate Cost + GST using formula: P.RATE × (1 + TotalGST%)
    const totalGstPercent = parseFloat(cgst) + parseFloat(sgst) + parseFloat(cess);
    const costPlusGst = batchPurchaseRate * (1 + (totalGstPercent / 100));
    
    // Get values from inputs
    const qty = parseFloat(document.getElementById(`qty_${rowIndex}`)?.value) || 0;
    const rate = parseFloat(document.getElementById(`rate_${rowIndex}`)?.value) || 0;
    const discount = parseFloat(document.getElementById(`discount_${rowIndex}`)?.value) || 0;
    
    // ALWAYS show basic fields
    document.getElementById('detailPacking').value = packing;
    document.getElementById('detailUnit').value = unit;
    document.getElementById('detailCompany').value = company;
    document.getElementById('detailCostGst').value = costPlusGst.toFixed(2);
    
    // Get batch code from row
    const batchInput = row.querySelector('input[name*="[batch]"]');
    const batchCodeValue = batchInput ? batchInput.value : '';
    document.getElementById('detailBatchCode').value = batchCodeValue;
    
    // Fetch total quantity from all batches for this item
    const itemId = row.getAttribute('data-item-id');
    if (itemId) {
        fetchTotalBatchQuantity(itemId);
    } else {
        // If no item ID, just show current row quantity
        document.getElementById('detailClQty').value = qty || '';
    }
    
    // Calculate amounts properly
    const ntAmt = qty * rate;  // N.T.Amt = Total amount before discount
    const discountAmt = ntAmt * (discount / 100);  // Discount amount
    const subTot = ntAmt - discountAmt;  // Sub.Tot = Amount after discount
    
    // Calculate tax on DISCOUNTED amount (Sub.Tot)
    const taxAmt = subTot * ((parseFloat(cgst) + parseFloat(sgst) + parseFloat(cess)) / 100);
    
    // Net Amount = Sub.Tot + Tax
    const netAmt = subTot + taxAmt;
    
    // Update detailed summary fields
    document.getElementById('detailNtAmt').value = ntAmt.toFixed(2);  // Total before discount
    document.getElementById('detailDisAmt').value = discountAmt.toFixed(2);  // Discount amount
    document.getElementById('detailSubTot').value = subTot.toFixed(2);  // Sub Total = Total - Discount
    document.getElementById('detailTaxAmt').value = taxAmt.toFixed(2);  // Tax on discounted amount
    document.getElementById('detailNetAmt').value = netAmt.toFixed(2);  // Final net amount
    document.getElementById('detailScAmt').value = '0.00';  // SC Amount (not used)
    document.getElementById('detailScmPercent').value = '0.00';  // Scm % (not used)
    document.getElementById('detailScmAmt').value = '0.00';  // Scm Amount (not used)
    document.getElementById('detailHsAmt').value = '0.00';  // HS Amount (not used)
    document.getElementById('detailLctn').value = '';  // Location (not used)
    document.getElementById('detailVol').value = '0';  // Volume (not used)
    document.getElementById('detailSrIno').value = '';  // Serial no (not used)
    document.getElementById('detailScm1').value = '0';  // Scm 1 (not used)
    document.getElementById('detailScm2').value = '0';  // Scm 2 (not used)
}

// Fetch total quantity from all batches for an item
function fetchTotalBatchQuantity(itemId) {
    fetch(`/admin/api/item-batches/${itemId}`)
        .then(response => response.json())
        .then(data => {
            // Handle different response formats
            let batches = [];
            if (Array.isArray(data)) {
                batches = data;
            } else if (data.success && Array.isArray(data.batches)) {
                batches = data.batches;
            } else if (data.batches && Array.isArray(data.batches)) {
                batches = data.batches;
            }
            
            // Sum up total quantity from all batches
            let totalQty = 0;
            batches.forEach(batch => {
                const batchQty = parseFloat(batch.total_qty || batch.qty || 0);
                totalQty += batchQty;
            });
            
            // Update CL QTY field with total from all batches
            document.getElementById('detailClQty').value = totalQty > 0 ? totalQty : '';
        })
        .catch(error => {
            console.error('Error fetching batch quantities:', error);
            // On error, show empty or current qty
            document.getElementById('detailClQty').value = '';
        });
}

// Clear detailed summary
function clearDetailedSummary() {
    document.getElementById('detailPacking').value = '';
    document.getElementById('detailUnit').value = '1';
    document.getElementById('detailCompany').value = '';
    document.getElementById('detailClQty').value = '';
    document.getElementById('detailLctn').value = '';
    document.getElementById('detailBatchCode').value = '';
    document.getElementById('detailNtAmt').value = '0.00';
    document.getElementById('detailScAmt').value = '0.00';
    document.getElementById('detailDisAmt').value = '0.00';
    document.getElementById('detailHsAmt').value = '0.00';
    document.getElementById('detailScmPercent').value = '0.00';
    document.getElementById('detailScmAmt').value = '0.00';
    document.getElementById('detailSubTot').value = '0.00';
    document.getElementById('detailTaxAmt').value = '0.00';
    document.getElementById('detailNetAmt').value = '0.00';
    document.getElementById('detailCostGst').value = '0.00';
    document.getElementById('detailVol').value = '0';
    document.getElementById('detailSrIno').value = '';
    document.getElementById('detailScm1').value = '0';
    document.getElementById('detailScm2').value = '0';
}

// Calculate row amount
function calculateRowAmount(rowIndex) {
    const qty = parseFloat(document.getElementById(`qty_${rowIndex}`)?.value) || 0;
    const rate = parseFloat(document.getElementById(`rate_${rowIndex}`)?.value) || 0;
    
    // Amount = Qty × Rate ONLY (discount NOT applied here)
    const amount = qty * rate;
    
    document.getElementById(`amount_${rowIndex}`).value = amount.toFixed(2);
    
    // Update row color
    updateRowColor(rowIndex);
    
    // Calculate totals
    calculateTotal();
    
    // Always update summary (not just for complete rows)
    calculateSummary();
    
    // If this is the currently selected row, update calculation & detailed summary
    if (currentSelectedRowIndex === rowIndex) {
        updateCalculationSection(rowIndex);
        updateDetailedSummary(rowIndex);
    }
}

// Check if row is complete (always true when called from moveToNextRow)
function isRowComplete(rowIndex) {
    const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
    if (!row) return false;
    
    // If row has any data, consider it complete
    // User can always edit it later
    const code = row.querySelector('input[name*="[code]"]')?.value?.trim();
    const itemName = row.querySelector('input[name*="[item_name]"]')?.value?.trim();
    
    // Row is complete if it has item code or name
    return (code || itemName) ? true : false;
}

// Update row color based on completion
function updateRowColor(rowIndex) {
    const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
    if (!row) return;
    
    // Remove old color classes
    row.classList.remove('table-danger', 'table-success');
    
    // Check if row is complete
    if (isRowComplete(rowIndex)) {
        // Mark as complete - GREEN
        row.setAttribute('data-complete', 'true');
        row.classList.add('table-success');
    } else {
        // Mark as incomplete - RED (if has any data)
        const code = row.querySelector('input[name*="[code]"]')?.value?.trim();
        const qty = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
        const rate = parseFloat(row.querySelector('input[name*="[rate]"]')?.value) || 0;
        
        if (code || qty > 0 || rate > 0) {
            row.setAttribute('data-complete', 'false');
            row.classList.add('table-danger');
        }
    }
}

// Calculate total
function calculateTotal() {
    let total = 0;
    const rows = document.querySelectorAll('#itemsTableBody tr');
    
    rows.forEach(row => {
        const amountInput = row.querySelector('input[name*="[amount]"]');
        if (amountInput) {
            const amount = parseFloat(amountInput.value) || 0;
            total += amount;
        }
    });
    
    document.getElementById('totalAmount').value = total.toFixed(2);
}

// Calculate summary (when all rows are complete)
function calculateSummary() {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    let totalNtAmt = 0;      // N.T.Amt - Total amount before discount
    let totalDisAmt = 0;     // Dis - Total discount amount
    let totalFTAmt = 0;      // F.T.Amt - Total after discount (before tax)
    let totalTax = 0;        // Tax - Total CGST + SGST + CESS
    let totalNet = 0;        // Net - Final amount
    
    rows.forEach(row => {
        // Count ALL rows that have item data (RED or GREEN doesn't matter)
        const rowIndex = row.getAttribute('data-row-index');
        const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
        const itemName = row.querySelector('input[name*="[item_name]"]')?.value?.trim();
        
        // Only process rows that have item
        if (itemCode || itemName) {
            const qty = parseFloat(document.getElementById(`qty_${rowIndex}`)?.value) || 0;
            const rate = parseFloat(document.getElementById(`rate_${rowIndex}`)?.value) || 0;
            const discount = parseFloat(document.getElementById(`discount_${rowIndex}`)?.value) || 0;
            
            // Calculate amounts for this row
            const rowAmount = qty * rate;  // Amount before discount
            const rowDiscount = rowAmount * (discount / 100);  // Discount amount
            const rowAfterDiscount = rowAmount - rowDiscount;  // Amount after discount
            
            // Get GST percentages
            const cgst = parseFloat(row.getAttribute('data-cgst')) || 0;
            const sgst = parseFloat(row.getAttribute('data-sgst')) || 0;
            const cess = parseFloat(row.getAttribute('data-cess')) || 0;
            
            // Calculate tax on DISCOUNTED amount
            const rowTax = rowAfterDiscount * ((cgst + sgst + cess) / 100);
            
            // Add to totals
            totalNtAmt += rowAmount;
            totalDisAmt += rowDiscount;
            totalFTAmt += rowAfterDiscount;
            totalTax += rowTax;
        }
    });
    
    // Calculate Net Amount: Amount after discount + Tax
    totalNet = totalFTAmt + totalTax;
    
    // Update summary fields
    document.getElementById('nt_amt').value = totalNtAmt.toFixed(2);  // Total before discount
    document.getElementById('sc_amt').value = '0.00';  // SC (not used in sale)
    document.getElementById('ft_amt').value = totalNtAmt.toFixed(2);  // F.T.Amt = N.T.Amt
    document.getElementById('dis_amt').value = totalDisAmt.toFixed(2);  // Total discount
    document.getElementById('scm_amt').value = '0.00';  // Scm (not used)
    document.getElementById('tax_amt').value = totalTax.toFixed(2);  // Total tax
    document.getElementById('net_amt').value = totalNet.toFixed(2);  // Final net amount
    document.getElementById('scm_percent').value = '0.00';  // Scm % (not used)
}

// Add new empty row
function addNewRow() {
    itemIndex++;
    const tbody = document.getElementById('itemsTableBody');
    
    const newRow = document.createElement('tr');
    newRow.setAttribute('data-row-index', itemIndex);
    newRow.style.cursor = 'pointer';
    newRow.addEventListener('click', function(e) {
        const clickedRow = e.currentTarget;
        const rowIdx = parseInt(clickedRow.getAttribute('data-row-index'));
        selectRow(rowIdx);
    });
    
    newRow.innerHTML = `
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][code]" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][item_name]" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][batch]" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][expiry]" style="font-size: 10px;" autocomplete="off"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0 item-qty" name="items[${itemIndex}][qty]" id="qty_${itemIndex}" value="" placeholder="0" style="font-size: 10px;" data-row="${itemIndex}" onchange="calculateRowAmount(${itemIndex})" oninput="calculateRowAmount(${itemIndex})"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][free_qty]" id="free_qty_${itemIndex}" value="0" style="font-size: 10px;"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0 item-rate" name="items[${itemIndex}][rate]" id="rate_${itemIndex}" value="0" step="0.01" style="font-size: 10px;" data-row="${itemIndex}" onchange="calculateRowAmount(${itemIndex})" oninput="calculateRowAmount(${itemIndex})"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0 item-discount" name="items[${itemIndex}][discount]" id="discount_${itemIndex}" value="0" step="0.01" style="font-size: 10px;" data-row="${itemIndex}" onchange="calculateRowAmount(${itemIndex})" oninput="calculateRowAmount(${itemIndex})"></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][mrp]" id="mrp_${itemIndex}" value="0" step="0.01" style="font-size: 10px;" readonly></td>
        <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][amount]" id="amount_${itemIndex}" value="0.00" style="font-size: 10px;" readonly></td>
        <td class="p-0 text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${itemIndex})" title="Delete Row" style="font-size: 9px; padding: 2px 5px;">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    
    // Mark as incomplete initially
    newRow.setAttribute('data-complete', 'false');
    newRow.classList.add('table-danger'); // Red background for incomplete
    
    tbody.appendChild(newRow);
    
    // Add event listeners for editing
    addRowEventListeners(newRow, itemIndex);
    
    // Focus on code field
    setTimeout(() => {
        const codeInput = newRow.querySelector('input[name*="[code]"]');
        if (codeInput) {
            codeInput.focus();
        }
    }, 100);
}

// Delete row
function deleteRow(rowIndex) {
    const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
    if (row) {
        row.remove();
        calculateTotal();
        calculateSummary();
        
        // Clear detailed summary if deleted row was selected
        if (currentSelectedRowIndex === rowIndex) {
            clearDetailedSummary();
            currentSelectedRowIndex = null;
        }
    }
}

// Delete selected item
function deleteSelectedItem() {
    if (currentSelectedRowIndex !== null) {
        deleteRow(currentSelectedRowIndex);
    } else {
        alert('Please select a row to delete');
    }
}

// Insert item
function insertItem() {
    openChooseItemsModal();
}

// Save sale transaction
function saveSale() {
    // Collect header data
    const headerData = {
        series: document.getElementById('seriesSelect')?.value || 'SB',
        date: document.getElementById('saleDate')?.value || '',
        invoice_no: document.getElementById('invoiceNo')?.value || '',
        due_date: document.getElementById('dueDate')?.value || null,
        customer_id: document.getElementById('customerSelect')?.value || '',
        salesman_id: document.getElementById('salesmanSelect')?.value || null,
        cash: 'N', // Default cash flag
        transfer: 'N', // Default transfer flag
        remarks: '', // Default remarks
    };
    
    // Validate required fields
    if (!headerData.date) {
        alert('⚠️ Please select Date');
        return;
    }
    
    if (!headerData.customer_id) {
        alert('⚠️ Please select Customer');
        return;
    }
    
    if (!headerData.invoice_no || headerData.invoice_no.trim() === '') {
        alert('⚠️ Invoice No. is required!');
        document.getElementById('invoiceNo').focus();
        return;
    }
    
    // Collect items data (only rows with actual data)
    const items = [];
    const rows = document.querySelectorAll('#itemsTableBody tr');
    
    rows.forEach((row, index) => {
        const itemCode = row.querySelector('input[name*="[code]"]')?.value?.trim();
        const itemName = row.querySelector('input[name*="[item_name]"]')?.value?.trim();
        const qty = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
        const rate = parseFloat(row.querySelector('input[name*="[rate]"]')?.value) || 0;
        
        const hasItemInfo = itemCode || itemName;
        const hasQuantityOrRate = qty > 0 || rate > 0;
        
        if (hasItemInfo && hasQuantityOrRate) {
            items.push({
                item_code: itemCode || '',
                item_name: itemName || '',
                batch: row.querySelector('input[name*="[batch]"]')?.value?.trim() || '',
                expiry: row.querySelector('input[name*="[expiry]"]')?.value || null,
                qty: qty,
                free_qty: parseFloat(row.querySelector('input[name*="[free_qty]"]')?.value) || 0,
                rate: rate,
                discount: parseFloat(row.querySelector('input[name*="[discount]"]')?.value) || 0,
                mrp: parseFloat(row.querySelector('input[name*="[mrp]"]')?.value) || 0,
                amount: parseFloat(row.querySelector('input[name*="[amount]"]')?.value) || 0,
                row_order: index
            });
        }
    });
    
    // Validate items
    if (items.length === 0) {
        alert('⚠️ Please add at least one item.\n\nUse "Choose Items" button to add items.');
        return;
    }
    
    // Prepare final payload
    const payload = {
        ...headerData,
        items: items,
        _token: document.querySelector('input[name="_token"]').value
    };
    
    // Send to server
    fetch('{{ route("admin.sale.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('Non-JSON response:', text.substring(0, 500));
                throw new Error('Server returned HTML instead of JSON. Check Laravel logs for errors.');
            });
        }
        
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('✅ Sale Transaction saved successfully!\n\nInvoice No: ' + data.invoice_no);
            window.location.reload();
        } else {
            alert('❌ Error: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error: ' + error.message + '\n\nCheck browser console for details.');
    });
}

// Close modals on backdrop click
document.getElementById('chooseItemsBackdrop')?.addEventListener('click', closeChooseItemsModal);
document.getElementById('batchSelectionBackdrop')?.addEventListener('click', closeBatchSelectionModal);

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeChooseItemsModal();
        closeBatchSelectionModal();
    }
});
</script>
@endsection
