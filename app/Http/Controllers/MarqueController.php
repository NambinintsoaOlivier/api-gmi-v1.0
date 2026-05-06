<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Marque::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_marque' => 'required|string|max:100|unique:marques,nom_marque',
        ]);

        $marque = Marque::create($request->only('nom_marque'));

        return response()->json($marque, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Marque $marque)
    {
        return response()->json($marque);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marque $marque)
    {
        $request->validate([
            'nom_marque' => 'required|string|max:100|unique:marques,nom_marque,' . $marque->id,
        ]);

        $marque->update($request->only('nom_marque'));

        return response()->json($marque);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marque $marque)
    {
        $marque->delete();
        return response()->json(['message' => 'Marque supprimée avec succès']);
    }
}
