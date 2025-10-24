@extends('template.body')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Choisir un aumônier</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($aumoniers as $a)
        <div class="p-4 bg-white shadow rounded flex flex-col">
            <img class="w-full h-40 object-cover rounded" src="/{{ $a->photo_path ?? 'images/placeholder.png' }}" alt="photo" />
            <div class="mt-3">
                <div class="font-medium">{{ $a->full_name }}</div>
                <div class="text-sm text-gray-600">{{ $a->title }}</div>
            </div>
            <a href="{{ route('rdv.select', ['aumonier' => $a->id]) }}" class="mt-4 inline-block px-3 py-2 bg-indigo-600 text-white rounded">Obtenir un RDV</a>
        </div>
        @endforeach
    </div>
</div>
@endsection
