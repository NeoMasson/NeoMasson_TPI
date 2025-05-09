<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modèle représentant une liste de thés
 * 
 * Ce modèle permet de gérer des collections personnalisées de thés, avec :
 * - Un nom descriptif pour la liste
 * - Une date de création
 * - Une relation many-to-many avec les thés via une table pivot
 */
class Liste extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 't_liste';

    /**
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'id_liste';

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
        'nom',            // Nom de la liste
        'date_creation'   // Date de création de la liste
    ];

    /**
     * Définition des conversions de type pour certains attributs
     * 
     * @var array
     */
    protected $casts = [
        'date_creation' => 'datetime'  // Conversion automatique en objet Carbon
    ];

    /**
     * Relation many-to-many avec le modèle The
     * Permet d'accéder aux thés contenus dans la liste via la table pivot t_contient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function thes(): BelongsToMany
    {
        return $this->belongsToMany(The::class, 't_contient', 'fk_id_liste', 'fk_id_the');
    }
}