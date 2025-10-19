<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // si tu veux utiliser auth

class Agent extends Authenticatable
{

    protected $fillable = [
        'id',
        'name',
        'tel',
        'fonction',
        'ceb',
        'password',
    ];

    // Masquer le mot de passe dans les tableaux ou JSON
    protected $hidden = [
        'password',
    ];
}
