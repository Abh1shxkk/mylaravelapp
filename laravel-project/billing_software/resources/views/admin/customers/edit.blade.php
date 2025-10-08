@extends('admin.layout')

@section('title', 'Edit Customer')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Customer</h4>
                <p class="card-description">Update the customer details below</p>

                <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Customer Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code', $customer->code) }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $customer->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact_person1">Contact Person I</label>
                                <input type="text" class="form-control @error('contact_person1') is-invalid @enderror" 
                                       id="contact_person1" name="contact_person1" value="{{ old('contact_person1', $customer->contact_person1) }}">
                                @error('contact_person1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact_person2">Contact Person II</label>
                                <input type="text" class="form-control @error('contact_person2') is-invalid @enderror" 
                                       id="contact_person2" name="contact_person2" value="{{ old('contact_person2', $customer->contact_person2) }}">
                                @error('contact_person2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tax_registration">Tax Registration</label>
                                <input type="text" class="form-control @error('tax_registration') is-invalid @enderror" 
                                       id="tax_registration" name="tax_registration" value="{{ old('tax_registration', $customer->tax_registration) }}">
                                @error('tax_registration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pin_code">Pin Code</label>
                                <input type="text" class="form-control @error('pin_code') is-invalid @enderror" 
                                       id="pin_code" name="pin_code" value="{{ old('pin_code', $customer->pin_code) }}">
                                @error('pin_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', $customer->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="2">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telephone_office">Telephone Office</label>
                                <input type="text" class="form-control @error('telephone_office') is-invalid @enderror" 
                                       id="telephone_office" name="telephone_office" value="{{ old('telephone_office', $customer->telephone_office) }}">
                                @error('telephone_office')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telephone_residence">Telephone Residence</label>
                                <input type="text" class="form-control @error('telephone_residence') is-invalid @enderror" 
                                       id="telephone_residence" name="telephone_residence" value="{{ old('telephone_residence', $customer->telephone_residence) }}">
                                @error('telephone_residence')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" name="mobile" value="{{ old('mobile', $customer->mobile) }}">
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile_contact1">Mobile Contact 1</label>
                                <input type="text" class="form-control @error('mobile_contact1') is-invalid @enderror" 
                                       id="mobile_contact1" name="mobile_contact1" value="{{ old('mobile_contact1', $customer->mobile_contact1) }}">
                                @error('mobile_contact1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile_contact2">Mobile Contact 2</label>
                                <input type="text" class="form-control @error('mobile_contact2') is-invalid @enderror" 
                                       id="mobile_contact2" name="mobile_contact2" value="{{ old('mobile_contact2', $customer->mobile_contact2) }}">
                                @error('mobile_contact2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fax_number">Fax Number</label>
                                <input type="text" class="form-control @error('fax_number') is-invalid @enderror" 
                                       id="fax_number" name="fax_number" value="{{ old('fax_number', $customer->fax_number) }}">
                                @error('fax_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Financial Information Section -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="opening_balance">Opening Balance</label>
                                <input type="number" step="0.01" class="form-control @error('opening_balance') is-invalid @enderror" 
                                       id="opening_balance" name="opening_balance" value="{{ old('opening_balance', $customer->opening_balance) }}">
                                @error('opening_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="balance_type">Balance Type</label>
                                <select class="form-control @error('balance_type') is-invalid @enderror" id="balance_type" name="balance_type">
                                    <option value="D" {{ old('balance_type', $customer->balance_type) == 'D' ? 'selected' : '' }}>Debit (D)</option>
                                    <option value="C" {{ old('balance_type', $customer->balance_type) == 'C' ? 'selected' : '' }}>Credit (C)</option>
                                </select>
                                @error('balance_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="local_central">Local/Central</label>
                                <select class="form-control @error('local_central') is-invalid @enderror" id="local_central" name="local_central">
                                    <option value="L" {{ old('local_central', $customer->local_central) == 'L' ? 'selected' : '' }}>Local (L)</option>
                                    <option value="C" {{ old('local_central', $customer->local_central) == 'C' ? 'selected' : '' }}>Central (C)</option>
                                </select>
                                @error('local_central')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="credit_days">Credit Days</label>
                                <input type="number" class="form-control @error('credit_days') is-invalid @enderror" 
                                       id="credit_days" name="credit_days" value="{{ old('credit_days', $customer->credit_days) }}">
                                @error('credit_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_day">Birth Day</label>
                                <input type="date" class="form-control @error('birth_day') is-invalid @enderror" 
                                       id="birth_day" name="birth_day" value="{{ old('birth_day', $customer->birth_day ? $customer->birth_day->format('Y-m-d') : '') }}">
                                @error('birth_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="Active" {{ old('status', $customer->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $customer->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- License Information Section -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dl_expiry">DL Expiry</label>
                                <input type="date" class="form-control @error('dl_expiry') is-invalid @enderror" 
                                       id="dl_expiry" name="dl_expiry" value="{{ old('dl_expiry', $customer->dl_expiry ? $customer->dl_expiry->format('Y-m-d') : '') }}">
                                @error('dl_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dl_number1">DL Number 1</label>
                                <input type="text" class="form-control @error('dl_number1') is-invalid @enderror" 
                                       id="dl_number1" name="dl_number1" value="{{ old('dl_number1', $customer->dl_number1) }}">
                                @error('dl_number1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="food_license">Food License</label>
                                <input type="text" class="form-control @error('food_license') is-invalid @enderror" 
                                       id="food_license" name="food_license" value="{{ old('food_license', $customer->food_license) }}">
                                @error('food_license')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cst_number">CST Number</label>
                                <input type="text" class="form-control @error('cst_number') is-invalid @enderror" 
                                       id="cst_number" name="cst_number" value="{{ old('cst_number', $customer->cst_number) }}">
                                @error('cst_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tin_number">TIN Number</label>
                                <input type="text" class="form-control @error('tin_number') is-invalid @enderror" 
                                       id="tin_number" name="tin_number" value="{{ old('tin_number', $customer->tin_number) }}">
                                @error('tin_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pan_number">PAN Number</label>
                                <input type="text" class="form-control @error('pan_number') is-invalid @enderror" 
                                       id="pan_number" name="pan_number" value="{{ old('pan_number', $customer->pan_number) }}">
                                @error('pan_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Sales Information Section -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sales_man_code">Salesman Code</label>
                                <input type="text" class="form-control @error('sales_man_code') is-invalid @enderror" 
                                       id="sales_man_code" name="sales_man_code" value="{{ old('sales_man_code', $customer->sales_man_code) }}">
                                @error('sales_man_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="area_code">Area Code</label>
                                <input type="text" class="form-control @error('area_code') is-invalid @enderror" 
                                       id="area_code" name="area_code" value="{{ old('area_code', $customer->area_code) }}">
                                @error('area_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="route_code">Route Code</label>
                                <input type="text" class="form-control @error('route_code') is-invalid @enderror" 
                                       id="route_code" name="route_code" value="{{ old('route_code', $customer->route_code) }}">
                                @error('route_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="state_code">State Code</label>
                                <input type="text" class="form-control @error('state_code') is-invalid @enderror" 
                                       id="state_code" name="state_code" value="{{ old('state_code', $customer->state_code) }}">
                                @error('state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="business_type">Business Type</label>
                                <select class="form-control @error('business_type') is-invalid @enderror" id="business_type" name="business_type">
                                    <option value="R" {{ old('business_type', $customer->business_type) == 'R' ? 'selected' : '' }}>Retail (R)</option>
                                    <option value="W" {{ old('business_type', $customer->business_type) == 'W' ? 'selected' : '' }}>Wholesale (W)</option>
                                    <option value="I" {{ old('business_type', $customer->business_type) == 'I' ? 'selected' : '' }}>Industrial (I)</option>
                                    <option value="D" {{ old('business_type', $customer->business_type) == 'D' ? 'selected' : '' }}>Distributor (D)</option>
                                    <option value="O" {{ old('business_type', $customer->business_type) == 'O' ? 'selected' : '' }}>Other (O)</option>
                                </select>
                                @error('business_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order_required">Order Required</label>
                                <select class="form-control @error('order_required') is-invalid @enderror" id="order_required" name="order_required">
                                    <option value="N" {{ old('order_required', $customer->order_required) == 'N' ? 'selected' : '' }}>No (N)</option>
                                    <option value="Y" {{ old('order_required', $customer->order_required) == 'Y' ? 'selected' : '' }}>Yes (Y)</option>
                                </select>
                                @error('order_required')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="2">{{ old('description', $customer->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection