@extends('layouts.app')

@section('title', 'Nouveau Contact')

@section('content')
<div class="h-full bg-slate-50">
    <!-- Action Header: Professional & Functional -->
    <div class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-indigo-100 shadow-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <nav class="flex mb-1" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                <li><a href="{{ route('contacts.index') }}" class="hover:text-indigo-600 transition-colors">Contacts</a></li>
                                <li><svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                                <li class="text-slate-600">Nouveau</li>
                            </ol>
                        </nav>
                        <h1 class="text-xl font-bold text-slate-900">Créer un contact</h1>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('contacts.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-all">
                        Annuler
                    </a>
                    <button type="submit" form="create-contact-form" class="inline-flex items-center px-6 py-2 text-sm font-bold text-white bg-indigo-600 border border-indigo-700 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 transition-all active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Enregistrer le contact
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Two-Column CRM Layout -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form id="create-contact-form" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('contacts.partials._form')
        </form>
    </div>
</div>
@endsection
