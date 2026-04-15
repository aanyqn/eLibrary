@php
    use chillerlan\QRCode\{QRCode, QROptions};
    require_once '../vendor/autoload.php';
@endphp

@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('app.midtrans.client_key') }}"></script>
@endpush

@section('content')
    <div class="container">
        <main class="py-4">
            <div class="row d-flex justify-content-center mb-3">
                <div class="col-6">
                    <a href="{{ route('pesanan') }}" class="btn btn-primary"><span>Back</span></a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6">

                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="mb-0">eLibrary</h4>
                            <small>#{{ $pesanan->id_pesanan }}</small>
                        </div>

                        <div class="card-body">

                            {{-- INFO CUSTOMER --}}
                            <div class="mb-3">
                                <strong>Nama:</strong> {{ $pesanan->nama }}
                            </div>

                            {{-- TABLE --}}
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Menu</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($details as $item)
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>Rp {{ number_format($item->harga) }}</td>
                                                <td>Rp {{ number_format($item->harga * $item->jumlah) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- TOTAL --}}
                            <div class="d-flex justify-content-end mt-2">
                                <h5>
                                    Total:
                                    <span class="text-success">
                                        Rp {{ number_format($pesanan->total) }}
                                    </span>
                                </h5>
                            </div>

                            {{-- STATUS --}}
                            <div class="mt-2">
                                <strong>Status:</strong>
                                @if($pesanan->status_bayar == 0)
                                    <span class="badge bg-warning">Belum Bayar</span>
                                @else
                                    <span class="badge bg-success">Lunas</span>
                                @endif
                            </div>

                            {{-- BUTTON --}}
                            @if($pesanan->status_bayar == 0)
                                <button id="pay-button" data-token="{{ $pesanan->snap_token }}"
                                    data-id="{{ $pesanan->id_pesanan }}" class="btn btn-primary w-100 mt-4">
                                    Bayar Sekarang
                                </button>
                            @endif
                        </div>
                        <div class="card m-5">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                @php
                                    $data = $pesanan->id_pesanan;
                                    $qrcode = (new QRCode)->render($data);

                                    printf('<img src="%s" alt="QR Code" style="width: 10em;" />', $qrcode);
                                @endphp
                                <div>
                                    <h5>Your order has been confirmed.</h5>
                                    <p>Please wait and take a seat.</p>
                                    <small>//. eLibrary .//</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#pay-button', function () {
                let snapToken = $(this).data('token');
                let idPesanan = $(this).data('id')
                let btn = $(this);
                console.log(window.snap);
                if (snapToken) {
                    snap.pay(snapToken, {
                        onSuccess: function (result) {
                            Swal.fire('Success', 'Pembayaran berhasil', 'success').then(() => {
                                Swal.fire('Success', 'Pembayaran berhasil', 'success');
                                localStorage.removeItem('cart');
                                btn.prop('disabled', false);
                                btn.text('');
                                btn.html('Bayar');
                                console.log(result);
                                axios.post('/payment', {
                                    result: result
                                })
                                    .then(response => {
                                        console.log(response);
                                        window.location.href = `/payment-success/` + response.data.id_pesanan;
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            });
                        },
                        onPending: function (result) {
                            Swal.fire('Pending', 'Menunggu pembayaran', 'info');
                        },
                        onError: function (result) {
                            Swal.fire('Error', 'Pembayaran gagal', 'error');
                        },
                        onClose: function () {
                            Swal.fire('Warning', 'Anda menutup popup tanpa menyelesaikan pembayaran', 'warning');
                        }
                    });
                }
            });
        })
    </script>
@endpush