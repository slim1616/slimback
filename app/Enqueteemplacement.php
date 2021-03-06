<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enqueteemplacement extends Model
{
    use SoftDeletes;
    protected $table = 'enqueteemplacements';
    protected $guarded = [];
    /**
     * Get the Enquete that owns the Enqueteemplacement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Enquete()
    {
        return $this->belongsTo(Enquete::class, 'enqueste_id');
    }

    /**
     * Get the Emplacement that owns the Enqueteemplacement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Emplacement()
    {
        return $this->belongsTo(Emplacement::class, 'emplacement_id');
    }
}
