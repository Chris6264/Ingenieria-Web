<?php

namespace App\Repositories;

use App\Models\OperationModel;
use Illuminate\Support\Facades\Log;
use Exception;

class OperationRepository
{
    public function searchObject($option, $number)
    {
        try {
            return OperationModel::where('option', $option)
                ->where('number', $number)
                ->first();
        } catch (Exception $e) {
            Log::error("Error searching Operation: " . $e->getMessage(), [
                'option' => $option,
                'number' => $number
            ]);
            return null;
        }
    }

    public function saveObject($option, $number, $result)
    {
        try {
            return OperationModel::create([
                'option' => $option,
                'number' => $number,
                'result' => $result
            ]);
        } catch (Exception $e) {
            Log::error("Error saving Operation: " . $e->getMessage(), [
                'option' => $option,
                'number' => $number,
                'result' => $result
            ]);
            return null;
        }
    }
}
