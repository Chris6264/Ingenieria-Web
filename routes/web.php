<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;

Route::get('/', [CalculatorController::class, 'calculator_home'])->name('calculator_home');

Route::post('/', [CalculatorController::class, 'calculator_process'])->name('calculator_process');
