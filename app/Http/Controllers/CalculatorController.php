<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;
use App\Services\CalculatorService;

class CalculatorController extends Controller
{

    private $calculatorService;

    // Inyectamos el servicio mediante el constructor
    public function __construct()
    {
        $this->calculatorService = new CalculatorService;
    }

    public function calculator_home(){
        return view('calculator.calculator', [
                'result' => '',
                'option' => '',
                'number' => ''
            ]);
    }

    public function calculator_process(Request $request){
        $option = $request->input('option');
        $number = $request->input('number');
        $operation = new Operation();
        
        if($option != 'limpiar'){
            $operation = $this->calculatorService->operacion($option, $number);
        } else {
            $number = '0';
            $result = '';
        }
        
        return view('calculator.calculator', compact('operation'));
    }
}