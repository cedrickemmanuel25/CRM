@extends('layouts.app')

@section('title', 'Nouvelle Opportunité')

@section('content')
<div class="min-h-screen bg-slate-50/50 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header & Breadcrumb -->
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs font-medium text-slate-500 uppercase tracking-wider">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            CRM
                        </a>
                    </li>
                    <li><svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li>
                        <a href="{{ route('opportunities.index') }}" class="hover:text-indigo-600 transition-colors">Opportunités</a>
                    </li>
                    <li><svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="text-slate-900 font-bold">Nouveau Pipeline</li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Nouvelle Opportunité</h1>
                    <p class="mt-2 text-lg text-slate-600">Ajoutez une nouvelle vente au pipeline commercial pour suivre son évolution.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2 animate-pulse"></span>
                        En attente de saisie
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="mt-8">
            <form action="{{ route('opportunities.store') }}" method="POST">
                @csrf
                @include('opportunities._form', ['opportunity' => null])
            </form>
        </div>
    </div>
</div>
@endsection
