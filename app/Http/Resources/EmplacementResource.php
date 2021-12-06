<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmplacementResource extends JsonResource
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
                                        
                    'adresse' => $this->adresse,
                                        
                    'email' => $this->email,
                                        
                    'tel' => $this->tel,
                    'borne' => $this->borne,
                    'code_borne' => $this->code_borne,
                                        
                    'company_id' => $this->company_id,
                            
                    'company' => $this->Company->title,
                                        
                    'user_id' => $this->user_id,
                            
                    'user' => $this->User->name,
                                        
                    'created_at' => $this->created_at,
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>