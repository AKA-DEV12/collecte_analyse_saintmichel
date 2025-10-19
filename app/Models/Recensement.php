<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recensement extends Model
{
    use HasFactory;

    protected $table = 'recensements';

    protected $fillable = [
        'nom',
        'date_naissance',
        'quartier',
        'baptise',
        'confirme',
        'profession_de_foi',
        'situation_matrimoniale',
        'telephone',
        'numero_whatsapp',
        'situation_professionnelle',
        'ceb',
        'user_id',
        'created_by',
    ];

    /**
     * Relations Eloquent
     */

    // ➤ L’utilisateur associé au recensement (ex : la personne recensée)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ➤ L’utilisateur qui a créé le recensement
    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Accessors et Mutators (facultatif)
     * Exemple : formater le nom proprement
     */
    public function getNomAttribute($value)
    {
        return ucfirst($value);
    }
}
