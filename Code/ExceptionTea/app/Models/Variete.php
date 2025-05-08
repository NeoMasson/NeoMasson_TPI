<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variete extends Model
{
    protected $table = 't_variete';
    protected $primaryKey = 'id_variete';
    public $timestamps = false;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom'
    ];

    /**
     * Obtient tous les thés de cette variété
     */
    public function thes(): HasMany
    {
        return $this->hasMany(The::class, 'fk_id_variete', 'id_variete');
    }
}