<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;
    public function sectionnable(){
        return $this->morphTo();
    }

    public function Company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function Enquete()
    {
        return $this->belongsTo('App\Enquete', 'enquete_id');
    }
    public function UsEmplacementer()
    {
        return $this->belongsTo('App\Emplacement', 'emplacement_id');
    }
}
