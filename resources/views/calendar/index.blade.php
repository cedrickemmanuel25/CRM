@extends('layouts.app')

@section('title', 'Calendrier & Tâches')

@section('content')
<div class="min-h-screen bg-slate-50" x-data="unifiedTaskApp()">
    
    <!-- Top Header -->
    <div class="bg-white border-b border-slate-200 sticky top-16 z-30">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Agenda & Tâches</h1>
                        <p class="text-sm text-slate-500" x-text="selectedDateLabel"></p>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button @click="openTaskModal = true" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Nouvelle Tâche</span>
                    </button>
                    <button @click="showFullCalendar = !showFullCalendar" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                        <span x-text="showFullCalendar ? 'Vue Kanban' : 'Vue Agenda'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            
            <!-- Left Sidebar: Mini Calendar -->
            <div class="w-full lg:w-80 flex-shrink-0 space-y-6">
                
                <!-- Mini Calendar Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-900" x-text="currentMonthLabel"></h3>
                        <div class="flex gap-1">
                            <button @click="prevMonth()" class="p-1.5 hover:bg-white rounded-lg transition-colors text-slate-500 border border-transparent hover:border-slate-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button @click="nextMonth()" class="p-1.5 hover:bg-white rounded-lg transition-colors text-slate-500 border border-transparent hover:border-slate-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-3">
                        <div class="grid grid-cols-7 mb-2">
                            <template x-for="day in ['L','M','M','J','V','S','D']">
                                <div class="text-[10px] font-bold text-slate-400 text-center py-1 uppercase tracking-wider" x-text="day"></div>
                            </template>
                        </div>
                        <div class="grid grid-cols-7 gap-px">
                            <template x-for="day in monthDays" :key="day.date">
                                <button @click="selectDate(day.date)" 
                                        class="aspect-square flex flex-col items-center justify-center rounded-lg text-xs transition-all relative group"
                                        :class="{
                                            'text-slate-300': !day.isCurrentMonth,
                                            'bg-indigo-600 text-white font-bold shadow-md shadow-indigo-100': isSelected(day.date),
                                            'hover:bg-slate-100 text-slate-700': day.isCurrentMonth && !isSelected(day.date),
                                            'ring-1 ring-inset ring-indigo-200': isToday(day.date) && !isSelected(day.date)
                                        }">
                                    <span x-text="day.dayNumber"></span>
                                    <!-- Indicator for events -->
                                    <div x-show="hasEvents(day.date)" 
                                         class="w-1 h-1 rounded-full mt-0.5"
                                         :class="isSelected(day.date) ? 'bg-white' : 'bg-indigo-400'"></div>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Legend Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hidden lg:block">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Légende</h3>
                    <div class="space-y-3">
                        <template x-for="(color, type) in legend" :key="type">
                            <div class="flex items-center gap-3">
                                <span class="w-2.5 h-2.5 rounded-full" :class="color"></span>
                                <span class="text-sm text-slate-600 capitalize" x-text="type"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Main Content: Task Board or Full Calendar -->
            <div class="flex-1 min-w-0 w-full">
                
                <!-- Full Calendar View (Alt) -->
                <div x-show="showFullCalendar" x-cloak class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-bold text-slate-900" x-text="calendarView === 'week' ? 'Agenda hebdomadaire' : 'Agenda du jour'"></h2>
                        <div class="flex bg-slate-100 rounded-lg p-1">
                            <button @click="calendarView = 'week'" :class="calendarView === 'week' ? 'bg-white shadow-sm' : ''" class="px-3 py-1 text-xs font-semibold rounded-md transition-all">Semaine</button>
                            <button @click="calendarView = 'day'" :class="calendarView === 'day' ? 'bg-white shadow-sm' : ''" class="px-3 py-1 text-xs font-semibold rounded-md transition-all">Jour</button>
                        </div>
                    </div>
                    <div class="p-0 overflow-x-auto min-h-[600px]">
                        <!-- Week View -->
                        <div x-show="calendarView === 'week'" class="grid grid-cols-7 divide-x divide-slate-100">
                            <template x-for="day in weekDays" :key="day.date">
                                <div class="min-h-[500px] p-2">
                                    <div class="text-center py-2 mb-3 rounded-lg" :class="isToday(day.date) ? 'bg-indigo-50' : ''">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase" x-text="day.dayName"></div>
                                        <div class="text-sm font-bold" :class="isToday(day.date) ? 'text-indigo-600' : 'text-slate-700'" x-text="day.dayNumber"></div>
                                    </div>
                                    <div class="space-y-2">
                                        <template x-for="event in getEventsForDate(day.date)" :key="event.id + '-' + event.type">
                                            <div @click="openEventDetail(event)" 
                                                 class="p-2 rounded-lg text-[10px] border leading-tight cursor-pointer hover:scale-[1.02] transition-transform"
                                                 :class="event.className">
                                                <div class="font-bold truncate" x-text="event.title"></div>
                                                <div class="opacity-80 mt-1" x-text="formatTime(event.start)"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <!-- Day View -->
                        <div x-show="calendarView === 'day'" class="p-6">
                            <div class="max-w-xl mx-auto">
                                <template x-for="event in getEventsForDate(selectedDate)" :key="event.id + '-' + event.type">
                                    <div @click="openEventDetail(event)" 
                                         class="mb-3 p-4 rounded-xl border-l-4 shadow-sm cursor-pointer hover:translate-x-1 transition-transform flex items-center justify-between"
                                         :class="event.className + ' border-slate-200 bg-white'">
                                        <div>
                                            <div class="text-xs font-bold uppercase opacity-60 mb-1" x-text="event.type === 'task' ? 'Tâche' : 'Activité'"></div>
                                            <div class="text-sm font-bold text-slate-900" x-text="event.title"></div>
                                        </div>
                                        <div class="text-xs font-medium text-slate-500 whitespace-nowrap ml-4" x-text="formatTime(event.start)"></div>
                                    </div>
                                </template>
                                <template x-if="getEventsForDate(selectedDate).length === 0">
                                    <div class="text-center py-20 text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <p>Aucun événement pour ce jour</p>
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

    <!-- Task Creation Modal -->
    <div x-show="openTaskModal" x-cloak class="fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 p-4">
            <div @click="openTaskModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden" x-show="openTaskModal" x-transition>
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900">Nouvelle tâche</h3>
                    <button @click="openTaskModal = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
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

    <!-- Event Detail Modal -->
    <div x-show="selectedEvent" x-cloak class="fixed inset-0 z-[70] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 p-4">
            <div @click="selectedEvent = null" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden" x-show="selectedEvent" x-transition>
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between" :class="selectedEvent?.className">
                    <h3 class="text-lg font-bold text-white" x-text="selectedEvent?.type === 'task' ? 'Détails de la tâche' : 'Détails de l\'activité'"></h3>
                    <button @click="selectedEvent = null" class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Titre / Description</label>
                        <p class="text-slate-900 font-semibold" x-text="selectedEvent?.title"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Date</label>
                            <p class="text-slate-700 text-sm" x-text="new Date(selectedEvent?.start).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' })"></p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Heure</label>
                            <p class="text-slate-700 text-sm" x-text="formatTime(selectedEvent?.start)"></p>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <template x-if="selectedEvent?.type === 'task'">
                            <a :href="'/tasks/' + selectedEvent.id" class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition-colors">Voir la tâche</a>
                        </template>
                        <button @click="selectedEvent = null" class="ml-3 px-4 py-2 bg-slate-100 text-slate-600 text-sm font-bold rounded-lg hover:bg-slate-200 transition-colors">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
