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
            'camer_id' => $this->id
        ];
    }
}
