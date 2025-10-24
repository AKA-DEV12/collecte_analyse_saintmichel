@extends('template.body')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Définir un calendrier de rendez-vous</h1>
    <form method="POST" action="{{ route('admin.rendezvous.calendar.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm">ID de l'aumônier</label>
            <input class="border p-2 w-full" type="number" name="aumonier_id" required />
        </div>
        <div class="flex items-center gap-2">
            <input id="use_global_quota" type="checkbox" name="use_global_quota" value="1" />
            <label for="use_global_quota" class="text-sm">Utiliser un quota global</label>
        </div>
        <div>
            <label class="block text-sm">Quota global (optionnel)</label>
            <input class="border p-2 w-full" type="number" name="global_quota" min="1" />
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-medium mb-2">Dates et créneaux</h2>
            <div id="dates-container" class="space-y-4"></div>
            <button type="button" id="add-date" class="mt-2 px-3 py-2 bg-gray-800 text-white rounded">Ajouter une date</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Enregistrer</button>
    </form>
</div>

<script>
const datesContainer = document.getElementById('dates-container');
const addDateBtn = document.getElementById('add-date');

function addSlotRow(dateIndex) {
  const slotRow = document.createElement('div');
  slotRow.className = 'flex gap-2 items-end';
  slotRow.innerHTML = `
    <div>
      <label class="block text-xs text-gray-600">Début (HH:MM)</label>
      <input type="time" name="dates[${dateIndex}][slots][][start_time]" class="border p-2" required />
    </div>
    <div>
      <label class="block text-xs text-gray-600">Fin (HH:MM)</label>
      <input type="time" name="dates[${dateIndex}][slots][][end_time]" class="border p-2" />
    </div>
    <button type="button" class="px-2 py-2 bg-red-500 text-white rounded remove-slot">Supprimer</button>
  `;
  slotRow.querySelector('.remove-slot').addEventListener('click', () => slotRow.remove());
  return slotRow;
}

function addDateBlock() {
  const index = datesContainer.children.length;
  const wrapper = document.createElement('div');
  wrapper.className = 'p-3 border rounded space-y-2';
  wrapper.innerHTML = `
    <div>
      <label class="block text-sm">Date</label>
      <input type="date" name="dates[${index}][date]" class="border p-2" min="{{ now()->toDateString() }}" required />
    </div>
    <div>
      <label class="block text-sm">Quota pour la date (optionnel)</label>
      <input type="number" name="dates[${index}][per_date_quota]" class="border p-2" min="1" />
    </div>
    <div>
      <h3 class="font-medium">Créneaux</h3>
      <div class="slots space-y-2"></div>
      <button type="button" class="mt-2 px-2 py-1 bg-gray-700 text-white rounded add-slot">Ajouter un créneau</button>
    </div>
  `;
  const slotsContainer = wrapper.querySelector('.slots');
  const addSlotBtn = wrapper.querySelector('.add-slot');
  addSlotBtn.addEventListener('click', () => slotsContainer.appendChild(addSlotRow(index)));
  slotsContainer.appendChild(addSlotRow(index));
  datesContainer.appendChild(wrapper);
}

addDateBtn.addEventListener('click', addDateBlock);
</script>
@endsection
