<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Singlereponse extends Model
{
    use SoftDeletes;
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
