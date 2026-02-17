@extends('layouts.app')

@section('title', 'Nouvelle Opportunité')

@section('content')
<div class="min-h-screen bg-slate-950">
    <!-- Header Contextuel -->
    <div class="bg-slate-800/30 backdrop-blur-xl border-b border-white/5 sticky top-16 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="min-h-[4rem] flex flex-col sm:flex-row sm:items-center justify-between py-4 sm:py-0 gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('opportunities.index') }}" class="p-2 -ml-2 text-slate-400 hover:text-white rounded-lg hover:bg-white/5 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    </a>
                    <div class="flex flex-col min-w-0">
                        <h1 class="text-sm sm:text-lg font-bold text-white truncate">Nouvelle Opportunité</h1>
                        <p class="hidden xs:block text-[10px] sm:text-xs text-slate-400 truncate">Ajouter une nouvelle affaire au pipeline</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 justify-end">
                    <a href="{{ route('opportunities.index') }}" class="px-3 sm:px-4 py-2 text-[11px] sm:text-sm font-medium text-slate-300 hover:bg-white/5 border border-white/10 rounded-lg transition-colors">
                        Annuler
                    </a>
                    <button type="submit" form="create-opportunity-form" class="px-4 sm:px-6 py-2 text-[11px] sm:text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm hover:shadow transition-all flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="hidden sm:inline">Créer l'opportunité</span>
                        <span class="sm:hidden">Créer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form id="create-opportunity-form" action="{{ route('opportunities.store') }}" method="POST">
            @csrf
            @include('opportunities._form', ['opportunity' => null])
        </form>
    </div>
</div>
@endsection
