
@extends('admin.layouts.app')

@section('title', 'Gestion des Mécaniciens')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" x-data="{ openModal: false }">
        <div>
            <h1 class="text-2xl font-bold text-white">Mécaniciens</h1>
            <p class="text-slate-400 text-sm mt-1">Suivez les spécialités et l'atelier de maintenance des mécaniciens.</p>
        </div>
        <button @click="openModal = true" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-xl transition duration-150 shadow-lg shadow-indigo-600/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nouveau Mécanicien
        </button>

        <!-- MODAL DE CRÉATION -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 overflow-y-auto" style="display: none;">
            <div @click.away="openModal = false" class="bg-slate-900 border border-slate-800 rounded-2xl max-w-2xl w-full p-6 shadow-2xl my-8">
                <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
                    <h3 class="text-lg font-bold text-white">Ajouter un nouveau mécanicien</h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-white">&times;</button>
                </div>

                <form action="{{ route('admin.mecaniciens.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Nom</label>
                            <input type="text" name="nom" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Prénom</label>
                            <input type="text" name="prenom" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Email</label>
                            <input type="email" name="email" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Téléphone</label>
                            <input type="text" name="telephone" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Mot de passe provisoire</label>
                            <input type="password" name="motDePasse" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Matricule</label>
                            <input type="text" name="matricule" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-slate-400 mb-1">Spécialité (ex: Motorisation Diesel, Électricité...)</label>
                            <input type="text" name="specialite" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Salaire (FCFA)</label>
                            <input type="number" step="0.01" name="salaire" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-white text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-800 mt-6">
                        <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-sm font-medium">Annuler</button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-sm font-medium">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tableau des Mécaniciens -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider bg-slate-950/50">
                    <th class="px-6 py-4">Matricule & Nom</th>
                    <th class="px-6 py-4">Contact</th>
                    <th class="px-6 py-4">Spécialité</th>
                    <th class="px-6 py-4">Statut</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-sm">
                @forelse($mecaniciens as $mecanicien)
                    <tr class="hover:bg-slate-800/40 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="font-medium text-white">{{ $mecanicien['prenom'] }} {{ $mecanicien['nom'] }}</div>
                            <div class="text-xs text-slate-400">{{ $mecanicien['matricule'] }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-300">
                            <div>{{ $mecanicien['email'] }}</div>
                            <div class="text-xs text-slate-400">{{ $mecanicien['telephone'] }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-300">
                            <span class="px-2 py-1 bg-slate-800 rounded text-xs font-semibold text-indigo-400">{{ $mecanicien['specialite'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                {{ $mecanicien['statut'] ?? 'ACTIF' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <form action="{{ route('admin.mecaniciens.destroy', $mecanicien['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce mécanicien ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-medium">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            Aucun mécanicien enregistré pour le moment.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
