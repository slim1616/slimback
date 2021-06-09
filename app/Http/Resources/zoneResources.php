<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class zoneResources extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'batiment_id' => $this->batiment_id,
            'batiment' => $this->Batiment->title,
            'portes' => $this->Portes,
            'portescount' => $this->Portes->count(),
        ];
    }
}
