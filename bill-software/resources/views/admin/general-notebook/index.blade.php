@extends('layouts.admin')

@section('title', 'General Notebook')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">
                <i class="bi bi-notebook me-2"></i>General Notebook
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.general-notebook.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Note
            </a>
        </div>
    </div>

    @if ($notebooks->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 35%">Title</th>
                        <th style="width: 40%">Content</th>
                        <th style="width: 10%">Date</th>
                        <th style="width: 10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notebooks as $notebook)
                        <tr>
                            <td>{{ ($notebooks->currentPage() - 1) * $notebooks->perPage() + $loop->iteration }}</td>
                            <td><strong>{{ $notebook->title ?? '-' }}</strong></td>
                            <td>{{ Str::limit($notebook->content ?? '-', 60) }}</td>
                            <td>{{ $notebook->created_at?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.general-notebook.edit', $notebook) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" data-delete-url="{{ route('admin.general-notebook.destroy', $notebook) }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $notebooks->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>No notes found. <a href="{{ route('admin.general-notebook.create') }}">Create one now</a>
        </div>
    @endif
</div>

<button id="scrollToTop" type="button" title="Scroll to top" onclick="scrollToTopNow()">
    <i class="bi bi-arrow-up"></i>
</button>
@endsection
