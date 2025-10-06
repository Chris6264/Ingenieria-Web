<?php

namespace App\Services;

use App\Repositories\MedicineRepository;

class MedicineService
{
    protected $medicineRepository;

    public function __construct(MedicineRepository $medicineRepository)
    {
        $this->medicineRepository = $medicineRepository;
    }

    public function getBranchInfo(string $pharmacyName, string $branchName)
    {
        $branch = $this->medicineRepository->findBranchByNameAndPharmacyName($branchName, $pharmacyName);
        if (!$branch) {
            return null;
        }

        return $branch;
    }

    public function getStock(string $medicationName, string $num, string $farm): int
    {
        return $this->medicineRepository->getStockByNameAndBranch($medicationName, $num, $farm);
    }

    public function processPrescription($pharmacyName, $branchId, $branchFarm, $branchName, $medications)
    {
        if (empty($medications)) {
            return ['success' => false, 'message' => 'No hay medicamentos en la receta'];
        }

        $this->medicineRepository->beginTransaction();

        $ID = $this->medicineRepository->lastPrescriptionID() + 1;
        $result = $this->medicineRepository->newPrescription($ID);

        $prescription = new Prescription( 
            $result -> id_prescription,
            $result -> description
        );

        foreach ($medications as $index => $med) {
            $name = $med['name'];
            $quantity = $med['units'];
        
            $stock = $this->medicineRepository->getStock(
                $name,
                $branchId,
                $branchFarm
            );
        
            if ($stock === null) {
                $this->medicineRepository->rollbackTransaction();
                return [
                    'success' => false,
                    'message' => "Medicamento {$name} no encontrado en inventario"
                ];
            }
            if ($stock < $quantity) {
                $this->medicineRepository->rollbackTransaction();
                return [
                    'success' => false,
                    'message' => "Stock insuficiente para {$name}. Disponible: {$stock}, Solicitado: {$quantity}"
                ];
            }
            
            $newStock = $stock - $quantity;
            $updated = $this->medicineRepository->updateStock(
                $name,
                $branchId,
                $branchFarm,
                $newStock
            );
            
            if (!$updated) {
                $this->medicineRepository->rollbackTransaction();
                return [
                    'success' => false,
                    'message' => "Error al actualizar stock de {$name}"
            
                ];
            }
            $med = $this->medicineRepository->findMedicationByName($name);
            $idMed = $med->id_medication;
            $this->medicineRepository->savePrescriptionsMedications($ID, $idMed);
        }
        
        $this->medicineRepository->commitTransaction();

        return $prescription;
    }
}