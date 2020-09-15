<?php

namespace App\Http\Controllers;

use App\Apartement;
use App\Http\Resources\UnitResource;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function floor() {
        $lantai = Apartement::distinct()->select('lantai')->orderBy('lantai', 'asc')->get();
        return response()->json($lantai);
    }

    public function unit_per_floor($floor) {
        $unit_per_floor = UnitResource::collection(Apartement::where('lantai', $floor)->get());
        return response()->json($unit_per_floor);
    }

    public function all_unit() {
        $unit = UnitResource::collection(Apartement::orderBy('lantai', 'desc')->paginate(100));
        return response()->json($unit);
    }
}
