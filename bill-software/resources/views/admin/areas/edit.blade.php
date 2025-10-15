@extends('layouts.admin')

@section('title', 'Edit Area')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Area</h3>
                    <a href="{{ route('admin.areas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <!-- Form content will be added later -->
                    <p class="text-muted">Area edit form will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
