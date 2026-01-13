@extends('layouts.app')

@section('title', 'Pipeline Opportunités')



@section('header_actions')
    @if(auth()->user()->hasRole(['admin', 'commercial']))
    <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Nouvelle Opportunité
    </a>
    @endif
@endsection

@section('content')
<div class="w-full flex flex-col" x-data="{ 
    viewMode: '{{ session('opportunities_view_mode', 'pipeline') }}', 
    showFilters: {{ request()->anyFilled(['search', 'commercial_id', 'stade', 'amount_min', 'amount_max', 'date_close_start', 'date_close_end']) ? 'true' : 'false' }},
    switchView(mode) {
        this.viewMode = mode;
        localStorage.setItem('oppViewMode', mode);
    }
}">
    
    <!-- Header professionnel, Métriques clés, Barre de contrôles, Panneau de filtres -->
    <div class="flex-shrink-0 max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Pipeline des Ventes</h1>
                    <p class="mt-1 text-sm text-gray-600">Gérez et suivez vos opportunités commerciales</p>
                </div>
                
                <div class="flex items-center gap-3">
                    @if(auth()->user()->hasRole(['admin', 'commercial']))
                    <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-transparent rounded-lg shadow-sm text-xs sm:text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <svg class="-ml-1 mr-1 sm:mr-2 h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span class="hidden sm:inline">Nouvelle Opportunité</span>
                        <span class="sm:hidden">Nouveau</span>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Métriques clés -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Pipeline</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900" id="total-pipeline-value">{{ format_currency($totalPipelineValue) }}</p>
                        </div>
                        <div class="h-12 w-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Valeur Pondérée</p>
                            <p class="mt-2 text-3xl font-bold text-emerald-600" id="weighted-pipeline-value">{{ format_currency($weightedPipelineValue) }}</p>
                        </div>
                        <div class="h-12 w-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Opportunités Actives</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900" id="active-opportunities-count">{{ $opportunities->total() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Taux de Conversion</p>
                            <p class="mt-2 text-3xl font-bold text-purple-600" id="win-rate">
                                @php
                                    $total = collect($pipeline)->flatten()->count();
                                    $won = isset($pipeline['gagne']) ? $pipeline['gagne']->count() : 0;
                                    $rate = $total > 0 ? round(($won / $total) * 100, 1) : 0;
                                @endphp
                                {{ $rate }}%
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de contrôles -->
        <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <!-- Toggle de vue -->
                <div class="inline-flex bg-gray-100 rounded-lg p-1 w-full sm:w-auto">
                    <button @click="switchView('pipeline')" :class="viewMode === 'pipeline' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'" class="flex-1 sm:flex-none px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all flex items-center justify-center">
                        <svg class="h-4 w-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                        Pipeline
                    </button>
                    <button @click="switchView('list')" :class="viewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'" class="flex-1 sm:flex-none px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all flex items-center justify-center">
                        <svg class="h-4 w-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Liste
                    </button>
                </div>

                <!-- Bouton filtres -->
                <button @click="showFilters = !showFilters" :class="showFilters ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-white text-gray-700 border-gray-300'" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 rounded-lg border text-xs sm:text-sm font-medium transition-all w-full sm:w-auto">
                    <svg class="h-4 w-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filtres
                </button>
            </div>
        </div>

        <!-- Panneau de filtres -->
        <div x-show="showFilters" x-transition class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <form action="{{ route('opportunities.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Commercial</label>
                        <select name="commercial_id" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Tous</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('commercial_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stade</label>
                        <select name="stade" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Tous</option>
                            @foreach(['prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu'] as $s)
                            <option value="{{ $s }}" {{ request('stade') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                        <input type="date" name="date_close_start" value="{{ request('date_close_start') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                        <input type="date" name="date_close_end" value="{{ request('date_close_end') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant min (€)</label>
                        <input type="number" name="amount_min" value="{{ request('amount_min') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant max (€)</label>
                        <input type="number" name="amount_max" value="{{ request('amount_max') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('opportunities.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                        Réinitialiser
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Appliquer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scrollable Content Area for Pipeline/List Views -->
    <div x-data="{
        isDragging: false,
        initKanban() {
            @if(!auth()->user()->isSupport())
            const kanbanContainers = document.querySelectorAll('.kanban-list');
            const self = this;
            kanbanContainers.forEach(container => {
                new Sortable(container, {
                    group: 'opportunities',
                    animation: 200,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onStart: function() {
                        self.isDragging = true;
                    },
                    onEnd: function (evt) {
                        self.isDragging = false;
                        const opportunityId = evt.item.getAttribute('data-id');
                        const newStage = evt.to.getAttribute('data-stage');
                        
                        if (evt.from !== evt.to) {
                            updateOpportunityStage(opportunityId, newStage);
                        }
                    }
                });
            });
            @endif
        },
        startPolling() {
            setInterval(() => {
                if (this.isDragging) return;
                
                const url = new URL(window.location.href);
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (!this.isDragging) { // Double check
                        this.$refs.contentArea.innerHTML = data.html;
                        
                        // Update metrics
                        document.getElementById('total-pipeline-value').innerText = data.total_pipeline_value;
                        document.getElementById('weighted-pipeline-value').innerText = data.weighted_pipeline_value;
                        document.getElementById('active-opportunities-count').innerText = data.total_opportunities;
                        document.getElementById('win-rate').innerText = data.win_rate;
                        
                        this.initKanban();
                    }
                });
            }, 5000);
        }
    }" x-init="initKanban(); startPolling();" 
    x-ref="contentArea">
        @include('opportunities._content')
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    .kanban-list { min-height: 100px; }
    .sortable-ghost { opacity: 0.5; }
    .sortable-drag { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    async function updateOpportunityStage(id, stage) {
        try {
            const response = await axios.patch(`/opportunities/${id}/stage`, {
                stade: stage
            }, {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            if (response.data.success) {
                // Optional: Show toast or just rely on polling/reload
                // If we rely on polling, we don't strictly need to reload, but reloading ensures state consistency
                // For smoother experience, we can suppress reload if we trust the drag
                // But data updates (amounts etc) might need refresh.
                // Let's trigger a manual refresh of the content area if possible, or just wait for poll.
                // For now, reload is safest but disruptive.
                // Let's NOT reload and let the drop stay, assume success. Polling will catch up details.
                // BUT, if we don't reload, the stats in the header won't update immediately.
                // Given the requirement "dynamically updated", maybe we should fetch fresh data immediately.
                
                // For now, let's keep the user comfortable without full reload
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur lors de la mise à jour.');
            window.location.reload();
        }
    }
</script>
@endsection