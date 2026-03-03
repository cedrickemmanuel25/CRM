@php
    $overdue = $data['lists']['overdue_tasks'] ?? collect();
    $today = $data['lists']['due_today_tasks'] ?? collect();
    $upcoming = $data['lists']['upcoming_tasks'] ?? collect();
    $hasUrgency = $overdue->isNotEmpty() || $today->isNotEmpty() || $upcoming->isNotEmpty();
@endphp

@if($hasUrgency)
<div x-data="{ show: true }" 
     x-show="show" 
     class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
     x-cloak>
    
    <div @click.away="show = false" 
         class="bg-slate-900 border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]">
        
        <!-- Header -->
        <div class="px-6 py-5 border-b border-white/5 bg-slate-800/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-500/10 rounded-lg">
                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white uppercase tracking-tight">Rappel des Tâches</h3>
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Planification de votre activité</p>
                </div>
            </div>
            <button @click="show = false" class="text-slate-500 hover:text-white transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto space-y-6 custom-scrollbar">
            
            <!-- Retards -->
            @if($overdue->isNotEmpty())
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                        </span>
                        En Retard ({{ $overdue->count() }})
                    </span>
                </div>
                <div class="space-y-3">
                    @foreach($overdue->take(3) as $task)
                    <div class="group bg-rose-500/5 border border-rose-500/10 rounded-xl p-3 hover:bg-rose-500/10 transition-all">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-white group-hover:text-rose-400 transition-colors truncate">{{ $task->titre }}</h4>
                                <p class="text-[10px] text-slate-400 mt-1 line-clamp-1 italic">{{ $task->due_date->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('tasks.show', $task) }}" class="shrink-0 p-1.5 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Aujourd'hui -->
            @if($today->isNotEmpty())
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest">Aujourd'hui ({{ $today->count() }})</span>
                </div>
                <div class="space-y-3">
                    @foreach($today->take(3) as $task)
                    <div class="group bg-blue-500/5 border border-blue-500/10 rounded-xl p-3 hover:bg-blue-500/10 transition-all">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-white group-hover:text-blue-400 transition-colors truncate">{{ $task->titre }}</h4>
                                <p class="text-[10px] text-slate-400 mt-1 italic">{{ $task->due_date->format('H:i') }}</p>
                            </div>
                            <a href="{{ route('tasks.show', $task) }}" class="shrink-0 p-1.5 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- À Venir (Prochainement) -->
            @if($upcoming->isNotEmpty())
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">À Venir ({{ $upcoming->count() }})</span>
                </div>
                <div class="space-y-3">
                    @foreach($upcoming->take(3) as $task)
                    <div class="group bg-emerald-500/5 border border-emerald-500/10 rounded-xl p-3 hover:bg-emerald-500/10 transition-all">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-white group-hover:text-emerald-400 transition-colors truncate">{{ $task->titre }}</h4>
                                <p class="text-[10px] text-slate-400 mt-1 italic">{{ $task->due_date->translatedFormat('d M H:i') }}</p>
                            </div>
                            <a href="{{ route('tasks.show', $task) }}" class="shrink-0 p-1.5 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-6 py-5 bg-slate-950/20 border-t border-white/5 flex flex-col gap-3">
            <a href="{{ route('calendar') }}" class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-blue-600/20 text-center uppercase tracking-wider">
                Voir tout l'agenda
            </a>
            <button @click="show = false" class="w-full py-2.5 bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white rounded-xl text-[11px] font-bold transition-all text-center uppercase tracking-widest">
                Ignorer pour l'instant
            </button>
        </div>
    </div>
</div>
@endif

