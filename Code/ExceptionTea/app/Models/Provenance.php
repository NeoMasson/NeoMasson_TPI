<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provenance extends Model
{
    protected $table = 't_provenance';
    protected $primaryKey = 'id_provenance';
    public $timestamps = false;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom'
    ];

    /**
     * Obtient tous les thés associés à cette provenance
     */
    public function thes(): HasMany
    {
        return $this->hasMany(The::class, 'fk_id_provenance', 'id_provenance');
    }
}