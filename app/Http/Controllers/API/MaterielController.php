<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\Materiel;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materiels = Materiel::all();

        return response()->json($materiels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomMateriel' => 'required|max:100',
            'stockMateriel' => 'required',
        ]);



        // On crée un nouvel utilisateur
        $materiel = Materiel::create([
            'nomMateriel' => $request->nomMateriel,
            'stockMateriel' => $request->stockMateriel,
        ]);

        $equipe = Equipe::whereId($request->equipe_id)->firstOrFail();

        $materiel_equipe = $materiel->equipes()->save($equipe);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $materiel,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Materiel $materiel)
    {
        $materiel =  Materiel::whereId($materiel->id)->firstOrFail();
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($materiel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materiel $materiel)
    {
        $this->validate($request, [
            'nomMateriel' => 'required|max:100',
            'stockMateriel' => 'required',
        ]);

        $equipe = Equipe::whereId($request->equipe_id)->firstOrFail();

        $materiel_equipe = $materiel->equipes()->save($equipe);
        // On met à jour l'utilisateur
        $materiel->update([
            'nomMateriel' => $request->nomMateriel,
            'stockMateriel' => $request->stockMateriel,
        ]);



        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Mise à jour avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materiel $materiel)
    {
        // On supprime le joueur
        $materiel->delete();

        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimer avec succès'
        ]);
    }
}
