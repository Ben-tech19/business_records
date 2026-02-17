<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

// Auth Routes (public)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // All users can read (GET)
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/goods', [GoodController::class, 'index'])->name('goods.index');
    Route::get('/goods/{good}', [GoodController::class, 'show'])->name('goods.show');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');

    // All users can create/record sales
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    // Admin-only: Create, Edit, Update, Delete suppliers and goods
    Route::middleware('admin')->group(function () {
        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

        Route::get('/goods/create', [GoodController::class, 'create'])->name('goods.create');
        Route::post('/goods', [GoodController::class, 'store'])->name('goods.store');
        Route::get('/goods/{good}/edit', [GoodController::class, 'edit'])->name('goods.edit');
        Route::put('/goods/{good}', [GoodController::class, 'update'])->name('goods.update');
        Route::delete('/goods/{good}', [GoodController::class, 'destroy'])->name('goods.destroy');

        Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    });
});

