<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- AUTH & GUEST ---
Route::get('/', function () { return view('login'); })->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () { return view('auth.forgot-password'); })
    ->middleware('guest')->name('password.request');

// --- GROUP USER / MAHASISWA ---
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/home', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/kantin/{id}', [UserController::class, 'detail'])->name('user.kantin');
    
    // Route Pelengkap Sidebar agar tidak error
    Route::get('/user/favorit', function() { return "Halaman Favorit"; })->name('user.favorit');
    Route::get('/user/riwayat', function() { return "Halaman Riwayat"; })->name('user.history');
    Route::get('/user/wallet', function() { return "Halaman Digital Wallet"; })->name('user.wallet');
});

// --- GROUP ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
});

// --- GROUP PENJUAL ---
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/penjual/dashboard', function () { return view('penjual.dashboard'); })->name('penjual.dashboard');
});