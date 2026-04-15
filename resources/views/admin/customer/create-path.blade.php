@extends('admin-layout.main')
@section('title', 'Add Customer (BLOB)')
@php
    $breadcrumbs = [
        'Kota' => '#',
        'Add Customer (BLOB)' => null
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
    <div class="modal fade" id="cameraModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Ambil Foto</h5>
                </div>
                <div class="modal-body d-flex gap-3 justify-content-center">
                    <div>
                        <video id="camera" autoplay playsinline
                            style="width:200px; height:200px; background:black;"></video>
                        <select id="cameraOption" class="form-control mt-2"></select>
                    </div>

                    <div class="d-flex flex-column align-items-center">
                        <canvas id="snapshot" style="width:200px; height:200px; border:1px solid #ccc;"></canvas>
                        <button id="btnCapture" type="button" class="btn btn-success mt-2">
                            Ambil Foto
                        </button>
                    </div>
                </div>
                <div class="modal-footer d-flex align-items-center">
                    <button type="button" class="btn btn-success">
                        <span>Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Customer</h4>
            <p class="card-description">Add new customer</p>
            <div class="mb-3">
                <label for="nama">Customer Name</label>
                <input type="text" name="nama" class="form-control mb-3" id="namaCustomer" placeholder="ex. Owo Santoso">
                @error('namaCustomer')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" class="form-control mb-3" id="alamatCustomer"
                    placeholder="ex. Jl. Celah Tikus 2 No. 32">
                @error('alamatCustomer')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
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
            <p>debug kecamatan:<span id="debug"></span></p>
            <div class="mb-3">
                <label for="kelurahan">Pilih Kelurahan</label>
                <select name="kelurahan" class="form-control select2 js-example-basic-single mb-3" id="kelurahan">
                    <option value="0">Pilih Kelurahan</option>
                </select>
                @error('kelurahan')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-flex flex-column align-items-start">
                <div class="mb-3" style="width: 200px">
                    <img id="previewImage" src="" alt="photo" class="img-fluid border">
                </div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cameraModal">
                    <span>Ambil Foto</span>
                </button>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-send">
                    Simpan
                </button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    <!-- End custom js for this page -->
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            $('#provinsi').change(function () {
                let provinsi_id = $('#provinsi').val();
                $('#kota').empty();

                axios.get('/admin/cascade/ajax/kota/' + provinsi_id)
                    .then(function (response) {
                        let kota = '<option value="0">Pilih Kota</option>';
                        response.data.data.kota.forEach(function (item) {
                            kota += `<option value="${item.id}">${item.name}</option>`
                        });
                        $('#kota').append(kota);
                        $('#kota').trigger('change');
                    })
                    .catch(function (error) {
                        Swal.fire(
                            'Error',
                            'there was an error',
                            'error'
                        );
                    })
            });

            $('#kota').change(function () {
                let kota_id = $('#kota').val();
                $('#kecamatan').empty();

                axios.get('/admin/cascade/ajax/kecamatan/' + kota_id)
                    .then(function (response) {
                        let kecamatan = '<option value="0">Pilih Kecamatan</option>';
                        response.data.data.kecamatan.forEach(function (item) {
                            kecamatan += `<option value="${item.id}">${item.name}</option>`
                        });
                        $('#kecamatan').append(kecamatan);
                        $('#kecamatan').trigger('change');
                    })
                    .catch(function (error) {
                        Swal.fire(
                            'Error',
                            'there was an error',
                            'error'
                        );
                    })
            });

            $('#kecamatan').change(function () {
                let kecamatan_id = $('#kecamatan').val();
                $('#debug').html(kecamatan_id);
                $('#kelurahan').empty();

                axios.get('/admin/cascade/ajax/kelurahan/' + kecamatan_id)
                    .then(function (response) {
                        let kelurahan = '<option value="0">Pilih Kelurahan</option>';
                        response.data.data.kelurahan.forEach(function (item) {
                            kelurahan += `<option value="${item.id}">${item.name}</option>`
                        });
                        $('#kelurahan').append(kelurahan);
                        $('#kelurahan').trigger('change');
                    })
                    .catch(function (error) {
                        Swal.fire(
                            'Error',
                            'there was an error',
                            'error'
                        );
                    })
            });
        });
    </script>
    <script>
        let video = $('#camera')[0];
        let canvas = $('#snapshot')[0];
        let preview = $('#previewImage');
        let cameraSelect = $('#cameraOption');

        let stream;
        let capturedImage = null;

        async function getCameras() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const cameras = devices.filter(device => device.kind === 'videoinput');

            cameraSelect.empty();
            $.each(cameras, function (index, camera) {
                cameraSelect.append(
                    `<option value="${camera.deviceId}">Camera ${index + 1}</option>`
                );
            });
        }

        async function startCamera(deviceId = null) {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            stream = await navigator.mediaDevices.getUserMedia({
                video: deviceId ? { deviceId: { exact: deviceId } } : true
            });

            video.srcObject = stream;
        }

        let capturedBlob = null;

        $('#btnCapture').on('click', function () {
            let context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(function (blob) {
                if (!blob) {
                    console.error('Blob kosong!');
                    return;
                }
                capturedBlob = blob;


                // preview tetap bisa pakai URL
                let previewUrl = URL.createObjectURL(blob);
                preview.attr('src', previewUrl);
            }, 'image/png');
        });

        cameraSelect.on('change', function () {
            startCamera($(this).val());
        });

        $('#cameraModal').on('shown.bs.modal', async function () {
            await getCameras();
            startCamera(cameraSelect.val());
        });

        $('#cameraModal').on('hidden.bs.modal', function () {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>

    <script>
        $('.btn-send').on('click', function () {

            let formData = new FormData();

            formData.append('nama', $('#namaCustomer').val());
            formData.append('alamat', $('#alamatCustomer').val());
            formData.append('provinsi', $('#provinsi').val());
            formData.append('kota', $('#kota').val());
            formData.append('kecamatan', $('#kecamatan').val());
            formData.append('kelurahan', $('#kelurahan').val());

            if (capturedBlob) {
                formData.append('foto', capturedBlob, 'foto.png'); // ✅ file asli
            }

            axios.post('/admin/customer/store_path', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    console.log(response.data);
                    Swal.fire('Success', 'Customer berhasil disimpan', 'success');
                })
                .catch(error => {
                    console.log(error.response);
                    Swal.fire('Error', 'Gagal menyimpan data', 'error');
                });
        });
    </script>
@endpush