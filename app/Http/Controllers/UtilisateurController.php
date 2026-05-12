<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Utilisateur::all());
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
            'nom_utilisateur' => 'required|string|max:255',
            'type_utilisateur' => 'required|string|max:50',
            'fonction_utilisateur' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255|unique:utilisateurs,email',
        ]);

        $utilisateur = Utilisateur::create([
            'nom_utilisateur' => $request->nom_utilisateur,
            'type_utilisateur' => $request->type_utilisateur,
            'fonction_utilisateur' => $request->fonction_utilisateur,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        return response()->json($utilisateur, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
    {
        return response()->json($utilisateur);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        $request->validate([
            'nom_utilisateur' => 'required|string|max:255',
            'type_utilisateur' => 'required|string|max:50',
            'fonction_utilisateur' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
            'email' => 'string|email|max:255|unique:utilisateurs,email,' . $utilisateur->id,
        ]);

        $utilisateur->update([
            'nom_utilisateur' => $request->nom_utilisateur,
            'type_utilisateur' => $request->type_utilisateur,
            'fonction_utilisateur' => $request->fonction_utilisateur,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        return response()->json($utilisateur);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
