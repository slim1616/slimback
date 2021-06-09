<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class employesSendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->Employe->active && !is_null($this->Employe->cardNo)){

            return [
                "id_management" => $this->Employe->id,
                "enroll_number" => $this->Employe->id,
                "name" => $this->Employe->nom . ' ' . $this->Employe->prenom,
                "password" => "1",
                "privilege" => "0",
                "enabled " => "True",
                "card_nb" => $this->Employe->cardNo
           ];
        }
    }
}
