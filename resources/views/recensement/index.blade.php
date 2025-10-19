@extends('template.body')
@push('css')
    <!-- Styles personnalisés -->
<style>
  .hover-bg-light:hover {
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
  }
</style>
@endpush
@section('content')

          <!--  Row 1 -->
          <div class="row" style="margin-top: -80px !important;">
   
<div class="row g-4">
   <div class="row" style="padding: 40px 10px 10px 10px;">
  <div class="col-md-2">
       @if(auth()->user()->role === 0)
    <a href="{{ route('agent.dashboard') }}">
    <button class="btn btn-outline-primary btn-sm fw-bold" >
      Retour
    </button></a>
    @else
    <a href="{{ route('collecte.index') }}">
    <button class="btn btn-outline-primary btn-sm fw-bold" >
      Retour
    </button></a>
    @endif
  </div>
</div>

  <!-- Bloc Statistiques -->
  <div class="{{ auth()->user()->role == 0 ? 'col-md-12' : 'col-lg-6' }}">
    <div class="card shadow-sm border-0 rounded-4 w-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 class=" fw-bold mb-1">Recensements</h1>
            <p class="card-subtitle text-muted">Gestion et export des données</p>
          </div>
         
        </div>

        <!-- Exemple de mini statistiques -->
        <div class="row text-center " style="margin-top: 58px;">
            <div class="col-md-6">
             <h4 class="fw-bolder text-primary mb-0">{{ now()->format('d/m/y H:i') }}</h4>
            <small class="text-muted"> Date</small>
          </div>
          <div class="col-md-6">
             <h4 class="fw-bolder text-primary mb-0">{{ $recensements->total() }}</h4>
            <small class="text-muted"> Totaux</small>
          </div>
          <div class="col-md-6" style="margin-top: 40px;"> <!-- Bouton : Voir le formulaire -->
            @if(auth()->user()->role === 0)
            <a href="{{ route('agent.recensement.formulaire') }}" class="text-decoration-none">
      <button class="btn btn-outline-primary btn-sm fw-bold">
        Voir le formulaire
      </button>
    </a>
    @else
            <a href="{{ route('recensement.formulaire') }}" class="text-decoration-none">
      <button class="btn btn-outline-primary btn-sm fw-bold">
        Voir le formulaire
      </button>
    </a>
            @endif
          </div>

           <div class="col-md-6" style="margin-top: 40px;">
             <!-- Bouton : Modifier le formulaire -->
    <a href="{{route('dashboard')}}" class="text-decoration-none">
      <button class="btn btn-outline-warning btn-sm fw-bold">
        Voir les statistiques
      </button>
    </a>
          </div>
         
        </div>
      </div>
    </div>
  </div>

  @if(Auth::user()->role === 1)
  <!-- Bloc Exportation -->
  <div class="col-lg-6">
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden ">
      <div class="card-body">

        <div class="row">
            <div class="col-md-6 hover-bg-light p-2">
                <!-- Export Excel -->
        <div class="d-flex align-items-center p-3 rounded-3 mb-3">
          <img src="https://cdn-icons-png.flaticon.com/512/732/732220.png" alt="Excel" width="48" height="48" class="me-3">
          <div>
            <h5 class="fw-semibold mb-1">Exporter en Excel</h5>
            <small class="text-muted">Téléchargez les données au format .xlsx</small>
          </div>
          
        </div>
        <div class="d-flex justify-content-center">
            <a class="btn btn-outline-success btn-sm fw-bold" href="{{ route('recensement.export', array_merge(['format' => 'excel'], request()->query())) }}">Exporter</a>
        </div>
        </div>

            <div class="col-md-6 hover-bg-light p-2">
                
        <!-- Export PDF -->
        <div class="d-flex align-items-center p-3 rounded-3 ">
          <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="PDF" width="48" height="48" class="me-3">
          <div>
            <h5 class="fw-semibold mb-1">Exporter en PDF</h5>
            <small class="text-muted">Téléchargez les données au format .pdf</small>
          </div>
          
        </div>
        <div class="d-flex justify-content-center">
            <a class="btn btn-outline-danger btn-sm fw-bold" href="{{ route('recensement.export', array_merge(['format' => 'pdf'], request()->query())) }}">Exporter</a>
          </div>
            </div>
        </div>
        

      </div>
    </div>
  </div>
