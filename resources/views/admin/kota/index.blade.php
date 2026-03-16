@extends('admin-layout.main')
@section('title')
<h2 class="page-title">
  <span class="page-title-icon bg-gradient-primary text-white me-2">
  <i class="mdi mdi-city"></i>
</span>
  Kota
</h2>
@endsection
@php
    $breadcrumbs = [
        'Kota' => null,
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
      <ul>
        <li><a href="{{ route('admin.kota.create') }}">Kota(select & select2)</a></li>
        <li><a href="{{ route('admin.cascade.ajax') }}">Cascade Select Ajax</a></li>
        <li><a href="{{ route('admin.cascade.axios') }}">Cascade Select Axios</a></li>
      </ul>
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