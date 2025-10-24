@extends('template.body')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">En travaux</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($aumoniers as $a)
        <div class="p-4 bg-white shadow rounded">
            <div class="flex items-center gap-3">
                <img class="w-16 h-16 object-cover rounded-full" src="/{{ $a->photo_path ?? 'images/placeholder.png' }}" alt="photo" />
                <div>
                    <div class="font-medium">{{ $a->full_name }}</div>
                    <div class="text-sm text-gray-500">{{ $a->title }}</div>
                </div>
            </div>
            <a href="{{ route('admin.rendezvous.calendar.create') }}" class="mt-3 inline-block px-3 py-2 bg-indigo-600  rounded" style="color: #000; ">Définir un calendrier de rendez-vous</a>
        </div>
        @endforeach
    </div>
</div>
@endsection
