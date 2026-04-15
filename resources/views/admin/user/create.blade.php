@extends('admin-layout.main')
@section('title', 'Add User')
@php
    $breadcrumbs = [
        'User' => route('admin.user'),
        'Add' => null
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
            <h4 class="card-title">Add User</h4>
            <p class="card-description">Add new user list</p>
            <form action="{{ route('admin.user.store') }}" method="POST" class="forms-sample" id="form">
                @csrf
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" required name="name" class="form-control form-control-sm mb-3" id="namaUser"
                        maxlength="50" minlength="3">
                    @error('namaUser')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="email">Email</label>
                    <input type="email" required name="email" class="form-control form-control-sm mb-3" id="emailUser">
                    @error('emailUser')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="password">Password</label>
                    <input type="password" required name="password" class="form-control form-control-sm mb-3" id="passwordUser">
                    @error('paswordUser')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    @foreach ($roles as $role)
                        <label>
                            <input type="radio" name="roles" value="{{ $role->id }}">
                            {{ $role->name }}
                        </label><br>
                    @endforeach
                    @error('roleUser')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <button type="button" class="btn btn-gradient-primary me-2" id="submitBtn">Submit</button>
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
    <script src="{{ asset('assets/js/submit-loader.js') }}"></script>
    <!-- End custom js for this page -->
@endpush