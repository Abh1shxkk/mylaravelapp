@extends('admin.layout')

@section('title', 'Company Details')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Company Details</h4>
                    <div class="btn-group">
                        <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-light btn-sm">
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
                                <th width="30%">Company Name</th>
                                <td>{{ $company->name }}</td>
                            </tr>
                            <tr>
                                <th>Short Name</th>
                                <td>{{ $company->short_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $company->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>{{ $company->location ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge {{ $company->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $company->status }}
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
                                <td>{{ $company->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Telephone</th>
                                <td>{{ $company->telephone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mobile 1</th>
                                <td>{{ $company->mobile_1 ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mobile 2</th>
                                <td>{{ $company->mobile_2 ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>
                                    @if($company->website)
                                        <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Contact Persons -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Contact Persons</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="25%">Contact Person 1</th>
                                <td>{{ $company->contact_person_1 ?? '-' }}</td>
                                <th width="25%">Contact Person 2</th>
                                <td>{{ $company->contact_person_2 ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Financial Information</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Pur. S.C.</th>
                                        <td>{{ number_format($company->pur_sc, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pur. Tax</th>
                                        <td>{{ number_format($company->pur_tax, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Sale S.C.</th>
                                        <td>{{ number_format($company->sale_sc, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sale Tax</th>
                                        <td>{{ number_format($company->sale_tax, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Min. GP</th>
                                        <td>{{ number_format($company->min_gp, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>VAT %</th>
                                        <td>{{ number_format($company->vat_percent, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Discount</th>
                                        <td>{{ number_format($company->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fixed/Maximum</th>
                                        <td>{{ number_format($company->fixed_maximum, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">Additional Settings</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Generic</th>
                                        <td>{{ $company->generic }}</td>
                                    </tr>
                                    <tr>
                                        <th>Direct/Indirect</th>
                                        <td>{{ $company->direct_indirect == 'D' ? 'Direct' : 'Indirect' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dis. on Sale %</th>
                                        <td>{{ number_format($company->dis_on_sale_percent, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Surcharge After Dis.</th>
                                        <td>{{ $company->surcharge_after_dis_yn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Add Surcharge</th>
                                        <td>{{ $company->add_surcharge_yn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Inclusive</th>
                                        <td>{{ $company->inclusive_yn }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Invoice Print Order</th>
                                        <td>{{ $company->invoice_print_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Disallow Expiry (Months)</th>
                                        <td>{{ $company->disallow_expiry_after_months }}</td>
                                    </tr>
                                    <tr>
                                        <th>Flag</th>
                                        <td>{{ $company->flag }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-primary">System Information</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="20%">Created At</th>
                                <td>{{ $company->created_at->format('M d, Y h:i A') }}</td>
                                <th width="20%">Updated At</th>
                                <td>{{ $company->updated_at->format('M d, Y h:i A') }}</td>
                            </tr>
                            @if($company->expiry)
                            <tr>
                                <th>Expiry Date</th>
                                <td colspan="3">{{ $company->expiry->format('M d, Y') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left"></i> Back to Companies
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection