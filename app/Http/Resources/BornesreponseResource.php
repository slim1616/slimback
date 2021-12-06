<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BornesreponseResource extends JsonResource
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
                                        
                    'company_id' => $this->company_id,
                            
                    'company' => $this->Company->title,
                                        
                    'borne_id' => $this->borne_id,
                            
                    'borne' => $this->Borne->title,
                                        
                    'code_borne' => $this->code_borne,
                                        
                    'resp' => $this->resp,
                                        
                    'created_at' => $this->created_at,
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>