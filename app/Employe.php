<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Employe extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'nom', 'prenom', 'active','matricule','cardNo','departement_id'
    ];
    public function avatar(){
        return $this->HasOne(Media::class,'id','avatar_id');
    }
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('avatar');
    }
    public function Historiques()
    {
        return $this->hasMany('App\Historique', 'employe_id');
    }
    
    public function Departement()
    {
        return $this->belongsTo('App\Departement', 'departement_id');
    }
    public function Acceslevels()
    {
        return $this->hasMany('App\Acceslevel', 'employe_id');
    }
}
