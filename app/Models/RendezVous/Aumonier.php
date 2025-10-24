<?php

namespace App\Models\RendezVous;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aumonier extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'photo_path',
    ];

    public function scheduleSets(): HasMany
    {
        return $this->hasMany(ScheduleSet::class);
    }

    public function rendezvous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
