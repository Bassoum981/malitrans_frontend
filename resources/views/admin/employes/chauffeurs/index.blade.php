@extends('admin.layouts.app')

@section('title', 'Gestion des Chauffeurs')

@section('content')
    <div x-data="{
    deleteModalOpen: false,
    deleteUrl: '',
    editModalOpen: false,
    editUrl: '',
    editData: { nom: '', prenom: '', email: '', telephone: '', matricule: '', numeroPermis: '', categoriePermis: '', dateExpirationPermis: '', salaire: '' },
    openEdit(chauffeur, url) {
        this.editData = { ...chauffeur };
        this.editUrl = url;
        this.editModalOpen = true;
    }
}">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">Chauffeurs</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Gérez les comptes conducteurs, leurs permis et informations de service.</p>
            </div>
            <a href="{{ route('admin.chauffeurs.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-zinc-900 hover:bg-zinc-800 text-zinc-50 dark:bg-zinc-100 dark:hover:bg-white dark:text-zinc-950 font-medium rounded-xl transition duration-150 text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Nouveau Chauffeur
            </a>
        </div>

        <!-- Tableau -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 dark:text-zinc-400 text-xs uppercase tracking-wider bg-zinc-50 dark:bg-zinc-950/60">
                        <th class="px-6 py-4 font-medium">Matricule & Nom</th>
                        <th class="px-6 py-4 font-medium">Contact</th>
                        <th class="px-6 py-4 font-medium">Permis</th>
                        <th class="px-6 py-4 font-medium">Statut</th>
                        <th class="px-6 py-4 text-right font-medium">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800/80 text-sm">
                    @forelse($chauffeurs as $chauffeur)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900 dark:text-zinc-200">{{ $chauffeur['prenom'] }} {{ $chauffeur['nom'] }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono mt-0.5">{{ $chauffeur['matricule'] }}</div>
                            </td>
                            <td class="px-6 py-4 text-zinc-700 dark:text-zinc-300">
                                <div>{{ $chauffeur['email'] }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $chauffeur['telephone'] }}</div>
                            </td>
                            <td class="px-6 py-4 text-zinc-700 dark:text-zinc-300">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 bg-zinc-900 text-zinc-100 dark:bg-zinc-100 dark:text-zinc-900 rounded text-[11px] font-semibold">Cat: {{ $chauffeur['categoriePermis'] }}</span>
                                    <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700/50 rounded text-xs font-mono text-zinc-800 dark:text-zinc-300">N°: {{ $chauffeur['numeroPermis'] }}</span>
                                </div>
                                @if(!empty($chauffeur['dateExpirationPermis']))
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Exp : {{ $chauffeur['dateExpirationPermis'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                                    {{ $chauffeur['statut'] ?? 'ACTIF' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <button type="button"
                                        @click='openEdit(@json($chauffeur), "{{ route('admin.chauffeurs.update', $chauffeur['id']) }}")'
                                        class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 text-xs font-medium transition">
                                    Modifier
                                </button>
                                <button type="button"
                                        @click="deleteModalOpen = true; deleteUrl = '{{ route('admin.chauffeurs.destroy', $chauffeur['id']) }}'"
                                        class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-medium transition">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-zinc-500 text-sm">
                                Aucun chauffeur enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODALE DE MODIFICATION -->
        <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 backdrop-blur-sm p-4 overflow-y-auto" style="display: none;" x-cloak>
            <div @click.away="editModalOpen = false" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl max-w-2xl w-full p-6 shadow-2xl my-8">
                <div class="flex items-center justify-between pb-4 border-b border-zinc-200 dark:border-zinc-800 mb-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Modifier le chauffeur</h3>
                    <button @click="editModalOpen = false" class="text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Nom</label>
                            <input type="text" name="nom" x-model="editData.nom" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Prénom</label>
                            <input type="text" name="prenom" x-model="editData.prenom" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Email</label>
                            <input type="email" name="email" x-model="editData.email" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Téléphone</label>
                            <input type="text" name="telephone" x-model="editData.telephone" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Matricule</label>
                            <input type="text" name="matricule" x-model="editData.matricule" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Numéro de Permis</label>
                            <input type="text" name="numeroPermis" x-model="editData.numeroPermis" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Catégorie de Permis</label>
                            <input type="text" name="categoriePermis" x-model="editData.categoriePermis" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Date d'expiration du permis</label>
                            <input type="date" name="dateExpirationPermis" x-model="editData.dateExpirationPermis" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Salaire (FCFA)</label>
                            <input type="number" step="0.01" name="salaire" x-model="editData.salaire" required class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 text-sm focus:border-zinc-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800 mt-6">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-xl text-sm font-medium transition">Annuler</button>
                        <button type="submit" class="px-5 py-2 bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-800 dark:hover:bg-white text-zinc-50 dark:text-zinc-950 rounded-xl text-sm font-medium transition">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODALE DE SUPPRESSION -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 backdrop-blur-sm p-4" style="display: none;" x-cloak>
            <div @click.away="deleteModalOpen = false" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Confirmer la suppression</h3>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mb-6">Êtes-vous sûr de vouloir supprimer ce chauffeur ? Cette action est irréversible.</p>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-xl text-sm font-medium transition">Annuler</button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-xl text-sm font-medium transition">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
