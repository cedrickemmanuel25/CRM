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
<div class="w-full flex flex-col" x-data="pipelineView(
    '{{ request('view', 'pipeline') }}', 
    {{ request()->anyFilled(['search', 'commercial_id', 'stade', 'amount_min', 'amount_max', 'date_close_start', 'date_close_end']) ? 'true' : 'false' }}
)" @change-stage-request.window="handleStageRequest($event)">
    
    <!-- Loading Overlay -->
    <div x-show="isLoading" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-30" style="display: none;">
        <svg class="animate-spin h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <!-- Error Toast -->
    <div x-show="showErrorToast" x-transition class="fixed bottom-4 right-4 z-[100] w-full max-w-sm rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 p-4" style="display: none;">
        <div class="flex items-start">
             <div class="flex-shrink-0"><svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
             <div class="ml-3 w-0 flex-1 pt-0.5"><p class="text-sm font-medium text-gray-900">Erreur</p><p class="mt-1 text-sm text-gray-500" x-text="errorMessage"></p></div>
             <div class="ml-4 flex flex-shrink-0"><button @click="showErrorToast = false" class="bg-white rounded-md text-gray-400 hover:text-gray-500"><svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg></button></div>
        </div>
    </div>

    <!-- Header, Filters, Content ... -->

    
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
        isTouchDevice: false,
        initKanban() {
            // Detect if device supports touch
            this.isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
            
            @if(!auth()->user()->isSupport())
            // Only initialize drag-and-drop on NON-touch devices
            if (!this.isTouchDevice) {
                const kanbanContainers = document.querySelectorAll('.kanban-list');
                const self = this;
                kanbanContainers.forEach(container => {
                    new Sortable(container, {
                        group: 'opportunities',
                        animation: 0,
                        ghostClass: 'sortable-ghost',
                        dragClass: 'sortable-drag',
                        onStart: function() {
                            self.isDragging = true;
                        },
                        onEnd: function (evt) {
                            self.isDragging = false;
                            const item = evt.item;
                            const opportunityId = item.getAttribute('data-id');
                            const currentStage = item.getAttribute('data-current-stage');
                            const newStage = evt.to.getAttribute('data-stage');
                            
                            if (evt.from !== evt.to) {
                                // Dispatch event to Alpine pipelineView
                                window.dispatchEvent(new CustomEvent('change-stage-request', {
                                    detail: {
                                        id: opportunityId,
                                        stage: newStage,
                                        currentStage: currentStage,
                                        besoin: item.getAttribute('data-besoin'),
                                        budget: item.getAttribute('data-budget'),
                                        amount: item.getAttribute('data-amount'),
                                        client_name: item.getAttribute('data-client-name')
                                    }
                                }));
                                
                                // Cancel sortable's DOM move because we want to reload or let modal handle it
                                // Actually, Sortable has already moved it. If the user cancels the modal, 
                                // we should probably reload or move it back. 
                                // For now, reloading on success is handled by the modal submission.
                            }
                        }
                    });
                });
            } else {
                // On touch devices, ensure cards are not draggable
                const kanbanCards = document.querySelectorAll('.kanban-card');
                kanbanCards.forEach(card => {
                    card.style.pointerEvents = 'auto';
                    card.style.touchAction = 'pan-x pan-y';
                });
            }
            @endif
        },
        startPolling() {
            setInterval(() => {
                if (this.isDragging) return;
                
                const url = new URL(window.location.href);
                url.searchParams.set('polling', '1');
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (response.ok) return response.json();
                    throw new Error('Request failed');
                })
                .then(data => {
                    if (!this.isDragging && data.html) { // Double check
                        // Save scroll position before updating
                        const scrollContainers = this.$refs.contentArea.querySelectorAll('.overflow-x-auto');
                        const scrollPositions = Array.from(scrollContainers).map(container => ({
                            element: container,
                            scrollLeft: container.scrollLeft
                        }));
                        
                        const binaryString = atob(data.html);
                        const bytes = new Uint8Array(binaryString.length);
                        for (let i = 0; i < binaryString.length; i++) {
                            bytes[i] = binaryString.charCodeAt(i);
                        }
                        const decodedHtml = new TextDecoder('utf-8').decode(bytes);
                        
                        // Only update if content has changed to prevent scroll jumping
                        if (this.$el.innerHTML === decodedHtml) return;

                        this.$el.innerHTML = decodedHtml;
                        
                        // Re-initialize Alpine on the new content
                        if (window.Alpine) {
                            window.Alpine.initTree(this.$refs.contentArea);
                        }
                        
                        // Restore scroll positions IMMEDIATELY
                        const newScrollContainers = this.$refs.contentArea.querySelectorAll('.overflow-x-auto');
                        scrollPositions.forEach((saved, index) => {
                            if (newScrollContainers[index]) {
                                newScrollContainers[index].scrollLeft = saved.scrollLeft;
                            }
                        });
                        
                        // Update metrics
                        document.getElementById('total-pipeline-value').innerText = data.total_pipeline_value;
                        document.getElementById('weighted-pipeline-value').innerText = data.weighted_pipeline_value;
                        document.getElementById('active-opportunities-count').innerText = data.total_opportunities;
                        document.getElementById('win-rate').innerText = data.win_rate;
                        
                        this.initKanban();
                    }
                })
                .catch(error => console.warn('Polling error:', error));
            }, 5000);
        }
    }" x-init="initKanban(); startPolling();" 
    x-ref="contentArea">
        @include('opportunities._content')
    </div>

    @include('opportunities._modals')
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    .kanban-list { min-height: 100px; }
    .sortable-ghost { opacity: 0.5; }
    .sortable-drag { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    
    /* Ensure touch scrolling works on mobile */
    @media (max-width: 640px) {
        .kanban-card {
            touch-action: auto !important;
            pointer-events: auto !important;
            user-select: none;
        }
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
            touch-action: pan-x pan-y;
        }
    }
    
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
    function pipelineView(initialView, initialFilters) {
        return {
            viewMode: initialView,
            showFilters: initialFilters,
            switchView(mode) {
                this.viewMode = mode;
                localStorage.setItem('oppViewMode', mode);
                const url = new URL(window.location);
                url.searchParams.set('view', mode);
                window.history.pushState({}, '', url);
            },
            
            isLoading: false,
            transitionUrl: '',
            
            // Pipeline Modals
            showProspectionModal: false,
            showQualificationModal: false,
            showPropositionModal: false,
            showNegociationModal: false,
            showWonModal: false,
            showLostModal: false,
            
            showErrorToast: false,
            errorMessage: '',
            
            // Global store for card expansion states to survive drag-and-drop
            cardStates: {},
            
            getCardState(id) {
                if (this.cardStates[id] === undefined) {
                    this.cardStates[id] = false;
                }
                return this.cardStates[id];
            },
            
            toggleCard(id) {
                this.cardStates[id] = !this.cardStates[id];
            },
            
            activeOpportunity: {
                id: null,
                stade: '',
                besoin: '',
                budget: '',
                montant: '',
                client_name: ''
            },
            targetStage: null,
            
            stageGuides: {
                prospection:   { label: 'Prospection', objective: 'Entrer en relation' },
                qualification: { label: 'Qualification', objective: 'Vérifier le potentiel' },
                proposition:   { label: 'Proposition', objective: 'Convaincre' },
                negociation:   { label: 'Négociation', objective: 'Finaliser l’accord' },
                gagne:         { label: 'Gagné', objective: 'Exécution' },
                perdu:         { label: 'Perdu', objective: 'Analyse' }
            },

            handleStageRequest(event) {
                const data = event.detail;
                
                this.activeOpportunity = {
                    id: data.id,
                    stade: data.currentStage,
                    besoin: data.besoin || '',
                    budget: data.budget || '',
                    montant: data.amount || '',
                    client_name: data.client_name || ''
                };

                this.transitionUrl = `{{ route('opportunities.processTransition', ':id') }}`.replace(':id', data.id);
                
                this.changeStage(data.stage);
            },

            changeStage(newStage) {
                if (this.isLoading) return;
                
                // If it's the same stage, we might still want to open the modal for data update (especially in Prospection)
                // But generally we trigger modals on target stage
                
                const currentStage = this.activeOpportunity.stade;

                if (newStage === 'qualification') {
                    this.showProspectionModal = true;
                } else if (newStage === 'proposition') {
                    this.showQualificationModal = true;
                } else if (newStage === 'negociation') {
                    this.showPropositionModal = true;
                } else if (newStage === 'gagne') {
                    this.showWonModal = true;
                } else if (newStage === 'perdu') {
                    this.showLostModal = true;
                } else {
                    // Fallback for simple stages or confirm if no specific modal
                    this.updateStage(newStage);
                }
            },

            async executeStageChange() {
                this.showConfirmModal = false;
                this.updateStage(this.targetStage);
            },

            async submitQualification() {
                this.showQualifyModal = false;
                const form = document.getElementById('qualificationForm');
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                data.decisionnaire = form.querySelector('[name="decisionnaire"]').checked ? 1 : 0;
                
                this.updateStage('qualification', data);
            },

            async updateStage(stage, extraData = {}) {
                this.isLoading = true;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                try {
                    const payload = { stade: stage, ...extraData };
                    let url = `{{ route('opportunities.update', ':id') }}`.replace(':id', this.activeOpportunity.id);
                    let method = 'PUT'; 
                    
                    if (stage !== 'qualification') {
                        url = `{{ route('opportunities.updateStage', ':id') }}`.replace(':id', this.activeOpportunity.id);
                        method = 'PATCH';
                    }
                    
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const resData = await response.json();

                    if (resData.success || response.ok) {
                        window.location.reload(); 
                    } else {
                        throw new Error(resData.message || 'Erreur');
                    }
                } catch (error) {
                    this.isLoading = false;
                    this.errorMessage = error.message || 'Une erreur est survenue';
                    this.showErrorToast = true;
                    setTimeout(() => this.showErrorToast = false, 4000);
                }
            }
        }
    }
</script>
<script>
    async function updateOpportunityStage(id, stage) {
        try {
            const response = await axios.patch(`{{ url('/opportunities') }}/${id}/stage`, {
                stade: stage
            }, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            });

            if (response.data.success) {
                // assume success for smooth experience
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur lors de la mise à jour.');
            window.location.reload();
        }
    }

    async function deleteOpportunity(id, button) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette opportunité ?')) return;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await axios.delete(`{{ url('/opportunities') }}/${id}`, {
                headers: { 
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });

            if (response.data.success) {
                // Find and remove the appropriate UI element
                const card = button.closest('.kanban-card');
                const row = button.closest('tr');
                const mobileCard = button.closest('.bg-white.rounded-lg.border.border-gray-200.p-4');

                if (card) {
                    card.remove();
                } else if (row) {
                    row.remove();
                } else if (mobileCard) {
                    mobileCard.remove();
                }
            }
        } catch (error) {
            console.error('Erreur:', error);
            const msg = error.response?.data?.message || error.message;
            alert('Erreur lors de la suppression : ' + msg);
        }
    }
</script>
@endsection