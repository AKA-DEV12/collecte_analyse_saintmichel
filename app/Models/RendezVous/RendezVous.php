<?php

namespace App\Models\RendezVous;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RendezVous extends Model
{
    use HasFactory;

    protected $fillable = [
        'aumonier_id',
        'date_id',
        'slot_id',
        'client_name',
        'client_email',
        'subject',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELED = 'canceled';

    public function aumonier(): BelongsTo
    {
        return $this->belongsTo(Aumonier::class);
    }

    public function date(): BelongsTo
    {
        return $this->belongsTo(ScheduleDate::class, 'date_id');
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(ScheduleSlot::class, 'slot_id');
    }
}
