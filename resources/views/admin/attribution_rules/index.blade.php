@extends('layouts.app')

@section('title', 'Règles d\'Attribution - Nexus Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-10">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-black text-white tracking-tight uppercase">Règles d'Attribution</h1>
            <p class="mt-2 text-slate-400 font-medium">Configurez comment les opportunités sont distribuées automatiquement aux commerciaux.</p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
             <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 uppercase tracking-widest shadow-lg shadow-indigo-900/20">
                Automation
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Formulaire Création -->
        <div class="lg:col-span-1">
            <div class="bg-indigo-900/10 backdrop-blur-xl border border-indigo-500/20 rounded-3xl overflow-hidden shadow-2xl sticky top-8">
                <div class="px-6 py-5 border-b border-indigo-500/20 bg-indigo-900/20">
                    <h3 class="text-lg font-black text-white uppercase tracking-tight">Nouvelle Règle</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.attribution-rules.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-indigo-300 mb-2 uppercase tracking-wide">Nom de la règle</label>
                            <input type="text" name="name" required class="block w-full rounded-xl border border-indigo-500/30 bg-indigo-900/40 text-white placeholder-indigo-300/50 focus:border-indigo-400 focus:ring-indigo-400 sm:text-sm py-3 px-4 shadow-inner transition-all hover:bg-indigo-900/60" placeholder="Ex: Attribution Web">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-indigo-300 mb-2 uppercase tracking-wide">Priorité (Plus haut = Premier)</label>
                            <input type="number" name="priority" value="10" class="block w-full rounded-xl border border-indigo-500/30 bg-indigo-900/40 text-white placeholder-indigo-300/50 focus:border-indigo-400 focus:ring-indigo-400 sm:text-sm py-3 px-4 shadow-inner transition-all hover:bg-indigo-900/60">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-indigo-300 mb-2 uppercase tracking-wide">Critère</label>
                            <select name="criteria_type" class="block w-full rounded-xl border border-indigo-500/30 bg-indigo-900/40 text-white focus:border-indigo-400 focus:ring-indigo-400 sm:text-sm py-3 px-4 shadow-inner transition-all hover:bg-indigo-900/60" x-data @change="$dispatch('criteria-change', $event.target.value)">
                                <option class="bg-slate-900" value="source">Source du Lead (ex: Web)</option>
                                <option class="bg-slate-900" value="amount_gt">Montant > X</option>
                                <option class="bg-slate-900" value="sector">Secteur (Entreprise contient)</option>
                                <option class="bg-slate-900" value="workload">Équilibrage de Charge (Défaut)</option>
                            </select>
                        </div>

                        <div x-data="{ show: true }" @criteria-change.window="show = $event.detail !== 'workload'">
                            <label class="block text-xs font-bold text-indigo-300 mb-2 uppercase tracking-wide" x-show="show">Valeur du Critère</label>
                            <input type="text" name="criteria_value" x-show="show" class="block w-full rounded-xl border border-indigo-500/30 bg-indigo-900/40 text-white placeholder-indigo-300/50 focus:border-indigo-400 focus:ring-indigo-400 sm:text-sm py-3 px-4 shadow-inner transition-all hover:bg-indigo-900/60" placeholder="Ex: Web, 50000...">
                        </div>

                        <div x-data="{ show: true }" @criteria-change.window="show = $event.detail !== 'workload'">
                            <label class="block text-xs font-bold text-indigo-300 mb-2 uppercase tracking-wide" x-show="show">Attribuer à</label>
                            <select name="target_user_id" x-show="show" class="block w-full rounded-xl border border-indigo-500/30 bg-indigo-900/40 text-white focus:border-indigo-400 focus:ring-indigo-400 sm:text-sm py-3 px-4 shadow-inner transition-all hover:bg-indigo-900/60">
                                <option class="bg-slate-900" value="">-- Choisir un Commercial --</option>
                                @foreach($users as $user)
                                <option class="bg-slate-900" value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <p x-show="!show" class="mt-2 text-xs text-indigo-300 font-medium italic bg-indigo-500/10 p-3 rounded-lg border border-indigo-500/20">
                                <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                L'équilibrage de charge assignera automatiquement au commercial le moins occupé.
                            </p>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-lg shadow-indigo-500/30 text-xs font-black uppercase tracking-wider rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-105">
                            Ajouter la Règle
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des Règles -->
        <div class="lg:col-span-2">
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                <div class="px-6 py-5 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Règles Actives</h3>
                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-700 text-slate-300">
                        {{ $rules->count() }} règles
                    </span>
                </div>
                <ul class="divide-y divide-white/5">
                    @forelse($rules as $rule)
                    <li class="hover:bg-white/[0.02] transition-colors duration-200">
                        <div class="px-6 py-6 flex items-center justify-between">
                            <div class="flex-1 min-w-0 pr-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-lg font-bold text-white truncate">{{ $rule->name }}</p>
                                    <div class="flex-shrink-0 flex ml-2">
                                        <span class="px-2.5 py-0.5 inline-flex text-[10px] font-black uppercase tracking-widest rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            Priorité: {{ $rule->priority }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1 flex items-center text-sm text-slate-400">
                                    <div class="bg-slate-800/50 rounded-lg p-2 border border-white/5 flex items-center gap-2 mr-2">
                                        <span class="font-medium">SI</span>
                                        @if($rule->criteria_type === 'source')
                                            Source = <strong class="text-indigo-400">{{ $rule->criteria_value }}</strong>
                                        @elseif($rule->criteria_type === 'amount_gt')
                                            Montant > <strong class="text-indigo-400">{{ $rule->criteria_value }} €</strong>
                                        @elseif($rule->criteria_type === 'sector')
                                            Secteur contient <strong class="text-indigo-400">{{ $rule->criteria_value }}</strong>
                                        @elseif($rule->criteria_type === 'workload')
                                            <span class="italic text-indigo-400">Équilibrage de charge automatique</span>
                                        @endif
                                    </div>
                                    
                                    <svg class="h-4 w-4 text-slate-600 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                    
                                    <div class="bg-slate-800/50 rounded-lg p-2 border border-white/5 flex items-center gap-2">
                                        <span class="font-medium">ALORS</span>
                                        @if($rule->target_user_id)
                                            Attribuer à <strong class="text-rose-400">{{ $rule->targetUser->name }}</strong>
                                        @else
                                            <span class="text-emerald-400 font-bold">Assignation dynamique (Moins chargé)</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 self-center">
                                <form action="{{ route('admin.attribution-rules.destroy', $rule) }}" method="POST" onsubmit="return confirm('Attention : Supprimer cette règle arrêtera son application immédiate. Continuer ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="group p-2 rounded-lg hover:bg-rose-500/10 border border-transparent hover:border-rose-500/20 transition-all">
                                        <svg class="h-5 w-5 text-slate-500 group-hover:text-rose-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="px-6 py-12 text-center text-slate-500">
                        <div class="h-16 w-16 rounded-full bg-slate-800/50 flex items-center justify-center mx-auto mb-4 border border-white/5">
                            <svg class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wide">Aucune règle définie</h3>
                        <p class="mt-2 text-sm">Les opportunités seront distribuées selon les paramètres par défaut.</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
</style>
<!-- Alpine for dynamic form -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
