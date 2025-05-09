<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modèle représentant un thé dans le catalogue
 * 
 * Ce modèle gère les informations relatives à chaque thé, incluant :
 * - Ses caractéristiques (nom, description, préparation)
 * - Ses données quantitatives (prix, quantité)
 * - Ses relations avec d'autres entités (type, variété, provenance)
 * - Son appartenance à différentes listes
 */
class The extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 't_the';

    /**
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'id_the';

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
        'nom',           // Nom du thé
        'preparation',   // Instructions de préparation
        'description',   // Description détaillée
        'quantite',      // Quantité disponible
        'prix',         // Prix unitaire
        'date_recolte', // Date de récolte du thé
        'fk_id_provenance', // Clé étrangère vers la provenance
        'fk_id_type',       // Clé étrangère vers le type
        'fk_id_variete'     // Clé étrangère vers la variété
    ];

    /**
     * Définition des conversions de type pour certains attributs
     * 
     * @var array
     */
    protected $casts = [
        'prix' => 'decimal:2',      // Prix avec 2 décimales
        'date_recolte' => 'date'    // Conversion automatique en objet Carbon
    ];

    /**
     * Relation avec le modèle Provenance
     * Définit d'où provient le thé (pays, région)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provenance(): BelongsTo
    {
        return $this->belongsTo(Provenance::class, 'fk_id_provenance', 'id_provenance');
    }

    /**
     * Relation avec le modèle Type
     * Définit le type de thé (vert, noir, blanc, etc.)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'fk_id_type', 'id_type');
    }

    /**
     * Relation avec le modèle Variete
     * Définit la variété spécifique du thé
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variete(): BelongsTo
    {
        return $this->belongsTo(Variete::class, 'fk_id_variete', 'id_variete');
    }

    /**
     * Relation avec le modèle Liste
     * Définit l'appartenance du thé à différentes listes via la table pivot t_contient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listes(): BelongsToMany
    {
        return $this->belongsToMany(Liste::class, 't_contient', 'fk_id_the', 'fk_id_liste');
    }
}