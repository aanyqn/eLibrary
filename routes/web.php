<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'loginForm'])->name('login');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('isAdmin')->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category');
    Route::get('/admin/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/book', [App\Http\Controllers\Admin\BookController::class, 'index'])->name('admin.book');
    Route::get('/admin/book/create', [App\Http\Controllers\Admin\BookController::class, 'create'])->name('admin.book.create');
    Route::post('/admin/book/store', [App\Http\Controllers\Admin\BookController::class, 'store'])->name('admin.book.store');
});

// Route::get('/db-test', function () {
//     try {
//         \DB::connection()->getPdo();
//         return "Database connected successfully!";
//     } catch (\Exception $e) {
//         return "Database connection failed: " . $e->getMessage();
//     }
// });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
