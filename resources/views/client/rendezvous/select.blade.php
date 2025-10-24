@extends('template.body')

@section('content')
<div class="container mx-auto p-4" x-data="rdvSelect()" x-init="init({{ $aumonierId }})">
    <h1 class="text-2xl font-semibold mb-4">Sélectionner une date et une heure</h1>

    <div class="grid md:grid-cols-3 gap-4">
        <div class="md:col-span-1 p-4 bg-white rounded shadow">
            <h2 class="font-medium mb-2">Dates disponibles</h2>
            <template x-for="d in dates" :key="d.id">
                <button class="w-full text-left px-3 py-2 mb-2 rounded border"
                        :class="d.is_full ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : (selectedDate === d.id ? 'bg-indigo-600 text-white' : 'bg-white')"
                        :disabled="d.is_full"
                        @click="selectDate(d)">
                    <span x-text="d.date"></span>
                    <span class="text-xs" x-show="d.is_full">(Complet)</span>
                </button>
            </template>
        </div>
        <div class="md:col-span-2 p-4 bg-white rounded shadow">
            <h2 class="font-medium mb-2">Créneaux disponibles</h2>
            <div class="flex flex-wrap gap-2 mb-4">
                <template x-for="s in slots" :key="s.id">
                    <button class="px-3 py-2 rounded border"
                            :class="s.taken ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : (selectedSlot === s.id ? 'bg-indigo-600 text-white' : 'bg-white')"
                            :disabled="s.taken"
                            @click="selectSlot(s)">
                        <span x-text="s.start_time"></span>
                        <template x-if="s.end_time"><span> - </span><span x-text="s.end_time"></span></template>
                    </button>
                </template>
            </div>
            <form method="POST" action="{{ route('rdv.book') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="aumonier_id" :value="aumonierId">
                <input type="hidden" name="date_id" :value="selectedDate">
                <input type="hidden" name="slot_id" :value="selectedSlot">
                <div>
                    <label class="block text-sm">Nom</label>
                    <input class="border p-2 w-full" type="text" name="client_name" required />
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input class="border p-2 w-full" type="email" name="client_email" required />
                </div>
                <div>
                    <label class="block text-sm">Objet de la demande</label>
                    <textarea class="border p-2 w-full" name="subject" rows="3" required></textarea>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded" :disabled="!selectedDate || !selectedSlot">Valider</button>
            </form>
        </div>
    </div>
</div>

<script>
function rdvSelect() {
  return {
    aumonierId: null,
    dates: [],
    slots: [],
    selectedDate: null,
    selectedSlot: null,
    async init(aid) {
      this.aumonierId = aid;
      const res = await fetch(`/rdv/dates/${aid}`);
      this.dates = await res.json();
    },
    async selectDate(d) {
      this.selectedDate = d.id;
      this.selectedSlot = null;
      const res = await fetch(`/rdv/slots/${d.id}`);
      this.slots = await res.json();
    },
    selectSlot(s) {
      this.selectedSlot = s.id;
    }
  }
}
</script>
@endsection
