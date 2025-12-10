<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion des visites')</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
        }

        
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
            padding: 20px 15px;
            border-right: 2px solid #DAA520;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
        }
        .sidebar .menu-title {
            font-size: 12px;
            font-weight: 700;
            color: #DAA520;
            margin-bottom: 10px;
            margin-top: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sidebar a {
            display: block;
            padding: 12px 14px;
            color: #e5e5e5;
            font-size: 15px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 6px;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            background: rgba(218, 165, 32, 0.1);
            color: #DAA520;
            transform: translateX(4px);
        }
        .sidebar a.active {
            background: #DAA520;
            color: #000;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(218, 165, 32, 0.3);
        }

      
        .content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }

        
        .card-dark {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            color: #333;
            box-shadow: 0 2px 8px rgba(218, 25, 25, 0.08);
            transition: all 0.3s ease;
        }
        .card-dark:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            border-color: #DAA520;
        }

       
        h2, h3, h4 {
            color: #1a1a2e;
            font-weight: 700;
        }
        .text-muted {
            color: #7a7a7a !important;
        }
        .text-accent {
            color: #DAA520;
            font-weight: bold;
        }

        
        .btn-accent {
            background: #DAA520;
            color: #000;
            font-weight: bold;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-accent:hover {
            background: #f5c24d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3);
        }

        .btn-outline-light {
            color: #666;
            border-color: #ddd;
        }
        .btn-outline-light:hover {
            background: #f5f5f5;
            border-color: #DAA520;
            color: #DAA520;
        }

        
        .navbar-custom {
            background: white;
            border-bottom: 2px solid #f0f0f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }
        .navbar-custom .navbar-brand {
            color: #DAA520;
            font-weight: bold;
            font-size: 18px;
            letter-spacing: 1px;
        }
        .navbar-custom .nav-link {
            color: #333;
        }
        .navbar-custom .nav-link:hover {
            color: #DAA520;
        }

        
        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 8px;
            color: #333;
        }
        .form-control:focus, .form-select:focus {
            border-color: #DAA520;
            box-shadow: 0 0 0 0.2rem rgba(218, 165, 32, 0.25);
            color: #333;
        }

        
        .form-label {
            color: #1a1a2e;
            font-weight: 600;
            margin-bottom: 8px;
        }
        small {
            color: #888;
        }

        .alert-danger {
            background-color: #fff3cd;
            color: #856404;
        }

    </style>
</head>

<body>

    
    @auth
        <nav class="navbar navbar-custom px-3">
            <span class="navbar-brand">GESTION VISITEURS</span>

            <div class="d-flex align-items-center gap-3">

                <span class="text-muted small">
                    {{ auth()->user()->nom }} {{ auth()->user()->prenom }}
                    <span class="badge bg-warning text-dark">{{ auth()->user()->role }}</span>
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Déconnexion</button>
                </form>
            </div>
        </nav>
    @endauth

    
    @auth
        <div class="sidebar">

            <div class="menu-title">MENU</div>

            <a href="{{ route('dashboard') }}" 
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
               📊 Tableau de bord
            </a>

            <a href="{{ route('clients.index') }}" 
               class="{{ request()->is('clients*') ? 'active' : '' }}">
               👥 Clients
            </a>

            <a href="{{ route('visites.index') }}" 
               class="{{ request()->is('visites*') ? 'active' : '' }}">
               📝 Visites
            </a>

            
            <a href="{{ route('rapports.index') }}" 
               class="{{ request()->routeIs('rapports.index') ? 'active' : '' }}">
               📈 Rapports
            </a>

            
            <a href="{{ route('help.index') }}" 
               class="{{ request()->routeIs('help.index') ? 'active' : '' }}">
               ❓ Aide
            </a>

            @if(auth()->user()->role === 'admin')
                <hr class="border-warning my-3" style="opacity: 0.3;">
                <div class="menu-title">ADMINISTRATION</div>

                <a href="{{ route('admin.historique.secretaires') }}"
                   class="{{ request()->routeIs('admin.historique.secretaires') ? 'active' : '' }}">
                   🕒 Historique des secrétaires
                </a>
            @endif

        </div>
    @endauth

    <!-- Contenu principal -->
    <div class="@auth content @else container mt-5 @endauth">
        @yield('content')
    </div>

</body>
</html>
