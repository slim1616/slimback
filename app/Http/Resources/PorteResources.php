<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PorteResources extends JsonResource
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
            "id" => $this->id,
            "marque" => $this->marque,
            "model" => $this->model,
            "ip" => $this->ip,
            "port" => $this->port,
            "titre" => $this->titre,
            "type" => $this->type,
            "status" => $this->status,
            "last_update_status" =>  is_null($this->last_update_status)? '' : Carbon::parse($this->last_update_status)->format('d/m/Y  H:i:s'),
            "zone_id" => $this->zone_id,
            "batiment_id" => $this->batiment_id,
            "zone" => $this->Zone->title,
            "batiment" => $this->Batiment->title,
        ];
    }
}
