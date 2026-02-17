<!-- Enterprise Modal/Details -->
<div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-950/80 backdrop-blur-md" aria-hidden="true" @click="open = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-[#0f172a] border border-white/10 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <!-- Modal Header -->
            <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                <h3 class="text-xl font-black text-white uppercase tracking-tight flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    Détails de l'action
                </h3>
                <button @click="open = false" class="text-slate-500 hover:text-white transition-colors p-2 hover:bg-white/5 rounded-xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="px-8 py-8 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Old Values -->
                    <div>
                        <h4 class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span> Données Originales
                        </h4>
                        @if($log->old_values)
                        <div class="bg-rose-500/5 rounded-2xl border border-rose-500/10 overflow-hidden">
                            <div class="p-5 overflow-x-auto">
                                @foreach($log->old_values as $key => $value)
                                <div class="mb-3 last:mb-0">
                                    <span class="block text-[10px] font-bold text-rose-300/70 uppercase tracking-wide mb-1">{{ \App\Models\AuditLog::getTranslatedKey($key) }}</span> 
                                    <div class="font-mono text-xs text-rose-100 bg-rose-500/10 p-2 rounded-lg border border-rose-500/10 break-all">
                                        {{ is_array($value) ? json_encode($value) : $value }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center h-48 bg-white/[0.02] rounded-2xl border border-dashed border-white/5 p-8">
                            <svg class="w-8 h-8 text-slate-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wide">Aucune valeur précédente</p>
                        </div>
                        @endif
                    </div>

                    <!-- New Values -->
                    <div>
                        <h4 class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Nouvelles Données
                        </h4>
                        @if($log->new_values)
                        <div class="bg-emerald-500/5 rounded-2xl border border-emerald-500/10 overflow-hidden">
                            <div class="p-5 overflow-x-auto">
                                @foreach($log->new_values as $key => $value)
                                <div class="mb-3 last:mb-0">
                                    <span class="block text-[10px] font-bold text-emerald-300/70 uppercase tracking-wide mb-1">{{ \App\Models\AuditLog::getTranslatedKey($key) }}</span> 
                                    <div class="font-mono text-xs text-emerald-100 bg-emerald-500/10 p-2 rounded-lg border border-emerald-500/10 break-all">
                                        {{ is_array($value) ? json_encode($value) : $value }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center h-48 bg-white/[0.02] rounded-2xl border border-dashed border-white/5 p-8">
                            <svg class="w-8 h-8 text-slate-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wide">Aucune nouvelle valeur</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if(!$log->old_values && !$log->new_values)
                <div class="text-center py-16">
                    <div class="mx-auto h-16 w-16 bg-white/5 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">Aucun détail disponible</h3>
                    <p class="text-sm text-slate-500 font-medium">Cette action n'a enregistré aucun changement de données spécifique.</p>
                </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="bg-white/[0.02] px-8 py-6 flex flex-row-reverse border-t border-white/5">
                <button type="button" class="w-full inline-flex justify-center rounded-xl px-6 py-3 bg-white/5 border border-white/10 text-xs font-black uppercase tracking-widest text-white hover:bg-white/10 hover:border-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto transition-all duration-200" @click="open = false">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>
