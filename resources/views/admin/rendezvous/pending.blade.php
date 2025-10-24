@extends('template.body')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Rendez-vous en attente</h1>
    <div class="bg-white shadow rounded">
        <table class="min-w-full">
            <thead class="bg-gray-100"><tr>
                <th class="p-2 text-left">Aumônier</th>
                <th class="p-2 text-left">Client</th>
                <th class="p-2 text-left">Objet</th>
                <th class="p-2 text-left">Date</th>
                <th class="p-2 text-left">Heure</th>
            </tr></thead>
            <tbody>
            @foreach($items as $it)
                <tr class="border-t">
                    <td class="p-2">{{ optional($it->aumonier)->full_name }}</td>
                    <td class="p-2">{{ $it->client_name }}</td>
                    <td class="p-2">{{ $it->subject }}</td>
                    <td class="p-2">{{ optional(optional($it->date)->date)->format('Y-m-d') }}</td>
                    <td class="p-2">{{ optional($it->slot)->start_time }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
