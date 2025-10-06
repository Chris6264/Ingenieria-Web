<?php

namespace App\Services;

class Prescription
{
    private ?int $idPrescription;
    private string $description;

    public function __construct(?int $idPrescription = null, string $description = '')
    {
        $this->idPrescription = $idPrescription;
        $this->description = $description;
    }

    public function getIdPrescription(): ?int
    {
        return $this->idPrescription;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setIdPrescription(?int $idPrescription): void
    {
        $this->idPrescription = $idPrescription;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}