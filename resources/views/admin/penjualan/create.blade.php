@extends('admin-layout.main')
@section('title', 'Add Penjualan')
@php
    $breadcrumbs = [
        'Penjualan' => route('admin.penjualan'),
        'Add Penjualan' => null
    ];
@endphp
@push('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
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
                            {{-- <input type="hidden" id="rowIndex"> --}}
                            <label for="id_barang">Kode Barang</label>
                            <input type="text" name="id_barang" id="editIdBarang" class="form-control mb-2" required
                                readonly>
                            <label for="nama">Nama Barang</label>
                            <input type="text" name="nama" id="editNamaBarang" class="form-control mb-2" required readonly>
                            <label for="harga">Harga Barang</label>
                            <input type="number" name="harga" id="editHargaBarang" class="form-control mb-2" required
                                readonly>
                            <label for="harga">Jumlah</label>
                            <input type="number" name="harga" id="editJumlah" class="form-control mb-2" required>
                            <label for="harga">Subtotal</label>
                            <input type="number" name="harga" id="editSubtotal" class="form-control mb-2" required readonly>
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
            <form id="form">
                @csrf
                <div class="form-group">
                    <label for="id_barang">Kode Barang</label>
                    <input type="text" required name="id_barang" class="form-control form-control-sm mb-3" id="idBarang"
                        placeholder="Masukkan kode barang">
                    @error('idBarang')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="nama">Nama Barang</label>
                    <input type="text" required name="nama" readonly class="form-control form-control-sm mb-3"
                        id="namaBarang" placeholder="ex. Buku Jadul">
                    @error('namaBarang')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="harga">Harga</label>
                    <input type="number" required name="harga" readonly class="form-control form-control-sm mb-3"
                        id="hargaBarang" step="0.01" min="0">
                    @error('hargaBarang')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <label for="jumlah">Jumlah</label>
                    <input type="number" required name="jumlah" class="form-control form-control-sm mb-3" id="jumlah"
                        step="1" min="0">
                    @error('jumlah')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                    <input type="hidden" id="totalHarga">
                    <button type="button" class="btn btn-success" id="add-button">Add</button>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table id="table" class="table">
                    <thead>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                </table>
            </div>
            <br>
            <h4>Total: <span id="total">0</span></h4>
            <br>
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
        $(function () {
            const form = $('#form');
            const modalForm = $('#modal-form');
            let addButton = $('#add-button');
            let tableBody = $('#table-body');
            let tableRow;
            const updateBtn = $('#update-button');
            const deleteBtn = $('#delete-button');
            $('#idBarang').on('input', function () {
                let kode = $('#idBarang').val();
                $.ajax({
                    url: '/admin/penjualan/barang/' + kode,
                    method: 'GET',
                    success: function (response) {
                        $('#namaBarang').val(response.data.barang?.nama ?? '');
                        $('#hargaBarang').val(response.data.barang?.harga ?? 0);
                        $('#jumlah').val(1)
                    }
                })
            });

            $('#jumlah').on('input', function () {
                if ($(this).val() == 0 || $(this).val() == null || $(this).val() == "") {
                    addButton.prop('disabled', true);
                } else {
                    addButton.prop('disabled', false);
                }
            })

            addButton.click(function () {
                if (!form[0].checkValidity()) {
                    form[0].reportValidity();
                    return;
                }

                addButton.prop('disabled', true);
                addButton.html('<span class="spinner-border spinner-border-sm"></span> Loading');

                let kode = $('#idBarang').val();
                let nama = $('#namaBarang').val();
                let harga = parseInt($('#hargaBarang').val());
                let jumlah = parseInt($('#jumlah').val());
                let subtotal = harga * jumlah;
                let previousKode;

                if (!validInput(nama)) {
                    addButton.prop('disabled', false);
                    addButton.html('Add');
                    return;
                }

                $("#table tbody tr").each(function () {
                    previousKode = $(this).find("td:eq(0)").text();

                    if (previousKode == kode) {
                        updateJumlah = parseInt($(this).find("td:eq(3)").text()) + jumlah;
                        updateSubtotal = parseInt($(this).find("td:eq(4)").text()) + subtotal;

                        $(this).find("td:eq(3)").text(updateJumlah);
                        $(this).find("td:eq(4)").text(updateSubtotal);
                        return false;
                    }
                });

                if (kode != previousKode) {
                    tableBody.append(`
                                        <tr>
                                            <td>${kode}</td>
                                            <td>${nama}</td>
                                            <td>${harga}</td>
                                            <td>${jumlah}</td>
                                            <td>${subtotal}</td>
                                        </tr>
                                        `);
                }

                hitungTotal();

                $('#idBarang').val('');
                $('#namaBarang').val('');
                $('#hargaBarang').val('');
                $('#jumlah').val('');

                addButton.prop('disabled', false);
                addButton.html('Add');
            });

            tableBody.on('click', 'tr', function () {
                tableRow = $(this);
                let kode = tableRow.find('td:eq(0)').text();
                let nama = tableRow.find('td:eq(1)').text();
                let harga = parseInt(tableRow.find('td:eq(2)').text());
                let jumlah = parseInt(tableRow.find('td:eq(3)').text());
                let subtotal = parseInt(tableRow.find('td:eq(4)').text());

                $('#editIdBarang').val(kode);
                $('#editNamaBarang').val(nama);
                $('#editHargaBarang').val(harga);
                $('#editJumlah').val(jumlah);
                $('#editSubtotal').val(subtotal);

                $('#editModal').modal('show');
            });

            $('#editJumlah').on('input', function () {
                harga = parseInt($('#editHargaBarang').val());
                jumlah = parseInt($(this).val()) || 0;
                subtotal = harga * jumlah;
                $('#editSubtotal').val(subtotal);
            });

            updateBtn.click(function () {

                const jumlah = $('#editJumlah').val();
                const subtotal = $('#editSubtotal').val();


                if (!modalForm[0].checkValidity() || !validInput(jumlah)) {
                    modalForm[0].reportValidity();
                    return;
                }

                updateBtn.prop('disabled', true);
                updateBtn.html('<span class="spinner-border spinner-border-sm"></span> Loading');

                tableRow.find('td:eq(3)').text(jumlah);
                tableRow.find('td:eq(4)').text(subtotal);

                $('#editModal').modal('hide');

                hitungTotal();
                updateBtn.prop('disabled', false);
                updateBtn.html('Edit');
            });

            deleteBtn.click(function () {

                deleteBtn.prop('disabled', true);
                deleteBtn.html('<span class="spinner-border spinner-border-sm"></span> Loading');

                tableRow.remove();

                $('#editModal').modal('hide');

                hitungTotal();
                deleteBtn.prop('disabled', false);
                deleteBtn.html('Delete');
            });

            function hitungTotal() {
                let total = 0;
                $("#table tbody tr").each(function () {
                    let subtotal = parseInt($(this).find("td:eq(4)").text()) || 0;
                    total += subtotal;
                });
                $('#total').text(total);
                $('#totalHarga').val(total);
            };

            function validInput(value) {
                if (value == null || value == 0 || value === "") {
                    Swal.fire(
                        'Error',
                        'There\'s Something Wrong',
                        'error'
                    );
                    return false;
                }
                return true;
            }

            $("#submitBtn").click(function () {
                $(this).prop('disabled', true);
                $(this).html('<span class="spinner-border spinner-border-sm"></span> Loading...');
                console.log('loadingg')

                let items = [];
                let total = $('#totalHarga').val();

                $("#table tbody tr").each(function () {

                    items.push({
                        id_barang: $(this).find("td:eq(0)").text(),
                        jumlah: $(this).find("td:eq(3)").text(),
                        subtotal: $(this).find("td:eq(4)").text(),
                    });

                });

                if (items.length === 0) {
                    Swal.fire('Error', 'Barang belum ada', 'error');
                    return;
                }

                $.ajax({
                    url: "/admin/penjualan/store/",
                    method: "POST",
                    data: {
                        items: items,
                        total: total,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        Swal.fire(
                            'Success',
                            'Penjualan added',
                            'success'
                        );
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Error',
                            'There\'s Something Wrong',
                            'error'
                        );
                    }
                });

                tableBody.empty();
                $(this).prop('disabled', false);
                $(this).html('Submit');

            });
        })
    </script>
@endpush