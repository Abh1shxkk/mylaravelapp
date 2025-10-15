@extends('layouts.admin')
@section('title', 'Create New Invoice')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Create New Invoice</h2>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Invoices
                    </a>
                </div>

                <form action="{{ route('admin.invoices.store') }}" method="POST" id="invoiceForm" novalidate>
                    @csrf
                    
                    <!-- Invoice Header Section (Image Structure) -->
                    <div class="card mb-3">
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <!-- Left Section -->
                                <div class="col-md-3 border-end">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-1 small">Series :</label>
                                        <input type="text" class="form-control form-control-sm" id="series" name="series" value="{{ old('series') }}" placeholder="Series">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-1 small">Date :</label>
                                        <input type="date" class="form-control form-control-sm" id="invoice_date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-1 small">Inv.No :</label>
                                        <input type="text" class="form-control form-control-sm" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $nextInvoiceNumber) }}" readonly>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label fw-bold mb-1 small">Due Date :</label>
                                        <input type="date" class="form-control form-control-sm" id="due_date" name="due_date" value="{{ old('due_date') }}">
                                    </div>
                                </div>

                                <!-- Right Section -->
                                <div class="col-md-9">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold mb-1 small">Name</label>
                                            <input type="text" class="form-control form-control-sm" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder="Customer Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold mb-1 small">Sales Man</label>
                                            <input type="text" class="form-control form-control-sm" id="sales_man" name="sales_man" value="{{ old('sales_man') }}" placeholder="Sales Person">
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <label class="form-label fw-bold mb-1 small">Cash :</label>
                                            <input type="number" class="form-control form-control-sm text-end" id="cash_amount" name="cash_amount" value="{{ old('cash_amount', 0) }}" min="0" step="0.01" placeholder="0.00">
                                        </div>
                                    </div>
                                    
                                    <!-- Yellow Highlight Row -->
                                    <div class="row g-2 mt-2" style="background-color: #fff9c4; padding: 8px; border-radius: 4px;">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold mb-1 small">DUE :</label>
                                            <input type="number" class="form-control form-control-sm" id="due_amount" name="due_amount" value="{{ old('due_amount', 0) }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold mb-1 small">PDC :</label>
                                            <input type="number" class="form-control form-control-sm" id="pdc_amount" name="pdc_amount" value="{{ old('pdc_amount', 0) }}" min="0" step="0.01">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold mb-1 small">TOTAL :</label>
                                            <input type="text" class="form-control form-control-sm fw-bold" id="total_display" value="₹0.00" readonly>
                                            <input type="hidden" name="total_amount" id="total_input" value="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Company Information
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-building me-2"></i>Company Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_id" class="form-label">Select Company *</label>
                                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id"
                                        name="company_id" required>
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company_name" class="form-label">Company Name *</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                        id="company_name" name="company_name" value="{{ old('company_name') }}" readonly>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="company_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="company_email" name="company_email"
                                        readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="company_address" class="form-label">Address</label>
                                    <textarea class="form-control" id="company_address" name="company_address" rows="2"
                                        readonly></textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="company_phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="company_phone" name="company_phone"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_gst" class="form-label">GST Number</label>
                                    <input type="text" class="form-control" id="company_gst" name="company_gst" readonly>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Customer Information (Compact) -->
                    <div class="card mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0"><i class="bi bi-person me-2"></i>Customer Information</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 small">Select Customer</label>
                                    <select class="form-select form-select-sm" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 small">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="customer_email" name="customer_email" placeholder="Email">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 small">Phone</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_phone" name="customer_phone" placeholder="Phone">
                                </div>
                            </div>
                            <div class="row g-2 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mb-1 small">Address</label>
                                    <textarea class="form-control form-control-sm" id="customer_address" name="customer_address" rows="1" placeholder="Address"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold mb-1 small">GST Number</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_gst" name="customer_gst" placeholder="GST">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">State</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_state" name="customer_state" placeholder="State">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Code</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_state_code" name="customer_state_code" placeholder="Code">
                                </div>
                            </div>
                        </div>
                    </div>

                   

                    <!-- Invoice Items -->
                    <div class="card mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Invoice Items</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-2" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th style="width: 200px;">Item</th>
                                            <th style="width: 150px;">Description</th>
                                            <th style="width: 100px;">HSN Code</th>
                                            <th style="width: 100px;">Batch</th>
                                            <th style="width: 100px;">Exp.</th>
                                            <th style="width: 70px;">Qty</th>
                                            <th style="width: 70px;">F.Qty</th>
                                            <th style="width: 70px;">Unit</th>
                                            <th style="width: 90px;">Rate</th>
                                            <th style="width: 90px;">Sale Rate</th>
                                            <th style="width: 80px;">Dis.%</th>
                                            <th style="width: 90px;">MRP</th>
                                            <th style="width: 70px;">GST%</th>
                                            <th style="width: 100px;">Amount</th>
                                            <th style="width: 60px;">Action</th>
                                        </tr>
                                    </thead>
                                   <tbody id="itemsTableBody">
                                        <!-- Items will be added dynamically when user clicks "Add Item" -->
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-success btn-sm" id="addItem">
                                <i class="bi bi-plus me-1"></i>Add Item
                            </button>
                        </div>
                    </div>

                    <!-- Invoice Totals (Compact) -->
                    <div class="card mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0"><i class="bi bi-calculator me-2"></i>Invoice Totals</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">Subtotal</label>
                                    <input type="text" class="form-control form-control-sm" id="subtotal" value="₹0.00" readonly>
                                    <input type="hidden" name="subtotal" id="subtotal_input" value="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">Discount</label>
                                    <input type="text" class="form-control form-control-sm" id="total_discount" value="₹0.00" readonly>
                                    <input type="hidden" name="discount_amount" id="discount_input" value="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">Tax</label>
                                    <input type="text" class="form-control form-control-sm" id="tax_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="tax_amount" id="tax_input" value="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">CGST Amt</label>
                                    <input type="text" class="form-control form-control-sm" id="cgst_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="cgst_amount" id="cgst_input" value="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">SGST Amt</label>
                                    <input type="text" class="form-control form-control-sm" id="sgst_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="sgst_amount" id="sgst_input" value="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">IGST Amt</label>
                                    <input type="text" class="form-control form-control-sm" id="igst_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="igst_amount" id="igst_input" value="0.00">
                                </div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 small text-primary">Total Amount</label>
                                    <input type="text" class="form-control form-control-sm fw-bold text-primary" id="total_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="total_amount" id="total_input" value="0.00">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 small">Paid Amount</label>
                                    <input type="number" class="form-control form-control-sm" id="paid_amount" name="paid_amount" value="{{ old('paid_amount', 0) }}" min="0" step="0.01">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mb-1 small">Balance</label>
                                    <input type="text" class="form-control form-control-sm" id="balance_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="balance_amount" id="balance_input" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Calculation Sections (Image Structure) -->
                    <div class="card mb-3">
                        <div class="card-body p-2" style="background-color: #f8f9fa;">
                            <!-- First Row: Case, Box, Red Section (CGST, SGST, Cess), TAX%, Excise, TCS, SC% -->
                            <div class="row g-2 mb-2">
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Case</label>
                                    <input type="number" class="form-control form-control-sm" id="case_qty" name="case_qty" value="0" min="0" step="1">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Box</label>
                                    <input type="number" class="form-control form-control-sm" id="box_qty" name="box_qty" value="0" min="0" step="1">
                                </div>
                                <div class="col-md-2 text-center" style="border: 2px solid #dee2e6; padding: 5px; border-radius: 4px;">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold mb-0 small">CGST(%):</label>
                                        <input type="number" class="form-control form-control-sm" id="cgst_percent" name="cgst_percent" value="0" min="0" max="100" step="0.01">
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label fw-bold mb-0 small">SGST(%):</label>
                                        <input type="number" class="form-control form-control-sm" id="sgst_percent" name="sgst_percent" value="0" min="0" max="100" step="0.01">
                                    </div>
                                    <div>
                                        <label class="form-label fw-bold mb-0 small">Cess (%):</label>
                                        <input type="number" class="form-control form-control-sm" id="cess_percent" name="cess_percent" value="0" min="0" max="100" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">TAX %</label>
                                    <input type="number" class="form-control form-control-sm" id="tax_percent" name="tax_percent" value="0" min="0" max="100" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Excise</label>
                                    <input type="number" class="form-control form-control-sm" id="excise" name="excise" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">TCS</label>
                                    <input type="number" class="form-control form-control-sm" id="tcs" name="tcs" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">SC %</label>
                                    <input type="number" class="form-control form-control-sm" id="sc_percent" name="sc_percent" value="0" min="0" max="100" step="0.01">
                                </div>
                            </div>

                            <!-- Second Row: M.T.Amt, SC, F.T.Amt, Dis., Scm., Tax, Net -->
                            <div class="row g-2 mb-2">
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">M.T.Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="mt_amount" name="mt_amount" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">SC</label>
                                    <input type="number" class="form-control form-control-sm" id="sc_amount" name="sc_amount" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">F.T.Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="ft_amount" name="ft_amount" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Dis.</label>
                                    <input type="number" class="form-control form-control-sm" id="discount_final" name="discount_final" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Scm.</label>
                                    <input type="number" class="form-control form-control-sm" id="scheme_final" name="scheme_final" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Tax</label>
                                    <input type="number" class="form-control form-control-sm" id="tax_final" name="tax_final" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Net</label>
                                    <input type="number" class="form-control form-control-sm" id="net_final" name="net_final" value="0" readonly>
                                </div>
                            </div>

                            <!-- Third Row: Short, Packing, N.T.Amt, Scm.%, Sub.Tot., Comp, Srfno -->
                            <div class="row g-2 mb-2">
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Short</label>
                                    <input type="number" class="form-control form-control-sm" id="short_amount" name="short_amount" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Packing</label>
                                    <input type="text" class="form-control form-control-sm" id="packing" name="packing" placeholder="Pack">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">N.T.Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="nt_amount" name="nt_amount" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Scm.%</label>
                                    <input type="number" class="form-control form-control-sm" id="scheme_percent" name="scheme_percent" value="0" min="0" max="100" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Sub.Tot.</label>
                                    <input type="number" class="form-control form-control-sm" id="sub_total_calc" name="sub_total_calc" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Comp</label>
                                    <input type="text" class="form-control form-control-sm" id="company_code" name="company_code" placeholder="Code">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Srfno</label>
                                    <input type="text" class="form-control form-control-sm" id="srfno" name="srfno" placeholder="Srf">
                                </div>
                            </div>

                            <!-- Fourth Row: Unit, SC Amt., Scm.Amt., Tax Amt., Net Amt., COST + GST, + -->
                            <div class="row g-2 mb-2">
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Unit</label>
                                    <input type="text" class="form-control form-control-sm" id="unit_type" name="unit_type" placeholder="Unit">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">SC Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="scheme_amount" name="scheme_amount" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Scm.Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="scheme_percent_2" name="scheme_percent_2" value="0" min="0" max="100" step="0.01">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Tax Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="tax_amount_detail" name="tax_amount_detail" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Net Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="net_amount_final" name="net_amount_final" value="0" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">COST + GST</label>
                                    <input type="number" class="form-control form-control-sm" id="cost_gst" name="cost_gst" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">SCM.</label>
                                    <input type="number" class="form-control form-control-sm" id="scm_final" name="scm_final" value="0" min="0" step="0.01">
                                </div>
                            </div>

                            <!-- Fifth Row: Cl.Qty, Dis.Amt., Vol., Batch Code, Lctn, HS Amt. -->
                            <div class="row g-2">
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Cl.Qty</label>
                                    <input type="number" class="form-control form-control-sm" id="cl_qty" name="cl_qty" value="0" min="0" step="1">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Dis.Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="discount_amount_detail" name="discount_amount_detail" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Vol.</label>
                                    <input type="number" class="form-control form-control-sm" id="volume" name="volume" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold mb-1 small">Batch Code</label>
                                    <input type="text" class="form-control form-control-sm" id="batch_code" name="batch_code" placeholder="Batch">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">Lctn</label>
                                    <input type="text" class="form-control form-control-sm" id="location" name="location" placeholder="Loc">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-bold mb-1 small">HS Amt.</label>
                                    <input type="number" class="form-control form-control-sm" id="hs_amount" name="hs_amount" value="0" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Detailed Calculations (Keep for compatibility) -->
                    <div class="card mb-4 d-none">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-calculator-fill me-2"></i>Detailed Calculations</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Case</label>
                                        <input type="number" class="form-control" id="case_qty" name="case_qty" value="0" min="0" step="1" placeholder="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Box</label>
                                        <input type="number" class="form-control" id="box_qty" name="box_qty" value="0" min="0" step="1" placeholder="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Packing</label>
                                        <input type="text" class="form-control" id="packing" name="packing" placeholder="Packing details">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Unit</label>
                                        <input type="text" class="form-control" id="unit_type" name="unit_type" placeholder="Unit type">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Cl.Qty</label>
                                        <input type="number" class="form-control" id="cl_qty" name="cl_qty" value="0" min="0" step="1" placeholder="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Qty</label>
                                        <input type="number" class="form-control" id="total_qty" name="total_qty" value="0" min="0" step="1" placeholder="0" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Lctn</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">M.T.Amt.</label>
                                        <input type="number" class="form-control" id="mt_amount" name="mt_amount" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">N.T.Amt</label>
                                        <input type="number" class="form-control" id="nt_amount" name="nt_amount" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Scm.%</label>
                                        <input type="number" class="form-control" id="scheme_percent" name="scheme_percent" value="0" min="0" max="100" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">N.T.Amt.</label>
                                        <input type="number" class="form-control" id="net_amount_1" name="net_amount_1" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sc Amt.</label>
                                        <input type="number" class="form-control" id="scheme_amount" name="scheme_amount" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Dis.Amt.</label>
                                        <input type="number" class="form-control" id="discount_amount_detail" name="discount_amount_detail" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">HS Amt.</label>
                                        <input type="number" class="form-control" id="hs_amount" name="hs_amount" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Short</label>
                                        <input type="number" class="form-control" id="short_amount" name="short_amount" value="0" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">SC</label>
                                        <input type="number" class="form-control" id="sc_amount" name="sc_amount" value="0" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">F.T.Amt.</label>
                                        <input type="number" class="form-control" id="ft_amount" name="ft_amount" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Scm.%</label>
                                        <input type="number" class="form-control" id="scheme_percent_2" name="scheme_percent_2" value="0" min="0" max="100" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tax Amt.</label>
                                        <input type="number" class="form-control" id="tax_amount_detail" name="tax_amount_detail" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Net Amt.</label>
                                        <input type="number" class="form-control" id="net_amount_final" name="net_amount_final" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Vol.</label>
                                        <input type="number" class="form-control" id="volume" name="volume" value="0" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Dis.</label>
                                        <input type="number" class="form-control" id="discount_final" name="discount_final" value="0" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Scm.</label>
                                        <input type="number" class="form-control" id="scheme_final" name="scheme_final" value="0" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tax</label>
                                        <input type="number" class="form-control" id="tax_final" name="tax_final" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">TAX %</label>
                                        <input type="number" class="form-control" id="tax_percent" name="tax_percent" value="0" min="0" max="100" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Comp</label>
                                        <input type="text" class="form-control" id="company_code" name="company_code" placeholder="Company code">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">COST + GST</label>
                                        <input type="number" class="form-control" id="cost_gst" name="cost_gst" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Batch Code</label>
                                        <input type="text" class="form-control" id="batch_code" name="batch_code" placeholder="Batch code">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="form-label">TAX %</label>
                                            <input type="number" class="form-control" id="tax_percent_bottom" name="tax_percent_bottom" value="0" min="0" max="100" step="0.01" placeholder="0.00">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Excise</label>
                                            <input type="number" class="form-control" id="excise" name="excise" value="0" min="0" step="0.01" placeholder="0.00">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">TCS</label>
                                            <input type="number" class="form-control" id="tcs" name="tcs" value="0" min="0" step="0.01" placeholder="0.00">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">SC %</label>
                                            <input type="number" class="form-control" id="sc_percent" name="sc_percent" value="0" min="0" max="100" step="0.01" placeholder="0.00">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Net</label>
                                            <input type="number" class="form-control" id="net_final" name="net_final" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">SCM.</label>
                                            <input type="number" class="form-control" id="scm_final" name="scm_final" value="0" min="0" step="0.01" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <label class="form-label">Sub.Tot.</label>
                                            <input type="number" class="form-control" id="sub_total_calc" name="sub_total_calc" value="0" min="0" step="0.01" placeholder="0.00" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Srfno</label>
                                            <input type="text" class="form-control" id="srfno" name="srfno" placeholder="Srf No">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">SrlNo</label>
                                            <input type="text" class="form-control" id="serial_no" name="serial_no" placeholder="Serial No">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information & Actions -->
                    <div class="card mb-3">
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold mb-1 small">Notes</label>
                                    <textarea class="form-control form-control-sm" id="notes" name="notes" rows="2" placeholder="Additional notes">{{ old('notes') }}</textarea>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold mb-1 small">Terms & Conditions</label>
                                    <textarea class="form-control form-control-sm" id="terms_conditions" name="terms_conditions" rows="2" placeholder="Payment terms">{{ old('terms_conditions') }}</textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end justify-content-end">
                                    <div class="btn-group-vertical w-100">
                                        <button type="submit" class="btn btn-primary btn-sm mb-1">
                                            <i class="bi bi-save me-1"></i>Create Invoice
                                        </button>
                                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-x me-1"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
       // Items data keyed by id for quick lookup
