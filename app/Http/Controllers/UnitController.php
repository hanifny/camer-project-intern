<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Type;
use App\Http\Resources\UnitResource;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function tower(Request $request) {
        $unit = Unit::where('unit_code', 'like', $request->tower.'%')->orderBy('unit_code', 'asc')->paginate(100);
        return UnitResource::collection($unit)->response()->getData(true);
    }

    public function store(Request $request) {
        $new_unit = Unit::create([
            'unit_code' => $request->unit,
            'unit_type' => $request->tipe,
            'floor' => $request->lantai,
        ]);
        return response()->json($new_unit);
    }

    public function destroy(Request $request) {
        $unit = Unit::find($request->id)->delete();
        return $unit;
    }

    public function update(Request $request) {
        $unit = Unit::find($request->id);
        $new_unit = $unit->update([
            'unit_code' => $request->unit,
            'floor' => $request->lantai,
        ]);
        if($request->tipe) {
            $new_unit = $unit->update([
                'unit_type' => $request->tipe,
            ]);
        }
        return response()->json($new_unit);
    }

    public function unit_per_floor($floor) {
        $unit_per_floor = Unit::where('floor', $floor)->get();
        return UnitResource::collection($unit_per_floor)->response()->getData(true);
    }

    public function all_unit() {
        $unit = Unit::orderByRaw('floor asc, unit_code asc')->paginate(100);
        return UnitResource::collection($unit)->response()->getData(true);
    }

    // public function all_type() {
    //     $tipe = Type::orderBy('tipe', 'asc')->get();
    //     return response()->json($tipe);
    // }

    // APP
    // ANDROID
    public function floorByTower($tower) {
        $lantai = Unit::distinct()->select('floor')->where('unit_code', 'like', $tower.'%')->orderBy('floor', 'asc')->get();
        return response()->json($lantai);
    }

    public function unitByFloorTower($tower, $floor) {
        $type = Unit::where('floor', $floor)->where('unit_code', 'like', $tower.'%')->get();
        return UnitResource::collection($type)->response()->getData(true);
    }
}