<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;
    protected $fillable = ['nomEquipe', 'descriptionEquipe','club_id'];

    public function materiels(){
    
        return $this->belongsToMany(
            Equipe::class,
            'equipes_materiels', // Table Pivot
            'equipe_id', // Clé étrangere de la table equipes
            'materiels_id'); // Clé étrangère 2nd table ( meteriels )
    }
}
