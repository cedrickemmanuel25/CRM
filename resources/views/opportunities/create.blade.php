@extends('layouts.app')

@section('title', 'Nouvelle Opportunité (Standard Entreprise)')

@section('content')
<div class="h-full flex flex-col bg-gray-50">
    <!-- Enterprise Command Bar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <!-- Left: Entity Context -->
                <div class="flex items-center gap-4">
                    <div class="h-9 w-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-indigo-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="flex flex-col">
                        <nav aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                <li><a href="{{ route('opportunities.index') }}" class="hover:text-indigo-600 transition-colors">Pipeline Ventes</a></li>
                                <li><svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                                <li class="text-gray-500">Flux d'Acquisition</li>
                            </ol>
                        </nav>
                        <h1 class="text-base font-black text-gray-900 tracking-tight leading-none mt-0.5">Nouvelle Ouverture de Compte</h1>
                    </div>
                </div>
                
                <!-- Right: Command Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('opportunities.index') }}" class="px-4 py-2 text-xs font-bold text-gray-600 hover:text-gray-900 bg-gray-50 border border-gray-200 rounded-lg transition-all">
                        Abandonner
                    </a>
                    <button type="submit" form="create-opportunity-form" class="px-6 py-2 text-xs font-black text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 rounded-lg shadow-md shadow-indigo-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 active:scale-95">
                        LANCER DANS LE PIPELINE
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Workspace Layout -->
    <div class="max-w-[1600px] mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        <form id="create-opportunity-form" action="{{ route('opportunities.store') }}" method="POST">
            @csrf
            @include('opportunities._form', ['opportunity' => null])
        </form>
    </div>
</div>
@endsection
