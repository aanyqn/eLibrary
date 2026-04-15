@extends('vendor-layout.main')
@section('title')
<h2 class="page-title">
  <span class="page-title-icon bg-gradient-primary text-white me-2">
  <i class="mdi mdi-home"></i>
</span>
  Profile
</h2>
@endsection
@php
    $breadcrumbs = [
        'Profile' => null,
    ];
@endphp
@push('styles')
<!-- Plugin css for this page -->
<link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
<!-- End plugin css for this page -->
@endpush
@section('content')
  <div class="row m-5">
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card bg-gradient-primary card-img-holder text-white">
        <div class="card-body">
          <h4 class="font-weight-normal mb-3">Kedai Saya<i class="mdi mdi-account mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-5">{{ $data->nama }}</h2>
          <h6 class="card-text">{{ $data->deskripsi }}</h6>
        </div>
      </div>
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