<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceslevel extends Model
{
    public function Porte()
    {
        return $this->belongsTo('App\Porte', 'porte_id');
    }

    public function Employe()
    {
        return $this->belongsTo('App\Employe', 'employe_id');
    }

    public function EmployeActive(){
        return $this->Employe->active ? $this : '';
    }

    public function Timezone()
    {
        return $this->belongsTo('App\Timezone', 'timezone_id');
    }
}
