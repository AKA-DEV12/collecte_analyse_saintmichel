<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


use App\Models\Sondage;
use App\Models\Champ;
use App\Models\EnregistrementSondage;

use App\Http\Requests\EnregistrementRequest;

class EnregistrementController extends Controller
{


    // public function store(Request $request)
    // {
    //     try {
    //         $data = $request->except(['_token', 'enregistrement_id']);

    //         foreach ($data as $label => $value) {
    //             // Gérer les tableaux (checkbox multiples, select[multiple], etc.)
    //             if (is_array($value)) {
    //                 $value = json_encode($value); // Encode les tableaux
    //             }

    //             if ($value == null || empty($value)) {
    //                 $value = '-';
    //             }

    //             EnregistrementSondage::create([
    //                 'label' => $label,
    //                 'value' => $value,
    //                 'sondage_id' => $request->enregistrement_id,
    //             ]);
    //         }

    //         // Flash message de succès
    //         return back()->with('success', 'Enregistrement effectué avec succès ');
    //     } catch (\Throwable $th) {
    //         // Log l'erreur pour debug
    //         Log::error('Erreur lors de l\'enregistrement du sondage : ' . $th->getMessage());

    //         // Retour avec message d’erreur et conservation des anciennes données
    //         return back()
    //             ->withInput()
    //             ->with('error', 'Oups, une erreur est survenue lors de l\'enregistrement ');
    //     }
    // }

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
}
