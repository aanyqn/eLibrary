@extends('admin-layout.main')
@section('title', 'Add Barang')
@php
    $breadcrumbs = [
        'Barang' => route('admin.barang'),
        'Add' => null
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
    <h4 class="card-title">Add Barang</h4>
    <p class="card-description">Add new barang list</p>
    <form action="{{ route('admin.barang.store') }}" method="POST" class="forms-sample">
        @csrf
        <div class="form-group">
        <label for="nama">Nama Barang</label>
        <input type="text" name="nama" class="form-control form-control-sm mb-3" id="namaBarang" placeholder="ex. Buku Jadul">
        @error('namaBarang')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        <label for="harga">Harga</label>
        <input type="number" name="harga" class="form-control form-control-sm mb-3" id="hargaBarang" step="0.01" min="0">
        @error('hargaBarang')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        </div>
        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
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
