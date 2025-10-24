<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RendezVous\Admin\StoreAumonierRequest;
use App\Http\Requests\RendezVous\Admin\UpdateAumonierRequest;
use App\Models\RendezVous\Aumonier;
use App\Services\ImageUploadService;

class AumonierController extends Controller
{
    public function index()
    {
        $aumoniers = Aumonier::orderBy('last_name')->paginate(20);
        return view('admin.aumoniers.index', compact('aumoniers'));
    }

    public function create()
    {
        return view('admin.aumoniers.create');
    }

    public function store(StoreAumonierRequest $request, ImageUploadService $uploader)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $uploader->uploadAumonierPhoto($request->file('photo'));
        }
        Aumonier::create($data);
        return redirect()->route('admin.rendezvous.aumoniers.index');
    }

    public function edit(Aumonier $aumonier)
    {
        return view('admin.aumoniers.edit', compact('aumonier'));
    }

    public function update(UpdateAumonierRequest $request, Aumonier $aumonier, ImageUploadService $uploader)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $uploader->uploadAumonierPhoto($request->file('photo'));
        }
        $aumonier->update($data);
        return redirect()->route('admin.rendezvous.aumoniers.index');
    }
}
