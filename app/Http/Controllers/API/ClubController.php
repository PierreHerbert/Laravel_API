<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $clubs = Club::all();

        return response()->json($clubs);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomClub' => 'required|max:100',
        ]);

        $filename = "";
        if ($request->hasFile('logoFile')) {

            // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
            $filenameWithExt = $request->file('logoFile')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //  On récupère l'extension du fichier, résultat $extension : ".jpg"
            $extension = $request->file('logoFile')->getClientOriginalExtension();

            // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore : "jeanmiche_20220422.jpg"
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;

            // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
            $path = $request->file('logoFile')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }



        // On crée un nouvel utilisateur
        $club = Club::create([
            'nomClub' => $request->nomClub,
            'logoClub' => $filename,
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $club,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        $club =  Club::whereId($club->id)->firstOrFail();
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($club);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        $this->validate($request, [
            'nomClub' => 'required|max:100',          
        ]);

        $filename = "";
        if ($request->hasFile('logoFile')) {

            // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
            $filenameWithExt = $request->file('logoFile')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //  On récupère l'extension du fichier, résultat $extension : ".jpg"
            $extension = $request->file('logoFile')->getClientOriginalExtension();

            // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore : "jeanmiche_20220422.jpg"
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;

            // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
            $path = $request->file('logoFile')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }

        // On crée un nouvel utilisateur
        $club->update([
            'nomClub' => $request->nomClub,
            'logoClub' => $filename,
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Mise à jour avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
         // On supprime le joueur
         $club->delete();

         // On retourne la réponse JSON
         return response()->json([
             'status' => 'Supprimer avec succès'
         ]);
    }
}
