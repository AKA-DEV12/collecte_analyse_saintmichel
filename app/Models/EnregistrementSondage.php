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
        'created_by',
        'created_at'
    ];

    public function sondage()
    {
        return $this->belongsTo(Sondage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
