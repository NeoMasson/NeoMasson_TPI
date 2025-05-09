<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant une variété de thé
 * 
 * Ce modèle gère les différentes variétés de thés, permettant une
 * classification plus fine que le type. Une variété est une sous-catégorie
 * qui peut exister dans différents types de thés.
 */
class Variete extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 't_variete';

    /**
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'id_variete';

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
        'nom'  // Nom de la variété de thé
    ];

    /**
     * Relation one-to-many avec le modèle The
     * Permet d'accéder à tous les thés de cette variété spécifique
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thes(): HasMany
    {
        return $this->hasMany(The::class, 'fk_id_variete', 'id_variete');
    }
}