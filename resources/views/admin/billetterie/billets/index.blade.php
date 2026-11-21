@extends('admin.layouts.app')

@section('title', 'Gestion des Billets')

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
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Billets ponctuels</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Vente de billets au guichet (avec compte passager ou passager ponctuel).</p>
            </div>

            <button @click="openModal = true" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-900 text-zinc-50 dark:bg-zinc-100 dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-200 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                Émettre un billet
            </button>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">N° Billet</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Passager</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Trajet / Placement</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Paiement</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3.5 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($billets as $billet)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $billet['numeroBillet'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                                {{ $billet['passagerNomComplet'] ?? 'Passager ponctuel' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                <span class="font-semibold text-zinc-900 dark:text-zinc-200">Ligne {{ $billet['ligneNumero'] ?? '' }}</span> - {{ $billet['ligneNom'] ?? '' }}
                                <div class="text-xs text-zinc-400">
                                    Bus : {{ $billet['busImmatriculation'] ?? 'N/A' }} | {{ $billet['siegeNumero'] ?? 'Placement libre' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300">
                                <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($billet['montantPaye'] ?? 0, 0, ',', ' ') }} FCFA</span>
                                <div class="text-xs text-zinc-500">{{ $billet['modePaiement'] ?? '' }} (Réf: {{ $billet['referencePaiement'] ?? '' }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $badgeColors = [
                                        'VALIDE'  => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
                                        'UTILISE' => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-300 dark:border-zinc-700',
                                        'RESERVE' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
                                        'ANNULE'  => 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                    ];
                                    $currentBadge = $badgeColors[$billet['statut'] ?? ''] ?? 'bg-zinc-100 text-zinc-700 border-zinc-200';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $currentBadge }}">
                                    {{ $billet['statut'] ?? 'INCONNU' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if(($billet['statut'] ?? '') !== 'ANNULE' && ($billet['statut'] ?? '') !== 'UTILISE')
                                    <form action="{{ route('admin.billetterie.billets.annuler', $billet['id']) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer l’annulation de ce billet ?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 font-medium text-xs bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 px-3 py-1.5 rounded-lg transition">
                                            Annuler
                                        </button>
                                    </form>
                                @else
                                    <span class="text-zinc-400 dark:text-zinc-600 text-xs italic">Fermé</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-zinc-400 dark:text-zinc-500">
                                Aucun billet enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Émission Billet (Passager optionnel / à l'improviste) -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" style="display: none;">
            <div @click.away="openModal = false" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Émission d'un Billet</h3>
                    <button @click="openModal = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">✕</button>
                </div>

                <form action="{{ route('admin.billetterie.billets.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">
                            Passager (Optionnel — vide = Passager ponctuel)
                        </label>
                        <select name="passagerId" class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100">
                            <option value="">Passager ponctuel (sans compte)</option>
                            @foreach($passagers as $passager)
                                <option value="{{ $passager['id'] }}" @selected(old('passagerId') == $passager['id'])>
                                    {{ $passager['prenom'] }} {{ $passager['nom'] }} ({{ $passager['telephone'] ?? 'Sans tel' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Affectation / Trajet *</label>
                        <select name="affectationId" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100">
                            <option value="">Sélectionner un trajet planifié...</option>
                            @foreach($affectations as $aff)
                                <option value="{{ $aff['id'] }}" @selected(old('affectationId') == $aff['id'])>
                                    Ligne {{ $aff['ligne']['numero'] ?? 'N/A' }} - {{ $aff['date'] }} à {{ $aff['heureDebut'] }} (Bus: {{ $aff['vehicule']['immatriculation'] ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Mode de Paiement *</label>
                        <select name="modePaiement" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100">
                            <option value="Espèces" @selected(old('modePaiement') === 'Espèces')>Espèces (Guichet)</option>
                            <option value="Orange Money" @selected(old('modePaiement') === 'Orange Money')>Orange Money</option>
                            <option value="Moov Money" @selected(old('modePaiement') === 'Moov Money')>Moov Money</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Référence de Transaction (Auto-générée si vide)</label>
                        <input type="text" name="referencePaiement" value="{{ old('referencePaiement') }}" placeholder="Ex: ESP261120..." class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100">
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" @click="openModal = false" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">Annuler</button>
                        <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-900 text-zinc-50 dark:bg-zinc-100 dark:text-zinc-900">Valider & Émettre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
