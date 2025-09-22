<?php

namespace App\Repositories;

use App\Models\Operation;

class OperationRepository
{
    public function searchObject($option,$number){
        return Operation::where('option', $option)
                                ->where('number', $number)
                                ->first();
    }

    public function saveObject($option,$number,$result){
        return Operation::create([
            'option' => $option,
            'number' => $number,
            'result' => $result
        ]);
    }
}