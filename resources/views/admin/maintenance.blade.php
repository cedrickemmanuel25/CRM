@extends('layouts.app')

@section('title', 'Maintenance & RGPD - Nexus Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8 animate-fade-in-up">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="page-title">Maintenance <span class="accent">&amp; RGPD</span></h1>
            <p class="mt-2 text-slate-400 font-medium">Outils de sauvegarde, conformité RGPD et suppression de données.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 uppercase tracking-widest">
                Admin System
            </span>
        </div>
    </div>

    <!-- Sauvegarde Système -->
    <div class="bg-indigo-900/10 backdrop-blur-xl border border-indigo-500/20 rounded-3xl overflow-hidden shadow-2xl relative group">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/5 to-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="p-8 relative z-10">
            <div class="sm:flex sm:items-start sm:justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="h-10 w-10 rounded-xl bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30">
                            <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-tight">Sauvegarde du Système</h3>
                    </div>
                    <div class="mt-2 max-w-xl text-sm text-slate-400 font-medium leading-relaxed pl-[3.25rem]">
                        <p>Téléchargez une copie complète de la base de données pour sécuriser vos informations (format JSON/SQL). Cette action est recommandée avant toute mise à jour majeure.</p>
                    </div>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <form action="{{ route('admin.backup.run') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-indigo-500/50 shadow-lg shadow-indigo-500/20 font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-xs uppercase tracking-wider transition-all transform hover:scale-105">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lancer une sauvegarde
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Export RGPD -->
    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl relative">
        <div class="p-8">
            <div class="sm:flex sm:items-center text-left">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="h-10 w-10 rounded-xl bg-slate-800 flex items-center justify-center border border-white/10">
                            <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-tight">Conformité RGPD</h3>
                    </div>
                    <p class="mt-2 text-sm text-slate-400 font-medium pl-[3.25rem] max-w-2xl">Exportez toutes les données personnelles liées à un utilisateur spécifique pour répondre aux demandes de portabilité.</p>
                </div>
            </div>
            
            <div class="mt-6 pl-[3.25rem]">
                <form action="{{ route('admin.gdpr.export') }}" method="POST" class="sm:flex sm:items-center gap-4">
                    @csrf
                    <div class="w-full sm:max-w-md relative">
                        <label for="user_id" class="sr-only">Utilisateur</label>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <select id="user_id" name="user_id" class="block w-full pl-10 pr-10 py-3 rounded-xl border-white/10 bg-slate-800 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm appearance-none shadow-inner" required>
                            <option value="" class="bg-slate-900 text-slate-500">Sélectionner un utilisateur cible...</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" class="bg-slate-900">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="mt-3 w-full sm:mt-0 sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-white/10 shadow-lg font-bold rounded-xl text-white bg-slate-700 hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-xs uppercase tracking-wider transition-all">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Exporter données (JSON)
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Suppression de données -->
    <div class="bg-rose-900/10 backdrop-blur-xl border border-rose-500/20 rounded-3xl overflow-hidden shadow-2xl relative group">
         <div class="absolute inset-0 bg-gradient-to-r from-rose-600/5 to-orange-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
         <div class="p-8 relative z-10">
             <div class="sm:flex sm:items-start sm:justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="h-10 w-10 rounded-xl bg-rose-500/10 flex items-center justify-center border border-rose-500/20">
                            <svg class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-tight">Zone de Danger</h3>
                    </div>
                    <div class="mt-2 max-w-xl text-sm text-rose-200/70 font-medium leading-relaxed pl-[3.25rem]">
                        <p>Actions irréversibles sur les données. La suppression définitive effacera tous les éléments actuellement dans la corbeille (Soft Deleted) sans possibilité de récupération.</p>
                    </div>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <form action="{{ route('admin.maintenance.cleanup') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer DÉFINITIVEMENT toutes les données archivées ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-lg shadow-rose-900/20 font-bold rounded-xl text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:text-xs uppercase tracking-wider transition-all transform hover:scale-105">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Vidanger la corbeille
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
</style>
@endsection
