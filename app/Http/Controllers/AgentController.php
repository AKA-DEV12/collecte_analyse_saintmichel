<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Sondage;
use App\Models\Recensement;


class AgentController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }
    public function dashboard()
    {

        $data['collections'] = Sondage::where('agent', auth()->user()->type_agent)->get(['id', 'titre', 'description', 'created_at']);

        return view('agent.dashboard_agent', $data);
    }


    public function index()
    {
        $agentId = request('agent_id');
        $query = User::where('role', 0);
        if (!empty($agentId)) {
            $query->where('id', $agentId);
        }
        $agents = $query->get();
        return view('agent.index', compact('agents'));
    }

    public function recensement(Request $request)
    {
        $query = Recensement::query();
        // Tri
        $sortBy = in_array($request->get('sort_by'), [
            'nom',
            'date_naissance',
            'quartier',
            'baptise',
            'confirme',
            'profession_de_foi',
            'telephone',
            'numero_whatsapp',
            'situation_professionnelle',
            'situation_matrimoniale',
            'ceb',
            'created_at'
        ]) ? $request->get('sort_by') : 'created_at';

        $sortDir = $request->get('sort_dir') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDir);

        // Pagination
        $perPage = (int) ($request->get('per_page', 10));
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }
        $recensements = $query->with('createur')->where('created_by', auth()->id())->paginate($perPage)->withQueryString();

        return view('recensement.index', compact('recensements', 'sortBy', 'sortDir'));
    }

    public function formulaire()
    {
        return view('agent.recensement_formulaire');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:20|unique:users,tel',
            'fonction' => 'required|string|max:255',
            'ceb' => 'required|string|max:255',
            'type_agent' => 'required|in:0,1',
            'password' => 'required|string|min:6|same:c_password',
            'c_password' => 'required|string|min:6',
        ], [
            'name.required' => 'Le nom complet est obligatoire.',
            'tel.required' => 'Le numéro de téléphone est obligatoire.',
            'fonction.required' => 'La fonction est obligatoire.',
            'ceb.required' => 'Le CEB est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.same' => 'Le mot de passe et la confirmation ne correspondent pas.',
            'c_password.required' => 'La confirmation du mot de passe est obligatoire.',

        ]);


        DB::beginTransaction();

        try {
            User::create([
                'name' => $request->name,
                'tel' => $request->tel,
                'fonction' => $request->fonction,
                'ceb' => $request->ceb,
                'role' => 0,
                'type_agent' => $request->type_agent,
                'password' => bcrypt($request->password),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Agent créé avec succès.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création de l’agent : ' . $th->getMessage());
        }
    }


    public function edit($id)
    {
        $agent = User::findOrFail($id);
        return response()->json($agent);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:20|unique:users,tel,' . $id,
            'fonction' => 'required|string|max:255',
            'ceb' => 'required|string|max:255',
            'type_agent' => 'required|in:0,1',
        ]);

        try {
            $agent = User::findOrFail($id);
            $agent->update([
                'name' => $request->name,
                'tel' => $request->tel,
                'type_agent' => $request->type_agent,

            ]);

            return redirect()->route('agent.index')->with('success', 'Agent mis à jour avec succès.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $agent = User::findOrFail($id);
            $agent->delete();

            return redirect()->back()->with('success', 'Agent supprimé avec succès.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $th->getMessage());
        }
    }
}
