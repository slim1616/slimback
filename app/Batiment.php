<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{
    public function Zones()
    {
        return $this->hasMany('App\Zone', 'batiment_id');
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