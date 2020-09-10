<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartement;
use App\Http\Resources\CamerResource;
use App\Http\Resources\UnitResource;
use App\Meter;

class CamerController extends Controller
{
    public function camer() {
        $camer = CamerResource::collection(Meter::get());
        return response()->json($camer);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'file1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);
 
		// menyimpan data file yang diupload ke variabel $file
        $file1 = $request->file('file1');
        $file2 = $request->file('file2');
 
        $bukti_gambar1 = time()."_".$file1->getClientOriginalName();
        $bukti_gambar2 = time()."_".$file2->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'img/camer';
 
        // upload file
        $file1->move($tujuan_upload, $bukti_gambar1);
        $file2->move($tujuan_upload, $bukti_gambar2);
        
        // dd(date('m Y', strtotime("last month")));
        $data_bulan_lalu = Meter::where(
            ['apartement_id' => $request->unit,
            'bulan_tahun' => date('m Y', strtotime("last month")),
            'validasi' => 1]
            )->select('pencatatan_listrik', 'pencatatan_air')->first();
        
        if($data_bulan_lalu) {
            // save camer
            $camer = new Meter;
            $camer->engineer_id = $request->user()->id;
            $camer->pencatatan_listrik = $request->pencatatan_listrik;
            $camer->pencatatan_air = $request->pencatatan_air;
            $camer->pemakaian_listrik = $request->pencatatan_listrik - $data_bulan_lalu->pencatatan_listrik;
            $camer->pemakaian_air = $request->pencatatan_air - $data_bulan_lalu->pencatatan_air;
            $camer->apartement_id = $request->unit;
            $camer->validasi = 0;
            $camer->gambar1 = $bukti_gambar1;
            $camer->gambar2 = $bukti_gambar2;
            $camer->bulan_tahun = date('m Y');
            $camer->save();
            return response()->json(['status_code' => 'success']);
        } else {
            $camer = new Meter;
            $camer->engineer_id = $request->user()->id;
            $camer->pencatatan_listrik = $request->pencatatan_listrik;
            $camer->pencatatan_air = $request->pencatatan_air;
            $camer->apartement_id = $request->unit;
            $camer->validasi = 0;
            $camer->gambar1 = $bukti_gambar1;
            $camer->gambar2 = $bukti_gambar2;
            $camer->bulan_tahun = date('m Y');
            $camer->save();
            $camer->status_code = 'success';                                                
            return response()->json(['status_code' => 'success']);
        }
        
    }

    public function floor() {
        $lantai = Apartement::distinct()->select('lantai')->orderBy('lantai', 'asc')->get();
        return response()->json($lantai);
    }

    public function all_unit() {
        $unit = UnitResource::collection(Apartement::orderBy('lantai', 'desc')->paginate(100));
        return response()->json($unit);
    }

    public function unit_per_floor($floor) {
        $unit_per_floor = UnitResource::collection(Apartement::where('lantai', $floor)->orderBy('lantai', 'desc')->get());
        return response()->json($unit_per_floor);
    }
}