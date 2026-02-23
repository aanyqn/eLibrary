@extends('admin-layout.main')
@section('title', 'Category')
@php
    $breadcrumbs = [
        'Category' => null,
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
      <div class="">
        <a href="{{ route('admin.category.create') }}">
          <button type="button" class="btn btn-primary mb-2">Add</button>
        </a>
        
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Category Name</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $item)
          <tr class="">
              <td>{{ $item->idkategori }}</td>
              <td>{{ $item->nama_kategori }}</td>
              <td class="text-center">
                <a href="{{ route('admin.category.edit', $item->idkategori) }}">
                  <button class="badge badge-info">Edit</button>
                </a>
                <label class="badge badge-danger">Delete</label>
              </td>
          </tr>
          @empty
          <tr>
              <td colspan="2" class="align-item-center text-center">No categories is found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
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