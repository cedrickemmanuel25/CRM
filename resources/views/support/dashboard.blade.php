@extends('layouts.app')

@section('title', 'Centre de Support - Nexus CRM')

@section('content')
@php
    $contacts = $data['contacts'] ?? [];
    $users = $data['users'] ?? [];
@endphp
<div class="min-h-screen bg-gray-50/50 p-6" x-data="{ openTicketModal: false }">
    <div class="max-w-[1600px] mx-auto space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Centre de Support
                </h2>
                <p class="mt-1 text-sm text-gray-500">Vue d'ensemble de l'activité du support client.</p>
            </div>
            <div class="flex items-center gap-3">                <a href="{{ route('support.reports.pdf', ['period' => 'day']) }}"                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-rose-600 to-red-600 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white hover:from-rose-700 hover:to-red-700 transition-all duration-200 hover:shadow-xl transform hover:-translate-y-0.5">                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />                    </svg>                    Télécharger PDF                </a>                <div class="flex items-center gap-3">
                <button @click="openTicketModal = true" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:from-indigo-700 hover:to-blue-700 transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau Ticket
                </button>
            </div>
        </div>

        <!-- KPIs Grid - Style Admin -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Tickets in Progress -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Tickets en cours</p>
                    <div class="p-2 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors">
                         <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['tickets_in_progress'] }}</p>
                </div>
            </div>

            <!-- Active Interactions -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Interactions Actives</p>
                    <div class="p-2 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['interactions_in_progress'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Resolved Today -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Résolus Aujourd'hui</p>
                    <div class="p-2 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 transition-colors">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['resolved_today'] }}</p>
                </div>
            </div>

            <!-- Active Tickets (Total excluding Closed) -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Tickets Actifs</p>
                    <div class="p-2 bg-amber-50 rounded-lg group-hover:bg-amber-100 transition-colors">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['total_active_tickets'] }}</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Status Distribution -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Répartition par Statut</h3>
                </div>
                <div class="relative h-[300px]">
                    <canvas id="ticketStatusChart"></canvas>
                </div>
            </div>

            <!-- Priority Distribution -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Distribution des Priorités</h3>
                </div>
                <div class="relative h-[300px]">
                    <canvas id="ticketPriorityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Main Content Area: 2/3 Table + 1/3 Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Ticket Queue (2/3) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">File d'attente</h3>
                            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider font-semibold">Derniers tickets mis à jour</p>
                        </div>
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-xs font-bold text-gray-600 rounded-lg transition-colors border border-gray-200">
                            VOIR TOUT
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Sujet</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Client</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Priorité</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($data['lists']['recent_tickets'] as $ticket)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="max-w-[200px]">
                                             <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-indigo-600 transition-colors">{{ $ticket->subject }}</p>
                                             <p class="text-[11px] text-gray-400 font-medium uppercase mt-1">{{ $ticket->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs font-bold ring-2 ring-white shadow-sm">
                                                {{ substr($ticket->contact->nom ?? 'C', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $ticket->contact->nom_complet ?? 'Inconnu' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'urgent' => 'bg-rose-100 text-rose-800 border-rose-200',
                                                'high' => 'bg-orange-100 text-orange-800 border-orange-200',
                                                'medium' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'low' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            ];
                                            $colorClass = $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="px-2.5 py-1 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-full border {{ $colorClass }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'nouveau' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                'en_cours' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'resolu' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'attente_client' => 'bg-purple-50 text-purple-700 border-purple-100',
                                                'ferme' => 'bg-gray-50 text-gray-600 border-gray-100',
                                            ];
                                            $statusClass = $statusColors[$ticket->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border {{ $statusClass }}">
                                            {{ str_replace('_', ' ', $ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 text-xs font-bold uppercase tracking-wider hover:underline">Ouvrir</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <p class="text-gray-500 font-medium">Aucun ticket récent</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar (1/3) -->
            <div class="space-y-8">
                
                <!-- Daily Activities Widget -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Activités Récentes</h3>
                    <div class="space-y-6 relative before:absolute before:inset-0 before:left-[11px] before:border-l-2 before:border-gray-100">
                        @forelse($data['lists']['recent_activities'] as $activity)
                            <div class="relative flex gap-4 pl-1 group">
                                <div class="h-5 w-5 rounded-full bg-white border-4 border-gray-100 ring-2 ring-gray-50 z-10 flex-shrink-0 group-hover:border-indigo-100 group-hover:ring-indigo-50 transition-colors"></div>
                                <div class="flex-1 min-w-0 -mt-0.5">
                                    <p class="text-[13px] text-gray-600 leading-snug">
                                        <span class="font-bold text-gray-900">{{ $activity->user->name ?? 'Système' }}</span> : {{ $activity->description }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 tracking-wider">{{ $activity->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-center text-gray-400 italic py-4 relative z-10 bg-white">Aucune activité aujourd'hui.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Assigned Tasks Widget -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">À faire</h3>
                        <a href="{{ route('tasks.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider">Voir tout</a>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($data['lists']['tasks'] as $task)
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-gray-50 transition-all border border-gray-100 group">
                            <div class="h-8 w-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $task->titre }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] text-gray-500 font-medium uppercase">{{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d M') }}</span>
                                    <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                    <span class="text-[10px] text-gray-400 font-medium uppercase">{{ $task->priority ?? 'Normale' }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs text-gray-400 italic">Aucune tâche assignée.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Nouveau Ticket -->
    <div x-show="openTicketModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div x-show="openTicketModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"
                 @click="openTicketModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="openTicketModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900" id="modal-title">Nouveau ticket</h3>
                            <p class="text-xs text-slate-600 mt-0.5">Les champs marqués <span class="text-rose-600 font-bold">*</span> sont obligatoires.</p>
                        </div>
                    </div>
                    <button @click="openTicketModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form Content -->
                <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                    @include('tickets.partials._form', ['isModal' => true])
                </div>

                <!-- Footer Actions -->
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex items-center justify-end gap-3">
                    <button @click="openTicketModal = false" type="button" class="px-4 py-2.5 text-sm font-semibold text-slate-700 hover:text-slate-900 rounded-lg hover:bg-white transition">
                        Annuler
                    </button>
                    <button type="submit" form="create-ticket-form" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 border border-transparent shadow-md text-sm font-bold rounded-lg text-white hover:from-indigo-700 hover:to-blue-700 focus:outline-none transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Créer le ticket
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('create-ticket-form');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Création...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                form.submit();
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    });
</script>
@endpush
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status Chart (Doughnut)
        const statusCtx = document.getElementById('ticketStatusChart').getContext('2d');
        const statusData = @json($data['charts']['ticket_status']);
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData).map(k => k.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: ['#3B82F6', '#F59E0B', '#10B981', '#8B5CF6', '#9CA3AF'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: { size: 11, family: "'Inter', sans-serif", weight: '600' },
                            color: '#6B7280'
                        }
                    }
                }
            }
        });

        // Priority Chart (Bar)
        const priorityCtx = document.getElementById('ticketPriorityChart').getContext('2d');
        const priorityData = @json($data['charts']['ticket_priority']);
        
        new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(priorityData).map(k => k.toUpperCase()),
                datasets: [{
                    label: 'Tickets',
                    data: Object.values(priorityData),
                    backgroundColor: ['#F43F5E', '#F97316', '#3B82F6', '#10B981'],
                    borderRadius: 6,
                    maxBarThickness: 32,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { size: 10, family: "'Inter', sans-serif" },
                            color: '#9CA3AF',
                            stepSize: 1
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, family: "'Inter', sans-serif", weight: '600' },
                            color: '#6B7280'
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush

