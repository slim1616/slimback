<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessleveResource extends JsonResource
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
            'employe_id' => $this->employe_id,
            'employe' => $this->Employe,
            'porte_id' => $this->porte_id,
            'porte' => $this->Porte,
            'zone' => $this->Porte->Zone,
            'batiement' => $this->Porte->Zone->Batiment,
            'departement' => $this->Employe->Departement,
            'timezone_id' => $this->timezone_id,
            'timezone' => $this->Timezone,
        ];
    }
}
