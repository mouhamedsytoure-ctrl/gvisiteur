<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'role',
        'password',
    ];

    /**
     * Attributs cachés pour la sérialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
