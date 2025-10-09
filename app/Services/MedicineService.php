<?php

namespace App\Services;

use App\Repositories\MedicineRepository;

class MedicineService
{
    private $medicineRepository;

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

    public function getInventory($medicationName, $branchNum, $branchFarm)
    {
        $inventory = $this->medicineRepository->getInventory($medicationName, $branchNum, $branchFarm);

        if ($inventory) {
            $inventoryObject = new Inventory(
                $inventory->id_medication,
                $medicationName,
                $inventory->id_branch,
                $inventory->id_pharmacy,
                $inventory->current_stock
            );
        } else {
            $inventoryObject = null;
        }
        return $inventoryObject;
    }


    public function processPrescription($pharmacyName, $branchId, $branchFarm, $branchName, $medications)
    {
        if (empty($medications)) {
            return ['success' => false, 'message' => 'No hay medicamentos en la receta'];
        }

        $this->medicineRepository->beginTransaction();
        $prescriptionObj = $this->medicineRepository->savePrescription($medications);
        $id = $prescriptionObj->id_prescription;
        $prescription = new Prescription($prescriptionObj->id_prescription, $medications);

        foreach ($medications as $med) {
            $name = $med['name'];
            $quantity = $med['units'];

            $inventory = $this->medicineRepository->getInventory($name, $branchId, $branchFarm);

            if (!$inventory) {
                $this->medicineRepository->rollbackTransaction();
                return ['success' => false, 'message' => "Inventario no encontrado para {$name}"];
            }

            $inventoryObject = new Inventory(
                $inventory->id_medication,
                $name,
                $inventory->id_branch,
                $inventory->id_pharmacy,
                $inventory->current_stock
            );

            $stock = $inventoryObject->getCurrentStock();

            if ($stock < $quantity) {
                $this->medicineRepository->rollbackTransaction();
                return ['success' => false, 'message' => "Stock insuficiente para {$name}. Disponible: {$stock}, Solicitado: {$quantity}"];
            }

            $newStock = $stock - $quantity;

            $inventoryObject->setCurrentStock($newStock);

            $updated = $this->medicineRepository->updateStock(
                $inventoryObject->getMedicationName(),
                $inventoryObject->getIdBranch(),
                $inventoryObject->getIdPharmacy(),
                $inventoryObject->getCurrentStock()
            );

            if (!$updated) {
                $this->medicineRepository->rollbackTransaction();
                return ['success' => false, 'message' => "Error al actualizar stock de {$name}"];
            }

            $medObj = $this->medicineRepository->findMedicationByName($name);
            $this->medicineRepository->savePrescriptionsMedications($id, $medObj->id_medication);
        }

        $this->medicineRepository->commitTransaction();
        return $prescription;
    }
}
