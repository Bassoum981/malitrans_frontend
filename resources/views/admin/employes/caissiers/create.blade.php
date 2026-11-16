@extends('admin.layouts.app')

@section('title', 'Créer un Caissier')

@section('content')
    <div class="max-w-2xl mx-auto" x-data="{ step: 1 }">
        <!-- En-tête -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">Nouveau Caissier</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Renseignez les informations du caissier en deux étapes.</p>
            </div>
            <a href="{{ route('admin.caissiers.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour
            </a>
        </div>

        <!-- Stepper -->
        <div class="mb-8 flex items-center gap-4 border-b border-zinc-200 dark:border-zinc-800 pb-4">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-mono font-semibold transition" :class="step === 1 ? 'bg-zinc-900 dark:bg-zinc-100 text-zinc-50 dark:text-zinc-950' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">1</span>
                <span class="text-sm font-medium transition" :class="step === 1 ? 'text-zinc-900 dark:text-zinc-100' : 'text-zinc-500 dark:text-zinc-400'">Identité & Accès</span>
            </div>
            <div class="w-8 h-px bg-zinc-200 dark:bg-zinc-800"></div>
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-mono font-semibold transition" :class="step === 2 ? 'bg-zinc-900 dark:bg-zinc-100 text-zinc-50 dark:text-zinc-950' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">2</span>
                <span class="text-sm font-medium transition" :class="step === 2 ? 'text-zinc-900 dark:text-zinc-100' : 'text-zinc-500 dark:text-zinc-400'">Caisse, Zone & Salaire</span>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
            <form action="{{ route('admin.caissiers.store') }}" method="POST">
                @csrf

                <!-- ÉTAPE 1 -->
                <div x-show="step === 1" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Nom</label>
                            <input type="text" name="nom" required value="{{ old('nom') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Prénom</label>
                            <input type="text" name="prenom" required value="{{ old('prenom') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Email</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Téléphone</label>
                            <input type="text" name="telephone" required value="{{ old('telephone') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Mot de passe provisoire</label>
                            <input type="password" name="motDePasse" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Matricule</label>
                            <input type="text" name="matricule" required value="{{ old('matricule') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800 mt-6">
                        <button type="button" @click="step = 2" class="inline-flex items-center gap-2 px-5 py-2.5 bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-800 dark:hover:bg-white text-zinc-50 dark:text-zinc-950 rounded-xl text-sm font-medium transition shadow-sm">
                            Continuer
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- ÉTAPE 2 -->
                <div x-show="step === 2" class="space-y-4" style="display: none;">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Identifiant de Caisse</label>
                            <input type="text" name="caisseId" required value="{{ old('caisseId') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Zone / Gare</label>
                            <input type="text" name="zone" required value="{{ old('zone') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Salaire (FCFA)</label>
                            <input type="number" step="0.01" name="salaire" required value="{{ old('salaire') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-800 mt-6">
                        <button type="button" @click="step = 1" class="inline-flex items-center gap-2 px-4 py-2.5 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-xl text-sm font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Précédent
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-800 dark:hover:bg-white text-zinc-50 dark:text-zinc-950 rounded-xl text-sm font-medium transition shadow-sm">
                            Créer le caissier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
