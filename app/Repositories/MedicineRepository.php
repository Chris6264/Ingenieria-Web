<?php

namespace App\Repositories;

use App\Models\MedicationModel;
use App\Models\BranchModel;
use App\Models\PrescriptionMedicationModel;
use App\Models\PrescriptionModel;
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

    public function savePrescription($medication){
        return PrescriptionModel::create([
            'medication' => $medication,
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

    public function getInventory(string $medicationName, string $idBranch, string $idPharmacy)
    {
        try {
            $medication = $this->findMedicationByName($medicationName);
            if (!$medication) {
                return null;
            }

            $inventory = DB::table('inventories')
            ->where('id_pharmacy', $idPharmacy)
            ->where('id_branch', $idBranch)
            ->where('id_medication', $medication->id_medication)
            ->lockForUpdate()
                ->first();
            
            if (!$inventory) {
                return null;
            }
            
            return $inventory;

        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function updateStock(string $name, string $idBranch, string $idPharmacy, int $newStock)
{
    $maxRetries = 3;

    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            $medication = $this->findMedicationByName($name);
            if (!$medication) {
                return false;
            }

            $updated = DB::table('inventories')
                ->where('id_pharmacy', $idPharmacy)
                ->where('id_branch', $idBranch)
                ->where('id_medication', $medication->id_medication)
                ->update(['current_stock' => $newStock]);

            return $updated > 0;
        } catch (QueryException $e) {
            if (str_contains(strtolower($e->getMessage()), 'deadlock')) {
                usleep(200000);
                continue;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
    return false;
    }
}