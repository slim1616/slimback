<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reponse extends Model
{
    use SoftDeletes;
    /**
     * Get all of the Reponses for the Reponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Reponses()
    {
        return $this->hasMany(Singlereponse::class, 'reponse_id');
    }
}
