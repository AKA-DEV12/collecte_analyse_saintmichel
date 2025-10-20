<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


use App\Models\Sondage;
use App\Models\Champ;
use App\Models\EnregistrementSondage;
use App\Exports\SondageExport;

use App\Http\Requests\EnregistrementRequest;

class EnregistrementController extends Controller
{


    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token', 'enregistrement_id']);

            // 1. Génère un identifiant unique pour grouper cette soumission
            $groupeId = Str::uuid();

            foreach ($data as $label => $value) {
                // Gérer les tableaux (checkbox multiples, select[multiple], etc.)
                if (is_array($value)) {
                    $value = json_encode($value); // Encode les tableaux
                }

                if ($value == null || empty($value)) {
                    $value = '-';
                }

                // 2. Enregistrement avec groupe_id
                EnregistrementSondage::create([
                    'label' => $label,
                    'value' => $value,
                    'sondage_id' => $request->enregistrement_id,
                    'groupe_id' => $groupeId, // <- regroupement ici
                    'created_by' => auth()->id(),
                ]);
            }

            return back()->with('success', 'Enregistrement effectué avec succès ✅');
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'enregistrement du sondage : ' . $th->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Oups, une erreur est survenue lors de l\'enregistrement ❌');
        }
    }

    public function exportExcel(Request $request)
    {
        $sondageId = $request->query('sondage_id');
        $sondage = Sondage::with(['enregistrements.creator', 'champs'])->findOrFail($sondageId);

        $export = new SondageExport($sondage);
        $filename = 'export_collecte_' . $sondage->id . '.xlsx';
        return Excel::download($export, $filename);
    }

    public function exportPdf(Request $request)
    {
        $sondageId = $request->query('sondage_id');
        $sondage = Sondage::with(['enregistrements.creator', 'champs'])->findOrFail($sondageId);

        $collections = $sondage->champs;
        $groupes = $sondage->enregistrements->groupBy('groupe_id');

        $headings = ['#'];
        foreach ($collections as $c) { $headings[] = $c->label; }
        $headings[] = 'Enregistré par';

        $rows = [];
        $counter = 1;
        foreach ($groupes as $groupeId => $champsDuGroupe) {
            $row = [$counter];
            foreach ($collections as $collection) {
                $champ = $champsDuGroupe->firstWhere('label', $collection->label);
                $row[] = $champ->value ?? '-';
            }
            $creatorName = optional($champsDuGroupe->first())->creator->name ?? 'Inconnu';
            $row[] = $creatorName;
            $rows[] = $row;
            $counter++;
        }

        $pdf = PDF::loadView('collecte.exports.pdf', [
            'title' => $sondage->titre,
            'headings' => $headings,
            'rows' => $rows,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('export_collecte_' . $sondage->id . '.pdf');
    }
}
