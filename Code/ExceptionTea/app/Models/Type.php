<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $table = 't_type';
    protected $primaryKey = 'id_type';
    public $timestamps = false;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom'
    ];

    /**
     * Obtient tous les thés de ce type
     */
    public function thes(): HasMany
    {
        return $this->hasMany(The::class, 'fk_id_type', 'id_type');
    }
}