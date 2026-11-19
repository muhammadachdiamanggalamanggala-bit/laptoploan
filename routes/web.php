<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;

// ==== HALAMAN LOGIN (tidak butuh login) ====
Route::get('/', fn () => view('welcome'))->name('welcome');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/katalog', [BarangController::class, 'katalog'])->name('katalog');
Route::get('/katalog/{barang}', [BarangController::class, 'detail'])->name('katalog.show');

// ==== HALAMAN YANG BUTUH LOGIN ====
Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/peminjaman-saya', [PeminjamanController::class, 'saya'])->name('peminjaman.saya');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
        Route::get('/laporan/{laporan}/lampiran', [LaporanController::class, 'file'])->name('laporan.file');
    Route::post('/katalog/{barang}/pinjam', [PeminjamanController::class, 'storeFromCatalog'])->name('katalog.pinjam');
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat');
    Route::patch('/notifikasi/baca', function (\Illuminate\Http\Request $request) {
        $request->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');
    Route::get('/notifikasi/{notification}', function (\Illuminate\Http\Request $request, string $notification) {
        $userNotification = $request->user()->notifications()->whereKey($notification)->firstOrFail();
        $userNotification->markAsRead();

        if ($request->user()->isAdmin()
            && ($userNotification->data['url'] ?? null) === route('peminjaman.index', [], false)) {
            return redirect()->route('peminjaman.index');
        }

        return redirect()->route('dashboard');
    })->name('notifications.show');

    Route::middleware('admin')->group(function () {
        Route::resource('barang', BarangController::class);
        Route::resource('siswa', SiswaController::class);

        Route::resource('peminjaman', PeminjamanController::class)->except(['edit', 'update', 'show']);
        Route::patch('peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::patch('peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::patch('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
        Route::patch('laporan/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');
        Route::get('pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::patch('pengguna/{user}', [PenggunaController::class, 'update'])->name('pengguna.update');
    });
});