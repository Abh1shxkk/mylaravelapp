@extends('layouts.admin')

@section('title', 'Create Route')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create New Route</h3>
                    <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <!-- Form content will be added later -->
                    <p class="text-muted">Route creation form will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
