<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choixquestion extends Model
{
    protected $table = 'choixquestions';
    protected $guarded = [];
    
    protected $casts = [
        'questions' => 'array'
    ];
    public function sectionnable(){
        return $this->morphOne('App\Section', 'sectionnable');
    }
}
