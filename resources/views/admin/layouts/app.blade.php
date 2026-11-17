<!DOCTYPE html>
<html lang="fr" class="h-full" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
    }
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaliTrans Admin - @yield('title', 'Tableau de bord')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js pour les interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans antialiased bg-zinc-100 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 flex transition-colors duration-200" x-data="{ sidebarOpen: false }">

<!-- Sidebar Mobile & Desktop -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col shadow-sm lg:shadow-none"
       :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-zinc-200 dark:border-zinc-800">
        <span class="text-xl font-bold tracking-wider text-zinc-900 dark:text-white">MALI<span class="text-zinc-400 font-normal">TRANS</span></span>
        <span class="ml-2 px-2 py-0.5 text-[10px] bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded border border-zinc-200 dark:border-zinc-700 font-mono">ADMIN</span>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <div class="pt-4 pb-2">
            <p class="px-4 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Gestion des Employés</p>
        </div>

        <!-- Chauffeurs -->
        <a href="{{ route('admin.chauffeurs.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.chauffeurs.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
            Chauffeurs
        </a>

        <!-- Caissiers -->
        <a href="{{ route('admin.caissiers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.caissiers.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Caissiers
        </a>

        <!-- Mécaniciens -->
        <a href="{{ route('admin.mecaniciens.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.mecaniciens.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Mécaniciens
        </a>

        <!-- Responsables de Flotte -->
        <a href="{{ route('admin.responsables-flotte.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.responsables-flotte.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Responsables Flotte
        </a>

        <!-- Agents d'Exploitation -->
        <a href="{{ route('admin.agents-exploitation.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.agents-exploitation.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Agents d'Exploitation
        </a>

        <!-- Section Exploitation -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500"> GESTION Exploitation</p>
        </div>

        <!-- Lignes de Transport -->
        <a href="{{ route('admin.lignes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.lignes.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            Lignes de Transport
        </a>

        <!-- Véhicules (Bus) -->
        <a href="{{ route('admin.vehicules.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.vehicules.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Véhicules (Bus)
        </a>

        <!-- Affectations -->
        <a href="{{ route('admin.affectations.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.affectations.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Affectations
        </a>

        <!-- Section Billetterie -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Commercial</p>
        </div>

        <!-- Billets & Ventes -->
        <a href="{{ route('admin.billetterie.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.billetterie.*') ? 'bg-zinc-900 text-zinc-50 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm border border-transparent dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            Billetterie
        </a>

    </nav>

    <!-- User profile footer / Déconnexion -->
    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="flex-1 flex flex-col min-w-0 overflow-hidden">
    <!-- Topbar -->
    <header class="h-16 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between px-6 z-40 shadow-sm lg:shadow-none">
        <button @click="sidebarOpen = !sidebarOpen" class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        <div class="flex items-center gap-4 ml-auto">
            <!-- Bouton Toggle Dark/Light Mode -->
            <button @click="toggleTheme()" class="p-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition" title="Changer le mode d'affichage">
                <!-- Icône Soleil (Visible en mode sombre) -->
                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <!-- Icône Lune (Visible en mode clair) -->
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>

            <div class="flex items-center gap-3 border-l border-zinc-200 dark:border-zinc-800 pl-4">
                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Administrateur</span>
                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center font-semibold text-zinc-800 dark:text-zinc-200 text-xs font-mono">AT</div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 overflow-y-auto bg-zinc-50 dark:bg-zinc-950 p-8 transition-colors duration-200">
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl text-sm shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
