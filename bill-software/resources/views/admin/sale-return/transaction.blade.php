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
    .readonly-field {
        background: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        cursor: not-allowed;
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

        <!-- Calculation Section -->
        <div class="bg-white border rounded p-3 mb-2" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div class="d-flex align-items-start gap-3 border rounded p-2" style="font-size: 11px; background: #fafafa;">
                <!-- HSN Code Block (First) -->
                <div class="d-flex flex-column gap-2">
                    <!-- HSN Code -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 75px;"><strong>HSN Code:</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_hsn_display" readonly style="width: 100px; height: 28px;" value="---">
                    </div>
                    
                    <!-- CGST(%) -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 75px;"><strong>CGST(%):</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_cgst" readonly style="width: 100px; height: 28px;" value="0">
                    </div>
                    
                    <!-- SGST(%) -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 75px;"><strong>SGST(%):</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_sgst" readonly style="width: 100px; height: 28px;" value="0">
                    </div>
                    
                    <!-- Cess (%) -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0" style="min-width: 75px;"><strong>Cess (%):</strong></label>
                        <input type="text" class="form-control readonly-field text-center" id="calc_cess" readonly style="width: 100px; height: 28px;" value="0">
                    </div>
                </div>
                
                <!-- Right Side Fields -->
                <div class="d-flex gap-3">
                    <!-- Column 1: Tax fields -->
                    <div class="d-flex flex-column gap-2">
                        <!-- CGST Amt -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px;"><strong>CGST Amt:</strong></label>
                            <div class="border rounded px-2 py-1" style="background: #fff; min-width: 70px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                <strong id="calc_cgst_amount">0.00</strong>
                            </div>
                        </div>
                        
                        <!-- SGST Amt -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px;"><strong>SGST Amt:</strong></label>
                            <div class="border rounded px-2 py-1" style="background: #fff; min-width: 70px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                <strong id="calc_sgst_amount">0.00</strong>
                            </div>
                        </div>
                        
                        <!-- CESS Amt -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 75px;"><strong>CESS Amt:</strong></label>
                            <div class="border rounded px-2 py-1" style="background: #fff; min-width: 70px; text-align: right; height: 28px; display: flex; align-items: center; justify-content: flex-end;">
                                <strong id="calc_cess_amount">0.00</strong>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Column 2: Other fields -->
                    <div class="d-flex flex-column gap-2">
                        <!-- TAX % -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 65px;"><strong>TAX %</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_tax_percent" readonly step="0.01" style="width: 80px; height: 28px;" value="0.000">
                        </div>
                        
                        <!-- SC % -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 65px;"><strong>SC %</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_sc_percent" readonly step="0.01" style="width: 80px; height: 28px;" value="0.00">
                        </div>
                        
                        <!-- Excise -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0" style="min-width: 65px;"><strong>Excise</strong></label>
                            <input type="number" class="form-control readonly-field" id="calc_excise" readonly step="0.01" style="width: 80px; height: 28px;" value="0.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="bg-white border rounded p-2 mb-2">
            <!-- Row 1: 6 fields -->
            <div class="d-flex align-items-center" style="font-size: 11px; gap: 10px;">
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">N.T AMT</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="nt_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #fff3cd;" value="0.00">
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
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="tax_amt" readonly step="0.01" style="width: 80px; height: 26px;" value="0.00">
                </div>
            </div>
            
            <!-- Row 2: 6 fields -->
            <div class="d-flex align-items-center mt-2" style="font-size: 11px; gap: 10px;">
                <div class="d-flex align-items-center" style="gap: 5px;">
                    <label class="mb-0" style="font-weight: bold; white-space: nowrap;">NET AMT.</label>
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="net_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #fff3cd; font-weight: bold;" value="0.00">
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
                    <input type="number" class="form-control form-control-sm readonly-field text-end" id="inv_amt" readonly step="0.01" style="width: 80px; height: 26px; background: #fff3cd; font-weight: bold;" value="0.00">
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
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="nt_amt_detail" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Scm.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="scm_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Tax Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="tax_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Cost</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="cost" readonly value="0.00" style="height: 22px; width: 70px;"></td>
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
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="net_amt_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Cost+GST</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="cost_gst" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>P.SCM.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="p_scm1" value="0" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px; text-align: center; font-weight: bold;">+</td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="p_scm2" value="0" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Cl.Qty</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="cl_qty" value="" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>Dis. Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="dis_amt_detail" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Less</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="less_detail" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Comp :</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="comp" value="" style="height: 22px; width: 100px;"></td>
                    <td style="padding: 3px;"><strong>Vol.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="vol" value="0" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>S.SCM.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="s_scm1" value="0" style="height: 22px; width: 40px;"></td>
                    <td style="padding: 3px; text-align: center; font-weight: bold;">+</td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-center" id="s_scm2" value="0" style="height: 22px; width: 40px;"></td>
                </tr>
                <tr>
                    <td style="padding: 3px;"><strong>Pack</strong></td>
                    <td style="padding: 3px;"><input type="text" class="form-control form-control-sm" id="pack_detail" value="" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>Hs.Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="hs_amt" readonly value="0.00" style="height: 22px; width: 80px;"></td>
                    <td style="padding: 3px;"><strong>Gross Amt.</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm readonly-field text-end" id="gross_amt" readonly value="0.00" style="height: 22px; width: 70px;"></td>
                    <td style="padding: 3px;"><strong>Scm%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="scm_percent_detail" value="0.00" style="height: 22px; width: 60px;"></td>
                    <td style="padding: 3px;"><strong>Dis1.%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="dis1_percent" value="0.00" style="height: 22px; width: 60px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="percent1" value="0.00" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="percent2" value="0.00" style="height: 22px; width: 50px;"></td>
                    <td style="padding: 3px;"><strong>%</strong></td>
                    <td style="padding: 3px;"><input type="number" class="form-control form-control-sm text-end" id="percent3" value="0.00" style="height: 22px; width: 50px;"></td>
                </tr>
            </table>
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
