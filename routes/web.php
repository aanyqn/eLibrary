<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'loginForm'])->name('login');
Route::post('/login/post', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('redirect.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('/otp/verify', [App\Http\Controllers\OTPController::class, 'verify'])->name('otp.verify');
Route::get('/otp/resend', [App\Http\Controllers\OTPController::class, 'resendOtp'])->name('otp.resend');

Route::post('/pdf/book-pdf', [PDFController::class, 'generate'])->name('book.pdf');
Route::post('/pdf/label-barang', [PDFController::class, 'generateLabel'])->name('label-barang.pdf');

Route::middleware('isAdmin')->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category');
    Route::get('/admin/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('/admin/category/update', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('admin.category.delete');

    Route::get('/admin/book', [App\Http\Controllers\Admin\BookController::class, 'index'])->name('admin.book');
    Route::get('/admin/book/create', [App\Http\Controllers\Admin\BookController::class, 'create'])->name('admin.book.create');
    Route::post('/admin/book/store', [App\Http\Controllers\Admin\BookController::class, 'store'])->name('admin.book.store');
    Route::get('/admin/book/edit/{id}', [App\Http\Controllers\Admin\BookController::class, 'edit'])->name('admin.book.edit');
    Route::post('/admin/book/update', [App\Http\Controllers\Admin\BookController::class, 'update'])->name('admin.book.update');
    Route::delete('/admin/book/delete/{id}', [App\Http\Controllers\Admin\BookController::class, 'delete'])->name('admin.book.delete');

    Route::get('/admin/barang', [App\Http\Controllers\Admin\BarangController::class, 'index'])->name('admin.barang');
    Route::get('/admin/barang/create', [App\Http\Controllers\Admin\BarangController::class, 'create'])->name('admin.barang.create');
    Route::post('/admin/barang/store', [App\Http\Controllers\Admin\BarangController::class, 'store'])->name('admin.barang.store');
    Route::get('/admin/barang/edit/{id}', [App\Http\Controllers\Admin\BarangController::class, 'edit'])->name('admin.barang.edit');
    Route::post('/admin/barang/update', [App\Http\Controllers\Admin\BarangController::class, 'update'])->name('admin.barang.update');
    Route::delete('/admin/barang/delete/{id}', [App\Http\Controllers\Admin\BarangController::class, 'delete'])->name('admin.barang.delete');
    Route::get('/admin/barang/multiple', [App\Http\Controllers\Admin\BarangController::class, 'multiple'])->name('admin.barang.multiple');
    Route::get('/admin/barang/multiple-datatables', [App\Http\Controllers\Admin\BarangController::class, 'multipleDatatables'])->name('admin.barang.multiple.datatables');

    Route::get('/admin/penjualan', [App\Http\Controllers\Admin\PenjualanController::class, 'index'])->name('admin.penjualan');
    Route::get('/admin/penjualan/create', [App\Http\Controllers\Admin\PenjualanController::class, 'create'])->name('admin.penjualan.create');
    Route::get('/admin/penjualan/barang/{kode}', [App\Http\Controllers\Admin\PenjualanController::class, 'barang'])->name('admin.penjualan.barang');
    Route::post('/admin/penjualan/store', [App\Http\Controllers\Admin\PenjualanController::class, 'store'])->name('admin.penjualan.store');

    Route::get('/admin/penjualan/create/axios', [App\Http\Controllers\Admin\PenjualanController::class, 'createAxios'])->name('admin.penjualan.create.axios');

    Route::get('/admin/ajax', [App\Http\Controllers\Admin\AjaxController::class, 'index'])->name('admin.ajax');
    Route::post('/admin/ajax/submit', [App\Http\Controllers\Admin\AjaxController::class, 'submit'])->name('admin.ajax.submit');

    Route::get('/admin/cascade/ajax', [App\Http\Controllers\Admin\AjaxController::class, 'cascadeSelectAjax'])->name('admin.cascade.ajax');
    Route::get('/admin/cascade/ajax/kota/{province_id}', [App\Http\Controllers\Admin\AjaxController::class, 'kota'])->name('admin.cascade.ajax.kota');
    Route::get('/admin/cascade/ajax/kecamatan/{regency_id}', [App\Http\Controllers\Admin\AjaxController::class, 'kecamatan'])->name('admin.cascade.ajax.kecamatan');
    Route::get('/admin/cascade/ajax/kelurahan/{district_id}', [App\Http\Controllers\Admin\AjaxController::class, 'kelurahan'])->name('admin.cascade.ajax.kelurahan');

    Route::get('/admin/cascade/axios', [App\Http\Controllers\Admin\AjaxController::class, 'cascadeSelectAxios'])->name('admin.cascade.axios');

    Route::get('/admin/kota', function () {
        return view('admin.kota.index');
    })->name('admin.kota');

    Route::get('/admin/kota/create', function () {
        return view('admin.kota.create');
    })->name('admin.kota.create');

    Route::get('/admin/learn', function () {
        return view('admin.learn.index');
    })->name('admin.learn');

    Route::get('/admin/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
    Route::get('/admin/user/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/admin/user/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.delete');

    Route::get('/admin/vendor', [App\Http\Controllers\Admin\VendorController::class, 'index'])->name('admin.vendor');
    Route::get('/admin/vendor/create', [App\Http\Controllers\Admin\VendorController::class, 'create'])->name('admin.vendor.create');
    Route::post('/admin/vendor/store', [App\Http\Controllers\Admin\VendorController::class, 'store'])->name('admin.vendor.store');
    Route::get('/admin/vendor/edit/{id}', [App\Http\Controllers\Admin\VendorController::class, 'edit'])->name('admin.vendor.edit');
    Route::post('/admin/vendor/update', [App\Http\Controllers\Admin\VendorController::class, 'update'])->name('admin.vendor.update');
    Route::delete('/admin/vendor/delete/{id}', [App\Http\Controllers\Admin\VendorController::class, 'destroy'])->name('admin.vendor.delete');

    Route::get('/admin/customer', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customer');
    Route::get('/admin/customer/create_blob', [App\Http\Controllers\Admin\CustomerController::class, 'createBlob'])->name('admin.customer.create_blob');
    Route::post('/admin/customer/store_blob', [App\Http\Controllers\Admin\CustomerController::class, 'storeBlob'])->name('admin.customer.store_blob');
    Route::get('/admin/customer/create_path', [App\Http\Controllers\Admin\CustomerController::class, 'createPath'])->name('admin.customer.create_path');
    Route::post('/admin/customer/store_path', [App\Http\Controllers\Admin\CustomerController::class, 'storePath'])->name('admin.customer.store_path');
    Route::get('/admin/customer/foto/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'getFoto'])->name('admin.customer.foto');
});

Route::get('/user/dashboard', [App\Http\Controllers\User\DashboarUserController::class, 'index'])->name('user.dashboard');

Route::middleware('isVendor')->group(function () {
    Route::get('/vendor/dashboard', [App\Http\Controllers\Vendor\DashboardVendorController::class, 'index'])->name('vendor.dashboard');

    Route::get('/vendor/profile', [App\Http\Controllers\Vendor\ProfileController::class, 'index'])->name('vendor.profile');

    Route::get('/vendor/menu', [App\Http\Controllers\Vendor\MenuController::class, 'index'])->name('vendor.menu');
    Route::get('/vendor/menu/create', [App\Http\Controllers\Vendor\MenuController::class, 'create'])->name('vendor.menu.create');
    Route::post('/vendor/menu/store', [App\Http\Controllers\Vendor\MenuController::class, 'store'])->name('vendor.menu.store');
    Route::get('/vendor/menu/edit/{id}', [App\Http\Controllers\Vendor\MenuController::class, 'edit'])->name('vendor.menu.edit');
    Route::post('/vendor/menu/update', [App\Http\Controllers\Vendor\MenuController::class, 'update'])->name('vendor.menu.update');
    Route::delete('/vendor/menu/delete/{id}', [App\Http\Controllers\Vendor\MenuController::class, 'destroy'])->name('vendor.menu.delete');

    Route::get('/vendor/pesanan', [App\Http\Controllers\Vendor\PesananController::class, 'index'])->name('vendor.pesanan');
    Route::post('/vendor/pesanan/proses', [App\Http\Controllers\Vendor\PesananController::class, 'changePesananStatus'])->name('vendor.pesanan.proses');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/pesan', [App\Http\Controllers\Sites\PesananController::class, 'index'])->name('pesanan');
Route::get('/pesan/{id_vendor}', [App\Http\Controllers\Sites\PesananController::class, 'vendorMenu'])->name('pesanan.vendor');
Route::post('/checkout', [App\Http\Controllers\Sites\PesananController::class, 'checkout'])->name('pesanan.checkout');
Route::post('/payment', [App\Http\Controllers\Sites\PesananController::class, 'payment'])->name('pesanan.payment');
Route::get('/payment-success/{id_pesanan}', [App\Http\Controllers\Sites\PesananController::class, 'success'])->name('pesanan.success');