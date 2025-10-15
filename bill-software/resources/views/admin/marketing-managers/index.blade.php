@extends('layouts.admin')

@section('title', 'Marketing Managers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Marketing Managers</h3>
                    <a href="{{ route('admin.marketing-managers.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Marketing Manager
                    </a>
                </div>
                <div class="card-body">
                    <!-- Content will be added later -->
                    <p class="text-muted">Marketing Managers management interface will be implemented here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
