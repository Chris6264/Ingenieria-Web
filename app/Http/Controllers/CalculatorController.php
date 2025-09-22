<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\Services\CalculatorService;

class CalculatorController extends Controller
{

    private $calculatorService;

    public function __construct(CalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    public function calculator_home(){
        return view('calculator.calculator_view');
    }

    public function calculator_process(Request $request)
    {
        $option = $request->input('option');
        $number = $request->input('number');

        $operation = null;

        if ($option !== 'limpiar' && $number !== null) {
            $operation = $this->calculatorService->processOperation($option, $number);
        }

        return view('calculator.calculator_view', compact('operation'));
}

}