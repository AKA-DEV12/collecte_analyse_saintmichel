<?php

namespace App\Models\RendezVous;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ScheduleDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'set_id',
        'date',
        'per_date_quota',
    ];

    protected $casts = [
        'date' => 'date',
        'per_date_quota' => 'integer',
    ];

    public function set(): BelongsTo
    {
        return $this->belongsTo(ScheduleSet::class, 'set_id');
    }

    public function slots(): HasMany
    {
        return $this->hasMany(ScheduleSlot::class, 'date_id');
    }

    public function rendezvous(): HasMany
    {
        return $this->hasMany(RendezVous::class, 'date_id');
    }
}
