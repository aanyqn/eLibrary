@extends('general-layout.main')

@section('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
@endsection

@section('content')
<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center mt-5">
        <div class="row flex-grow">
            <div class="col-lg-8 mx-auto">
                <div class="auth-form-light text-left p-5">

                    <!-- LOGO -->
                    <div class="brand-logo mb-4">
                        <img src="../../assets/images/logo.svg" alt="Logo">
                    </div>

                    <!-- HERO -->
                    <h2 class="font-weight-bold mb-2">
                        Welcome to Purple Platform
                    </h2>
                    <h6 class="font-weight-light text-muted mb-4">
                        Manage your system, data, and services with a modern dashboard experience.
                    </h6>

                    <!-- BUTTONS -->
                    <div class="mt-4 d-grid gap-2">
                        <a href="/login" class="btn btn-primary btn-lg font-weight-medium auth-form-btn">
                            Login Now
                        </a>

                        <a href="/register" class="btn btn-outline-primary btn-lg font-weight-medium auth-form-btn">
                            Create Account
                        </a>
                    </div>

                    <!-- FEATURES -->
                    <div class="mt-5">
                        <h4 class="font-weight-bold mb-3">Why Choose Us?</h4>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="font-weight-bold">Fast</h5>
                                        <p class="text-muted mb-0">
                                            Lightweight system optimized for speed and efficiency.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="font-weight-bold">Secure</h5>
                                        <p class="text-muted mb-0">
                                            Authentication and access control built with Laravel.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="font-weight-bold">Modern</h5>
                                        <p class="text-muted mb-0">
                                            Clean interface design with responsive UI components.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ABOUT -->
                    <div class="mt-5">
                        <h4 class="font-weight-bold mb-3">About This Website</h4>
                        <p class="text-muted">
                            This platform is designed to help users manage their services, monitor activity,
                            and access dashboards in a simple and user-friendly interface.
                            Everything is built with scalability and usability in mind.
                        </p>
                    </div>

                    <!-- CTA -->
                    <div class="mt-4 text-center">
                        <p class="text-muted mb-2">
                            Ready to explore the system?
                        </p>
                        <a href="/login" class="btn btn-gradient-primary btn-fw">
                            Get Started
                        </a>
                    </div>

                    <!-- FOOTER TEXT -->
                    <div class="text-center mt-5 font-weight-light">
                        © 2026 Purple Platform. All rights reserved.
                    </div>

                </div>
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
