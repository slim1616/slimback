<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
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
            /**
             * Get all of the Compagnes for the Company
             *
             * @return \Illuminate\Database\Eloquent\Relations\HasMany
             */
            public function Compagnes()
            {
                return $this->hasMany(Compagne::class, 'company_id');
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
            /**
             * Get all of the Bornes for the Company
             *
             * @return \Illuminate\Database\Eloquent\Relations\HasMany
             */
            public function Bornes()
            {
                return $this->hasMany(Borne::class, 'company_id');
            }
            /**
             * Get all of the ActifBornes for the Company
             *
             * @return \Illuminate\Database\Eloquent\Relations\HasMany
             */
            public function ActifBornes()
            {
                return $this->hasMany(Compagneborne::class, 'company_id');
            }
        
    
    } ?>