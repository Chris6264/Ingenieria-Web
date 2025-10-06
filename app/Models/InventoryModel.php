<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    protected $table = 'inventories';
    protected $fillable = ['id_medication', 'id_pharmacy', 'id_branch', 'max_stock', 'min_stock', 'current_stock'];
    public $timestamps = false;
}
