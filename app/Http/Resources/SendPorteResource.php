<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\employesSendResource;
use App\Http\Resources\employesSendPullResource;

class SendPorteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->sdk=='pull'){
            return [
                'device_id_management' => $this->id,
                'addr' => $this->ip,
                "password" => !is_null($this->password)? $this->password : "",
                'users' => employesSendPullResource::collection($this->Acceslevels)
            ];
        }else if ($this->sdk=='standalone'){
            return [
                'device_id_management' => $this->id,
                'addr' => $this->ip,
                "password" => !is_null($this->password)? $this->password : "",
                'users' => employesSendResource::collection($this->Acceslevels)
            ];
        }
    }
    
}
