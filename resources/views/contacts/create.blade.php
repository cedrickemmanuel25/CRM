@extends('layouts.app')

@section('title', 'Nouveau Contact (Standard Entreprise)')

@section('content')
<div class="h-full flex flex-col bg-gray-50">
    <!-- Enterprise Command Bar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <!-- Left: Entity Context -->
                <div class="flex items-center gap-4">
                    <div class="h-9 w-9 rounded bg-gray-900 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        C
                    </div>
                    <div class="flex flex-col">
                        <nav aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                <li><a href="{{ route('contacts.index') }}" class="hover:text-indigo-600 transition-colors">Répertoire Contacts</a></li>
                                <li><svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                                <li class="text-gray-500">Instance Création</li>
                            </ol>
                        </nav>
                        <h1 class="text-base font-black text-gray-900 tracking-tight leading-none mt-0.5">Nouveau Prospect / Contact</h1>
                    </div>
                </div>
                
                <!-- Right: Command Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('contacts.index') }}" class="px-4 py-2 text-xs font-bold text-gray-600 hover:text-gray-900 bg-gray-50 border border-gray-200 rounded transition-all">
                        Abandonner
                    </a>
                    <button type="submit" form="create-contact-form" class="px-6 py-2 text-xs font-black text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 rounded shadow-md shadow-indigo-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 active:scale-95">
                        ENREGISTRER LA FICHE
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Workspace Layout -->
    <div class="max-w-[1600px] mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        <form id="create-contact-form" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('contacts.partials._form')
        </form>
    </div>
</div>
@endsection
