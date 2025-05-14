<?php

namespace App\Http\Controllers;

use App\Models\Variete;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Contrôleur pour la gestion des variétés de thé
 * 
 * Ce contrôleur gère l'ensemble des opérations CRUD pour les variétés de thé.
 * 
 * Toutes les méthodes retournent des réponses JSON pour faciliter
 * l'intégration avec l'interface utilisateur.
 */
class VarieteController extends Controller
{
    /**
     * Enregistre une nouvelle variété de thé dans le catalogue
     * 
     * Cette méthode vérifie que :
     * - Le nom de la variété est unique dans la base de données
     * - Le nom respecte les contraintes de longueur
     * 
     * @param Request $request La requête contenant les données de la nouvelle variété
     * @return JsonResponse Retourne la variété créée avec un code 201 ou une erreur
     * 
     * @throws \Illuminate\Validation\ValidationException Si les données sont invalides
     */
    public function store(Request $request): JsonResponse
    {
        // Valider les données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:t_variete,nom'
        ]);

        try {
            // Créer la nouvelle variété
            $variete = Variete::create([
                'nom' => $validated['nom']
            ]);

            return response()->json([
                'message' => 'Variété créée avec succès',
                'variete' => $variete
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la variété',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Met à jour les informations d'une variété de thé existante
     * 
     * Cette méthode vérifie que :
     * - La variété existe dans la base de données
     * - Le nouveau nom est unique (sauf pour la variété en cours de modification)
     * - Le nom respecte les contraintes de longueur
     * 
     * @param Request $request La requête contenant les nouvelles données
     * @param int $id L'identifiant de la variété à modifier
     * @return JsonResponse Retourne la variété modifiée ou une erreur
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si la variété n'existe pas
     * @throws \Illuminate\Validation\ValidationException Si les données sont invalides
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Valider les données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:t_variete,nom,' . $id . ',id_variete'
        ]);

        try {
            $variete = Variete::findOrFail($id);
            $variete->update([
                'nom' => $validated['nom']
            ]);

            return response()->json([
                'message' => 'Variété mise à jour avec succès',
                'variete' => $variete
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la variété',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime une variété de thé du catalogue
     * 
     * Cette méthode vérifie que :
     * - La variété existe dans la base de données
     * - La variété n'est pas actuellement utilisée par des thés
     * 
     * @param int $id L'identifiant de la variété à supprimer
     * @return JsonResponse Retourne un message de succès ou une erreur
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si la variété n'existe pas
     * @throws \Exception Si la variété est encore utilisée par des thés
     */
    public function destroy($id): JsonResponse
    {
        try {
            $variete = Variete::findOrFail($id);
            $variete->delete();

            return response()->json([
                'message' => 'Variété supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la variété, vérifiez que celle-ci ne soit pas liée à un thé',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retourne la liste complète des variétés
     * Utilisé pour les mises à jour AJAX des listes déroulantes
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return response()->json(Variete::all());
    }
}
