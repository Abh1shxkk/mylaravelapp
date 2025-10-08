@extends('admin.layout')

@section('title', 'Companies')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Companies</h4>
                    <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Add Company
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
                                <th>Address</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $company->name }}</td>
                                <td>{{ Str::limit($company->address, 50) }}</td>
                                <td>{{ $company->email ?? '-' }}</td>
                                <td>{{ $company->mobile_1 ?? '-' }}</td>
                                <td>{{ $company->location ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $company->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $company->status }}
                                    </span>
                                </td>
                                <td>{{ $company->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.companies.show', $company->id) }}" 
                                           class="btn btn-info btn-sm" title="View">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.companies.edit', $company->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.companies.destroy', $company->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    title="Delete" 
                                                    onclick="return confirm('Are you sure you want to delete this company?')">
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
                                    No companies found. <a href="{{ route('admin.companies.create') }}">Create the first company</a>.
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