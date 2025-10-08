@extends('admin.layout')

@section('title', 'Edit Company')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Company</h4>
                <p class="card-description">Update the company details below</p>

                <form method="POST" action="{{ route('admin.companies.update', $company->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Company Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $company->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="1">{{ old('address', $company->address) }}</textarea>
                                @error('address')
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
                                       id="email" name="email" value="{{ old('email', $company->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact_person_1">Contact Person 1</label>
                                <input type="text" class="form-control @error('contact_person_1') is-invalid @enderror" 
                                       id="contact_person_1" name="contact_person_1" value="{{ old('contact_person_1', $company->contact_person_1) }}">
                                @error('contact_person_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact_person_2">Contact Person 2</label>
                                <input type="text" class="form-control @error('contact_person_2') is-invalid @enderror" 
                                       id="contact_person_2" name="contact_person_2" value="{{ old('contact_person_2', $company->contact_person_2) }}">
                                @error('contact_person_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                       id="website" name="website" value="{{ old('website', $company->website) }}">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="alter_code">Alter Code</label>
                                <input type="text" class="form-control @error('alter_code') is-invalid @enderror" 
                                       id="alter_code" name="alter_code" value="{{ old('alter_code', $company->alter_code) }}">
                                @error('alter_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telephone">Telephone</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" name="telephone" value="{{ old('telephone', $company->telephone) }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="short_name">Short Name</label>
                                <input type="text" class="form-control @error('short_name') is-invalid @enderror" 
                                       id="short_name" name="short_name" value="{{ old('short_name', $company->short_name) }}">
                                @error('short_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                       id="location" name="location" value="{{ old('location', $company->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile_1">Mobile 1</label>
                                <input type="text" class="form-control @error('mobile_1') is-invalid @enderror" 
                                       id="mobile_1" name="mobile_1" value="{{ old('mobile_1', $company->mobile_1) }}">
                                @error('mobile_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile_2">Mobile 2</label>
                                <input type="text" class="form-control @error('mobile_2') is-invalid @enderror" 
                                       id="mobile_2" name="mobile_2" value="{{ old('mobile_2', $company->mobile_2) }}">
                                @error('mobile_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Financial Information Section -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pur_sc">Pur. S.C.</label>
                                <input type="number" step="0.01" class="form-control @error('pur_sc') is-invalid @enderror" 
                                       id="pur_sc" name="pur_sc" value="{{ old('pur_sc', $company->pur_sc) }}">
                                @error('pur_sc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pur_tax">Pur. Tax</label>
                                <input type="number" step="0.01" class="form-control @error('pur_tax') is-invalid @enderror" 
                                       id="pur_tax" name="pur_tax" value="{{ old('pur_tax', $company->pur_tax) }}">
                                @error('pur_tax')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sale_sc">Sale S.C.</label>
                                <input type="number" step="0.01" class="form-control @error('sale_sc') is-invalid @enderror" 
                                       id="sale_sc" name="sale_sc" value="{{ old('sale_sc', $company->sale_sc) }}">
                                @error('sale_sc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sale_tax">Sale Tax</label>
                                <input type="number" step="0.01" class="form-control @error('sale_tax') is-invalid @enderror" 
                                       id="sale_tax" name="sale_tax" value="{{ old('sale_tax', $company->sale_tax) }}">
                                @error('sale_tax')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="expiry">Expiry</label>
                                <input type="date" class="form-control @error('expiry') is-invalid @enderror" 
                                       id="expiry" name="expiry" value="{{ old('expiry', $company->expiry ? $company->expiry->format('Y-m-d') : '') }}">
                                @error('expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="generic">Generic</label>
                                <select class="form-control @error('generic') is-invalid @enderror" id="generic" name="generic">
                                    <option value="N" {{ old('generic', $company->generic) == 'N' ? 'selected' : '' }}>N</option>
                                    <option value="Y" {{ old('generic', $company->generic) == 'Y' ? 'selected' : '' }}>Y</option>
                                </select>
                                @error('generic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="direct_indirect">Direct / Indirect</label>
                                <select class="form-control @error('direct_indirect') is-invalid @enderror" id="direct_indirect" name="direct_indirect">
                                    <option value="D" {{ old('direct_indirect', $company->direct_indirect) == 'D' ? 'selected' : '' }}>Direct</option>
                                    <option value="I" {{ old('direct_indirect', $company->direct_indirect) == 'I' ? 'selected' : '' }}>Indirect</option>
                                </select>
                                @error('direct_indirect')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dis_on_sale_percent">Dis. on Sale %</label>
                                <input type="number" step="0.01" class="form-control @error('dis_on_sale_percent') is-invalid @enderror" 
                                       id="dis_on_sale_percent" name="dis_on_sale_percent" value="{{ old('dis_on_sale_percent', $company->dis_on_sale_percent) }}">
                                @error('dis_on_sale_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="disallow_expiry_after_months">Disallow Expiry After (Months)</label>
                                <input type="number" class="form-control @error('disallow_expiry_after_months') is-invalid @enderror" 
                                       id="disallow_expiry_after_months" name="disallow_expiry_after_months" 
                                       value="{{ old('disallow_expiry_after_months', $company->disallow_expiry_after_months) }}" placeholder="0 Months (minus to lock)">
                                @error('disallow_expiry_after_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Additional Settings Section -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="surcharge_after_dis_yn">Surcharge After Dis. [Y/N]</label>
                                <select class="form-control @error('surcharge_after_dis_yn') is-invalid @enderror" id="surcharge_after_dis_yn" name="surcharge_after_dis_yn">
                                    <option value="N" {{ old('surcharge_after_dis_yn', $company->surcharge_after_dis_yn) == 'N' ? 'selected' : '' }}>N</option>
                                    <option value="Y" {{ old('surcharge_after_dis_yn', $company->surcharge_after_dis_yn) == 'Y' ? 'selected' : '' }}>Y</option>
                                </select>
                                @error('surcharge_after_dis_yn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="add_surcharge_yn">Add Surcharge [Y/N]</label>
                                <select class="form-control @error('add_surcharge_yn') is-invalid @enderror" id="add_surcharge_yn" name="add_surcharge_yn">
                                    <option value="N" {{ old('add_surcharge_yn', $company->add_surcharge_yn) == 'N' ? 'selected' : '' }}>N</option>
                                    <option value="Y" {{ old('add_surcharge_yn', $company->add_surcharge_yn) == 'Y' ? 'selected' : '' }}>Y</option>
                                </select>
                                @error('add_surcharge_yn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inclusive_yn">Inclusive</label>
                                <select class="form-control @error('inclusive_yn') is-invalid @enderror" id="inclusive_yn" name="inclusive_yn">
                                    <option value="N" {{ old('inclusive_yn', $company->inclusive_yn) == 'N' ? 'selected' : '' }}>N</option>
                                    <option value="Y" {{ old('inclusive_yn', $company->inclusive_yn) == 'Y' ? 'selected' : '' }}>Y</option>
                                </select>
                                @error('inclusive_yn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="min_gp">Min.GP</label>
                                <input type="number" step="0.01" class="form-control @error('min_gp') is-invalid @enderror" 
                                       id="min_gp" name="min_gp" value="{{ old('min_gp', $company->min_gp) }}">
                                @error('min_gp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="vat_percent">VAT %</label>
                                <input type="number" step="0.01" class="form-control @error('vat_percent') is-invalid @enderror" 
                                       id="vat_percent" name="vat_percent" value="{{ old('vat_percent', $company->vat_percent) }}">
                                @error('vat_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="invoice_print_order">Invoice Print Order</label>
                                <input type="number" class="form-control @error('invoice_print_order') is-invalid @enderror" 
                                       id="invoice_print_order" name="invoice_print_order" value="{{ old('invoice_print_order', $company->invoice_print_order) }}">
                                @error('invoice_print_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fixed_maximum">F(ixed) / M(aximum)</label>
                                <input type="number" step="0.01" class="form-control @error('fixed_maximum') is-invalid @enderror" 
                                       id="fixed_maximum" name="fixed_maximum" value="{{ old('fixed_maximum', $company->fixed_maximum) }}">
                                @error('fixed_maximum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" 
                                       id="discount" name="discount" value="{{ old('discount', $company->discount) }}">
                                @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="flag">Flag</label>
                                <input type="number" class="form-control @error('flag') is-invalid @enderror" 
                                       id="flag" name="flag" value="{{ old('flag', $company->flag) }}">
                                @error('flag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="Active" {{ old('status', $company->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $company->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                            <a href="{{ route('admin.companies.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection