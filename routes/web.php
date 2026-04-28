<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ── Rutas públicas ───────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── Rutas protegidas (requieren login) ───────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('roles',     RoleController::class);
    Route::resource('users',     UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products',  ProductController::class);
    Route::resource('orders',    OrderController::class);

    Route::get('/orders-trash',         [OrderController::class, 'trash'])  ->name('orders.trash');
    Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])->name('orders.restore');
});