<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployesResources extends JsonResource
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
            'email' => $this->email,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'birthday' => $this->birthday,
            'adress' => $this->adress,
            'phone' => $this->phone,
            'sexe' => $this->sexe,
            'matricule' => $this->matricule,
            'fonction' => $this->fonction,
            'departement' => $this->Departement->title,
            'departement_id' =>   $this->departement_id,
            'postal_code' =>   $this->postal_code,
            'cardNo' =>   $this->cardNo,
            'active' =>   $this->active==1 ? true : false,
            'avatar_id' => $this->avatar_id,
            'marge_entree' => $this->marge_entree,
            'marge_sortie' => $this->marge_sortie,
            'marge_entree_retard' => $this->marge_entree_retard,
            'marge_sortie_retard' => $this->marge_sortie_retard,
            'fingerPrint1' => is_null($this->fingerPrint1)? "" : $this->fingerPrint1,
            'fingerPrint2' => is_null($this->fingerPrint2)? "" : $this->fingerPrint2,
            'emploi' => $this->emploi,
            'avatar' => $this->avatar?$this->avatar->getUrl('avatar'):asset('img/avatar.jpg'),
            
        ];
    }
}
