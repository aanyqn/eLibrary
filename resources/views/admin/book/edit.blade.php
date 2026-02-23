@extends('admin-layout.main')
@section('title', 'Edit Book')
@php
    $breadcrumbs = [
        'Book' => route('admin.book'),
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
    <h4 class="card-title">Edit Book</h4>
    <p class="card-description">Edit book list</p>
    <form action="{{ route('admin.book.update') }}" method="POST" class="forms-sample">
        @csrf
        <input type="hidden" name="idbuku" value="{{ $id }}">
        <div class="form-group">
        <label for="judul">Title</label>
        <input type="text" name="judul" class="form-control form-control-sm mb-3" id="judulBuku" value="{{ $old[0]->judul }}" placeholder="ex. Buku Jadul">
        @error('judulBuku')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        <label for="kode">Code</label>
        <input type="text" name="kode" class="form-control form-control-sm mb-3" id="kodeBuku" value="{{ $old[0]->kode }}" placeholder="ex. PM01">
        @error('kodeBuku')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        <label for="pengarang">Author</label>
        <input type="text" name="pengarang" class="form-control form-control-sm mb-3" id="pengarangBuku" value="{{ $old[0]->pengarang }}" placeholder="ex. Dwi Susanto">
        @error('pengarangBuku')
            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
        <label for="idkategori">Category</label>
        <select name="idkategori" class="form-control form-control-sm mb-3" id="kategoriBuku">
            <option>Choose category..</option>
            @forelse($data_category as $item)
            <option {{ $item->idkategori == $old[0]->idkategori ? 'selected' : '' }} value="{{ $item->idkategori }}">{{ $item->nama_kategori }}</option>
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
