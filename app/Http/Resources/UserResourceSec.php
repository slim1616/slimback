<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceSec extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->avatar->getUrl('avatar'));
        return [
            'id' => $this->id,
            // 'name' => !is_null($this->name),
            'email' => $this->email,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'birthday' => $this->birthday,
            'adress' => $this->adress,
            'phone' => $this->phone,
            'sexe' => $this->sexe,
            'role' => $this->Role->slug,
            'role_id' => $this->role_id,
            'active' =>   $this->active==1 ? true : false,
            'avatar_id' => $this->avatar_id,
            'avatar' => $this->avatar?$this->avatar->getUrl('avatar'):'',
        ];
    }
}
