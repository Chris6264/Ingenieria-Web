<?php

namespace App\Services;

use App\Models\Operation;
use App\Repositories\OperationRepository;

class CalculatorService
{
    private $operationRepository;

    public function __construct(OperationRepository $operationRepository){
        $this->operationRepository = $operationRepository;
    }

    private function factorial($number)
    {
        if($number==0) return 1;
        return $number * $this->factorial($number-1);
    }

    private function fibonacci($number)
    {
        if($number == 0) return 0;
        if($number == 1) return 1;
        return $this->fibonacci($number-1) + $this->fibonacci($number-2);
    }

    private function ackermann($m, $n)
    {
        if($m==0) return $n+1;
        else if($m > 0 && $n == 0) return $this->ackermann($m-1, 1);
        else if($m > 0 && $n > 0) return $this->ackermann($m - 1, $this->ackermann($m, $n - 1));
    }

    public function processOperation($option, $number){
    
        $operation = $this->operationRepository->searchObject($option,$number);

        if($operation != null){
            return $operation;
        }

        $result = 0;
        switch($option){
            case 'factorial':
                $result = $this->factorial($number);
                break;
            case 'fibonacci':
                $result = $this->fibonacci($number);
                break;
            case 'ackermann':
                $result = $this->ackermann(1, $number);
                break;
            default:
                $result = 0;
        }

        $operation = $this->operationRepository->saveObject($option,$number,$result);
        return $operation;
    }
}