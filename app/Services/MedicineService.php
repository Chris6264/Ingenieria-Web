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

    public function getStock(string $medicationName, string $idBranch, string $idPharmacy): int
    {
        return $this->medicineRepository->getStock($medicationName, $idBranch, $idPharmacy);
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

            $inventory = $this->medicineRepository->getInventory(
                $name,
                $branchId,
                $branchFarm
            );

            if (!$inventory) {
                $this->medicineRepository->rollbackTransaction();
                return [
                    'success' => false,
                    'message' => "Inventario no encontrado para el medicamento {$name}."
                ];
            }

            $inventoryObject = new Inventory(
                    $inventory->id_medication,
                    $name,
                    $inventory->id_branch,
                    $inventory->id_pharmacy,
                    $inventory->current_stock
            );

            $stock = $inventoryObject->getCurrentStock();
        
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
                    'message' => "Stock insuficiente para {$name}. Disponible: {$inventoryObject->getCurrentStock()}, Solicitado: {$quantity}"
                ];
            }
            
            $inventoryObject->setCurrentStock($stock - $quantity);

            $updated = $this->medicineRepository->updateStock(
                $inventoryObject->getMedicationName(),
                $inventoryObject->getIdBranch(),
                $inventoryObject->getIdPharmacy(),
                $inventoryObject->getCurrentStock()
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