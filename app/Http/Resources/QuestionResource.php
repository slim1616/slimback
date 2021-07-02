<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
                    'label' => $this->Sectionnable->label,
                    'label' => $this->Sectionnable->label,
                    'typeIcon' => $this->type=='icons' ? $this->Sectionnable->typeIcon : null,
                    'typeinput' => $this->type=='choix' ? $this->Sectionnable->typeinput : null,
                    'textquestion' => $this->Sectionnable->textquestion,
                    'questions' => $this->Sectionnable->questions,
                    'question_type' => $this->type,
                    'order' => $this->order,
                    'status' => $this->status,
                    'obligatoire' => $this->obligatoire==1?true:false,
                    'icon' => '',       
                    'company_id' => $this->company_id,
                    'user_id' => $this->user_id,
                    'enquete_id' => $this->enquete_id,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                                        ];
    }
}
 ?>