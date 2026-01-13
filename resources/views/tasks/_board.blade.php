    <div class="flex gap-6 w-full items-start">
        @php
            $columns = [
                'todo' => ['label' => 'À faire', 'color' => 'slate', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'],
                'in_progress' => ['label' => 'En cours', 'color' => 'blue', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'],
                'done' => ['label' => 'Terminé', 'color' => 'green', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>']
            ];
        @endphp

        @foreach($columns as $status => $config)
        <div class="flex-1 flex flex-col min-w-[300px]">
            <div class="bg-slate-100 rounded-lg flex flex-col">
                <!-- Column Header -->
                <div class="p-4 border-b border-slate-200 bg-white rounded-t-lg flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="text-{{ $config['color'] }}-600">
                                {!! $config['icon'] !!}
                            </div>
                            <h3 class="font-semibold text-slate-900">{{ $config['label'] }}</h3>
                        </div>
                        <span class="px-2 py-1 bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 rounded text-sm font-semibold">{{ $tasks[$status]->count() }}</span>
                    </div>
                </div>
                
                <!-- Cards Zone -->
                <div class="p-3 space-y-3">
                    @foreach($tasks[$status] as $task)
                    <div class="group bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-all border border-slate-200 hover:border-{{ $config['color'] }}-300">
                        <!-- Card Content -->
                            <div class="flex justify-between gap-3 mb-2">
                            <h4 class="text-sm font-semibold text-slate-900 flex-1 line-clamp-2">{{ $task->titre }}</h4>
                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($status !== 'done')
                                <form action="{{ route('tasks.update', $task) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="statut" value="done">
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded transition-colors" title="Marquer comme terminé">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Supprimer">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        @if($task->description)
                        <p class="text-xs text-slate-500 mb-3 line-clamp-2">{{ $task->description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                            <div class="flex items-center gap-2">
                                @if($task->due_date)
                                    @php 
                                        $isOverdue = $task->due_date->startOfDay()->lte(now()->startOfDay()) && $status !== 'done';
                                        $isToday = $task->due_date->isToday();
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium {{ $isOverdue ? 'bg-red-100 text-red-700' : ($isToday ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $task->due_date->translatedFormat('d M') }}
                                    </span>
                                @endif
                                
                                @if($task->priority === 'high')
                                <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-medium" title="Priorité haute">Haute</span>
                                @elseif($task->priority === 'medium')
                                <span class="px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-medium" title="Priorité moyenne">Moyenne</span>
                                @endif
                            </div>
                            
                            <div class="w-7 h-7 rounded-full bg-indigo-600 text-white text-xs font-semibold flex items-center justify-center" title="{{ $task->assignee?->name ?? 'Non assigné' }}">
                                {{ substr($task->assignee?->name ?? '?', 0, 1) }}
                            </div>
                        </div>

                        @if($task->related)
                        <div class="mt-3 pt-3 border-t border-slate-100">
                            <div class="inline-flex items-center gap-1.5 px-2 py-1 bg-slate-50 rounded text-xs text-slate-600 border border-slate-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                <span class="font-medium">{{ class_basename($task->related_type) }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    
                    @if($tasks[$status]->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mb-3">
                            {!! $config['icon'] !!}
                        </div>
                        <p class="text-sm font-medium">Aucune tâche</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
