@extends('admin.layout')

@section('title', 'Customers')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Customers</h4>
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Add Customer
                    </a>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->contact_person1 ?? '-' }}</td>
                                <td>{{ $customer->email ?? '-' }}</td>
                                <td>{{ $customer->mobile ?? '-' }}</td>
                                <td>{{ $customer->city ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $customer->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $customer->status ?? 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $customer->created_date->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                           class="btn btn-info btn-sm" title="View">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    title="Delete" 
                                                    onclick="return confirm('Are you sure you want to delete this customer?')">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="mdi mdi-information-outline me-2"></i>
                                    No customers found. <a href="{{ route('admin.customers.create') }}">Create the first customer</a>.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection