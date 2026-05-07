<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    /** @use HasFactory<\Database\Factories\MaterielFactory> */
    use HasFactory;

    protected $fillable = [
        'modele',
        'description',
        'etat',
        'categorie_materiel_id',
        'marque_id',
        'type_materiel_id',
        'user_id',
    ];

    public function categorieMateriel()
    {
        return $this->belongsTo(Categorie_materiel::class, 'categorie_materiel_id');
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class, 'marque_id');
    }

    public function typesMateriel()
    {
        return $this->belongsTo(Types_materiel::class, 'type_materiel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
