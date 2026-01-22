@extends('layouts.app')

@section('title', 'Tableau de bord Support - Nexus CRM')

@section('content')
@php
    $contacts = $data['contacts'] ?? [];
    $users = $data['users'] ?? [];
@endphp
<div class="min-h-screen bg-gray-50/50 p-6" x-data="{ openTicketModal: false, activeFilter: 'all' }">
    <div class="max-w-[1600px] mx-auto space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Tableau de bord
                </h2>
                <p class="mt-1 text-sm text-gray-500">Vue d'ensemble de l'activité du support client</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('support.reports.pdf', ['period' => 'day']) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all">
                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Télécharger PDF
                </a>
                <button @click="openTicketModal = true" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau Ticket
                </button>
            </div>
        </div>

        <!-- KPIs Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Tickets Nouveaux -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Nouveaux</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-blue-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['tickets_new'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Tickets en Cours -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">En Cours</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-amber-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['tickets_in_progress'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Tickets Urgents -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Urgents</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-rose-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['tickets_urgent'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Résolus Aujourd'hui -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Résolus Aujourd'hui</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-emerald-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['resolved_today'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Secondary KPIs Row -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Tickets Non Assignés -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Non Assignés</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-amber-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['tickets_unassigned'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Temps Moyen de Résolution -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Temps Moyen</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-indigo-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['avg_resolution_time'] ?? 0 }}<span class="text-sm font-semibold text-gray-500 ml-1">h</span></p>
                </div>
            </div>

            <!-- Total Actifs -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Actifs</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-blue-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['total_active_tickets'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Taux de Satisfaction -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Satisfaction</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-emerald-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['satisfaction_rate'] ?? 0 }}<span class="text-sm font-semibold text-gray-500 ml-1">%</span></p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Status Distribution (Left - 2/3) -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6 flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Répartition par Statut</h3>
                    <div class="flex space-x-2 text-xs font-medium">
                        <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded cursor-pointer hover:bg-gray-200">Mois</span>
                        <span class="px-2 py-1 text-gray-400 cursor-pointer hover:text-gray-500">Année</span>
                    </div>
                </div>
                
                <div class="flex-1 mt-4 relative h-[300px]">
                    <canvas id="ticketStatusChart"></canvas>
                </div>
            </div>

            <!-- Priority Distribution (Right - 1/3) -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-8">Par Priorité</h3>
                <div class="space-y-6">
                    @php
                        $priorityData = $data['charts']['ticket_priority'] ?? [];
                        $totalPriority = array_sum($priorityData) ?: 1;
                    @endphp
                    @foreach(['urgent', 'high', 'medium', 'low'] as $priority)
                        @php
                            $count = $priorityData[$priority] ?? 0;
                            $percentage = round(($count / $totalPriority) * 100);
                            $colors = [
                                'urgent' => 'bg-rose-500',
                                'high' => 'bg-orange-500',
                                'medium' => 'bg-blue-500',
                                'low' => 'bg-gray-400',
                            ];
                            $priorityLabels = [
                                'urgent' => 'Urgent',
                                'high' => 'Haute',
                                'medium' => 'Moyenne',
                                'low' => 'Basse',
                            ];
                            $barColor = $colors[$priority] ?? 'bg-gray-400';
                            $priorityLabel = $priorityLabels[$priority] ?? ucfirst($priority);
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $barColor }}"></span>
                                    <span class="text-sm font-medium text-gray-600">{{ $priorityLabel }}</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="h-full {{ $barColor }} rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content Area: 2/3 Table + 1/3 Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Ticket Queue (2/3) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Derniers Tickets</h3>
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-xs font-semibold text-gray-600 rounded-lg transition-colors">
                            Voir tout
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-white border-b border-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Ticket</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Client</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Assigné</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Priorité</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($data['lists']['recent_tickets'] as $ticket)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="text-sm font-semibold text-gray-900 hover:text-indigo-600 transition-colors">
                                                {{ $ticket->subject }}
                                            </a>
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tight mt-0.5">#{{ $ticket->id }} • {{ $ticket->category ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs ring-2 ring-white">
                                                {{ substr($ticket->contact->nom ?? 'C', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-600">{{ $ticket->contact->nom_complet ?? 'Inconnu' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->assignee)
                                        <div class="flex items-center gap-2">
                                            <div class="h-7 w-7 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs">
                                                {{ substr($ticket->assignee->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-600">{{ $ticket->assignee->name ?? 'N/A' }}</span>
                                        </div>
                                        @else
                                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 uppercase tracking-wider">Non assigné</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityClasses = [
                                                'urgent' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                'high' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                'medium' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'low' => 'bg-gray-50 text-gray-600 border-gray-200',
                                            ];
                                            $priorityLabels = [
                                                'urgent' => 'Urgent',
                                                'high' => 'Haute',
                                                'medium' => 'Moyenne',
                                                'low' => 'Basse',
                                            ];
                                            $priorityClass = $priorityClasses[$ticket->priority] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                                            $priorityLabel = $priorityLabels[$ticket->priority] ?? ucfirst($ticket->priority);
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $priorityClass }}">
                                            {{ $priorityLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'new' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'in_progress' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'waiting_client' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'closed' => 'bg-gray-50 text-gray-600 border-gray-200',
                                            ];
                                            $statusClass = $statusClasses[$ticket->status] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusClass }} capitalize">
                                            {{ str_replace('_', ' ', $ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->created_at->translatedFormat('d F') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">Aucun ticket récent.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar (1/3) -->
            <div class="space-y-8">
                
                <!-- Tickets Urgents Widget -->
                @if(count($data['lists']['urgent_tickets'] ?? []) > 0)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">Tickets Urgents</h3>
                        <span class="text-[10px] font-black bg-rose-50 text-rose-600 px-2 py-0.5 rounded-full border border-rose-100 uppercase tracking-widest">{{ count($data['lists']['urgent_tickets']) }}</span>
                    </div>
                    <div class="space-y-1">
                        @foreach($data['lists']['urgent_tickets'] as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="flex flex-col p-4 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-rose-600 transition-colors leading-snug">{{ $ticket->subject }}</span>
                            <div class="flex items-center gap-2 mt-1">
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
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">Non Assignés</h3>
                        <span class="text-[10px] font-black bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full border border-amber-100 uppercase tracking-widest">{{ count($data['lists']['unassigned_tickets']) }}</span>
                    </div>
                    <div class="space-y-1">
                        @foreach($data['lists']['unassigned_tickets'] as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="flex flex-col p-4 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-amber-600 transition-colors leading-snug">{{ $ticket->subject }}</span>
                            <div class="flex items-center gap-2 mt-1">
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
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">Mes Tickets</h3>
                        <span class="text-[10px] font-black bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full border border-indigo-100 uppercase tracking-widest">{{ count($data['lists']['my_tickets']) }}</span>
                    </div>
                    <div class="space-y-1">
                        @foreach($data['lists']['my_tickets'] as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="flex flex-col p-4 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors leading-snug">{{ $ticket->subject }}</span>
                            <div class="flex items-center gap-2 mt-1">
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
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Dernières Activités</h3>
                    <div class="relative space-y-6 before:absolute before:inset-0 before:left-[11px] before:border-l before:border-slate-100">
                        @forelse($data['lists']['recent_activities'] as $activity)
                            <div class="relative pl-7 flex flex-col group">
                                <div class="absolute left-0 top-1 w-2.5 h-2.5 rounded-full bg-white border-2 border-slate-200 z-10 group-hover:border-indigo-500 transition-colors"></div>
                                <p class="text-[13px] font-medium text-slate-600 group-hover:text-slate-900 transition-colors">{{ $activity->description }}</p>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 italic text-center py-4 bg-white relative z-10">Historique vide.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Assigned Tasks Widget -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">À faire</h3>
                        <a href="{{ route('tasks.index') }}" class="text-xs font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-wider">Voir tout</a>
                    </div>
                    
                    <div class="space-y-2">
                        @forelse($data['lists']['tasks'] as $task)
                        <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $task->due_date < now() ? 'bg-rose-500' : 'bg-slate-300' }} flex-shrink-0"></div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800 leading-snug truncate">{{ $task->titre }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-8 w-8 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs text-slate-400 italic">Pas de tâches en attente.</p>
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
                 class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
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
                 class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-200">
                
                <!-- Header -->
                <div class="bg-white px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" id="modal-title">Nouveau ticket</h3>
                            <p class="text-xs text-gray-600 mt-0.5">Les champs marqués <span class="text-rose-600 font-bold">*</span> sont obligatoires.</p>
                        </div>
                    </div>
                    <button @click="openTicketModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
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
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end gap-3">
                    <button @click="openTicketModal = false" type="button" class="px-4 py-2.5 text-sm font-semibold text-gray-700 hover:text-gray-900 rounded-lg hover:bg-white transition">
                        Annuler
                    </button>
                    <button type="submit" form="create-ticket-form" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 focus:outline-none transition-all">
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
        // Status Chart (Bar Chart like admin dashboard)
        const statusCtx = document.getElementById('ticketStatusChart').getContext('2d');
        const statusData = @json($data['charts']['ticket_status'] ?? []);
        
        const statusConfig = [
            { key: 'new', label: 'Nouveau', color: '#3B82F6' },
            { key: 'in_progress', label: 'En Cours', color: '#F59E0B' },
            { key: 'resolved', label: 'Résolu', color: '#10B981' },
            { key: 'waiting_client', label: 'En Attente', color: '#8B5CF6' },
            { key: 'closed', label: 'Fermé', color: '#9CA3AF' }
        ];

        const labels = statusConfig.map(s => s.label);
        const dataValues = statusConfig.map(s => Number(statusData[s.key] || 0));
        const backgroundColors = statusConfig.map(s => s.color);

        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tickets',
                    data: dataValues,
                    backgroundColor: backgroundColors,
                    borderRadius: 6,
                    maxBarThickness: 50,
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
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + ' ticket(s)';
                                }
                                return label;
                            }
                        }
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
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9CA3AF',
                            stepSize: 1
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9CA3AF'
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
