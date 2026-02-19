@extends('layouts.app')

@section('title', 'Rapports Support - CRM')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 p-6">
    <div class="max-w-[1800px] mx-auto space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black tracking-tight bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">
                    Rapports Support
                </h2>
                <p class="mt-2 text-sm font-semibold text-slate-600">Analyse des tickets par période</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('support.reports.pdf', ['period' => $period]) }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-rose-600 to-red-600 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white hover:from-rose-700 hover:to-red-700 transition-all duration-200 hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Télécharger PDF
                </a>
            </div>
        </div>

        <!-- Period Filters -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200/50 p-6">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-sm font-bold text-slate-700">Période :</span>
                <a href="{{ route('support.reports', ['period' => 'day']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $period === 'day' ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Aujourd'hui
                </a>
                <a href="{{ route('support.reports', ['period' => 'week']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $period === 'week' ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Cette Semaine
                </a>
                <a href="{{ route('support.reports', ['period' => 'month']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $period === 'month' ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Ce Mois
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Tickets -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-slate-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total</p>
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-slate-500 mt-1 font-semibold">{{ $periodLabel }}</p>
            </div>

            <!-- Nouveaux -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-blue-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nouveaux</p>
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['new'] }}</p>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Tickets nouveaux</p>
            </div>

            <!-- En Cours -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-amber-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">En Cours</p>
                    <div class="p-2 bg-amber-100 rounded-lg">
                        <svg class="h-4 w-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['in_progress'] }}</p>
                <p class="text-xs text-slate-500 mt-1 font-semibold">En traitement</p>
            </div>

            <!-- Résolus -->
            <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-md border border-emerald-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Résolus</p>
                    <div class="p-2 bg-emerald-100 rounded-lg">
                        <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['resolved'] }}</p>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Tickets résolus</p>
            </div>
        </div>

        <!-- Priority Statistics -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <div class="bg-white rounded-xl p-5 shadow-md border border-rose-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase">Urgent</p>
                    <span class="px-2 py-1 bg-rose-100 text-rose-800 text-xs font-bold rounded-full">{{ $stats['urgent'] }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-md border border-orange-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase">Haute</p>
                    <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs font-bold rounded-full">{{ $stats['high'] }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-md border border-blue-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase">Moyenne</p>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full">{{ $stats['medium'] }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-md border border-slate-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase">Basse</p>
                    <span class="px-2 py-1 bg-slate-100 text-slate-800 text-xs font-bold rounded-full">{{ $stats['low'] }}</span>
                </div>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200/50 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50/30">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Liste des Tickets - {{ $periodLabel }}</h3>
                        <p class="text-xs text-slate-500 mt-1 uppercase tracking-wider font-bold">{{ $tickets->count() }} ticket(s) trouvé(s)</p>
                    </div>
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
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="max-w-[250px]">
                                    <p class="text-sm font-bold text-slate-900 truncate group-hover:text-indigo-600 transition-colors">{{ $ticket->subject }}</p>
                                    @if($ticket->category)
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase mt-1">{{ $ticket->category }}</p>
                                    @endif
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-700">{{ $ticket->created_at->format('d/m/Y') }}</div>
                                <div class="text-[10px] text-slate-400 font-semibold">{{ $ticket->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-xs font-bold rounded-lg hover:from-indigo-700 hover:to-blue-700 transition-all shadow-sm">
                                    Ouvrir
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-slate-500 font-semibold">Aucun ticket trouvé pour {{ strtolower($periodLabel) }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
