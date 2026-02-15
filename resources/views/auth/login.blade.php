@extends('general-layout.main')

@section('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
@endsection

@section('content')
<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth mt-5">
        <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left p-5">
                    <div class="brand-logo">
                        <img src="../../assets/images/logo.svg">
                    </div>

                    <h4>Hello! let's get started</h4>
                    <h6 class="font-weight-light">Sign in to continue.</h6>

                    <form method="POST" action="{{ route('login') }}" class="pt-3">
                        @csrf

                        <div class="form-group">
                            <input id="email"
                                type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                                placeholder="Email Address">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password"
                                type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="my-2 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <label class="form-check-label text-muted" for="remember">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    Remember Me
                                    <i class="input-helper"></i>
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="auth-link text-primary" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            @endif
                        </div>

                        <div class="mt-3 d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg font-weight-medium auth-form-btn">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <div class="mb-2 d-grid gap-2">
                            <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                <i class="mdi mdi-facebook me-2"></i>Connect using facebook
                            </button>
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-primary">Create</a>
                        </div>

                    </form>
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
