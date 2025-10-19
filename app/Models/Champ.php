<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champ extends Model
{
    use HasFactory;

    protected $fillable = [
        'sondage_id',
        'label',
        'type',
        'obligatoire',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'obligatoire' => 'boolean',
    ];

    public function sondage()
    {
        return $this->belongsTo(Sondage::class);
    }
}