@endif
</div>


  <!-- Modal Filtres -->
  <div class="modal fade" id="filtersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-4">
        <div class="modal-header">
          <h5 class="modal-title">Filtres de recensement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <form method="GET" action="{{ route('recensement.index') }}">
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nom et/ou Prénom</label>
                <input type="text" name="nom" value="{{ request('nom') }}" class="form-control form-control-sm" placeholder="Nom et/ou Prénom recherché">
              </div>
              <div class="col-md-6">
                <label class="form-label">Quartier</label>
                <input type="text" name="quartier" value="{{ request('quartier') }}" class="form-control form-control-sm" placeholder="Quartier recherché">
              </div>
              <div class="col-md-6">
                 <label class="form-label">C.E.B</label>
               <select class="form-select" name="ceb" id="ceb" >
                <option value="" selected>Sélectionnez une C.E.B</option>
                <option value="Inconnue">Inconnue</option>
                    <option value="Bienheureuse Caroline">Bienheureuse Caroline</option>
<option value="Saint Antoine de Padoue">Saint Antoine de Padoue</option>
<option value="Saint David">Saint David</option>
<option value="Saint Jean Baptiste">Saint Jean Baptiste</option>
<option value="Saint Jean l’Évangéliste">Saint Jean l’Évangéliste</option>
<option value="Saint Jean Marie-Vianney">Saint Jean Marie-Vianney</option>
<option value="Saint Joseph Artisan">Saint Joseph Artisan</option>
<option value="Saint Joseph Époux">Saint Joseph Époux</option>
<option value="Saint Julien">Saint Julien</option>
<option value="Saint Michel Archange">Saint Michel Archange</option>
<option value="Saint Paul">Saint Paul</option>
<option value="Saint Pierre">Saint Pierre</option>
<option value="Saint Raphaël">Saint Raphaël</option>
<option value="Sainte Bernadette">Sainte Bernadette</option>
<option value="Sainte Famille">Sainte Famille</option>
<option value="Sainte Rita">Sainte Rita</option>
<option value="Sainte Thérèse de l’Enfant Jésus">Sainte Thérèse de l’Enfant Jésus</option>
<option value="Sainte Trinité">Sainte Trinité</option>
            </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Baptisé</label>
                <select name="baptise" class="form-select form-select-sm">
                  <option value="">Tous</option>
                  <option value="1" {{ request('baptise')==='1' ? 'selected' : '' }}>Oui</option>
                  <option value="0" {{ request('baptise')==='0' ? 'selected' : '' }}>Non</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Confirmé</label>
                <select name="confirme" class="form-select form-select-sm">
                  <option value="">Tous</option>
                  <option value="1" {{ request('confirme')==='1' ? 'selected' : '' }}>Oui</option>
                  <option value="0" {{ request('confirme')==='0' ? 'selected' : '' }}>Non</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Profession de foi</label>
                <select name="profession_de_foi" class="form-select form-select-sm">
                  <option value="">Tous</option>
                  <option value="1" {{ request('profession_de_foi')==='1' ? 'selected' : '' }}>Oui</option>
                  <option value="0" {{ request('profession_de_foi')==='0' ? 'selected' : '' }}>Non</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="situation_professionnelle" class="form-label">Situation professionnelle *</label>
            <select class="form-select form-select-sm" name="situation_professionnelle" id="situation_professionnelle" >
                <option value="" selected>Sélectionnez une option</option>
                <option value="Menagere">Ménagère</option>
                <option value="Eleve">Élève</option>
                <option value="Etudiant">Étudiant</option>
                <option value="RechercheEmploi">Quête d’emploi</option>
                <option value="Agentlibre">Agent libre</option>
                <option value="Commercant(e)">Commerçant(e)</option>
                <option value="Fonctionnaire">Fonctionnaire</option>
                <option value="SalariePrive">Salarié privé</option>
                <option value="Entrepreneur">Entrepreneur</option>
                <option value="Retraite">Retraité</option>
            </select>
              </div>

              <div class="col-md-6">
    <label for="situation_matrimoniale" class="form-label">Situation Matrimoniale </label>
            <select class="form-select" name="situation_matrimoniale" id="situation_matrimoniale" >
                <option value="" selected>Sélectionnez une option</option>
                <option value="0">Célibataire</option>
                <option value="1">Marié(e)</option>
                <option value="2">Divorcé(e)</option>
                <option value="3">Veuf/veuve</option>
                <option value="4">Mariage Traditionnel</option>
                <option value="5">Autre</option>
            </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Du</label>
                <input type="date" name="date_min" value="{{ request('date_min') }}" class="form-control form-control-sm">
              </div>
              <div class="col-md-6">
                <label class="form-label">Au</label>
                <input type="date" name="date_max" value="{{ request('date_max') }}" class="form-control form-control-sm">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-light btn-sm" href="{{ route('recensement.index') }}">Réinitialiser</a>
            <button class="btn btn-primary btn-sm" type="submit">Appliquer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
                     
               

