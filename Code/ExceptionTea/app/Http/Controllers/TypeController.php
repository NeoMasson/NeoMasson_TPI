<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Contrôleur pour la gestion des types de thé
 * 
 * Ce contrôleur gère l'ensemble des opérations CRUD pour les types de thé.
 * Les types de thé sont des catégories fondamentales (vert, noir, blanc, etc.) 
 * qui servent de base pour la classification des thés dans le catalogue.
 * 
 * Toutes les méthodes retournent des réponses JSON pour faciliter
 * l'intégration avec l'interface utilisateur.
 */
class TypeController extends Controller
{
    /**
     * Enregistre un nouveau type de thé dans le catalogue
     * 
     * Cette méthode vérifie que :
     * - Le nom du type est unique dans la base de données
     * - Le nom respecte les contraintes de longueur
     * 
     * @param Request $request La requête contenant les données du nouveau type
     * @return JsonResponse Retourne le type créé avec un code 201 ou une erreur
     * 
     * @throws \Illuminate\Validation\ValidationException Si les données sont invalides
     */
    public function store(Request $request): JsonResponse
    {
        // Valider les données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:t_type,nom'
        ]);

        try {
            // Créer le nouveau type
            $type = Type::create([
                'nom' => $validated['nom']
            ]);

            return response()->json([
                'message' => 'Type créé avec succès',
                'type' => $type
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Met à jour les informations d'un type de thé existant
     * 
     * Cette méthode vérifie que :
     * - Le type existe dans la base de données
     * - Le nouveau nom est unique (sauf pour le type en cours de modification)
     * - Le nom respecte les contraintes de longueur
     * 
     * @param Request $request La requête contenant les nouvelles données
     * @param int $id L'identifiant du type à modifier
     * @return JsonResponse Retourne le type modifié ou une erreur
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si le type n'existe pas
     * @throws \Illuminate\Validation\ValidationException Si les données sont invalides
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Valider les données reçues
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:t_type,nom,' . $id . ',id_type'
        ]);

        try {
            $type = Type::findOrFail($id);
            $type->update([
                'nom' => $validated['nom']
            ]);

            return response()->json([
                'message' => 'Type mis à jour avec succès',
                'type' => $type
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime un type de thé du catalogue
     * 
     * Cette méthode vérifie que :
     * - Le type existe dans la base de données
     * - Le type n'est pas actuellement utilisé par des thés
     * 
     * @param int $id L'identifiant du type à supprimer
     * @return JsonResponse Retourne un message de succès ou une erreur
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si le type n'existe pas
     * @throws \Exception Si le type est encore utilisé par des thés
     */
    public function destroy($id): JsonResponse
    {
        try {
            $type = Type::findOrFail($id);
            $type->delete();

            return response()->json([
                'message' => 'Type supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression du type, vérifiez que celui-ci ne soit pas lié à un thé',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retourne la liste complète des types
     * Utilisé pour les mises à jour AJAX des listes déroulantes
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return response()->json(Type::all());
    }
}
