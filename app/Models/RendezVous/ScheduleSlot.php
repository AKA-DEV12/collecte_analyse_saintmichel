<?php

namespace App\Models\RendezVous;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScheduleSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_id',
        'start_time',
        'end_time',
    ];

    public function date(): BelongsTo
    {
        return $this->belongsTo(ScheduleDate::class, 'date_id');
    }

    public function rendezvous(): HasMany
    {
        return $this->hasMany(RendezVous::class, 'slot_id');
    }
}
