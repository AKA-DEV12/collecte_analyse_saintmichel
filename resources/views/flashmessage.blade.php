@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Succès de l‘action :</strong> {{ session('success') }}
        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
        </button> --}}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erreur :</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Attention :</strong> 
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
        </button> --}}
    </div>
@endif

<!-- Script pour faire disparaître automatiquement les alertes après 8 secondes -->
<script>
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            // Bootstrap 5
            if (typeof bootstrap !== 'undefined') {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            } else {
                // fallback simple si bootstrap JS non chargé
                alert.style.opacity = 0.3;
                alert.style.display = 'none';
            }
        });
    }, 6000); // 6000 ms = 6 secondes
</script>
