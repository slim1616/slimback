<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iconquestion extends Model
{
    protected $table = 'iconquestions';
    protected $guarded = [];
    
    protected $casts = [
        'questions' => 'array'
    ];
    public function sectionnable(){
        return $this->morphOne('App\Section', 'sectionnable');
    }
}
