<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\MeterRecord;

class ContextController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function __invoke(Request $request)
    {
        function meterLastMonth($id, $type) {
            $meterLM = isset(MeterRecord::where([
                'unit_id' => $id,
                'month_year' => date('m Y', strtotime('last month')),
                'type' => $type,
            ])->where('validation', '!=', 2)->first()->meter_end);

            if($meterLM) {
                return MeterRecord::where([
                    'unit_id' => $id,
                    'month_year' => date('m Y', strtotime('last month')),
                    'type' => $type,
                ])->where('validation', '!=', 2)->select('meter_end')->first()->meter_end;  
            } else {
                return null;
            }
        }
        
        // Konteks T
        $tFloor = Unit::distinct()->select('floor')->where('unit_code', 'like', 'T'.'-%')->orderBy('floor', 'asc')->get();
        for ($i=0; $i < count($tFloor); $i++) { 
            $tFloor[$i]->unit = Unit::where('floor', $tFloor[$i]->floor)->select('unit_code', 'id')->where('unit_code', 'like', 'T'.'-%')->get();
            for ($j=0; $j < count($tFloor[$i]->unit); $j++) { 
                $tFloor[$i]->unit[$j]->meter_air_bulan_lalu = meterLastMonth($tFloor[$i]->unit[$j]->id, 'wt'); 
            }

            for ($j=0; $j < count($tFloor[$i]->unit); $j++) { 
                $tFloor[$i]->unit[$j]->meter_listrik_bulan_lalu = meterLastMonth($tFloor[$i]->unit[$j]->id, 'el'); 
            }
        }

        // Konteks U
        $uFloor = Unit::distinct()->select('floor')->where('unit_code', 'like', 'U'.'-%')->orderBy('floor', 'asc')->get();
        for ($i=0; $i < count($uFloor); $i++) { 
            $uFloor[$i]->unit = Unit::where('floor', $uFloor[$i]->floor)->select('unit_code', 'id')->where('unit_code', 'like', 'U'.'-%')->get();
            for ($j=0; $j < count($uFloor[$i]->unit); $j++) { 
                $uFloor[$i]->unit[$j]->meter_air_bulan_lalu = meterLastMonth($uFloor[$i]->unit[$j]->id, 'wt'); 
            }

            for ($j=0; $j < count($uFloor[$i]->unit); $j++) { 
                $uFloor[$i]->unit[$j]->meter_listrik_bulan_lalu = meterLastMonth($uFloor[$i]->unit[$j]->id, 'el'); 
            }
        }

        // Konteks B
        $bFloor = Unit::distinct()->select('floor')->where('floor', 0)->orderBy('floor', 'asc')->get();
        for ($i=0; $i < count($bFloor); $i++) { 
            $bFloor[$i]->unit = Unit::where('floor', $bFloor[$i]->floor)->select('unit_code', 'id')->where('floor', 0)->get();
            for ($j=0; $j < count($bFloor[$i]->unit); $j++) { 
                $bFloor[$i]->unit[$j]->meter_air_bulan_lalu = meterLastMonth($bFloor[$i]->unit[$j]->id, 'wt'); 
            }

            for ($j=0; $j < count($bFloor[$i]->unit); $j++) { 
                $bFloor[$i]->unit[$j]->meter_listrik_bulan_lalu = meterLastMonth($bFloor[$i]->unit[$j]->id, 'el'); 
            }
        }

        return response()->json([
            'T' => $tFloor, 
            'U' => $uFloor,
            'B' => $bFloor, 
            ]);
    }
}
