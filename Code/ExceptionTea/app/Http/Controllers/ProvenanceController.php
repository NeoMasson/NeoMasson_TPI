<?php

namespace App\Http\Controllers;

use App\Models\Provenance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Contrôleur pour la gestion des provenances de thé
 * 
 * Ce contrôleur gère l'ensemble des opérations CRUD pour les provenances de thé.
 * Les provenances représentent l'origine géographique des thés (pays, région) et 
 * sont essentielles pour la traçabilité et la qualité des produits.
 * 
 * Toutes les méthodes retournent des réponses JSON pour faciliter
 * l'intégration avec l'interface utilisateur.
 */
class ProvenanceController extends Controller
{
    /**
     * Enregistre une nouvelle provenance de thé dans le catalogue
     * 
     * Cette méthode vérifie que :
     * - Le nom de la provenance est unique dans la base de données
     * - Le nom respecte les contraintes de longueur
     * 
     * @param Request $request La requête contenant les données de la nouvelle provenance
     * @return JsonResponse Retourne la provenance créée avec un code 201 ou une erreur
     * 
     * @throws \Illuminate\Validation\ValidationException Si les données sont invalides
     */
    public function store(Request $request): JsonResponse
    {
        // Valider les données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:t_provenance,nom'
        ]);

        try {
            // Créer la nouvelle provenance
            $provenance = Provenance::create([
                'nom' => $validated['nom']
            ]);

            return response()->json([
                'message' => 'Provenance créée avec succès',
                'provenance' => $provenance
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la provenance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Met à jour les informations d'une provenance de thé existante
     * 
     * Cette méthode vérifie que :
     * - La provenance existe dans la base de données
     * - Le nouveau nom est unique (sauf pour la provenance en cours de modification)
     * - Le nom respecte les contraintes de longueur
     * 
     * @param Request $request La requête contenant les nouvelles données
     * @param int $id L'identifiant de la provenance à modifier
     * @return JsonResponse Retourne la provenance modifiée ou une erreur
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si la provenance n'existe pas
     * @throws \Illuminate\Validation\ValidationException Si les données sont invalides
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Valider les données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:t_provenance,nom,' . $id . ',id_provenance'
        ]);

        try {
            $provenance = Provenance::findOrFail($id);
            $provenance->update([
                'nom' => $validated['nom']
            ]);

            return response()->json([
                'message' => 'Provenance mise à jour avec succès',
                'provenance' => $provenance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la provenance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime une provenance de thé du catalogue
     * 
     * Cette méthode vérifie que :
     * - La provenance existe dans la base de données
     * - La provenance n'est pas actuellement utilisée par des thés
     * 
     * @param int $id L'identifiant de la provenance à supprimer
     * @return JsonResponse Retourne un message de succès ou une erreur
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si la provenance n'existe pas
     * @throws \Exception Si la provenance est encore utilisée par des thés
     */
    public function destroy($id): JsonResponse
    {
        try {
            $provenance = Provenance::findOrFail($id);
            $provenance->delete();

            return response()->json([
                'message' => 'Provenance supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la provenance, vérifiez que celle-ci ne soit pas liée à un thé',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retourne la liste complète des provenances
     * Utilisé pour les mises à jour AJAX des listes déroulantes
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return response()->json(Provenance::all());
    }
}
