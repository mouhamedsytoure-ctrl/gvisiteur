<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse.
     */
    protected $fillable = [
        'client_id',
        'user_id',
        'date_arrivee',
        'date_sortie',
        'motif',
        'personne_rencontree',
        'statut',
    ];

    /**
     * Une visite appartient à un client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Une visite est enregistrée par un user (admin ou secrétaire).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
