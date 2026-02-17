@extends('layouts.app')

@section('title', 'Modifier Opportunité (Standard Entreprise)')

@section('content')
<div class="h-full flex flex-col bg-slate-950">
    <!-- Enterprise Command Bar -->
    <div class="bg-slate-800/30 backdrop-blur-xl border-b border-white/5 sticky top-16 z-40">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="min-h-[4rem] flex flex-col sm:flex-row sm:items-center justify-between py-4 sm:py-0 gap-4">
                <!-- Left: Entity Context -->
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 h-9 w-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-indigo-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <nav aria-label="Breadcrumb" class="hidden xs:block">
                            <ol class="flex items-center space-x-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                <li><a href="{{ route('opportunities.index') }}" class="hover:text-blue-400 transition-colors">Pipeline Ventes</a></li>
                                <li><svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                                <li class="text-slate-400">Mise à jour Dossier</li>
                            </ol>
                        </nav>
                        <h1 class="text-sm sm:text-base font-black text-white tracking-tight leading-none mt-0.5 truncate">Modifier : {{ $opportunity->titre }}</h1>
                    </div>
                </div>
                
                <!-- Right: Command Actions -->
                <div class="flex items-center justify-end flex-wrap sm:flex-nowrap gap-2">
                    <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" class="contents" onsubmit="return confirm('Êtes-vous sûr de vouloir archiver/supprimer cette opportunité ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex-shrink-0 inline-flex items-center justify-center h-9 px-3 sm:px-4 border border-transparent rounded-lg shadow-sm text-[11px] sm:text-sm font-semibold text-red-400 bg-red-500/10 hover:bg-red-500/20 hover:text-red-300 transition-all duration-200">
                            Archiver
                        </button>
                    </form>
                    <a href="{{ route('opportunities.show', $opportunity) }}" class="flex-shrink-0 inline-flex items-center justify-center h-9 px-3 sm:px-4 border border-white/10 rounded-lg shadow-sm text-[11px] sm:text-sm font-semibold text-slate-300 bg-slate-800 hover:bg-slate-700 transition-all duration-200">
                        Abandonner
                    </a>
                    <button type="submit" form="edit-opportunity-form" class="flex-shrink-0 inline-flex items-center justify-center h-9 px-4 sm:px-6 text-[11px] sm:text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 rounded-lg shadow-md shadow-indigo-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 active:scale-95">
                        <span class="hidden sm:inline uppercase">Enregistrer les modifications</span>
                        <span class="sm:hidden uppercase">Enregistrer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Workspace Layout -->
    <div class="max-w-[1600px] mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        <form id="edit-opportunity-form" action="{{ route('opportunities.update', $opportunity) }}" method="POST">
            @csrf
            @method('PUT')
            @include('opportunities._form', ['opportunity' => $opportunity])
        </form>
    </div>
</div>
@endsection
