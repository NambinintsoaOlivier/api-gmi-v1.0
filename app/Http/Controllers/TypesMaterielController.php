<?php

namespace App\Http\Controllers;

use App\Models\Types_materiel;
use Illuminate\Http\Request;

class TypesMaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Types_materiel::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_type' => 'required|string|max:100|unique:types_materiels,nom_type',
        ]);

        $types_materiel = Types_materiel::create($request->only('nom_type'));
        return response()->json($types_materiel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Types_materiel $types_materiel)
    {
        return response()->json($types_materiel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Types_materiel $types_materiel)
    {
        $request->validate([
            'nom_type' => 'required|string|max:100|unique:types_materiels,nom_type,' . $types_materiel->id,
        ]);

        $types_materiel->update($request->only('nom_type'));

        return response()->json($types_materiel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Types_materiel $types_materiel)
    {
        $types_materiel->delete();
        return response()->json(['message' => 'Type de matériel supprimé avec succès']);
    }
}
