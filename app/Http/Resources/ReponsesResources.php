<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReponsesResources extends JsonResource
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
            'enquete_id' => $this->enquete_id,
            'company_id' => $this->company_id,
            'emplacement_id' => $this->emplacement_id,
            'reponses' => $this->Reponses,
            'created_at' =>  Carbon::parse($this->created_at)->format('d/m/Y  H:i:s'),
        ];
    }
}
