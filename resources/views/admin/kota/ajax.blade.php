@extends('admin-layout.main')
@section('title', 'Cascading Select (Ajax)')
@php
    $breadcrumbs = [
        'Kota' => 'admin.kota',
        'Cascading Select (Ajax)' => null
    ];
@endphp
@push('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Cascading Select</h4>
            <p class="card-description">Select Provinsi, kota, kecamatan, kelurahan</p>
            <div class="mb-3">
                <label for="provinsi">Pilih Provinsi</label>
                <select name="provinsi" class="form-control select2 js-example-basic-single mb-3" id="provinsi">
                    <option value="0">Pilih Provinsi</option>
                    @foreach($provinsi as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach
                </select>
                @error('provinsi')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kota">Pilih Kota</label>
                <select name="kota" class="form-control select2 js-example-basic-single mb-3" id="kota">
                    <option value="0">Pilih Kota</option>
                </select>
                @error('kota')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kecamatan">Pilih Kecamatan</label>
                <select name="kecamatan" class="form-control select2 js-example-basic-single mb-3" id="kecamatan">
                    <option value="0">Pilih Kecamatan</option>
                </select>
                @error('kecamatan')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kelurahan">Pilih Kelurahan</label>
                <select name="kelurahan" class="form-control select2 js-example-basic-single mb-3" id="kelurahan">
                    <option value="0">Pilih Kelurahan</option>
                </select>
                @error('kelurahan')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    <!-- End custom js for this page -->
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            $('#provinsi').change(function () {
                let provinsi_id = $('#provinsi').val();
                $('#kota').empty();


                $.ajax({
                    url: '/admin/cascade/ajax/kota/' + provinsi_id,
                    type: 'GET',
                    success: function (response) {
                        let kota = '<option value="0">Pilih Kota</option>';
                        response.data.kota.forEach(function (item) {
                            kota += `<option value="${item.id}">${item.name}</option>`
                        });
                        $('#kota').append(kota);
                        $('#kota').trigger('change');
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Error',
                            'there was an error',
                            'error'
                        );
                    }
                })
            });

            $('#kota').change(function () {
                let kota_id = $('#kota').val();
                $('#kecamatan').empty();

                $.ajax({
                    url: '/admin/cascade/ajax/kecamatan/' + kota_id,
                    type: 'GET',
                    success: function (response) {
                        let kecamatan = '<option value="0">Pilih Kecamatan</option>';
                        response.data.kecamatan.forEach(function (item) {
                            kecamatan += `<option value="${item.id}">${item.name}</option>`
                        });
                        $('#kecamatan').append(kecamatan);
                        $('#kecamatan').trigger('change');
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Error',
                            'there was an error',
                            'error'
                        );
                    }
                })
            });

            $('#kecamatan').change(function () {
                let kecamatan_id = $('#kecamatan').val();
                $('#kelurahan').empty();

                $.ajax({
                    url: '/admin/cascade/ajax/kelurahan/' + kecamatan_id,
                    type: 'GET',
                    success: function (response) {
                        let kelurahan = '<option value="0">Pilih Kelurahan</option>';
                        response.data.kelurahan.forEach(function (item) {
                            kelurahan += `<option value="${item.id}">${item.name}</option>`
                        });
                        $('#kelurahan').append(kelurahan);
                        $('#kelurahan').trigger('change');
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Error',
                            'there was an error',
                            'error'
                        );
                    }
                })
            });
        });
    </script>
@endpush