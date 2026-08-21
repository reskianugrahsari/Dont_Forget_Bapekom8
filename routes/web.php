<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PengajuanController::class, 'index'])->name('pengajuan.index');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