<!-- Ici tu me fera un filtre baser sur l‘ensemble des donnees contenu dans l‘entete du tableau -->


            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-md-flex align-items-center justify-content-between">
                    <div>
                      <h4 class="card-title">Liste des donnees</h4>
                      
                    </div>
                     @if(Auth::user()->role == 1)
                    <button class="btn btn-outline-primary btn-md fw-bold" data-bs-toggle="modal" data-bs-target="#filtersModal">
                      Filtres
                    </button>

                     @endif
                  </div>
                  <div class="table-responsive mt-4">
                   <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Quartier</th>
      <th>CEB</th>
      <th>Baptisé</th>
      <th>Confirmé</th>
      <th>Profession de foi</th>
      <th>Situation Matrimoniale</th>
      <th>Situation Professionnel</th>
      <th>Téléphone</th>
      <th>Whatsapp</th>
      <th>Date de naissance</th>
      <th>Enregistré par</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($recensements as $recensement)
      <tr>
        <td><span class="fw-semibold" style="color: var(--bs-primary);">{{ $recensement->nom }}</span></td>
        <td>{{ $recensement->quartier }}</td>
        <td>{{ $recensement->ceb }}</td>
        <td>
          {!! $recensement->baptise 
              ? '<span class="fw-semibold text-success">Oui</span>' 
              : '<span class="text-danger">Non</span>' !!}
        </td>
        <td>
          {!! $recensement->confirme 
              ? '<span class="fw-semibold text-success">Oui</span>' 
              : '<span class="text-danger">Non</span>' !!}
        </td>
        <td>
          {!! $recensement->profession_de_foi 
              ? '<span class="fw-semibold text-success">Oui</span>' 
              : '<span class="text-danger">Non</span>' !!}
        </td>
        <td>
          @if($recensement->situation_matrimoniale == 0)
              Célibataire
          @elseif($recensement->situation_matrimoniale == 1)
              Marié(e)
          @elseif($recensement->situation_matrimoniale == 2)
              Divorcé(e)
          @elseif($recensement->situation_matrimoniale == 3)
              Veuf/veuve
          @elseif($recensement->situation_matrimoniale == 4)
              Mariage Traditionnel
          @elseif($recensement->situation_matrimoniale == 5)
              Autre
          @endif
        </td>
        <td>{{ $recensement->situation_professionnelle }}</td>
        <td>{{ $recensement->telephone }}</td>
        <td>{{ $recensement->numero_whatsapp }}</td>
        <td>{{ $recensement->date_naissance }}</td>
        <td>
          @if($recensement->createur && $recensement->createur->id === auth()->id())
              <span class="fw-semibold text-success">Moi-même</span>
          @else
              @if($recensement->createur)
                <a href="{{ route('agent.index', ['agent_id' => $recensement->createur->id]) }}" class="fw-semibold text-primary text-decoration-underline">
                  {{ $recensement->createur->name }}
                </a>
              @else
                —
              @endif
          @endif
        </td>
        <td>
          <div class="dropdown">
            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Action
            </button>
            <ul class="dropdown-menu">
              <li>
                <button type="button" class="dropdown-item btn-edit" data-id="{{ $recensement->id }}" data-url-show="{{ route('recensement.show', $recensement->id) }}" data-url-update="{{ route('recensement.update', $recensement->id) }}">Modifier</button>
              </li>
              <li><hr class="dropdown-divider"></li>
              @if(Auth::user()->role == 1)
              <li>
                <form method="POST" action="{{ route('recensement.destroy', $recensement->id) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item text-danger">Supprimer</button>
                </form>
              </li>
              @endif
            </ul>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="13" class="text-center text-muted">Aucune donnée disponible.</td>
      </tr>
    @endforelse
  </tbody>
