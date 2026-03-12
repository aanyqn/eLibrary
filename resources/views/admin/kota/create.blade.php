@extends('admin-layout.main')
@section('title', 'Add Kota')
@php
    $breadcrumbs = [
        'Barang' => '#',
        'Add Kota' => null
    ];
@endphp
@push('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- End plugin css for this page -->
    {{-- <style>
        #table-body tr {
            cursor: pointer;
        }
    </style> --}}
@endpush
@section('content')
    {{-- <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Kota</h5>
                </div>
                <div class="modal-body">
                    <form action="#" id="modal-form">
                        <div class="form-group">
                            <input type="hidden" id="rowIndex">
                            <label for="id_barang">ID Barang</label>
                            <input type="text" name="id_barang" id="editId" class="form-control mb-2" readonly>
                            <label for="nama">Nama Barang</label>
                            <input type="text" name="nama" id="editNama" class="form-control mb-2" required>
                            <label for="harga">Harga Barang</label>
                            <input type="number" name="harga" id="editHarga" class="form-control mb-2" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete-button">Delete</button>
                    <button type="button" class="btn btn-primary" id="update-button">Edit</button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card mb-5">
        <div class="card-body">
            <h4 class="card-title">Select</h4>
            <p class="card-description">Select kota menggunakan select biasa</p>
            <form action="#" method="POST" class="forms-sample" id="form">
                @csrf
                <div class="form-group">
                    <label for="nama">Kota</label>
                    <input type="text" required name="nama" class="form-control form-control-sm mb-3" id="namaKota"
                        placeholder="ex. Surabaya">
                    @error('namaKota')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <button type="button" class="btn btn-success mb-3" id="add-button">Add</button>
                    <br>
                    <label for="kota">Pilih Kota</label>
                    <select name="kota" class="form-control form-control-sm mb-3" id="kota">
                        <option selected>Pilih kota..</option>
                    </select>
                    @error('kota')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <h5>Kota terpilih: <span id="selected-kota">-</span></h5>
                </div>
                <hr>
                {{-- <div class="table-responsive">
                    <table id="table" class="table">
                        <thead>
                            <th>ID Barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </thead>
                        <tbody id="table-body">
                        </tbody>
                    </table>
                </div> --}}
                {{-- <br>
                <button type="button" class="btn btn-gradient-primary me-2" id="submitBtn">Submit</button>
                <button class="btn btn-light">Cancel</button> --}}
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Select2</h4>
            <p class="card-description">Select kota menggunakan select2</p>
            <form action="#" method="POST" class="forms-sample" id="form2">
                @csrf
                <div class="form-group">
                    <label for="nama">Kota</label>
                    <input type="text" required name="nama2" class="form-control form-control-sm mb-3" id="namaKota2"
                        placeholder="ex. Jakarta">
                    @error('namaKota2')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <button type="button" class="btn btn-success mb-3" id="add-button2">Add</button>
                    <div class="mb-3">
                        <label for="kota2">Pilih Kota</label>
                        <select name="kota2" class="form-control js-example-basic-single mb-3" id="kota2">
                        </select>
                        @error('kota2')
                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <h5>Kota terpilih: <span id="selected-kota2">-</span></h5>
                </div>
                {{-- <button type="button" class="btn btn-gradient-primary me-2" id="submitBtn">Submit</button>
                <button class="btn btn-light">Cancel</button> --}}
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        const form = $('#form');
        const form2 = $('#form2');
        const addButton = $('#add-button');
        const addButton2 = $('#add-button2');
        let selectOption = $('#kota');
        let selectedKota = $('#selected-kota')
        let selectOption2 = $('#kota2');
        let selectedKota2 = $('#selected-kota2')

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {
            $('#kota2').select2({
                theme: 'bootstrap-5'
            });
        });

        addButton.click(function () {
            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }
            addButton.prop('disabled', true);
            addButton.html('<span class="spinner-border spinner-border-sm"></span> Loading');

            let kota = $('#namaKota').val();

            selectOption.append(`<option value="${kota}">${kota}</option>`);

            $('#namaKota').val('');

            addButton.prop('disabled', false);
            addButton.html('Add');
        });

        selectOption.change(function () {
            let kota = $(this).val();
            selectedKota.html(kota)
        });

        addButton2.click(function () {
            if (!form2[0].checkValidity()) {
                form2[0].reportValidity();
                return;
            }
            addButton2.prop('disabled', true);
            addButton2.html('<span class="spinner-border spinner-border-sm"></span> Loading');

            let kota2 = $('#namaKota2').val();

            selectOption2.append(`<option value="${kota2}">${kota2}</option>`);
            selectOption2.trigger('change');

            $('#namaKota2').val('');

            addButton2.prop('disabled', false);
            addButton2.html('Add');
        });

        selectOption2.change(function () {
            let kota2 = $(this).val();
            selectedKota2.html(kota2)
        });

        // tableBody.on('click', 'tr', function () {
        //     selectedRow = $(this);
        //     let id = $(this).find('td:eq(0)').text();
        //     let nama = $(this).find('td:eq(1)').text();
        //     let harga = $(this).find('td:eq(2)').text();

        //     $('#editId').val(id);
        //     $('#editNama').val(nama);
        //     $('#editHarga').val(harga);

        //     $('#editModal').modal('show');

        // });

        // updateBtn.click(function () {

        //     const nama = $('#editNama').val();
        //     const harga = $('#editHarga').val();

        //     if (!modalForm[0].checkValidity()) {
        //         modalForm[0].reportValidity();
        //         return;
        //     }

        //     updateBtn.prop('disabled', true);
        //     updateBtn.html('<span class="spinner-border spinner-border-sm"></span> Loading');

        //     selectedRow.find('td:eq(1)').text(nama);
        //     selectedRow.find('td:eq(2)').text(harga);

        //     $('#editModal').modal('hide');

        //     updateBtn.prop('disabled', false);
        //     updateBtn.html('Edit');
        // });

        // deleteBtn.click(function () {

        //     deleteBtn.prop('disabled', true);
        //     deleteBtn.html('<span class="spinner-border spinner-border-sm"></span> Loading');

        //     selectedRow.remove();

        //     $('#editModal').modal('hide');

        //     deleteBtn.prop('disabled', false);
        //     deleteBtn.html('Delete');
        // });
    </script>
@endpush