<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Singlereponse extends Model
{
    protected $casts = [
        'reponse' => 'array'
    ];
    /**
     * Get the Reponse that owns the Singlereponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Reponse()
    {
        return $this->belongsTo(Reponse::class, 'reponse_id');
    }
}
