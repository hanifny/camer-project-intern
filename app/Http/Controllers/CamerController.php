<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartement;
use App\Http\Resources\UnitCollection;

class CamerController extends Controller
{
    public function camer() {
        return 'OK';
    }

    public function floor() {
        $lantai = Apartement::distinct()->select('lantai')->orderBy('lantai', 'asc')->get();
        return response()->json($lantai);
    }

    public function all_unit() {
        return new UnitCollection(Apartement::orderBy('lantai', 'asc')->paginate(5));
    }

    public function unit_per_floor($floor) {
        $unit_per_floor = new UnitCollection(Apartement::where('lantai', $floor)->get());
        return response()->json($unit_per_floor);
    }
}
