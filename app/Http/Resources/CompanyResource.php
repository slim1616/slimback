<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
                                        
                    'type' => $this->type,
                                        
                    'adresse' => $this->adresse,
                                        
                    'email' => $this->email,
                                        
                    'tel' => $this->tel,
                    'logo' => !is_null($this->logo)? 'storage/'.$this->logo : "",
                                        
                    'codetva' => $this->codetva,
                                        
                    'user_id' => $this->user_id,
                            
                    'user' => $this->User->name,
                                        
                    'created_at' => $this->created_at,
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>