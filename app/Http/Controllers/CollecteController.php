<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


use App\Models\Sondage;
use App\Models\Champ;
use App\Models\EnregistrementSondage;

class CollecteController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Collecte";
        $data['title'] = "Collecte/Sondage";
        $data['section_title'] = 'Affichage la liste des differents enregistrement';
        $data['sub_title'] = 'Cette section est utilisée pour l\'affichage du formulaire d\'une collecte';
        $data['submenu'] = "Collecte";

        $data['collections'] = Sondage::get(['id', 'titre', 'description', 'created_at']);

        return view('collecte.index', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Collecte";
        $data['title'] = "Collecte/Sondage";
        $data['section_title'] = 'Affichage du formulaire de collecte';
        $data['sub_title'] = 'Cette section est utilisée pour l\'affichage du formulaire d\'une collecte';
        $data['submenu'] = "Collecte";

        $donnee = Sondage::findOrFail($id);

        // Si les champs sont stockés en JSON dans la base :
        $champs = json_decode($donnee->champs, true); // ← important d'utiliser true ici

        return view('collecte.edit', [
            'donnee' => $donnee,
            'champs' => $champs
        ]);
    }


    public function create()
    {
        return view('collecte.create');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'agent' => 'nullable|integer',
            'champs' => 'required|string', // Le JSON envoyé depuis l’input hidden
        ]);

        // Création du sondage
        $sondage = Sondage::create([
            'titre' => $validated['titre'],
            'agent' => $validated['agent'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        // Décoder les champs envoyés en JSON
        $champs = json_decode($validated['champs'], true);

        if (!empty($champs)) {
            foreach ($champs as $champ) {
                Champ::create([
                    'sondage_id' => $sondage->id,
                    'label' => $champ['label'],
                    'value' => $champ['label'],
                    'type' => $champ['type'],
                    'obligatoire' => $champ['required'] ?? false,
                    'options' => $champ['options'] ?? null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Formulaire créé avec succès 🎉');
    }

    // public function update(Request $request, $id)
    // {
    //     // dd('Merci de patienter..., En travaux');
    //     $validated = $request->validate([
    //         'titre' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'champs' => 'required|string', // JSON des champs
    //     ]);

    //     $sondage = Sondage::findOrFail($id);

    //     $sondage->update([
    //         'titre' => $validated['titre'],
    //         'description' => $validated['description'] ?? null,
    //     ]);

    //     $champs = json_decode($validated['champs'], true);

    //     // Tableau des IDs existants mis à jour (pour nettoyage ensuite)
    //     $updatedIds = [];

    //     foreach ($champs as $champ) {
    //         // Si un ID est présent dans les données du champ, on l'utilise
    //         $champModel = Champ::updateOrCreate(
    //             [
    //                 'id' => $champ['id'] ?? null,
    //                 'sondage_id' => $sondage->id,
    //             ],
    //             [
    //                 'label' => $champ['label'],
    //                 'value' => $champ['label'],
    //                 'type' => $champ['type'],
    //                 'obligatoire' => $champ['required'] ?? false,
    //                 'options' => $champ['options'] ?? null, // Pas besoin de json_encode si colonne JSON
    //             ]
    //         );

    //         EnregistrementSondage::updateOrCreate(
    //             [
    //                 'sondage_id' => $sondage->id,
    //             ],
    //             [
    //                 'label' => $champ['label'],
    //             ]
    //         );

    //         $updatedIds[] = $champModel->id;
    //     }

    //     // Supprimer les anciens champs qui ne sont plus dans la requête
    //     Champ::where('sondage_id', $sondage->id)
    //         ->whereNotIn('id', $updatedIds)
    //         ->delete();

    //     return redirect()->back()->with('success', 'Mis à jour avec succès ');
    // }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'champs' => 'required|string', // JSON des champs
        ]);

        $sondage = Sondage::findOrFail($id);

        $sondage->update([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
        ]);

        $champs = json_decode($validated['champs'], true);

        $updatedIds = [];

        // Récupérer tous les groupes existants pour ce sondage
        $groupes = EnregistrementSondage::where('sondage_id', $sondage->id)
            ->distinct('groupe_id')
            ->pluck('groupe_id');

        foreach ($champs as $champ) {
            $champModel = Champ::updateOrCreate(
                [
                    'id' => $champ['id'] ?? null,
                    'sondage_id' => $sondage->id,
                ],
                [
                    'label' => $champ['label'],
                    'value' => $champ['label'],
                    'type' => $champ['type'],
                    'obligatoire' => $champ['required'] ?? false,
                    'options' => $champ['options'] ?? null,
                ]
            );

            $updatedIds[] = $champModel->id;

            // Pour chaque groupe existant, ajouter le champ seulement s'il n'existe pas
            foreach ($groupes as $groupe_id) {
                $existe = EnregistrementSondage::where([
                    ['sondage_id', $sondage->id],
                    ['groupe_id', $groupe_id],
                    ['label', $champ['label']]
                ])->exists();

                if (!$existe) {
                    EnregistrementSondage::create([
                        'sondage_id' => $sondage->id,
                        'groupe_id' => $groupe_id,
                        'label' => $champ['label'],
                        'value' => '-', // Valeur par défaut
                    ]);
                }
            }
        }

        // Supprimer les anciens champs qui ne sont plus dans la requête
        Champ::where('sondage_id', $sondage->id)
            ->whereNotIn('id', $updatedIds)
            ->delete();

        return redirect()->back()->with('success', 'Mis à jour avec succès');
    }




    public function show($id)
    {
        $data['page_title'] = "Collecte";
        $data['title'] = "Collecte/Sondage";
        $data['section_title'] = 'Affichage du formulaire de collecte';
        $data['sub_title'] = 'Cette section est utilisée pour l\'affichage du formulaire d\'une collecte';
        $data['submenu'] = "Collecte";

        $data['donnees'] = Sondage::with('enregistrements')->findOrFail($id);
        $data['collections'] = $data['donnees']->champs;

        return view('collecte.show', $data);
    }

    public function formulaire($id)
    {
        $data['page_title'] = "Collecte";
        $data['title'] = "Collecte/Sondage";
        $data['section_title'] = 'Affichage du formulaire de collecte';
        $data['sub_title'] = 'Cette section est utilisée pour l\'affichage du formulaire d\'une collecte';
        $data['submenu'] = "Collecte";

        $data['donnee'] = Sondage::findOrFail($id);

        $data['collections'] = $data['donnee']->champs;

        return view('collecte.formulaire', $data);
    }

    public function delete($id)
    {

        try {

            DB::beginTransaction();
            EnregistrementSondage::where('sondage_id', $id)->delete();
            Champ::where('sondage_id', $id)->delete();
            Sondage::where('id', $id)->delete();

            DB::commit();
            return back()->with('success', 'Projet supprimer ');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Erreur lors de la suppression : ' . $th->getMessage());
        }
    }
}
