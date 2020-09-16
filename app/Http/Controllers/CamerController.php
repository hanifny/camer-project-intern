<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CamerResource;
use App\Meter;

class CamerController extends Controller
{
    public function all() {
        $camer = CamerResource::collection(Meter::where('bulan_tahun', date('m Y'))->orderBy('validasi', 'asc')->get());
        return response()->json($camer);
    }

    public function camer_per_month(Request $request) {
        // return $request->month_year;
        $camer = CamerResource::collection(Meter::where('bulan_tahun', $request->month_year)->orderBy('validasi', 'asc')->get());
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
        $data_bulan_ini = Meter::where(
            ['apartement_id' => $request->unit,
            'bulan_tahun' => date('m Y'),
            ]
        )->first();

        // save camer
        $camer = new Meter;
        $camer->engineer_id = $request->user()->id;
        $camer->pencatatan_listrik = $request->pencatatan_listrik;
        $camer->pencatatan_air = $request->pencatatan_air;
        $camer->apartement_id = $request->unit;
        $camer->validasi = 0;
        $camer->gambar1 = $bukti_gambar1;
        $camer->gambar2 = $bukti_gambar2;
        $camer->bulan_tahun = date('m Y');
        if(!$data_bulan_ini) {
            if($data_bulan_lalu) {
                // Otomatis menghitung pemakaian listrik dan air
                $camer->pemakaian_listrik = $request->pencatatan_listrik - $data_bulan_lalu->pencatatan_listrik;
                $camer->pemakaian_air = $request->pencatatan_air - $data_bulan_lalu->pencatatan_air;
            }
            $camer->save();
            return response()->json(['status' => 'success']);
        } 
        return response()->json(['status' => 'failed']);
    }

    public function validation(Request $request) {
        $validasi = Meter::find($request->id);
        $validasi->validasi = 1;
        $validasi->validator_id = $request->user()->id;
        $validasi->save();
        return $validasi;
    }

    public function validation_per_month(Request $request) {
        $validasi = Meter::where(['bulan_tahun' => $request->bulan_tahun, 'validasi' => 0])
                    ->update(['validasi' => 1, 'validator_id' => $request->user()->id]);
    }
}