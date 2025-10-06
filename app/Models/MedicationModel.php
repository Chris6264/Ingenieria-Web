<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicationModel extends Model
{
    protected $table = 'medications';
    protected $fillable = ['id_medication', 'name', 'specification', 'laboratory'];
    public $timestamps = false;

    public function branches()
    {
        return $this->belongsToMany(
            BranchModel::class,
            'inventories',
            'id_medication',
            'id_branch'
        )->withPivot('current_stock', 'min_stock', 'max_stock');
    }
}