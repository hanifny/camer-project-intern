<?php

namespace App\Http\Controllers;

use App\Apartement;
use Illuminate\Http\Request;
use App\Http\Resources\CamerResource;
use App\Http\Resources\CamerPerTowerResource;
use App\Meter;
use App\User;
use Illuminate\Support\Facades\File;
use App\Exports\CamerExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class CamerController extends Controller
{
    public function all() {
        $camer = Meter::where('bulan_tahun', date('m Y'))->where('validasi', '!=', 2)->orderBy('validasi', 'asc')->paginate(100);
        return CamerResource::collection($camer)->response()->getData(true);
    }

    public function camer_per_tower(Request $request) {
        $camer = Meter::where('bulan_tahun', $request->month_year)->where('validasi', '!=', 2)->orderBy('validasi', 'asc');
        if ($request->tower === "T") {
            $camer = $camer->whereHas('unit', function ($query) {
                return $query->where('unit', 'like', 'T%');
            })->paginate(100);
        } elseif ($request->tower === "U") {
            $camer = $camer->whereHas('unit', function ($query) {
                return $query->where('unit', 'like', 'U%');
            })->paginate(100);
        } else {
            $camer = $camer->paginate(100);
        }
        return CamerPerTowerResource::collection($camer)->response()->getData(true);
    }

    public function camer_per_month(Request $request) {
        $camer = Meter::where('bulan_tahun', $request->month_year)->where('validasi', '!=', 2)->orderBy('validasi', 'asc')->paginate(100);
        return CamerResource::collection($camer)->response()->getData(true);
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
        if(!$data_bulan_ini) {
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
        } elseif($data_bulan_ini) {
            return response()->json(['status' => 'data already added']);            
        }
        return response()->json(['status' => 'failed']);
    }

    public function update(Request $request) {
        $this->validate($request, [
            'file1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // data bulan lalu
        $data_bulan_lalu = Meter::where(
            ['apartement_id' => $request->unit_id,
            'bulan_tahun' => date("m Y", strtotime("last month")),
            'validasi' => 1]
        )->select('pencatatan_listrik', 'pencatatan_air')->first();
        // data yg mau diedit
        $camer = Meter::where(['id' => $request->camer_id, 'validasi' => 2])->first();

		// menyimpan data file yang diupload ke variabel $file
        $file1 = $request->file('file1');
        $file2 = $request->file('file2');
        // modify nama gambar 
        $bukti_gambar1 = time()."_".$file1->getClientOriginalName();
        $bukti_gambar2 = time()."_".$file2->getClientOriginalName();
        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'img/camer';
        // hapus foto lama
        File::delete('img/camer/' . $camer->gambar1);
        File::delete('img/camer/' . $camer->gambar2);
        
        // save gambar
        $file1->move($tujuan_upload, $bukti_gambar1);
        $file2->move($tujuan_upload, $bukti_gambar2);
        // update camer
        $update = $camer->update([
            'gambar1' => $bukti_gambar1,
            'gambar2' => $bukti_gambar2,
            'pencatatan_listrik' => $request->pencatatan_listrik,
            'pencatatan_air' => $request->pencatatan_air,
            'validasi' => 0,
            'validator_id' => null,
            'engineer_id' => $request->user()->id
        ]);
        if($data_bulan_lalu) {
            // Otomatis menghitung pemakaian listrik dan air
            $update_pemakaian = $camer->update([
                'pemakaian_listrik' => $request->pencatatan_listrik - $data_bulan_lalu->pencatatan_listrik,
                'pemakaian_air' => $request->pencatatan_air - $data_bulan_lalu->pencatatan_air
            ]);
        } 

        if ($update) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    public function validation(Request $request) {
        $validasi = Meter::find($request->id);
        $validasi->pencatatan_air = $request->pencatatan_air;
        $validasi->pencatatan_listrik = $request->pencatatan_listrik;
        if ($request->pencatatan_listrik_bulan_lalu && $request->pencatatan_air_bulan_lalu) {
            $validasi->pemakaian_listrik = $request->pencatatan_listrik - $request->pencatatan_listrik_bulan_lalu;
            $validasi->pemakaian_air = $request->pencatatan_air - $request->pencatatan_air_bulan_lalu;
        }
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
        $validasi = Meter::where([
            'bulan_tahun' => $request->all()['data'][0]['bulan_tahun'], 
            'validasi' => 0,
        ])->update(['validasi' => 1, 
                    'validator_id' => $request->user()->id,
                    ]);
        if($validasi) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 422);
        }
    }

    public function count() {
        $count_camer_must_validation = Meter::where([
            'validasi' => 0,
            'bulan_tahun' => date('m Y')
        ])->count();
        $count_camer_validated = Meter::where([
            'validasi' => 1,
            'bulan_tahun' => date('m Y')
        ])->count();
        $count_camer_invalid = Meter::where('validasi', 2)->count();
        $count_engineer = User::where('role_id', '9db7170e-7d23-4b16-98a0-095f4c3c1f6a')->count();
        $count_camer_today_validation = Meter::whereDate('updated_at', Carbon::today())->where([
            'validasi' => 1,
            'bulan_tahun' => date('m Y')
        ])->count();
        $count_unit = Apartement::count();
        return response()->json([
            'camer_must_validation' => $count_camer_must_validation,
            'camer_validated' => $count_camer_validated,
            'camer_invalid' => $count_camer_invalid, 
            'engineer' => $count_engineer,
            'unit' => $count_unit,
            'camer_today_validation' => $count_camer_today_validation
        ]); 
    }

    public function export() 
    {
        return Excel::download(new CamerExport, 'camer.xlsx');
    }
}