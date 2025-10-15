@extends('layouts.admin')

@section('title', 'Create Regional Manager')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create New Regional Manager</h3>
                    <a href="{{ route('admin.regional-managers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <!-- Form content will be added later -->
                    <p class="text-muted">Regional Manager creation form will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
