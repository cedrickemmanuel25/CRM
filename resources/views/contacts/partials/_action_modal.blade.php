<div x-show="showQuickModal" 
     class="fixed inset-0 z-[100] overflow-y-auto" 
     x-cloak>
    <!-- Backdrop -->
    <div @click="showQuickModal = false" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
         x-show="showQuickModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    <!-- Modal Content -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="showQuickModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all w-full max-w-sm border border-slate-100">
            
            <div class="flex items-center gap-4 mb-4">
                <div class="h-10 w-10 rounded-full flex items-center justify-center" :class="quickModalColor">
                    <template x-if="quickModalIcon === 'phone'">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </template>
                    <template x-if="quickModalIcon === 'mail'">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </template>
                    <template x-if="quickModalIcon === 'note'">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </template>
                    <template x-if="quickModalIcon === 'check'">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </template>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-tight" x-text="quickModalTitle"></h3>
                    <p class="text-xs text-slate-500" x-text="quickModalBody"></p>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-2">
                <button @click="executeQuickAction()" 
                        class="w-full inline-flex justify-center items-center px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-all shadow-md active:scale-95">
                    Confirmer l'action
                </button>
                <button @click="showQuickModal = false" 
                        class="w-full inline-flex justify-center items-center px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition-all active:scale-95">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
