@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Tableau de bord</h1>
        <p class="text-slate-400 text-sm mt-1">Bienvenue dans l'espace de gestion centrale de MaliTrans.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl">
            <p class="text-slate-400 text-sm font-medium">Chauffeurs</p>
            <p class="text-3xl font-bold text-white mt-2">--</p>
        </div>
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl">
            <p class="text-slate-400 text-sm font-medium">Caissiers</p>
            <p class="text-3xl font-bold text-white mt-2">--</p>
        </div>
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl">
            <p class="text-slate-400 text-sm font-medium">Mécaniciens</p>
            <p class="text-3xl font-bold text-white mt-2">--</p>
        </div>
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl">
            <p class="text-slate-400 text-sm font-medium">Agents d'Exploitation</p>
            <p class="text-3xl font-bold text-indigo-400 mt-2">--</p>
        </div>
    </div>
@endsection
