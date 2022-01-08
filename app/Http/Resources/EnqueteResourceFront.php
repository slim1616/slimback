<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EnqueteResourceFront extends JsonResource
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
                                
            'title' => $this->title,
                                
            'description' => $this->description,
                                
            'company_id' => $this->company_id,
                    
            'company' => $this->Company->title,
            'logo' => !is_null($this->Company->logo)? $this->Company->logo : '',
            'user_id' => $this->user_id,
            'layout' => $this->layout,
            'user' => $this->User->name,
            'online' => $this->online,
            'questionParPage' => $this->questionParPage,
            'start_at' => $this->start_at,
            // 'reponses' => $this->Reponses->count(),
            'end_at' => $this->end_at,
            'online' => $this->online,
            'confidentiality' => $this->confidentiality,
                                
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // 'selectedEmplacements' => $this->Enqueteemplacements->pluck('emplacement_id'),
                                
            // 'updated_in' => Carbon::parse($this->updated_at)->format('d/m/Y  H:i'),
                                ];
    }
}
