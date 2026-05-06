<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie_materiel extends Model
{
    /** @use HasFactory<\Database\Factories\CategorieMaterielFactory> */
    use HasFactory;

    protected $fillable = [
        'nom_categorie',
    ];
}
