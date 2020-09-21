<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CamerExcelResource extends JsonResource
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
            'id' => $this->id,
            'unit' => $this->unit->unit,
            'pencatatan_listrik' => $this->pencatatan_listrik,
            'pemakaian_listrik' => $this->pemakaian_listrik,
            'pencatatan_air' => $this->pencatatan_air,
            'pemakaian_air' => $this->pemakaian_air,
            'bulan_tahun' => $this->bulan_tahun,
            'validasi' => $this->validasi,
            'validator' => $this->when($this->validator, function() {
                return $this->validator->nama;
            }),
            'validatorr' => $this->when(!$this->validator, function() {
                return '';
            }),
            'engineer' => $this->engineer->nama,
            'tanggal_upload' => $this->created_at->format('d M Y'),
            'tanggal_validasi' => $this->updated_at->format('d M Y'),
        ];
    }
}
