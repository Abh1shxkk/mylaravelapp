@extends('layouts.admin')

@section('title', 'Divisional Managers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Divisional Managers</h3>
                    <a href="{{ route('admin.divisional-managers.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Divisional Manager
                    </a>
                </div>
                <div class="card-body">
                    <!-- Content will be added later -->
                    <p class="text-muted">Divisional Managers management interface will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
