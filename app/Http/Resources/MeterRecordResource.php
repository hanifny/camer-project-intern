<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\MeterRecord;

class MeterRecordResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'tipe' => $this->type,
            'unit_id' => $this->unit->id,
            'unit' => $this->unit->unit_code,
            'lantai' => $this->unit->floor,
            'meter_awal' => $this->meter_start,
            'meter_akhir' => $this->meter_end,

            'bulan_tahun' => $this->month_year,
            'validasi' => $this->validation,
            'validator' => $this->when($this->validator, function() {
                return $this->validator->name;
            }),
            'isValidator' => $this->when(is_null($this->validator_id), function() {
                return 0;
            }),
            'engineer' => $this->engineer->name,
            'tanggal_upload' => $this->created_at->format('d M Y'),
            'tanggal_validasi' => $this->when($this->validation == 1, function() {
                return $this->updated_at->format('d M Y');
            }),
            'gambar' => $this->image,
        ];

        return $data;
    }
}