<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LokasiResource extends JsonResource
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
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            // Add other attributes here if needed
        ];
    }
}
