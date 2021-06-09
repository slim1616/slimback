<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{

    public function employes(){
        return $this->hasMany('App\Employe', 'departement_id');
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