<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RendezVous\Admin\StoreScheduleRequest;
use App\Models\RendezVous\ScheduleSet;
use App\Models\RendezVous\ScheduleDate;
use App\Models\RendezVous\ScheduleSlot;
use Illuminate\Support\Facades\DB; // For transactions

class ScheduleController extends Controller
{
    public function create()
    {
        return view('admin.rendezvous.calendar');
    }

    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data) {
            $set = ScheduleSet::create([
                'aumonier_id' => $data['aumonier_id'],
                'use_global_quota' => $data['use_global_quota'],
                'global_quota' => $data['global_quota'] ?? null,
            ]);

            foreach ($data['dates'] as $dateData) {
                $date = ScheduleDate::create([
                    'set_id' => $set->id,
                    'date' => $dateData['date'],
                    'per_date_quota' => $dateData['per_date_quota'] ?? null,
                ]);
                foreach ($dateData['slots'] as $slot) {
                    ScheduleSlot::create([
                        'date_id' => $date->id,
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.rendezvous.pending')->with('success', 'Calendrier enregistré');
    }
}
