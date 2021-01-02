<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'tipe' => $this->type,
            'unit' => $this->unit->unit_code,
            'meter_awal' => $this->meter_start,
            'meter_akhir' => $this->meter_end,
            'pemakaian' => $this->meter_end - $this->meter_start,
            'bulan_tahun' => $this->month_year,
            'validasi' => $this->when($this->validation, function() {
                if($this->validation == 1) {
                    return 'Tervalidasi';
                } else if($this->validation == 2) {
                    return 'Tidak Valid';
                } else {
                    return 'Belum Tervalidasi';
                } 
            }),
            'validator' => $this->when($this->validator, function() {
                return $this->validator->name;
            }),
            'isValidator' => $this->when(is_null($this->validator_id), function() {
                return 0;
            }),
            'engineer' => $this->engineer->name,
            'tanggal_upload' => $this->created_at->format('Y-m-d'),
            'tanggal_validasi' => $this->when($this->validation == 1, function() {
                return $this->validation_date;
            }),
        ];
        return $data;
    }
}
