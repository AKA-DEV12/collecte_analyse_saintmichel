@extends('template.body')

{{-- Inclusion des fichiers CSS et JS externes --}}
@push('css')
  <style>
    :root {
  --primary-color: #C21224FF;
  --secondary-color: #6c757d;
  --success-color: #198754;
  --danger-color: #dc3545;
  --light-bg: #f8f9fa;
  --border-color: #dee2e6;
}

body {
  background: var(--light-bg);
  min-height: 100vh;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.card {
  border-radius: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}

.field-card {
  border: 2px solid var(--border-color);
  border-radius: 12px;
  transition: all 0.3s ease;
  background: white;
  margin-bottom: 1.5rem;
  animation: slideIn 0.3s ease;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.field-card:hover {
  border-color: var(--primary-color);
  box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.15);
}

.field-header {
  background: linear-gradient(135deg,  #1a97f5 0%, #ffee33 100%);
  color: white;
  border-radius: 10px 10px 0 0;
  padding: 1rem 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.field-number {
  background: rgba(255, 255, 255, 0.2);
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-weight: 600;
}

.btn-remove-field {
  background: #dc3545e6;
  border: none;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.btn-remove-field:hover {
  background: var(--danger-color);
  transform: scale(1.05);
}

.form-label {
  color: #495057;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.form-control,
.form-select {
  border: 2px solid var(--border-color);
  border-radius: 8px;
  padding: 0.75rem;
  transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.form-check-input {
  width: 1.25rem;
  height: 1.25rem;
  margin-top: 0.125rem;
  cursor: pointer;
}

.form-check-input:checked {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.options-container {
  background: var(--light-bg);
  border-radius: 8px;
  padding: 1rem;
  margin-top: 1rem;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.option-item {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
  animation: slideIn 0.2s ease;
}

.btn-add-option,
.btn-remove-option {
  border-radius: 8px;
  transition: all 0.3s ease;
}

.btn-add-option:hover,
.btn-remove-option:hover {
  transform: scale(1.05);
}

.btn-outline-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.25);
}

.btn-success,
.btn-primary {
  border-radius: 10px;
  padding: 0.75rem 2rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-success:hover,
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.modal-content {
  border-radius: 15px;
  border: none;
}

.modal-header {
  border-radius: 15px 15px 0 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .field-header {
    flex-direction: column;
    gap: 0.5rem;
    text-align: center;
  }

  .btn-success,
  .btn-primary {
    padding: 0.5rem 1rem;
  }
}

/* Animation pour les alertes */
.alert {
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

  </style>
@endpush

@section('content')

<div >
<!-- Bouton d’ouverture du modal -->
<button style="margin-bottom: 20px; background: var(--primary-color); color: #fff;" type="button" 
        class="btn btn-lg flex-grow-1 mb-20" 
        
        data-bs-toggle="modal" 
        data-bs-target="#previewModal">
    <i class="bi bi-eye me-2"></i> Ajouter un Agent
</button>

@include('flashmessage')
<!-- Modal d’ajout d’un agent -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            
            <!-- En-tête -->
            <div style="background: var(--primary-color)" class="modal-header text-white">
                <h5 class="modal-title text-white" id="previewModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Ajouter un Agent
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <!-- Corps du modal -->
            <div class="modal-body p-4">
                <form action="{{ route('agent.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">

                        <!-- Nom -->
                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold">Nom complet</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-4">
                            <label for="tel" class="form-label fw-bold">Téléphone</label>
                            <input type="text" name="tel" id="tel" class="form-control" value="{{ old('tel') }}" required>
                        </div>

                        <!-- Type agent -->
                         <div class="col-md-4">
                            <label for="tel" class="form-label fw-bold">Type d‘agent</label>
                            <select class="form-select" name="type_agent" id="type_agent" required>
                                <option value="" selected>Sélectionnez un type d‘agent</option>
                                <option value="0">Agent de Récensement</option>
                                <option value="1">Agent Libre</option>
                            </select>
                          </div>

                        <!-- Fonction -->
                        <div class="col-md-6">
                            <label for="fonction" class="form-label fw-bold">Fonction</label>
                            <input type="text" name="fonction" id="fonction" class="form-control" value="{{ old('fonction') }}" required>
                        </div>

                        <!-- CEB -->
                        <div class="col-md-6">
                            <label for="ceb" class="form-label">C.E.B </label>
            <select class="form-select" name="ceb" id="ceb" required>
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

                        <!-- Mot de passe -->
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required minlength="6">
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="col-md-6">
                            <label for="c_password" class="form-label fw-bold">Confirmer le mot de passe</label>
                            <input type="password" name="c_password" id="c_password" class="form-control" required minlength="6">
                        </div>
                    </div>

                 
                    <!-- Bouton d’envoi -->
                    <div class="text-end mt-4">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                        <button type="submit" class="btn " style="background: var(--primary-color); color: #fff;">
                            <i class="bi bi-save me-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>

           
        </div>
    </div>
</div>
<div class="modal fade" id="previewModalUpdate" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            
            <div style="background: var(--primary-color)" class="modal-header text-white">
                <h5 class="modal-title text-white" id="previewModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Modification de l'Agent <span id="agentNameModal"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <div class="modal-body p-4">
                <form id="formUpdateAgent" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="updateName" class="form-label fw-bold">Nom complet</label>
                            <input type="text" name="name" id="updateName" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="updateTel" class="form-label fw-bold">Téléphone</label>
                            <input type="text" name="tel" id="updateTel" class="form-control" required>
                        </div>
                         <!-- Type agent -->
                         <div class="col-md-4">
                            <label for="tel" class="form-label fw-bold">Type d‘agent</label>
                            <select class="form-select" name="type_agent" id="typeAgent" required>
                                <option value="" selected>Sélectionnez un type d‘agent</option>
                                <option value="0">Agent de Récensement</option>
                                <option value="1">Agent Libre</option>
                            </select>
                          </div>
                        <div class="col-md-6">
                            <label for="updateFonction" class="form-label fw-bold">Fonction</label>
                            <input type="text" name="fonction" id="updateFonction" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="updateCeb" class="form-label fw-bold">CEB</label>
                            <input type="text" name="ceb" id="updateCeb" class="form-control" required>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn" style="background: var(--primary-color); color: #fff;">
                            <i class="bi bi-save me-2"></i> Modifier
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>





    <div class="row">
        <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-md-flex align-items-center">
                    <div>
                      <h4 class="card-title">Liste des donnees</h4>
                      
                    </div>
         
                  </div>
                  <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom & Prénom</th>
            <th>Numéro</th>
            <th>Type Agent</th>
            <th>CEB</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($agents as $index => $agent)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $agent->name }}</td>
            <td>{{ $agent->tel }}</td>
            <td>{{ $agent->fonction }}</td>
            <td>{{ $agent->ceb }}</td>
           <td>
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="actionDropdown{{ $agent->id }}" data-bs-toggle="dropdown" aria-expanded="false">
            
        </button>
        <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $agent->id }}">
       
<li>
    <a href="javascript:void(0);" 
       class="dropdown-item" 
       onclick="openUpdateModal({{ $agent->id }})">
        <i class="bi bi-pencil-square me-2"></i> Modifier
    </a>
</li>

            <li>
                <form action="{{ route('agent.delete', $agent->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-trash me-2"></i> Supprimer
                    </button>
                </form>
            </li>
        </ul>
    </div>
</td>

        </tr>
        @endforeach
    </tbody>
</table>

                  </div>
                </div>
              </div>
            </div>
    </div>
@endsection
@push('js')
   <script>
document.addEventListener('DOMContentLoaded', function() {

    window.openUpdateModal = function(agentId) {
        fetch(`/agents/modification-de-champs-agent/${agentId}`)
            .then(response => {
                if (!response.ok) throw new Error('Erreur AJAX : ' + response.status);
                return response.json();
            })
            .then(agent => {
                // Remplir le modal
                document.getElementById('agentNameModal').textContent = agent.name;
                document.getElementById('updateName').value = agent.name;
                document.getElementById('updateTel').value = agent.tel;
                document.getElementById('updateFonction').value = agent.fonction;
                document.getElementById('updateCeb').value = agent.ceb;
                document.getElementById('typeAgent').value = agent.type_agent;

                // Mettre à jour l'action du formulaire
                const form = document.getElementById('formUpdateAgent');
                form.action = `/agents/mise-a-jour/${agent.id}`;

                // Afficher le modal
                const updateModal = new bootstrap.Modal(document.getElementById('previewModalUpdate'));
                updateModal.show();
            })
            .catch(error => {
                console.error(error);
                alert('Impossible de charger les données de l’agent.');
            });
    }

});
</script>
@endpush