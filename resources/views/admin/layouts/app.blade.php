
<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaliTrans Admin - @yield('title', 'Tableau de bord')</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!-- Alpine.js pour les interactions (modales, menus déroulants) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans antialiased text-slate-100 flex" x-data="{ sidebarOpen: false }">

<!-- Sidebar Mobile & Desktop -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col"
       :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-slate-800">
        <span class="text-xl font-bold tracking-wider text-white">MALI<span class="text-indigo-500">TRANS</span></span>
        <span class="ml-2 px-2 py-0.5 text-xs bg-indigo-500/10 text-indigo-400 rounded border border-indigo-500/20">Admin</span>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Gestion des Employés</p>
        </div>

        <!-- Chauffeurs -->
        <a href="{{ route('admin.chauffeurs.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.chauffeurs.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
            Chauffeurs
        </a>

        <!-- Caissiers -->
        <a href="{{ route('admin.caissiers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.caissiers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Caissiers
        </a>

        <!-- Mécaniciens -->
        <a href="{{ route('admin.mecaniciens.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.mecaniciens.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Mécaniciens
        </a>

        <!-- Responsables de Flotte -->
        <a href="{{ route('admin.responsables-flotte.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.responsables-flotte.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Responsables Flotte
        </a>

        <!-- Agents d'Exploitation -->
        <a href="{{ route('admin.agents-exploitation.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.agents-exploitation.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Agents d'Exploitation
        </a>
    </nav>

    <!-- User profile footer / Déconnexion -->
    <div class="p-4 border-t border-slate-800">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="flex-1 flex flex-col min-w-0 overflow-hidden">
    <!-- Topbar -->
    <header class="h-16 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-6 z-40">
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <div class="flex items-center gap-4 ml-auto">
            <span class="text-sm font-medium text-slate-300">Administrateur MaliTrans</span>
            <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-white text-sm">AT</div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 overflow-y-auto bg-slate-950 p-8">
        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
