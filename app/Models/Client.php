<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'entreprise',
    ];

    /**
     * Un client a plusieurs visites.
     */
    public function visites()
    {
        return $this->hasMany(Visite::class);
    }
}
