<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

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
                                                                                                        
            public function User()
            {
                return $this->belongsTo('App\User', 'user_id');
            }
                                        
            public function Emplacements(){
                return $this->hasMany('App\Emplacement');
            }
            public function Abonnements(){
                return $this->hasMany('App\Abonnement');
            }
        
            public function Users(){
                return $this->hasMany('App\User');
            }
        
        
            public function Enquetes(){
                return $this->hasMany('App\Enquete');
            }
        
            public function Questions(){
                return $this->hasMany('App\Question');
            }
        
    
    } ?>