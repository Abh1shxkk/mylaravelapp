@extends('layouts.admin')
@section('title','Add Customer')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Add New Customer</h2>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Customers
                </a>
            </div>

            <form action="{{ route('admin.customers.store') }}" method="POST">
                @csrf
                
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tax Registration</label>
                                <input type="text" class="form-control" name="tax_registration" value="{{ old('tax_registration') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Flag</label>
                                <input type="text" class="form-control" name="flag" value="{{ old('flag') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PIN Code</label>
                                <input type="text" class="form-control" name="pin_code" value="{{ old('pin_code') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mobile</label>
                                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-telephone me-2"></i>Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Telephone (Office)</label>
                                <input type="text" class="form-control" name="telephone_office" value="{{ old('telephone_office') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Telephone (Residence)</label>
                                <input type="text" class="form-control" name="telephone_residence" value="{{ old('telephone_residence') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Fax Number</label>
                                <input type="text" class="form-control" name="fax_number" value="{{ old('fax_number') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person 1</label>
                                <input type="text" class="form-control" name="contact_person1" value="{{ old('contact_person1') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mobile Contact 1</label>
                                <input type="text" class="form-control" name="mobile_contact1" value="{{ old('mobile_contact1') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person 2</label>
                                <input type="text" class="form-control" name="contact_person2" value="{{ old('contact_person2') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mobile Contact 2</label>
                                <input type="text" class="form-control" name="mobile_contact2" value="{{ old('mobile_contact2') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-cash-coin me-2"></i>Financial Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Opening Balance</label>
                                <input type="number" step="0.01" class="form-control" name="opening_balance" value="{{ old('opening_balance', '0.00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Balance Type</label>
                                <input type="text" class="form-control" name="balance_type" value="{{ old('balance_type', 'D') }}" placeholder="Debit (D)/Credit (C)">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Local/Central</label>
                                <input type="text" class="form-control" name="local_central" value="{{ old('local_central', 'L') }}" placeholder="Local (L)/Central (C)">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Credit Days</label>
                                <input type="number" class="form-control" name="credit_days" value="{{ old('credit_days', '0') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-briefcase me-2"></i>Business Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Business Type</label>
                                <input type="text" class="form-control" name="business_type" value="{{ old('business_type', 'R') }}" placeholder="Retail (R)">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Registration Status</label>
                                <input type="text" class="form-control" name="registration_status" value="{{ old('registration_status') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Birth Day</label>
                                <input type="date" class="form-control" name="birth_day" value="{{ old('birth_day') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Due List Sequence</label>
                                <input type="text" class="form-control" name="due_list_sequence" value="{{ old('due_list_sequence') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Registration Date</label>
                                <input type="date" class="form-control" name="registration_date" value="{{ old('registration_date', '2000-01-01') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ old('end_date', '2000-01-01') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Day Value</label>
                                <input type="number" class="form-control" name="day_value" value="{{ old('day_value', '0') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Order Required</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="order_required" id="order_required" {{ old('order_required') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="order_required">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Invoice Export</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="invoice_export" id="invoice_export" {{ old('invoice_export') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="invoice_export">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="status" {{ old('status', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- License & Registration -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>License & Registration</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">TAN Number</label>
                                <input type="text" class="form-control" name="tan_number" value="{{ old('tan_number') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PAN Number</label>
                                <input type="text" class="form-control" name="pan_number" value="{{ old('pan_number') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">TIN Number</label>
                                <input type="text" class="form-control" name="tin_number" value="{{ old('tin_number') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">CST Number</label>
                                <input type="text" class="form-control" name="cst_number" value="{{ old('cst_number') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">CST Registration</label>
                                <input type="text" class="form-control" name="cst_registration" value="{{ old('cst_registration') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">GST Name</label>
                                <input type="text" class="form-control" name="gst_name" value="{{ old('gst_name') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State Code (GST)</label>
                                <input type="text" class="form-control" name="state_code_gst" value="{{ old('state_code_gst') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">MSME License</label>
                                <input type="text" class="form-control" name="msme_license" value="{{ old('msme_license') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Food License</label>
                                <input type="text" class="form-control" name="food_license" value="{{ old('food_license') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">DL Number</label>
                                <input type="text" class="form-control" name="dl_number" value="{{ old('dl_number') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">DL Expiry</label>
                                <input type="date" class="form-control" name="dl_expiry" value="{{ old('dl_expiry') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">DL Number 1</label>
                                <input type="text" class="form-control" name="dl_number1" value="{{ old('dl_number1') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Aadhar Number</label>
                                <input type="text" class="form-control" name="aadhar_number" value="{{ old('aadhar_number') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Codes & Routes -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-signpost me-2"></i>Codes & Routes</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Salesman Code</label>
                                <input type="text" class="form-control" name="sales_man_code" value="{{ old('sales_man_code', '00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Area Code</label>
                                <input type="text" class="form-control" name="area_code" value="{{ old('area_code', '00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Route Code</label>
                                <input type="text" class="form-control" name="route_code" value="{{ old('route_code', '00') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State Code</label>
                                <input type="text" class="form-control" name="state_code" value="{{ old('state_code', '00') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Description</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection