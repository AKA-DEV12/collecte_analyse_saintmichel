<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\RecensementRequest;

use App\Models\Recensement;

class RecensementController extends Controller
{
    /**
     * Liste des recensements avec pagination, tri et filtres.
     */
  public function index(Request $request)
{
    $query = Recensement::query();

    // Filtres texte
    if ($request->filled('nom')) {
        $query->where('nom', 'like', '%' . $request->nom . '%');
    }

    if ($request->filled('quartier')) {
        $query->where('quartier', 'like', '%' . $request->quartier . '%');
    }

    if ($request->filled('ceb')) {
        $query->where('ceb', 'like', '%' . $request->ceb . '%');
    }

    if ($request->filled('situation_professionnelle')) {
        $query->where('situation_professionnelle', 'like', '%' . $request->situation_professionnelle . '%');
    }

    if ($request->filled('situation_matrimoniale')) {
        $query->where('situation_matrimoniale', $request->situation_matrimoniale);
    }

    if ($request->filled('telephone')) {
        $query->where('telephone', 'like', '%' . $request->telephone . '%');
    }

    if ($request->filled('numero_whatsapp')) {
        $query->where('numero_whatsapp', 'like', '%' . $request->numero_whatsapp . '%');
    }

    // Filtres booléens
    foreach (['baptise', 'confirme', 'profession_de_foi'] as $boolField) {
        if ($request->filled($boolField)) {
            $val = $request->input($boolField);
            $query->where($boolField, in_array($val, ['1', 1, 'oui'], true) ? 1 : 0);
        }
    }

    // Filtres de dates (intervalle sur date_naissance)
    if ($request->filled('date_min')) {
        $query->whereDate('date_naissance', '>=', $request->date_min);
    }

    if ($request->filled('date_max')) {
        $query->whereDate('date_naissance', '<=', $request->date_max);
    }

    // Tri
    $sortBy = in_array($request->get('sort_by'), [
        'nom','date_naissance','quartier','baptise','confirme','profession_de_foi',
        'telephone','numero_whatsapp','situation_professionnelle','situation_matrimoniale',
        'ceb','created_at'
    ]) ? $request->get('sort_by') : 'created_at';

    $sortDir = $request->get('sort_dir') === 'asc' ? 'asc' : 'desc';
    $query->orderBy($sortBy, $sortDir);

    // Pagination
    $perPage = (int) ($request->get('per_page', 10));
    if ($perPage <= 0 || $perPage > 100) {
        $perPage = 10;
    }

    $recensements = $query->with('createur')->paginate($perPage)->withQueryString();

    return view('recensement.index', compact('recensements', 'sortBy', 'sortDir'));
}


    public function formulaire()
    {
        return view('recensement.formulaire');
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        return view('recensement.create');
    }

    /**
     * Enregistrement d’un nouveau recensement.
     */
    public function store(RecensementRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();

            Recensement::create($data);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Recensement ajouté avec succès !');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erreur création recensement : ' . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors de l’ajout du recensement.');
        }
    }

    /**
     * Afficher un recensement.
     */
    public function show(Request $request, $id)
    {
        $recensement = Recensement::findOrFail($id);
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($recensement);
        }
        return view('recensement.show', compact('recensement'));
    }

    /**
     * Formulaire d’édition.
     */
    public function edit($id)
    {
        $recensement = Recensement::findOrFail($id);
        return view('recensement.edit', compact('recensement'));
    }

    /**
     * Mise à jour d’un recensement.
     */
    public function update(RecensementRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $recensement = Recensement::findOrFail($id);
            $recensement->update($data);

            DB::commit();
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'data' => $recensement]);
            }
            return redirect()->route('recensement.index')->with('success', 'Recensement mis à jour avec succès !');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour recensement : ' . $e->getMessage());
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Une erreur est survenue.'], 500);
            }
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du recensement.');
        }
    }

    /**
     * Suppression d’un recensement.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $recensement = Recensement::findOrFail($id);
            $recensement->delete();

            DB::commit();
            return redirect()->route('recensement.index')
                ->with('success', 'Recensement supprimé avec succès !');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erreur suppression recensement : ' . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors de la suppression du recensement.');
        }
    }

    /**
     * Recherche avancée.
     */
    public function search(Request $request)
    {
        // Redirige vers index avec les query params pour centraliser la logique
        return redirect()->route('recensement.index', $request->all());
    }

    /**
     * Suppression multiple.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            Recensement::whereIn('id', $request->ids)->delete();

            DB::commit();
            return redirect()->route('recensement.index')
                ->with('success', 'Les recensements sélectionnés ont été supprimés avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erreur suppression multiple recensements : ' . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors de la suppression multiple.');
        }
    }

    /**
     * Export des données (CSV par défaut). Pour PDF/Excel, nécessite des packages.
     */
    public function export($format, Request $request)
    {
        // Filtrage identique à index
        $query = Recensement::query();
        if ($request->filled('nom')) { $query->where('nom', 'like', '%' . $request->nom . '%'); }
        if ($request->filled('quartier')) { $query->where('quartier', 'like', '%' . $request->quartier . '%'); }
        if ($request->filled('ceb')) { $query->where('ceb', 'like', '%' . $request->ceb . '%'); }
        if ($request->filled('situation_professionnelle')) { $query->where('situation_professionnelle', 'like', '%' . $request->situation_professionnelle . '%'); }
        if ($request->filled('situation_matrimoniale')) { $query->where('situation_matrimoniale', $request->situation_matrimoniale); }
        if ($request->filled('telephone')) { $query->where('telephone', 'like', '%' . $request->telephone . '%'); }
        if ($request->filled('numero_whatsapp')) { $query->where('numero_whatsapp', 'like', '%' . $request->numero_whatsapp . '%'); }
        foreach (['baptise', 'confirme', 'profession_de_foi'] as $boolField) {
            if ($request->filled($boolField)) {
                $val = $request->input($boolField);
                $query->where($boolField, in_array($val, ['1', 1, 'oui'], true) ? 1 : 0);
            }
        }
        if ($request->filled('date_min')) { $query->whereDate('date_naissance', '>=', $request->date_min); }
        if ($request->filled('date_max')) { $query->whereDate('date_naissance', '<=', $request->date_max); }

        $items = $query->with('createur')->orderBy('created_at', 'desc')->get();

        // Préparer HTML identique aux colonnes du tableau
        $html = view('recensement.export_table', [
            'items' => $items,
        ])->render();

        $format = strtolower($format);

        if ($format === 'excel') {
            // Excel (compat.) via HTML table
            $filename = 'recensements_' . now()->format('Ymd_His') . '.xls';
            return response($html, 200, [
                'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        if ($format === 'pdf') {
            // Tente Dompdf si disponible
            if (app()->bound('dompdf.wrapper')) {
                $pdf = app('dompdf.wrapper');
                $pdf->loadHTML($html)->setPaper('a4', 'landscape');
                return $pdf->download('recensements_' . now()->format('Ymd_His') . '.pdf');
            }
            return back()->with('error', "L'export PDF requiert barryvdh/laravel-dompdf. Veuillez l'installer (composer require barryvdh/laravel-dompdf) ou utilisez l'export Excel.");
        }

        return back()->with('error', 'Format non supporté. Utilisez excel ou pdf.');
    }

    /**
     * Filtres rapides par type (ex: baptises, maries, confirmes, profession_de_foi)
     */
    public function filter($type, Request $request)
    {
        $map = [
            'baptises' => ['baptise' => 1],
            'non_baptises' => ['baptise' => 0],
            'confirmes' => ['confirme' => 1],
            'maries' => ['marie' => 1],
            'profession_de_foi' => ['profession_de_foi' => 1],
        ];

        if (!isset($map[$type])) {
            return redirect()->route('recensement.index')->with('error', 'Type de filtre inconnu.');
        }

        return redirect()->route('recensement.index', array_merge($request->all(), $map[$type]));
    }

    /**
     * Duplication rapide d’un enregistrement existant
     */
    public function duplicate($id)
    {
        $item = Recensement::findOrFail($id);
        $copy = $item->replicate();
        $copy->created_at = now();
        $copy->updated_at = now();
        $copy->created_by = auth()->id();
        $copy->save();

        return redirect()->route('recensement.index')->with('success', 'Enregistrement dupliqué.');
    }
}
