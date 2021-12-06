<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompagneResource extends JsonResource
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
                                        
                    'question' => $this->question,
                                        
                    'company_id' => $this->company_id,
                            
                    'company' => $this->Company->title,
                                        
                    'start_at' => $this->start_at,
                                        
                    'end_at' => $this->end_at,
                                        
                    'emploie' => $this->emploie,

                    'selectedbornes' => $this->SelectedBornes->pluck('borne_id'),
                    
                    'nbBornes' => $this->SelectedBornes->count(),
                                        
                    'created_at' => $this->created_at,
                                        
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>