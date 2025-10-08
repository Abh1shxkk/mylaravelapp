@extends('layouts.admin')

@section('title','Admin Dashboard')

@section('content')
<div class="container-fluid">
  <div class="row g-3">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="mb-0">Welcome, {{ auth()->user()->full_name }} 👋</h5>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


