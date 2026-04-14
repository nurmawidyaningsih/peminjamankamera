<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () { return redirect()->route('dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/items/all', [DashboardController::class, 'allItems'])->name('items.all');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Peminjaman
    Route::get('/pinjamBarang', [LoanController::class, 'index'])->name('pinjamBarang');
    Route::post('/loans', [LoanController::class, 'borrow'])->name('loans.borrow');
    
    // TAMBAHKAN ROUTE INI UNTUK BORROW ITEM
    Route::post('/items/borrow', [LoanController::class, 'borrowItem'])->name('items.borrow');
    
    // User mengambil barang
    Route::post('/loans/{loan}/take', [LoanController::class, 'takeItem'])->name('loans.take');
    
    // Transaksi
    Route::get('/transactions', [LoanController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/{loan}/receipt', [LoanController::class, 'printReceipt'])->name('transactions.receipt');
});

// Admin & Petugas routes
Route::middleware(['auth', RoleMiddleware::class . ':admin,petugas'])->group(function () {
    // Inventaris
    Route::get('/items', [ItemController::class, 'index'])->name('items');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    
    // Approve & Reject
    Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    
    // Return barang
    Route::post('/loans/{loan}/return', [LoanController::class, 'returnLoan'])->name('loans.return');
    
    // DELETE LOAN - HAPUS DATA PEMINJAMAN (TAMBAHKAN INI)
    Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])->name('loans.destroy');
    
    // Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
    Route::delete('/logs/{log}', [LogController::class, 'destroy'])->name('logs.delete');
});

// Admin only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// User only routes
Route::middleware(['auth', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/my-loans', [LoanController::class, 'userLoans'])->name('my.loans');
    Route::get('/my-logs', [LogController::class, 'userLogs'])->name('my.logs');
});

// Fallback
Route::fallback(function () {
    return view('errors.404');
});