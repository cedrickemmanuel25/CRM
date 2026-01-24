@extends('layouts.app')

@section('title', 'Nouveau Contact')

@section('content')
<div class="min-h-full bg-gradient-to-b from-slate-50/50 to-white py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header & Navigation -->
        <div class="mb-10 text-center sm:text-left">
            <!-- Sophisticated Breadcrumbs -->
            <nav class="flex justify-center sm:justify-start mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1.5 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                    <li class="hover:text-indigo-600 transition-colors">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            CRM
                        </a>
                    </li>
                    <li><svg class="h-3 w-3 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="hover:text-indigo-600 transition-colors">
                        <a href="{{ route('contacts.index') }}">Contacts</a>
                    </li>
                    <li><svg class="h-3 w-3 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-indigo-600">Nouveau</li>
                </ol>
            </nav>

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
                        Nouveau <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">Contact</span>
                    </h1>
                    <p class="mt-3 text-base text-slate-500 font-medium max-w-2xl leading-relaxed">
                        Enregistrez un nouveau partenaire commercial. Complétez les informations pour un suivi optimal dans votre pipeline.
                    </p>
                </div>
                
                <div class="flex items-center justify-center sm:justify-end gap-3 shrink-0">
                    <a href="{{ route('contacts.index') }}" class="group inline-flex items-center px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm active:scale-95">
                        Annuler
                    </a>
                    <button type="submit" form="create-contact-form" class="inline-flex items-center px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 hover:shadow-indigo-200 hover:shadow-lg transition-all active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Créer le contact
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <form id="create-contact-form" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @include('contacts.partials._form')
        </form>
    </div>
</div>
@endsection
