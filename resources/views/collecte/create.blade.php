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
<div class="row" style="padding: 40px 10px 10px 10px;">
  <div class="col-md-2">
    <a href="{{route('collecte.index')}}" class="btn btn-outline-primary btn-sm fw-bold" >
      Retour
    </a>
  </div>
</div>
    <div class="container-lg" style="margin-top: -85px !important;">
      
        <div class="row justify-content-center">
            {{-- Retour à une seule colonne centrée --}}
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold " style="color: var(--bs-secondary)">
                        <i class="bi bi-clipboard-data me-2"></i>
                        Création d'une Collecte de Donnees ou d'un Sondage
                    </h1>
                    <p class="text-muted">Créez et personnalisés facilement vos formulaires de collecte de donnees/sondages </p>
                </div>

                @include('flashmessage')

                <form action="{{ route('collecte.store') }}" method="POST" id="surveyForm">
                    @csrf
                    
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            {{-- Survey Info Section --}}
                            <div class="mb-5">
                                <h3 class="h4 mb-4 border-bottom pb-2" style="color: var(--bs-secondary)">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Informations 
                                </h3>
                                
                                <div class="mb-4">
                                    <label for="surveyTitle" class="form-label fw-semibold">
                                        Titre  <span class="text-danger">*</span>
                                    </label>
                                    {{-- Suppression de l'événement oninput --}}
                                    <input type="text" class="form-control form-control-lg" id="surveyTitle" 
                                           name="titre" placeholder="Ex: Enquête paroissiale; Inscription ..." required>
                                    @error('titre')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                
                                   <div class="mb-4">
                                    <label for="surveyDescription" class="form-label fw-semibold">
                                        Description
                                    </label>
                                    {{-- Suppression de l'événement oninput --}}
                                    <textarea class="form-control" id="surveyDescription" name="description" rows="4" 
                                              placeholder="Décrivez l'objectif de votre sondage..."></textarea>
                                    @error('description')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                
                                <div class=" mb-4">
                            <label for="tel" class="form-label fw-bold">Type d‘agent</label>
                            <select class="form-select" name="agent" id="agent" required>
                                <option value="" selected>Sélectionnez un type d‘agent</option>
                                <option value="0">Agent de Récensement</option>
                                <option value="1">Agent Libre</option>
                            </select>
                          </div>
                           
                               
                            </div>

                            {{-- Fields Section --}}
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 class="h4 mb-0 border-bottom pb-2 flex-grow-1" style="color: var(--bs-secondary)">
                                        <i class="bi bi-list-ul me-2"></i>
                                        Champs du Formulaire
                                    </h3>
                                </div>

                                <div id="fieldsContainer">
                                    {{-- Fields will be added here dynamically --}}
                                </div>

                                <button type="button" class="btn btn-lg w-100 mt-3" id="addFieldBtn" style="background: var(--primary-color); color: #fff;">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Ajouter un Champ
                                </button>
                            </div>

                            <input type="hidden" name="champs" id="champsData">
                            @error('champs')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            {{-- Action Buttons --}}
                            <div class="d-flex gap-3 mt-5 pt-4 border-top">
                                <button type="button" style="background: var(--primary-color); color: #fff;" class="btn btn-lg flex-grow-1" id="previewBtn">
                                    <i class="bi bi-eye me-2"></i>
                                    Prévisualiser en Modal
                                </button>
                                <button type="submit" style="background: var(--bs-secondary); color :#fff;" class="btn btn-lg flex-grow-1" id="saveBtn">
                                    <i class="bi bi-save me-2"></i>
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    {{-- Preview Modal --}}
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-eye me-2"></i>
                        Prévisualisation 
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="previewContent">
                    {{-- Preview content will be inserted here --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Inclusion du fichier JavaScript externe --}}
@push('js')
  <script>
let fieldCount = 0

const addFieldBtn = document.getElementById("addFieldBtn")
const previewBtn = document.getElementById("previewBtn")
const fieldsContainer = document.getElementById("fieldsContainer")

function addField() {
  fieldCount++
  const fieldCard = document.createElement("div")
  fieldCard.className = "field-card"
  fieldCard.dataset.fieldId = fieldCount

  fieldCard.innerHTML = `
        <div class="field-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-grip-vertical"></i>
                <span class="field-number">Champ ${fieldCount}</span>
            </div>
            <button type="button" class="btn btn-remove-field btn-sm" onclick="removeField(${fieldCount})">
                <i class="bi bi-trash me-1"></i>
                Supprimer
            </button>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Intitulé du Champ <span class="text-danger">*</span>
                    </label>
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
                            <i class="bi bi-list-check me-2"></i>
                            Options de Choix
                        </label>
                        <div class="options-list"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-option" onclick="addOption(${fieldCount})">
                            <i class="bi bi-plus-circle me-1"></i>
                            Ajouter une Option
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `

  fieldsContainer.appendChild(fieldCard)
}

function removeField(fieldId) {
  const fieldCard = document.querySelector(`[data-field-id="${fieldId}"]`)
  if (fieldCard) {
    fieldCard.style.animation = "slideOut 0.3s ease"
    setTimeout(() => {
      fieldCard.remove()
      updateFieldNumbers()
    }, 300)
  }
}

function updateFieldNumbers() {
  const fieldCards = document.querySelectorAll(".field-card")
  fieldCards.forEach((card, index) => {
    const fieldNumber = card.querySelector(".field-number")
    if (fieldNumber) {
      fieldNumber.textContent = `Champ ${index + 1}`
    }
  })
}

function handleTypeChange(fieldId) {
  const fieldCard = document.querySelector(`[data-field-id="${fieldId}"]`)
  const typeSelect = fieldCard.querySelector(".field-type")
  const optionsSection = fieldCard.querySelector(".options-section")

  const multiChoiceTypes = ["select", "radio", "checkbox"]

  if (multiChoiceTypes.includes(typeSelect.value)) {
    optionsSection.style.display = "block"
    // Ajouter une option par défaut si aucune n'existe
    const optionsList = fieldCard.querySelector(".options-list")
    if (optionsList.children.length === 0) {
      addOption(fieldId)
    }
  } else {
    optionsSection.style.display = "none"
  }
}

function addOption(fieldId) {
  const fieldCard = document.querySelector(`[data-field-id="${fieldId}"]`)
  const optionsList = fieldCard.querySelector(".options-list")

  const optionItem = document.createElement("div")
  optionItem.className = "option-item"

  const optionCount = optionsList.children.length + 1

  optionItem.innerHTML = `
        <input type="text" class="form-control option-value" placeholder="Option ${optionCount}" required>
        <button type="button" class="btn btn-sm btn-danger btn-remove-option" onclick="removeOption(this)">
            <i class="bi bi-x-lg"></i>
            supprimer
        </button>
    `

  optionsList.appendChild(optionItem)
}

function removeOption(button) {
  const optionItem = button.parentElement
  optionItem.style.animation = "slideOut 0.2s ease"
  setTimeout(() => {
    optionItem.remove()
  }, 200)
}

function collectFieldsData() {
  const fields = []
  const fieldCards = document.querySelectorAll(".field-card")

  fieldCards.forEach((card) => {
    const label = card.querySelector(".field-label").value
    const type = card.querySelector(".field-type").value
    const required = card.querySelector(".field-required").checked

    if (!label.trim()) return

    const fieldData = {
      label: label,
      type: type,
      required: required,
    }

    // Collecter les options si c'est un champ à choix multiples
    const multiChoiceTypes = ["select", "radio", "checkbox"]
    if (multiChoiceTypes.includes(type)) {
      const options = []
      const optionInputs = card.querySelectorAll(".option-value")
      optionInputs.forEach((input) => {
        if (input.value.trim()) {
          options.push(input.value.trim())
        }
      })
      fieldData.options = options
    }

    fields.push(fieldData)
  })

  return fields
}

function showPreview() {
  const surveyTitle = document.getElementById("surveyTitle").value
  const surveyDescription = document.getElementById("surveyDescription").value
  const fields = collectFieldsData()

  if (!surveyTitle.trim()) {
    alert("Veuillez entrer un titre pour le sondage")
    return
  }

  if (fields.length === 0) {
    alert("Veuillez ajouter au moins un champ au formulaire")
    return
  }

  let previewHTML = `
        <div class="mb-4">
            <h2 class="h3 text-primary mb-3">${surveyTitle}</h2>
            ${surveyDescription ? `<p class="text-muted">${surveyDescription}</p>` : ""}
        </div>
        <hr class="my-4">
    `

  fields.forEach((field, index) => {
    previewHTML += `
            <div class="preview-field">
                <label class="form-label fw-semibold">
                    ${field.label}
                    ${field.required ? '<span class="badge bg-danger ms-2">Obligatoire</span>' : '<span class="badge bg-secondary ms-2">Facultatif</span>'}
                </label>
        `

    switch (field.type) {
      case "textarea":
        previewHTML += `<textarea class="form-control" rows="4" ${field.required ? "required" : ""}></textarea>`
        break

      case "select":
        previewHTML += `<select class="form-select" ${field.required ? "required" : ""}>
                    <option value="">Sélectionnez une option</option>
                    ${field.options.map((opt) => `<option value="${opt}">${opt}</option>`).join("")}
                </select>`
        break

      case "radio":
        previewHTML += `<div class="mt-2">`
        field.options.forEach((opt, i) => {
          previewHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio${index}" id="radio${index}_${i}" ${field.required ? "required" : ""}>
                            <label class="form-check-label" for="radio${index}_${i}">${opt}</label>
                        </div>
                    `
        })
        previewHTML += `</div>`
        break

      case "checkbox":
        previewHTML += `<div class="mt-2">`
        field.options.forEach((opt, i) => {
          previewHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox${index}_${i}">
                            <label class="form-check-label" for="checkbox${index}_${i}">${opt}</label>
                        </div>
                    `
        })
        previewHTML += `</div>`
        break

      default:
        previewHTML += `<input type="${field.type}" class="form-control" ${field.required ? "required" : ""}>`
    }

    previewHTML += `</div>`
  })

  document.getElementById("previewContent").innerHTML = previewHTML

  const modal = new bootstrap.Modal(document.getElementById("previewModal"))
  modal.show()
}

document.addEventListener("DOMContentLoaded", () => {
  addFieldBtn.addEventListener("click", addField)
  previewBtn.addEventListener("click", showPreview)

  // Validation avant soumission du formulaire
  const surveyForm = document.getElementById("surveyForm")
  surveyForm.addEventListener("submit", (e) => {
    e.preventDefault()

    const surveyTitle = document.getElementById("surveyTitle").value
    const fields = collectFieldsData()

    if (!surveyTitle.trim()) {
      alert("Veuillez entrer un titre pour le sondage")
      return
    }

    if (fields.length === 0) {
      alert("Veuillez ajouter au moins un champ au formulaire")
      return
    }

    // Stocker les champs dans l'input hidden en JSON
    document.getElementById("champsData").value = JSON.stringify(fields)

    // Soumettre le formulaire
    surveyForm.submit()
  })
})

// Animation CSS pour slideOut
const style = document.createElement("style")
style.textContent = `
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }
`
document.head.appendChild(style)

  </script>
@endpush
