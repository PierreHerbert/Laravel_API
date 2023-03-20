<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    use HasFactory;
    protected $fillable = ['nomMateriel', 'stockMateriel'];


    public function equipes(){
    
        return $this->belongsToMany(
            Materiel::class,
            'equipes_materiels', // Table Pivot
            'materiels_id', // Clé étrangere de la table materiels
            'equipe_id'); // Clé étrangère 2nd table ( equipes )
    }

}
