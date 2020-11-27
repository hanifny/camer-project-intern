<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use App\Http\Resources\MeterRecordResource;
use App\MeterRecord;
use App\User;
use Illuminate\Support\Facades\File;
use App\Exports\MeterRecordExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class MeterRecordController extends Controller
{
    public function getCamer(Request $request) {
        $camer = MeterRecord::where([
                'month_year' => $request->month_year,
                'type' => $request->type,
            ])->where('validation', '!=', 2)->orderBy('validation', 'asc');
        if ($request->tower === "T") {
            $camer = $camer->whereHas('unit', function ($query) {
                return $query->where('unit_code', 'like', 'T%');
            })->paginate(100);
        } elseif ($request->tower === "U") {
            $camer = $camer->whereHas('unit', function ($query) {
                return $query->where('unit_code', 'like', 'U%');
            })->paginate(100);
        } else {
            $camer = $camer->paginate(100);
        }
        return MeterRecordResource::collection($camer)->response()->getData(true);
    }

    public function camer_per_month(Request $request) {
        $camer = MeterRecord::where([
            'month_year' => $request->month_year,
            'type' => $request->type,
            ])->where('validation', '!=', 2)->orderByRaw('validation asc, updated_at desc')->paginate(100);
        return MeterRecordResource::collection($camer)->response()->getData(true);
    }

    public function camer_last_month(Request $request) {
        $camer = MeterRecord::where([
            'unit_id' => $request->unit_id,
            'month_year' => date('m Y', strtotime('last month')),
            'type' => $request->type,
        ])->where('validation', '!=', 2)->get();
        return MeterRecordResource::collection($camer)->response()->getData(true);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

        // cek apakah user mengirim nama unit atau id unit
        if(isset($request->unit_id)) {
            $unit_id = $request->unit_id;
        } else {
            $unit = DB::table('units')->where('unit_code', $request->unit)->first();
            $unit_id = $unit->id;
        };

		// menyimpan data file yang diupload ke variabel $file
        $gambar = $request->file('gambar');
 
        $bukti_gambar = time()."_".$gambar->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'img/camer';
        
        $data_bulan_lalu = MeterRecord::where(
            ['unit_id' => $unit_id,
            'month_year' => date("m Y", strtotime("last month")),
            'validation' => 1,
            'type' => $request->tipe]
        )->select('meter_start')->first();
        $data_bulan_ini = MeterRecord::where(
            ['unit_id' => $unit_id,
            'month_year' => date('m Y'),
            'type' => $request->tipe
            ]
        )->first();

        // save camer
        $camer = new MeterRecord;
        $camer->type = $request->tipe;
        $camer->engineer_id = $request->user()->id;
        $camer->meter_end = $request->meter_akhir;
        $camer->unit_id = $unit_id;
        $camer->validation = 0;
        $camer->image = $bukti_gambar;
        $camer->month_year = date('m Y');
        if(!$data_bulan_ini) {
            if($data_bulan_lalu) {
                // Otomatis menghitung pemakaian listrik dan air
                $camer->meter_start = $data_bulan_lalu->meter_start;
            } 
            $camer->validator_id = null;
            $camer->save();
            // upload file
            $gambar->move($tujuan_upload, $bukti_gambar);
            return response()->json(['status' => 'success']);
        } elseif($data_bulan_ini) {
            return response()->json(['status' => 'Data sudah ada'], 500);            
        }
        return response()->json(['status' => 'failed'], 500);
    }

    public function update(Request $request) {
        $this->validate($request, [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // data yg mau diedit
        $camer = MeterRecord::where(['id' => $request->camer_id, 'validation' => 2])->first();

		// menyimpan data file yang diupload ke variabel $file
        $gambar = $request->file('gambar');
        // modify nama gambar 
        $bukti_gambar = time()."_".$gambar->getClientOriginalName();
        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'img/camer';
        // hapus foto lama
        File::delete('img/camer/' . $camer->gambar);
        // save gambar
        $gambar->move($tujuan_upload, $bukti_gambar);

        // update camer
        $update = $camer->update([
            'image' => $bukti_gambar,
            'meter_end' => $request->meter_akhir,
            'validation' => 0,
            'validator_id' => null,
            'engineer_id' => $request->user()->id
        ]);

        if ($update) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    public function validation(Request $request) {
        $validation = MeterRecord::find($request->id);
        $validation->meter_end = $request->meter_akhir;

        if($request->status == "invalid") {
            // ketika data tidak valid
            $validation->validation = 2;
        } else { 
            // ketika data valid
            $validation->validation = 1;
        }

        $validation->validator_id = $request->user()->id;
        $validation->save();
        return response()->json(['status' => 'success']);
    }

    
    public function count() {
        // General
        $validated = MeterRecord::where([
            'validation' => 1,
            'month_year' => date('m Y'),
        ])->count();

        // Camer wt
        $wt_must_validation = MeterRecord::where([
            'validation' => 0,
            'month_year' => date('m Y'),
            'type' => 'wt'
        ])->count();
        $wt_validated_today = MeterRecord::whereDate('updated_at', Carbon::today())->where([
            'validation' => 1,
            'month_year' => date('m Y'),
            'type' => 'wt'
        ])->count();

        // Camer el
        $el_must_validation = MeterRecord::where([
            'validation' => 0,
            'month_year' => date('m Y'),
            'type' => 'el'
            ])->count();
        $el_validated_today = MeterRecord::whereDate('updated_at', Carbon::today())->where([
            'validation' => 1,
            'month_year' => date('m Y'),
            'type' => 'el'
        ])->count();

        $invalid = MeterRecord::where('validation', 2)->count();
        $engineer = User::where('role_id', '9db7170e-7d23-4b16-98a0-095f4c3c1f6a')->count();
        $unit = Unit::count();
        return response()->json([
            'el_validation' => $el_must_validation,
            'el_validated_today' => $el_validated_today,
            'wt_validation' => $wt_must_validation,
            'wt_validated_today' => $wt_validated_today,

            'validated' => $validated,
            'invalid' => $invalid, 
            'engineer' => $engineer,
            'unit' => $unit,
            ]); 
        }
        
        public function export() 
        {
            return Excel::download(new MeterRecordExport, 'camer.xlsx');
        }

    public function invalid(Request $request) {
        $allInvalid = MeterRecordResource::collection(MeterRecord::where('validation', 2)->get());
        return response()->json($allInvalid);
    }
}