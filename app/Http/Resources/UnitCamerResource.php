<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitCamerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->unit->id,
            'unit' => $this->unit->unit,
            'lantai' => $this->unit->lantai,
            'camer_id' => $this->id,
            'bulan_lalu' => $this->bulan_tahun,
            'pencatatan_listrik' => $this->pencatatan_listrik,
            'pencatatan_listrik_bulan_lalu' => $this->when($this->pemakaian_listrik, function() {
                return $this->pencatatan_listrik - $this->pemakaian_listrik;
            }),
            'pemakaian_listrik' => $this->pemakaian_listrik,
            'pencatatan_air' => $this->pencatatan_air,
            'pencatatan_air_bulan_lalu' => $this->when($this->pemakaian_air, function() {
                return $this->pencatatan_air - $this->pemakaian_air;
            }),
            'pemakaian_air' => $this->pemakaian_air,
            'unit' => $this->unit->unit,
            'unit_id' => $this->unit->id,
            'validasi' => $this->validasi,
            'gambar1' => $this->gambar1,
            'gambar2' => $this->gambar2,
            'bulan_tahun' => $this->bulan_tahun,
            'validator' => $this->when($this->validator, function() {
                return $this->validator->nama;
            }),
            'engineer' => $this->engineer->nama,
            // 'tanggal_upload' => $this->created_at->format('d M Y'),
        ];
    }
}
