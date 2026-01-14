@extends('layouts.app')

@section('title', 'Calendrier')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="calendarApp()">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                <div class="flex items-center space-x-3 sm:space-x-4 w-full sm:w-auto">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Calendrier</h1>
                    </div>
                    <button @click="showEventModal = true" class="px-3 py-1.5 bg-indigo-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-indigo-700 flex items-center space-x-2 shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Nouveau</span>
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <button @click="goToToday()" class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Aujourd'hui
                    </button>
                    
                    <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                        <button @click="previousPeriod()" class="px-2 sm:px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <div class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-gray-900 border-x border-gray-300 min-w-[160px] sm:min-w-[200px] text-center" x-text="currentPeriodLabel"></div>
                        <button @click="nextPeriod()" class="px-2 sm:px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button @click="currentView = 'month'" :class="currentView === 'month' ? 'bg-white shadow-sm' : ''" class="flex-1 sm:flex-none px-2 sm:px-3 py-1.5 text-xs sm:text-sm font-medium rounded-md">
                            Mois
                        </button>
                        <button @click="currentView = 'week'" :class="currentView === 'week' ? 'bg-white shadow-sm' : ''" class="flex-1 sm:flex-none px-2 sm:px-3 py-1.5 text-xs sm:text-sm font-medium rounded-md">
                            Semaine
                        </button>
                        <button @click="currentView = 'day'" :class="currentView === 'day' ? 'bg-white shadow-sm' : ''" class="flex-1 sm:flex-none px-2 sm:px-3 py-1.5 text-xs sm:text-sm font-medium rounded-md">
                            Jour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Calendar Area -->
            <div class="flex-1 min-w-0">
                <!-- Month View -->
                <div x-show="currentView === 'month'" class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Days of week header -->
                    <div class="grid grid-cols-7 border-b border-gray-200 bg-gray-50">
                        <template x-for="day in daysOfWeek" :key="day">
                            <div class="py-3 text-center text-sm font-semibold text-gray-700" x-text="day"></div>
                        </template>
                    </div>

                    <!-- Calendar grid -->
                    <div class="grid grid-cols-7 border-l border-t border-gray-200">
                        <template x-for="(day, index) in monthDays" :key="index">
                            <div class="min-h-[80px] border-r border-b border-gray-200 p-1"
                                 :class="{
                                     'bg-gray-50': !day.isCurrentMonth,
                                     'bg-blue-50': isToday(day.date),
                                     'bg-white': day.isCurrentMonth && !isToday(day.date)
                                 }">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-semibold"
                                          :class="{
                                              'text-gray-400': !day.isCurrentMonth,
                                              'text-white bg-indigo-600 rounded-full w-6 h-6 flex items-center justify-center': isToday(day.date),
                                              'text-gray-900': day.isCurrentMonth && !isToday(day.date)
                                          }"
                                          x-text="day.dayNumber"></span>
                                    <button @click="openEventModal(day.date)" class="text-gray-400 hover:text-indigo-600 opacity-0 hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="space-y-0.5">
                                    <template x-for="event in getEventsForDate(day.date).slice(0, 4)" :key="event.id">
                                        <div @click="openEventDetail(event)" 
                                             class="text-[10px] px-1 py-0.5 rounded cursor-pointer truncate leading-tight"
                                             :class="getEventColor(event.type)"
                                             x-text="event.title"></div>
                                    </template>
                                    <div x-show="getEventsForDate(day.date).length > 4" 
                                         class="text-[10px] text-gray-500 px-1 leading-tight">
                                        + <span x-text="getEventsForDate(day.date).length - 4"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Week View -->
                <div x-show="currentView === 'week'" class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="grid grid-cols-8 border-b border-gray-200">
                        <div class="bg-gray-50 border-r border-gray-200 p-4"></div>
                        <template x-for="day in weekDays" :key="day.date">
                            <div class="text-center py-4 border-r border-gray-200 bg-gray-50"
                                 :class="{'bg-blue-50': isToday(day.date)}">
                                <div class="text-xs font-semibold text-gray-500 uppercase" x-text="day.dayName"></div>
                                <div class="text-2xl font-bold mt-1"
                                     :class="{'text-white bg-indigo-600 rounded-full w-10 h-10 flex items-center justify-center mx-auto': isToday(day.date)}"
                                     x-text="day.dayNumber"></div>
                            </div>
                        </template>
                    </div>

                    <div class="grid grid-cols-8 divide-x divide-gray-200" style="height: 600px;">
                        <div class="bg-gray-50">
                            <template x-for="hour in hours" :key="hour">
                                <div class="h-16 border-b border-gray-200 px-2 py-1 text-xs text-gray-500 text-right" x-text="hour"></div>
                            </template>
                        </div>
                        
                        <template x-for="day in weekDays" :key="day.date">
                            <div class="relative border-r border-gray-200 bg-white">
                                <template x-for="hour in hours" :key="hour">
                                    <div class="h-16 border-b border-gray-100"></div>
                                </template>
                                
                                <template x-for="event in getEventsForDate(day.date)" :key="event.id">
                                    <div @click="openEventDetail(event)"
                                         class="absolute left-1 right-1 px-2 py-1 rounded text-xs cursor-pointer overflow-hidden"
                                         :class="getEventColor(event.type)"
                                         :style="`top: ${getEventTop(event.start)}px; height: ${getEventHeight(event.start, event.end)}px;`">
                                        <div class="font-semibold truncate" x-text="event.title"></div>
                                        <div class="text-xs opacity-90" x-text="formatTimeRange(event.start, event.end)"></div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Day View -->
                <div x-show="currentView === 'day'" class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="grid grid-cols-2 border-b border-gray-200">
                        <div class="bg-gray-50 border-r border-gray-200 p-4"></div>
                        <div class="text-center py-4 bg-gray-50"
                             :class="{'bg-blue-50': isToday(currentDate)}">
                            <div class="text-xs font-semibold text-gray-500 uppercase" x-text="formatDayName(currentDate)"></div>
                            <div class="text-3xl font-bold mt-1"
                                 :class="{'text-white bg-indigo-600 rounded-full w-12 h-12 flex items-center justify-center mx-auto': isToday(currentDate)}"
                                 x-text="new Date(currentDate).getDate()"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 divide-x divide-gray-200" style="height: 700px; overflow-y: auto;">
                        <div class="bg-gray-50">
                            <template x-for="hour in hours" :key="hour">
                                <div class="h-20 border-b border-gray-200 px-4 py-2 text-sm text-gray-600 text-right" x-text="hour"></div>
                            </template>
                        </div>
                        
                        <div class="relative bg-white">
                            <template x-for="hour in hours" :key="hour">
                                <div class="h-20 border-b border-gray-100"></div>
                            </template>
                            
                            <template x-for="event in getEventsForDate(currentDate)" :key="event.id">
                                <div @click="openEventDetail(event)"
                                     class="absolute left-2 right-2 px-3 py-2 rounded cursor-pointer overflow-hidden"
                                     :class="getEventColor(event.type)"
                                     :style="`top: ${getEventTop(event.start)}px; height: ${getEventHeight(event.start, event.end)}px;`">
                                    <div class="font-semibold" x-text="event.title"></div>
                                    <div class="text-sm opacity-90" x-text="formatTimeRange(event.start, event.end)"></div>
                                    <div x-show="event.description" class="text-sm mt-1 opacity-80" x-text="event.description"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Legend & Upcoming) -->
            <div class="lg:w-72 flex-shrink-0 space-y-6">
                
                <!-- Legend -->
                <div class="bg-white rounded-lg shadow p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Légende</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-blue-500 mr-3"></span>
                            <span class="text-sm text-gray-600">Tâche</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-indigo-500 mr-3"></span>
                            <span class="text-sm text-gray-600">Appel</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-purple-500 mr-3"></span>
                            <span class="text-sm text-gray-600">Email</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-amber-500 mr-3"></span>
                            <span class="text-sm text-gray-600">Réunion</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-gray-500 mr-3"></span>
                            <span class="text-sm text-gray-600">Note</span>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-gray-900">Prochains événements</h3>
                        <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full font-medium" x-text="upcomingEvents.length"></span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <template x-for="event in upcomingEvents" :key="event.id">
                            <div class="p-4 hover:bg-gray-50 transition-colors cursor-pointer" @click="openEventDetail(event)">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 mt-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full block border border-transparent shadow-sm"
                                              :class="{
                                                'bg-blue-500': event.type === 'task',
                                                'bg-indigo-500': event.type === 'call',
                                                'bg-purple-500': event.type === 'email',
                                                'bg-amber-500': event.type === 'meeting',
                                                'bg-gray-500': event.type === 'note'
                                              }"></span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="event.title"></p>
                                        <div class="flex items-center mt-1 text-xs text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span x-text="formatDateShort(event.start)"></span>
                                            <span class="mx-1">•</span>
                                            <span x-text="formatTime(event.start)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div x-show="upcomingEvents.length === 0" class="p-8 text-center bg-gray-50/50">
                            <p class="text-sm text-gray-500 italic">Aucun événement à venir</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div x-show="showEventModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.self="showEventModal = false">
        <div class="flex items-center justify-center min-h-screen px-4 sm:px-6">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Nouvel événement</h3>
                    <button @click="showEventModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="saveEvent()">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                            <input x-model="newEvent.title" type="text" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                <input x-model="newEvent.startDate" type="date" required
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Heure de début</label>
                                <input x-model="newEvent.startTime" type="time" required
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                <input x-model="newEvent.endDate" type="date" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Heure de fin</label>
                                <input x-model="newEvent.endTime" type="time" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select x-model="newEvent.type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="task">Tâche</option>
                                <option value="call">Appel</option>
                                <option value="email">Email</option>
                                <option value="meeting">Réunion</option>
                                <option value="note">Note</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea x-model="newEvent.description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" @click="showEventModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div x-show="showEventDetail" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.self="showEventDetail = false">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full p-6" x-show="selectedEvent">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="selectedEvent?.title"></h3>
                    <button @click="showEventDetail = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-gray-700" x-text="selectedEvent ? formatTimeRange(selectedEvent.start, selectedEvent.end) : ''"></span>
                    </div>

                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="text-sm px-3 py-1 rounded-full font-medium"
                              :class="selectedEvent ? getEventColor(selectedEvent.type) : ''"
                              x-text="selectedEvent?.type"></span>
                    </div>

                    <div x-show="selectedEvent?.description" class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-700" x-text="selectedEvent?.description"></p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button @click="deleteEvent(selectedEvent?.id)"
                            class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100">
                        Supprimer
                    </button>
                    <button @click="showEventDetail = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
