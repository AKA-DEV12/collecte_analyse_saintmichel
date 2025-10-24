<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\RendezVous\Client\BookRendezVousRequest;
use App\Repositories\RendezVousRepository;
use App\Models\RendezVous\RendezVous;

class RendezVousController extends Controller
{
    public function __construct(private RendezVousRepository $repo)
    {
    }

    public function listAumoniers()
    {
        $aumoniers = $this->repo->listAumoniers();
        return view('client.rendezvous.list', compact('aumoniers'));
    }

    public function select(int $aumonier)
    {
        return view('client.rendezvous.select', ['aumonierId' => $aumonier]);
    }

    public function availableDates(int $aumonier)
    {
        $dates = $this->repo->getAvailableDatesForAumonier($aumonier);
        return response()->json($dates);
    }

    public function availableSlots(int $dateId)
    {
        $slots = $this->repo->getAvailableSlotsForDate($dateId);
        return response()->json($slots);
    }

    public function book(BookRendezVousRequest $request)
    {
        $data = $request->validated();
        $data['status'] = RendezVous::STATUS_PENDING;
        $this->repo->createBooking($data);
        return view('client.rendezvous.success');
    }
}