const itemsData = @json($items->keyBy('id'));

document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = -1; // Start with -1 so first item gets index 0
    
    // Company selection handler (using jQuery for Select2 compatibility)
    if (typeof $ !== 'undefined' && $('#company_id').length) {
        $('#company_id').on('change', function() {
            const companyId = $(this).val();
            if (companyId) {
                // Fetch company details via AJAX
                fetch(`/admin/companies/${companyId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('company_name').value = data.name || '';
                    document.getElementById('company_email').value = data.email || '';
                    document.getElementById('company_address').value = data.address || '';
                    document.getElementById('company_phone').value = data.telephone || '';
                    document.getElementById('company_gst').value = data.gst_number || '';
                })
                .catch(error => console.error('Error:', error));
            } else {
                // Clear company fields
                document.getElementById('company_name').value = '';
                document.getElementById('company_email').value = '';
                document.getElementById('company_address').value = '';
                document.getElementById('company_phone').value = '';
                document.getElementById('company_gst').value = '';
            }
        });
    }

    // Customer selection handler (using jQuery for Select2 compatibility)
    if (typeof $ !== 'undefined' && $('#customer_id').length) {
        $('#customer_id').on('change', function() {
            const customerId = $(this).val();
            if (customerId) {
                // Fetch customer details via AJAX
                fetch(`/admin/customers/${customerId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('customer_name').value = data.name || '';
                    document.getElementById('customer_email').value = data.email || '';
                    document.getElementById('customer_phone').value = data.mobile || '';
                    document.getElementById('customer_gst').value = data.tax_registration || '';
                    document.getElementById('customer_address').value = data.address || '';
                    document.getElementById('customer_state').value = data.city || '';
                    document.getElementById('customer_state_code').value = data.state_code || '';
                })
                .catch(error => console.error('Error:', error));
            } else {
                // Clear customer fields
                document.getElementById('customer_name').value = '';
                document.getElementById('customer_email').value = '';
                document.getElementById('customer_phone').value = '';
                document.getElementById('customer_gst').value = '';
                document.getElementById('customer_address').value = '';
                document.getElementById('customer_state').value = '';
                document.getElementById('customer_state_code').value = '';
            }
        });
    }

    // Add item functionality
    const addItemBtn = document.getElementById('addItem');
    const itemsTableBody = document.getElementById('itemsTableBody');
    
    if (!addItemBtn) {
        console.error('Add Item button not found!');
        return;
    }
    
    if (!itemsTableBody) {
        console.error('Items table body not found!');
        return;
    }
    
    console.log('Add Item button found, attaching click handler');
    
    addItemBtn.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Add Item clicked, current itemIndex:', itemIndex);
        
        itemIndex++;
        console.log('New itemIndex:', itemIndex);
        
        // Build options HTML from itemsData
        let optionsHTML = '<option value="">Select Item</option>';
        for (let id in itemsData) {
            const item = itemsData[id];
            optionsHTML += `<option value="${item.id}">${item.name}</option>`;
        }
        
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" class="form-control item-code" name="items[${itemIndex}][code]" placeholder="Code" readonly></td>
            <td>
                <select class="form-select item-select" name="items[${itemIndex}][item_id]">
                    ${optionsHTML}
                </select>
            </td>
            <td><input type="text" class="form-control" name="items[${itemIndex}][description]" placeholder="Description"></td>
            <td><input type="text" class="form-control" name="items[${itemIndex}][hsn_code]" placeholder="HSN Code"></td>
            <td><input type="text" class="form-control" name="items[${itemIndex}][batch]" placeholder="Batch"></td>
            <td><input type="date" class="form-control" name="items[${itemIndex}][expiry]" placeholder="Expiry"></td>
            <td><input type="number" class="form-control qty" name="items[${itemIndex}][qty]" value="1" min="0" step="1"></td>
            <td><input type="number" class="form-control free-qty" name="items[${itemIndex}][free_qty]" value="0" min="0" step="0.01"></td>
            <td><input type="text" class="form-control" name="items[${itemIndex}][unit]" placeholder="PCS"></td>
            <td><input type="number" class="form-control rate" name="items[${itemIndex}][rate]" value="0" min="0" step="0.01"></td>
            <td><input type="number" class="form-control sale-rate" name="items[${itemIndex}][sale_rate]" value="0" min="0" step="0.01"></td>
            <td><input type="number" class="form-control discount" name="items[${itemIndex}][discount]" value="0" min="0" max="100" step="0.01"></td>
            <td><input type="number" class="form-control mrp" name="items[${itemIndex}][mrp]" value="0" min="0" step="0.01" readonly></td>
            <td><input type="number" class="form-control gst" name="items[${itemIndex}][gst]" value="18" min="0" max="100" step="0.01"></td>
            <td>
                <input type="text" class="form-control amount" value="₹0.00" readonly>
                <input type="hidden" class="amount_numeric" name="items[${itemIndex}][line_total]" value="0.00">
            </td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item"><i class="bi bi-trash"></i></button></td>
        `;
        
        itemsTableBody.appendChild(newRow);
        console.log('Row added to table body');
        
        // Initialize Select2 on the new row and attach event listeners
        setTimeout(() => {
            const newSelect = newRow.querySelector('.item-select');
            if (newSelect && typeof $ !== 'undefined') {
                $(newSelect).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Select Item',
                    allowClear: true,
                    minimumResultsForSearch: 5
                });
            }
            attachItemEventListeners(newRow);
            lockAllRowsExceptLast();
        }, 100);
    });

    // Attach event listeners to item row
    function attachItemEventListeners(row) {
        const itemSelect = row.querySelector('.item-select');
        if (itemSelect) {
            // Use jQuery event for Select2 compatibility
            $(itemSelect).on('change', function() {
                const selectedId = $(this).val();
                if (selectedId && itemsData[selectedId]) {
                    const item = itemsData[selectedId];
                    const codeInput = row.querySelector('input.item-code');
                    const descInput = row.querySelector('input[name$="[description]"]');
                    const hsnInput = row.querySelector('input[name$="[hsn_code]"]');
                    const batchInput = row.querySelector('input[name$="[batch]"]');
                    const expiryInput = row.querySelector('input[name$="[expiry]"]');
                    const unitInput = row.querySelector('input[name$="[unit]"]');
                    const rateInput = row.querySelector('input.rate');
                    const saleRateInput = row.querySelector('input.sale-rate');
                    const discountInput = row.querySelector('input.discount');
                    const mrpInput = row.querySelector('input.mrp');

                    if (codeInput) codeInput.value = item.code || '';
                    if (descInput) descInput.value = item.name || '';
                    if (hsnInput) hsnInput.value = item.HSNCode ?? item.hsn_code ?? '';
                    if (batchInput) batchInput.value = item.Batchcode ?? '';
                    if (expiryInput && item.Expiry) {
                        const expDate = new Date(item.Expiry);
                        if (!isNaN(expDate.getTime())) {
                            expiryInput.value = expDate.toISOString().split('T')[0];
                        }
                    }
                    if (unitInput) unitInput.value = item.Unit ?? item.unit ?? '';
                    const rateVal = item.Prate ?? item.rate ?? 0;
                    if (rateInput) rateInput.value = parseFloat(rateVal) || 0;
                    const saleRateVal = item.Srate ?? item.sale_rate ?? 0;
                    if (saleRateInput) saleRateInput.value = parseFloat(saleRateVal) || 0;
                    if (discountInput) discountInput.value = parseFloat(item.discount_percent ?? 0) || 0;
                    
                    // MRP field - check multiple possible field names
                    const mrpValue = item.Mrp ?? item.mrp ?? item.MRP ?? 0;
                    if (mrpInput) {
                        mrpInput.value = parseFloat(mrpValue) || 0;
                        console.log('MRP Set:', mrpValue, 'for item:', item.name, 'Input found:', !!mrpInput);
                    } else {
                        console.warn('MRP input field not found for item:', item.name);
                    }

                    // Populate additional fields from items database
                    const boxQtyInput = document.getElementById('box_qty');
                    const packingInput = document.getElementById('packing');
                    const unitTypeInput = document.getElementById('unit_type');
                    const locationInput = document.getElementById('location');
                    const volumeInput = document.getElementById('volume');
                    const companyCodeInput = document.getElementById('company_code');
                    const exciseInput = document.getElementById('excise');

                    if (boxQtyInput) boxQtyInput.value = parseFloat(item.Box ?? 0) || 0;
                    if (packingInput) packingInput.value = item.Pack ?? '';
                    if (unitTypeInput) unitTypeInput.value = item.Unit ?? '';
                    if (locationInput) locationInput.value = item.Location ?? '';
                    if (volumeInput) volumeInput.value = parseFloat(item.Vol ?? 0) || 0;
                    if (companyCodeInput) companyCodeInput.value = item.Compcode ?? '';
                    if (exciseInput) exciseInput.value = parseFloat(item.Excise ?? 0) || 0;

                    // Populate GST related fields from items table
                    const cgstPercentInput = document.getElementById('cgst_percent');
                    const sgstPercentInput = document.getElementById('sgst_percent');
                    const cessPercentInput = document.getElementById('cess_percent');
                    
                    if (cgstPercentInput) cgstPercentInput.value = parseFloat(item.CGST ?? 0) || 0;
                    if (sgstPercentInput) sgstPercentInput.value = parseFloat(item.SGST ?? 0) || 0;
                    if (cessPercentInput) cessPercentInput.value = parseFloat(item.GSTCess ?? 0) || 0;

                    // Populate IGST (was missing)
                    const igstPercentInput = document.getElementById('igst_percent');
                    if (igstPercentInput) igstPercentInput.value = parseFloat(item.IGST ?? 0) || 0;

                    // Populate tax and other calculation fields
                    const staxInput = document.getElementById('tax_percent');
                    const ptaxInput = document.getElementById('ptax');
                    
                    if (staxInput) staxInput.value = parseFloat(item.Stax ?? 0) || 0;
                    if (ptaxInput) ptaxInput.value = parseFloat(item.ptax ?? 0) || 0;

                    // Populate scheme fields (Scm1, Scm2, Sc)
                    const scm1Input = document.getElementById('scheme_percent');
                    const scm2Input = document.getElementById('scheme_percent_2');
                    const scInput = document.getElementById('sc_amount');
                    const scPercentInput = document.getElementById('sc_percent');
                    
                    if (scm1Input) scm1Input.value = parseFloat(item.Scm1 ?? 0) || 0;
                    if (scm2Input) scm2Input.value = parseFloat(item.scm2 ?? 0) || 0;
                    if (scInput) scInput.value = parseFloat(item.Sc ?? 0) || 0;

                    // Populate rate fields (Wsrate, splrate)
                    const wsrateInput = document.getElementById('wsrate');
                    const splrateInput = document.getElementById('splrate');
                    
                    if (wsrateInput) wsrateInput.value = parseFloat(item.Wsrate ?? 0) || 0;
                    if (splrateInput) splrateInput.value = parseFloat(item.splrate ?? 0) || 0;

                    // Populate discount fields (FDis, FDisP)
                    const fdisInput = document.getElementById('discount_final');
                    const fdisPInput = document.getElementById('discount_percent_fixed');
                    
                    if (fdisInput) fdisInput.value = parseFloat(item.FDis ?? 0) || 0;
                    if (fdisPInput) fdisPInput.value = parseFloat(item.FDisP ?? 0) || 0;

                    // Populate quantity fields (Clqty, opqty)
                    const clqtyInput = document.getElementById('cl_qty');
                    const opqtyInput = document.getElementById('op_qty');
                    
                    if (clqtyInput) clqtyInput.value = parseFloat(item.Clqty ?? 0) || 0;
                    if (opqtyInput) opqtyInput.value = parseFloat(item.opqty ?? 0) || 0;

                    // Populate MinGP, VAT, Margin
                    const minGPInput = document.getElementById('min_gp');
                    const vatInput = document.getElementById('vat_amount');
                    const marginInput = document.getElementById('margin_amount');
                    
                    if (minGPInput) minGPInput.value = parseFloat(item.MinGP ?? 0) || 0;
                    if (vatInput) vatInput.value = parseFloat(item.VAT ?? 0) || 0;
                    if (marginInput) marginInput.value = parseFloat(item.Margin ?? 0) || 0;

                    // Populate tax flags (TaxonMrp, VATonSrate, Inclusive)
                    const taxOnMrpInput = document.getElementById('tax_on_mrp');
                    const vatOnSrateInput = document.getElementById('vat_on_srate');
                    const inclusiveInput = document.getElementById('inclusive_tax');
                    
                    if (taxOnMrpInput) taxOnMrpInput.checked = item.TaxonMrp ?? false;
                    if (vatOnSrateInput) vatOnSrateInput.checked = item.VATonSrate ?? false;
                    if (inclusiveInput) inclusiveInput.checked = item.Inclusive ?? false;

                    calculateItemAmount(row);
                    calculateTotals();
                }
            });
        }
        
        const qtyInput = row.querySelector('.qty');
        const rateInput = row.querySelector('.rate');
        const discountInput = row.querySelector('.discount');
        const gstInput = row.querySelector('.gst');

        [qtyInput, rateInput, discountInput, gstInput].forEach(input => {
            if (input) {
                input.addEventListener('input', function() {
                    calculateItemAmount(row);
                    calculateTotals();
                });
            }
        });

        const removeBtn = row.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const tr = this.closest('tr');
                if (tr) {
                    showDeleteConfirmation(tr);
                }
            });
        }
    }

    function lockAllRowsExceptLast() {
        const rows = Array.from(document.querySelectorAll('#itemsTableBody tr'));
        if (rows.length === 0) return;

        rows.forEach((row, idx) => {
            const isLast = idx === rows.length - 1;
            const inputs = row.querySelectorAll('input:not([type="hidden"])');
            const selects = row.querySelectorAll('select');

            inputs.forEach(inp => {
                const alwaysReadonly = inp.classList.contains('amount') || inp.classList.contains('mrp') || inp.classList.contains('item-code');
                if (alwaysReadonly) {
                    inp.readOnly = true;
                } else {
                    inp.readOnly = !isLast;
                }
            });

            selects.forEach(sel => {
                sel.disabled = !isLast;
                // Update Select2 state
                if (typeof $ !== 'undefined') {
                    $(sel).prop('disabled', !isLast);
                }
            });
        });
    }

    // Unlock all fields before form submission
    const invoiceForm = document.getElementById('invoiceForm');
    if (invoiceForm) {
        invoiceForm.addEventListener('submit', function() {
            document.querySelectorAll('#itemsTableBody tr input, #itemsTableBody tr select').forEach(el => {
                if (el.tagName === 'INPUT') el.readOnly = false;
                if (el.tagName === 'SELECT') {
                    el.disabled = false;
                    if (typeof $ !== 'undefined') {
                        $(el).prop('disabled', false);
                    }
                }
            });
        });
    }

    // Calculate item amount
    function calculateItemAmount(row) {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const discount = parseFloat(row.querySelector('.discount').value) || 0;
        const gst = parseFloat(row.querySelector('.gst').value) || 0;

        const subtotal = qty * rate;
        const discountAmount = (subtotal * discount) / 100;
        const taxableAmount = subtotal - discountAmount;
        const gstAmount = (taxableAmount * gst) / 100;
        const total = taxableAmount + gstAmount;

        const amountInput = row.querySelector('.amount');
        if (amountInput) amountInput.value = `₹${total.toFixed(2)}`;
        
        const amtNum = row.querySelector('.amount_numeric');
        if (amtNum) amtNum.value = total.toFixed(2);
    }

    // Calculate totals
    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalGst = 0;
        let totalCgst = 0;
        let totalSgst = 0;
        let totalIgst = 0;

        document.querySelectorAll('#itemsTableBody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const discount = parseFloat(row.querySelector('.discount').value) || 0;
            const gst = parseFloat(row.querySelector('.gst').value) || 0;

            const itemSubtotal = qty * rate;
            const itemDiscount = (itemSubtotal * discount) / 100;
            const taxableAmount = itemSubtotal - itemDiscount;
            const itemGst = (taxableAmount * gst) / 100;

            subtotal += itemSubtotal;
            totalDiscount += itemDiscount;
            totalGst += itemGst;
            
            totalCgst += itemGst / 2;
            totalSgst += itemGst / 2;
        });

        const totalAmount = subtotal - totalDiscount + totalGst;
        const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
        const balanceAmount = totalAmount - paidAmount;

        document.getElementById('subtotal').value = `₹${subtotal.toFixed(2)}`;
        document.getElementById('total_discount').value = `₹${totalDiscount.toFixed(2)}`;
        document.getElementById('cgst_amount').value = `₹${totalCgst.toFixed(2)}`;
        document.getElementById('sgst_amount').value = `₹${totalSgst.toFixed(2)}`;
        document.getElementById('igst_amount').value = `₹${totalIgst.toFixed(2)}`;
        document.getElementById('tax_amount').value = `₹${totalGst.toFixed(2)}`;
        document.getElementById('total_amount').value = `₹${totalAmount.toFixed(2)}`;
        document.getElementById('balance_amount').value = `₹${balanceAmount.toFixed(2)}`;
        
        const subtotalInput = document.getElementById('subtotal_input');
        const discountInput = document.getElementById('discount_input');
        const cgstInput = document.getElementById('cgst_input');
        const sgstInput = document.getElementById('sgst_input');
        const igstInput = document.getElementById('igst_input');
        const taxInput = document.getElementById('tax_input');
        const totalInput = document.getElementById('total_input');
        const balanceInput = document.getElementById('balance_input');
        
        if (subtotalInput) subtotalInput.value = subtotal.toFixed(2);
        if (discountInput) discountInput.value = totalDiscount.toFixed(2);
        if (cgstInput) cgstInput.value = totalCgst.toFixed(2);
        if (sgstInput) sgstInput.value = totalSgst.toFixed(2);
        if (igstInput) igstInput.value = totalIgst.toFixed(2);
        if (taxInput) taxInput.value = totalGst.toFixed(2);
        if (totalInput) totalInput.value = totalAmount.toFixed(2);
        if (balanceInput) balanceInput.value = balanceAmount.toFixed(2);
    }

    // FORM VALIDATION - Check if at least one item is added
    if (invoiceForm) {
        invoiceForm.addEventListener('submit', function(e) {
            const rows = document.querySelectorAll('#itemsTableBody tr');
            let hasValidItem = false;
            
            // Remove previous error if exists
            const existingError = document.getElementById('items-error-message');
            if (existingError) {
                existingError.remove();
            }
            
            // Check if at least one row has either item selected or rate > 0
            rows.forEach(row => {
                const itemSelect = row.querySelector('.item-select');
                const rate = parseFloat(row.querySelector('.rate').value) || 0;
                
                if ((itemSelect && itemSelect.value) || rate > 0) {
                    hasValidItem = true;
                }
            });
            
            if (!hasValidItem) {
                e.preventDefault();
                
                // Create error message div
                const errorDiv = document.createElement('div');
                errorDiv.id = 'items-error-message';
                errorDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
                errorDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error:</strong> Please add at least one item to create an invoice.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                // Insert after Add Item button
                const addItemBtn = document.getElementById('addItem');
                addItemBtn.parentNode.insertBefore(errorDiv, addItemBtn.nextSibling);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                }, 5000);
                
                return false;
            }
        });
    }

    // Pre-populate if values already selected
    if (typeof $ !== 'undefined') {
        const preCompanyId = $('#company_id').val();
        if (preCompanyId) { $('#company_id').trigger('change'); }
        const preCustomerId = $('#customer_id').val();
        if (preCustomerId) { $('#customer_id').trigger('change'); }
    }

    // Attach event listeners to existing rows
    document.querySelectorAll('#itemsTableBody tr').forEach(row => {
        attachItemEventListeners(row);
    });

    // Initial calculation
    calculateTotals();
    
    // Recalculate balance when paid amount changes
    const paidAmountInput = document.getElementById('paid_amount');
    if (paidAmountInput) {
        paidAmountInput.addEventListener('input', calculateTotals);
    }

    // Initialize Select2 on company and customer dropdowns
    if (typeof $ !== 'undefined') {
        $('#company_id, #customer_id').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });
    }

    // Invoice item delete confirmation using global modal
    let itemRowToDelete = null;

    function showDeleteConfirmation(row) {
        itemRowToDelete = row;
        
        // Set custom message for invoice items
        document.getElementById('globalDeleteMessage').textContent = 'Are you sure you want to delete this invoice item? This action cannot be undone.';
        
        // Show the global modal
        const modal = new bootstrap.Modal(document.getElementById('globalDeleteModal'));
        modal.show();
    }

    // Handle global delete confirmation for invoice items
    document.getElementById('globalDeleteConfirm').addEventListener('click', function(e) {
        // Check if this is for an invoice item
        if (itemRowToDelete) {
            e.stopImmediatePropagation();
            
            // Remove the item row
            itemRowToDelete.remove();
            
            // Recalculate totals
            calculateTotals();
            
            // Update row locking
            lockAllRowsExceptLast();
            
            // Hide the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('globalDeleteModal'));
            if (modal) {
                modal.hide();
            }
            
            // Reset
            itemRowToDelete = null;
            
            return false;
        }
    });

    // Reset when modal is closed
    document.getElementById('globalDeleteModal').addEventListener('hidden.bs.modal', function() {
        itemRowToDelete = null;
    });
});

// Invoice Date Validation
(function() {
    const invoiceDateInput = document.getElementById('invoice_date');
    const form = document.getElementById('invoiceForm');
    
    if (!invoiceDateInput) return;
    
    // Get server date from PHP (already set in min/max attributes)
    const serverToday = invoiceDateInput.getAttribute('min');
    const serverTomorrow = invoiceDateInput.getAttribute('max');
    const todayStr = serverToday;
    
    // Prevent manual keyboard input completely
    invoiceDateInput.addEventListener('keydown', function(e) {
        e.preventDefault();
        return false;
    });
    
    // Prevent paste
    invoiceDateInput.addEventListener('paste', function(e) {
        e.preventDefault();
        return false;
    });
    
    // Validate on date change
    invoiceDateInput.addEventListener('change', function() {
        validateInvoiceDate();
    });
    
    // Validate on input (for manual paste)
    invoiceDateInput.addEventListener('input', function() {
        validateInvoiceDate();
    });
    
    function validateInvoiceDate() {
        const selectedDate = new Date(invoiceDateInput.value);
        const todayDate = new Date(todayStr);
        
        // Remove time component for accurate comparison
        selectedDate.setHours(0, 0, 0, 0);
        todayDate.setHours(0, 0, 0, 0);
        
        if (selectedDate < todayDate) {
            // Show error styling
            invoiceDateInput.classList.add('is-invalid');
            invoiceDateInput.style.borderColor = '#dc3545';
            
            // Show error message
            let errorDiv = invoiceDateInput.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                errorDiv = document.createElement('div');
                errorDiv.classList.add('invalid-feedback');
                errorDiv.style.display = 'block';
                invoiceDateInput.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = 'Cannot create invoice for previous dates';
            
            // Show alert notification
            showAlert('Error', 'Previous dates are not allowed for invoice creation', 'error');
            
            // Reset to today's date
            invoiceDateInput.value = todayStr;
            
            return false;
        } else {
            // Remove error styling
            invoiceDateInput.classList.remove('is-invalid');
            invoiceDateInput.style.borderColor = '';
            
            const errorDiv = invoiceDateInput.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.remove();
            }
            
            return true;
        }
    }
    
    // Form submit validation (CRITICAL)
    if (form) {
        form.addEventListener('submit', function(e) {
            const selectedDate = new Date(invoiceDateInput.value);
            const todayDate = new Date(todayStr);
            
            selectedDate.setHours(0, 0, 0, 0);
            todayDate.setHours(0, 0, 0, 0);
            
            if (selectedDate < todayDate) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                showAlert('Error', 'Cannot submit invoice with previous date!', 'error');
                invoiceDateInput.focus();
                invoiceDateInput.value = todayStr;
                
                return false;
            }
        }, true); // Use capture phase to run before other handlers
    }
    
    // Alert notification function
    function showAlert(title, message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'danger' : 'warning'} alert-dismissible fade show`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            <strong>${title}!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
})();
    </script>
@endpush