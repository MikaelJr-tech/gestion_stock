<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full z-50">

            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-gray-700">
                <h1 class="text-xl font-bold text-white">📦 Gestion Stock</h1>
                <p class="text-xs text-gray-400 mt-1">{{ auth()->user()->tenant->nom_entreprise ?? 'Entreprise' }}</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="mr-3">🏠</span> Dashboard
                </a>

                {{-- APPROVISIONNEMENTS --}}
                <div class="pt-3">
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Approvisionnements</p>

                    <a href="{{ route('appro.commandes.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('appro.commandes.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">📋</span> Bons de commande
                    </a>
                    <a href="{{ route('appro.factures.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('appro.factures.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🧾</span> Factures fournisseur
                    </a>
                    <a href="{{ route('appro.bons-entree.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('appro.bons-entree.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">📥</span> Bons d'entrée / Dons
                    </a>
                </div>

                {{-- VENTES --}}
                <div class="pt-3">
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Ventes</p>

                    <a href="{{ route('ventes.commandes.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('ventes.commandes.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🛒</span> Commandes client
                    </a>
                    <a href="{{ route('ventes.factures.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('ventes.factures.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🧾</span> Factures client
                    </a>
                    <a href="{{ route('ventes.bons-sortie.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('ventes.bons-sortie.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">📤</span> Bons de sortie
                    </a>
                </div>

                {{-- STRUCTURE --}}
                <div class="pt-3">
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Structure</p>

                    <a href="{{ route('produits.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('produits.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">📦</span> Produits
                    </a>
                    <a href="{{ route('familles.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('familles.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🗂️</span> Familles
                    </a>
                    <a href="{{ route('fournisseurs.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('fournisseurs.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🏭</span> Fournisseurs
                    </a>
                    <a href="{{ route('clients.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('clients.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">👥</span> Clients
                    </a>
                    <a href="{{ route('categories.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🏷️</span> Catégories clients
                    </a>
                    <a href="{{ route('banques.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('banques.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🏦</span> Banques
                    </a>
                    <a href="{{ route('versements.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('versements.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">💰</span> Versements
                    </a>
                </div>

                {{-- RAPPORTS --}}
                <div class="pt-3">
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Rapports</p>

                    <a href="{{ route('rapports.achats-jour') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('rapports.achats*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">📊</span> Achats
                    </a>
                    <a href="{{ route('rapports.ventes-jour') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('rapports.ventes*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">📈</span> Ventes
                    </a>
                    <a href="{{ route('rapports.versements-banque') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('rapports.versements*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🏦</span> Versements banque
                    </a>
                </div>

                {{-- ADMINISTRATION --}}
                <div class="pt-3">
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Administration</p>

                    <a href="{{ route('utilisateurs.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('utilisateurs.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">👤</span> Utilisateurs
                    </a>
                    <a href="{{ route('groupes.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('groupes.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                        <span class="mr-3">🔐</span> Groupes & Droits
                    </a>
                </div>

            </nav>

            {{-- User + Logout --}}
            <div class="px-4 py-4 border-t border-gray-700">
                <p class="text-sm text-gray-300 font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-xs text-red-400 hover:text-red-300">
                        🚪 Déconnexion
                    </button>
                </form>
            </div>

        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 ml-64 flex flex-col overflow-hidden">

            {{-- Top Bar --}}
            <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</h2>
                <span class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</span>
            </header>

            {{-- Alerts --}}
            <div class="px-6 pt-4">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-4 flex justify-between">
                        <span>✅ {{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()">✕</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg mb-4 flex justify-between">
                        <span>❌ {{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()">✕</button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto px-6 py-4">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>
