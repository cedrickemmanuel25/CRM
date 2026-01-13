<div x-show="notifModal.open" 
     class="fixed inset-0 z-[100] overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true"
     style="display: none;">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div x-show="notifModal.open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             aria-hidden="true"
             @click="notifModal.open = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div x-show="notifModal.open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            
            <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-indigo-50 sm:mx-0 sm:h-12 sm:w-12">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="mt-4 text-center sm:mt-0 sm:ml-6 sm:text-left w-full">
                        <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title" x-text="notifModal.title"></h3>
                        <div class="mt-4">
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed" x-text="notifModal.message"></p>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-gray-400">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-text="notifModal.date"></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3">
                <template x-if="notifModal.url">
                    <a :href="notifModal.url" 
                       class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-indigo-600 text-base font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-all">
                        Accéder aux détails
                    </a>
                </template>
                <button type="button" 
                        @click="notifModal.open = false" 
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>
