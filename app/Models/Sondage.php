<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sondage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'titre',
        'description',
        'agent',
        'created_by',
    ];

    public function champs()
    {
        return $this->hasMany(Champ::class);
    }
    public function enregistrements()
    {
        return $this->hasMany(EnregistrementSondage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
