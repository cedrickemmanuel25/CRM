@extends('layouts.app')

@section('title', 'Mes Tâches')



@section('content')
<div class="w-full flex flex-col bg-slate-50" x-data="{ openTaskModal: false }">
    
    <!-- Fixed Top Section (Header, Stats, Filters) -->
    <div class="flex-shrink-0">
        <!-- Header professionnel -->
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-slate-900">Tâches</h1>
                            <p class="text-sm text-slate-500">Gérez vos tâches et suivez leur progression</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="{{ route('calendar') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Calendrier
                        </a>
                        <button @click="openTaskModal = true" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 rounded-lg text-sm font-medium text-white hover:bg-indigo-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nouvelle tâche
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Stats markup remains same but inside this wrapper -->
                <div class="bg-white rounded-lg border border-slate-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-slate-600">Total des tâches</span>
                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-semibold text-slate-900" id="total-tasks">{{ $tasks['todo']->count() + $tasks['in_progress']->count() + $tasks['done']->count() }}</p>
                </div>

                <div class="bg-white rounded-lg border border-slate-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-slate-600">En cours</span>
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-semibold text-blue-600">{{ $tasks['in_progress']->count() }}</p>
                </div>

                <div class="bg-white rounded-lg border border-slate-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-slate-600">Terminées</span>
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-semibold text-green-600">{{ $tasks['done']->count() }}</p>
                </div>

                <div class="bg-white rounded-lg border border-slate-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-slate-600">À faire aujourd'hui</span>
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-semibold text-amber-600" id="tasks-due-today">{{ \App\Models\Task::whereDate('due_date', today())->count() }}</p>
                </div>

                <div class="bg-white rounded-lg border border-slate-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-slate-600">Priorité haute</span>
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-semibold text-red-600" id="tasks-high-priority">{{ \App\Models\Task::where('priority', 'high')->count() }}</p>
                </div>
            </div>

            <!-- Filtres -->
            <div class="bg-white rounded-lg border border-slate-200 p-6 mb-6">
                <!-- Filter form content remains largely same -->
                <form action="{{ route('tasks.index') }}" method="GET">
                    <div class="flex flex-wrap items-center gap-2 mb-6 pb-5 border-b border-slate-200">
                        <span class="text-sm font-medium text-slate-700 mr-2">Filtres rapides:</span>
                        <a href="{{ route('tasks.index', ['my_tasks' => 1]) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ request('my_tasks') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Mes tâches
                        </a>
                        <a href="{{ route('tasks.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ !request()->hasAny(['my_tasks', 'overdue']) ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Toutes</a>
                        <a href="{{ route('tasks.index', ['overdue' => 1]) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ request('overdue') ? 'bg-red-600 text-white' : 'bg-red-50 text-red-600 hover:bg-red-100' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path></svg>
                            En retard
                            <span class="px-2 py-0.5 bg-white/20 rounded text-xs font-semibold">{{ \App\Models\Task::overdue()->count() }}</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scrollable Kanban Board -->
    <div class="overflow-x-auto pb-8 bg-slate-50 px-4 sm:px-6 lg:px-8">
        <div x-data="{
            startPolling() {
                setInterval(() => {
                    const url = new URL(window.location.href);
                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Décoder le HTML base64 en gérant correctement l'UTF-8
                        const binaryString = atob(data.html);
                        const bytes = new Uint8Array(binaryString.length);
                        for (let i = 0; i < binaryString.length; i++) {
                            bytes[i] = binaryString.charCodeAt(i);
                        }
                        const decodedHtml = new TextDecoder('utf-8').decode(bytes);
                        this.$el.innerHTML = decodedHtml;
                        
                        // Update metrics
                        document.getElementById('total-tasks').innerText = data.total_tasks;
                        document.getElementById('tasks-due-today').innerText = data.tasks_due_today;
                        document.getElementById('tasks-high-priority').innerText = data.tasks_high_priority;
                    });
                }, 5000);
            }
        }" x-init="startPolling()">
            @include('tasks._board')
        </div>
    </div>

    <!-- Modal -->
    <div x-show="openTaskModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
            <div @click="openTaskModal = false" class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity"></div>
            <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900">Nouvelle tâche</h3>
                        <button @click="openTaskModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        @include('tasks._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 3px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.5); }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection