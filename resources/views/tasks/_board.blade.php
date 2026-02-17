    <div class="flex gap-4 w-full items-start">
        @php
            $columns = [
                'todo' => [
                    'label' => 'Flux Intrant', 
                    'color' => 'slate', 
                    'text_color' => 'text-slate-400',
                    'bg_color' => 'bg-slate-500/10',
                    'border_color' => 'border-slate-500/20',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                ],
                'in_progress' => [
                    'label' => 'Traitement Actif', 
                    'color' => 'blue', 
                    'text_color' => 'text-blue-400',
                    'bg_color' => 'bg-blue-500/10',
                    'border_color' => 'border-blue-500/20',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'
                ],
                'done' => [
                    'label' => 'Objectif Atteint', 
                    'color' => 'green', 
                    'text_color' => 'text-emerald-400',
                    'bg_color' => 'bg-emerald-500/10',
                    'border_color' => 'border-emerald-500/20',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>'
                ]
            ];
        @endphp

        @foreach($columns as $status => $config)
        <div class="flex-1 flex flex-col min-w-[240px] max-w-[300px]">
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-[1.5rem] border border-white/5 flex flex-col shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-x-0 top-0 h-1 {{ $status === 'todo' ? 'bg-slate-500/30' : ($status === 'in_progress' ? 'bg-blue-500/30' : 'bg-emerald-500/30') }}"></div>
                
                <!-- Column Header -->
                <div class="px-5 py-3.5 border-b border-white/5 bg-white/[0.02] flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="{{ $config['text_color'] }} opacity-80 group-hover:scale-110 transition-transform duration-500 scale-90">
                                {!! $config['icon'] !!}
                            </div>
                            <h3 class="text-[8.5px] font-black text-white uppercase tracking-[0.2em]">{{ $config['label'] }}</h3>
                        </div>
                        <span class="px-2 py-0.5 {{ $config['bg_color'] }} {{ $config['text_color'] }} rounded-lg text-[8.5px] font-black border {{ $config['border_color'] }} shadow-inner">{{ $tasks[$status]->count() }}</span>
                    </div>
                </div>
                
                <!-- Cards Zone -->
                <div class="p-2 space-y-2.5 custom-scrollbar overflow-y-auto max-h-[700px]">
                    @foreach($tasks[$status] as $task)
                    <div class="group/card bg-slate-800/60 backdrop-blur-md rounded-xl p-3.5 shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/10 hover:border-white/20 relative overflow-hidden active:scale-[0.98] cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/[0.03] to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                        
                        <!-- Card Content -->
                        <div class="relative z-10 flex justify-between gap-2.5 mb-2.5">
                            <h4 class="text-xs font-black text-white leading-tight tracking-tight flex-1 line-clamp-2 group-hover/card:text-blue-400 transition-colors">{{ $task->titre }}</h4>
                            <div class="flex gap-1 opacity-0 group-hover/card:opacity-100 transition-all transform translate-x-1 group-hover/card:translate-x-0">
                                @if($status !== 'done')
                                <form action="{{ route('tasks.update', $task) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="statut" value="done">
                                    <button type="submit" class="p-1 text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded transition-all border border-transparent hover:border-emerald-500/20" title="Valider">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette action ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded transition-all border border-transparent hover:border-red-500/20" title="Supprimer">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        @if($task->description)
                        <p class="relative z-10 text-[8.5px] font-bold text-slate-400 mb-3.5 line-clamp-2 leading-relaxed tracking-wide group-hover/card:text-slate-300 transition-colors">{{ $task->description }}</p>
                        @endif
                        
                        <div class="relative z-10 flex items-center justify-between pt-3 border-t border-white/10">
                            <div class="flex items-center gap-1.5">
                                @if($task->priority === 'high')
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-lg shadow-red-500/50 animate-pulse" title="Haute Priorité"></span>
                                @elseif($task->priority === 'medium')
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-lg shadow-amber-500/50" title="Priorité Moyenne"></span>
                                @endif
                                
                                @if($task->due_date)
                                    @php 
                                        $isOverdue = $task->due_date->startOfDay()->lte(now()->startOfDay()) && $status !== 'done';
                                        $isToday = $task->due_date->isToday();
                                    @endphp
                                    <span class="text-[7.5px] font-black uppercase tracking-widest {{ $isOverdue ? 'text-red-400' : ($isToday ? 'text-amber-400' : 'text-slate-400') }}">
                                        {{ $isToday ? "Auj." : $task->due_date->translatedFormat('d M') }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="w-6 h-6 rounded-lg bg-blue-600/20 border border-blue-500/20 text-blue-400 text-[8px] font-black flex items-center justify-center uppercase shadow-lg group-hover/card:bg-blue-600 group-hover/card:text-white transition-all duration-500" title="Assigné à : {{ $task->assignee?->name ?? 'Système' }}">
                                {{ substr($task->assignee?->name ?? 'S', 0, 1) }}
                            </div>
                        </div>

                        @if($task->related)
                        <div class="relative z-10 mt-3 pt-2.5 border-t border-white/5 flex items-center gap-2">
                            <div class="w-4 h-4 rounded-md bg-white/5 border border-white/5 flex items-center justify-center text-slate-500 group-hover/card:text-blue-400 transition-colors overflow-hidden">
                                <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <span class="text-[7px] font-black text-slate-500 uppercase tracking-widest group-hover/card:text-slate-400 transition-colors truncate">{{ class_basename($task->related_type) }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    
                    @if($tasks[$status]->isEmpty())
                    <div class="flex flex-col items-center justify-center py-8 text-slate-700">
                        <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center mb-3 border border-white/5 shadow-inner">
                            <div class="opacity-20 translate-y-0.5 scale-75">{!! $config['icon'] !!}</div>
                        </div>
                        <p class="text-[7.5px] font-black uppercase tracking-[0.2em] opacity-30">Libre</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
