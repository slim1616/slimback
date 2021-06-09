<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BatimentsResource extends JsonResource
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
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'zones' => $this->Zones,
            'zonecount' => $this->Zones->count()
        ];
    }
}