window.unifiedTaskApp = function() {
    return {
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
            this.generateMonthDays();
            this.generateWeekDays();
            this.startPolling();
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
            startDay = startDay === 0 ? 6 : startDay - 1; // Mon-Sun
            
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
        hasEvents(date) {
            return this.events.some(e => e.start.startsWith(date));
        },
        
        getEventsForDate(date) {
            return this.events.filter(e => e.start.startsWith(date));
        },

        openEventDetail(event) {
            this.selectedEvent = event;
        },
        
        formatTime(dateStr) {
            return new Date(dateStr).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        },
        
        prevMonth() { this.currentMonth.setMonth(this.currentMonth.getMonth() - 1); this.generateMonthDays(); },
        nextMonth() { this.currentMonth.setMonth(this.currentMonth.getMonth() + 1); this.generateMonthDays(); },
        
        selectDate(date) {
            this.selectedDate = date;
            this.generateWeekDays();
            this.fetchTasks();
        },
        
        async fetchTasks() {
            const url = new URL(window.location.href);
            url.searchParams.set('date', this.selectedDate);
            
            try {
                const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await response.json();
                this.$refs.taskBoard.innerHTML = data.html;
                this.events = data.events;
            } catch (error) {
                console.error('Error fetching tasks:', error);
            }
        },
        
        startPolling() {
            setInterval(() => this.fetchTasks(), 10000);
        }
    }
}
</script>
@endpush

<style>
[x-cloak] { display: none !important; }
.custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endsection