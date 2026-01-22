@extends('layouts.app')

@section('title', 'Centre de Support - Nexus CRM')

@section('content')
@php
    $contacts = $data['contacts'] ?? [];
    $users = $data['users'] ?? [];
@endphp
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 p-6" x-data="{ openTicketModal: false, activeFilter: 'all' }">
    <div class="max-w-[1800px] mx-auto space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black tracking-tight bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">
                    Centre de Support
                </h2>
                <p class="mt-2 text-sm font-semibold text-slate-600">Vue d'ensemble de l'activité du support client</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('support.reports.pdf', ['period' => 'day']) }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-rose-600 to-red-600 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white hover:from-rose-700 hover:to-red-700 transition-all duration-200 hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Télécharger PDF
                </a>
                <button @click="openTicketModal = true" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white hover:from-indigo-700 hover:to-blue-700 transition-all duration-200 hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau Ticket
                </button>
            </div>
        </div>

        <!-- KPIs Grid - Enhanced -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Tickets Nouveaux -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-blue-50/50 p-6 shadow-lg border border-indigo-100/50 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nouveaux</p>
                    <div class="p-2.5 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl group-hover:from-blue-200 group-hover:to-indigo-200 transition-all shadow-sm">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-4xl font-black text-slate-900">{{ $data['kpis']['tickets_new'] ?? 0 }}</p>
                    <span class="text-xs font-bold text-slate-500">tickets</span>
                </div>
                <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full" style="width: {{ min(100, (($data['kpis']['tickets_new'] ?? 0) / max(1, ($data['kpis']['total_active_tickets'] ?? 1))) * 100) }}%"></div>
                </div>
            </div>

            <!-- Tickets en Cours -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-amber-50/50 p-6 shadow-lg border border-amber-100/50 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">En Cours</p>
                    <div class="p-2.5 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl group-hover:from-amber-200 group-hover:to-orange-200 transition-all shadow-sm">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-4xl font-black text-slate-900">{{ $data['kpis']['tickets_in_progress'] ?? 0 }}</p>
                    <span class="text-xs font-bold text-slate-500">tickets</span>
                </div>
                <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-500 to-orange-500 rounded-full" style="width: {{ min(100, (($data['kpis']['tickets_in_progress'] ?? 0) / max(1, ($data['kpis']['total_active_tickets'] ?? 1))) * 100) }}%"></div>
                </div>
            </div>

            <!-- Tickets Urgents -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-rose-50/50 p-6 shadow-lg border border-rose-100/50 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Urgents</p>
                    <div class="p-2.5 bg-gradient-to-br from-rose-100 to-red-100 rounded-xl group-hover:from-rose-200 group-hover:to-red-200 transition-all shadow-sm">
                        <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-4xl font-black text-slate-900">{{ $data['kpis']['tickets_urgent'] ?? 0 }}</p>
                    <span class="text-xs font-bold text-slate-500">tickets</span>
                </div>
                <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-rose-500 to-red-500 rounded-full" style="width: {{ min(100, (($data['kpis']['tickets_urgent'] ?? 0) / max(1, ($data['kpis']['total_active_tickets'] ?? 1))) * 100) }}%"></div>
                </div>
            </div>

            <!-- Résolus Aujourd'hui -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-emerald-50/50 p-6 shadow-lg border border-emerald-100/50 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Résolus Aujourd'hui</p>
                    <div class="p-2.5 bg-gradient-to-br from-emerald-100 to-green-100 rounded-xl group-hover:from-emerald-200 group-hover:to-green-200 transition-all shadow-sm">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-4xl font-black text-slate-900">{{ $data['kpis']['resolved_today'] ?? 0 }}</p>
                    <span class="text-xs font-bold text-slate-500">tickets</span>
                </div>
                <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-green-500 rounded-full" style="width: {{ min(100, (($data['kpis']['resolved_today'] ?? 0) / max(1, ($data['kpis']['total_active_tickets'] ?? 1))) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Secondary KPIs Row -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Tickets Non Assignés -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-slate-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Non Assignés</p>
                    <div class="p-2 bg-slate-100 rounded-lg">
                        <svg class="h-4 w-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900">{{ $data['kpis']['tickets_unassigned'] ?? 0 }}</p>
            </div>

            <!-- Temps Moyen de Résolution -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-slate-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Temps Moyen</p>
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900">{{ $data['kpis']['avg_resolution_time'] ?? 0 }}<span class="text-sm font-semibold text-slate-500 ml-1">h</span></p>
            </div>

            <!-- Total Actifs -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-slate-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Actifs</p>
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900">{{ $data['kpis']['total_active_tickets'] ?? 0 }}</p>
            </div>

            <!-- Taux de Satisfaction -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-slate-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Satisfaction</p>
                    <div class="p-2 bg-emerald-100 rounded-lg">
                        <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900">{{ $data['kpis']['satisfaction_rate'] ?? 0 }}<span class="text-sm font-semibold text-slate-500 ml-1">%</span></p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Status Distribution -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200/50 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Répartition par Statut</h3>
                        <p class="text-xs text-slate-500 mt-1 font-semibold">Distribution des tickets</p>
                    </div>
                </div>
                <div class="relative h-[320px]">
                    <canvas id="ticketStatusChart"></canvas>
                </div>
            </div>

            <!-- Priority Distribution -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200/50 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Distribution des Priorités</h3>
                        <p class="text-xs text-slate-500 mt-1 font-semibold">Répartition par niveau</p>
                    </div>
                </div>
                <div class="relative h-[320px]">
                    <canvas id="ticketPriorityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Main Content Area: 2/3 Table + 1/3 Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Ticket Queue (2/3) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200/50 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-black text-slate-900">File d'attente</h3>
                                <p class="text-xs text-slate-500 mt-1 uppercase tracking-wider font-bold">Derniers tickets mis à jour</p>
                            </div>
                            <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-xs font-bold rounded-lg hover:from-indigo-700 hover:to-blue-700 transition-all shadow-sm">
                                VOIR TOUT
                            </a>
                        </div>
                        
                        <!-- Quick Filters -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <button @click="activeFilter = 'all" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all" :class="activeFilter === 'all' ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                                Tous
                            </button>
                            <button @click="activeFilter = 'urgent'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all" :class="activeFilter === 'urgent' ? 'bg-gradient-to-r from-rose-600 to-red-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                                Urgents
                            </button>
                            <button @click="activeFilter = 'unassigned'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all" :class="activeFilter === 'unassigned' ? 'bg-gradient-to-r from-amber-600 to-orange-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                                Non assignés
                            </button>
                            <button @click="activeFilter = 'new'" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all" :class="activeFilter === 'new' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                                Nouveaux
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Sujet</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Client</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Assigné à</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Priorité</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($data['lists']['recent_tickets'] as $ticket)
                                <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50/30 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="max-w-[200px]">
                                             <p class="text-sm font-bold text-slate-900 truncate group-hover:text-indigo-600 transition-colors">{{ $ticket->subject }}</p>
                                             <p class="text-[11px] text-slate-400 font-semibold uppercase mt-1">{{ $ticket->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center text-indigo-600 text-xs font-black ring-2 ring-white shadow-sm">
                                                {{ substr($ticket->contact->nom ?? 'C', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-semibold text-slate-700">{{ $ticket->contact->nom_complet ?? 'Inconnu' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->assignee)
                                        <div class="flex items-center gap-2">
                                            <div class="h-7 w-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-xs font-bold">
                                                {{ substr($ticket->assignee->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-semibold text-slate-700">{{ $ticket->assignee->name ?? 'N/A' }}</span>
                                        </div>
                                        @else
                                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Non assigné</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'urgent' => 'bg-gradient-to-r from-rose-100 to-red-100 text-rose-800 border-rose-200',
                                                'high' => 'bg-gradient-to-r from-orange-100 to-amber-100 text-orange-800 border-orange-200',
                                                'medium' => 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-blue-200',
                                                'low' => 'bg-slate-100 text-slate-800 border-slate-200',
                                            ];
                                            $colorClass = $priorityColors[$ticket->priority] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                        @endphp
                                        <span class="px-3 py-1.5 inline-flex text-[10px] font-black uppercase tracking-widest rounded-full border {{ $colorClass }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'new' => 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border-blue-100',
                                                'in_progress' => 'bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border-amber-100',
                                                'resolved' => 'bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-700 border-emerald-100',
                                                'waiting_client' => 'bg-gradient-to-r from-purple-50 to-violet-50 text-purple-700 border-purple-100',
                                                'closed' => 'bg-slate-50 text-slate-600 border-slate-100',
                                            ];
                                            $statusClass = $statusColors[$ticket->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase border {{ $statusClass }}">
                                            {{ str_replace('_', ' ', $ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-xs font-bold rounded-lg hover:from-indigo-700 hover:to-blue-700 transition-all shadow-sm">
                                            Ouvrir
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <p class="text-slate-500 font-semibold">Aucun ticket récent</p>
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
            <div class="space-y-6">
                
                <!-- Tickets Urgents Widget -->
                @if(count($data['lists']['urgent_tickets'] ?? []) > 0)
                <div class="bg-gradient-to-br from-white to-rose-50/30 rounded-2xl shadow-lg border border-rose-200/50 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Tickets Urgents
                        </h3>
                        <span class="px-2.5 py-1 bg-rose-100 text-rose-800 text-xs font-black rounded-full">{{ count($data['lists']['urgent_tickets']) }}</span>
                    </div>
                    <div class="space-y-3">
                        @foreach($data['lists']['urgent_tickets'] as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="block p-3 bg-white rounded-xl border border-rose-100 hover:border-rose-300 hover:shadow-md transition-all group">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-rose-600">{{ $ticket->subject }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[10px] font-bold text-slate-500">{{ $ticket->contact->nom_complet ?? 'N/A' }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <span class="text-[10px] font-bold text-slate-400">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tickets Non Assignés Widget -->
                @if(count($data['lists']['unassigned_tickets'] ?? []) > 0)
                <div class="bg-gradient-to-br from-white to-amber-50/30 rounded-2xl shadow-lg border border-amber-200/50 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Non Assignés
                        </h3>
                        <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-black rounded-full">{{ count($data['lists']['unassigned_tickets']) }}</span>
                    </div>
                    <div class="space-y-3">
                        @foreach($data['lists']['unassigned_tickets'] as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="block p-3 bg-white rounded-xl border border-amber-100 hover:border-amber-300 hover:shadow-md transition-all group">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-amber-600">{{ $ticket->subject }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[10px] font-bold text-slate-500">{{ $ticket->contact->nom_complet ?? 'N/A' }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <span class="text-[10px] font-bold text-slate-400">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Mes Tickets Widget -->
                @if(count($data['lists']['my_tickets'] ?? []) > 0)
                <div class="bg-gradient-to-br from-white to-indigo-50/30 rounded-2xl shadow-lg border border-indigo-200/50 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Mes Tickets
                        </h3>
                        <span class="px-2.5 py-1 bg-indigo-100 text-indigo-800 text-xs font-black rounded-full">{{ count($data['lists']['my_tickets']) }}</span>
                    </div>
                    <div class="space-y-3">
                        @foreach($data['lists']['my_tickets'] as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="block p-3 bg-white rounded-xl border border-indigo-100 hover:border-indigo-300 hover:shadow-md transition-all group">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-indigo-600">{{ $ticket->subject }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[10px] font-bold text-slate-500">{{ $ticket->contact->nom_complet ?? 'N/A' }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <span class="text-[10px] font-bold text-slate-400">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Daily Activities Widget -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200/50 p-6">
                    <h3 class="text-base font-black text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Activités Récentes
                    </h3>
                    <div class="space-y-4 relative before:absolute before:inset-0 before:left-[11px] before:border-l-2 before:border-slate-200">
                        @forelse($data['lists']['recent_activities'] as $activity)
                            <div class="relative flex gap-4 pl-1 group">
                                <div class="h-5 w-5 rounded-full bg-white border-4 border-slate-200 ring-2 ring-slate-50 z-10 flex-shrink-0 group-hover:border-indigo-300 group-hover:ring-indigo-50 transition-colors"></div>
                                <div class="flex-1 min-w-0 -mt-0.5">
                                    <p class="text-[13px] text-slate-600 leading-snug">
                                        <span class="font-black text-slate-900">{{ $activity->user->name ?? 'Système' }}</span> : {{ $activity->description }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-wider">{{ $activity->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-center text-slate-400 italic py-4 relative z-10 bg-white">Aucune activité aujourd'hui.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Assigned Tasks Widget -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200/50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            À faire
                        </h3>
                        <a href="{{ route('tasks.index') }}" class="text-xs font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-wider">Voir tout</a>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($data['lists']['tasks'] as $task)
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-gradient-to-r hover:from-slate-50 hover:to-indigo-50/30 transition-all border border-slate-200 group">
                            <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center text-indigo-600 group-hover:from-indigo-600 group-hover:to-blue-600 group-hover:text-white transition-all shadow-sm">
                                 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $task->titre }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] text-slate-500 font-bold uppercase">{{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d M') }}</span>
                                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $task->priority ?? 'Normale' }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-8 w-8 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs text-slate-400 italic">Aucune tâche assignée.</p>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status Chart (Doughnut) - Enhanced
        const statusCtx = document.getElementById('ticketStatusChart').getContext('2d');
        const statusData = @json($data['charts']['ticket_status'] ?? []);
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData).map(k => k.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',   // blue
                        'rgba(245, 158, 11, 0.8)',  // amber
                        'rgba(16, 185, 129, 0.8)', // emerald
                        'rgba(139, 92, 246, 0.8)', // purple
                        'rgba(156, 163, 175, 0.8)', // gray
                    ],
                    borderWidth: 0,
                    hoverOffset: 8
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
                            font: { size: 11, family: "'Inter', sans-serif", weight: '700' },
                            color: '#475569'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 11 },
                        displayColors: true
                    }
                }
            }
        });

        // Priority Chart (Bar) - Enhanced
        const priorityCtx = document.getElementById('ticketPriorityChart').getContext('2d');
        const priorityData = @json($data['charts']['ticket_priority'] ?? []);
        
        new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(priorityData).map(k => k.toUpperCase()),
                datasets: [{
                    label: 'Tickets',
                    data: Object.values(priorityData),
                    backgroundColor: [
                        'rgba(244, 63, 94, 0.8)',   // rose
                        'rgba(249, 115, 22, 0.8)',  // orange
                        'rgba(59, 130, 246, 0.8)', // blue
                        'rgba(16, 185, 129, 0.8)', // emerald
                    ],
                    borderRadius: 8,
                    maxBarThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 11 },
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F1F5F9',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { size: 10, family: "'Inter', sans-serif" },
                            color: '#94A3B8',
                            stepSize: 1
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, family: "'Inter', sans-serif", weight: '700' },
                            color: '#64748B'
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>

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