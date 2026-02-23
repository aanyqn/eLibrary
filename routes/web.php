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
});

Route::get('/user/dashboard', [App\Http\Controllers\User\DashboarUserController::class, 'index'])->name('user.dashboard');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
