<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant la provenance d'un thé
 * 
 * Ce modèle gère les informations sur l'origine géographique des thés,
 * permettant de catégoriser les thés selon leur pays ou région de production.
 * La provenance est un facteur important qui influence les caractéristiques
 * et la qualité du thé.
 */
class Provenance extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 't_provenance';

    /**
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'id_provenance';

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
        'nom'  // Nom du pays ou de la région de provenance
    ];

    /**
     * Relation one-to-many avec le modèle The
     * Permet d'accéder à tous les thés provenant de cette origine
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thes(): HasMany
    {
        return $this->hasMany(The::class, 'fk_id_provenance', 'id_provenance');
    }
}