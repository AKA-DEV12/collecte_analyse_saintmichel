<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnregistrementSondage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'label',
        'value',
        'sondage_id',
        'agent',
        'groupe_id',
        'created_at'
    ];

    public function sondage()
    {
        return $this->belongsTo(Sondage::class);
    }
}
