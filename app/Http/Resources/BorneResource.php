<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorneResource extends JsonResource
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
                                        
                    'code_borne' => $this->code_borne,
                                        
                    'ip' => $this->ip,
                                        
                    'lat' => $this->lat,
                                        
                    'lng' => $this->lng,
                                        
                    'company_id' => $this->company_id,
                            
                    'company' => $this->Company->title,
                                        
                    'created_at' => $this->created_at,
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>