<?php

namespace App\Http\Controllers;

use App\Models\Categorie_materiel;
use Illuminate\Http\Request;

class CategorieMaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Categorie_materiel::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_categorie' => 'required|string|max:100|unique:categorie_materiels,nom_categorie',
        ]);

        $categorie_materiel = Categorie_materiel::create($request->only('nom_categorie'));
        return response()->json($categorie_materiel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie_materiel $categorie_materiel)
    {
        return response()->json($categorie_materiel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie_materiel $categorie_materiel)
    {
        $request->validate([
            'nom_categorie' => 'required|string|max:100|unique:categorie_materiels,nom_categorie,' . $categorie_materiel->id,
        ]);

        $categorie_materiel->update($request->only('nom_categorie'));

        return response()->json($categorie_materiel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie_materiel $categorie_materiel)
    {
        $categorie_materiel->delete();
        return response()->json(['message' => 'Catégorie de matériel supprimée avec succès']);
    }
}
