<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartement;

class CamerController extends Controller
{
    public function lantai() {
        $lantai = Apartement::distinct()->select('lantai')->get();
        return $lantai;
    }

}
