@extends('layouts.app')

@section('title', 'Centre d\'Exports & Rapports')

@section('content')
<div class="min-h-screen bg-slate-50 py-8" x-data="{ exportType: 'opportunities', loading: false }">
    <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Centre de Données & Exports</h1>
            <p class="mt-2 text-slate-600 max-w-2xl">
                Générez des rapports détaillés sur vos opportunités, contacts et performances commerciales. 
                Toutes les extractions sont journalisées conformément aux directives de sécurité.
            </p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left Column: Export Engine (2 cols wide) -->
            <div class="xl:col-span-2 space-y-8">
                
                <!-- Main Export Builder -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                Configuration de l'Export
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">Sélectionnez les données à extraire</p>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <form action="{{ route('reports.export') }}" method="GET" class="space-y-8">
                            
                            <!-- 1. Data Source Selection -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">1. Type de Données</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="type" value="opportunities" x-model="exportType" class="sr-only peer" checked>
                                        <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all shadow-sm peer-checked:shadow-md">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="h-8 w-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </div>
                                                <span class="font-bold text-slate-900">Opportunités</span>
                                            </div>
                                            <p class="text-xs text-slate-500 pl-11">Pipeline, montants et stades</p>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="type" value="contacts" x-model="exportType" class="sr-only peer">
                                        <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all shadow-sm peer-checked:shadow-md">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="h-8 w-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                                </div>
                                                <span class="font-bold text-slate-900">Contacts</span>
                                            </div>
                                            <p class="text-xs text-slate-500 pl-11">Clients et Prospects</p>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="type" value="leads" x-model="exportType" class="sr-only peer">
                                        <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all shadow-sm peer-checked:shadow-md">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="h-8 w-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                                </div>
                                                <span class="font-bold text-slate-900">Leads</span>
                                            </div>
                                            <p class="text-xs text-slate-500 pl-11">Nouveaux prospects uniquement</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- 2. Filters -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">2. Période</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Du</label>
                                            <input type="date" name="date_from" class="block w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Au</label>
                                            <input type="date" name="date_to" class="block w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <p class="mt-2 text-[10px] text-slate-400">Laisser vide pour tout l'historique.</p>
                                </div>

                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">3. Segmentation</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Propriétaire</label>
                                            <select name="owner_id" class="block w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">Tous les utilisateurs</option>
                                                @foreach($users as $u)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div x-show="exportType !== 'opportunities'">
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Source</label>
                                            <select name="source" class="block w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">Toutes les sources</option>
                                                <option value="LinkedIn">LinkedIn</option>
                                                <option value="Site Web">Site Web</option>
                                                <option value="Événement">Événement</option>
                                                <option value="Bouche à oreille">Bouche à oreille</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- 3. Actions -->
                            <div class="flex flex-col sm:flex-row items-center gap-4 bg-slate-50 p-6 rounded-xl border border-slate-200">
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-900">Format de sortie</h4>
                                    <p class="text-xs text-slate-500">Choisissez le format adapté à votre usage</p>
                                </div>
                                <div class="flex gap-3 w-full sm:w-auto">
                                    <button type="submit" name="format" value="csv" @click="loading = true; setTimeout(() => loading = false, 3000)" :disabled="loading"
                                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-lg hover:bg-indigo-700 transition-all shadow-sm disabled:opacity-70">
                                        <svg x-show="!loading" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <svg x-show="loading" class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                        CSV / Excel
                                    </button>
                                    <button type="button" @click="const q = new URLSearchParams(new FormData($el.closest('form'))).toString(); window.location.href='{{ route('reports.pdf') }}?' + q"
                                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-2.5 bg-white border border-slate-300 text-slate-700 font-bold text-sm rounded-lg hover:bg-slate-50 transition-all shadow-sm">
                                        <svg class="h-4 w-4 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        Rapport PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Right Column: History & Info (1 col wide) -->
            <div class="space-y-8">
                
                <!-- History Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Historique Récent</h3>
                    </div>
                    <ul class="divide-y divide-slate-100">
                        @forelse($recentExports as $exp)
                        <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-1">
                                <span class="bg-slate-100 text-slate-600 py-0.5 px-2 rounded text-[10px] font-bold uppercase tracking-wide">
                                    {{ str_contains($exp->action, 'pdf') ? 'PDF' : 'CSV' }}
                                </span>
                                <span class="text-[10px] text-slate-400">{{ $exp->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm font-medium text-slate-800">
                                Export {{ $exp->new_values['type'] ?? 'données' }}
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">Par {{ $exp->user->name ?? 'Système' }}</p>
                        </li>
                        @empty
                        <li class="px-6 py-8 text-center">
                            <p class="text-xs text-slate-400 italic">Aucun historique d'export.</p>
                        </li>
                        @endforelse
                    </ul>
                </div>

                <!-- Info Card -->
                <div class="bg-indigo-900 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center mb-4 backdrop-blur-sm">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2">Sécurité & Gouvernance</h4>
                        <p class="text-indigo-200 text-sm leading-relaxed">
                            L'export de données est une action sensible. Assurez-vous de respecter les protocoles RGPD en vigueur.
                        </p>
                        @if(auth()->user()->isAdmin())
                        <div class="mt-4 pt-4 border-t border-indigo-800/50">
                            <a href="{{ route('admin.audit_logs.index') }}" class="text-xs font-bold text-white hover:text-indigo-200 flex items-center">
                                Voir le journal d'audit complet
                                <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                        </div>
                        @endif
                    </div>
                    <!-- Decorative BG -->
                    <svg class="absolute -right-6 -bottom-6 h-32 w-32 text-indigo-800 blur-sm opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
