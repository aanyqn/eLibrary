@extends('general-layout.main')
@push('styles')
@section('title', 'Dashboard')
@php
    $breadcrumbs = [
        'Dashboard' => null,
    ];
@endphp
<!-- Plugin css for this page -->
<link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
<!-- End plugin css for this page -->
@endpush
@section('content')
  <div class="row m-5">
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-danger card-img-holder text-white">
        <div class="card-body">
          <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
          <h4 class="font-weight-normal mb-3">Weekly Sales <i class="mdi mdi-chart-line mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-5">$ 15,0000</h2>
          <h6 class="card-text">Increased by 60%</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-info card-img-holder text-white">
        <div class="card-body">
          <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
          <h4 class="font-weight-normal mb-3">Weekly Orders <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-5">45,6334</h2>
          <h6 class="card-text">Decreased by 10%</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-success card-img-holder text-white">
        <div class="card-body">
          <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
          <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-5">95,5741</h2>
          <h6 class="card-text">Increased by 5%</h6>
        </div>
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
@endpush