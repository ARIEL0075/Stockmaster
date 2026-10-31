<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Administration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e2530 0%, #0d6efd 100%);
        }

        .login-card {
            max-width: 420px;
            width: 100%;
            border: 0;
            border-radius: 1rem;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #e7f0ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
        }

        .input-group-text {
            background: #f8f9fa;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center p-3">

    <div class="card login-card shadow-lg">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <div class="login-logo">
                    <i class="bi bi-shop"></i>
                </div>
                <h1 class="h4 fw-bold mb-1">Administration</h1>
                <p class="text-muted mb-0">Connectez-vous pour accéder à votre espace</p>
            </div>

            {{-- Message de succès (ex : après déconnexion) --}}
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            {{-- Erreurs de connexion --}}
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.dologin') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Adresse email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="nom@exemple.com"
                               autocomplete="email" autofocus required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Votre mot de passe"
                               autocomplete="current-password" required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword"
                                aria-label="Afficher ou masquer le mot de passe">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                </button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Afficher / masquer le mot de passe
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        document.getElementById('togglePassword').addEventListener('click', () => {
            const visible = password.type === 'text';
            password.type = visible ? 'password' : 'text';
            icon.className = visible ? 'bi bi-eye' : 'bi bi-eye-slash';
        });
    </script>
</body>
</html>