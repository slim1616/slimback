<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iconquestion extends Model
{
    use SoftDeletes;
    protected $table = 'iconquestions';
    protected $guarded = [];
    
    protected $casts = [
        'questions' => 'array'
    ];
    public function sectionnable(){
        return $this->morphOne('App\Section', 'sectionnable');
    }
}
