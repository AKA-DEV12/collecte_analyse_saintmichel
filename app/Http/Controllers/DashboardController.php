<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recensement;
use Carbon\Carbon;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Vérifie le rôle de l'utilisateur
        if (!Auth::check() || Auth::user()->role != 1) {
            abort(403, 'Accès interdit.');
        }

        $total = Recensement::count();
        $all = Recensement::select('date_naissance', 'situation_professionnelle')->get();

        $enfants = 0; // < 18
        $jeunes = 0;  // 18 - 40
        $adultes = 0; // > 40

        foreach ($all as $r) {
            if (!$r->date_naissance) continue;
            $age = Carbon::parse($r->date_naissance)->age;
            if ($age < 18) $enfants++;
            elseif ($age <= 40) $jeunes++;
            else $adultes++;
        }

        $taux = [
            'enfants' => $total ? round(($enfants / $total) * 100, 1) : 0,
            'jeunes'  => $total ? round(($jeunes / $total) * 100, 1) : 0,
            'adultes' => $total ? round(($adultes / $total) * 100, 1) : 0,
        ];

        $labels = ['SalariePrive', 'Entrepreneur', 'Fonctionnaire', 'RechercheEmploi', 'Eleve', 'Etudiant', 'Agentlibre'];
        $emploiCounts = [];
        foreach ($labels as $lab) {
            $emploiCounts[] = Recensement::where('situation_professionnelle', $lab)->count();
        }

        // Regroupements demandés
        $seekers = Recensement::where('situation_professionnelle', 'RechercheEmploi')->count();
        $workers = Recensement::whereIn('situation_professionnelle', ['SalariePrive','Entrepreneur','Fonctionnaire','Agentlibre','Commercant(e)'])->count();
        $singles = Recensement::where('situation_matrimoniale', 0)->count();
        $married = Recensement::whereIn('situation_matrimoniale', [1,4])->count();
        $divorced = Recensement::where('situation_matrimoniale', 2)->count();
        $widows = Recensement::where('situation_matrimoniale', 3)->count();

        $statusLabels = ['Quête d’emploi','Marié(e)s','Travailleurs','Veuf/Veuve','Divorcé(e)s','Célibataires'];
        $statusCounts = [$seekers, $married, $workers, $widows, $divorced, $singles];

        $agents = User::where('role', 0)->orderBy('name')->get(['id','name','tel','fonction','ceb']);

        return view('dashboard', compact(
            'total', 'enfants', 'jeunes', 'adultes', 'taux', 'labels', 'emploiCounts', 'statusLabels', 'statusCounts', 'agents'
        ));
    }
}
