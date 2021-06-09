<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{

    public function Acceslevels()
    {
        return $this->hasMany('App\Acceslevel', 'timezone_id');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var  array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var  array
     */
    protected $casts = [
        ''
    ];
} ?>