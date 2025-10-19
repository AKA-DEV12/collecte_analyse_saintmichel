@extends('template.body')
@push('css')
    <!-- Style supplémentaire pour effets -->
<style>
      :root {
  --primary-color: #C21224FF;
  --secondary-color: #6c757d;
  --success-color: #198754;
  --danger-color: #dc3545;
  --light-bg: #f8f9fa;
  --border-color: #dee2e6;
}

  .fade-in-up {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.8s ease forwards;
  }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .project-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .project-card:hover {
    transform: scale(1.05);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
  }

  /* Mode sombre facultatif */
  body.dark-mode .project-card {
    background-color: #1f2937 !important;
    color: #f8f9fa !important;
  }
</style>
@endpush
@section('content')
   
<section id="projects" class="mb-5 fade-in-up" style="animation-delay: 0.2s;">
  <div class="container">
    <h2 class="fw-bold mb-5" style="color: var(--bs-primary); ">Projets</h2>
    <div class="row gy-4">
        @include('flashmessage')
     <div class="col-12 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 project-card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h3 class="card-title fw-semibold mb-2">Recensement des Paroissiens
</h3>
                    

                            
                    </div>
           
                  <p class="card-text mb-4">Remplissez ce formulaire pour le recensement des paroissiens de la Paroisse Saint Michel d'Adjamé</p>
                  <a href="{{route('agent.recensement.index')}}" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">Voir→</a>
                </div>
              </div>
            </div>
    
        @forelse ($collections as $collection)
            <div class="col-12 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100 project-card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h3 class="card-title fw-semibold mb-2">{{$collection->titre}}</h3>
                    

                        <form action="{{route('collecte.delete', $collection->id)}}" method="post">
                          @csrf
                        @method('DELETE')  

                          <button type="submit" class="btn btn-remove-field btn-sm" >
                                        <i class="bi bi-trash me-1"></i>
                                        Supprimer
                                    </button>
                        </form>           
                    </div>
           
                  <p class="card-text mb-4">{{$collection->description ?? 'Aucune descriotion'}}</p>
                  <a href="{{route('collecte.show',$collection->id)}}" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">Voir→</a>
                </div>
              </div>
            </div>
        @empty
            
        @endforelse
      <!-- Project Card -->
      


    
      
    </div>
  </div>
</section>




@endsection