<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;

Route::get('/',[MedicineController::class,'medicine_home']) -> name('medicine_home');
Route::get('/stock', [MedicineController::class, 'medicine_getStock']) -> name('medicine_getStock');
Route::get('/branch', [MedicineController::class, 'medicine_getBranch']) -> name('medicine_getBranch');
Route::post('/process-prescription', [MedicineController::class, 'medicine_process'])->name('medicine_process');


