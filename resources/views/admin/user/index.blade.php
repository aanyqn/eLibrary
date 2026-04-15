@extends('admin-layout.main')
@section('title')
<h2 class="page-title">
  <span class="page-title-icon bg-gradient-primary text-white me-2">
  <i class="mdi mdi-account"></i>
</span>
  User
</h2>
@endsection
@php
    $breadcrumbs = [
        'User' => null,
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
              <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                  Add User
              </a>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="text-center">ID</th>
              <th class="text-center">Nama User</th>
              <th class="text-center">Email</th>
              <th class="text-center">Roles</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $item)
            <tr>
                <td class="">{{ $item->id }}</td>
                <td class="text-truncate" style="max-width: 220px" title="{{ $item->name }}">{{ $item->name }}</td>
                <td class="">{{ $item->email }}</td>
                <td>
                @foreach ($item->roles as $role)
                    <span>{{ $role->name ? $role->name : 'no role identified' }}</span>
                    {{ $role->pivot->status ? '[active]' : '[inactive]' }}
                @endforeach
                </td>
                <td class="text-center">
                  <a href="{{ route('admin.user.edit', $item->id) }}" class="text-decoration-none">
                    <button class="badge badge-info">Edit</button>
                  </a>
                  <form action="{{ route('admin.user.delete', $item->id) }}">
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