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
    <button class="btn btn-outline-primary btn-sm fw-bold" onclick="window.history.back();">
      Retour
    </button>
  </div>
</div>

  <!-- Bloc Statistiques -->
  <div class="col-lg-6">
    <div class="card shadow-sm border-0 rounded-4 w-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 class=" fw-bold mb-1">{{$donnees->titre}}</h1>
            <p class="card-subtitle text-muted"></p>
          </div>
         
        </div>

        <!-- Exemple de mini statistiques -->
        <div class="row text-center " style="margin-top: 58px;">
            <div class="col-md-6">
             <h4 class="fw-bolder text-primary mb-0">{{$donnees->created_at->format('d/m/y H:i')}}</h4>
            <small class="text-muted"> Date de Creation</small>
          </div>
          <div class="col-md-6">
            @php
                $total = $donnees->enregistrements->count() / $collections->count();
                
            @endphp
          
             <h4 class="fw-bolder text-primary mb-0">{{ $total }}</h4>
            <small class="text-muted"> Totales</small>
          </div>
          <div class="col-md-6" style="margin-top: 40px;"> <!-- Bouton : Voir le formulaire -->
            <a href="{{ route('collecte.formulaire', $donnees->id) }}" class="text-decoration-none">
      <button class="btn btn-outline-primary btn-sm fw-bold">
        Voir le formulaire
      </button>
    </a>
          </div>

           <div class="col-md-6" style="margin-top: 40px;">
             <!-- Bouton : Modifier le formulaire -->
    <a href="{{ route('collecte.edit', $donnees->id) }}" class="text-decoration-none">
      <button class="btn btn-outline-warning btn-sm fw-bold">
        Modifier le formulaire
      </button>
    </a>
          </div>
         
        </div>
      </div>
    </div>
  </div>

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
            <button class="btn btn-outline-success btn-sm fw-bold">Exporter</button>
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
            <button class="btn btn-outline-danger btn-sm fw-bold">Exporter</button>
          </div>
            </div>
        </div>
        

      </div>
    </div>
  </div>
</div>




            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-md-flex align-items-center">
                    <div>
                      <h4 class="card-title">Liste des donnees</h4>
                      
                    </div>
                    <div class="ms-auto mt-3 mt-md-0">
                 
            
            
        
                      <select class="form-select theme-select border-0" aria-label="Default select example">
                        <option value="1">March 2025</option>
                        <option value="2">March 2025</option>
                        <option value="3">March 2025</option>
                      </select>
                        </div>
                   
                  </div>
                  <div class="table-responsive mt-4">
                    {{-- <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                      <thead>
                        <tr>
                          @php
                              $longueur = count($collections); // Le nombre de champs
                          @endphp
                          <th>#</th>
                          @foreach ($collections as $collection)
                            <th>{{ $collection->label }}</th>
                          @endforeach
                          <th>Enregistré par</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $total = count($donnees->enregistrements);
                            $index = 0;
                        @endphp

                        @foreach ($donnees->enregistrements as $i => $champ)
                            @if ($index % $longueur == 0)
                                <tr>
                                    <td>{{ floor($index / $longueur) + 1 }}</td>
                            @endif

                            <td>{{ $champ->value ?? '-' }}</td>

                            @php $index++; @endphp

                            @if ($index % $longueur == 0)
                                    <td>Inconnu</td>
                                </tr>
                            @endif
                        @endforeach

                        <!-- Si le nombre de champs n'est pas un multiple exact, on complète la ligne -->
                        @if ($index % $longueur != 0)
                            @for ($i = 0; $i < ($longueur - ($index % $longueur)); $i++)
                                <td>-</td>
                            @endfor
                            <td>Inconnu</td>
                            </tr>
                        @endif
                      </tbody>
                    </table> --}}



                   <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
    <thead>
        <tr>
            <th>#</th>
            @foreach ($collections as $collection)
                <th>{{ $collection->label }}</th>
            @endforeach
            <th>Enregistré par</th>
        </tr>
    </thead>
    <tbody>
        @php
            $groupes = $donnees->enregistrements->groupBy('groupe_id');
            $counter = 1;
        @endphp

        @foreach ($groupes as $groupe_id => $champsDuGroupe)
            <tr>
                <td>{{ $counter }}</td>
                
                @foreach ($collections as $collection)
                    @php
                        $champ = $champsDuGroupe->firstWhere('label', $collection->label);
                    @endphp
                    <td>{{ $champ->value ?? '-' }}</td>
                     
                @endforeach
                
               <td>{{$champ->creator->name ?? 'Inconnu'}}</td>
            </tr>
            @php $counter++; @endphp
        @endforeach
    </tbody>
</table>


                  </div>
                </div>
              </div>
            </div>
           
          </div>
        
       
   
@endsection