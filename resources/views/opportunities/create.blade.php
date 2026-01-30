@extends('layouts.app')

@section('title', 'Nouvelle Opportunité')

@section('content')
<div class="min-h-screen bg-gray-50/50">
    <!-- Header Contextuel -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('opportunities.index') }}" class="p-2 -ml-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Nouvelle Opportunité</h1>
                        <p class="text-xs text-gray-500">Ajouter une nouvelle affaire au pipeline</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('opportunities.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 border border-gray-300 rounded-lg transition-colors">
                        Annuler
                    </a>
                    <button type="submit" form="create-opportunity-form" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm hover:shadow transition-all flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Créer l'opportunité
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
