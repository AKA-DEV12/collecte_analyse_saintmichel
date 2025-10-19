<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Paroisse Saint Michel Archange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="shortcut icon" type="image/png" href="{{asset('/assets/images/logos/favicon.png')}}" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
        }
        .card-gradient {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border-radius: 20px;
            padding: 2px;
        }
        .card-login {
            border-radius: 18px;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .btn-gradient {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(to right, #2a5298, #1e3c72);
            transform: scale(1.05);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card-gradient mb-4">
                    <div class="card-login">
                        <h2 class="text-center mb-4 text-primary fw-bold">Paroisse Saint Michel Archange</h2>
                        <h4 class="text-center mb-4 text-secondary">Connexion</h4>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email / Téléphone -->
                            <div class="mb-3">
                                <label for="login" class="form-label">Email ou Téléphone</label>
                                <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login" value="{{ old('login') }}" required autofocus>
                                @error('login')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label" for="remember_me">
                                    Se souvenir de moi
                                </label>
                            </div>

                            <!-- Mot de passe oublié -->
                            <div class="mb-3 text-end">
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">Mot de passe oublié ?</a>
                                @endif
                            </div>

                            <!-- Bouton connexion -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-gradient btn-lg">Se connecter</button>
                            </div>
                        </form>

                     {{--   <p class="text-center text-muted">
                            Pas encore de compte ?
                            <a href="#" class="text-primary text-decoration-none">Inscrivez-vous</a>
                        </p> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
