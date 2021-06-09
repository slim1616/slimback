<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{

    public function Batiment()
    {
        return $this->belongsTo('App\Batiment', 'batiment_id');
    }
    public function Portes()
    {
        return $this->hasMany('App\Porte', 'zone_id');
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