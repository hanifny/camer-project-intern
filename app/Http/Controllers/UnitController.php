<?php

namespace App\Http\Controllers;

use App\Apartement;
use App\Http\Resources\UnitCamerResource;
use App\Type;
use App\Http\Resources\UnitResource;
use App\Meter;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function tower(Request $request) {
        if ($request->tower === "T") {
            $unit = Apartement::where('unit', 'like', 'T%')->orderBy('unit', 'asc')->paginate(100);
        } elseif ($request->tower === "U") {
            $unit = Apartement::where('unit', 'like', 'U%')->orderBy('unit', 'asc')->paginate(100);
        } 
        return UnitResource::collection($unit)->response()->getData(true);
    }

    public function invalid(Request $request) {
        $allInvalid = UnitCamerResource::collection(Meter::where('validasi', 2)->get());
        return response()->json($allInvalid);
    }

    public function store(Request $request) {
        $new_unit = Apartement::create([
            'unit' => $request->unit,
            'tipe_id' => $request->tipe_id,
            'lantai' => $request->lantai,
        ]);
        return response()->json($new_unit);
    }

    public function destroy(Request $request) {
        $unit = Apartement::find($request->id)->delete();
        return $unit;
    }

    public function update(Request $request) {
        $unit = Apartement::find($request->id);
        $new_unit = $unit->update([
            'unit' => $request->unit,
            'lantai' => $request->lantai,
        ]);
        if($request->tipe_id) {
            $new_unit = $unit->update([
                'tipe_id' => $request->tipe_id,
            ]);
        }
        return response()->json($new_unit);
    }

    public function floor() {
        $lantai = Apartement::distinct()->select('lantai')->orderBy('lantai', 'asc')->get();
        return response()->json($lantai);
    }

    public function unitName_per_floor($id) {
        $unit_per_floor = UnitResource::collection(Apartement::where('lantai', $id)->get());
        return response()->json($unit_per_floor);
    }

    public function unit_per_floor($id) {
        $unit_per_floor = Apartement::where('lantai', $id)->get();
        return UnitResource::collection($unit_per_floor)->response()->getData(true);
    }

    public function all_unit() {
        $unit = Apartement::orderBy('lantai', 'asc')->paginate(100);
        return UnitResource::collection($unit)->response()->getData(true);
    }

    public function all_type() {
        $tipe = Type::orderBy('tipe', 'asc')->get();
        return response()->json($tipe);
    }
}