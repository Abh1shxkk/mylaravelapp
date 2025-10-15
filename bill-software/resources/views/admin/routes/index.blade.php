@extends('layouts.admin')

@section('title', 'Routes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Routes</h3>
                    <a href="{{ route('admin.routes.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Route
                    </a>
                </div>
                <div class="card-body">
                    <!-- Content will be added later -->
                    <p class="text-muted">Routes management interface will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
