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
                <h1>{{$donnee->titre}}</h1>
                <p>{{$donnee->description}}</p>
            </div>

            <div style="background: rgb(56, 56, 90);">

            
            <div class="text-center">
                <div class="info-badge" style="color: #000;">
                    
                    {{-- <span>Nous avons <strong>17 Paroissiens enregistrés</strong></span> --}}
                    @include('flashmessage')
                </div>
            </div>

            <div class="form-section" >
                <form id="parishForm" method="POST" action="{{route('collecte.enregistrement.store')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="number" name="enregistrement_id" value="{{$donnee->id}}" hidden>
                    <div class="row g-4">
                      @forelse ($collections as $collection)
    @if ($collection->type === 'select')
        <div class="col-md-6">
            <label for="{{$collection->label}}" class="form-label">
                {{$collection->label}}
                @if ($collection->obligatoire == 1)
                    <span style="color: #C21224FF;">*</span>
                @endif
            </label>
            <select class="form-select" id="{{$collection->label}}" name="{{$collection->label}}" 
                     required >
                <option value="">Sélectionnez une option</option>
                @forelse ($collection->options as $option)
                    <option value="{{$option}}">{{$option}}</option>
                @empty
                    <option disabled>Aucune option disponible</option>
                @endforelse
            </select>
        </div>

    @elseif($collection->type === 'radio')
        <div class="col-md-6">
            <label class="form-label">
                {{$collection->label}}
                @if ($collection->obligatoire == 1)
                    <span style="color: #C21224FF;">*</span>
                @endif
            </label>
            @forelse ($collection->options as $index => $option)
                <div class="form-check">
                    <input class="form-check-input" type="radio" 
                           name="{{$collection->label}}" 
                           id="{{$collection->label}}_{{$index}}" 
                           value="{{$option}}"
                             >
                    <label class="form-check-label" for="{{$collection->label}}_{{$index}}">
                        {{$option}}
                    </label>
                </div>
            @empty
                <p class="text-muted">Aucune option disponible</p>
            @endforelse
        </div>

    @elseif($collection->type === 'checkbox')
        <div class="col-md-6">
            <label class="form-label">
                {{$collection->label}}
                @if ($collection->obligatoire == 1)
                    <span style="color: #C21224FF;">*</span>
                @endif
            </label>
            @forelse ($collection->options as $index => $option)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="{{$collection->label}}[]" 
                           id="{{$collection->label}}_{{$index}}" 
                           value="{{$option}}" >
                    <label class="form-check-label" for="{{$collection->label}}_{{$index}}">
                        {{$option}}
                    </label>
                </div>
            @empty
                <p class="text-muted">Aucune option disponible</p>
            @endforelse
        </div>

    @else
        <div class="col-md-6">
            <label for="{{$collection->label}}" class="form-label">
                {{$collection->label}}
                @if ($collection->obligatoire == 1)
                    <span style="color: #C21224FF;">*</span>
                @endif
            </label>
            <input type="{{$collection->type}}" 
                   class="form-control" 
                   id="{{$collection->label}}" 
                   name="{{$collection->label}}"
                   placeholder="{{$collection->label}}" 
                   @if ($collection->obligatoire === 1) value="-" required @endif>
        </div>
    @endif

@empty
    <div class="col-12">
        <p class="text-center text-muted">Aucune donnée disponible</p>
    </div>
@endforelse
                      
                       
{{-- 
                        <div class="col-md-6">
                            <label for="professionFoi" class="form-label">Profession de foi *</label>
                            <select class="form-select" id="professionFoi" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="marie" class="form-label">Marié *</label>
                            <select class="form-select" id="marie" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone *</label>
                            <input type="tel" class="form-control" id="telephone" placeholder="+225 XX XX XX XX XX" required>
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label">Numéro whatsapp</label>
                            <input type="tel" class="form-control" id="whatsapp" placeholder="+225 XX XX XX XX XX">
                        </div>

                        <div class="col-md-6">
                            <label for="situationPro" class="form-label">Situation Professionnelle *</label>
                            <select class="form-select" id="situationPro" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="employe">Employé</option>
                                <option value="independant">Indépendant</option>
                                <option value="etudiant">Étudiant</option>
                                <option value="chomage">Sans emploi</option>
                                <option value="retraite">Retraité</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nomCEB" class="form-label">Nom de la CEB</label>
                            <input type="text" class="form-control" id="nomCEB" placeholder="Nom de votre CEB">
                        </div> --}}

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-submit">Soumettre le formulaire</button>
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