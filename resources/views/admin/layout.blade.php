<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Administration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
        }

        /* ---------- Menu latéral ---------- */
        .sidebar-offcanvas {
            --bs-offcanvas-bg: #1e2530;
            --bs-offcanvas-color: #fff;
            --bs-offcanvas-width: 270px;
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            padding: 1.25rem 1.5rem;
        }

        .sidebar-label {
            font-size: .7rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .4);
            padding: 1rem 1.5rem .4rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .7);
            padding: .65rem 1rem;
            margin: .1rem .75rem;
            border-radius: .5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            transition: background .15s, color .15s;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .08);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: #0d6efd;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
        }

        /* ---------- Ordinateur : menu fixe à gauche ---------- */
        @media (min-width: 992px) {
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                width: 260px;
                background: #1e2530;
                display: flex;
                flex-direction: column;
                overflow-y: auto;
            }

            .sidebar-offcanvas {
                height: 100%;
            }

            .content {
                margin-left: 260px;
            }
        }
    </style>
</head>

<body>

{{-- Barre du haut : visible uniquement sur mobile / tablette --}}
<header class="navbar navbar-dark bg-dark sticky-top d-lg-none shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-shop me-2"></i>Administration
        </a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
                aria-controls="sidebarMenu" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</header>

{{-- Menu latéral --}}
<aside class="sidebar">
    <div class="offcanvas-lg offcanvas-start sidebar-offcanvas" tabindex="-1"
         id="sidebarMenu" aria-labelledby="sidebarLabel">

        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title" id="sidebarLabel">
                <i class="bi bi-shop me-2"></i>Administration
            </h5>
            <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                    aria-label="Fermer"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column flex-grow-1 p-0">

            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand d-none d-lg-block">
                <i class="bi bi-shop me-2"></i>Administration
            </a>

            <nav class="nav flex-column pb-3">
                <div class="sidebar-label">Général</div>

                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>

                <div class="sidebar-label">Catalogue</div>

                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                   href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam"></i> Produits
                </a>

                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                   href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags"></i> Catégories
                </a>

                <a class="nav-link {{ request()->routeIs('admin.stock-movements') ? 'active' : '' }}"
                   href="{{ route('admin.stock-movements') }}">
                    <i class="bi bi-arrow-left-right"></i> Mouvements des stocks
                </a>

                <div class="sidebar-label">Administration</div>

                <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Utilisateurs
                </a>
            </nav>

            {{-- Utilisateur connecté + déconnexion --}}
            <div class="mt-auto p-3 border-top border-secondary">
                <div class="d-flex align-items-center gap-2 mb-3 px-1">
                    <i class="bi bi-person-circle fs-3 text-white-50"></i>
                    <div class="text-truncate">
                        <div class="fw-semibold text-white text-truncate">
                            {{ auth()->user()->name ?? 'Administrateur' }}
                        </div>
                        <small class="text-white-50 text-truncate d-block">
                            {{ auth()->user()->email ?? '' }}
                        </small>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Se déconnecter
                    </button>
                </form>
            </div>

        </div>
    </div>
</aside>

{{-- Contenu --}}
<div class="content">
    <main class="p-3 p-lg-4">
        @yield('container')
    </main>

    <footer class="text-center text-muted small py-3">
        &copy; {{ date('Y') }} Administration
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>