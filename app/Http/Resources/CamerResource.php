<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Meter;

class CamerResource extends JsonResource
{
    public function toArray($request)
    {
        $data_bulan_lalu = Meter::where([
            'apartement_id' => $this->unit->id,
            'bulan_tahun' => $this->bulan_lalu($this->bulan_tahun),
            'validasi' => 1
        ])->first();

        $data = ['id' => $this->id,
            'unit_id' => $this->unit->id,
            'unit' => $this->unit->unit,
            'lantai' => $this->unit->lantai,
            'pencatatan_listrik_bulan_lalu' => '',
            'pencatatan_listrik' => $this->pencatatan_listrik,
            'pemakaian_listrik' => $this->pemakaian_listrik,
            'pencatatan_air_bulan_lalu' => '',
            'pencatatan_air' => $this->pencatatan_air,
            'pemakaian_air' => $this->pemakaian_air,
            'bulan_tahun' => $this->bulan_tahun,
            'validasi' => $this->validasi,
            'validator' => $this->when($this->validator, function() {
                return $this->validator->nama;
            }),
            'isValidator' => $this->when(is_null($this->validator_id), function() {
                return 0;
            }),
            'engineer' => $this->engineer->nama,
            'tanggal_upload' => $this->created_at->format('d M Y'),
            'tanggal_validasi' => $this->when($this->validasi == 1, function() {
                return $this->updated_at->format('d M Y');
            }),
        ];

        if($data_bulan_lalu) {
            $data['pencatatan_listrik_bulan_lalu'] = $data_bulan_lalu->pencatatan_listrik;
            $data['pencatatan_air_bulan_lalu'] = $data_bulan_lalu->pencatatan_air;
            return $data;
        } else {
            return $data;
        }

        // $data = [
        //     'id' => $this->id,
        //     'unit' => $this->unit->unit,
        //     'lantai' => $this->unit->lantai,
        //     'bulan_tahun' => $this->bulan_tahun,
        //     'pencatatan_listrik' => $this->pencatatan_listrik,
        //     'pemakaian_listrik' => $this->pemakaian_listrik,
        //     'pencatatan_air' => $this->pencatatan_air,
        //     'pemakaian_air' => $this->pemakaian_air,
        //     'unit_id' => $this->unit->id,
        //     'validasi' => $this->validasi,
        //     'gambar1' => $this->gambar1,
        //     'gambar2' => $this->gambar2,
        //     'validator' => $this->when($this->validator, function() {
        //         return $this->validator->nama;
        //     }),
        //     'engineer' => $this->engineer->nama,
        //     'tanggal_upload' => $this->created_at->format('d M Y'),
        //     'tanggal_validasi' => $this->when($this->validasi == 1, function() {
        //         return $this->updated_at->format('d M Y');
        //     }),
        // ];

        // if($data_bulan_lalu) {
        //     return $data += [
        //         'pencatatan_listrik_bulan_lalu' => $data_bulan_lalu->pencatatan_listrik,
        //         'pencatatan_air_bulan_lalu' => $data_bulan_lalu->pencatatan_air,
        //     ];
        // } else {
        //     return $data;
        // }
    }

    public function bulan_lalu($date) {
        $tmp = [];
        $tmp = explode(" ", $date);
        $date = $tmp[1] . "-" . $tmp[0];
        return Date("m Y", strtotime($date . " -1 Month"));
    }
}