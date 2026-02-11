<!-- Professional Modal/Details -->
<div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm" aria-hidden="true" @click="open = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full ring-1 ring-black ring-opacity-5">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Détails de l'action
                </h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Old Values -->
                    @if($log->old_values)
                    <div class="bg-red-50/50 rounded-lg border border-red-100 overflow-hidden">
                        <div class="bg-red-100/50 px-4 py-2 border-b border-red-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-red-800 uppercase tracking-widest">Avant</span>
                            <span class="text-[10px] text-red-600 font-mono">JSON</span>
                        </div>
                        <div class="p-4 overflow-x-auto text-xs">
                            @foreach($log->old_values as $key => $value)
                            <div class="mb-1">
                                <span class="font-semibold text-red-700">{{ \App\Models\AuditLog::getTranslatedKey($key) }}:</span> 
                                <span class="text-red-900 font-mono">{{ is_array($value) ? json_encode($value) : $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-center h-full bg-gray-50 rounded-lg border border-dashed border-gray-200 p-8">
                        <p class="text-gray-400 text-sm italic">Aucune valeur précédente</p>
                    </div>
                    @endif

                    <!-- New Values -->
                    @if($log->new_values)
                    <div class="bg-green-50/50 rounded-lg border border-green-100 overflow-hidden">
                        <div class="bg-green-100/50 px-4 py-2 border-b border-green-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-green-800 uppercase tracking-widest">Après</span>
                            <span class="text-[10px] text-green-600 font-mono">JSON</span>
                        </div>
                        <div class="p-4 overflow-x-auto text-xs">
                            @foreach($log->new_values as $key => $value)
                            <div class="mb-1">
                                <span class="font-semibold text-green-700">{{ \App\Models\AuditLog::getTranslatedKey($key) }}:</span> 
                                <span class="text-green-900 font-mono">{{ is_array($value) ? json_encode($value) : $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-center h-full bg-gray-50 rounded-lg border border-dashed border-gray-200 p-8">
                        <p class="text-gray-400 text-sm italic">Aucune nouvelle valeur</p>
                    </div>
                    @endif
                </div>

                @if(!$log->old_values && !$log->new_values)
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-300">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun détail disponible</h3>
                    <p class="mt-1 text-sm text-gray-500">Cette action n'a enregistré aucun changement de données spécifique.</p>
                </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-gray-100">
                <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-gray-900 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors" @click="open = false">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>
