<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TimezoneResource extends JsonResource
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
            'titre' => $this->titre,
            'heure_debut' => Carbon::parse($this->heure_debut)->format('H:i'),
            'heure_fin' => Carbon::parse($this->heure_fin)->format('H:i'),
            'marge_entree' => $this->marge_entree,
            'marge_sortie' => $this->marge_sortie,
            'marge_sortie' => $this->marge_sortie,
            'marge_entree_retard' => $this->marge_entree_retard,
            'marge_sortie_retard' => $this->marge_sortie_retard,
            'planning' => $this->planning,
        ];
    }
}
