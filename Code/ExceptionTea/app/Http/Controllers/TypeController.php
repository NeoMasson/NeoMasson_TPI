<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Contrôleur pour gérer les types de thé
 */
class TypeController extends Controller
{
    /**
     * Enregistrer un nouveau type
     *
     * @param Request $request
     * @return JsonResponse
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
     * Mettre à jour un type existant
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
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
     * Supprimer un type
     *
     * @param int $id
     * @return JsonResponse
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
}
