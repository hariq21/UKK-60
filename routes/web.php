<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SiswaController;

// Landing Page
Route::get('/', function () { return view('landing'); });

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'profileShow'])->name('admin.profile');
    Route::patch('/admin/profile', [AdminController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::patch('/admin/kategori/{kategori}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::get('/admin/siswa', [AdminController::class, 'siswaCreate'])->name('admin.siswa.create');
    Route::post('/admin/siswa', [AdminController::class, 'siswaStore'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{siswa}', [AdminController::class, 'siswaShow'])->name('admin.siswa.show');
    Route::patch('/admin/siswa/{siswa}', [AdminController::class, 'siswaUpdate'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{siswa}', [AdminController::class, 'siswaDestroy'])->name('admin.siswa.destroy');
    Route::get('/admin/pengaduan', [PengaduanController::class, 'adminIndex'])->name('admin.pengaduan.index');
    Route::get('/admin/pengaduan/{pengaduan}', [PengaduanController::class, 'adminShow'])->name('admin.pengaduan.show');
    Route::patch('/admin/pengaduan/{pengaduan}', [PengaduanController::class, 'adminUpdate'])->name('admin.pengaduan.update');
    Route::delete('/admin/pengaduan/{pengaduan}', [PengaduanController::class, 'adminDestroy'])->name('admin.pengaduan.destroy');
});

// Area Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/siswa/profile', function () { return view('siswa.profile.index'); })->name('siswa.profile');
    Route::get('/siswa/pengaduan', [PengaduanController::class, 'siswaIndex'])->name('siswa.pengaduan.index');
    Route::get('/siswa/pengaduan/create', [PengaduanController::class, 'siswaCreate'])->name('siswa.pengaduan.create');
    Route::get('/siswa/pengaduan/{pengaduan}', [PengaduanController::class, 'siswaShow'])->name('siswa.pengaduan.show');
    Route::post('/siswa/pengaduan', [PengaduanController::class, 'siswaStore'])->name('siswa.pengaduan.store');
    Route::delete('/siswa/pengaduan/{pengaduan}', [PengaduanController::class, 'siswaDestroy'])->name('siswa.pengaduan.destroy');
});
