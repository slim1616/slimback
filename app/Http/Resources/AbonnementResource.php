<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbonnementResource extends JsonResource
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
                                        
                    'formule_id' => $this->formule_id,
                            
                    'formule' => $this->Formule->title,
                                        
                    'company_id' => $this->company_id,
                            
                    'company' => $this->Company->title,
                                        
                    'user_id' => $this->user_id,
                            
                    'user' => $this->User->name,
                                        
                    'start_at' => $this->start_at,
                                        
                    'end_at' => $this->end_at,
                                        
                    'created_at' => $this->created_at,
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>