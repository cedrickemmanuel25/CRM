@extends('layouts.app')

@section('title', $contact->prenom . ' ' . $contact->nom)

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

<div class="min-h-screen flex flex-col bg-[#0f172a] text-slate-100" 
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
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        
        <!-- Header Section -->
        <div class="mb-10">
            <!-- Breadcrumbs -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                    <li class="hover:text-slate-300 transition-colors">
                        <a href="{{ route('contacts.index') }}" class="flex items-center">
                            <svg class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Contacts
                        </a>
                    </li>
                    <li><svg class="h-3 w-3 text-slate-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-blue-500 font-bold">{{ $contact->prenom }} {{ $contact->nom }}</li>
                </ol>
            </nav>

            <!-- Title & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div class="flex flex-col xs:flex-row items-center xs:items-start gap-4 sm:gap-6 text-center xs:text-left">
                    <!-- Avatar Circle -->
                    <div class="relative flex-shrink-0">
                        <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-2xl border border-white/10 shadow-xl overflow-hidden bg-slate-800 ring-4 ring-white/5 mx-auto xs:mx-0">
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
                        <div class="absolute -bottom-2 -right-2 h-7 w-7 sm:h-8 sm:w-8 bg-slate-900 rounded-lg flex items-center justify-center shadow-lg border border-white/10">
                            <span class="text-sm sm:text-base">{{ $statusIcon }}</span>
                        </div>
                    </div>
                    
                    <div class="min-w-0">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-100 tracking-tight truncate">{{ $contact->prenom }} {{ $contact->nom }}</h1>
                        <p class="text-[11px] sm:text-sm text-slate-500 mt-1 font-medium uppercase tracking-wider truncate">{{ $contact->poste ?? 'Poste non renseigné' }} • {{ $contact->entreprise ?? 'Indépendant' }}</p>
                        
                        @if($contact->tags)
                            <div class="flex items-center justify-center xs:justify-start gap-2 flex-wrap mt-2">
                                @foreach($contact->tags as $tag)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/20">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-center justify-center sm:justify-end gap-2 sm:gap-3 flex-wrap sm:flex-nowrap mt-4 sm:mt-0">
                    @if(auth()->user()->isAdmin() || auth()->user()->isCommercial())
                    <form action="{{ route('contacts.convert', $contact) }}" method="POST" class="contents">
                        @csrf
                        <button type="submit" class="flex-shrink-0 inline-flex items-center px-4 sm:px-5 py-2 sm:py-2.5 bg-emerald-600 text-white text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/20">
                            <svg class="h-4 w-4 mr-1.5 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Convertir
                        </button>
                    </form>
                    @endif

                    @if($canEdit)
                    <a href="{{ route('contacts.edit', $contact) }}" class="flex-shrink-0 btn-action inline-flex items-center px-4 sm:px-5 py-2 sm:py-2.5 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-lg">
                        <svg class="h-4 w-4 mr-1.5 sm:mr-2 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Modifier
                    </a>
                    @endif

                    @if($canEdit)
                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="contents" onsubmit="return confirm('Supprimer définitivement ce contact ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex-shrink-0 p-2 sm:p-2.5 text-rose-400 bg-rose-500/5 hover:bg-rose-500/10 rounded-lg transition-colors border border-rose-500/10 hover:border-rose-500/20">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                <div class="saas-card overflow-hidden">
                    <!-- Status Header -->
                    <div class="bg-white/5 px-5 py-4 border-b border-white/5">
                        <div class="flex items-center justify-between">
                            <span class="label-caps">Statut</span>
                            @php
                                $stage = \App\Models\Contact::getStages()[$contact->statut] ?? null;
                                $color = $stage['color'] ?? 'slate';
                                $statusClasses = match($color) {
                                    'slate' => 'bg-slate-800 text-slate-400 border-white/10',
                                    'amber' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    'indigo' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                    'blue' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                    'emerald' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'rose' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    default => 'bg-slate-800 text-slate-400 border-white/10'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold border uppercase tracking-wider {{ $statusClasses }}">
                                {{ $stage['label'] ?? ucfirst($contact->statut) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Contact Details -->
                    <div class="p-5 sm:p-6 space-y-5 sm:space-y-6">
                        <!-- Email -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="flex-shrink-0 h-9 w-9 sm:h-10 sm:w-10 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                                <svg class="h-4.5 w-4.5 sm:h-5 sm:w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="label-caps mb-0.5 sm:mb-1 opacity-50">Email principal</p>
                                <a href="mailto:{{ $contact->email }}" class="block text-xs sm:text-sm font-semibold text-slate-200 hover:text-blue-400 transition-colors truncate">{{ $contact->email }}</a>
                                @if($contact->alternative_emails)
                                    @foreach($contact->alternative_emails as $email)
                                        <a href="mailto:{{ $email }}" class="block text-[10px] sm:text-xs text-slate-500 hover:text-blue-400 transition-colors mt-0.5 sm:mt-1 truncate">{{ $email }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="flex-shrink-0 h-9 w-9 sm:h-10 sm:w-10 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                                <svg class="h-4.5 w-4.5 sm:h-5 sm:w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="label-caps mb-0.5 sm:mb-1 opacity-50">Téléphone</p>
                                <a href="tel:{{ $contact->telephone }}" class="block text-xs sm:text-sm font-semibold text-slate-200 hover:text-blue-400 transition-colors">{{ format_phone($contact->telephone) }}</a>
                                @if($contact->alternative_telephones)
                                    @foreach($contact->alternative_telephones as $phone)
                                        <a href="tel:{{ $phone }}" class="block text-[10px] sm:text-xs text-slate-500 hover:text-blue-400 transition-colors mt-0.5 sm:mt-1">{{ format_phone($phone) }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="flex-shrink-0 h-9 w-9 sm:h-10 sm:w-10 rounded-lg bg-slate-500/10 flex items-center justify-center border border-white/5">
                                <svg class="h-4.5 w-4.5 sm:h-5 sm:w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="label-caps mb-0.5 sm:mb-1 opacity-50">Adresse</p>
                                <p class="text-xs sm:text-sm text-slate-200 font-medium">{{ $contact->adresse ?? 'Non renseignée' }}</p>
                            </div>
                        </div>

                        <!-- Source -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="flex-shrink-0 h-9 w-9 sm:h-10 sm:w-10 rounded-lg bg-slate-500/10 flex items-center justify-center border border-white/5">
                                <svg class="h-4.5 w-4.5 sm:h-5 sm:w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="label-caps mb-0.5 sm:mb-1 opacity-50">Source</p>
                                <span class="inline-flex items-center px-2 py-0.5 sm:py-1 rounded text-[9px] sm:text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-400 border border-white/5">
                                    {{ $contact->source ?? 'Direct' }}
                                </span>
                            </div>
                        </div>

                        <!-- Owner -->
                        <div class="pt-5 sm:pt-6 border-t border-white/5">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-[10px] sm:text-xs font-bold text-blue-400 uppercase">
                                    {{ strtoupper(substr($contact->owner?->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="label-caps mb-0.5 opacity-50">Responsable</p>
                                    <p class="text-xs sm:text-sm font-bold text-slate-200">{{ $contact->owner?->name ?? 'Système' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Internal Notes -->
                <div class="bg-amber-500/5 rounded-xl border border-amber-500/20 p-5 sm:p-6 text-center sm:text-left">
                    <div class="flex items-center justify-center sm:justify-start gap-2 mb-3 sm:mb-4">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <h3 class="label-caps text-amber-500">Note interne</h3>
                    </div>
                    <p class="text-[12px] sm:text-sm text-amber-200 leading-relaxed italic opacity-80">"{{ $contact->notes_internes }}"</p>
                </div>
                
                <!-- Pipeline Value -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-5 sm:p-6 text-white border border-blue-400/20 text-center sm:text-left">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest opacity-70">Valeur Pipeline</span>
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    @php
                        $potentialValue = $contact->opportunities->whereNotIn('stade', ['gagne', 'perdu'])->sum('montant_estime');
                    @endphp
                    <p class="text-2xl sm:text-3xl font-bold mb-1 tracking-tight">{{ format_currency($potentialValue) }}</p>
                    <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider opacity-60">{{ $contact->opportunities->whereNotIn('stade', ['gagne', 'perdu'])->count() }} affaire(s) en cours</p>
                </div>
            </div>
            
            <!-- MAIN CONTENT: Tabs -->
            <div class="lg:col-span-2 space-y-6">
                

                <!-- Tabs Navigation -->
                <div class="saas-card p-1 overflow-x-auto no-scrollbar">
                    <nav class="flex space-x-1 min-w-max sm:min-w-0" aria-label="Tabs">
                        <button @click="activeTab = 'overview'" 
                            :class="activeTab === 'overview' ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5'"
                            class="flex-1 px-3 sm:px-4 py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest rounded-xl transition-all whitespace-nowrap">
                            Vue d'ensemble
                        </button>
                        @if(auth()->user()->isAdmin() || auth()->user()->isCommercial())
                        <button @click="activeTab = 'opportunites'" 
                            :class="activeTab === 'opportunites' ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5'"
                            class="flex-1 px-3 sm:px-4 py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest rounded-xl transition-all whitespace-nowrap">
                            Pipeline <span class="ml-1 opacity-60">({{ $contact->opportunities->count() }})</span>
                        </button>
                        @endif
                        <button @click="activeTab = 'activities'" 
                            :class="activeTab === 'activities' ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5'"
                            class="flex-1 px-3 sm:px-4 py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest rounded-xl transition-all whitespace-nowrap">
                            Journal
                        </button>
                        <button @click="activeTab = 'tasks'" 
                            :class="activeTab === 'tasks' ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5'"
                            class="flex-1 px-3 sm:px-4 py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest rounded-xl transition-all whitespace-nowrap">
                            Rappels
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div>
                    
                    <!-- TAB: OVERVIEW -->
                    <div x-show="activeTab === 'overview'" x-transition class="space-y-6">
                        
                        <!-- Quick Activity Button -->
                        <button @click="showActivityForm = !showActivityForm" class="w-full saas-card border-dashed border-2 p-5 sm:p-8 hover:border-blue-500/50 hover:bg-blue-500/5 transition-all group">
                            <div class="flex flex-col xs:flex-row items-center justify-center gap-3 sm:gap-4">
                                <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-900/40 group-hover:scale-110 transition-transform">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="text-sm sm:text-base font-bold text-slate-100 group-hover:text-blue-400 transition-colors uppercase tracking-widest text-center">Consigner activité</span>
                            </div>
                        </button>

                        <!-- Activity Form -->
                        <div x-show="showActivityForm" class="saas-card p-5 sm:p-8" x-transition>
                            @include('contacts.partials._activity_form', ['contact' => $contact])
                        </div>

                        <!-- Highlights Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Recent Notes -->
                            <div class="saas-card overflow-hidden">
                                <div class="bg-white/5 px-6 py-4 border-b border-white/5 flex items-center justify-between">
                                    <h3 class="label-caps">Dernières notes</h3>
                                    @php $noteCount = $allActivities->where('type', 'note')->count() @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-600 text-white shadow-sm">{{ $noteCount }}</span>
                                </div>
                                <div class="p-5 sm:p-6 space-y-5 sm:space-y-6">
                                    @forelse($allActivities->where('type', 'note')->take(3) as $note)
                                        <div class="relative pl-5 sm:pl-6 border-l-2 border-blue-500/30">
                                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic opacity-80">"{{ $note->description }}"</p>
                                            <p class="mt-2 text-[9px] sm:text-[10px] text-slate-500 font-bold uppercase tracking-wider">
                                                {{ $note->user?->name ?? 'Système' }} • {{ $note->date_activite->diffForHumans() }}
                                            </p>
                                        </div>
                                    @empty
                                        <div class="text-center py-6 sm:py-10">
                                            <p class="text-xs sm:text-sm text-slate-500 italic">Aucune note pour le moment</p>
                                        </div>
                                    @endforelse
                                    <button @click="activeTab = 'activities'" class="w-full mt-2 sm:mt-4 py-2 sm:py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-blue-400 hover:bg-white/5 rounded-xl transition-all">
                                        Voir tout le journal →
                                    </button>
                                </div>
                            </div>

                            <!-- Upcoming Tasks -->
                            <div class="saas-card overflow-hidden">
                                <div class="bg-white/5 px-6 py-4 border-b border-white/5 flex items-center justify-between">
                                    <h3 class="label-caps">Rappels à venir</h3>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-600 text-white shadow-sm">{{ $tasks->where('statut', '!=', 'done')->count() }}</span>
                                </div>
                                <div class="p-5 sm:p-6 space-y-3 sm:space-y-4">
                                    @forelse($tasks->where('statut', '!=', 'done')->sortBy('due_date')->take(3) as $task)
                                        <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-all cursor-pointer group" @click="activeTab = 'tasks'">
                                            <div class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full shadow-sm {{ $task->priority == 'high' ? 'bg-rose-500 shadow-rose-900/50' : ($task->priority == 'medium' ? 'bg-amber-500 shadow-amber-900/50' : 'bg-slate-400 shadow-slate-900/50') }}"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs sm:text-sm font-bold text-slate-200 truncate group-hover:text-blue-400 transition-colors">{{ $task->titre }}</p>
                                                <p class="text-[9px] sm:text-[10px] text-slate-500 mt-0.5 sm:mt-1 font-bold uppercase tracking-widest">{{ $task->due_date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-6 sm:py-10">
                                            <p class="text-xs sm:text-sm text-slate-500 italic">Aucun rappel en attente</p>
                                        </div>
                                    @endforelse
                                    <button @click="activeTab = 'tasks'" class="w-full mt-2 sm:mt-4 py-2 sm:py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-blue-400 hover:bg-white/5 rounded-xl transition-all">
                                        + Créer un rappel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: OPPORTUNITIES -->
                    <div x-show="activeTab === 'opportunites'" x-transition class="space-y-6">
                        <div class="flex justify-between items-center px-2">
                            <h3 class="text-xl font-bold text-slate-100 tracking-tight">Portefeuille d'affaires</h3>
                            @if(auth()->user()->isAdmin() || auth()->user()->isCommercial())
                            <button @click="showOppForm = !showOppForm" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Nouvelle affaire
                            </button>
                            @endif
                        </div>

                        <!-- Opp Form -->
                        <div x-show="showOppForm" class="saas-card p-5 sm:p-8" x-transition style="display: none;">
                            <div class="flex justify-between items-center mb-6 sm:mb-8">
                                <h3 class="text-lg sm:text-xl font-bold text-slate-100 uppercase tracking-widest">Nouvelle opportunité</h3>
                                <button @click="showOppForm = false" class="text-slate-500 hover:text-slate-300 transition-colors">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </div>
                            @include('contacts.partials._opportunity_form')
                        </div>

                        <!-- Opportunities Table -->
                        <div class="saas-card overflow-hidden">
                            <div class="overflow-x-auto saas-scroll">
                                <table class="min-w-full divide-y divide-white/5">
                                    <thead class="bg-white/5">
                                        <tr>
                                            <th class="px-6 py-4 text-left label-caps">Opportunité</th>
                                            <th class="px-6 py-4 text-left label-caps">Montant</th>
                                            <th class="px-6 py-4 text-left label-caps">Stade</th>
                                            <th class="px-6 py-4 text-left label-caps">Commercial</th>
                                            <th class="px-6 py-4 text-right label-caps">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @forelse($contact->opportunities as $opp)
                                        <tr class="hover:bg-white/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <a href="{{ route('opportunities.show', $opp) }}" class="text-sm font-bold text-slate-100 hover:text-blue-400 transition-colors block">{{ $opp->titre }}</a>
                                                <div class="flex items-center gap-3 mt-2">
                                                    <div class="w-24 h-1.5 bg-white/5 rounded-full overflow-hidden border border-white/5">
                                                        <div class="h-full bg-blue-500 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.5)]" style="width: {{ $opp->probabilite }}%"></div>
                                                    </div>
                                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $opp->probabilite }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <span class="text-sm font-black text-slate-100 tracking-tight">{{ format_currency($opp->montant_estime) }}</span>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @php
                                                    $stageClasses = match($opp->stade) {
                                                        'gagne' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                        'perdu' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                                        default => 'bg-blue-500/10 text-blue-400 border-blue-500/20'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider border {{ $stageClasses }}">
                                                    {{ ucfirst($opp->stade) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-8 w-8 rounded-lg bg-slate-800 border border-white/10 flex items-center justify-center text-[10px] font-black text-slate-400 uppercase tracking-tighter shadow-sm">
                                                        {{ strtoupper(substr($opp->commercial?->name ?? '?', 0, 1)) }}
                                                    </div>
                                                    <span class="text-xs font-bold text-slate-400">{{ $opp->commercial?->name ?? 'Non assigné' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-right whitespace-nowrap">
                                                <div class="flex justify-end gap-2 text-slate-500">
                                                    <a href="{{ route('opportunities.edit', $opp) }}" class="p-2 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg transition-all" title="Modifier">
                                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    </a>
                                                    <form action="{{ route('opportunities.destroy', $opp) }}" method="POST" onsubmit="return confirm('Supprimer cette opportunité ?');" class="contents">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="p-2 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all" title="Supprimer">
                                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center gap-3">
                                                    <svg class="h-10 w-10 text-slate-700 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    <p class="text-sm text-slate-500 font-bold uppercase tracking-widest italic opacity-50">Aucune opportunité rattachée</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: ACTIVITIES -->
                    <div x-show="activeTab === 'activities'" x-transition>
                        <div class="saas-card p-8">
                            <div class="flex justify-between items-center mb-8 px-2">
                                <h3 class="text-xl font-bold text-slate-100 tracking-tight">Timeline chronologique</h3>
                                <button @click="showActivityForm = !showActivityForm" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    Nouvelle activité
                                </button>
                            </div>

                            <!-- Activity Form -->
                            <div x-show="showActivityForm" class="mb-10 bg-white/5 rounded-2xl p-8 border border-white/5 shadow-inner" x-transition>
                                <div class="flex justify-between items-center mb-8">
                                    <h3 class="text-xl font-bold text-slate-100 uppercase tracking-widest">Consigner une activité</h3>
                                    <button @click="showActivityForm = false" class="text-slate-500 hover:text-slate-300 transition-colors">
                                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                    </button>
                                </div>
                                @include('contacts.partials._activity_form', ['contact' => $contact])
                            </div>

                            <div class="flow-root px-2">
                                <ul class="-mb-10">
                                    @foreach($allActivities as $activity)
                                    <li>
                                        <div class="relative pb-10">
                                            @if(!$loop->last) <span class="absolute top-5 left-6 -ml-px h-full w-0.5 bg-white/5" aria-hidden="true"></span> @endif
                                            <div class="relative flex items-start space-x-6">
                                                <div class="relative">
                                                    @php
                                                        $typeConfig = match($activity->type) {
                                                            'appel' => ['bg' => 'bg-blue-600', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                                                            'email' => ['bg' => 'bg-blue-500', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                                                            'reunion' => ['bg' => 'bg-emerald-500', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                                                            'note' => ['bg' => 'bg-amber-500', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                                                            'ticket' => ['bg' => 'bg-rose-500', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                                                            default => ['bg' => 'bg-slate-500', 'icon' => 'M12 4v16m8-8H4']
                                                        };
                                                    @endphp
                                                    <span class="flex items-center justify-center h-12 w-12 rounded-xl {{ $typeConfig['bg'] }} text-white shadow-lg shadow-black/20">
                                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $typeConfig['icon'] }}"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="bg-white/5 rounded-2xl p-6 border border-white/5 shadow-sm hover:border-white/10 transition-all">
                                                        <div class="flex items-start justify-between mb-4">
                                                            <div class="flex items-center gap-3">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest bg-blue-600/10 border border-blue-500/20 text-blue-400">{{ $activity->type }}</span>
                                                                <h4 class="text-base font-bold text-slate-100 tracking-tight">{{ $activity->description }}</h4>
                                                            </div>
                                                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $activity->date_activite->format('d/m/Y H:i') }}</span>
                                                        </div>
                                                        
                                                        @if($activity->contenu)
                                                            <div class="text-sm text-slate-400 leading-relaxed bg-black/20 p-4 rounded-xl border border-white/5 mb-4 italic">
                                                                {{ $activity->contenu }}
                                                            </div>
                                                        @endif
 
                                                        <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                                            <div class="flex items-center gap-5">
                                                                <span class="flex items-center gap-2">
                                                                    <div class="h-4 w-4 rounded-full bg-slate-800 flex items-center justify-center text-[8px] border border-white/5">
                                                                        {{ strtoupper(substr($activity->user?->name ?? 'S', 0, 1)) }}
                                                                    </div>
                                                                    {{ $activity->user?->name ?? 'Système' }}
                                                                </span>
                                                                @if($activity->duree)
                                                                    <span class="flex items-center text-blue-400/70">
                                                                        <svg class="h-3 w-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                                                        {{ $activity->duree }} min
                                                                    </span>
                                                                @endif
                                                            </div>
 
                                                            @if($activity->piece_jointe)
                                                            <a href="{{ asset('storage/' . $activity->piece_jointe) }}" target="_blank" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors">
                                                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
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
                        <div class="flex justify-between items-center px-2">
                            <h3 class="text-xl font-bold text-slate-100 tracking-tight">Gestion des rappels</h3>
                            <button @click="showTaskForm = !showTaskForm" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Nouveau rappel
                            </button>
                        </div>

                        <!-- Task Form -->
                        <div x-show="showTaskForm" class="saas-card p-5 sm:p-8" x-transition style="display: none;">
                            <div class="flex justify-between items-center mb-6 sm:mb-8">
                                <h3 class="text-lg sm:text-xl font-bold text-slate-100 uppercase tracking-widest">Nouveau rappel</h3>
                                <button @click="showTaskForm = false" class="text-slate-500 hover:text-slate-300 transition-colors">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </div>
                            @include('contacts.partials._task_form')
                        </div>

                        <!-- Tasks Table -->
                        <div class="saas-card overflow-hidden">
                            <div class="overflow-x-auto saas-scroll">
                                <table class="min-w-full divide-y divide-white/5">
                                    <thead class="bg-white/5">
                                        <tr>
                                            <th class="px-6 py-4 text-left label-caps">Sujet</th>
                                            <th class="px-6 py-4 text-left label-caps">Échéance</th>
                                            <th class="px-6 py-4 text-left label-caps">Priorité</th>
                                            <th class="px-6 py-4 text-left label-caps">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @forelse($tasks as $task)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-5">
                                                <div class="text-sm font-bold text-slate-100">{{ $task->titre }}</div>
                                                <div class="flex items-center mt-2">
                                                    <div class="h-6 w-6 rounded-lg bg-slate-800 border border-white/5 flex items-center justify-center text-[8px] font-black text-slate-500 uppercase tracking-tighter shadow-sm mr-2.5">
                                                        {{ strtoupper(substr($task->assignee?->name ?? '?', 0, 1)) }}
                                                    </div>
                                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest tracking-tighter">{{ $task->assignee?->name ?? 'Non assigné' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <span class="text-sm font-bold text-slate-300 {{ $task->due_date->isPast() ? 'text-rose-400' : '' }}">{{ $task->due_date->format('d M Y') }}</span>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @php
                                                    $priorityClasses = match($task->priority) {
                                                        'high' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                                        'medium' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                                        default => 'bg-slate-500/10 text-slate-400 border-white/10'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider border {{ $priorityClasses }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider border {{ $task->statut === 'done' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-blue-500/10 text-blue-400 border-blue-500/20' }}">
                                                    {{ $task->statut === 'done' ? 'Terminé' : 'En attente' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center gap-3">
                                                    <svg class="h-10 w-10 text-slate-700 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    <p class="text-sm text-slate-500 font-bold uppercase tracking-widest italic opacity-50">Aucun rappel en attente</p>
                                                </div>
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
    </div>

    <!-- Quick Action Modal -->
    @include('contacts.partials._action_modal')
</div>
@endsection