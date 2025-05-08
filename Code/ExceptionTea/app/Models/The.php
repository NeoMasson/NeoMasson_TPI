<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class The extends Model
{
    protected $table = 't_the';
    protected $primaryKey = 'id_the';
    public $timestamps = false;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom',
        'preparation',
        'description',
        'quantite',
        'prix',
        'date_recolte',
        'fk_id_provenance',
        'fk_id_type',
        'fk_id_variete'
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs
     */
    protected $casts = [
        'prix' => 'decimal:2',
        'date_recolte' => 'date'
    ];

    /**
     * Obtient la provenance du thé
     */
    public function provenance(): BelongsTo
    {
        return $this->belongsTo(Provenance::class, 'fk_id_provenance', 'id_provenance');
    }

    /**
     * Obtient le type du thé
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'fk_id_type', 'id_type');
    }

    /**
     * Obtient la variété du thé
     */
    public function variete(): BelongsTo
    {
        return $this->belongsTo(Variete::class, 'fk_id_variete', 'id_variete');
    }

    /**
     * Obtient toutes les listes contenant ce thé
     */
    public function listes(): BelongsToMany
    {
        return $this->belongsToMany(Liste::class, 't_contient', 'fk_id_the', 'fk_id_liste');
    }
}