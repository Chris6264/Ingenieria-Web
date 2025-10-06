<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionMedicationModel extends Model
{
    protected $table = 'prescriptions_medications';
    
    protected $primaryKey = 'id';
    
    protected $fillable = ['id_prescription', 'id_medication'];
    
    public $timestamps = false;

    public function prescription()
    {
        return $this->belongsTo(PrescriptionModel::class, 'id_prescription', 'id_prescription');
    }

    public function medication()
    {
        return $this->belongsTo(MedicationModel::class, 'id_medication', 'id_medication');
    }
}