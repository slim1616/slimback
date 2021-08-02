<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnqEmplacementResource extends JsonResource
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
                                        
            'title' => $this->Emplacement->title,
                                
            'adresse' => $this->Emplacement->adresse,
                                
            'email' => $this->Emplacement->email,
                                
            'tel' => $this->Emplacement->tel,
                                
            'company_id' => $this->company_id,
            'emplacement_id' => $this->emplacement_id,
            'enquete_id' => $this->enquete_id,
                    
            'company' => $this->Emplacement->Company->title,
                                
            'user_id' => $this->Emplacement->user_id,
            'password' => $this->password
        ];
    }
}
