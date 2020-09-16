<?php

namespace App\Http\Controllers;

use App\Apartement;
use App\Type;
use App\Http\Resources\UnitResource;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function store(Request $request) {
        $new_unit = Apartement::create([
            'unit' => $request->unit,
            'tipe_id' => $request->tipe_id,
            'lantai' => $request->lantai,
        ]);
        return response()->json($new_unit);
    }

    public function floor() {
        $lantai = Apartement::distinct()->select('lantai')->orderBy('lantai', 'asc')->get();
        return response()->json($lantai);
    }

    public function unit_per_floor($id) {
        $unit_per_floor = UnitResource::collection(Apartement::where('lantai', $id)->get());
        return response()->json($unit_per_floor);
    }

    public function all_unit() {
        $unit = UnitResource::collection(Apartement::orderBy('lantai', 'asc')->paginate(100));
        return response()->json($unit);
    }

    public function all_type() {
        $tipe = Type::orderBy('tipe', 'asc')->get();
        return response()->json($tipe);
    }
}
