@extends('template.body')

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
  background: rgba(220, 53, 69, 0.9);
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
<div class="container-lg" style="margin-top: -115px !important;">
    <div class="row" style="padding: 40px 10px 10px 10px;">
  <div class="col-md-2">
    <a href="{{route('collecte.index')}}" class="btn btn-outline-primary btn-sm fw-bold">
      Retour
    </a>
  </div>
</div>
    <div class="row justify-content-center">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold" style="color: var(--bs-secondary)">
                <i class="bi bi-clipboard-data me-2"></i>
                Modification : <strong>{{ $donnee->titre }}</strong>
            </h1>
            <p class="text-muted">Créez et personnalisez facilement vos formulaires de collecte de données / sondages</p>
        </div>

        @include('flashmessage')
        <form action="{{ route('collecte.update', $donnee->id) }}" method="POST" id="surveyForm">
            @csrf
            @method('PATCH')

            <div class="card shadow-lg border-0">
                <div class="card-body p-4 p-md-5">
                    {{-- Section info sondage --}}
                    <div class="mb-5">
                        <h3 class="h4 mb-4 border-bottom pb-2" style="color: var(--bs-secondary)">
                            <i class="bi bi-info-circle me-2"></i>
                            Informations du Sondage
                        </h3>

                        <div class="mb-4">
                            <label for="surveyTitle" class="form-label fw-semibold">
                                Titre du Sondage <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg" id="surveyTitle"
                                   name="titre" value="{{ old('titre', $donnee->titre) }}" required>
                            @error('titre')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="surveyDescription" class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea class="form-control" id="surveyDescription" name="description" rows="4"
                                      placeholder="Décrivez l'objectif de votre sondage...">{{ old('description', $donnee->description) }}</textarea>
                            @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Section des champs dynamiques --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="h4 mb-0 border-bottom pb-2 flex-grow-1" style="color: var(--bs-secondary)">
                                <i class="bi bi-list-ul me-2"></i>
                                Champs du Formulaire
                            </h3>
                        </div>

                        <div id="fieldsContainer"></div>

                        <button type="button" class="btn btn-lg w-100 mt-3" id="addFieldBtn"
                                style="background: var(--primary-color); color: #fff;">
                            <i class="bi bi-plus-circle me-2"></i>
                            Ajouter un Champ
                        </button>
                    </div>

                    <input type="hidden" name="champs" id="champsData">
                    @error('champs')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror

                    {{-- Boutons d’action --}}
                    <div class="d-flex gap-3 mt-5 pt-4 border-top">
                        <button type="button" style="background: var(--primary-color); color: #fff;"
                                class="btn btn-lg flex-grow-1" id="previewBtn">
                            <i class="bi bi-eye me-2"></i>
                            Prévisualiser
                        </button>
                        <button type="submit" style="background: var(--bs-secondary); color: #fff;"
                                class="btn btn-lg flex-grow-1" id="saveBtn">
                            <i class="bi bi-save me-2"></i>
                            Enregistrer
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal de prévisualisation --}}
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="bi bi-eye me-2"></i>Prévisualisation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="previewContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    // Champs déjà existants injectés depuis le contrôleur
    const existingFields = @json($champs ?? []);

    let fieldCount = 0;
    const fieldsContainer = document.getElementById("fieldsContainer");
    const addFieldBtn = document.getElementById("addFieldBtn");
    const previewBtn = document.getElementById("previewBtn");

    document.addEventListener("DOMContentLoaded", () => {
        addFieldBtn.addEventListener("click", () => addField());
        previewBtn.addEventListener("click", () => showPreview());

        const surveyForm = document.getElementById("surveyForm");
        surveyForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const fields = collectFieldsData();
            if (!document.getElementById("surveyTitle").value.trim()) {
                alert("Veuillez entrer un titre pour le sondage");
                return;
            }
            if (fields.length === 0) {
                alert("Veuillez ajouter au moins un champ au formulaire");
                return;
            }
            document.getElementById("champsData").value = JSON.stringify(fields);
            surveyForm.submit();
        });

        // Charger les champs existants s’il y en a
        if (Array.isArray(existingFields) && existingFields.length > 0) {
            loadExistingFields(existingFields);
        } else {
            // Si aucun champ existant, on ajoute un champ vide par défaut
            addField();
        }
    });

    function addField() {
        fieldCount++;
        const fieldCard = document.createElement("div");
        fieldCard.className = "field-card";
        fieldCard.dataset.fieldId = fieldCount;

        fieldCard.innerHTML = `
        <div class="field-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-grip-vertical"></i>
                <span class="field-number">Champ ${fieldCount}</span>
            </div>
            <button type="button" class="btn btn-remove-field btn-sm" onclick="removeField(${fieldCount})">
                <i class="bi bi-trash me-1"></i> Supprimer
            </button>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Intitulé du Champ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control field-label" placeholder="Ex: Nom complet" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Type de Champ</label>
                    <select class="form-select field-type" onchange="handleTypeChange(${fieldCount})">
                        <option value="text">Texte</option>
                        <option value="email">Email</option>
                        <option value="number">Nombre</option>
                        <option value="tel">Téléphone</option>
                        <option value="date">Date</option>
                        <option value="time">Heure</option>
                        <option value="url">URL</option>
                        <option value="textarea">Zone de Texte</option>
                        <option value="select">Liste Déroulante</option>
                        <option value="radio">Choix Unique (Radio)</option>
                        <option value="checkbox">Choix Multiple (Checkbox)</option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input field-required" type="checkbox" id="required${fieldCount}">
                        <label class="form-check-label fw-semibold" for="required${fieldCount}">
                            Champ Obligatoire
                        </label>
                    </div>
                </div>
                <div class="col-12 options-section" style="display: none;">
                    <div class="options-container">
                        <label class="form-label fw-semibold mb-3">
                            <i class="bi bi-list-check me-2"></i> Options de Choix
                        </label>
                        <div class="options-list"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-option"
                            onclick="addOption(${fieldCount})">
                            <i class="bi bi-plus-circle me-1"></i> Ajouter une Option
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;

        fieldsContainer.appendChild(fieldCard);
    }

    function removeField(fieldId) {
        const fieldCard = document.querySelector(`[data-field-id="${fieldId}"]`);
        if (fieldCard) {
            fieldCard.remove();
            updateFieldNumbers();
        }
    }

    function updateFieldNumbers() {
        const cards = document.querySelectorAll(".field-card");
        cards.forEach((card, idx) => {
            const numElem = card.querySelector(".field-number");
            if (numElem) {
                numElem.textContent = `Champ ${idx + 1}`;
            }
        });
    }

    function handleTypeChange(fieldId) {
        const card = document.querySelector(`[data-field-id="${fieldId}"]`);
        const sel = card.querySelector(".field-type");
        const optionsSec = card.querySelector(".options-section");
        const multi = ["select", "radio", "checkbox"];
        if (multi.includes(sel.value)) {
            optionsSec.style.display = "block";
            const list = card.querySelector(".options-list");
            if (list.children.length === 0) {
                addOption(fieldId);
            }
        } else {
            optionsSec.style.display = "none";
        }
    }

    function addOption(fieldId) {
        const card = document.querySelector(`[data-field-id="${fieldId}"]`);
        const list = card.querySelector(".options-list");
        const optionItem = document.createElement("div");
        optionItem.className = "option-item";

        const count = list.children.length + 1;
        optionItem.innerHTML = `
            <input type="text" class="form-control option-value" placeholder="Option ${count}" required>
            <button type="button" class="btn btn-sm btn-danger btn-remove-option" onclick="removeOption(this)">
                <i class="bi bi-x-lg"></i> supprimer
            </button>
        `;
        list.appendChild(optionItem);
    }

    function removeOption(btn) {
        const item = btn.parentElement;
        if (item) {
            item.remove();
        }
    }

    function collectFieldsData() {
        const arr = [];
        const cards = document.querySelectorAll(".field-card");
        cards.forEach((card) => {
            const label = card.querySelector(".field-label").value;
            const type = card.querySelector(".field-type").value;
            const required = card.querySelector(".field-required").checked;
            if (!label.trim()) {
                return;
            }
            const obj = { label, type, required };
            const multi = ["select", "radio", "checkbox"];
            if (multi.includes(type)) {
                const opts = [];
                card.querySelectorAll(".option-value").forEach(input => {
                    if (input.value.trim()) {
                        opts.push(input.value.trim());
                    }
                });
                obj.options = opts;
            }
            arr.push(obj);
        });
        return arr;
    }

    function showPreview() {
        const title = document.getElementById("surveyTitle").value;
        const desc = document.getElementById("surveyDescription")?.value || "";
        const fields = collectFieldsData();

        if (!title.trim()) {
            alert("Veuillez entrer un titre pour le sondage");
            return;
        }
        if (fields.length === 0) {
            alert("Veuillez ajouter au moins un champ");
            return;
        }

        let html = `<div class="mb-4"><h2 class="h3 text-primary mb-3">${title}</h2>`;
        if (desc) html += `<p class="text-muted">${desc}</p>`;
        html += `</div><hr class="my-4">`;

        fields.forEach((f, idx) => {
            html += `<div class="preview-field"><label class="form-label fw-semibold">${f.label}`;
            html += f.required ? ' <span class="badge bg-danger ms-2">Obligatoire</span>' : ' <span class="badge bg-secondary ms-2">Facultatif</span>';
            html += `</label>`;

            switch (f.type) {
                case "textarea":
                    html += `<textarea class="form-control" rows="4" ${f.required ? "required" : ""}></textarea>`;
                    break;
                case "select":
                    html += `<select class="form-select" ${f.required ? "required" : ""}><option value="">Sélectionnez une option</option>`;
                    f.options.forEach(opt => {
                        html += `<option value="${opt}">${opt}</option>`;
                    });
                    html += `</select>`;
                    break;
                case "radio":
                    html += `<div class="mt-2">`;
                    f.options.forEach((opt, i) => {
                        html += `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radio${idx}" id="radio${idx}_${i}" ${f.required ? "required" : ""}>
                            <label class="form-check-label" for="radio${idx}_${i}">${opt}</label>
                        </div>`;
                    });
                    html += `</div>`;
                    break;
                case "checkbox":
                    html += `<div class="mt-2">`;
                    f.options.forEach((opt, i) => {
                        html += `<div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox${idx}_${i}">
                            <label class="form-check-label" for="checkbox${idx}_${i}">${opt}</label>
                        </div>`;
                    });
                    html += `</div>`;
                    break;
                default:
                    html += `<input type="${f.type}" class="form-control" ${f.required ? "required" : ""}>`;
            }

            html += `</div>`;
        });

        document.getElementById("previewContent").innerHTML = html;
        const modal = new bootstrap.Modal(document.getElementById("previewModal"));
        modal.show();
    }

    function loadExistingFields(fields) {
        fields.forEach(f => {
            addFieldFromData(f);
        });
    }

    function addFieldFromData(field) {
        fieldCount++;
        const card = document.createElement("div");
        card.className = "field-card";
        card.dataset.fieldId = fieldCount;

        card.innerHTML = `
        <div class="field-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-grip-vertical"></i>
                <span class="field-number">Champ ${fieldCount}</span>
            </div>
            <button type="button" class="btn btn-remove-field btn-sm" onclick="removeField(${fieldCount})">
                <i class="bi bi-trash me-1"></i> Supprimer
            </button>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Intitulé du Champ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control field-label" value="${field.label}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Type de Champ</label>
                    <select class="form-select field-type" onchange="handleTypeChange(${fieldCount})">
                        <option value="text" ${field.type === "text" ? "selected" : ""}>Texte</option>
                        <option value="email" ${field.type === "email" ? "selected" : ""}>Email</option>
                        <option value="number" ${field.type === "number" ? "selected" : ""}>Nombre</option>
                        <option value="tel" ${field.type === "tel" ? "selected" : ""}>Téléphone</option>
                        <option value="date" ${field.type === "date" ? "selected" : ""}>Date</option>
                        <option value="time" ${field.type === "time" ? "selected" : ""}>Heure</option>
                        <option value="url" ${field.type === "url" ? "selected" : ""}>URL</option>
                        <option value="textarea" ${field.type === "textarea" ? "selected" : ""}>Zone de Texte</option>
                        <option value="select" ${field.type === "select" ? "selected" : ""}>Liste Déroulante</option>
                        <option value="radio" ${field.type === "radio" ? "selected" : ""}>Choix Unique (Radio)</option>
                        <option value="checkbox" ${field.type === "checkbox" ? "selected" : ""}>Choix Multiple (Checkbox)</option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input field-required" type="checkbox" id="required${fieldCount}" ${field.required ? "checked" : ""}>
                        <label class="form-check-label fw-semibold" for="required${fieldCount}">
                            Champ Obligatoire
                        </label>
                    </div>
                </div>
                <div class="col-12 options-section" style="display: ${["select", "radio", "checkbox"].includes(field.type) ? "block" : "none"};">
                    <div class="options-container">
                        <label class="form-label fw-semibold mb-3">
                            <i class="bi bi-list-check me-2"></i> Options de Choix
                        </label>
                        <div class="options-list">
                            ${(field.options || []).map((opt, i) => `
                                <div class="option-item">
                                    <input type="text" class="form-control option-value" value="${opt}" required>
                                    <button type="button" class="btn btn-sm btn-danger btn-remove-option" onclick="removeOption(this)">
                                        <i class="bi bi-x-lg"></i> supprimer
                                    </button>
                                </div>
                            `).join("")}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-option" onclick="addOption(${fieldCount})">
                            <i class="bi bi-plus-circle me-1"></i> Ajouter une Option
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;

        fieldsContainer.appendChild(card);
    }
</script>
@endpush
