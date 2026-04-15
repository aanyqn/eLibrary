@extends('admin-layout.main')
@section('title', 'Add Vendor')
@php
    $breadcrumbs = [
        'Vendor' => route('admin.vendor'),
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
            <h4 class="card-title">Add Vendor</h4>
            <p class="card-description">Add new vendor list</p>
            <form action="{{ route('admin.vendor.store') }}" method="POST" class="forms-sample" id="form">
                @csrf
                <div class="form-group">
                    <label for="id_user">Pilih Vendor</label>
                    <select name="id_user" class="form-control select mb-3" id="akunUser">
                        <option value="">Pilih..</option>
                        @foreach($data as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                    @error('akunUser')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="nama">Nama Kedai</label>
                    <input type="text" required name="nama" class="form-control form-control-sm mb-3" id="namaVendor"
                        maxlength="50" minlength="3">
                    @error('namaVendor')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" required name="deskripsi" class="form-control form-control-sm mb-3" id="deskripsiVendor">
                    @error('deskripsiVendor')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <button type="button" class="btn btn-gradient-primary me-2" id="submitBtn">Submit</button>
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
    <script src="{{ asset('assets/js/submit-loader.js') }}"></script>
    <!-- End custom js for this page -->
@endpush