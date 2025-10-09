<?php

namespace App\Services;

class Prescription
{
    private int $idPrescription;
    private array $medication;

    public function __construct(int $idPrescription, array $medication)
    {
        $this->idPrescription = $idPrescription;
        $this->medication = $medication;
    }

    public function getIdPrescription()
    {
        return $this->idPrescription;
    }

    public function getMedication()
    {
        return $this->medication;
    }

    public function setIdPrescription(int $idPrescription)
    {
        $this->idPrescription = $idPrescription;
    }

    public function setMedication(array $medication)
    {
        $this->medication = $medication;
    }
}