window.calendarApp = function() {
    return {
        currentView: 'month',
        currentDate: new Date(),
        showEventModal: false,
        showEventDetail: false,
        selectedEvent: null,
        
        events: @json($events ?? []),
        
        newEvent: {
            title: '',
            startDate: '',
            startTime: '09:00',
            endDate: '',
            endTime: '10:00',
            type: 'meeting',
            description: ''
        },

        daysOfWeek: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        hours: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'],

        monthDays: [],
        weekDays: [],
        upcomingEvents: [],

        init() {
            this.generateMonthDays();
            this.generateWeekDays();
            this.updateUpcomingEvents();
            
            // Set default dates for new event
            const today = new Date();
            this.newEvent.startDate = this.formatDate(today);
            this.newEvent.endDate = this.formatDate(today);
        },

        get currentPeriodLabel() {
            if (this.currentView === 'month') {
                return this.currentDate.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });
            } else if (this.currentView === 'week') {
                const weekStart = this.getWeekStart(this.currentDate);
                const weekEnd = new Date(weekStart);
                weekEnd.setDate(weekEnd.getDate() + 6);
                return `${weekStart.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })} - ${weekEnd.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' })}`;
            } else {
                return this.currentDate.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            }
        },

        generateMonthDays() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            
            let startDay = firstDay.getDay();
            startDay = startDay === 0 ? 6 : startDay - 1;
            
            this.monthDays = [];
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = startDay - 1; i >= 0; i--) {
                const date = new Date(year, month - 1, prevMonthLastDay - i);
                this.monthDays.push({ dayNumber: date.getDate(), date: this.formatDate(date), isCurrentMonth: false });
            }
            for (let i = 1; i <= lastDay.getDate(); i++) {
                const date = new Date(year, month, i);
                this.monthDays.push({ dayNumber: i, date: this.formatDate(date), isCurrentMonth: true });
            }
            const remainingDays = 42 - this.monthDays.length;
            for (let i = 1; i <= remainingDays; i++) {
                const date = new Date(year, month + 1, i);
                this.monthDays.push({ dayNumber: i, date: this.formatDate(date), isCurrentMonth: false });
            }
        },

        generateWeekDays() {
            const weekStart = this.getWeekStart(this.currentDate);
            this.weekDays = [];
            for (let i = 0; i < 7; i++) {
                const date = new Date(weekStart);
                date.setDate(date.getDate() + i);
                this.weekDays.push({ date: this.formatDate(date), dayNumber: date.getDate(), dayName: date.toLocaleDateString('fr-FR', { weekday: 'short' }) });
            }
        },

        getWeekStart(date) {
            const d = new Date(date);
            const day = d.getDay();
            const diff = d.getDate() - day + (day === 0 ? -6 : 1);
            return new Date(d.setDate(diff));
        },

        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        formatDayName(dateStr) { return new Date(dateStr).toLocaleDateString('fr-FR', { weekday: 'long' }); },
        formatTimeRange(start, end) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            return `${startDate.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })} - ${endDate.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;
        },
        isToday(dateStr) { return dateStr === this.formatDate(new Date()); },
        
        getEventsForDate(dateStr) {
            return this.events.filter(event => {
                const eventDate = new Date(event.start);
                return this.formatDate(eventDate) === dateStr;
            });
        },

        updateUpcomingEvents() {
            const now = new Date();
            this.upcomingEvents = this.events
                .filter(e => new Date(e.start) >= now)
                .sort((a, b) => new Date(a.start) - new Date(b.start))
                .slice(0, 5);
        },

        formatDateShort(dateStr) { const date = new Date(dateStr); return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' }); },
        formatTime(dateStr) { const d = new Date(dateStr); return d.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }); },
        
        getEventColor(type) {
            const colors = { task: 'bg-blue-100 text-blue-700 border-blue-200', call: 'bg-indigo-100 text-indigo-700 border-indigo-200', email: 'bg-purple-100 text-purple-700 border-purple-200', meeting: 'bg-amber-100 text-amber-700 border-amber-200', note: 'bg-gray-100 text-gray-700 border-gray-200' };
            return colors[type] || colors.note;
        },

        getEventTop(startTime) {
            const date = new Date(startTime);
            const hours = date.getHours();
            const minutes = date.getMinutes();
            return (hours * 64) + (minutes * 64 / 60);
        },

        getEventHeight(startTime, endTime) {
            const start = new Date(startTime);
            const end = new Date(endTime);
            const diffMinutes = (end - start) / 1000 / 60;
            return Math.max((diffMinutes * 64 / 60), 32);
        },

        previousPeriod() {
            if (this.currentView === 'month') {
                this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
                this.generateMonthDays();
            } else if (this.currentView === 'week') {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() - 7));
                this.generateWeekDays();
            } else {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() - 1));
            }
        },

        nextPeriod() {
            if (this.currentView === 'month') {
                this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
                this.generateMonthDays();
            } else if (this.currentView === 'week') {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() + 7));
                this.generateWeekDays();
            } else {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() + 1));
            }
        },

        goToToday() {
            this.currentDate = new Date();
            if (this.currentView === 'month') { this.generateMonthDays(); }
            else if (this.currentView === 'week') { this.generateWeekDays(); }
        },

        openEventModal(date) {
            this.newEvent.startDate = date;
            this.newEvent.endDate = date;
            this.showEventModal = true;
        },

        openEventDetail(event) {
            this.selectedEvent = event;
            this.showEventDetail = true;
        },

        saveEvent() {
            const newEvent = {
                id: Date.now(),
                title: this.newEvent.title,
                start: `${this.newEvent.startDate}T${this.newEvent.startTime}`,
                end: `${this.newEvent.endDate}T${this.newEvent.endTime}`,
                type: this.newEvent.type,
                description: this.newEvent.description
            };

            this.events.push(newEvent);
            this.updateUpcomingEvents();
            
            // Reset form
            this.newEvent = {
                title: '',
                startDate: this.formatDate(new Date()),
                startTime: '09:00',
                endDate: this.formatDate(new Date()),
                endTime: '10:00',
                type: 'meeting',
                description: ''
            };
            
            this.showEventModal = false;
        },

        deleteEvent(eventId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
                this.events = this.events.filter(e => e.id !== eventId);
                this.updateUpcomingEvents();
                this.showEventDetail = false;
            }
        }
    }
}
</script>
@endpush

<style>
[x-cloak] {
    display: none !important;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth transitions */
* {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
    transition-duration: 150ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Calendar cell hover effects */
.min-h-\[120px\]:hover {
    transform: scale(1.02);
    z-index: 10;
}

/* Event hover effects */
.cursor-pointer:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>

@endsection