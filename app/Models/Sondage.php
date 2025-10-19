<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sondage extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'titre', 'description', 'agent'];

    public function champs()
    {
        return $this->hasMany(Champ::class);
    }
    public function enregistrements()
    {
        return $this->hasMany(EnregistrementSondage::class);
    }
}
