<?php

namespace App\Http\Controllers;

use App\Models\Variete;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Contrôleur pour gérer les variétés de thé
 */
class VarieteController extends Controller
{
    /**
     * Enregistrer une nouvelle variété
     *
     * @param Request $request
     * @return JsonResponse
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
     * Mettre à jour une variété existante
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
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
     * Supprimer une variété
     *
     * @param int $id
     * @return JsonResponse
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
}
