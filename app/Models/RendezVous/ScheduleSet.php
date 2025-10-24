<?php

namespace App\Models\RendezVous;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScheduleSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'aumonier_id',
        'use_global_quota',
        'global_quota',
    ];

    protected $casts = [
        'use_global_quota' => 'boolean',
        'global_quota' => 'integer',
    ];

    public function aumonier(): BelongsTo
    {
        return $this->belongsTo(Aumonier::class);
    }

    public function dates(): HasMany
    {
        return $this->hasMany(ScheduleDate::class, 'set_id');
    }
}
