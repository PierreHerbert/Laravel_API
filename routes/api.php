<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JoueurController;
use App\Http\Controllers\API\EquipeController;
use App\Http\Controllers\API\ClubController;
use App\Http\Controllers\API\MaterielController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route des Joueurs
Route::controller(JoueurController::class)->group(function () {
    Route::get('joueurs', 'index');
    Route::post('joueur', 'store');
    Route::get('joueur/{joueur}', 'show');
    Route::post('joueur/{joueur}', 'update');
    Route::delete('joueur/{joueur}', 'destroy');
}); 

//Routes des Equipes
Route::controller(EquipeController::class)->group(function () {
    Route::get('equipes', 'index');
    Route::post('equipe', 'store');
    Route::get('equipe/{equipe}', 'show');
    Route::post('equipe/{equipe}', 'update');
    Route::delete('equipe/{equipe}', 'destroy');
}); 

//Routes des Clubs
Route::controller(ClubController::class)->group(function () {
    Route::get('clubs', 'index');
    Route::post('club', 'store');
    Route::get('club/{club}', 'show');
    Route::post('club/{club}', 'update');
    Route::delete('club/{club}', 'destroy');
}); 

//Routes des Materiels
Route::controller(MaterielController::class)->group(function () {
    Route::get('materiels', 'index');
    Route::post('materiel', 'store');
    Route::get('materiel/{materiel}', 'show');
    Route::post('materiel/{materiel}', 'update');
    Route::delete('materiel/{materiel}', 'destroy');
}); 

