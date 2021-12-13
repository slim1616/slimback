<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Formule;

class UserResourceSec extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->Company->Abonnements);
        $user = $request->user();
        if ($user->Role->slug=='superadmin'){
            $currentAbonnement = null;
            $currentFormule = null;
        }else{
            $abonnement = $this->Company->Abonnements->last();
            if ($abonnement){
                // if ($abonnement->Formule->id==1){
                //     $currentAbonnement = $abonnement;
                //     $currentFormule = $abonnement->Formule;
                // }else{
                    if ($abonnement->start_at&&$abonnement->end_at){
                        $start = Carbon::createFromFormat('Y-m-d', $abonnement->start_at);
                        $end = Carbon::createFromFormat('Y-m-d', $abonnement->end_at);
                        if (Carbon::now()->between($start,$end)){
                            $currentAbonnement = $abonnement;
                            $currentFormule = $abonnement->Formule;
                        }else{
                            $currentAbonnement = null;
                            $currentFormule = null;
                        }
                    }else{
                        $currentAbonnement = $abonnement;
                        $currentFormule = $abonnement->Formule;
                    }
                // }
            }
        }



        // dd($this->Company);
        return [
            'id' => $this->id,
            // 'name' => !is_null($this->name),
            'company_id' => $this->company_id,
            'company' => !is_null($this->Company)? $this->Company->title :'',
            'email' => $this->email,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'name' => $this->name,
            'birthday' => $this->birthday,
            'adress' => $this->adress,
            'phone' => $this->phone,
            'sexe' => $this->sexe,
            'fonction' => $this->fonction,
            'role' => $this->Role->slug,
            'role_id' => $this->role_id,
            'active' =>   $this->active==1 ? true : false,
            'avatar_id' => $this->avatar_id,
            'avatar' => $this->avatar?$this->avatar->getUrl('avatar'):'',
            'currentAbonnement' => $currentAbonnement,
            'currentFormule' => $currentFormule
            // 'abonnements' => $this->Company->Abonnements->last(),
        ];
    }
}
