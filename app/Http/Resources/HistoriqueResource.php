<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class HistoriqueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->Employe->avatar);
        return [
            'id' => $this->id,
            'avatar' => !is_null($this->Employe) ? $this->Employe->avatar->getUrl() : asset('img/avatar.jpg'),
            'datetime' => Carbon::parse($this->datetime)->format('d/m/Y  H:i:s'),
            'employe_id' => $this->employe_id,
            'employe' => !is_null($this->Employe)? $this->Employe->nom . ' ' . $this->Employe->prenom : 'Inconnue',
            'porte' => $this->Porte->titre,
            'zone' => $this->Zone->title,
            'batiement' => $this->Batiment->title,
            'nature_porte' => $this->nature_porte,
            'departement' => $this->Departement->title,
            'type_emp' => $this->type_emp,
            
        ];
    }
}
