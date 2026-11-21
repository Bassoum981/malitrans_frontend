@extends('admin.layouts.app')

@section('title', 'Titres de Transport')

@section('content')
    <div class="space-y-6" x-data="{ openModal: false }">
        @if (session('error'))
            <div class="p-4 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-500/20 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/20 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Titres de transport</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Souscription et suivi des titres de transport rattachés aux comptes passagers.</p>
            </div>

            <button @click="openModal = true" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-900 text-zinc-50 dark:bg-zinc-100 dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-200 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                Créer un titre de transport
            </button>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Code Titre</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Passager</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Période de validité</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Paiement</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Statut</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($titresTransport as $titre)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $titre['codeTitre'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                                {{ $titre['passagerNomComplet'] ?? ('Passager #' . ($titre['passagerId'] ?? '-')) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $titre['dateDebut'] ?? '-' }} → {{ $titre['dateFin'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300">
                                <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($titre['montantPaye'] ?? 0, 0, ',', ' ') }} FCFA</span>
                                <div class="text-xs text-zinc-500">{{ $titre['modePaiement'] ?? '' }} (Réf: {{ $titre['referencePaiement'] ?? '' }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20">
                                    {{ $titre['statut'] ?? 'ACTIF' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-400 dark:text-zinc-500">
                                Aucun titre de transport enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Création Titre de Transport -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" style="display: none;">
            <div @click.away="openModal = false" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Créer un Titre de Transport</h3>
                    <button @click="openModal = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">✕</button>
                </div>

                <form action="{{ route('admin.billetterie.titres.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Compte Passager *</label>
                        <select name="passagerId" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100">
                            <option value="">Sélectionner un compte passager...</option>
                            @foreach($passagers as $passager)
                                <option value="{{ $passager['id'] }}" @selected(old('passagerId') == $passager['id'])>
                                    {{ $passager['prenom'] }} {{ $passager['nom'] }} ({{ $passager['telephone'] ?? 'Sans tel' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Mode de Paiement *</label>
                        <select name="modePaiement" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100">
                            <option value="Orange Money" @selected(old('modePaiement') === 'Orange Money')>Orange Money</option>
                            <option value="Moov Money" @selected(old('modePaiement') === 'Moov Money')>Moov Money</option>
                            <option value="Espèces" @selected(old('modePaiement') === 'Espèces')>Espèces (Guichet)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Référence de Transaction (Auto-générée si vide)</label>
                        <input type="text" name="referencePaiement" value="{{ old('referencePaiement') }}" placeholder="Ex: OM261120..." class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100">
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" @click="openModal = false" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">Annuler</button>
                        <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-900 text-zinc-50 dark:bg-zinc-100 dark:text-zinc-900">Créer le titre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
