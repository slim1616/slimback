<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Porte extends Model
{
    public function Zone()
    {
        return $this->belongsTo('App\Zone', 'zone_id');
    }
    public function Batiment()
    {
        return $this->belongsTo('App\Batiment', 'batiment_id');
    }
    public function Acceslevels()
    {
        return $this->hasMany('App\Acceslevel', 'porte_id');
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