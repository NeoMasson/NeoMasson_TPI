<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\The;
use App\Models\Type;
use App\Models\Variete;
use App\Models\Provenance;
use App\Models\Liste;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Tests unitaires pour vérifier les relations du modèle The
 * 
 * Cette classe vérifie que les relations du modèle The sont correctement
 * définies et fonctionnelles, notamment:
 * - Relations BelongsTo avec Type, Variete, et Provenance
 * - Relation BelongsToMany avec Liste
 */
class TheRelationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste que la relation avec le Type est correctement définie
     *
     * @return void
     */
    public function test_relation_type()
    {
        // Vérifie que la méthode type() existe et retourne une relation BelongsTo
        $the = new The();
        $this->assertInstanceOf(BelongsTo::class, $the->type());
        
        // Vérifie que la relation est configurée avec les bonnes clés
        $relation = $the->type();
        $this->assertEquals('fk_id_type', $relation->getForeignKeyName());
        $this->assertEquals('id_type', $relation->getOwnerKeyName());
    }

    /**
     * Teste que la relation avec la Variété est correctement définie
     *
     * @return void
     */
    public function test_relation_variete()
    {
        // Vérifie que la méthode variete() existe et retourne une relation BelongsTo
        $the = new The();
        $this->assertInstanceOf(BelongsTo::class, $the->variete());
        
        // Vérifie que la relation est configurée avec les bonnes clés
        $relation = $the->variete();
        $this->assertEquals('fk_id_variete', $relation->getForeignKeyName());
        $this->assertEquals('id_variete', $relation->getOwnerKeyName());
    }

    /**
     * Teste que la relation avec la Provenance est correctement définie
     *
     * @return void
     */
    public function test_relation_provenance()
    {
        // Vérifie que la méthode provenance() existe et retourne une relation BelongsTo
        $the = new The();
        $this->assertInstanceOf(BelongsTo::class, $the->provenance());
        
        // Vérifie que la relation est configurée avec les bonnes clés
        $relation = $the->provenance();
        $this->assertEquals('fk_id_provenance', $relation->getForeignKeyName());
        $this->assertEquals('id_provenance', $relation->getOwnerKeyName());
    }

    /**
     * Teste que la relation avec les Listes est correctement définie
     *
     * @return void
     */
    public function test_relation_listes()
    {
        // Vérifie que la méthode listes() existe et retourne une relation BelongsToMany
        $the = new The();
        $this->assertInstanceOf(BelongsToMany::class, $the->listes());
        
        // Vérifie que la relation est configurée avec les bonnes clés et table pivot
        $relation = $the->listes();
        $this->assertEquals('t_contient', $relation->getTable());
        $this->assertEquals('fk_id_the', $relation->getForeignPivotKeyName());
        $this->assertEquals('fk_id_liste', $relation->getRelatedPivotKeyName());
    }
}