@extends('layouts.admin')

@section('title', 'Sales Men')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Sales Men</h3>
                    <a href="{{ route('admin.sales-men.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Sales Man
                    </a>
                </div>
                <div class="card-body">
                    <!-- Content will be added later -->
                    <p class="text-muted">Sales Men management interface will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
