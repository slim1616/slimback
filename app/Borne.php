<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Borne extends Model
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
                                        
            
            public function Bornesreponses(){
                return $this->hasMany('App\Bornesreponse');
            }
            /**
             * Get all of the Comapagnes for the Borne
             *
             * @return \Illuminate\Database\Eloquent\Relations\HasMany
             */
            public function Comapagnes()
            {
                return $this->hasMany(Compagneborne::class, 'borne_id');
            }
        
    
    } ?>