<?php

namespace App\Services;

class CalculatorService
{
    public function factorial($number)
    {
        if($number==0) return 1;
        return $number * $this->factorial($number-1);
    }

    public function fibonacci($number)
    {
        if($number == 0) return 0;
        if($number == 1) return 1;
        return $this->fibonacci($number-1) + $this->fibonacci($number-2);
    }

    public function ackermann($m, $n)
    {
        if($m==0) return $n+1;
        else if($m > 0 && $n == 0) return $this->ackermann($m-1, 1);
        else if($m > 0 && $n > 0) return $this->ackermann($m - 1, $this->ackermann($m, $n - 1));
        return 0;
    }
}