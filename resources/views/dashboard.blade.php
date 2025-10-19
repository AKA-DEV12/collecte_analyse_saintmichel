@extends('template.body')
@section('content')

          <!--  Row 1 -->
          <div class="row">
            <!-- Statistiques Recensement -->
            <div class="col-lg-12">
              <div class="row">
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-2">Taux d'enfants</h5>
                      <h2 class="fw-bolder text-primary mb-0">{{ $taux['enfants'] ?? 0 }}%</h2>
                     
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-2">Taux de jeunes</h5>
                      <h2 class="fw-bolder text-success mb-0">{{ $taux['jeunes'] ?? 0 }}%</h2>
                    
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-2">Taux d'adultes</h5>
                      <h2 class="fw-bolder text-warning mb-0">{{ $taux['adultes'] ?? 0 }}%</h2>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Graphique Emploi -->
            <div class="col-lg-12">
              <div class="card w-100">
                <div class="card-body">
                  <div class="d-md-flex align-items-center mb-3">
                    <div>
                      <h4 class="card-title">Répartition par situation professionnelle</h4>
                      <p class="card-subtitle">Effectifs par catégorie</p>
                    </div>
                  </div>
                  <canvas id="emploiChart" height="120"></canvas>
                </div>
              </div>
            </div>

            <!-- Graphique Statuts (quête d'emploi, mariés, travailleurs, veufs, divorcés, célibataires) -->
            <div class="col-lg-12">
              <div class="card w-100">
                <div class="card-body">
                  <div class="d-md-flex align-items-center mb-3">
                    <div>
                      <h4 class="card-title">Répartition par statut</h4>
                      <p class="card-subtitle">Catégories sociales</p>
                    </div>
                  </div>
                  <canvas id="statusChart" height="120"></canvas>
                </div>
              </div>
            </div>
            
        
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-md-flex align-items-center justify-content-between">
                    <div>
                      <h4 class="card-title">Liste des agents</h4>
                      <p class="card-subtitle">Tous les agents enregistrés</p>
                    </div>
                  </div>
                  <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                      <thead>
                        <tr>
                          <th class="px-0 text-muted">#</th>
                          <th class="px-0 text-muted">Nom & Prénom</th>
                          <th class="px-0 text-muted">Téléphone</th>
                          <th class="px-0 text-muted">Fonction</th>
                          <th class="px-0 text-muted">CEB</th>
                          <th class="px-0 text-muted text-end">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($agents as $i => $agent)
                          <tr>
                            <td class="px-0">{{ $i + 1 }}</td>
                            <td class="px-0 fw-semibold">{{ $agent->name }}</td>
                            <td class="px-0">{{ $agent->tel }}</td>
                            <td class="px-0">{{ $agent->fonction }}</td>
                            <td class="px-0">{{ $agent->ceb }}</td>
                            <td class="px-0 text-end">
                              <a href="{{ route('agent.index', ['agent_id' => $agent->id]) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td class="px-0" colspan="6">Aucun agent disponible.</td>
                          </tr>
                        @endforelse
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
  document.addEventListener('DOMContentLoaded', function(){
    const ctx = document.getElementById('emploiChart');
    if (!ctx || typeof Chart === 'undefined') return;
    const labels = @json($labels ?? []);
    const data = @json($emploiCounts ?? []);
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Effectifs',
          data: data,
          borderColor: '#1a97f5',
          backgroundColor: 'rgba(26, 151, 245, 0.15)',
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6,
          pointBackgroundColor: '#1a97f5',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          borderWidth: 3,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true, labels: { boxWidth: 12 } },
          tooltip: { mode: 'index', intersect: false }
        },
        interaction: { mode: 'nearest', intersect: false },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { precision: 0 },
            grid: { color: 'rgba(0,0,0,0.05)' }
          },
          x: {
            grid: { display: false }
          }
        },
        elements: {
          line: { borderCapStyle: 'round', borderJoinStyle: 'round' },
          point: { hoverBorderWidth: 2 }
        }
      }
    });

    // Status chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
      const statusLabels = @json($statusLabels ?? []);
      const statusCounts = @json($statusCounts ?? []);
      new Chart(statusCtx, {
        type: 'polarArea',
        data: {
          labels: statusLabels,
          datasets: [{
            label: 'Effectifs',
            data: statusCounts,
            backgroundColor: [
              'rgba(26, 151, 245, 0.65)',   // bleu
              'rgba(16, 185, 129, 0.65)',   // vert
              'rgba(99, 102, 241, 0.65)',   // indigo
              'rgba(234, 179, 8, 0.65)',    // jaune
              'rgba(239, 68, 68, 0.65)',    // rouge
              'rgba(107, 114, 128, 0.65)'   // gris
            ],
            borderColor: '#ffffff',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'bottom' },
            tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.parsed}` } }
          },
          scales: {
            r: {
              beginAtZero: true,
              grid: { color: 'rgba(0,0,0,0.06)' },
              angleLines: { color: 'rgba(0,0,0,0.06)' },
              ticks: { precision: 0 }
            }
          }
        }
      });
    }
  });
</script>
@endpush