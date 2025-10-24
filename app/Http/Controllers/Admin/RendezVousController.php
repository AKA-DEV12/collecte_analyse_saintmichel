<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous\RendezVous;
use App\Models\RendezVous\Aumonier;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function indexPending()
    {
        $items = RendezVous::where('status', RendezVous::STATUS_PENDING)->latest()->paginate(20);
        return view('admin.rendezvous.pending', compact('items'));
    }

    public function indexDone()
    {
        $items = RendezVous::where('status', RendezVous::STATUS_DONE)->latest()->paginate(20);
        return view('admin.rendezvous.completed', compact('items'));
    }

    public function settings()
    {
        $aumoniers = Aumonier::orderBy('last_name')->get();
        return view('admin.rendezvous.settings', compact('aumoniers'));
    }
}
