@extends('layouts.app')

@section('title', 'Liste des Contacts')



@section('content')
<div class="w-full flex flex-col bg-gradient-to-br from-slate-50 via-white to-slate-50" x-data="{ search: '{{ request('search') }}', showAdvanced: {{ request()->anyFilled(['date_from', 'date_to']) ? 'true' : 'false' }} }">
    <!-- Fixed Header & Filters Section -->
    <div class="px-4 sm:px-6 lg:px-8 py-6 space-y-6 flex-shrink-0">
        <!-- Header -->
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex-1 min-w-0">
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                        <li class="hover:text-slate-700 transition-colors">CRM PRO</li>
                        <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-indigo-600 font-bold">Contacts</li>
                    </ol>
                </nav>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl mb-2">
                            Gestion des Contacts
                        </h1>
                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                                <span id="contact-count">{{ $contacts->total() }}</span> contacts
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4 gap-3">
                @if(!auth()->user()->isSupport())
                <a href="{{ route('reports.export', ['type' => 'contacts'] + request()->all()) }}" class="inline-flex items-center px-4 py-2.5 border border-slate-300 shadow-sm text-sm font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-400 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Exporter
                </a>
                @endif
                
                @if(!auth()->user()->isSupport())
                <a href="{{ route('contacts.create') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-md text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nouveau Contact
                </a>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5">
                <form action="{{ route('contacts.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col lg:flex-row gap-3">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-2.5 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Rechercher...">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700">Rechercher</button>
                            <button type="button" @click="showAdvanced = !showAdvanced" class="px-4 py-2.5 border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 bg-white" :class="showAdvanced ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : ''">
                                <span x-text="showAdvanced ? 'Masquer' : 'Filtres'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    <div class="flex flex-wrap items-center gap-2">
                        <select name="entreprise" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-xs font-medium border border-slate-200 rounded-lg bg-white hover:bg-slate-50 cursor-pointer">
                            <option value="">Toutes les entreprises</option>
                            @foreach($entreprises as $ent)
                                <option value="{{ $ent }}" {{ request('entreprise') == $ent ? 'selected' : '' }}>{{ $ent }}</option>
                            @endforeach
                        </select>
                        <select name="source" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-xs font-medium border border-slate-200 rounded-lg bg-white hover:bg-slate-50 cursor-pointer">
                            <option value="">Toutes les sources</option>
                            @foreach($sources as $source)
                                <option value="{{ $source }}" {{ request('source') == $source ? 'selected' : '' }}>{{ ucfirst($source) }}</option>
                            @endforeach
                        </select>
                         @if(auth()->user()->isAdmin() || auth()->user()->isSupport())
                        <select name="owner_id" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-xs font-medium border border-slate-200 rounded-lg bg-white hover:bg-slate-50 cursor-pointer">
                            <option value="">Tous les commerciaux</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                            @endforeach
                        </select>
                        @endif
                         @if(request()->anyFilled(['search', 'source', 'owner_id', 'date_from', 'date_to', 'entreprise']))
                        <a href="{{ route('contacts.index') }}" class="inline-flex items-center px-3 py-2 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-100">Réinitialiser</a>
                        @endif
                    </div>

                    <!-- Advanced Filters -->
                    <div x-show="showAdvanced" style="display: none" class="pt-4 border-t border-slate-200 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-lg">
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-lg">
                        <select name="per_page" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-lg">
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 par page</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 par page</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 par page</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white border-t border-slate-200 overflow-x-auto">
        <table class="min-w-full w-full divide-y divide-slate-200 relative">
            <thead class="bg-slate-50 sticky top-0 z-10 shadow-sm">
                <tr>
                    <th class="px-3 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[20%]">Contact</th>
                    <th class="px-3 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[15%]">Entreprise</th>
                    <th class="px-3 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[10%]">Coordonnées</th>
                    <th class="px-3 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[10%]">Source</th>
                    <th class="px-3 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[10%]">Statut CRM</th>
                    <th class="px-3 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[12%]">Propriétaire</th>
                    <th class="px-3 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[10%]">Création</th>
                    <th class="px-3 py-3.5 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider bg-slate-50 w-[8%]">Actions</th>
                </tr>
            </thead>
            <tbody x-data="{
                startPolling() {
                    // Démarrer le polling après un court délai pour éviter les conflits avec le chargement initial
                    setTimeout(() => {
                        setInterval(() => {
                            const url = new URL("{{ route('contacts.fetch') }}");
                            // Append current filters from main URL
                            const currentParams = new URLSearchParams(window.location.search);
                            currentParams.forEach((value, key) => {
                                url.searchParams.set(key, value);
                            });
                            
                            fetch(url, {
                                headers: { 
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                credentials: 'same-origin'
                            })
                            .then(response => {
                                if (response.ok) return response.json();
                                throw new Error('Request failed');
                            })
                            .then(data => {
                                if (data.html) {
                                    const decodedHtml = new TextDecoder().decode(Uint8Array.from(atob(data.html), c => c.charCodeAt(0)));
                                    this.$el.innerHTML = decodedHtml;
                                    const countEl = document.getElementById('contact-count');
                                    if (countEl) countEl.innerText = data.total;
                                }
                            })
                            .catch(error => console.warn('Polling error:', error));
                        }, 5000);
                    }, 1000);
                }
            }" x-init="startPolling()" class="bg-white divide-y divide-slate-100">
                @include('contacts._table_rows')
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($contacts->hasPages())
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex-shrink-0">
        {{ $contacts->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection