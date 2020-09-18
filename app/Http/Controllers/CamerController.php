<?php

namespace App\Http\Controllers;

use App\Apartement;
use Illuminate\Http\Request;
use App\Http\Resources\CamerResource;
use App\Meter;
use App\User;

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
        
        // dd(date('m Y', strtotime("last month")));
        $data_bulan_lalu = Meter::where(
            ['apartement_id' => $request->unit_id,
            'bulan_tahun' => date("m Y", strtotime("last month")),
            'validasi' => 1]
        )->select('pencatatan_listrik', 'pencatatan_air')->first();
        $data_bulan_ini = Meter::where(
            ['apartement_id' => $request->unit_id,
            'bulan_tahun' => date('m Y'),
            ]
        )->first();
            
        // save camer
        $camer = new Meter;
        $camer->engineer_id = $request->user()->id;
        $camer->pencatatan_listrik = $request->pencatatan_listrik;
        $camer->pencatatan_air = $request->pencatatan_air;
        $camer->apartement_id = $request->unit_id;
        $camer->validasi = 0;
        $camer->gambar1 = $bukti_gambar1;
        $camer->gambar2 = $bukti_gambar2;
        $camer->bulan_tahun = date('m Y');
        if(!$data_bulan_ini || $data_bulan_ini->validasi == 2) {
            if($data_bulan_lalu) {
                // Otomatis menghitung pemakaian listrik dan air
                $camer->pemakaian_listrik = $request->pencatatan_listrik - $data_bulan_lalu->pencatatan_listrik;
                $camer->pemakaian_air = $request->pencatatan_air - $data_bulan_lalu->pencatatan_air;
            } 
            $camer->validator_id = null;
            $camer->save();
            // upload file
            $file1->move($tujuan_upload, $bukti_gambar1);
            $file2->move($tujuan_upload, $bukti_gambar2);
            return response()->json(['status' => 'success']);
        } 
        return response()->json(['status' => 'failed']);
    }

    public function update(Request $request) {
        $tmp = [];
        $date = "09 2020";
        $tmp = explode(" ", $date);
        $date = $tmp[1] . "-" . $tmp[0];
        echo Date("m Y", strtotime($date . " -1 Month"));
    }

    public function validation(Request $request) {
        $validasi = Meter::find($request->id);
        $validasi->pencatatan_air = $request->pencatatan_air;
        $validasi->pencatatan_listrik = $request->pencatatan_listrik;
        // ketika data tidak valid
        if($request->status == "invalid") {
            $validasi->validasi = 2;
        } else { 
            // ketika data valid
            $validasi->validasi = 1;
        }
        $validasi->validator_id = $request->user()->id;
        $validasi->save();
        return response()->json(['status' => 'success']);
    }

    public function validation_per_month(Request $request) {
        $validasi = Meter::where(['bulan_tahun' => $request->bulan_tahun, 'validasi' => 0])
                    ->update(['validasi' => 1, 'validator_id' => $request->user()->id]);
    }

    public function count() {
        $count_camer_validation = Meter::where('validasi', 0)->count();
        $count_camer_invalid = Meter::where('validasi', 2)->count();
        $count_engineer = User::where('role_id', '2db7170e-7d23-4b16-98a0-095f4c3c1f6a')->count();
        $count_unit = Apartement::count();
        return response()->json([
            'camer_validation' => $count_camer_validation,
            'camer_invalid' => $count_camer_invalid, 
            'engineer' => $count_engineer,
            'unit' => $count_unit,
        ]); 
    }
}