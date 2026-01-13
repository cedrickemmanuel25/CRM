@extends('layouts.app')

@section('title', 'Nouveau Contact')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
            <li class="hover:text-slate-700 transition-colors">CRM PRO</li>
            <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li><a href="{{ route('contacts.index') }}" class="hover:text-slate-700 transition-colors">Contacts</a></li>
            <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li class="text-indigo-600 font-bold">Nouveau</li>
        </ol>
    </nav>

    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0 flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg border-2 border-white shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">
                Nouveau Contact
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('contacts.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit" form="create-contact-form" class="ml-3 inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Enregistrer le contact
            </button>
        </div>
    </div>

    <form id="create-contact-form" action="{{ route('contacts.store') }}" method="POST">
        @csrf
        @include('contacts.partials._form')
    </form>
</div>
@endsection
