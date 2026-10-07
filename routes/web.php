<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AsetAdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookletController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\UserListController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\KatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KatalogController::class, 'landing'])->name('landing');

// ---------- Autentikasi ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'pilihDaftar'])->name('register.pilih');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register-admin', [AuthController::class, 'showRegisterAdmin'])->name('register.admin');
    Route::post('/register-admin', [AuthController::class, 'registerAdmin']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- Area User ----------
Route::middleware('auth')->group(function () {
    Route::get('/selamat-datang', [AuthController::class, 'showWelcome'])->name('welcome');
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::get('/katalog/{aset}', [KatalogController::class, 'show'])->name('katalog.show');
    Route::post('/katalog/{aset}/like', [KatalogController::class, 'toggleLike'])->name('katalog.like');
    Route::get('/favorit', [KatalogController::class, 'favorit'])->name('katalog.favorit');
});

// ---------- Area Admin ----------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/aset/create', [AsetAdminController::class, 'create'])->name('aset.create');
    Route::post('/aset', [AsetAdminController::class, 'store'])->name('aset.store');
    Route::get('/aset/{aset}/edit', [AsetAdminController::class, 'edit'])->name('aset.edit');
    Route::put('/aset/{aset}', [AsetAdminController::class, 'update'])->name('aset.update');
    Route::delete('/aset/{aset}', [AsetAdminController::class, 'destroy'])->name('aset.destroy');

    Route::get('/master-data', [MasterDataController::class, 'index'])->name('master.index');
    Route::get('/master-data/create', [MasterDataController::class, 'create'])->name('master.create');
    Route::post('/master-data', [MasterDataController::class, 'store'])->name('master.store');
    Route::get('/master-data/export-zip', [MasterDataController::class, 'exportZip'])->name('master.export');
    Route::get('/master-data/{debitur}', [MasterDataController::class, 'show'])->name('master.show');
    Route::get('/master-data/{debitur}/edit', [MasterDataController::class, 'edit'])->name('master.edit');
    Route::put('/master-data/{debitur}', [MasterDataController::class, 'update'])->name('master.update');
    Route::delete('/master-data/{debitur}', [MasterDataController::class, 'destroy'])->name('master.destroy');

    Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
    Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');
    Route::post('/banner/{banner}/toggle', [BannerController::class, 'toggle'])->name('banner.toggle');
    Route::delete('/banner/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy');

    Route::get('/booklet', [BookletController::class, 'index'])->name('booklet.index');
    Route::get('/booklet/{aset}', [BookletController::class, 'show'])->name('booklet.show');

    Route::get('/admin-akun', [AdminManagementController::class, 'index'])->name('admin.index');
    Route::get('/admin-akun/create', [AdminManagementController::class, 'create'])->name('admin.create');
    Route::post('/admin-akun', [AdminManagementController::class, 'store'])->name('admin.store');
    Route::get('/admin-akun/{admin}/edit', [AdminManagementController::class, 'edit'])->name('admin.edit');
    Route::put('/admin-akun/{admin}', [AdminManagementController::class, 'update'])->name('admin.update');
    Route::delete('/admin-akun/{admin}', [AdminManagementController::class, 'destroy'])->name('admin.destroy');

    Route::get('/pengguna', [UserListController::class, 'index'])->name('user.index');
    Route::delete('/pengguna/{user}', [UserListController::class, 'destroy'])->name('user.destroy');

    Route::get('/kalkulator', [KatalogController::class, 'kalkulator'])->name('kalkulator');
});