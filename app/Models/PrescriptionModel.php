<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionModel extends Model
{
    protected $table = 'prescriptions';
    protected $fillable = ['id_prescription', 'description'];
    public $timestamps = false;
}
