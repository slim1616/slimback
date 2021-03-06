<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable 
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * Get the Company that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
    public function Role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }
   
    /**
     * Get all of the Enquetes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Enquetes()
    {
        return $this->hasMany(Enquete::class, 'user_id');
    }
    public function Abonnements(){
        return $this->hasMany('App\Abonnement');
    }
    public function getLastAbonnementsAttribute(){
        if ($this->Company){
            $abonnement = $this->Company->Abonnements->last();
            if ($abonnement->Formule->id==1){
                return $abonnement->Formule->title;
            }else{
                if ($abonnement->start_at&&$abonnement->end_at){
                    $start = Carbon::createFromFormat('Y-m-d', $abonnement->start_at);
                    $end = Carbon::createFromFormat('Y-m-d', $abonnement->end_at);
                    if (Carbon::now()->between($start,$end)){
                        return $abonnement->Formule->title;
                    }else{
                        $currentFormule = Formule::find(1);
                        return $currentFormule->title;
                    }
                }else{
                    return $abonnement->Formule->title;
                }
            }
        }else{
            return '';
        }
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'nom','prenom'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
