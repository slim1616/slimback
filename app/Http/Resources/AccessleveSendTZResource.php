<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class AccessleveSendTZResource extends JsonResource
{
    public function getDayByInt($num){
        switch ($num){
            case 0:
                return 'SUNDAY';
            case 1:
                return 'MONDAY';
            case 2:
                return 'TUESDAY';
            case 3:
                return 'WEDNESDAY';
            case 4:
                return 'THURSDAY';
            case 5:
                return 'FRIDAY';
            case 6:
                return 'SATURDAY';
            }
    }
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $plans = json_decode($this->Timezone->planning);
        // dd(json_decode($this->Timezone->planning));
        $tab = [];
        foreach ($plans as $key => $times) {
            if (count($times)>0){
                foreach ($times as $segment => $time) {
                    $start = Carbon::parse($time[0])->addMinutes(-$this->marge_entree)->format('H:i');
                    $end = Carbon::parse($time[1])->addMinutes(-1)->format('H:i');
                    $tab[] = array("day" => $this->getDayByInt($key),
                                    'time_segment' => strval($segment+1),
                                    "start_hour" => explode(':',$start)[0],
                                    "start_min" =>  explode(':',$start)[1],
                                    "end_hour" => explode(':',$end)[0],
                                    "end_min" =>  explode(':',$end)[1],
                                    
                                    
                                    ) ;
                }
            }
            // echo $this->getDayByInt($key);
        }

        return [
            'addr' => $this->Porte->ip,
            'timezoneid' => strval($this->timezone_id),
            'porte_id' =>  "1",
            'password' => is_null($this->Porte->password)?'': $this->Porte->password,
            'sequence' => $tab,
        ];
        
    }
}
