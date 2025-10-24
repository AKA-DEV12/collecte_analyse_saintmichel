<?php

namespace App\Repositories;

use App\Models\RendezVous\Aumonier;
use App\Models\RendezVous\ScheduleDate;
use App\Models\RendezVous\ScheduleSet;
use App\Models\RendezVous\ScheduleSlot;
use App\Models\RendezVous\RendezVous;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RendezVousRepository
{
    public function listAumoniers(): Collection
    {
        return Aumonier::query()->orderBy('last_name')->get();
    }

    public function getAvailableDatesForAumonier(int $aumonierId): Collection
    {
        $today = Carbon::today();
        return ScheduleDate::query()
            ->whereHas('set', fn($q) => $q->where('aumonier_id', $aumonierId))
            ->whereDate('date', '>=', $today)
            ->withCount('rendezvous')
            ->with(['set'])
            ->get()
            ->map(function (ScheduleDate $d) {
                $effectiveQuota = $d->per_date_quota ?? ($d->set->use_global_quota ? $d->set->global_quota : null);
                $is_full = $effectiveQuota !== null && $d->rendezvous_count >= $effectiveQuota;
                return [
                    'id' => $d->id,
                    'date' => $d->date->toDateString(),
                    'is_full' => $is_full,
                    'quota' => $effectiveQuota,
                ];
            });
    }

    public function getAvailableSlotsForDate(int $dateId): Collection
    {
        return ScheduleSlot::query()
            ->where('date_id', $dateId)
            ->withCount('rendezvous')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'start_time' => (string) $s->start_time,
                    'end_time' => $s->end_time ? (string) $s->end_time : null,
                    'taken' => $s->rendezvous_count > 0,
                ];
            });
    }

    public function createBooking(array $data): RendezVous
    {
        // Validate associations and quota
        $date = ScheduleDate::with(['set'])->findOrFail($data['date_id']);
        $slot = ScheduleSlot::where('id', $data['slot_id'])->where('date_id', $date->id)->firstOrFail();

        // Ensure aumonier matches schedule
        if ($date->set->aumonier_id !== (int) $data['aumonier_id']) {
            abort(422, 'Le créneau ne correspond pas à cet aumônier.');
        }

        // Quota calculation
        $effectiveQuota = $date->per_date_quota ?? ($date->set->use_global_quota ? $date->set->global_quota : null);
        if ($effectiveQuota !== null) {
            $countForDate = RendezVous::where('date_id', $date->id)->count();
            if ($countForDate >= $effectiveQuota) {
                abort(422, 'Quota atteint pour cette date.');
            }
        }

        // Ensure slot not taken (1 booking per slot)
        $countForSlot = RendezVous::where('slot_id', $slot->id)->count();
        if ($countForSlot > 0) {
            abort(422, 'Ce créneau est déjà pris.');
        }

        return RendezVous::create($data);
    }
}
