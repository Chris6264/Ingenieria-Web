<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function medicine_home()
    {
        return view('Medicine.medicine_view');
    }
}