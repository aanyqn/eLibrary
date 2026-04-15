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
    <div class="modal fade" id="keranjangModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Keranjang saya</h5>
                </div>
                <div class="modal-body" id="cartContainer">
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Total: <span id="totalHarga">Rp 0</span></h6>
                    <button type="button" class="btn btn-success btn-pay">Bayar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        @if(isset($pendingPesanan))
            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-4">
                <div>
                    <strong>Anda memiliki pesanan yang belum dibayar!</strong> (Order ID:
                    {{ $pendingPesanan->order_id ?? $pendingPesanan->id_pesanan }})
                </div>
                <button class="btn btn-primary btn-sm" id="btn-lanjut-bayar" data-id="{{ $pendingPesanan->id_pesanan }}"
                    data-token="{{ $pendingPesanan->snap_token }}">
                    Lanjutkan Pembayaran
                </button>
            </div>
        @endif
        <div class="row justify-content-between mb-5">
            <div class="col-md-3">
                <select name="vendor" class="form-control select2 js-example-basic-single mb-3" id="vendor">
                    <option value="0" selected>Pilih vendor..</option>
                    @foreach($vendor as $data_vendor)
                        <option value="{{ $data_vendor->id_vendor }}">{{ $data_vendor->nama }}</option>
                    @endforeach
                </select>
                @error('vendor')
                    <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" id="btn-cart">
                    Keranjang
                    <span class="btn btn-sm btn-light" id="cartCounter">0</span>
                </button>

            </div>
        </div>
        <div class="row justify-content-start" id="menu">
            @foreach($data as $menu)
                <div class="col-md-4" id="menuOption">
                    <div class="card mb-3" id="menuCard">
                        <div class="card-header">
                            <small>{{ $menu->nama_vendor }}</small>
                        </div>
                        @if ($menu->path_gambar)
                            <img src="{{ asset('storage/' . $menu->path_gambar) }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;" alt="menu-image">
                        @endif
                        <div class="card-body">
                            <h5 class="text-dark mb-1">{{ $menu->nama }}</h5>
                            <p class="text-muted small mb-2">
                                {{ \Illuminate\Support\Str::limit($menu->deskripsi, 30) }}
                            </p>
                            <h6 class="text-success mb-3">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </h6>
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="#" class="btn btn-sm btn-success btn-tambah" data-id="{{ $menu->id_menu }}"
                                    data-nama="{{ $menu->nama }}" data-vendor="{{ $menu->nama_vendor }}"
                                    data-harga="{{ $menu->harga }}" data-gambar="{{ $menu->path_gambar }}">
                                    Tambahkan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            $('#vendor').change(function () {
                let id_vendor = $('#vendor').val();
                $('#menu').empty();

                axios.get('/pesan/' + id_vendor)
                    .then(function (response) {
                        response.data.data.menu.forEach(function (item) {
                            let harga_format = new Intl.NumberFormat('id-ID').format(item.harga);
                            let gambar;
                            let menu = $('#menu');
                            if (item.path_gambar) {
                                gambar = `<img src="${'storage/' + item.path_gambar}" class="card-img-top"
                                                                                                    style="height: 200px; object-fit: cover;" alt="menu-image">`;
                            }
                            menu.append(`<div class="col-md-4" id="menuOption">
                                <div class="card mb-3" id="menuCard">
                                    <div class="card-header">
                                        <small>${item.nama_vendor}</small>
                                    </div>
                                        ${gambar ?? ''}
                                    <div class="card-body">
                                        <h5 class="text-dark mb-1">${item.nama}</h5>
                                        <!-- Deskripsi -->
                                        <p class="text-muted small mb-2">
                                            ${item.deskripsi.slice(0, 30)}
                                        </p>
                                        <h6 class="text-success mb-3">
                                            Rp ${harga_format}
                                        </h6>
                                        <div class="mt-auto d-flex justify-content-between">
                                            <a href="#" class="btn btn-sm btn-success btn-tambah" data-id="${item.id_menu}"
                                                data-nama="${item.nama}" data-vendor="${item.nama_vendor}"
                                                data-harga="${item.harga}" data-gambar="${item.path_gambar ?? ''}">
                                                Tambahkan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`)
                        });
                        $('#menu').trigger('change');
                    });
            });

            renderCart()

            $('#btn-cart').on('click', function () {
                renderCart();
                $('#keranjangModal').modal('show');
            });

            $(document).on('click', '.btn-tambah', function (e) {
                e.preventDefault();

                let item = {
                    id_menu: $(this).data('id'),
                    nama: $(this).data('nama'),
                    vendor: $(this).data('vendor'),
                    harga: $(this).data('harga'),
                    gambar: $(this).data('gambar'),
                    qty: 1
                };

                tambahKeranjang(item);
                renderCart();
            });

            function tambahKeranjang(itemBaru) {
                let cart = JSON.parse(localStorage.getItem('cart')) ?? [];

                let index = cart.findIndex(item => item.id_menu == itemBaru.id_menu);

                if (index !== -1) {
                    cart[index].qty += 1;
                } else {
                    cart.push(itemBaru);
                }

                localStorage.setItem('cart', JSON.stringify(cart));

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Item ditambahkan ke keranjang',
                    timer: 1000,
                    showConfirmButton: false
                });
            }

            function renderCart() {
                let cart = JSON.parse(localStorage.getItem('cart')) ?? [];
                let container = $('#cartContainer');

                container.empty();

                let total = 0;
                let totalItem = 0;

                if (cart.length === 0) {
                    container.append('<p class="text-center">Keranjang kosong</p>');
                    $('#totalHarga').text('Rp 0');
                    $('#cartCounter').text(totalItem);
                    return;
                }

                cart.forEach(item => {
                    let harga = item.harga * item.qty;
                    total += harga;

                    totalItem += item.qty

                    let hargaFormat = new Intl.NumberFormat('id-ID').format(harga);

                    container.append(`
                        <div class="d-flex align-items-center justify-content-between border-bottom py-2">

                            <!-- IMAGE -->
                            <div style="width: 60px;">
                                <img src="/storage/${item.gambar}" class="img-fluid rounded"
                                    style="height: 60px; width: 60px; object-fit: cover;">
                            </div>

                            <!-- INFO -->
                            <div class="flex-grow-1 mx-3">
                                <h6 class="mb-1">${item.nama}</h6>
                                <small class="text-muted">${item.vendor}</small>
                                <div class="text-success small">Rp ${hargaFormat}</div>
                            </div>

                            <!-- QTY -->
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-sm btn-outline-secondary btn-minus" data-id="${item.id_menu}">-</button>
                                <span>${item.qty}</span>
                                <button class="btn btn-sm btn-outline-primary btn-plus" data-id="${item.id_menu}">+</button>
                            </div>

                        </div>
                    `);
                });

                let totalFormat = new Intl.NumberFormat('id-ID').format(total);
                $('#totalHarga').text('Rp ' + totalFormat);
                $('#cartCounter').text(totalItem);
            }

            $(document).on('click', '.btn-plus', function () {
                let id = $(this).data('id');
                let cart = JSON.parse(localStorage.getItem('cart')) ?? [];

                cart = cart.map(item => {
                    if (item.id_menu == id) item.qty += 1;
                    return item;
                });

                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            });

            $(document).on('click', '.btn-minus', function () {
                let id = $(this).data('id');
                let cart = JSON.parse(localStorage.getItem('cart')) ?? [];

                cart = cart.map(item => {
                    if (item.id_menu == id) {
                        item.qty -= 1;
                    }
                    return item;
                }).filter(item => item.qty > 0);

                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            });

            $(document).on('click', '.btn-pay', function () {
                let cart = JSON.parse(localStorage.getItem('cart')) ?? [];
                let btn = $(this);
                btn.prop('disabled', true);
                btn.text('');
                btn.html('<span class="spinner-border spinner-border-sm"></span> Loading...');
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty',
                        text: 'Tidak ada item di keranjang',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    btn.prop('disabled', false);
                    btn.text('');
                    btn.html('Bayar');
                    return;
                } else {
                    axios.post('/checkout', {
                        cart: cart
                    })
                        .then(response => {
                            let snapToken = response.data.snapToken;
                            snap.pay(snapToken, {
                                onSuccess: function (result) {
                                    Swal.fire('Success', 'Pembayaran berhasil', 'success');
                                    localStorage.removeItem('cart');
                                    btn.prop('disabled', false);
                                    btn.text('');
                                    btn.html('Bayar');
                                    axios.post('/payment', {
                                    result: result
                                    })
                                    .then(response => {
                                        console.log(response);
                                        window.location.href = `/payment-success/` + response.data.id_pesanan;
                                    })
                                    .catch(error =>{
                                        console.log(error);
                                    });
                                },
                                onPending: function (result) {
                                    Swal.fire('Pending', 'Menunggu pembayaran', 'info');
                                },
                                onError: function (result) {
                                    Swal.fire('Error', 'Pembayaran gagal', 'error');
                                }
                            });
                        })
                        .catch(error => {
                            console.log(error.response)
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Pesanan gagal dibuat.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        });
                }
            })
            $(document).on('click', '#btn-lanjut-bayar', function () {
                let snapToken = $(this).data('token');
                let idPesanan = $(this).data('id')
                let btn = $(this);
                if (snapToken) {
                    snap.pay(snapToken, {
                        onSuccess: function (result) {
                            Swal.fire('Success', 'Pembayaran berhasil', 'success').then(() => {
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
                                .catch(error =>{
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
        });
    </script>
@endpush