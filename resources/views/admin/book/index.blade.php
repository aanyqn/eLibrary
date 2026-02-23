@extends('admin-layout.main')
@section('title', 'Book')
@php
    $breadcrumbs = [
        'Book' => null,
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
        <div class="row align-items-center mb-3">
          <div class="col-md-6">
              <a href="{{ route('admin.book.create') }}" class="btn btn-primary">
                  Add
              </a>
          </div>
          <div class="col-md-6">
              <p>Generate PDF:</p>
              <form method="POST" action="{{ route('book.pdf') }}" class="d-flex gap-2">
                  @csrf

                  <select name="rotation" class="form-select">
                      <option value="landscape">Landscape</option>
                      <option value="portrait">Portrait</option>
                  </select>

                  <button type="submit" class="btn btn-success">
                      Generate
                  </button>
              </form>
          </div>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="text-center">Code</th>
            <th class="text-center">Title</th>
            <th class="text-center">Author</th>
            <th class="text-center">Category</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $item)
          <tr>
              <td class="">{{ $item->kode }}</td>
              <td class="">{{ $item->judul }}</td>
              <td class="">{{ $item->pengarang }}</td>
              <td class="">{{ $item->category->nama_kategori }}</td>
              <td class="text-center">
                <a href="{{ route('admin.book.edit', $item->idbuku) }}">
                  <button class="badge badge-info">Edit</button>
                </a>
                <label class="badge badge-danger">Delete</label>
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