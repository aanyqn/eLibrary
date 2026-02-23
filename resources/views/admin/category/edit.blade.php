@extends('admin-layout.main')
@section('title', 'Edit Category')
@php
    $breadcrumbs = [
        'Category' => route('admin.category'),
        'Edit' => null
    ];
@endphp
@push('styles')
<!-- Plugin css for this page -->
<link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
<!-- End plugin css for this page -->
@endpush
@section('content')
<div class="card">
    <div class="card-body">
    <h4 class="card-title">Edit Category</h4>
    <p class="card-description">Edit books category</p>
    <form action="{{ route('admin.category.update') }}" method="POST" class="forms-sample">
        @csrf
        <input type="hidden" name="idkategori" value="{{ $id }}">
        <div class="form-group">
        <label for="nama_kategori">Category Name</label>
        <input type="text" name="nama_kategori" class="form-control" id="namaKategori" placeholder="ex. Dongeng">
        @error('namaKategori')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        </div>
        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <a href="{{ route('admin.category') }}"><button class="btn btn-light">Cancel</button></a>
    </form>
    </div>
</div>
@endsection
@push('scripts')
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
@endpush
