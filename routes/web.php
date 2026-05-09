<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RmaController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\ActivityLogController;

// Dashboard
Route::get('/', [AssetController::class, 'dashboard'])->name('dashboard');

// Master Asset
Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
Route::put('/assets/{id}', [AssetController::class, 'update'])->name('assets.update');
Route::delete('/assets/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');

// Transaksi Masuk — Jalur Barang Retur
Route::get('/rma/create', [RmaController::class, 'create'])->name('rma.create');
Route::post('/rma/store', [RmaController::class, 'store'])->name('rma.store');
Route::get('/rma/generate/{assetId}', [RmaController::class, 'generateForm'])->name('rma.generate.form');
Route::post('/rma/generate/{assetId}', [RmaController::class, 'generatePdf'])->name('rma.generate.pdf');

// Transaksi Masuk — Jalur Barang Baru dari Pusat
Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang_masuk.create');
Route::post('/barang-masuk/store', [BarangMasukController::class, 'store'])->name('barang_masuk.store');

// Sistem Paket (Bundle)
Route::get('/bundle', [BundleController::class, 'index'])->name('bundle.index');
Route::get('/bundle/create', [BundleController::class, 'create'])->name('bundle.create');
Route::post('/bundle/store', [BundleController::class, 'store'])->name('bundle.store');
Route::delete('/bundle/{id}', [BundleController::class, 'destroy'])->name('bundle.destroy');

// Transaksi Keluar — Generate BSTP dari Paket
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/pdf/{id}', [TransactionController::class, 'downloadPDF'])->name('transactions.pdf');

// Log Activity
Route::get('/log-activity', [ActivityLogController::class, 'index'])->name('activity_log.index');
