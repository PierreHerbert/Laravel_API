<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EquipeController extends Controller
{
    public function index()
    {
        $equipes = DB::table('equipes')
            ->leftjoin('clubs', 'clubs.id', '=', 'equipes.club_id')
            ->select('equipes.*', 'nomClub', 'logoClub')
            ->get()
            ->toArray();

        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $equipes,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nomEquipe' => 'required|max:100',
            'descriptionEquipe' => 'required|max:500',
        ]);


        // On crée un nouvel utilisateur
        $equipe = Equipe::create([
            'nomEquipe' => $request->nomEquipe,
            'descriptionEquipe' => $request->descriptionEquipe,
            'club_id' =>$request->club_id,
        ]);

        
        $materiel = Materiel::whereId($request->materiel_id)->firstOrFail();
        $materiel_equipe = $equipe->materiels()->save($materiel);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $equipe,
        ]);
    }

    public function show(Equipe $equipe)
    {
        $equipe =  Equipe::whereId($equipe->id)->firstOrFail();
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($equipe);
    }


    public function update(Request $request, Equipe $equipe)
    {
        $this->validate($request, [
            'nomEquipe' => 'required|max:100',
            'descriptionEquipe' => 'required|max:500',
        ]);

        $materiel = Materiel::whereId($request->materiel_id)->firstOrFail();
        $materiel_equipe = $equipe->materiels()->save($materiel);
        
        // On crée un nouvel utilisateur
        $equipe->update([
            'nomEquipe' => $request->nomEquipe,
            'descriptionEquipe' => $request->descriptionEquipe,
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Mise à jour avec succès'
        ]);
    }

    public function destroy(Equipe $equipe)
    {
        // On supprime le equipe
        $equipe->delete();

        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimer avec succès'
        ]);
    }
}
