<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PointageResource extends JsonResource
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
            'avatar' => $this->employe_id!=0 ? $this->Employe->avatar->getUrl() : '',
            'datetime' => Carbon::parse($this->datetime)->format('d/m/Y H:i:s'),
            'employe_id' => $this->employe_id,
            'employe' => $this->employe_id!=0 ? $this->Employe->nom . ' ' . $this->Employe->prenom : 'Inconnue',
            'porte' => $this->Porte->titre,
            'zone' => $this->Zone->title,
            'batiement' => $this->Batiment->title,
            'nature_porte' => $this->nature_porte,
            'departement' => $this->Departement->title,
            'type_emp' => $this->type_emp,
            
        ];
    }
}
