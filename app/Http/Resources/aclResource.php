<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class aclResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if ($this->Porte->sdk=='pull'){
            return [
                'device_id_management' => $this->Porte->id,
                'addr' => $this->Porte->ip,
                "password" => !is_null($this->Porte->password)? $this->Porte->password : "",
                'users' => employesSendPullResource::collection($this->Porte->Acceslevels)
                
            ];
        }else if ($this->sdk=='standalone'){
            return [
                'device_id_management' => $this->Porte->id,
                'addr' => $this->Porte->ip,
                "password" => !is_null($this->Porte->password)? $this->Porte->password : "",
                'users' => employesSendResource::collection($this->Porte->Acceslevels)
            ];
        }
    }
}
