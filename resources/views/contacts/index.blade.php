@extends('layouts.app')

@section('title', 'Liste des Contacts')



@section('content')
<style>
    :root {
        --enterprise-bg: #0f172a;
        --enterprise-card: rgba(30, 41, 59, 0.4);
        --enterprise-border: rgba(255, 255, 255, 0.08);
        --enterprise-accent: #3b82f6;
    }

    .saas-card {
        background: var(--enterprise-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--enterprise-border);
        border-radius: 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .saas-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .label-caps {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
    }

    .btn-action {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #f8fafc;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #f8fafc;
    }

    /* Custom Scrollbar */
    .saas-scroll::-webkit-scrollbar { width: 4px; }
    .saas-scroll::-webkit-scrollbar-track { background: transparent; }
    .saas-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>

<div class="w-full flex flex-col bg-[#0f172a] min-h-screen text-slate-100" x-data="{ search: '{{ request('search') }}', showAdvanced: {{ request()->anyFilled(['date_from', 'date_to']) ? 'true' : 'false' }} }">
    <!-- Fixed Header & Filters Section -->
    <div class="px-4 sm:px-6 lg:px-8 py-6 space-y-6 flex-shrink-0">
        <!-- Header -->
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex-1 min-w-0">
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        <li class="hover:text-slate-300 transition-colors">CRM PRO</li>
                        <li><svg class="h-3 w-3 text-slate-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-blue-500">Contacts</li>
                    </ol>
                </nav>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="page-title">Mes <span class="accent">Contacts</span></h1>
                            Gestion des Contacts
                        </h1>
                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                                <span id="contact-count">{{ $contacts->total() }}</span> contacts
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex flex-col sm:flex-row lg:mt-0 lg:ml-4 gap-3">
                @if(!auth()->user()->isSupport())
                <a href="{{ route('reports.export', ['type' => 'contacts'] + request()->all()) }}" class="btn-action inline-flex items-center justify-center px-5 py-2.5 text-xs font-semibold rounded-lg order-2 sm:order-1">
                    <svg class="-ml-1 mr-2 h-4 w-4 opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Exporter
                </a>
                @endif
                
                @if(!auth()->user()->isSupport())
                <a href="{{ route('contacts.create') }}" class="inline-flex items-center justify-center px-6 py-2.5 shadow-lg text-xs font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 order-1 sm:order-2">
                    <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nouveau Contact
                </a>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="saas-card overflow-hidden">
            <div class="p-5">
                <form action="{{ route('contacts.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col lg:flex-row gap-3">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-sm text-slate-100 placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="Rechercher...">
                        </div>
                        <div class="flex gap-2 w-full lg:w-auto">
                            <button type="submit" class="flex-1 lg:flex-none px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all shadow-sm">Rechercher</button>
                            <button type="button" @click="showAdvanced = !showAdvanced" class="btn-action px-4 py-2.5 text-sm font-semibold rounded-lg" :class="showAdvanced ? 'bg-blue-600 text-white border-blue-600' : ''">
                                <span x-text="showAdvanced ? 'Masquer' : 'Filtres'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    <div class="flex flex-wrap items-center gap-2">
                        <select name="entreprise" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-[10px] font-bold uppercase tracking-wider bg-white/5 text-slate-300 border border-white/10 rounded-lg cursor-pointer focus:ring-1 focus:ring-blue-500 outline-none">
                            <option value="" class="bg-[#1e293b]">Toutes les entreprises</option>
                            @foreach($entreprises as $ent)
                                <option value="{{ $ent }}" {{ request('entreprise') == $ent ? 'selected' : '' }} class="bg-[#1e293b]">{{ $ent }}</option>
                            @endforeach
                        </select>
                        <select name="source" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-[10px] font-bold uppercase tracking-wider bg-white/5 text-slate-300 border border-white/10 rounded-lg cursor-pointer focus:ring-1 focus:ring-blue-500 outline-none">
                            <option value="" class="bg-[#1e293b]">Toutes les sources</option>
                            @foreach($sources as $source)
                                <option value="{{ $source }}" {{ request('source') == $source ? 'selected' : '' }} class="bg-[#1e293b]">{{ ucfirst($source) }}</option>
                            @endforeach
                        </select>
                         @if(auth()->user()->isAdmin() || auth()->user()->isSupport())
                        <select name="owner_id" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-[10px] font-bold uppercase tracking-wider bg-white/5 text-slate-300 border border-white/10 rounded-lg cursor-pointer focus:ring-1 focus:ring-blue-500 outline-none">
                            <option value="" class="bg-[#1e293b]">Tous les commerciaux</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }} class="bg-[#1e293b]">{{ $owner->name }}</option>
                            @endforeach
                        </select>
                        @endif
                         @if(request()->anyFilled(['search', 'source', 'owner_id', 'date_from', 'date_to', 'entreprise']))
                        <a href="{{ route('contacts.index') }}" class="inline-flex items-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg hover:bg-rose-500/20">Réinitialiser</a>
                        @endif
                    </div>

                    <!-- Advanced Filters -->
                    <div x-show="showAdvanced" style="display: none" class="pt-4 border-t border-white/5 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="block w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-sm text-slate-300 focus:ring-1 focus:ring-blue-500 outline-none">
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="block w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-sm text-slate-300 focus:ring-1 focus:ring-blue-500 outline-none">
                        <select name="per_page" class="block w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-sm text-slate-300 focus:ring-1 focus:ring-blue-500 outline-none">
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }} class="bg-[#1e293b]">20 par page</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }} class="bg-[#1e293b]">50 par page</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }} class="bg-[#1e293b]">100 par page</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Dynamic Content Container -->
    <div x-data="contactsTable" x-init="init()" class="bg-[#0f172a] border-t border-white/5">
        <!-- Table View (Desktop & Tablet) -->
        <div class="hidden lg:block overflow-x-auto saas-scroll">
            <table class="min-w-full w-full divide-y divide-white/5 relative">
                <thead class="bg-slate-900/50 sticky top-0 z-10 backdrop-blur-md shadow-sm">
                    <tr>
                        <th class="px-3 py-4 text-left label-caps w-[40%] sm:w-[20%]">Contact</th>
                        <th class="px-3 py-4 text-left label-caps w-[30%] sm:w-[15%]">Entreprise</th>
                        <th class="hidden lg:table-cell px-3 py-4 text-left label-caps w-[10%]">Coordonnées</th>
                        <th class="hidden md:table-cell px-3 py-4 text-left label-caps w-[10%]">Source</th>
                        <th class="hidden sm:table-cell px-3 py-4 text-left label-caps w-[10%]">Statut CRM</th>
                        <th class="hidden lg:table-cell px-3 py-4 text-left label-caps w-[12%]">Propriétaire</th>
                        <th class="hidden xl:table-cell px-3 py-4 text-left label-caps w-[10%]">Création</th>
                        <th class="px-3 py-4 text-right label-caps w-40 min-w-[160px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 table-view-body">
                    @include('contacts._table_rows', ['viewType' => 'table'])
                </tbody>
            </table>
        </div>

        <!-- Card View (Mobile) -->
        <div class="lg:hidden p-4 space-y-4 card-view-body bg-slate-950/20">
            @include('contacts._table_rows', ['viewType' => 'card'])
        </div>
    </div>

    <!-- Pagination -->
    @if($contacts->hasPages())
    <div class="px-6 py-4 bg-slate-900/30 border-t border-white/5 flex-shrink-0">
        {{ $contacts->withQueryString()->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contactsTable', () => ({
        pollingInterval: null,
        
        init() {
            this.startPolling();
        },
        
        startPolling() {
            // Démarrer après un délai pour éviter les conflits
            setTimeout(() => {
                this.pollingInterval = setInterval(() => {
                    this.fetchContacts();
                }, 5000);
            }, 1000);
        },
        
        async fetchContacts() {
            try {
                const url = new URL('{{ route('contacts.fetch') }}');
                
                // Ajouter les paramètres de filtre actuels
                const currentParams = new URLSearchParams(window.location.search);
                currentParams.forEach((value, key) => {
                    url.searchParams.set(key, value);
                });
                
                const response = await fetch(url, {
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.html) {
                    // Décoder le HTML base64 en gérant correctement l'UTF-8
                    const binaryString = atob(data.html);
                    const bytes = new Uint8Array(binaryString.length);
                    for (let i = 0; i < binaryString.length; i++) {
                        bytes[i] = binaryString.charCodeAt(i);
                    }
                    const decodedHtml = new TextDecoder('utf-8').decode(bytes);
                    
                    // Si le HTML contient les deux vues (séparées par un commentaire ou un marqueur)
                    if (decodedHtml.includes('<!-- CARD_VIEW_START -->')) {
                        const tableHtml = decodedHtml.split('<!-- CARD_VIEW_START -->')[0].replace('<!-- TABLE_VIEW_START -->', '').trim();
                        const cardHtml = decodedHtml.split('<!-- CARD_VIEW_START -->')[1].replace('<!-- CARD_VIEW_END -->', '').trim();
                        
                        const tableView = this.$el.querySelector('.table-view-body');
                        const cardView = this.$el.querySelector('.card-view-body');
                        
                        if (tableView) tableView.innerHTML = tableHtml;
                        if (cardView) cardView.innerHTML = cardHtml;
                    } else {
                        // Fallback pour la compatibilité
                        this.$el.innerHTML = decodedHtml;
                    }
                    
                    // Mettre à jour le compteur
                    const countEl = document.getElementById('contact-count');
                    if (countEl && data.total !== undefined) {
                        countEl.innerText = data.total;
                    }
                }
            } catch (error) {
                console.warn('Erreur lors du polling des contacts:', error.message);
            }
        },
        
        destroy() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
            }
        }
    }));
});
</script>
@endpush
@endsection