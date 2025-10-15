@extends('layouts.admin')

@section('title', 'Areas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Areas</h3>
                    <a href="{{ route('admin.areas.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Area
                    </a>
                </div>
                <div class="card-body">
                    <!-- Content will be added later -->
                    <p class="text-muted">Areas management interface will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
