<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('customers', CustomerController::class);
    Route::get('customers-export/csv', [CustomerController::class, 'exportCsv'])->name('customers.export.csv');
    Route::get('customers-export/pdf', [CustomerController::class, 'exportPdf'])->name('customers.export.pdf');

    Route::resource('orders', OrderController::class);
    Route::get('orders-export/csv', [OrderController::class, 'exportCsv'])->name('orders.export.csv');
    Route::get('orders-export/pdf', [OrderController::class, 'exportPdf'])->name('orders.export.pdf');

    Route::middleware('isAdmin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
