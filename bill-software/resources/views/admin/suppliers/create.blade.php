@extends('layouts.admin')
@section('title','Add Supplier')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Add New Supplier</h2>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Suppliers
                </a>
            </div>

            <form action="{{ route('admin.suppliers.store') }}" method="POST" novalidate>
                @csrf
                
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
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
                                <label class="form-label">T(ax)/R(etail)</label>
                                <select class="form-select" name="tax_retail_flag">
                                    <option value="T" {{ old('tax_retail_flag', 'T') == 'T' ? 'selected' : '' }}>T</option>
                                    <option value="R" {{ old('tax_retail_flag') == 'R' ? 'selected' : '' }}>R</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Telephone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Fax</label>
                                <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="status" {{ old('status') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">B* Day</label>
                                <input type="date" class="form-control" name="b_day" value="{{ old('b_day') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">A* Day</label>
                                <input type="date" class="form-control" name="a_day" value="{{ old('a_day') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person I</label>
                                <input type="text" class="form-control" name="contact_person_1" value="{{ old('contact_person_1') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person II</label>
                                <input type="text" class="form-control" name="contact_person_2" value="{{ old('contact_person_2') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mobile</label>
                                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mobile Additional</label>
                                <input type="text" class="form-control" name="mobile_additional" value="{{ old('mobile_additional') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Flag</label>
                                <input type="text" class="form-control" name="flag" value="{{ old('flag') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Visit Days</label>
                                <input type="text" class="form-control" name="visit_days" value="{{ old('visit_days') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- License & Registration -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-card-checklist me-2"></i>License & Registration</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">D.L No.</label>
                                <input type="text" class="form-control" name="dl_no" value="{{ old('dl_no') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">D.L No. 1</label>
                                <input type="text" class="form-control" name="dl_no_1" value="{{ old('dl_no_1') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Food Lic.</label>
                                <input type="text" class="form-control" name="food_lic" value="{{ old('food_lic') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">MSME Lic.</label>
                                <input type="text" class="form-control" name="msme_lic" value="{{ old('msme_lic') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">CST No.</label>
                                <input type="text" class="form-control" name="cst_no" value="{{ old('cst_no') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">TIN No.</label>
                                <input type="text" class="form-control" name="tin_no" value="{{ old('tin_no') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">GST No.</label>
                                <input type="text" class="form-control" name="gst_no" value="{{ old('gst_no') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PAN</label>
                                <input type="text" class="form-control" name="pan" value="{{ old('pan') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">TAN No.</label>
                                <input type="text" class="form-control" name="tan_no" value="{{ old('tan_no') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State Code</label>
                                <input type="text" class="form-control" name="state_code" value="{{ old('state_code') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Local/Central</label>
                                <select class="form-select" name="local_central_flag">
                                    <option value="L" {{ old('local_central_flag', 'L') == 'L' ? 'selected' : '' }}>Local</option>
                                    <option value="C" {{ old('local_central_flag') == 'C' ? 'selected' : '' }}>Central</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-currency-rupee me-2"></i>Financial Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Opening Balance</label>
                                <input type="number" step="0.01" class="form-control" name="opening_balance" value="{{ old('opening_balance', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Credit Limit</label>
                                <input type="number" step="0.01" class="form-control" name="credit_limit" value="{{ old('credit_limit', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Invoice Roff</label>
                                <input type="number" step="0.01" class="form-control" name="invoice_roff" value="{{ old('invoice_roff', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Direct/Indirect</label>
                                <select class="form-select" name="direct_indirect">
                                    <option value="D" {{ old('direct_indirect', 'D') == 'D' ? 'selected' : '' }}>Direct</option>
                                    <option value="I" {{ old('direct_indirect') == 'I' ? 'selected' : '' }}>Indirect</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Details -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-bank me-2"></i>Bank Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Bank</label>
                                <input type="text" class="form-control" name="bank" value="{{ old('bank') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Branch</label>
                                <input type="text" class="form-control" name="branch" value="{{ old('branch') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">A/c No.</label>
                                <input type="text" class="form-control" name="account_no" value="{{ old('account_no') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc_code" value="{{ old('ifsc_code') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Flags -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>System Flags</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Dis. On Excise</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="discount_on_excise" id="discount_on_excise" {{ old('discount_on_excise') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="discount_on_excise">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Dis After Scheme</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="discount_after_scheme" id="discount_after_scheme" {{ old('discount_after_scheme') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="discount_after_scheme">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sch. Type</label>
                                <input type="text" class="form-control" name="scheme_type" value="{{ old('scheme_type') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Inv. on F.T. Rate</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="invoice_on_trade_rate" id="invoice_on_trade_rate" {{ old('invoice_on_trade_rate') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="invoice_on_trade_rate">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Net Rate [Y/N/M]</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="net_rate_yn" id="net_rate_yn" {{ old('net_rate_yn') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="net_rate_yn">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Scm. In Decimal</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="scheme_in_decimal" id="scheme_in_decimal" {{ old('scheme_in_decimal') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="scheme_in_decimal">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">VAT on Br./Expiry</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="vat_on_bill_expiry" id="vat_on_bill_expiry" {{ old('vat_on_bill_expiry') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vat_on_bill_expiry">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Tax on FQty</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="tax_on_fqty" id="tax_on_fqty" {{ old('tax_on_fqty') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tax_on_fqty">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sale Pur. Status</label>
                                <select class="form-select" name="sale_purchase_status">
                                    <option value="P" {{ old('sale_purchase_status', 'P') == 'P' ? 'selected' : '' }}>Purchase</option>
                                    <option value="S" {{ old('sale_purchase_status') == 'S' ? 'selected' : '' }}>Sale</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Expiry on M(RP)/S(ale)/P(ur.)</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="expiry_on_mrp_sale_rate_purchase_rate" id="expiry_on_mrp_sale_rate_purchase_rate" {{ old('expiry_on_mrp_sale_rate_purchase_rate') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="expiry_on_mrp_sale_rate_purchase_rate">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Composite Scheme</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="composite_scheme" id="composite_scheme" {{ old('composite_scheme') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="composite_scheme">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Stock Transfer</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="stock_transfer" id="stock_transfer" {{ old('stock_transfer') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="stock_transfer">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Cash Purchase</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="cash_purchase" id="cash_purchase" {{ old('cash_purchase') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cash_purchase">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Add Charges with GST</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="add_charges_with_gst" id="add_charges_with_gst" {{ old('add_charges_with_gst') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="add_charges_with_gst">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Pur. Import Box Conversion</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="purchase_import_box_conversion" id="purchase_import_box_conversion" {{ old('purchase_import_box_conversion') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="purchase_import_box_conversion">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tax & Compliance -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-percent me-2"></i>Tax & Compliance</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Aadhar</label>
                                <input type="text" class="form-control" name="aadhar" value="{{ old('aadhar') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Regd. Date</label>
                                <input type="date" class="form-control" name="registration_date" value="{{ old('registration_date') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">R(egistered)/U(nregistered)/C(omposite)</label>
                                <select class="form-select" name="registered_unregistered_composite">
                                    <option value="R" {{ old('registered_unregistered_composite', 'R') == 'R' ? 'selected' : '' }}>Registered</option>
                                    <option value="U" {{ old('registered_unregistered_composite') == 'U' ? 'selected' : '' }}>Unregistered</option>
                                    <option value="C" {{ old('registered_unregistered_composite') == 'C' ? 'selected' : '' }}>Composite</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">TCS Applicable [Y/N/#]</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="tcs_applicable" id="tcs_applicable" {{ old('tcs_applicable') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tcs_applicable">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">TDS [Y/N]</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="tds_yn" id="tds_yn" {{ old('tds_yn') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tds_yn">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">TDS on Return</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="tds_on_return" id="tds_on_return" {{ old('tds_on_return') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tds_on_return">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">TDS / TCS on Bill Amt.</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="tds_tcs_on_bill_amount" id="tds_tcs_on_bill_amount" {{ old('tds_tcs_on_bill_amount') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tds_tcs_on_bill_amount">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection