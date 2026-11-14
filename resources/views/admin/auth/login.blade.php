<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaliTrans - Connexion Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center font-sans antialiased text-slate-100">
<div class="max-w-md w-full mx-4 bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-2xl">

    <!-- En-tête -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold tracking-wider text-white">MALI<span class="text-indigo-500">TRANS</span></h1>
        <p class="text-slate-400 text-sm mt-1">Espace d'Administration Sécurisé</p>
    </div>

    <!-- Messages d'erreur -->
    @if($errors->any())
        <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Formulaire de connexion -->
    <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-medium text-slate-400 mb-1.5 uppercase tracking-wider">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:border-indigo-500 focus:outline-none transition duration-150"
                   placeholder="admin@malitrans.tech">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-400 mb-1.5 uppercase tracking-wider">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:border-indigo-500 focus:outline-none transition duration-150"
                   placeholder="••••••••••••">
        </div>

        <button type="submit"
                class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-xl transition duration-150 shadow-lg shadow-indigo-600/20 text-sm mt-2">
            Se connecter
        </button>
    </form>

    <div class="mt-8 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} MaliTrans. Tous droits réservés.
    </div>
</div>
</body>
</html>
