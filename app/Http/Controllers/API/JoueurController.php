<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JoueurController extends Controller
{
    public function index()
    {
        $joueurs = DB::table('joueurs')
            ->leftjoin('equipes', 'equipes.id', '=', 'joueurs.equipe_id')
            ->select('joueurs.*', 'nomEquipe', 'descriptionEquipe')
            ->get()
            ->toArray();

        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $joueurs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nom' => 'required|max:100',
            'prenom' => 'required|max:100',
            'poste' => 'required|max:100',
        ]);


        // On crée un nouvel utilisateur
        $joueur = Joueur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'poste' => $request->poste,
            'equipe_id' => $request->equipe_id,
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $joueur,
        ]);
    }

    public function show(Joueur $joueur)
    {
        $joueur =  Joueur::whereId($joueur->id)->firstOrFail();
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($joueur);
    }


    public function update(Request $request, Joueur $joueur)
    {
        $this->validate($request, [
            'nom' => 'required|max:100',
            'prenom' => 'required|max:100',
            'poste' => 'required|max:100',
        ]);


        // On crée un nouvel utilisateur
        $joueur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'poste' => $request->poste,
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Mise à jour avec succès'
        ]);
    }

    public function destroy(Joueur $joueur)
    {
        // On supprime le joueur
        $joueur->delete();

        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimer avec succès'
        ]);
    }
}
