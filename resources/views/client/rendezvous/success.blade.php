@extends('layouts.app')

@section('content')
<div class="container mx-auto p-10 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7.5 7.5a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L8.5 12.086l6.793-6.793a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
    </div>
    <h1 class="text-2xl font-semibold mb-2">Demande envoyée</h1>
    <p class="text-gray-600">Votre demande de rendez-vous a été enregistrée. Vous recevrez une confirmation.</p>
    <a href="{{ route('rdv.list') }}" class="mt-6 inline-block px-4 py-2 bg-indigo-600 text-white rounded">Retour</a>
</div>
@endsection
