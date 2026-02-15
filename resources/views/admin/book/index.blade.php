@extends('admin-layout.main')
@section('styles')
@section('title', 'Book')
@php
    $breadcrumbs = [
        'Book' => null,
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
        <div class="">
        <a href="{{ route('admin.book.create') }}">
          <button type="button" class="btn btn-primary btn-fw mb-2">Add</button>
        </a>
        
      </div>
      <table class="table">
        <thead>
          <tr>
            <th class="bg-primary text-white text-center">Code</th>
            <th class="bg-primary text-white text-center">Title</th>
            <th class="bg-primary text-white text-center">Author</th>
            <th class="bg-primary text-white text-center">Category</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $item)
          <tr>
              <td class="text-center">{{ $item->kode }}</td>
              <td class="text-center">{{ $item->judul }}</td>
              <td class="text-center">{{ $item->pengarang }}</td>
              <td class="text-center">{{ $item->nama_kategori }}</td>
          </tr>
          @empty
          <tr>
              <td colspan="4" class="align-item-center text-center">No books is found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
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