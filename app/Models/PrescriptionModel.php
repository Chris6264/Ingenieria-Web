<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionModel extends Model
{
    protected $table = 'prescriptions';

    protected $primaryKey = 'id_prescription';

    protected $fillable = ['medication'];

    protected $casts = ['medication' => 'array'];

    public $timestamps = false;
}
