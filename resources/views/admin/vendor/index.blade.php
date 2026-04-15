@extends('admin-layout.main')
@section('title')
<h2 class="page-title">
  <span class="page-title-icon bg-gradient-primary text-white me-2">
  <i class="mdi mdi-shopping"></i>
</span>
  Vendor
</h2>
@endsection
@php
    $breadcrumbs = [
        'Vendor' => null,
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
        <div class="row align-items-center mb-3 justify-content-between">
          <div class="col-auto">
              <a href="{{ route('admin.vendor.create') }}" class="btn btn-primary">
                  Add Vendor
              </a>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="text-center">ID</th>
              <th class="text-center">Nama Vendor</th>
              <th class="text-center">Deskripsi</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $item)
            <tr>
                <td class="">{{ $item->id_vendor }}</td>
                <td class="text-truncate" style="max-width: 220px" title="{{ $item->nama }}">{{ $item->nama }}</td>
                <td class="">{{ $item->deskripsi }}</td>
                <td class="text-center">
                  <a href="{{ route('admin.vendor.edit', $item->id_vendor) }}" class="text-decoration-none">
                    <button class="badge badge-info">Edit</button>
                  </a>
                  <form action="{{ route('admin.vendor.delete', $item->id_vendor) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="badge badge-danger">Delete</button type="submit">
                  </form>
                </td>
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
    <script src="/assets/js/select-all.js"></script>
@endpush