@extends('vendor-layout.main')
@section('title')
  <h2 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span>
    Menu
  </h2>
@endsection
@php
  $breadcrumbs = [
    'Dashboard' => null,
  ];
@endphp
@push('styles')
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
@endpush
@section('content')
  <div class="row">
    <div class="d-flex justify-content-end">
      <a href="{{ route('vendor.menu.create') }}" class="btn btn-primary">
        Add
      </a>
    </div>
  </div>
  <div class="row m-5 ">
    @forelse($data as $menu)
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-light card-img-holder h-100">

          @if ($menu->path_gambar)
            <img src="{{ asset('storage/' . $menu->path_gambar) }}" class="card-img-top"
              style="height: 200px; object-fit: cover;" alt="menu-image">
          @endif

          <div class="card-body d-flex flex-column">

            <!-- Nama -->
            <h5 class="text-dark mb-1">{{ $menu->nama }}</h5>
            <!-- Deskripsi -->
            <p class="text-muted small mb-2">
              {{ \Illuminate\Support\Str::limit($menu->deskripsi, 30) }}
            </p>
            <!-- Harga -->
            <h6 class="text-success mb-3">
              Rp {{ number_format($menu->harga, 0, ',', '.') }}
            </h6>
            <!-- Spacer biar button di bawah -->
            <div class="mt-auto d-flex justify-content-between">
              <!-- Edit -->
              <a href="{{ route('vendor.menu.edit', $menu->id_menu) }}" class="btn btn-sm btn-warning">
                Edit
              </a>
              <!-- Delete -->
              <form action="{{ route('vendor.menu.delete', $menu->id_menu) }}" method="POST"
                onsubmit="return confirm('Yakin mau hapus menu ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                  Delete
                </button>
              </form>
            </div>

          </div>
        </div>
      </div>
    @empty
      <div class="col-md-12 stretch-card grid-margin">
        <span>There's no menu added yet</span>
      </div>
    @endforelse
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