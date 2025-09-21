<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CalculatorService;

class BdController extends Controller
{

    protected $calculatorService;

    // Inyectamos el servicio mediante el constructor
    public function __construct()
    {
        $this->calculatorService = new CalculatorService;
    }

    public function calculator_home(Request $request){
        $number = $request->input('number');
        $option = $request->input('option');
        $result = '';

        switch($option){
            case 'factorial':
                $result = $this->calculatorService->factorial($number);
                break;
            case 'fibonacci':
                $result = $this->calculatorService->fibonacci($number);
                break;
            case 'ackermann':
                $result = $this->calculatorService->ackermann(1, $number);
                break;
            default:
                $result = '';
        }
        return view('calculator.calculator', compact('result', 'option', 'number'));
    }
}