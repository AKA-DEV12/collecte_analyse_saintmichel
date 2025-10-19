@extends('template.body')

{{-- Inclusion des fichiers CSS et JS externes --}}
@push('css')
 <!-- Styles personnalisés -->
<style>
       
/* 
        body {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
                        url('/placeholder.svg?height=1080&width=1920') center/cover no-repeat fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }
*/
        .glass-container {
            background: var(--bs-gray-100);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--bs-gray-100);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 0;
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        } 

        .header-section {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9), rgba(59, 130, 246, 0.9));
            padding: 3rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-section h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header-section p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            margin: 0;
        }

        .info-badge {
            background: rgba(16, 185, 129, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .info-badge svg {
            width: 24px;
            height: 24px;
            fill: #10b981;
        }

        .form-section {
            padding: 2.5rem;
        }

        .form-label {
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            color: white;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus, .form-select:focus {
            /* background: rgba(255, 255, 255, 0.25); */
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
            color: white;
            outline: none;
        }

        .form-select {
            color: white;
           
        }

        .form-select option {
            background: rgba(30, 58, 138, 0.95);
            color: white;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6, #1e3a8a);
            border: none;
            border-radius: 12px;
            color: white;
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
            background: linear-gradient(135deg, #2563eb, #1e40af);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Custom date input styling */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 1.8rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .glass-container {
                margin: 0 1rem;
            }
        }
    </style>
@endpush

@section('content')
<div class="row" style="padding: 40px 10px 10px 10px;">
  <div class="col-md-2">
    <button class="btn btn-outline-primary btn-sm fw-bold" onclick="window.history.back();">
      Retour
    </button>
  </div>
</div>
 <div class="container">
  
           <div class="w-30">
       
        <img style="margin-left: 100px;" src="{{asset('assets/images/logos/logo.png')}}" width="73" height="auto" alt="">
        
      </div>
      
        <div class="glass-container">
            <div class="header-section">
                <h1>Recensement des Paroissiens
</h1>
                <p>Remplissez ce formulaire pour le recensement des paroissiens de la Paroisse Saint Michel d'Adjamé

</p>
            </div>

            <div style="background: rgb(56, 56, 90);">

  
            
                    
                    @include('flashmessage')

            <div class="form-section" >
              <form id="parishForm" method="POST" action="{{ route('recensement.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">

        <!-- Nom -->
        <div class="col-md-6">
            <label for="nom" class="form-label">Nom et Prénoms *</label>
            <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez votre nom complet" required>
        </div>

        <!-- Date de naissance -->
        <div class="col-md-6">
            <label for="date_naissance" class="form-label">Date de naissance *</label>
            <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
        </div>

        <!-- Quartier -->
        <div class="col-md-6">
            <label for="quartier" class="form-label">Quartier / Lieu d’habitation *</label>
            <input type="text" name="quartier" id="quartier" class="form-control" placeholder="Ex : Koumassi, Yopougon..." required>
        </div>

        <!-- Téléphone -->
        <div class="col-md-6">
            <label for="telephone" class="form-label">Numéro de téléphone *</label>
            <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Ex : 0700000000" required>
        </div>

        <!-- WhatsApp -->
        <div class="col-md-6">
            <label for="numero_whatsapp" class="form-label">Numéro WhatsApp (facultatif)</label>
            <input type="text" name="numero_whatsapp" id="numero_whatsapp" class="form-control" placeholder="Ex : 0700000000">
        </div>

        <!-- Situation Professionnelle -->
        <div class="col-md-6">
            <label for="situation_professionnelle" class="form-label">Situation professionnelle *</label>
            <select class="form-select" name="situation_professionnelle" id="situation_professionnelle" required>
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

        <!-- CEB -->
        <div class="col-md-6">
            <label for="ceb" class="form-label">C.E.B </label>
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

        <!-- Baptisé -->
<div class="col-md-3">
    <label for="baptise" class="form-label">Baptisé(e) *</label>
    <select name="baptise" id="baptise" class="form-select" required>
        <option value="">Sélectionnez une option</option>
        <option value="1">Oui</option>
        <option value="0">Non</option>
    </select>
</div>

<!-- Profession de foi -->
<div class="col-md-3">
    <label for="profession_de_foi" class="form-label">Profession de foi *</label>
    <select name="profession_de_foi" id="profession_de_foi" class="form-select" required>
        <option value="">Sélectionnez une option</option>
        <option value="1">Oui</option>
        <option value="0">Non</option>
    </select>
</div>

<!-- Confirmé -->
<div class="col-md-6">
    <label for="confirme" class="form-label">Confirmé(e) *</label>
    <select name="confirme" id="confirme" class="form-select" required>
        <option value="">Sélectionnez une option</option>
        <option value="1">Oui</option>
        <option value="0">Non</option>
    </select>
</div>



<!-- Marié -->
<div class="col-md-6">
    <label for="situation_matrimoniale" class="form-label">Situation Matrimoniale *</label>
     <select class="form-select" name="situation_matrimoniale" id="situation_matrimoniale" required>
                <option value="" selected>Sélectionnez une option</option>
                <option value="0">Célibataire</option>
                <option value="1">Marié(e)</option>
                <option value="2">Divorcé(e)</option>
                <option value="3">Veuf/veuve</option>
                <option value="4">Mariage Traditionnel</option>
                <option value="5">Autre</option>
            </select>
</div>


        <!-- Bouton -->
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary">Soumettre le formulaire</button>
        </div>

    </div>
</form>

            </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
     <script>
       

        // Add smooth focus effects
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.2s ease';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
@endpush