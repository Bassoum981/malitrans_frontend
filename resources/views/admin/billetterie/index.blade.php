@extends('admin.layouts.app') {{-- Remplace par le nom exact de ton fichier de layout si besoin --}}

@section('title', 'Gestion de la Billetterie')

@section('content')
    <div class="space-y-6" x-data="{ openModal: false }">
        <!-- Header de la page -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Billetterie & Ventes</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Émission des titres de transport, suivi des paiements et contrôle des passagers.</p>
            </div>

            <!-- Bouton d'ouverture du Modal d'émission au guichet -->
            <button @click="openModal = true" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-900 text-zinc-50 dark:bg-zinc-100 dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-200 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                Émettre un billet (Guichet)
            </button>
        </div>

        <!-- Tableau de suivi des billets -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">N° Billet / QR</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Passager</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Trajet / Affectation</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Paiement</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3.5 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($billets as $billet)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $billet['numeroBillet'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                                {{ $billet['passagerNomComplet'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                <span class="font-semibold text-zinc-900 dark:text-zinc-200">Ligne {{ $billet['ligneNumero'] }}</span> - {{ $billet['ligneNom'] }}
                                <div class="text-xs text-zinc-400">Bus : {{ $billet['busImmatriculation'] }} | Prévu le {{ $billet['dateTrajet'] }} à {{ $billet['heureDebut'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300">
                                <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($billet['montantPaye'], 0, ',', ' ') }} FCFA</span>
                                <div class="text-xs text-zinc-500">{{ $billet['modePaiement'] }} (Réf: {{ $billet['referencePaiement'] }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $badgeColors = [
                                        'VALIDE'  => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
                                        'UTILISE' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
                                        'RESERVE' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
                                        'ANNULE'  => 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                    ];
                                    $currentBadge = $badgeColors[$billet['statut']] ?? 'bg-zinc-100 text-zinc-700 border-zinc-200';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $currentBadge }}">
                                    {{ $billet['statut'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if($billet['statut'] !== 'ANNULE' && $billet['statut'] !== 'UTILISE')
                                    <form action="{{ route('admin.billetterie.annuler', $billet['id']) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce billet ?');">
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

        <!-- Modal d'Émission de Billet (Alpine.js) -->
        <div x-show="openModal"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">

            <div @click.away="openModal = false" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Émission d'un Billet (Guichet)</h3>
                    <button @click="openModal = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('admin.billetterie.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <!-- Sélection Passager -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Passager</label>
                        <select name="passagerId" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-100">
                            <option value="">Sélectionner un passager...</option>
                            @foreach($passagers as $passager)
                                <option value="{{ $passager['id'] }}">{{ $passager['prenom'] }} {{ $passager['nom'] }} ({{ $passager['telephone'] ?? 'Sans tel' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sélection Affectation -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Affectation / Trajet</label>
                        <select name="affectationId" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-100">
                            <option value="">Sélectionner un trajet planifié...</option>
                            @foreach($affectations as $aff)
                                <option value="{{ $aff['id'] }}">
                                    Ligne {{ $aff['ligne']['numero'] ?? 'N/A' }} - {{ $aff['date'] }} à {{ $aff['heureDebut'] }} (Bus: {{ $aff['vehicule']['immatriculation'] ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mode de Paiement -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Mode de Paiement</label>
                        <select name="modePaiement" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-100">
                            <option value="Espèces">Espèces (Guichet)</option>
                            <option value="Orange Money">Orange Money</option>
                            <option value="Moov Money">Moov Money</option>
                        </select>
                    </div>

                    <!-- Référence de Paiement -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1.5">Référence de Transaction (Optionnel)</label>
                        <input type="text" name="referencePaiement" placeholder="Ex: OM261117..." class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-100">
                    </div>

                    <!-- Boutons d'actions du modal -->
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" @click="openModal = false" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-zinc-900 text-zinc-50 dark:bg-zinc-100 dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-200 transition shadow-sm">
                            Valider & Émettre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
