<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BdController;

// Route::get('/', [BdController::class, 'calculator_home']) -> name('calculator_home');

// Ruta principal que recibe los parámetros por POST
Route::post('/calculate', [BdController::class, 'calculator_home'])->name('calculator_home');

// Ruta para la página inicial (GET)
Route::get('/', function () {
    return view('calculator.calculator', [
        'result' => '',
        'option' => '',
        'number' => ''
    ]);
})->name('calculator_index');