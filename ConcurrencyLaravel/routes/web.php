<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;

Route::get('/',[MedicineController::class,'medicine_home']) -> name('medicine_home');