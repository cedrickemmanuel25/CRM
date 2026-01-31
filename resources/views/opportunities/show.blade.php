@extends('layouts.app')

@section('title', 'Opportunité : ' . $opportunity->titre)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="opportunityData(
    '{{ $opportunity->stade }}',
    '{{ route('opportunities.updateStage', $opportunity) }}',
    '{{ csrf_token() }}'
)" x-cloak>
    
    <!-- Loading Overlay -->
    <div x-show="isLoading" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-30" style="display: none;">
        <svg class="animate-spin h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <!-- Error Toast Notification -->
    <div x-show="showErrorToast" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-4 right-4 z-[80] w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 pointer-events-auto" style="display: none;">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">Erreur</p>
                    <p class="mt-1 text-sm text-gray-500" x-text="errorMessage"></p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" @click="showErrorToast = false" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Fermer</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div x-show="showConfirmModal" class="fixed inset-0 z-[70] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showConfirmModal = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Changer d'étape ?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Voulez-vous passer cette opportunité à l'étape <span x-text="stageGuides[targetStage] ? stageGuides[targetStage].label.toUpperCase() : 'SUIVANTE'" class="font-bold text-indigo-600"></span> ?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="executeStageChange()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmer
                    </button>
                    <button type="button" @click="showConfirmModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Qualification Modal (Relocated) -->
    <div x-show="showQualifyModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showQualifyModal = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white uppercase tracking-wider" id="modal-title">
                        Qualification de l'Opportunité
                    </h3>
                    <button @click="showQualifyModal = false" class="text-indigo-200 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <!-- Form content is large, I should just move it or use include. For now I paste the structure and rely on the fact that I will DELETE the duplicates at the bottom -->
                <form action="{{ route('opportunities.update', $opportunity) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="space-y-6">
                            <p class="text-sm text-gray-500 bg-gray-50 p-3 rounded-lg border-l-4 border-indigo-500">
                                Pour passer à l'étape suivante, veuillez valider les critères de qualification.
                            </p>
                            <input type="hidden" name="stade" value="qualification">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="modal_budget" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Budget Estimé</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">{{ currency_symbol() }}</span>
                                        </div>
                                        <input type="number" name="budget_estime" id="modal_budget" value="{{ old('budget_estime', $opportunity->budget_estime) }}" required
                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md py-2" placeholder="0.00">
                                    </div>
                                </div>
                                <div>
                                    <label for="modal_delai" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Délai Souhaité</label>
                                    <input type="date" name="delai_projet" id="modal_delai" value="{{ old('delai_projet', $opportunity->delai_projet ? $opportunity->delai_projet->format('Y-m-d') : '') }}" required
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-2">
                                </div>
                            </div>
                            <div class="relative flex items-start py-3 px-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="min-w-0 flex-1 text-sm">
                                    <label for="modal_decisionnaire" class="font-bold text-gray-700 select-none cursor-pointer">Décisionnaire identifié</label>
                                </div>
                                <div class="ml-3 flex items-center h-5">
                                    <input id="modal_decisionnaire" name="decisionnaire" type="checkbox" value="1" {{ $opportunity->decisionnaire ? 'checked' : '' }}
                                        class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded cursor-pointer">
                                </div>
                            </div>
                            <div>
                                <label for="modal_besoin" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Besoins / Points de Douleur</label>
                                <textarea name="besoin" id="modal_besoin" rows="3" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('besoin', $opportunity->besoin) }}</textarea>
                            </div>
                            <input type="hidden" name="score" value="20">
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm uppercase tracking-wide">
                            Valider & Qualifier
                        </button>
                        <button type="button" @click="showQualifyModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pipeline Progress Bar Moved to List View -->
    <div class="mb-4"></div>

    <!-- Top Actions Mobil/Desktop -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs text-gray-400">
                    <li><a href="{{ route('opportunities.index') }}" class="hover:text-gray-600">Pipeline</a></li>
                    <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="font-medium text-gray-600 truncate max-w-[200px]">{{ $opportunity->titre }}</li>
                </ol>
            </nav>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ $opportunity->titre }}
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
             @if(auth()->user()->hasRole(['admin', 'commercial']) && (auth()->user()->isAdmin() || $opportunity->commercial_id === auth()->id()))
                
                @if($opportunity->stade === 'prospection')
                    <button @click="showQualifyModal = true" class="inline-flex items-center px-6 py-2 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Qualifier l'opportunité
                    </button>
                @endif

                @if(!in_array($opportunity->stade, ['gagne', 'perdu']))
                <form action="{{ route('opportunities.markWon', $opportunity) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Marquer Gagné
                    </button>
                </form>
                <form action="{{ route('opportunities.markLost', $opportunity) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Marquer Perdu
                    </button>
                </form>
                @endif
                <a href="{{ route('opportunities.edit', $opportunity) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Modifier
                </a>
                <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette opportunité ?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-red-700 bg-red-100 hover:bg-red-200 transition-all duration-200">
                        Supprimer
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Filter Feedback -->
    @if(request()->filled('type') || request()->filled('date_start'))
    <div class="mb-4 bg-indigo-50 border-l-4 border-indigo-400 p-4 flex justify-between items-center">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-indigo-700">
                    Filtres actifs : 
                    @if(request('type')) <strong>{{ ucfirst(request('type')) }}</strong> @endif
                    @if(request('date_start')) depuis le <strong>{{ \Carbon\Carbon::parse(request('date_start'))->format('d/m/Y') }}</strong> @endif
                    @if(request('date_end')) jusqu'au <strong>{{ \Carbon\Carbon::parse(request('date_end'))->format('d/m/Y') }}</strong> @endif
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('opportunities.show', $opportunity) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 underline">Effacer</a>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- COLONNE GAUCHE (35%) : Détails & Contact -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Carte Résumé Financial -->
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 shadow-lg rounded-xl overflow-hidden text-white p-6">
                <p class="text-xs font-semibold uppercase tracking-wider opacity-80 mb-1">Montant Estimé</p>
                <div class="flex items-baseline space-x-2">
                    <span class="text-4xl font-extrabold">{{ format_currency($opportunity->montant_estime) }}</span>
                    <span class="text-indigo-200 text-sm">({{ format_currency($opportunity->weighted_value) }} pondéré)</span>
                </div>
                
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="opacity-80">Stade actuel</span>
                        <span class="font-bold px-2 py-0.5 bg-white/20 rounded capitalize">{{ $opportunity->stade }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="opacity-80">Probabilité</span>
                        <div class="flex items-center">
                            <div class="w-16 h-1.5 bg-white/20 rounded-full mr-2">
                                <div class="h-1.5 bg-white rounded-full" style="width: {{ $opportunity->probabilite }}%"></div>
                            </div>
                            <span class="font-bold">{{ $opportunity->probabilite }}%</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="opacity-80">Clôture prévue</span>
                        <span class="font-bold">{{ $opportunity->date_cloture_prev ? $opportunity->date_cloture_prev->format('d/m/Y') : 'Non définie' }}</span>
                    </div>
                </div>
            </div>

            <!-- Carte Contact Associé -->
            <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900">Contact Associé</h3>
                    @if($opportunity->contact)
                        <a href="{{ route('contacts.show', $opportunity->contact) }}" class="text-xs text-indigo-600 hover:underline">Voir profil</a>
                    @endif
                </div>
                <div class="p-5">
                    @if($opportunity->contact)
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-lg font-bold text-gray-400 mr-3">
                            {{ strtoupper(substr($opportunity->contact->prenom, 0, 1) . substr($opportunity->contact->nom, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 leading-tight">{{ $opportunity->contact->prenom }} {{ $opportunity->contact->nom }}</p>
                            <p class="text-sm text-gray-500">{{ $opportunity->contact->entreprise }}</p>
                        </div>
                    </div>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center text-gray-600">
                            <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $opportunity->contact->email }}
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $opportunity->contact->telephone ?? '-' }}
                        </li>
                    </ul>
                    @else
                    <p class="text-sm text-gray-400 italic">Aucun contact associé.</p>
                    @endif
                </div>
            </div>

            <!-- Propriétaire & Info Système -->
            <div class="bg-white shadow rounded-xl border border-gray-100 p-5">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Informations</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Commercial</span>
                        <div class="flex items-center">
                            <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-700 mr-2">
                                {{ substr($opportunity->commercial->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $opportunity->commercial->name }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Créé le</span>
                        <span class="text-gray-900 font-medium">{{ $opportunity->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="flex flex-col text-sm border-t border-gray-100 pt-3 mt-3">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Mode</span>
                        <span class="font-medium text-gray-900 capitalize flex items-center">
                            {{ $opportunity->attribution_mode === 'auto' ? 'Automatique 🤖' : 'Manuel 👤' }}
                        </span>
                    </div>
                    @if($opportunity->assigned_at)
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Depuis le</span>
                        <span class="font-medium text-gray-900">{{ $opportunity->assigned_at->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    <button @click="showHistory = true" class="text-indigo-600 hover:text-indigo-800 text-xs text-right mt-1 underline">
                        Voir l'historique
                    </button>
                </div>

            </div>

            <!-- Modal for Attribution History -->
            <div x-show="showHistory" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showHistory = false"></div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full p-6 relative">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Historique d'attribution</h3>
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($opportunity->attributionHistory->sortByDesc('created_at') as $history)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last) <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span> @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center ring-8 ring-white">
                                                    <span class="text-xs font-bold text-indigo-600">{{ substr($history->assignedTo->name, 0, 1) }}</span>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Assigné à <span class="font-medium text-gray-900">{{ $history->assignedTo->name }}</span>
                                                        <span class="text-xs text-gray-400 block">
                                                            Par {{ $history->assignedBy ? $history->assignedBy->name : 'Système (Auto)' }} 
                                                            ({{ $history->mode }})
                                                        </span>
                                                    </p>
                                                    @if($history->reason)
                                                        <p class="text-xs text-gray-400 mt-1 italic">"{{ $history->reason }}"</p>
                                                    @endif
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $history->created_at }}">{{ $history->created_at->format('d/m/Y') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @if($opportunity->attributionHistory->isEmpty())
                            <p class="text-center text-gray-500 italic py-4">Aucun historique disponible.</p>
                        @endif
                        <div class="mt-5 sm:mt-6">
                            <button type="button" @click="showHistory = false" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:text-sm">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- COLONNE CENTRALE (65%) : Activités & Description -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Description -->
            <div class="bg-white shadow rounded-xl border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-4 border-b pb-2">Description / Notes</h3>
                <div class="prose prose-sm max-w-none text-gray-600">
                    {!! nl2br(e($opportunity->description ?? 'Aucune description disponible pour cette opportunité.')) !!}
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-white shadow rounded-lg px-2">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Vue d'ensemble
                    </button>
                    <button @click="activeTab = 'timeline'" 
                        :class="activeTab === 'timeline' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Historique ({{ $opportunity->activities->count() }})
                    </button>
                    <button @click="activeTab = 'notes'" 
                        :class="activeTab === 'notes' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Notes & Fichiers
                    </button>
                    <button @click="activeTab = 'history'" 
                        :class="activeTab === 'history' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Historique des Stades ({{ $opportunity->stage_history->count() }})
                    </button>
                </nav>
            </div>

            <!-- TAB: VUE D'ENSEMBLE (Activités Récentes + Quick Add) -->
            <div x-show="activeTab === 'overview'" class="space-y-6" x-transition>
                
                <!-- Quick Add Interaction -->
                <div class="bg-white shadow rounded-lg p-4 cursor-pointer hover:bg-gray-50 transition border border-dashed border-gray-300" @click="showActivityForm = !showActivityForm">
                     <div class="flex items-center justify-center text-gray-500">
                        <svg class="h-5 w-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span class="font-medium">Consigner une interaction (Appel, Email, Note)...</span>
                     </div>
                </div>

                <!-- Formulaire Rapide Add Activity (Generic Logic) -->
                <div x-show="showActivityForm" class="bg-white p-6 border rounded-lg shadow-lg" x-transition style="display: none;">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Nouvelle Interaction</h3>
                        <button @click="showActivityForm = false" class="text-gray-400 hover:text-gray-500"><svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg></button>
                    </div>
                    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parent_type" value="App\Models\Opportunity">
                        <input type="hidden" name="parent_id" value="{{ $opportunity->id }}">
                        
                        <div class="grid grid-cols-12 gap-4 mb-4">
                            <div class="col-span-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <select name="type" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="appel">Appel Téléphonique</option>
                                    <option value="email">Email</option>
                                    <option value="reunion">Réunion</option>
                                    <option value="note">Note Interne</option>
                                    <option value="tache">Tâche</option>
                                </select>
                            </div>
                            <div class="col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <input type="date" name="date_activite" value="{{ date('Y-m-d') }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                             <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Durée (min)</label>
                                <input type="number" name="duree" placeholder="15" step="5" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description / Contenu</label>
                            <textarea name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Détails..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pièce Jointe (Optionnel)</label>
                            <input type="file" name="piece_jointe" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Recent Activity Feed (Limit 5) -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Interactions Récentes</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @forelse($opportunity->activities->sortByDesc('date_activite')->take(5) as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last) <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span> @endif
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                                {{ $activity->type == 'appel' ? 'bg-blue-100 text-blue-600' : 
                                                   ($activity->type == 'email' ? 'bg-gray-100 text-gray-600' : 
                                                   ($activity->type == 'note' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600')) }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    @if($activity->type == 'appel') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    @elseif($activity->type == 'email') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    @elseif($activity->type == 'note') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    @endif
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    <span class="font-medium text-gray-900 capitalize">{{ $activity->type }}</span>: {{ $activity->description }}
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $activity->date_activite }}">{{ $activity->date_activite->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="py-4 text-center text-sm text-gray-500 italic">Aucune activité récente.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- TAB: TIMELINE COMPLETE (Historique) -->
            <div x-show="activeTab === 'timeline'" style="display: none;">
                 @include('activities.timeline', [
                    'activities' => $opportunity->activities,
                    'parent_type' => 'opportunity',
                    'parent_id' => $opportunity->id
                ])
            </div>

            <!-- TAB: NOTES & FICHIERS -->
            <div x-show="activeTab === 'notes'" style="display: none;">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Notes & Fichiers</h3>
                    <div class="space-y-4">
                        @forelse($opportunity->activities->where('type', 'note') as $note)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm text-yellow-700">
                                            <p>{{ $note->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if($note->piece_jointe)
                                <a href="{{ asset('storage/' . $note->piece_jointe) }}" target="_blank" class="text-xs text-yellow-600 hover:text-yellow-900 underline">Fichier joint</a>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 italic text-center py-4">Aucune note pour le moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- TAB: STAGE HISTORY -->
            <div x-show="activeTab === 'history'" style="display: none;">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Historique des Changements de Stade</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @forelse($opportunity->stage_history as $change)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last) <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span> @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    Passage de <span class="font-semibold text-gray-900 capitalize">{{ $change->old_stage }}</span> 
                                                    à <span class="font-semibold text-indigo-600 capitalize">{{ $change->new_stage }}</span>
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Par {{ $change->user->name ?? 'Système' }}
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $change->changed_at }}">{{ $change->changed_at->format('d/m/Y H:i') }}</time>
                                                <p class="text-xs text-gray-400">{{ $change->changed_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="py-4 text-center text-sm text-gray-500 italic">Aucun changement de stade enregistré.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>

            <!-- Modal for Attribution History -->
            <div x-show="showHistory" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showHistory = false"></div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full p-6 relative">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Historique d'attribution</h3>
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @forelse($opportunity->attributionHistory->sortByDesc('created_at') as $history)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last) <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span> @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center ring-8 ring-white">
                                                    <span class="text-xs font-bold text-indigo-600">{{ substr($history->assignedTo->name, 0, 1) }}</span>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Assigné à <span class="font-medium text-gray-900">{{ $history->assignedTo->name }}</span>
                                                        <span class="text-xs text-gray-400 block">
                                                            Par {{ $history->assignedBy ? $history->assignedBy->name : 'Système (Auto)' }} 
                                                            ({{ $history->mode }})
                                                        </span>
                                                    </p>
                                                    @if($history->reason)
                                                        <p class="text-xs text-gray-400 mt-1 italic">"{{ $history->reason }}"</p>
                                                    @endif
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $history->created_at }}">{{ $history->created_at->format('d/m/Y') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="py-4 text-center text-sm text-gray-500 italic">Aucun historique disponible.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="mt-5 sm:mt-6">
                            <button type="button" @click="showHistory = false" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:text-sm">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>



</div>
<!-- Scripts (déjà inclus via layout mais nécessaire pour Alpine si pas global) -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection

@push('scripts')
<script>
    function opportunityData(initialStage, updateUrl, csrfToken) {
        return {
            activeTab: 'overview',
            showActivityForm: false,
            showHistory: false,
            currentStage: initialStage,
            showQualifyModal: false,
            showConfirmModal: false,
            targetStage: null,
            showErrorToast: false,
            errorMessage: '',
            isLoading: false,

            stageGuides: {
                prospection: {
                    label: 'Prospection',
                    description: 'Le contact vient d’être créé dans le CRM, mais aucun échange concret n’a encore eu lieu.',
                    contactStatus: 'Nouveau contact',
                    objective: 'Entrer en relation',
                    actions: ['Appel de prise de contact', 'Email de présentation', 'Message WhatsApp / LinkedIn', 'Ajout de notes'],
                    buttons: ['Appeler', 'Envoyer email', 'Ajouter une note', 'Passer en Qualification']
                },
                qualification: {
                    label: 'Qualification',
                    description: 'Le contact a répondu ou montré de l’intérêt. Vous vérifiez s’il peut devenir un client réel.',
                    contactStatus: 'Contact qualifié',
                    objective: 'Vérifier le potentiel',
                    actions: ['Rendez-vous de découverte', 'Mise à jour budget/besoin', 'Scoring du contact'],
                    buttons: ['Planifier RDV', 'Modifier fiche', 'Qualifier le contact', 'Passer en Proposition']
                },
                proposition: {
                    label: 'Proposition',
                    description: 'Le contact a un besoin clair. Une offre commerciale est liée à sa fiche.',
                    contactStatus: 'Contact avec proposition',
                    objective: 'Convaincre',
                    actions: ['Création d’un devis', 'Envoi d’une proposition personnalisée', 'Ajout de documents'],
                    buttons: ['Créer un devis', 'Envoyer proposition', 'Ajouter document', 'Passer en Négociation']
                },
                negociation: {
                    label: 'Négociation',
                    description: 'Le contact est intéressé mais discute les conditions.',
                    contactStatus: 'En négociation',
                    objective: 'Finaliser l’accord',
                    actions: ['Ajustement du prix', 'Traitement des objections', 'Relances commerciales'],
                    buttons: ['Modifier devis', 'Ajouter échange', 'Programmer relance', 'Marquer Gagné/Perdu']
                },
                gagne: {
                    label: 'Gagné',
                    description: 'Le contact devient client actif.',
                    contactStatus: 'Client',
                    objective: 'Exécution & fidélisation',
                    actions: ['Conversion en client', 'Création projet/commande', 'Facturation'],
                    buttons: ['Convertir en client', 'Créer projet', 'Créer facture', 'Voir CA']
                },
                perdu: {
                    label: 'Perdu',
                    description: 'Le contact n’a pas abouti à une vente.',
                    contactStatus: 'Opportunité perdue',
                    objective: 'Analyse & relance future',
                    actions: ['Sélection motif perte', 'Archivage', 'Planification relance'],
                    buttons: ['Marquer perdu', 'Ajouter motif', 'Relancer plus tard', 'Archiver']
                }
            },

            async changeStage(newStage) {
                // Prevent multi-clicks if loading
                if (this.isLoading) return;

                // Allow re-clicking 'qualification' to edit fields, otherwise block same-stage clicks
                if (newStage === this.currentStage && newStage !== 'qualification') return;

                // Specific Transition Logic: Always open modal for Qualification stage
                if (newStage === 'qualification') {
                     this.showQualifyModal = true;
                     return;
                }

                // Restore Confirmation Modal logic 
                this.targetStage = newStage;
                this.showConfirmModal = true;
            },

            async executeStageChange() {
                const newStage = this.targetStage;
                this.showConfirmModal = false;
                this.isLoading = true; // Show loading state

                try {
                    const response = await fetch(updateUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ stade: newStage })
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.reload(); 
                    } else {
                        this.isLoading = false;
                        this.errorMessage = data.message || 'Impossible de mettre à jour le statut.';
                        this.showErrorToast = true;
                        let self = this;
                        setTimeout(function() { self.showErrorToast = false; }, 4000);
                    }
                } catch (error) {
                    this.isLoading = false;
                    console.error('Error:', error);
                    this.errorMessage = 'Une erreur système est survenue.';
                    this.showErrorToast = true;
                    let self = this;
                    setTimeout(function() { self.showErrorToast = false; }, 4000);
                }
            }
        };
    }
</script>
@endpush
