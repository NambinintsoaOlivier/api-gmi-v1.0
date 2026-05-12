<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return response()->json(Materiel::with(['categorieMateriel', 'marque', 'typesMateriel'])->paginate(2));

        $query = Materiel::with(['typesMateriel', 'marque', 'categorieMateriel']);

        // Recherche instantanée
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            // Version optimisée avec whereLike (Laravel 11+)
            $query->where(function ($q) use ($search) {
                $q->where('modele', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('etat', 'like', "%{$search}%")
                    ->orWhereHas('marque', fn($q) => $q->where('nom_marque', 'like', "%{$search}%"))
                    ->orWhereHas('typesMateriel', fn($q) => $q->where('nom_type', 'like', "%{$search}%"))
                    ->orWhereHas('categorieMateriel', fn($q) => $q->where('nom_categorie', 'like', "%{$search}%"));
            });
        }

        // Pagination (10 par page)
        $materiels = $query->orderBy('id', 'desc')->paginate(7);

        return response()->json($materiels);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'modele' => 'required|string|max:255',
            'description' => 'nullable|string',
            'etat' => 'required|string|max:50',
            'categorie_materiel_id' => 'required|exists:categorie_materiels,id',
            'marque_id' => 'required|exists:marques,id',
            'type_materiel_id' => 'required|exists:types_materiels,id',
        ]);

        // Ajouter l'user_id
        $validated['user_id'] = Auth::id();

        // Vérifier si l'utilisateur est connecté
        if (!$validated['user_id']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $materiel = Materiel::create($validated);

        return response()->json([
            'status' => 'created',
            'message' => 'Matériel créé avec succès',
            'data' => $materiel
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Materiel $materiel)
    {
        return response()->json($materiel->load(['categorieMateriel', 'marque', 'typesMateriel']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materiel $materiel)
    {
        $request->validate([
            'modele' => 'required|string|max:255',
            'description' => 'nullable|string',
            'etat' => 'required|string|max:50',
            'categorie_materiel_id' => 'required|exists:categorie_materiels,id',
            'marque_id' => 'required|exists:marques,id',
            'type_materiel_id' => 'required|exists:types_materiels,id',
        ]);

        $materiel->update($request->only('modele', 'description', 'etat', 'categorie_materiel_id', 'marque_id', 'type_materiel_id'));

        return response()->json($materiel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materiel $materiel)
    {
        $materiel->delete();
        return response()->json(['message' => 'Matériel supprimé avec succès']);
    }
}
