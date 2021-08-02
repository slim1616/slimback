<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted(){
        static::creating(function($emplacement){
            $emplacement->id = (string) Str::uuid();
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var  array
     */
    protected $casts = [
        ''
    ];
  
    /**
     * Get all of the comments for the Emplacement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function EnqueteEmplacements()
    {
        return $this->hasMany('App\EnqueteEmplacement', 'emplacement_id');
    }                                                                      
    public function Company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
                    
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
                                        
    
    } ?>