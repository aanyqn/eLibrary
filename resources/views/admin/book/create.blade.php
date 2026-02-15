@extends('admin-layout.main')
@section('styles')
@section('title', 'Category')
@php
    $breadcrumbs = [
        'Category' => route('admin.book'),
        'Add' => null
    ];
@endphp
<!-- Plugin css for this page -->
<link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
<!-- End plugin css for this page -->
@endsection
@section('content')
<div class="card">
    <div class="card-body">
    <h4 class="card-title">Add Book</h4>
    <p class="card-description">Add new book list</p>
    <form action="{{ route('admin.book.store') }}" method="POST" class="forms-sample">
        @csrf
        <div class="form-group">
        <label for="judul">Title</label>
        <input type="text" name="judul" class="form-control" id="judulBuku" placeholder="ex. Buku Jadul">
        @error('judulBuku')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        <label for="kode">Code</label>
        <input type="text" name="kode" class="form-control" id="kodeBuku" placeholder="ex. PM01">
        @error('kodeBuku')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        <label for="pengarang">Author</label>
        <input type="text" name="pengarang" class="form-control" id="pengarangBuku" placeholder="ex. Dwi Susanto">
        @error('pengarangBuku')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        <label for="idkategori">Category</label>
        <select name="idkategori" class="form-control" id="kategoriBuku">
            <option selected>Choose category..</option>
            @forelse($data_category as $item)
            <option value="{{ $item->idkategori }}">{{ $item->nama_kategori }}</option>
            @empty
            @endforelse
        </select>
        @error('kategoriBuku')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        </div>
        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
    </form>
    </div>
</div>
@endsection
@section('scripts')
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
@endsection
