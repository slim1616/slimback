<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnqueteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function toArray($request)
    {
        return [
                    
                    'id' => $this->id,
                                        
                    'title' => $this->title,
                                        
                    'description' => $this->description,
                                        
                    'company_id' => $this->company_id,
                            
                    'company' => $this->Company->title,
                                        
                    'user_id' => $this->user_id,
                            
                    'user' => $this->User->name,
                                        
                    'start_at' => $this->start_at,
                    'objectif' => $this->objectif,
                                        
                    'end_at' => $this->end_at,
                    'confidentiality' => $this->confidentiality,
                                        
                    'created_at' => $this->created_at,
                    'selectedEmplacements' => $this->Enqueteemplacements->pluck('emplacement_id'),
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>