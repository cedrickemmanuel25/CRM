@extends('layouts.app')

@section('title', 'Calendrier & Tâches')

@section('content')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('unifiedTaskApp', () => ({
        selectedDate: '{{ request('date', now()->format('Y-m-d')) }}',
        currentMonth: new Date(),
        showFullCalendar: false,
        calendarView: 'week',
        openTaskModal: false,
        selectedEvent: null,
        
        events: @json($events ?? []),
        legend: { task: 'bg-indigo-500', appel: 'bg-blue-500', email: 'bg-purple-500', reunion: 'bg-amber-500', note: 'bg-gray-500' },
        
        monthDays: [],
        weekDays: [],
        
        init() {
            try {
                this.generateMonthDays();
                this.generateWeekDays();
                this.startPolling();
                if ({{ $errors->any() ? 'true' : 'false' }}) {
                    this.openTaskModal = true;
                }
            } catch (e) {
                console.error('Init error:', e);
            }
        },

        openNewTask() {
            this.openTaskModal = true;
        },

        closeNewTask() {
            this.openTaskModal = false;
        },
        
        get currentMonthLabel() {
            return this.currentMonth.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });
        },
        
        get selectedDateLabel() {
            return new Date(this.selectedDate).toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        },
        
        generateMonthDays() {
            const year = this.currentMonth.getFullYear();
            const month = this.currentMonth.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            let startDay = firstDay.getDay(); 
            startDay = startDay === 0 ? 6 : startDay - 1;
            this.monthDays = [];
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = startDay - 1; i >= 0; i--) {
                const d = new Date(year, month - 1, prevMonthLastDay - i);
                this.monthDays.push({ dayNumber: d.getDate(), date: this.formatDate(d), isCurrentMonth: false });
            }
            for (let i = 1; i <= lastDay.getDate(); i++) {
                const d = new Date(year, month, i);
                this.monthDays.push({ dayNumber: i, date: this.formatDate(d), isCurrentMonth: true });
            }
            const remaining = 42 - this.monthDays.length;
            for (let i = 1; i <= remaining; i++) {
                const d = new Date(year, month + 1, i);
                this.monthDays.push({ dayNumber: i, date: this.formatDate(d), isCurrentMonth: false });
            }
        },
        
        generateWeekDays() {
            const date = new Date(this.selectedDate);
            const day = date.getDay();
            const diff = date.getDate() - day + (day === 0 ? -6 : 1);
            const weekStart = new Date(date.setDate(diff));
            this.weekDays = [];
            for (let i = 0; i < 7; i++) {
                const d = new Date(weekStart);
                d.setDate(d.getDate() + i);
                this.weekDays.push({ date: this.formatDate(d), dayNumber: d.getDate(), dayName: d.toLocaleDateString('fr-FR', { weekday: 'short' }) });
            }
        },
        
        formatDate(d) {
            return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
        },
        
        isSelected(date) { return date === this.selectedDate; },
        isToday(date) { return date === this.formatDate(new Date()); },
        hasEvents(date) { return this.events.some(e => e.start.startsWith(date)); },
        getEventsForDate(date) { return this.events.filter(e => e.start.startsWith(date)); },
        openEventDetail(event) { this.selectedEvent = event; },
        formatTime(dateStr) { return new Date(dateStr).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }); },
        prevMonth() { this.currentMonth.setMonth(this.currentMonth.getMonth() - 1); this.generateMonthDays(); },
        nextMonth() { this.currentMonth.setMonth(this.currentMonth.getMonth() + 1); this.generateMonthDays(); },
        selectDate(date) { this.selectedDate = date; this.generateWeekDays(); this.fetchTasks(); },
        
        async fetchTasks() {
            const url = new URL(window.location.href);
            url.searchParams.set('date', this.selectedDate);
            try {
                const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' });
                if (!response.ok) {
                    if (response.status === 401) { window.location.reload(); return; }
                    throw new Error(`Server status: ${response.status}`);
                }
                const data = await response.json();
                if (data.html && this.$refs.taskBoard) {
                    const decodedHtml = new TextDecoder('utf-8').decode(Uint8Array.from(atob(data.html), c => c.charCodeAt(0)));
                    this.$refs.taskBoard.innerHTML = decodedHtml;
                    this.events = data.events || this.events;
                }
            } catch (error) { console.warn('Sync error:', error.message); }
        },
        startPolling() { setInterval(() => this.fetchTasks(), 10000); }
    }));
});
</script>

