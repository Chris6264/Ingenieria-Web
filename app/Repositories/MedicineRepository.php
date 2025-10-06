<?php

namespace App\Repositories;

use App\Models\MedicationModel;
use App\Models\BranchModel;
use App\Models\InventoryModel;
use App\Models\PrescriptionMedicationModel;
use App\Models\PrescriptionModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class MedicineRepository
{
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    public function commitTransaction()
    {
        DB::commit();
    }

    public function rollbackTransaction()
    {
        DB::rollBack();
    }

    public function findByName(string $name)
    {
        return MedicationModel::where('name', $name)->first();
    }

    public function lastPrescriptionID(){
        try {
            return PrescriptionModel::max('id_prescription');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Error interno'], 500);
        }
    }

    public function newPrescription($ID){
        return PrescriptionModel::create([
            'id_prescription' => $ID,
            'description' => "Receta " . $ID,
        ]);
    }

    public function savePrescriptionsMedications($IDPrescription, $IDMedication){
        PrescriptionMedicationModel::create([
            'id_prescription' => $IDPrescription,
            'id_medication' => $IDMedication
        ]);
    }

    public function findMedicationByName(string $name)
    {
        return MedicationModel::where('name', $name)->first();
    }

    public function findBranchByNameAndPharmacyName(string $branchName, string $pharmacyName)
    {
        try {
            return BranchModel::select('branches.id_branch', 'branches.id_pharmacy')
                ->join('pharmacies', 'branches.id_pharmacy', '=', 'pharmacies.id_pharmacy')
                ->where('branches.name', $branchName)
                ->where('pharmacies.name', $pharmacyName)
                ->first();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Error interno'], 500);
        }
    }

    public function getStockByNameAndBranch(string $name, string $num, string $farm)
    {
        try {
            $medication = $this->findMedicationByName($name);
            if (!$medication) {
                Log::info("No se encontró medicamento", ['name' => $name]);
                return 0;
            }
        

            $stock = InventoryModel::where('id_medication', $medication->id_medication)
                ->where('id_branch', $num)
                ->where('id_pharmacy', $farm)
                ->sum('current_stock');

            Log::info("Stock consultado", [
                'medication' => $name,
                'id_branch' => $num,
                'id_pharmacy' => $farm,
                'stock' => $stock
            ]);

            return (int) $stock;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getStock(string $name, string $num, string $farm)
    {
        try {
            $medication = $this->findMedicationByName($name);
            if (!$medication) {
                Log::warning("Medicamento no encontrado", ['name' => $name]);
                return null;
            }

            $inventory = DB::table('inventories')
                ->where('id_medication', $medication->id_medication)
                ->where('id_branch', $num)
                ->where('id_pharmacy', $farm)
                ->first();

            if (!$inventory) {
                Log::warning("Inventario no encontrado", [
                    'medication' => $name,
                    'id_branch' => $num,
                    'id_pharmacy' => $farm
                ]);
                return null;
            }

            return (int) $inventory->current_stock;
        }
        catch (\Exception $e) {
            return 0;            
        }
    }

    public function updateStock(string $name, string $num, string $farm, int $newStock)
{
    $maxRetries = 3;

    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            $medication = $this->findByName($name);
            if (!$medication) {
                Log::warning("Medicamento no encontrado para actualizar", ['name' => $name]);
                return false;
            }

            $updated = DB::table('inventories')
                ->where('id_medication', $medication->id_medication)
                ->where('id_branch', $num)
                ->where('id_pharmacy', $farm)
                ->lockForUpdate()
                ->update(['current_stock' => $newStock]);

            Log::info("Stock actualizado", [
                'medication' => $name,
                'new_stock' => $newStock,
                'rows_affected' => $updated
            ]);

            return $updated > 0;
        } catch (QueryException $e) {
            if (str_contains(strtolower($e->getMessage()), 'deadlock')) {
                Log::warning("Deadlock detectado, reintentando ($i)");
                usleep(200000);
                continue;
            }
            Log::error("Error SQL al actualizar stock: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error("Error al actualizar stock: " . $e->getMessage());
            return false;
        }
    }
    Log::error("Error: máximo de reintentos alcanzado al actualizar stock");
    return false;
    }
}