@extends('admin-layout.main')
@section('title', 'Belajar Ajax')
@php
    $breadcrumbs = [
        'Ajax' => route('admin.barang'),
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
            <h4 class="card-title">Belajar AJAX (Async JS and XML)</h4>
            <p class="card-description">with jquery</p>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" required name="nama" class="form-control form-control-sm mb-3" id="nama" maxlength="50"
                    minlength="3" placeholder="ex. Buku Jadul">
                @error('nama')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
                <h5>Your input is: <span id="result"></span></h5>
            </div>
            <button type="button" class="btn btn-gradient-primary me-2" id="submitBtn">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    {{--
    <script src="/assets/js/dashboard.js"></script> --}}
    <!-- End custom js for this page -->
    <script>
        $('#submitBtn').click(function () {
            let button = $('#submitBtn');
            button.html('Loading..')
            let nama = $('#nama').val();

            $.ajax({
                url: "{{ route('admin.ajax.submit') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    nama: nama
                },
                success: function (response) {
                    button.html('Submit');
                    console.log(response.code);
                    if (response.status == 'success') {
                        $('#result').html(response.data.name);
                        Swal.fire(
                            'Success',
                            'Data updated',
                            'success'
                        );
                        $('#nama').val('');
                    } else {
                        Swal.fire(
                            'Error',
                            'there was an error submiting your data',
                            'error'
                        );
                    }
                },
                error: function (xhr) {
                    button.html('Submit');
                    Swal.fire(
                        'Error',
                        'there was an error submiting your data',
                        'error'
                    );
                }
            })
        })
    </script>
@endpush