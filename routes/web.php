<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SimulasiController;
use App\Http\Controllers\PerbandinganController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TentangController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/materi', [MateriController::class, 'index'])->name('materi');
Route::get('/simulasi', [SimulasiController::class, 'index'])->name('simulasi');
Route::post('/simulasi', [SimulasiController::class, 'calculate'])->name('simulasi.calculate');
Route::get('/perbandingan', [PerbandinganController::class, 'index'])->name('perbandingan');
Route::post('/perbandingan', [PerbandinganController::class, 'calculate'])->name('perbandingan.calculate');
Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');

Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');