</table>

                    {{ $recensements->links() }}
                  </div>
                </div>
              </div>
            </div>
           
          </div>
        
       
   
@endsection

@push('js')
<script>
  (function(){
    const csrfToken = '{{ csrf_token() }}';
    let editModalEl;
    let bsEditModal;
    let formEl;

    function ensureModal() {
      editModalEl = document.getElementById('editRecensementModal');
      if (!editModalEl) return;
      bsEditModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
      formEl = editModalEl.querySelector('form');
    }

    document.addEventListener('click', async function(e){
      const btn = e.target.closest('.btn-edit');
      if (!btn) return;
      e.preventDefault();
      ensureModal();
      if (!bsEditModal) return;

      const showUrl = btn.getAttribute('data-url-show');
      const updateUrl = btn.getAttribute('data-url-update');
      formEl.setAttribute('data-update-url', updateUrl);

      // Clear form
      formEl.reset();

      try {
        const res = await fetch(showUrl, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) throw new Error('Load failed');
        const data = await res.json();
        // Populate fields
        formEl.querySelector('[name="nom"]').value = data.nom ?? '';
        formEl.querySelector('[name="date_naissance"]').value = data.date_naissance ?? '';
        formEl.querySelector('[name="quartier"]').value = data.quartier ?? '';
        formEl.querySelector('[name="telephone"]').value = data.telephone ?? '';
        formEl.querySelector('[name="numero_whatsapp"]').value = data.numero_whatsapp ?? '';
        formEl.querySelector('[name="situation_professionnelle"]').value = data.situation_professionnelle ?? '';
        formEl.querySelector('[name="ceb"]').value = data.ceb ?? '';
        formEl.querySelector('[name="baptise"]').value = String(Number(Boolean(data.baptise)));
        formEl.querySelector('[name="confirme"]').value = String(Number(Boolean(data.confirme)));
        formEl.querySelector('[name="profession_de_foi"]').value = String(Number(Boolean(data.profession_de_foi)));
        formEl.querySelector('[name="situation_matrimoniale"]').value = data.situation_matrimoniale ?? '';

formEl.querySelector('[name="situation_professionnelle"]').value = data.situation_professionnelle ?? '';


        bsEditModal.show();
      } catch(err) {
        alert("Impossible de charger l'enregistrement.");
      }
    });
    

    document.addEventListener('submit', async function(e){
      if (!e.target.matches('#editRecensementForm')) return;
      e.preventDefault();
      const updateUrl = e.target.getAttribute('data-update-url');
      const formData = new FormData(e.target);
      formData.append('_token', csrfToken);
      formData.append('_method', 'PATCH');
      try {
        const res = await fetch(updateUrl, {
          method: 'POST',
          headers: { 'Accept': 'application/json' },
          body: formData
        });
        if (!res.ok) throw new Error('Update failed');
        const out = await res.json();
        if (out && out.success) {
          bsEditModal.hide();
          location.reload();
        } else {
          alert("La mise à jour a échoué.");
        }
      } catch(err) {
        alert("Erreur lors de la mise à jour.");
      }
    });
  })();
