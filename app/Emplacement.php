<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Emplacement extends Model
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
                                                                                
            public function Company()
            {
                return $this->belongsTo('App\Company', 'company_id');
            }
                            
            public function User()
            {
                return $this->belongsTo('App\User', 'user_id');
            }
                                        
    
    } ?>