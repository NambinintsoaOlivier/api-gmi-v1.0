<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    /** @use HasFactory<\Database\Factories\MarqueFactory> */
    use HasFactory;

    protected $fillable = [
        'nom_marque',
    ];
}
