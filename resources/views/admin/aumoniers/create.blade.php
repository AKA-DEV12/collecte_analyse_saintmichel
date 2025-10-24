@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-xl">
    <h1 class="text-2xl font-semibold mb-4">Créer un aumônier</h1>
    <form method="POST" action="{{ route('admin.rendezvous.aumoniers.store') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm">Prénom</label>
            <input class="border p-2 w-full" type="text" name="first_name" required />
        </div>
        <div>
            <label class="block text-sm">Nom</label>
            <input class="border p-2 w-full" type="text" name="last_name" required />
        </div>
        <div>
            <label class="block text-sm">Titre</label>
            <select class="border p-2 w-full" name="title" required>
                <option value="Aumônier jeunes">Aumônier jeunes</option>
                <option value="Aumônier adultes">Aumônier adultes</option>
                <option value="Aumônier enfants">Aumônier enfants</option>
            </select>
        </div>
        <div>
            <label class="block text-sm">Photo (optionnel)</label>
            <input type="file" name="photo" accept="image/*" />
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Enregistrer</button>
    </form>
</div>
@endsection
