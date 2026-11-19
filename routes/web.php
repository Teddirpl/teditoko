<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukCon;
use App\Http\Controllers\PembelianCon;
use App\Http\Controllers\RegisterCon;
use App\Http\Controllers\CsCon;
use Illuminate\Support\Facades\Auth;

// === PUBLIC ROUTES ===
Route::get('/', [ProdukCon::class, 'home'])->name('homeproduk');
Route::get('/register', [RegisterCon::class, 'register'])->name('register');
Route::post('/register/action', [RegisterCon::class, 'actionregister'])
    ->name('actionregister');
Route::get('/login', [RegisterCon::class, 'login'])->name('login');
Route::post('/login/action', [RegisterCon::class, 'actionlogin'])
    ->name('actionlogin');

// === CUSTOMER SERVICE (bisa diakses pengunjung tanpa login) ===
Route::get('/cs', [CsCon::class, 'index'])->name('cs');
Route::post('/cs/store', [CsCon::class, 'store'])->name('cs.store');

// === PROTECTED ROUTES (Harus Login) ===
Route::middleware('auth')->group(function () {
    Route::get('/pesanan', [PembelianCon::class, 'index'])->name('pesanan');

    Route::post('/pembelian/storeinput', [PembelianCon::class, 'storeinput'])
        ->name('storeInputpembelian');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});
