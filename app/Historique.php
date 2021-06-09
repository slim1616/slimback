<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    // protected $table = 'historiques';
    public function Employe()
    {
        return $this->belongsTo('App\Employe', 'employe_id');
    }
    public function Porte()
    {
        return $this->belongsTo('App\Porte', 'porte_id');
    }
    public function Batiment()
    {
        return $this->belongsTo('App\Batiment', 'batiment_id');
    }
    public function Zone()
    {
        return $this->belongsTo('App\Zone', 'zone_id');
    }
    public function Departement()
    {
        return $this->belongsTo('App\Departement', 'departement_id');
    }
}
