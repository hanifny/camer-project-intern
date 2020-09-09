<?php

namespace App\Http\Resources;

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
        return [
            'pencatatan_listrik' => $this->pencatatan_listrik,
            'pencatatan_air' => $this->pencatatan_air,
            'pemakaian_listrik' => $this->pemakaian_listrik,
            'pemakaian_air' => $this->pemakaian_air,
            'unit' => $this->unit->unit,
            'validasi' => $this->validasi,
            'bulan_tahun' => $this->bulan_tahun,
            'validator' => $this->when($this->validator, function() {
                return $this->validator->nama;
            }),
            'engineer' => ($this->engineer->nama),
        ];
    }
}
