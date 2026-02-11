@extends('layouts.app')

@section('title', $contact->prenom . ' ' . $contact->nom)

@section('content')
<div class="h-full flex flex-col bg-slate-50" 
     x-data="{ 
        activeTab: 'overview', 
        showActivityForm: false, 
        showTaskForm: false, 
        showOppForm: false,
        showQuickModal: false,
        quickModalTitle: '',
        quickModalBody: '',
        quickModalIcon: '',
        quickModalColor: '',
        quickModalAction: null,
        openQuickModal(title, body, icon, color, action) {
            this.quickModalTitle = title;
            this.quickModalBody = body;
            this.quickModalIcon = icon;
            this.quickModalColor = color;
            this.quickModalAction = action;
            this.showQuickModal = true;
        },
        executeQuickAction() {
            if (this.quickModalAction) {
                this.quickModalAction();
            }
            this.showQuickModal = false;
        }
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-6">
            <!-- Breadcrumbs -->
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                    <li class="hover:text-indigo-600 transition-colors">
                        <a href="{{ route('contacts.index') }}" class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Contacts
                        </a>
                    </li>
                    <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-slate-700 font-semibold">{{ $contact->prenom }} {{ $contact->nom }}</li>
                </ol>
            </nav>

            <!-- Title & Actions -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <!-- Avatar Circle -->
                    <div class="relative">
                        <div class="h-16 w-16 rounded-full border-2 border-white shadow-lg overflow-hidden bg-slate-100 ring-1 ring-slate-200">
                            <img src="{{ $contact->avatar_url }}" alt="{{ $contact->nom_complet }}" class="h-full w-full object-cover">
                        </div>
                        @php
                            $statusIcon = match($contact->statut) {
                                'nouveau' => '🔥',
                                'qualifie' => '💎',
                                'proposition' => '📄',
                                'negociation' => '🤝',
                                'client' => '👑',
                                'perdu' => '📉',
                                default => '⚙️'
                            };
                        @endphp
                        <div class="absolute -bottom-1 -right-1 h-7 w-7 bg-white rounded-full flex items-center justify-center shadow-md border-2 border-white">
                            <span class="text-sm">{{ $statusIcon }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $contact->prenom }} {{ $contact->nom }}</h1>
                        <p class="text-sm text-slate-600 mt-0.5">{{ $contact->poste ?? 'Poste non renseigné' }} • {{ $contact->entreprise ?? 'Indépendant' }}</p>
                    </div>

                    @if($contact->tags)
                        <div class="flex items-center gap-2 flex-wrap">
                            @foreach($contact->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    @if(auth()->user()->isAdmin() || auth()->user()->isCommercial())
                    <form action="{{ route('contacts.convert', $contact) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Convertir
                        </button>
                    </form>
                    @endif

                    @if($canEdit)
                    <a href="{{ route('contacts.edit', $contact) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Modifier
                    </a>
                    @endif
                    
                    @if($canEdit)
                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer définitivement ce contact ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- LEFT SIDEBAR: Contact Info -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Main Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <!-- Status Header -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 px-5 py-4 border-b border-slate-200">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600 uppercase tracking-wide">Statut</span>
                            @php
                                $stage = \App\Models\Contact::getStages()[$contact->statut] ?? null;
                                $color = $stage['color'] ?? 'slate';
                                $statusClasses = match($color) {
                                    'slate' => 'bg-slate-100 text-slate-700 border-slate-200',
                                    'amber' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'indigo' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                    'blue' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'emerald' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'rose' => 'bg-rose-100 text-rose-700 border-rose-200',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $statusClasses }}">
                                {{ $stage['label'] ?? ucfirst($contact->statut) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Contact Details -->
                    <div class="p-5 space-y-5">
                        <!-- Email -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 h-9 w-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-500 mb-1">Email principal</p>
                                <a href="mailto:{{ $contact->email }}" class="block text-sm font-medium text-slate-900 hover:text-indigo-600 transition-colors truncate">{{ $contact->email }}</a>
                                @if($contact->alternative_emails)
                                    @foreach($contact->alternative_emails as $email)
                                        <a href="mailto:{{ $email }}" class="block text-xs text-slate-600 hover:text-indigo-600 transition-colors mt-1 truncate">{{ $email }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 h-9 w-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-500 mb-1">Téléphone</p>
                                <a href="tel:{{ $contact->telephone }}" class="block text-sm font-medium text-slate-900 hover:text-indigo-600 transition-colors">{{ format_phone($contact->telephone) }}</a>
                                @if($contact->alternative_telephones)
                                    @foreach($contact->alternative_telephones as $phone)
                                        <a href="tel:{{ $phone }}" class="block text-xs text-slate-600 hover:text-indigo-600 transition-colors mt-1">{{ format_phone($phone) }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 h-9 w-9 rounded-lg bg-slate-50 flex items-center justify-center">
                                <svg class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-500 mb-1">Adresse</p>
                                <p class="text-sm text-slate-900">{{ $contact->adresse ?? 'Non renseignée' }}</p>
                            </div>
                        </div>

                        <!-- Source -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 h-9 w-9 rounded-lg bg-slate-50 flex items-center justify-center">
                                <svg class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-500 mb-1">Source</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $contact->source ?? 'Direct' }}
                                </span>
                            </div>
                        </div>

                        <!-- Owner -->
                        <div class="pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-xs font-semibold text-slate-700">
                                    {{ strtoupper(substr($contact->owner?->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-slate-500">Responsable</p>
                                    <p class="text-sm font-medium text-slate-900">{{ $contact->owner?->name ?? 'Système' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Internal Notes -->
                @if($contact->notes_internes)
                <div class="bg-amber-50 rounded-xl border border-amber-200 p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <h3 class="text-xs font-semibold text-amber-900 uppercase tracking-wide">Note interne</h3>
                    </div>
                    <p class="text-sm text-amber-900 leading-relaxed italic">"{{ $contact->notes_internes }}"</p>
                </div>
                @endif
                
                <!-- Pipeline Value -->
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold uppercase tracking-wide opacity-80">Valeur Pipeline</span>
                        <svg class="h-6 w-6 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    @php
                        $potentialValue = $contact->opportunities->whereNotIn('stade', ['gagne', 'perdu'])->sum('montant_estime');
                    @endphp
                    <p class="text-3xl font-bold mb-1">{{ format_currency($potentialValue) }}</p>
                    <p class="text-xs opacity-70">{{ $contact->opportunities->whereNotIn('stade', ['gagne', 'perdu'])->count() }} affaire(s) en cours</p>
                </div>
            </div>
            
            <!-- MAIN CONTENT: Tabs -->
            <div class="lg:col-span-2 space-y-6">
                

                <!-- Tabs Navigation -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-1">
                    <nav class="flex space-x-1" aria-label="Tabs">
                        <button @click="activeTab = 'overview'" 
                            :class="activeTab === 'overview' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                            class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition-all">
                            Vue d'ensemble
                        </button>
                        @if(auth()->user()->isAdmin() || auth()->user()->isCommercial())
                        <button @click="activeTab = 'opportunites'" 
                            :class="activeTab === 'opportunites' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                            class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition-all">
                            Pipeline <span class="ml-1 text-xs">({{ $contact->opportunities->count() }})</span>
                        </button>
                        @endif
                        <button @click="activeTab = 'activities'" 
                            :class="activeTab === 'activities' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                            class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition-all">
                            Journal
                        </button>
                        <button @click="activeTab = 'tasks'" 
                            :class="activeTab === 'tasks' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                            class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg transition-all">
                            Rappels
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div>
                    
                    <!-- TAB: OVERVIEW -->
                    <div x-show="activeTab === 'overview'" x-transition class="space-y-6">
                        
                        <!-- Quick Activity Button -->
                        <button @click="showActivityForm = !showActivityForm" class="w-full bg-white rounded-xl shadow-sm border-2 border-dashed border-slate-200 p-6 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                            <div class="flex items-center justify-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-900 group-hover:text-indigo-700 transition-colors">Consigner une nouvelle activité</span>
                            </div>
                        </button>

                        <!-- Activity Form -->
                        <div x-show="showActivityForm" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6" x-transition>
                            @include('contacts.partials._activity_form', ['contact' => $contact])
                        </div>

                        <!-- Highlights Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Recent Notes -->
                            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                                <div class="bg-slate-50 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-slate-900">Dernières notes</h3>
                                    @php $noteCount = $allActivities->where('type', 'note')->count() @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-100 text-indigo-700">{{ $noteCount }}</span>
                                </div>
                                <div class="p-5 space-y-4">
                                    @forelse($allActivities->where('type', 'note')->take(3) as $note)
                                        <div class="relative pl-4 border-l-2 border-indigo-200">
                                            <p class="text-sm text-slate-700 leading-relaxed">"{{ $note->description }}"</p>
                                            <p class="mt-1.5 text-xs text-slate-500">
                                                {{ $note->user?->name ?? 'Système' }} • {{ $note->date_activite->diffForHumans() }}
                                            </p>
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <p class="text-sm text-slate-400">Aucune note pour le moment</p>
                                        </div>
                                    @endforelse
                                    <button @click="activeTab = 'activities'" class="w-full mt-3 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        Voir tout le journal →
                                    </button>
                                </div>
                            </div>

                            <!-- Upcoming Tasks -->
                            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                                <div class="bg-slate-50 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-slate-900">Rappels à venir</h3>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-rose-100 text-rose-700">{{ $tasks->where('statut', '!=', 'done')->count() }}</span>
                                </div>
                                <div class="p-5 space-y-3">
                                    @forelse($tasks->where('statut', '!=', 'done')->sortBy('due_date')->take(3) as $task)
                                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer" @click="activeTab = 'tasks'">
                                            <div class="h-1.5 w-1.5 rounded-full {{ $task->priority == 'high' ? 'bg-rose-500' : ($task->priority == 'medium' ? 'bg-amber-500' : 'bg-slate-400') }}"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-slate-900 truncate">{{ $task->titre }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5">{{ $task->due_date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <p class="text-sm text-slate-400">Aucun rappel en attente</p>
                                        </div>
                                    @endforelse
                                    <button @click="activeTab = 'tasks'" class="w-full mt-3 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        + Créer un rappel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: OPPORTUNITIES -->
                    <div x-show="activeTab === 'opportunites'" x-transition class="space-y-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-slate-900">Portefeuille d'affaires</h3>
                            @if(auth()->user()->isAdmin() || auth()->user()->isCommercial())
                            <button @click="showOppForm = !showOppForm" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Nouvelle affaire
                            </button>
                            @endif
                        </div>

                        <!-- Opp Form -->
                        <div x-show="showOppForm" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6" x-transition style="display: none;">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-slate-900">Nouvelle opportunité</h3>
                                <button @click="showOppForm = false" class="text-slate-400 hover:text-slate-600">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </div>
                            @include('contacts.partials._opportunity_form')
                        </div>

                        <!-- Opportunities Table -->
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Opportunité</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Montant</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Stade</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Commercial</th>
                                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($contact->opportunities as $opp)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-5 py-4">
                                            <a href="{{ route('opportunities.show', $opp) }}" class="text-sm font-medium text-slate-900 hover:text-indigo-600 truncate block">{{ $opp->titre }}</a>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $opp->probabilite }}%"></div>
                                                </div>
                                                <span class="text-xs text-slate-500">{{ $opp->probabilite }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold text-slate-900">{{ format_currency($opp->montant_estime) }}</span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @php
                                                $stageClasses = match($opp->stade) {
                                                    'gagne' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                    'perdu' => 'bg-rose-100 text-rose-800 border-rose-200',
                                                    default => 'bg-indigo-100 text-indigo-800 border-indigo-200'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $stageClasses }}">
                                                {{ ucfirst($opp->stade) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="h-7 w-7 rounded-full bg-slate-200 flex items-center justify-center text-xs font-semibold text-slate-700">
                                                    {{ strtoupper(substr($opp->commercial?->name ?? '?', 0, 1)) }}
                                                </div>
                                                <span class="text-sm text-slate-900">{{ $opp->commercial?->name ?? 'Non assigné' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-right whitespace-nowrap">
                                            @if(auth()->user()->hasRole(['admin', 'commercial']) && (auth()->user()->isAdmin() || $opp->commercial_id == auth()->id()))
                                            <div class="flex justify-end gap-2 text-slate-400">
                                                <a href="{{ route('opportunities.edit', $opp) }}" class="hover:text-amber-600 transition-colors" title="Modifier">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                </a>
                                                <form action="{{ route('opportunities.destroy', $opp) }}" method="POST" onsubmit="return confirm('Supprimer cette opportunité ?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="hover:text-rose-600 transition-colors" title="Supprimer">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-12 text-center">
                                            <p class="text-sm text-slate-400">Aucune opportunité rattachée</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB: ACTIVITIES -->
                    <div x-show="activeTab === 'activities'" x-transition>
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-slate-900">Timeline chronologique</h3>
                                <button @click="showActivityForm = !showActivityForm" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Nouvelle activité
                                </button>
                            </div>

                            <!-- Activity Form -->
                            <div x-show="showActivityForm" class="mb-8 bg-slate-50 rounded-xl p-6 border border-slate-200 shadow-inner" x-transition>
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-lg font-semibold text-slate-900">Consigner une activité</h3>
                                    <button @click="showActivityForm = false" class="text-slate-400 hover:text-slate-600">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                    </button>
                                </div>
                                @include('contacts.partials._activity_form', ['contact' => $contact])
                            </div>

                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach($allActivities as $activity)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last) <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span> @endif
                                            <div class="relative flex items-start space-x-4">
                                                <div class="relative">
                                                    @php
                                                        $typeConfig = match($activity->type) {
                                                            'appel' => ['bg' => 'bg-blue-500', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                                                            'email' => ['bg' => 'bg-indigo-500', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                                                            'reunion' => ['bg' => 'bg-emerald-500', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                                                            'note' => ['bg' => 'bg-amber-500', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                                                            'ticket' => ['bg' => 'bg-rose-500', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                                                            default => ['bg' => 'bg-slate-500', 'icon' => 'M12 4v16m8-8H4']
                                                        };
                                                    @endphp
                                                    <span class="flex items-center justify-center h-10 w-10 rounded-lg {{ $typeConfig['bg'] }} text-white shadow-sm">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeConfig['icon'] }}"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                                        <div class="flex items-start justify-between mb-2">
                                                            <div class="flex items-center gap-2">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-white border border-slate-200 text-slate-700">{{ ucfirst($activity->type) }}</span>
                                                                <h4 class="text-sm font-semibold text-slate-900">{{ $activity->description }}</h4>
                                                            </div>
                                                            <span class="text-xs text-slate-500">{{ $activity->date_activite->format('d/m/Y H:i') }}</span>
                                                        </div>
                                                        
                                                        @if($activity->contenu)
                                                            <div class="text-sm text-slate-600 leading-relaxed bg-white p-3 rounded border border-slate-100 mb-3">
                                                                {{ $activity->contenu }}
                                                            </div>
                                                        @endif

                                                        <div class="flex items-center justify-between text-xs text-slate-500">
                                                            <div class="flex items-center gap-3">
                                                                <span>{{ $activity->user?->name ?? 'Système' }}</span>
                                                                @if($activity->duree)
                                                                    <span class="flex items-center">
                                                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                                                        {{ $activity->duree }} min
                                                                    </span>
                                                                @endif
                                                            </div>

                                                            @if($activity->piece_jointe)
                                                            <a href="{{ asset('storage/' . $activity->piece_jointe) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
                                                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                Fichier joint
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: TASKS -->
                    <div x-show="activeTab === 'tasks'" x-transition class="space-y-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-slate-900">Gestion des rappels</h3>
                            <button @click="showTaskForm = !showTaskForm" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Nouveau rappel
                            </button>
                        </div>

                        <!-- Task Form -->
                        <div x-show="showTaskForm" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6" x-transition style="display: none;">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-slate-900">Nouveau rappel</h3>
                                <button @click="showTaskForm = false" class="text-slate-400 hover:text-slate-600">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </div>
                            @include('contacts.partials._task_form')
                        </div>

                        <!-- Tasks Table -->
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Sujet</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Échéance</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Priorité</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($tasks as $task)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-slate-900">{{ $task->titre }}</div>
                                            <div class="flex items-center mt-1">
                                                <div class="h-5 w-5 rounded-full bg-slate-200 flex items-center justify-center text-xs font-semibold text-slate-700 mr-2">
                                                    {{ strtoupper(substr($task->assignee?->name ?? '?', 0, 1)) }}
                                                </div>
                                                <span class="text-xs text-slate-500">{{ $task->assignee?->name ?? 'Non assigné' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-slate-900">{{ $task->due_date->format('d/m/Y') }}</span>
                                            @if($task->due_date->isPast() && $task->statut != 'done')
                                                <span class="block text-xs text-rose-600 mt-0.5">En retard</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @php
                                                $prioClasses = match($task->priority) {
                                                    'high' => 'bg-rose-100 text-rose-700 border-rose-200',
                                                    'medium' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $prioClasses }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @php
                                                $taskStatusClasses = match($task->statut) {
                                                    'done' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                    'in_progress' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $taskStatusClasses }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->statut)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-12 text-center">
                                            <p class="text-sm text-slate-400">Aucun rappel enregistré</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Modal -->
    @include('contacts.partials._action_modal')
</div>
@endsection