<?php

namespace App\Http\Resources;

use App\Meter;
use Illuminate\Http\Resources\Json\JsonResource;

class CamerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data_bulan_lalu = Meter::where(
            ['apartement_id' => $this->apartement_id,
            'bulan_tahun' => $this->bulan_lalu($this->bulan_tahun),
            'validasi' => 1]
        )->first();
        if($data_bulan_lalu) {
            return [
                'id' => $this->id,
                'bulan_lalu' => $data_bulan_lalu->bulan_tahun,
                'pencatatan_listrik' => $this->pencatatan_listrik,
                'pencatatan_listrik_bulan_lalu' => $data_bulan_lalu->pencatatan_listrik,
                'pemakaian_listrik' => $this->pemakaian_listrik,
                'pencatatan_air' => $this->pencatatan_air,
                'pencatatan_air_bulan_lalu' => $data_bulan_lalu->pencatatan_air,
                'pemakaian_air' => $this->pemakaian_air,
                'unit' => $this->unit->unit,
                'validasi' => $this->validasi,
                'gambar1' => $this->gambar1,
                'gambar2' => $this->gambar2,
                'bulan_tahun' => $this->bulan_tahun,
                'validator' => $this->when($this->validator, function() {
                    return $this->validator->nama;
                }),
                'engineer' => $this->engineer->nama,
                'tanggal_upload' => $this->created_at->format('d M Y'),
            ];
        }
        else {
            return [
                'id' => $this->id,
                'bulan_lalu' => $this->bulan_lalu($this->bulan_tahun),
                'pencatatan_listrik' => $this->pencatatan_listrik,
                'pemakaian_listrik' => $this->pemakaian_listrik,
                'pencatatan_air' => $this->pencatatan_air,
                'pemakaian_air' => $this->pemakaian_air,
                'unit' => $this->unit->unit,
                'validasi' => $this->validasi,
                'gambar1' => $this->gambar1,
                'gambar2' => $this->gambar2,
                'bulan_tahun' => $this->bulan_tahun,
                'validator' => $this->when($this->validator, function() {
                    return $this->validator->nama;
                }),
                'engineer' => $this->engineer->nama,
                'tanggal_upload' => $this->created_at->format('d M Y'),
            ];
        }   
    }

    public function bulan_lalu($date) {
        $tmp = [];
        $tmp = explode(" ", $date);
        $date = $tmp[1] . "-" . $tmp[0];
        return Date("m Y", strtotime($date . " -1 Month"));
    }
}
