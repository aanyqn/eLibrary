@extends('admin-layout.main')
@section('title', 'Add Barang Multiple (DataTables)')
@php
    $breadcrumbs = [
        'Barang' => route('admin.barang'),
        'Add Multiple (DataTables)' => null
    ];
@endphp
@push('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <!-- End plugin css for this page -->
    <style>
        #table-body tr {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Barang</h5>
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
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Barang</h4>
            <p class="card-description">Add new barang list</p>
            <form action="#" method="POST" class="forms-sample" id="form">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" required name="nama" class="form-control form-control-sm mb-3" id="namaBarang"
                        placeholder="ex. Buku Jadul">
                    @error('namaBarang')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="harga">Harga</label>
                    <input type="number" required name="harga" class="form-control form-control-sm mb-3" id="hargaBarang"
                        step="0.01" min="0">
                    @error('hargaBarang')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <button type="button" class="btn btn-success" id="add-button">Add</button>
                </div>
                <hr>
                <div class="">
                    <table id="table" class="hover stripe">
                        <thead>
                            <th>ID Barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </thead>
                        <tbody id="table-body">
                        </tbody>
                    </table>
                </div>
                <br>
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
    <script src="//cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
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
            let table = $('#table').DataTable();

            let id = table.rows().count() + 1;
            const form = $('#form');
            const modalForm = $('#modal-form');
            const addButton = $('#add-button');
            const updateBtn = $('#update-button');
            const deleteBtn = $('#delete-button');
            let tableBody = $('#table-body');
            let selectedRow;

            addButton.click(function () {
                if (!form[0].checkValidity()) {
                    form[0].reportValidity();
                    return;
                }
                addButton.prop('disabled', true);
                addButton.html('<span class="spinner-border spinner-border-sm"></span> Loading');

                let nama = $('#namaBarang').val();
                let harga = $('#hargaBarang').val();

                table.row.add([
                    id++,
                    nama,
                    harga
                ]).draw(false);

                $('#namaBarang').val('');
                $('#hargaBarang').val('');

                addButton.prop('disabled', false);
                addButton.html('Add');
            });

            tableBody.on('click', 'tr', function () {
                selectedRow = $(this);
                let id = selectedRow.find('td:eq(0)').text();
                let nama = selectedRow.find('td:eq(1)').text();
                let harga = selectedRow.find('td:eq(2)').text();

                $('#editId').val(id);
                $('#editNama').val(nama);
                $('#editHarga').val(harga);

                $('#editModal').modal('show');

            });

            updateBtn.click(function () {

                const nama = $('#editNama').val();
                const harga = $('#editHarga').val();

                if (!modalForm[0].checkValidity()) {
                    modalForm[0].reportValidity();
                    return;
                }

                updateBtn.prop('disabled', true);
                updateBtn.html('<span class="spinner-border spinner-border-sm"></span> Loading');

                selectedRow.find('td:eq(1)').text(nama);
                selectedRow.find('td:eq(2)').text(harga);

                $('#editModal').modal('hide');

                updateBtn.prop('disabled', false);
                updateBtn.html('Edit');
            });

            deleteBtn.click(function () {

                deleteBtn.prop('disabled', true);
                deleteBtn.html('<span class="spinner-border spinner-border-sm"></span> Loading');

                selectedRow.remove();

                $('#editModal').modal('hide');

                deleteBtn.prop('disabled', false);
                deleteBtn.html('Delete');
            });
        });
    </script>
@endpush