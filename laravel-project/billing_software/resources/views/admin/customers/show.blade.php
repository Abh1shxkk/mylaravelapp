@extends('admin.layout')

@section('title', 'Customer Details')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Customer Details</h4>
                    <div class="btn-group">
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-primary">Basic Information</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Customer Name</th>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $customer->code ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tax Registration</th>
                                <td>{{ $customer->tax_registration ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pin Code</th>
                                <td>{{ $customer->pin_code ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $customer->city ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge {{ $customer->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $customer->status ?? 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-primary">Contact Information</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Email</th>
                                <td>{{ $customer->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Telephone Office</th>
                                <td>{{ $customer->telephone_office ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Telephone Residence</th>
                                <td>{{ $customer->telephone_residence ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $customer->mobile ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Fax Number</th>
                                <td>{{ $customer->fax_number ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Address -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Address</h5>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">{{ $customer->address ?? 'No address provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Persons -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Contact Persons</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="25%">Contact Person I</th>
                                <td>{{ $customer->contact_person1 ?? '-' }}</td>
                                <th width="25%">Mobile Contact 1</th>
                                <td>{{ $customer->mobile_contact1 ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Contact Person II</th>
                                <td>{{ $customer->contact_person2 ?? '-' }}</td>
                                <th>Mobile Contact 2</th>
                                <td>{{ $customer->mobile_contact2 ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Financial Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Opening Balance</th>
                                        <td>{{ number_format($customer->opening_balance, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Balance Type</th>
                                        <td>{{ $customer->balance_type == 'D' ? 'Debit' : 'Credit' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Local/Central</th>
                                        <td>{{ $customer->local_central == 'L' ? 'Local' : 'Central' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Credit Days</th>
                                        <td>{{ $customer->credit_days }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Business Type</th>
                                        <td>
                                            @switch($customer->business_type)
                                                @case('R') Retail @break
                                                @case('W') Wholesale @break
                                                @case('I') Industrial @break
                                                @case('D') Distributor @break
                                                @case('O') Other @break
                                                @default {{ $customer->business_type }}
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Required</th>
                                        <td>{{ $customer->order_required == 'Y' ? 'Yes' : 'No' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- License Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">License Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Food License</th>
                                        <td>{{ $customer->food_license ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>CST Number</th>
                                        <td>{{ $customer->cst_number ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>TIN Number</th>
                                        <td>{{ $customer->tin_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>PAN Number</th>
                                        <td>{{ $customer->pan_number ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>DL Number 1</th>
                                        <td>{{ $customer->dl_number1 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>DL Expiry</th>
                                        <td>{{ $customer->dl_expiry ? $customer->dl_expiry->format('M d, Y') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Sales Information</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Salesman Code</th>
                                        <td>{{ $customer->sales_man_code }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Area Code</th>
                                        <td>{{ $customer->area_code }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Route Code</th>
                                        <td>{{ $customer->route_code }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>State Code</th>
                                        <td>{{ $customer->state_code }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($customer->description)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Description</h5>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">{{ $customer->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timestamps -->
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-primary">System Information</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="20%">Created Date</th>
                                <td>{{ $customer->created_date->format('M d, Y h:i A') }}</td>
                                <th width="20%">Modified Date</th>
                                <td>{{ $customer->modified_date->format('M d, Y h:i A') }}</td>
                            </tr>
                            @if($customer->birth_day)
                            <tr>
                                <th>Birth Day</th>
                                <td colspan="3">{{ $customer->birth_day->format('M d, Y') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Additional Details (appended) -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Additional Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Pin Code</th>
                                        <td>{{ $customer->pin_code ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice Export</th>
                                        <td>{{ ($customer->invoice_export ?? 'N') === 'Y' ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Registration Status</th>
                                        <td>{{ $customer->registration_status ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>GST Name</th>
                                        <td>{{ $customer->gst_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>TAN Number</th>
                                        <td>{{ $customer->tan_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>MSME License</th>
                                        <td>{{ $customer->msme_license ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>DL Number</th>
                                        <td>{{ $customer->dl_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aadhar Number</th>
                                        <td>{{ $customer->aadhar_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>State Code GST</th>
                                        <td>{{ $customer->state_code_gst ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Registration Date</th>
                                        <td>{{ $customer->registration_date ? $customer->registration_date->format('M d, Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <td>{{ $customer->end_date ? $customer->end_date->format('M d, Y') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Day Value</th>
                                        <td>{{ $customer->day_value ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Due List Sequence</th>
                                        <td>{{ $customer->due_list_sequence ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Flag</th>
                                        <td>{{ $customer->flag ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Type</th>
                                        <td>
                                            @switch($customer->business_type)
                                                @case('R') Retail @break
                                                @case('W') Wholesale @break
                                                @case('I') Industrial @break
                                                @case('D') Distributor @break
                                                @case('O') Other @break
                                                @default {{ $customer->business_type }}
                                            @endswitch
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left"></i> Back to Customers
                        </a>
                    </div>
                </div>