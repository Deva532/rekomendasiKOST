<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RekomendasiController;

Route::view('/', 'landing')->name('landing');
Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('home');
Route::post('/proses', [RekomendasiController::class, 'proses'])->name('proses');
Route::get('/rekomendasi/proses-perhitungan', [RekomendasiController::class, 'prosesPerhitungan'])->name('rekomendasi.proses-perhitungan');
Route::get('/rekomendasi/detail/{id}', [RekomendasiController::class, 'detailPerhitungan'])->name('rekomendasi.detail');

