<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Http\Resources\UnitResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UnitImport;

class UnitController extends Controller
{
    public function import_excel(Request $request) 
    {
        // validasi
        $this->validate($request, [
            'file_unit' => 'required|mimes:csv,xls,xlsx'
        ]);
    
        // menangkap file excel
        $file = $request->file('file_unit');
    
        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();
    
        // upload ke folder file_siswa di dalam folder public
        $file->move('file_unit', $nama_file);
    
        // import data
        Excel::import(new UnitImport, public_path('/file_unit/' . $nama_file));
    }

    public function tower(Request $request) {
        if($request->tower === "B") {
            $unit = Unit::where('floor', $request->tower)->orderBy('unit_code', 'asc')->paginate(100); // tower disini maksudnya adalah basement
        } else {
            $unit = Unit::where('unit_code', 'like', $request->tower.'%')->orderBy('unit_code', 'asc')->paginate(100);
        }
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

    public function unitPerFloor($floor) {
        $unit_per_floor = Unit::where('floor', $floor)->get();
        return UnitResource::collection($unit_per_floor)->response()->getData(true);
    }

    public function allUnit() {
        $unit = Unit::orderByRaw('floor asc, unit_code asc')->paginate(100);
        return UnitResource::collection($unit)->response()->getData(true);
    }

    // APP
    // ANDROID
    public function floorByTower($tower) {
        $lantai = Unit::distinct()->select('floor')->where('unit_code', 'like', $tower.'-%')->orderBy('floor', 'asc')->get();
        return response()->json($lantai);
    }

    public function unitByFloorTower($tower, $floor) {
        $type = Unit::where('floor', $floor)->where('unit_code', 'like', $tower.'%')->get();
        return UnitResource::collection($type)->response()->getData(true);
    }
}