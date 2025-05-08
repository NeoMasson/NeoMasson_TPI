<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Liste extends Model
{
    protected $table = 't_liste';
    protected $primaryKey = 'id_liste';
    public $timestamps = false;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom',
        'date_creation'
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs
     */
    protected $casts = [
        'date_creation' => 'datetime'
    ];

    /**
     * Obtient tous les thés contenus dans cette liste
     */
    public function thes(): BelongsToMany
    {
        return $this->belongsToMany(The::class, 't_contient', 'fk_id_liste', 'fk_id_the');
    }
}