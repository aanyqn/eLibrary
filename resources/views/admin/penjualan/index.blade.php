@extends('admin-layout.main')
@section('title')
    <h2 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-shopping"></i>
        </span>
        Sales
    </h2>
@endsection
@php
    $breadcrumbs = [
        'Penjualan' => null,
    ];
@endphp
@push('styles')
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <!-- End plugin css for this page -->
@endpush
@section('content')
    <!-- Vertically centered scrollable modal -->
    {{-- <div class="modal fade" id="labelBarang">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Label PDF</h5>
                </div>
                <div class="modal-body">
                    <input type="checkbox" id="checkAll">
                    <label class="mb-2 badge badge-outline-success">
                        Select All
                    </label>
                    <form method="POST" action="{{ route('label-barang.pdf') }}" class="d-flex gap-2">
                        @csrf
                        <div class="d-flex flex-column align-item-center gap-2">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Kode Barang</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data as $item)
                                        <tr>
                                            <td class="">{{ $item->id_barang }}</td>
                                            <td class="text-truncate" style="max-width: 200px">{{ $item->nama }}</td>
                                            <td class="">{{ $item->harga }}</td>
                                            <td class=""><input type="checkbox" name="id_barang[]" class="checkLabel"
                                                    id="id_barang" value="{{ $item->id_barang }}"></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="align-item-center text-center">No books is found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <label for="row mt-2">Print at row</label>
                            <input type="number" name="row" class="form-control form-control-sm mb-3" id="rowCoordinate"
                                max="8" min="1">
                            @error('rowCoordinate')
                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                            <label for="column mt-2">Print at column</label>
                            <input type="number" name="column" class="form-control form-control-sm mb-3" id="columnPoint"
                                max="5" min="1">
                            @error('columnPoint')
                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn btn-success">
                                Generate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center mb-3 justify-content-between">
                <div class="col-auto">
                    <a href="{{ route('admin.penjualan.create') }}" class="btn btn-primary">
                        Add New Sales
                    </a>
                    <a href="{{ route('admin.penjualan.create.axios') }}" class="btn btn-primary">
                        Add New Sales (Axios)
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">WAKTU</th>
                                <th class="text-center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td class="">{{ $item->id_penjualan }}</td>
                                    <td class="">{{ $item->created_at }}</td>
                                    <td class="">{{ $item->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
        <script src="/assets/js/select-all.js"></script>
        <script>
            $(document).ready(function () {
                let table = new DataTable('#table', {
                    columns: [
                        null,
                        null,
                        null,
                    ]
                });
            });
        </script>
    @endpush