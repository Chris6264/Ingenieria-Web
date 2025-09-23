<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $fillable = ['option', 'number', 'result'];
    public $timestamps = false;
}
