<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant un type de thé
 * 
 * Ce modèle gère les différentes catégories de thés (vert, noir, blanc, etc.)
 * Il sert de classification principale pour les thés du catalogue
 */
class Type extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 't_type';

    /**
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'id_type';

    /**
     * Désactive les timestamps automatiques (created_at, updated_at)
     * @var bool
     */
    public $timestamps = false;

    /**
     * Liste des attributs qui peuvent être assignés en masse via create() ou update()
     * 
     * @var array
     */
    protected $fillable = [
        'nom'  // Nom du type de thé (ex: vert, noir, blanc)
    ];

    /**
     * Relation one-to-many avec le modèle The
     * Permet d'accéder à tous les thés appartenant à ce type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thes(): HasMany
    {
        return $this->hasMany(The::class, 'fk_id_type', 'id_type');
    }
}