<div class="min-h-screen bg-[#020617] text-slate-300" x-data="unifiedTaskApp()">
    <!-- Modals moved to Top for stacking reliability -->
    
    <!-- Task Creation Modal -->
    <div x-show="openTaskModal" x-cloak class="fixed inset-0 z-[999] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 p-8">
            <div @click="openTaskModal = false" class="fixed inset-0 bg-slate-950/90 backdrop-blur-2xl transition-opacity"></div>
            <div class="relative bg-[#020617] rounded-[2.5rem] shadow-2xl max-w-2xl w-full overflow-hidden border border-white/10" x-transition>
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em]">Nouvelle Unité Action</span>
                        </div>
                        <h3 class="text-lg font-black text-white uppercase tracking-tight">Planification Tâche</h3>
                    </div>
                    <button @click="openTaskModal = false" class="p-3 text-slate-500 hover:text-white hover:bg-white/10 rounded-2xl transition-all border border-transparent hover:border-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="px-8 py-8">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        @include('tasks._form', [
                            'users' => $users,
                            'contacts' => $contacts,
                            'opportunities' => $opportunities
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div x-show="selectedEvent" x-cloak class="fixed inset-0 z-[998] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 p-8">
            <div @click="selectedEvent = null" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl transition-opacity"></div>
            <template x-if="selectedEvent">
                <div class="relative bg-[#020617] rounded-[2.5rem] shadow-2xl max-w-lg w-full overflow-hidden border border-white/10" 
                     x-transition
                     :class="selectedEvent.className.replace('bg-', 'bg-').replace('text-', 'text-')">
                    <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between transition-colors">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-[10px] font-black text-white/60 uppercase tracking-[0.3em]">Analyse de Flux</span>
                            </div>
                            <h3 class="text-lg font-black text-white uppercase tracking-tight" x-text="selectedEvent.type === 'task' ? 'Fiche d\'action' : 'Mémo Activité'"></h3>
                        </div>
                        <button @click="selectedEvent = null" class="p-3 text-white/50 hover:text-white hover:bg-white/10 rounded-2xl transition-all border border-transparent hover:border-white/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="p-8 space-y-8">
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 block">Désignation / Contexte</label>
                            <p class="text-lg font-black text-white tracking-tight leading-snug" x-text="selectedEvent.title"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-8">
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1.5 block">Planification</label>
                                <p class="text-white font-black text-sm" x-text="new Date(selectedEvent.start).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })"></p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1.5 block">Horodatage</label>
                                <p class="text-white font-black text-sm" x-text="formatTime(selectedEvent.start)"></p>
                            </div>
                        </div>
                        <div class="flex justify-end pt-8 border-t border-white/5 gap-4">
                            <template x-if="selectedEvent.type === 'task'">
                                <a :href="'/tasks/' + selectedEvent.id" class="px-8 py-3.5 bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-blue-500 transition-all shadow-lg shadow-blue-500/20 active:scale-95">Inspecter</a>
                            </template>
                            <button @click="selectedEvent = null" class="px-6 py-3 rounded-xl border border-white/10 bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest hover:bg-white/10 hover:text-white transition-all">Fermer</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    
    <!-- Top Header : Enterprise Context -->
    <div class="bg-slate-900/50 backdrop-blur-xl border-b border-white/10 sticky top-16 z-30">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 py-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-12 bg-blue-600/10 rounded-2xl flex items-center justify-center border border-blue-500/20 shadow-lg shadow-blue-500/5">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h1 class="page-title">Agenda <span class="accent">&amp; Tâches</span></h1>
                        <p class="text-[10px] font-black text-blue-500/60 uppercase tracking-[0.3em] mt-1">{{ now()->translatedFormat('l d F Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <button @click="showFullCalendar = !showFullCalendar" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-3 bg-white/5 border border-white/10 text-slate-300 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-white/10 hover:text-white transition-all">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                        <span x-text="showFullCalendar ? 'Tableau Kanban' : 'Vue Agenda'"></span>
                    </button>
                    <button @click="openNewTask()" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-3 px-6 py-3.5 bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-blue-500 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Nouvelle Tâche</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[1800px] mx-auto px-4 pt-10 pb-12">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            
            <!-- Left Sidebar: Mini Calendar -->
            <div class="w-full lg:w-64 flex-shrink-0 space-y-6">
                
                <!-- Mini Calendar Card -->
                <div class="bg-slate-900/50 backdrop-blur-xl rounded-[2rem] border border-white/10 shadow-2xl relative overflow-hidden group">
                    <div class="px-6 py-5 border-b border-white/5 bg-white/5 flex items-center justify-between">
                        <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em]" x-text="currentMonthLabel"></h3>
                        <div class="flex gap-1.5">
                            <button @click="prevMonth()" class="p-2 hover:bg-white/10 rounded-xl transition-all text-slate-500 hover:text-white border border-transparent hover:border-white/10 shadow-inner">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button @click="nextMonth()" class="p-2 hover:bg-white/10 rounded-xl transition-all text-slate-500 hover:text-white border border-transparent hover:border-white/10 shadow-inner">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="grid grid-cols-7 mb-4">
                            <template x-for="day in ['L','M','M','J','V','S','D']">
                                <div class="text-[10px] font-black text-slate-600 text-center py-2 uppercase tracking-[0.2em]" x-text="day"></div>
                            </template>
                        </div>
                        <div class="grid grid-cols-7 gap-1">
                            <template x-for="day in monthDays" :key="day.date">
                                <button @click="selectDate(day.date)" 
                                        class="aspect-square flex flex-col items-center justify-center rounded-xl text-xs font-bold transition-all relative group"
                                        :class="{
                                            'text-slate-700': !day.isCurrentMonth,
                                            'bg-blue-600 text-white shadow-lg shadow-blue-500/20 scale-110 z-10': isSelected(day.date),
                                            'hover:bg-white/5 text-slate-400 hover:text-white': day.isCurrentMonth && !isSelected(day.date),
                                            'border border-blue-500/30 text-blue-400': isToday(day.date) && !isSelected(day.date)
                                        }">
                                    <span x-text="day.dayNumber"></span>
                                    <!-- Indicator for events -->
                                    <div x-show="hasEvents(day.date)" 
                                         class="w-1 h-1 rounded-full mt-1"
                                         :class="isSelected(day.date) ? 'bg-white/50' : 'bg-blue-500'"></div>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Selected Date Label -->
                    <div class="p-6 bg-blue-500/5 border-t border-white/5">
                        <p class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] text-center" x-text="selectedDateLabel"></p>
                    </div>
                </div>

                <!-- Legend Card -->
                <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-[2rem] shadow-2xl hidden lg:block">
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Légende </h3>
                    <div class="space-y-4">
                        <template x-for="(color, type) in legend" :key="type">
                            <div class="flex items-center gap-4 group cursor-default">
                                <span class="w-3 h-3 rounded-full shadow-lg transition-transform group-hover:scale-125" :class="color"></span>
                                <span class="text-xs font-bold text-slate-400 capitalize group-hover:text-slate-200 transition-colors" x-text="type"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 w-full">
                <!-- Full Calendar View (Alt) -->
                <div x-show="showFullCalendar" x-cloak class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl">
                    <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/5">
                        <h2 class="text-[10px] font-black text-white uppercase tracking-[0.2em]" x-text="calendarView === 'week' ? 'Plan hebdomadaire' : 'Focus Journalier'"></h2>
                        <div class="flex bg-slate-800/60 rounded-xl p-1.5 border border-white/5">
                            <button @click="calendarView = 'week'" :class="calendarView === 'week' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white'" class="px-5 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all">Semaine</button>
                            <button @click="calendarView = 'day'" :class="calendarView === 'day' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white'" class="px-5 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all">Jour</button>
                        </div>
                    </div>
                    <div class="p-0 overflow-x-auto min-h-[650px] custom-scrollbar">
                        <!-- Week View -->
                        <div x-show="calendarView === 'week'" class="grid grid-cols-7 divide-x divide-white/5">
                            <template x-for="day in weekDays" :key="day.date">
                                <div class="min-h-[500px] p-3 transition-colors hover:bg-white/[0.02]">
                                    <div class="text-center py-4 mb-6 rounded-2xl transition-all" :class="isToday(day.date) ? 'bg-blue-600/10 border border-blue-500/20 shadow-lg shadow-blue-500/5' : ''">
                                        <div class="text-[10px] font-black uppercase tracking-[0.2em]" :class="isToday(day.date) ? 'text-blue-400' : 'text-slate-500'" x-text="day.dayName"></div>
                                        <div class="text-xl font-black mt-1" :class="isToday(day.date) ? 'text-white' : 'text-slate-200'" x-text="day.dayNumber"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <template x-for="event in getEventsForDate(day.date)" :key="event.id + '-' + event.type">
                                            <div @click="openEventDetail(event)" 
                                                 class="p-4 rounded-xl text-[10px] border relative overflow-hidden leading-tight cursor-pointer hover:scale-[1.02] active:scale-95 transition-all group shadow-lg"
                                                 :class="event.className.replace('bg-', 'bg-').replace('border-', 'border-') + ' backdrop-blur-md'">
                                                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                                <div class="relative z-10 font-black text-white uppercase tracking-wider line-clamp-2" x-text="event.title"></div>
                                                <div class="relative z-10 opacity-70 mt-2 font-bold flex items-center gap-1.5">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    <span x-text="formatTime(event.start)"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <!-- Day View -->
                        <div x-show="calendarView === 'day'" class="p-10">
                            <div class="max-w-2xl mx-auto space-y-6">
                                <template x-for="event in getEventsForDate(selectedDate)" :key="event.id + '-' + event.type">
                                    <div @click="openEventDetail(event)" 
                                         class="group p-6 rounded-[2rem] border-l-4 shadow-2xl cursor-pointer hover:translate-x-2 transition-all flex items-center justify-between border-white/5 bg-slate-900/40 backdrop-blur-xl relative overflow-hidden"
                                         :class="event.className.replace('bg-', 'border-').replace('text-', 'text-')">
                                        <div class="absolute inset-0 bg-white/[0.02] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <div class="relative z-10">
                                            <div class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40 mb-2 flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full" :class="event.className"></div>
                                                <span x-text="event.type === 'task' ? 'Flux Opérationnel' : 'Activité Client'"></span>
                                            </div>
                                            <div class="text-base font-black text-white tracking-tight" x-text="event.title"></div>
                                        </div>
                                        <div class="relative z-10 flex items-center gap-3 bg-white/5 px-4 py-2 rounded-xl border border-white/5 font-black text-[10px] text-slate-400 group-hover:text-blue-400 group-hover:border-blue-500/30 transition-all">
                                            <svg class="w-4 h-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span x-text="formatTime(event.start)"></span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="getEventsForDate(selectedDate).length === 0">
                                    <div class="flex flex-col items-center justify-center py-32 text-slate-600">
                                        <div class="w-24 h-24 bg-white/5 rounded-[2.5rem] flex items-center justify-center mb-8 border border-white/5 shadow-inner">
                                            <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <p class="text-[10px] font-black uppercase tracking-[0.3em]">Aucune activité détectée</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanban Task Board (Default) -->
                <div x-show="!showFullCalendar" class="w-full">
                    <div class="overflow-x-auto pb-4 custom-scrollbar">
                        <div x-ref="taskBoard">
                            @include('tasks._board')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    console.log('Calendar scripts V5 active');
</script>
@endpush

<style>
[x-cloak] { display: none !important; }

/* Supprimer absolument toutes les barres de défilement horizontales */
html, body {
    overflow-x: hidden !important;
    width: 100%;
}

* {
    scrollbar-width: none !important; /* Firefox */
    -ms-overflow-style: none !important; /* IE 10+ */
}

::-webkit-scrollbar {
    width: 0px !important;
    height: 0px !important;
    display: none !important;
}

.custom-scrollbar {
    overflow-x: auto;
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.custom-scrollbar::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}
</style>
@endsection