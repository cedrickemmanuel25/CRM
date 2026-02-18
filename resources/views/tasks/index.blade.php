@extends('layouts.app')

@section('title', 'Mes Tâches')

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
    }

    .label-caps {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
    }

    .metric-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #f1f5f9;
        letter-spacing: -0.025em;
    }
</style>

<div class="w-full flex flex-col bg-[#020617] text-slate-300 min-h-screen" x-data="{ openTaskModal: false }">
    
    <!-- Fixed Top Section (Header, Stats, Filters) -->
    <div class="flex-shrink-0">
        <!-- Header professionnel -->
        <div class="bg-slate-900/50 backdrop-blur-xl border-b border-white/10">
            <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 py-5">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-indigo-600/10 rounded-2xl flex items-center justify-center border border-indigo-500/20 shadow-lg shadow-indigo-500/5">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="page-title">Tâches <span class="accent">&amp; Missions</span></h1>
                            <p class="text-[10px] font-black text-indigo-500/60 uppercase tracking-[0.3em] mt-1">{{ count($tasks['todo']) + count($tasks['in_progress']) + count($tasks['done']) }} flux opérationnels</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <a href="{{ route('calendar') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-3 bg-white/5 border border-white/10 text-slate-300 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-white/10 hover:text-white transition-all">
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Agenda
                        </a>
                        <button @click="openTaskModal = true" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-3 px-6 py-3.5 bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-blue-500 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Nouvelle Tâche</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <!-- Statistiques -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-8">
                <div class="saas-card p-6">
                    <span class="label-caps mb-3">Total</span>
                    <div class="flex items-baseline gap-2">
                        <span class="metric-value" id="total-tasks">{{ $tasks['todo']->count() + $tasks['in_progress']->count() + $tasks['done']->count() }}</span>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Missions</span>
                    </div>
                </div>

                <div class="saas-card p-6 border-l-2 border-l-blue-500">
                    <span class="label-caps mb-3">En cours</span>
                    <span class="metric-value text-blue-500">{{ $tasks['in_progress']->count() }}</span>
                </div>

                <div class="saas-card p-6 border-l-2 border-l-emerald-500">
                    <span class="label-caps mb-3">Terminées</span>
                    <span class="metric-value text-emerald-500">{{ $tasks['done']->count() }}</span>
                </div>

                <div class="saas-card p-6 border-l-2 border-l-amber-500">
                    <span class="label-caps mb-3">Aujourd'hui</span>
                    <span class="metric-value text-amber-500" id="tasks-due-today">{{ \App\Models\Task::whereDate('due_date', today())->count() }}</span>
                </div>

                <div class="saas-card p-6 border-l-2 border-l-rose-500 hidden lg:block">
                    <span class="label-caps mb-3">Priorité Haute</span>
                    <span class="metric-value text-rose-500" id="tasks-high-priority">{{ \App\Models\Task::where('priority', 'high')->count() }}</span>
                </div>
            </div>

            <!-- Filtres -->
            <div class="bg-slate-900/30 border border-white/5 rounded-3xl p-6 mb-10 backdrop-blur-md">
                <form action="{{ route('tasks.index') }}" method="GET">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mr-4 ml-2">Séquenceur:</span>
                        <a href="{{ route('tasks.index', ['my_tasks' => 1]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('my_tasks') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-white/5 text-slate-400 hover:bg-white/10 hover:text-white border border-white/5' }}">
                            Mes tâches
                        </a>
                        <a href="{{ route('tasks.index') }}" class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request()->hasAny(['my_tasks', 'overdue']) ? 'bg-slate-800 text-white border border-white/10' : 'bg-white/5 text-slate-400 hover:bg-white/10 hover:text-white border border-white/5' }}">Vecteur Complet</a>
                        <a href="{{ route('tasks.index', ['overdue' => 1]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('overdue') ? 'bg-rose-600 text-white shadow-lg shadow-rose-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20 hover:bg-rose-500/20' }}">
                            Point Critique
                            <span class="px-2 py-0.5 bg-black/30 rounded text-xs font-black">{{ \App\Models\Task::overdue()->count() }}</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scrollable Kanban Board -->
    <div class="overflow-x-auto pb-12 px-4 sm:px-6 lg:px-8 no-scrollbar scroll-smooth">
        <div x-data="{
            startPolling() {
                setInterval(() => {
                    const url = new URL(window.location.href);
                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            const binaryString = atob(data.html);
                            const bytes = new Uint8Array(binaryString.length);
                            for (let i = 0; i < binaryString.length; i++) {
                                bytes[i] = binaryString.charCodeAt(i);
                            }
                            const decodedHtml = new TextDecoder('utf-8').decode(bytes);
                            this.$el.innerHTML = decodedHtml;
                        }
                        
                        if (document.getElementById('total-tasks')) document.getElementById('total-tasks').innerText = data.total_tasks;
                        if (document.getElementById('tasks-due-today')) document.getElementById('tasks-due-today').innerText = data.tasks_due_today;
                        if (document.getElementById('tasks-high-priority')) document.getElementById('tasks-high-priority').innerText = data.tasks_high_priority;
                    })
                    .catch(err => console.debug('Polling background silence'));
                }, 10000);
            }
        }" x-init="startPolling()">
            @include('tasks._board')
        </div>
    </div>

    <!-- Modal -->
    <div x-show="openTaskModal" x-cloak class="fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 p-8">
            <div @click="openTaskModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl transition-opacity"></div>
            <div class="relative bg-[#020617] rounded-[2.5rem] shadow-2xl max-w-2xl w-full overflow-hidden border border-white/10" x-show="openTaskModal" x-transition>
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em]">Nouvelle Unité Action</span>
                        </div>
                        <h3 class="text-lg font-black text-white uppercase tracking-tight">Planification Tâche</h3>
                    </div>
                    <button @click="openTaskModal = false" class="p-3 text-slate-500 hover:text-white hover:bg-white/10 rounded-2xl transition-all border border-transparent hover:border-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="px-8 py-8">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        @include('tasks._form', [
                            'users' => $users ?? \App\Models\User::all(),
                            'contacts' => $contacts ?? \App\Models\Contact::all(),
                            'opportunities' => $opportunities ?? \App\Models\Opportunity::all()
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection