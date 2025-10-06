<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyModel extends Model
{
    protected $table = 'pharmacies';
    protected $fillable = ['id_pharmacy', 'name'];
    public $timestamps = false;
}
