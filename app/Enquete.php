<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquete extends Model
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
                                                                
            
            public function Questions(){
                return $this->hasMany('App\Question');
            }
            /**
             * Get all of the Enqueteemplacement for the Enquete
             *
             * @return \Illuminate\Database\Eloquent\Relations\HasMany
             */
            public function Enqueteemplacements()
            {
                return $this->hasMany(Enqueteemplacement::class, 'enquete_id');
            }
            /**
             * Get all of the Sections for the Enquete
             *
             * @return \Illuminate\Database\Eloquent\Relations\HasMany
             */
            public function Sections()
            {
                return $this->hasMany(Section::class, 'enquete_id');
            }

            public function Reponses()
            {
                return $this->hasMany(Reponse::class, 'enquete_id');
            }
        
    
    } ?>