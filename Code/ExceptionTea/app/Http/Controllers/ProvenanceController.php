<?php

namespace App\Http\Controllers;

use App\Models\Provenance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Contrôleur pour gérer les provenances de thé
 */
class ProvenanceController extends Controller
{
    /**
     * Enregistrer une nouvelle provenance
     *
     * @param Request $request
     * @return JsonResponse
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
     * Mettre à jour une provenance existante
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
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
     * Supprimer une provenance
     *
     * @param int $id
     * @return JsonResponse
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
}
