@extends('admin-layout.main')
@section('title')
<h2 class="page-title">
  <span class="page-title-icon bg-gradient-primary text-white me-2">
  <i class="mdi mdi-shape-plus-outline"></i>
</span>
  Customer
</h2>
@endsection
@php
    $breadcrumbs = [
        'Customer' => null,
    ];
@endphp
@push('styles')
<!-- Plugin css for this page -->
<link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
<!-- End plugin css for this page -->
@endpush
@section('content')
  <div class="modal fade" id="cameraModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
            <h5>Foto Customer</h5>
          </div>
          <div class="modal-body d-flex gap-3 justify-content-center">
            <div id="imageContainer" class="m-2">
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.customer.create_blob') }}" class="text-decoration-none">
          <button type="button" class="btn btn-primary mb-2">Add (BLOB)</button>
        </a>
        <a href="{{ route('admin.customer.create_path') }}">
          <button type="button" class="btn btn-primary mb-2">Add (PATH)</button>
        </a>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="text-center">ID</th>
              <th class="text-center">Customer Name</th>
              <th class="text-center">Alamat</th>
              <th class="text-center">Foto</th>
              {{-- <th class="text-center">Action</th> --}}
            </tr>
          </thead>
          <tbody>
            @forelse($data as $item)
            <tr class="">
                <td>{{ $item->id_customer }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat . ', ' . $item->kelurahan . ', ' . $item->kecamatan . ', ' . $item->kota . ', ' . $item->provinsi }}</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" id="btn-foto" data-id="{{ $item->id_customer }}">
                    <i class="mdi mdi-eye"></i><span> Lihat</span>
                  </button>
                </td>
                {{-- <td class="text-center">
                  <a href="{{ route('admin.customer.edit', $item->idkategori) }}" class="text-decoration-none">
                    <button class="badge badge-info">Edit</button>
                  </a>
                  <label class="badge badge-danger">Delete</label>
                </td> --}}
            </tr>
            @empty
            <tr>
                <td colspan="3" class="align-item-center text-center">No customer is found.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <script>
      $(document).on('click', '#btn-foto', function() {
        let btn = $(this);
        let originalText = btn.html(); // simpan isi awal
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Loading...');
        let id = $(this).data('id');
        let foto;
        axios.get('/admin/customer/foto/' + id)
        .then(response => {
          foto = response.data.foto;
          if(response.data.path) {
            $('#imageContainer').html('<img src="' + response.data.path + foto + '" style="width:200px; height:200px;">');
          } else {
            $('#imageContainer').html('<img src="data:image/png;base64,' + foto + '" style="width:200px; height:200px;">');
          }
          $('.modal').modal('show');
          btn.prop('disabled', false);
          btn.html(originalText);
        })
        .catch(error => {
          Swal.fire(
            'Error',
            'there was an error',
            'error'
          );
        })
      })
    </script>
    <!-- End custom js for this page -->
@endpush