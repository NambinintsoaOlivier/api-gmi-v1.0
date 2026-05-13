<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Http\Requests\StoreAffectationRequest;
use App\Http\Requests\UpdateAffectationRequest;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Affectation::with(['utilisateur', 'materiel']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('utilisateur', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('materiel', fn($q) => $q->where('modele', 'like', "%{$search}%"));
            });
        }

        $affectations = $query->orderBy('id', 'desc')->paginate(7);

        return response()->json($affectations);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function getAffectations(Request $request)
    {
        // On prépare la requête SANS mettre get()
        $affectations = Affectation::select([
            'id',
            'utilisateur_id',
            'materiel_id',
            'date_affectation',
            'date_retour',
            'status'
        ])
            ->with([
                'utilisateur:id,nom_utilisateur,fonction_utilisateur,telephone',
                'materiel:id,modele,description,marque_id,categorie_materiel_id,type_materiel_id',
                'materiel.marque:id,nom_marque',
                'materiel.categorieMateriel:id,nom_categorie',
                'materiel.typesMateriel:id,nom_type'
            ])
            ->orderBy('id', 'desc') // On trie avant de paginer
            ->paginate(7); // Paginate exécute la requête automatiquement

        return response()->json($affectations);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'materiel_id' => 'required|exists:materiels,id',
            'date_affectation' => 'required|date',
            'date_retour' => 'nullable|date|after_or_equal:date_affectation',
            'status' => 'required|string|max:50',
        ]);

        $affectation = Affectation::create($validated);

        return response()->json([
            'message' => 'Affectation créée avec succès',
            'data' => $affectation->load(['utilisateur', 'materiel'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Affectation $affectation)
    {
        return response()->json([
            'message' => 'Affectation récupérée avec succès',
            'data' => $affectation->load(['utilisateur', 'materiel'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Affectation $affectation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Affectation $affectation)
    {
        $validated = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'materiel_id' => 'required|exists:materiels,id',
            'date_affectation' => 'required|date',
            'date_retour' => 'nullable|date|after_or_equal:date_affectation',
            'status' => 'required|string|max:50',
        ]);

        $affectation->update($validated);

        return response()->json([
            'message' => 'Affectation mise à jour avec succès',
            'data' => $affectation->load(['utilisateur', 'materiel'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Affectation $affectation)
    {
        $affectation->delete();

        return response()->json([
            'message' => 'Affectation supprimée avec succès'
        ], 204);
    }
}
