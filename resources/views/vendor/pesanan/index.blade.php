@extends('vendor-layout.main')
@section('title')
    <h2 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-receipt"></i>
        </span>
        Pesanan
    </h2>
@endsection
@php
    $breadcrumbs = [
        'Pesanan' => null,
    ];
@endphp
@push('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- End plugin css for this page -->
@endpush
@section('content')
    <div class="modal fade" id="scanner">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hasil Scan QR Pesanan</h5>
                </div>
                <div class="modal-body ms-3 me-3">
                    <div class="d-flex justify-content-center mb-3">
                        <div id="reader" style="width:300px;"></div>
                    </div>
                    <div id="scan-result" style="display:none;">
                        <p class="mb-1"><strong>Order ID:</strong> <span id="scan-order-id"></span></p>
                        <p class="mb-1"><strong>ID Pesanan:</strong> <span id="scan-id-pesanan"></span></p>
                        <p class="mb-2"><strong>Customer:</strong> <span id="scan-customer"></span></p>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="scan-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="scan-error" class="alert alert-danger" style="display:none;"></div>
                    <audio id="beep" src="{{ asset('assets/audio/beep.mp3') }}"></audio>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="closeScanner">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#scanner">
                Scan
            </button>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">
                            Order ID
                        </th>
                        <th class="text-center">
                            Customer
                        </th>
                        <th class="text-center">
                            Menu
                        </th>
                        <th class="text-center">
                            Harga
                        </th>
                        <th class="text-center">
                            Status Pesanan
                        </th>
                        <th class="text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $pesanan)
                        <tr>
                            <td class="text-center">
                                <span class="text-success">{{ $pesanan->order_id }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $pesanan->customer }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $pesanan->menu }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $pesanan->harga }}</span>
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge {{ $pesanan->status_pesanan == 0 ? 'badge-outline-danger' : ($pesanan->status_pesanan == 1 ? 'badge-outline-warning' : 'badge-outline-success') }}">{{ $pesanan->status_pesanan == 0 ? 'Belum' : ($pesanan->status_pesanan == 1 ? 'Proses' : 'Selesai') }}</span>
                            </td>
                            <td class="text-center">
                                <button data-id="{{ $pesanan->id_detail_pesanan }}"
                                    class="btn btn-sm btn-update-status {{ $pesanan->status_pesanan == 0 ? 'btn-warning' : ($pesanan->status_pesanan == 1 ? 'btn-danger' : 'btn-danger disabled') }}">
                                    {{ $pesanan->status_pesanan == 0 ? 'Buat Pesanan' : 'Selesaikan' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">There's no order today</td>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

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
        $(document).ready(function () {
            $(document).on('click', '.btn-update-status', function () {
                let id = $(this).data('id');
                $(this).prop('disabled', true);
                $(this).text('');
                $(this).html('<span class="spinner-border spinner-border-sm"></span> Loading...');
                console.log(id);
                axios.post('/vendor/pesanan/proses', {
                    id: id
                })
                    .then(response => {
                        console.log(response.data)
                        Swal.fire('Success', 'Status diubah', 'success')
                            .then(() => location.reload());
                    })
                    .catch(error => {
                        console.log(error.response);
                        Swal.fire('Error', 'Gagal', 'error');
                    })
            });
        })
    </script>
    <script>
        let html5QrcodeScanner;

        const modal = $('#scanner');

        modal.on('shown.bs.modal', function () {
            startScanner();
        });

        modal.on('hidden.bs.modal', function () {
            stopScanner();
        });

        function startScanner() {
            // Reset tampilan hasil scan
            $('#scan-result').hide();
            $('#scan-error').hide().text('');
            $('#scan-tbody').html('');
            $('#scan-order-id').text('');
            $('#scan-id-pesanan').text('');
            $('#scan-customer').text('');

            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                fps: 10,
                qrbox: { width: 150, height: 150 }
            });

            function onScanSuccess(decodedText, decodedResult) {
                console.log(`Scan result: ${decodedText}`, decodedResult);

                // Play beep sound
                const beep = document.getElementById('beep');
                if (beep) {
                    beep.play().catch(e => console.log('Audio play failed:', e));
                }

                stopScanner();

                // Fetch data pesanan berdasarkan order_id dari QR
                fetch(`/vendor/pesanan/api/${encodeURIComponent(decodedText)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.length > 0) {
                            const first = data.data[0];
                            $('#scan-order-id').text(first.order_id);
                            $('#scan-id-pesanan').text(first.id_pesanan);
                            $('#scan-customer').text(first.customer);

                            let rows = '';
                            data.data.forEach(item => {
                                const harga = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }).format(item.harga);

                                const statusLabel = item.status_pesanan == 0 ? 'Belum'
                                    : (item.status_pesanan == 1 ? 'Proses' : 'Selesai');
                                const statusClass = item.status_pesanan == 0 ? 'badge-outline-danger'
                                    : (item.status_pesanan == 1 ? 'badge-outline-warning' : 'badge-outline-success');
                                const btnClass = item.status_pesanan == 0 ? 'btn-warning'
                                    : (item.status_pesanan == 1 ? 'btn-success' : 'btn-secondary disabled');
                                const btnLabel = item.status_pesanan == 0 ? 'Buat Pesanan'
                                    : (item.status_pesanan == 1 ? 'Selesaikan' : 'Selesai');

                                rows += `
                                    <tr>
                                        <td>${item.menu}</td>
                                        <td>${harga}</td>
                                        <td><span class="badge ${statusClass}">${statusLabel}</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-update-status ${btnClass}"
                                                data-id="${item.id_detail_pesanan}">
                                                ${btnLabel}
                                            </button>
                                        </td>
                                    </tr>`;
                            });

                            $('#scan-tbody').html(rows);
                            $('#scan-result').show();
                        } else {
                            $('#scan-error').text(data.message || 'Pesanan tidak ditemukan.').show();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching pesanan:', error);
                        $('#scan-error').text('Terjadi kesalahan saat mengambil data pesanan.').show();
                    });
            }

            html5QrcodeScanner.render(onScanSuccess);
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(err => console.log(err));
                html5QrcodeScanner = null;
            }
        }
    </script>
    <!-- End custom js for this page -->
@endpush