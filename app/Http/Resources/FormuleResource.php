<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormuleResource extends JsonResource
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
                                        
                    'online' => $this->online,
                                        
                    'price' => $this->price,
                                        
                    'nbsurvey' => $this->nbsurvey,
                    'nbmois' => $this->nbmois,
                                        
                    'nbsemplacements' => $this->nbsemplacements,
                                        
                    'created_at' => $this->created_at,
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>