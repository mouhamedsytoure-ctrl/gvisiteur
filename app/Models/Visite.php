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
}
