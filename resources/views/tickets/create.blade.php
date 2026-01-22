@extends('layouts.app')

@section('title', 'Nouveau Ticket')

@section('content')
<div class="min-h-full bg-gradient-to-br from-slate-50 via-white to-slate-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Header Section -->
        <div class="mb-6">
            <!-- Breadcrumbs -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                    <li class="hover:text-indigo-600 transition-colors">
                        <a href="{{ route('tickets.index') }}" class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            Support
                        </a>
                    </li>
                    <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-indigo-600 font-bold">Nouveau ticket</li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black tracking-tight text-slate-900 mb-1">Nouveau ticket</h1>
                    <p class="text-sm text-slate-600 font-medium">Créez une demande d'assistance claire, complète et assignable en 30 secondes.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-rose-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A1.5 1.5 0 004.09 19h15.82a1.5 1.5 0 001.3-2.14l-7.5-13a1.5 1.5 0 00-2.42 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-bold text-rose-800">Certaines informations sont manquantes ou invalides.</p>
                            <p class="text-sm text-rose-700">Corrigez les champs surlignés puis réessayez.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sticky action bar -->
        <div class="sticky top-16 z-30 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-3 mb-6 bg-white/85 backdrop-blur border-y border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white flex items-center justify-center shadow-sm shadow-indigo-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-900 leading-tight">Création d'un ticket</p>
                        <p class="text-xs text-slate-600">Les champs marqués <span class="text-rose-600 font-bold">*</span> sont obligatoires.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-end">
                    <a href="{{ route('tickets.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 hover:text-slate-900 rounded-lg hover:bg-slate-100 transition">
                        Annuler
                    </a>
                    <button type="submit" form="create-ticket-form"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 border border-transparent shadow-md shadow-indigo-500/20 text-sm font-black rounded-lg text-white hover:from-indigo-700 hover:to-blue-700 focus:outline-none transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Créer le ticket
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="max-w-3xl mx-auto">
            @include('tickets.partials._form', ['isModal' => false])
        </div>
    </div>
</div>
@endsection
