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
    <div class="card">
        <div class="card-body table-responsive">
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
                                <span
                                    class="badge {{ $pesanan->status_pesanan == 0 ? 'badge-outline-danger' : ($pesanan->status_pesanan == 1 ? 'badge-outline-warning' : 'badge-outline-success') }}">{{ $pesanan->status_pesanan == 0 ? 'Belum' : ($pesanan->status_pesanan == 1 ? 'Proses' : 'Selesai') }}</span>
                            </td>
                            <td class="text-center">
                                <button data-id="{{ $pesanan->id_pesanan }}"
                                    class="btn btn-sm btn-update-status {{ $pesanan->status_pesanan == 0 ? 'btn-warning' : ($pesanan->status_pesanan == 1 ? 'btn-danger' : 'btn-danger disabled') }}">
                                    {{ $pesanan->status_pesanan == 0 ? 'Buat Pesanan' : 'Selesaikan' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">There's no order today</td>
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
    <!-- End custom js for this page -->
@endpush