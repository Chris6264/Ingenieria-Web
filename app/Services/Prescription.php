<?php

namespace App\Services;

class Prescription
{
    private int $idPrescription;
    private string $description;

    public function __construct(int $idPrescription, string $description)
    {
        $this->idPrescription = $idPrescription;
        $this->description = $description;
    }

    public function getIdPrescription()
    {
        return $this->idPrescription;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setIdPrescription(int $idPrescription)
    {
        $this->idPrescription = $idPrescription;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }
}