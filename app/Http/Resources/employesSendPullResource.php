<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class employesSendPullResource extends JsonResource
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
                "pin" => $this->Employe->id,
                "name" => $this->Employe->nom . ' ' . $this->Employe->prenom,
                "password" => "1",
                "privilege" => "0",
                "card_nb" => $this->Employe->cardNo,
                "group " => "0",
                "timezoneid " => $this->timezone_id,
                "starttime"=>"20200201",
                "endtime" => "20300101",
                "superauthorize" => "0",
                "doorid"=> $this->porte_id,
            ];
        }
    }
}