</script>

<!-- Modal Edition -->
<div class="modal fade" id="editRecensementModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Modifier un recensement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <form id="editRecensementForm">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nom et Prénoms</label>
              <input type="text" name="nom" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date de naissance</label>
              <input type="date" name="date_naissance" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Quartier</label>
              <input type="text" name="quartier" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Téléphone</label>
              <input type="text" name="telephone" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">WhatsApp</label>
              <input type="text" name="numero_whatsapp" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
              <label class="form-label">Situation professionnelle</label>
              <select name="situation_professionnelle" class="form-select form-select-sm" required>
                <option value="">Sélectionnez une option</option>
                <option value="Menagere">Ménagère</option>
                <option value="Eleve">Élève</option>
                <option value="Etudiant">Étudiant</option>
                <option value="RechercheEmploi">Quête d’emploi</option>
                <option value="Agentlibre">Agent libre</option>
                <option value="Commercant(e)">Commerçant(e)</option>
                <option value="Fonctionnaire">Fonctionnaire</option>
                <option value="SalariePrive">Salarié privé</option>
                <option value="Entrepreneur">Entrepreneur</option>
                <option value="Retraite">Retraité</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">C.E.B</label>
              <select name="ceb" class="form-select form-select-sm" required>
                <option value="">Sélectionnez une C.E.B</option>
                <option value="Inconnue">Inconnue</option>
                <option value="Bienheureuse Caroline">Bienheureuse Caroline</option>
                <option value="Saint Antoine de Padoue">Saint Antoine de Padoue</option>
                <option value="Saint David">Saint David</option>
                <option value="Saint Jean Baptiste">Saint Jean Baptiste</option>
                <option value="Saint Jean l’Évangéliste">Saint Jean l’Évangéliste</option>
                <option value="Saint Jean Marie-Vianney">Saint Jean Marie-Vianney</option>
                <option value="Saint Joseph Artisan">Saint Joseph Artisan</option>
                <option value="Saint Joseph Époux">Saint Joseph Époux</option>
                <option value="Saint Julien">Saint Julien</option>
                <option value="Saint Michel Archange">Saint Michel Archange</option>
                <option value="Saint Paul">Saint Paul</option>
                <option value="Saint Pierre">Saint Pierre</option>
                <option value="Saint Raphaël">Saint Raphaël</option>
                <option value="Sainte Bernadette">Sainte Bernadette</option>
                <option value="Sainte Famille">Sainte Famille</option>
                <option value="Sainte Rita">Sainte Rita</option>
                <option value="Sainte Thérèse de l’Enfant Jésus">Sainte Thérèse de l’Enfant Jésus</option>
                <option value="Sainte Trinité">Sainte Trinité</option>
              </select>
            </div>
              <div class="col-md-6">
              <label class="form-label">Situation Matrimoniale</label>
              <select name="situation_matrimoniale" class="form-select form-select-sm">
                <option value="0">Célibataire</option>
                <option value="1">Marié(e)</option>
                <option value="2">Divorcé(e)</option>
                <option value="3">Veuf/veuve</option>
                <option value="4">Mariage Traditionnel</option>
                <option value="5">Autre</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Baptisé</label>
              <select name="baptise" class="form-select form-select-sm">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Confirmé</label>
              <select name="confirme" class="form-select form-select-sm">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Prof. de foi</label>
              <select name="profession_de_foi" class="form-select form-select-sm">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
            </div>
          
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endpush