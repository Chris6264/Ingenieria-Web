<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MedicineService;
use App\Services\Inventory;

class MedicineController extends Controller
{
    protected $medicineService;

    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    public function medicine_home()
    {
        return view('Medicine.medicine_view');
    }

    public function medicine_getBranch(Request $request)
    {
        $pharmacy = $request->query('pharmacy');
        $branch   = $request->query('branch');

        if (!$pharmacy || !$branch) {
            return response()->json(['error' => 'Pharmacy y branch son obligatorios'], 400);
        }

        $branchData = $this->medicineService->getBranchInfo($pharmacy, $branch);

        if (!$branchData) {
            return response()->json(['error' => 'sucursal no encontrada'], 404);
        }

        return response()->json([
            'branchNum'  => $branchData->id_branch,
            'branchFarm' => $branchData->id_pharmacy
        ]);
    }

    public function medicine_getInventory(Request $request)
{
    $medicationName = $request->query('medication');
    $branchNum = $request->query('branch_num');
    $branchFarm = $request->query('branch_farm');

    $inventory = $this->medicineService->getInventory($medicationName, $branchNum, $branchFarm);

    if ($request->ajax()) {
        return response()->json([
            'stock' => $inventory ? $inventory->getCurrentStock() : 0
        ]);
    }
}

    public function medicine_process(Request $request)
    {
        $pharmacyName = $request->input('pharmacy');
        $branchId = $request->input('branchId');
        $idBranchFarm = $request->input('branchFarm');
        $branchName = $request->input('branch');
        $medicationsCount = $request->input('medications_count', 0);

        $medications = [];
        for ($i = 0; $i < $medicationsCount; $i++) {
            $medName = $request->input("medication_{$i}");
            $units = $request->input("units_{$i}");

            if ($medName && $units) {
                $medications[] = [
                    'name' => $medName,
                    'units' => (int) $units
                ];
            }
        }

        $prescription = $this->medicineService->processPrescription(
            $pharmacyName,
            $branchId,
            $idBranchFarm,
            $branchName,
            $medications
        );

        if (!$prescription instanceof \App\Services\Prescription) {
            return view('Medicine.result', [
                'result' => ['success' => false, 'message' => 'Error al procesar receta.'],
                'pharmacyName' => $pharmacyName,
                'branchName' => $branchName,
                'branchId' => $branchId,
                'branchFarm' => $idBranchFarm,
                'medications' => $medications
            ]);
        }

        return view('Medicine.result', [
            'prescription' => $prescription,
            'pharmacyName' => $pharmacyName,
            'branchName' => $branchName,
            'branchId' => $branchId,
            'branchFarm' => $idBranchFarm,
            'medications' => $medications,
            'result' => ['success' => true, 'message' => 'Receta procesada correctamente.']
        ]);
    }
}
