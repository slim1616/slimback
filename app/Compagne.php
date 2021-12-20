<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compagne extends Model
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
             /**
              * Get all of the SelectedBornes for the Compagne
              *
              * @return \Illuminate\Database\Eloquent\Relations\HasMany
              */
             public function SelectedBornes()
             {
                 return $this->hasMany(Compagneborne::class, 'compagne_id');
             }
            public function Company()
            {
                return $this->belongsTo('App\Company', 'company_id');
            }
                                                                            
    
    } ?>