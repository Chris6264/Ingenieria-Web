<?php

namespace App\Services;

class Inventory{
    private $idMedication;
    private $medicationName;
    private $idBranch;
    private $idPharmacy;
    private $currentStock;

    public function __construct($idMedication, $medicationName, $idBranch, $idPharmacy, $currentStock) {
        $this->idMedication = $idMedication;
        $this->medicationName = $medicationName;
        $this->idBranch = $idBranch;
        $this->idPharmacy = $idPharmacy;
        $this->currentStock = $currentStock;
    }

    public function getIdMedication() {
        return $this->idMedication;
    }

    public function getMedicationName() {
        return $this->medicationName;
    }

    public function getIdBranch() {
        return $this->idBranch;
    }

    public function getIdPharmacy() {
        return $this->idPharmacy;
    }

    public function getCurrentStock() {
        return $this->currentStock;
    }

    public function setIdMedication($idMedication) {
        $this->idMedication = $idMedication;
    }

    public function setMedicationName($medicationName) {
        $this->medicationName = $medicationName;
    }

    public function setIdBranch($idBranch) {
        $this->idBranch = $idBranch;
    }

    public function setIdPharmacy($idPharmacy) {
        $this->idPharmacy = $idPharmacy;
    }

    public function setCurrentStock($currentStock) {
        $this->currentStock = $currentStock;
    }

}