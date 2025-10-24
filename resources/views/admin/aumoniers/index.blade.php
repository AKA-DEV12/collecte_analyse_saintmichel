@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Aumôniers</h1>
        <a href="{{ route('admin.rendezvous.aumoniers.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Nouveau</a>
    </div>
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Photo</th>
                    <th class="p-2 text-left">Nom</th>
                    <th class="p-2 text-left">Titre</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aumoniers as $a)
                <tr class="border-t">
                    <td class="p-2"><img class="w-12 h-12 rounded object-cover" src="/{{ $a->photo_path ?? 'images/placeholder.png' }}" /></td>
                    <td class="p-2">{{ $a->full_name }}</td>
                    <td class="p-2">{{ $a->title }}</td>
                    <td class="p-2">
                        <a class="text-indigo-600" href="{{ route('admin.rendezvous.aumoniers.edit', $a) }}">Modifier</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $aumoniers->links() }}</div>
</div>
@endsection
