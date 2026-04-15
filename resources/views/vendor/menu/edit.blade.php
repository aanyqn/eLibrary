@extends('vendor-layout.main')
@section('title', 'Add Menu')
@php
    $breadcrumbs = [
        'Menu' => route('vendor.menu'),
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
            <h4 class="card-title">Add Menu</h4>
            <p class="card-description">Add new menu list</p>
            <form action="{{ route('vendor.menu.update') }}" method="POST" enctype="multipart/form-data" class="forms-sample" id="form">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id_menu" value="{{ $id }}">
                    <label for="path_gambar">Foto</label>
                    <input type="file" name="path_gambar" class="form-control mb-3" id="gambarMenu"
                        accept="image/*">
                    @error('namaMenu')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="nama">Nama Menu</label>
                    <input type="text" required name="nama" class="form-control form-control-sm mb-3" id="namaMenu"
                        maxlength="30" minlength="3" placeholder="ex. Es Teler" value="{{ $old[0]->nama }}">
                    @error('namaMenu')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="harga">Harga</label>
                    <input type="number" required name="harga" class="form-control form-control-sm mb-3" id="hargaMenu"
                        step="0.01" min="0" value="{{ $old[0]->harga }}">
                    @error('hargaMenu')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="deskripsi">Deskripsi Menu</label>
                    <input type="text" required name="deskripsi" class="form-control form-control-sm mb-3" id="namaMenu"
                        maxlength="200" minlength="3" value="{{ $old[0]->deskripsi }}">
                    @error('namaMenu')
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