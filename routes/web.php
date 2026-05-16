<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;

// ==========================================
// 1. CÁC ROUTE CÔNG KHAI
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.detail');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/remove-from-cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Webhook của PayOS (PayOS sẽ tự động gọi vào đây, không cần đăng nhập)
Route::post('/payos/webhook', [OrderController::class, 'webhook']);


// ==========================================
// 2. CÁC ROUTE YÊU CẦU ĐĂNG NHẬP (Khách hàng)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/process-order', [OrderController::class, 'process'])->name('order.process');
    
    // URL hứng kết quả trả về từ trang PayOS
    Route::get('/checkout/success', [OrderController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [OrderController::class, 'cancel'])->name('checkout.cancel');

    // Thêm Route Lịch sử mua hàng
    Route::get('/history', [OrderController::class, 'history'])->name('order.history');
});


// ==========================================
// 3. CÁC ROUTE YÊU CẦU QUYỀN ADMIN
// ==========================================
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/book/create', [AdminController::class, 'create'])->name('admin.book.create');
    Route::post('/admin/book/store', [AdminController::class, 'store'])->name('admin.book.store');
});
