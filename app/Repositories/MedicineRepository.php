<?php

namespace App\Repositories;

use App\Models\MedicationModel;
use App\Models\BranchModel;
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

    public function lastPrescriptionID(){
        try {
            return PrescriptionModel::max('id_prescription');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Error interno'], 500);
        }
    }

    public function newPrescription($id){
        return PrescriptionModel::create([
            'id_prescription' => $id,
            'description' => "Receta " . $id,
        ]);
    }

    public function savePrescriptionsMedications($idPrescription, $idMedication){
        PrescriptionMedicationModel::create([
            'id_prescription' => $idPrescription,
            'id_medication' => $idMedication
        ]);
    }

    public function findMedicationByName(string $medicationName)
    {
        return MedicationModel::where('name', $medicationName)->first();
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

    public function getStock(string $mediactionName, string $idBranch, string $idPharmacy)
    {
        try {
            $medication = $this->findMedicationByName($mediactionName);
            if (!$medication) {
                Log::warning("Medicamento no encontrado", ['name' => $mediactionName]);
                return null;
            }

            $inventory = DB::table('inventories')
                ->where('id_medication', $medication->id_medication)
                ->where('id_branch', $idBranch)
                ->where('id_pharmacy', $idPharmacy)
                ->first();

            if (!$inventory) {
                Log::warning("Inventario no encontrado", [
                    'medication' => $mediactionName,
                    'id_branch' => $idBranch,
                    'id_pharmacy' => $idPharmacy
                ]);
                return null;
            }

            return (int) $inventory->current_stock;
        }
        catch (\Exception $e) {
            return 0;            
        }
    }

    public function updateStock(string $name, string $idBranch, string $idPharmacy, int $newStock)
{
    $maxRetries = 3;

    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            $medication = $this->findMedicationByName($name);
            if (!$medication) {
                Log::warning("Medicamento no encontrado para actualizar", ['name' => $name]);
                return false;
            }

            $updated = DB::table('inventories')
                ->where('id_medication', $medication->id_medication)
                ->where('id_branch', $idBranch)
                ->where('id_pharmacy', $idPharmacy)
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