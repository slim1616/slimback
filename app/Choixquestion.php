<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Choixquestion extends Model
{
    use SoftDeletes;
    protected $table = 'choixquestions';
    protected $guarded = [];
    
    protected $casts = [
        'questions' => 'array'
    ];
    public function sectionnable(){
        return $this->morphOne('App\Section', 'sectionnable');
    }
}
