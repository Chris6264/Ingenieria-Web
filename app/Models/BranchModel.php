<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchModel extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id_branch';
    protected $fillable = ['id_branch', 'name', 'id_pharmacy'];
    public $timestamps = false;

    public function medications()
    {
        return $this->belongsToMany(
            MedicationModel::class,
            'inventories',
            'id_medication',
            'id_branch'
        )->withPivot('current_stock', 'min_stock', 'max_stock');
    }
}
