<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types_materiel extends Model
{
    /** @use HasFactory<\Database\Factories\TypesMaterielFactory> */
    use HasFactory;

    protected $fillable = [
        'nom_type',
    ];
}
