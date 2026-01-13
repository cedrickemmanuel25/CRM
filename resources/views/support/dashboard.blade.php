@extends('layouts.app')

@section('title', 'Tableau de bord Support')

@section('content')
<div x-data="{ showTicketModal: false }" class="min-h-screen bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Centre de Support</h2>
                <p class="text-sm text-gray-500 mt-1">Pilotage du service client et des tickets.</p>
            </div>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Créer un ticket
            </a>
        </div>

        <!-- KPIs Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tickets in Progress -->
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 hover:bg-gray-50 transition">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-widest">Tickets en cours</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $data['kpis']['tickets_in_progress'] }}</p>
                <div class="absolute bottom-4 right-4 text-gray-300">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
            </div>

            <!-- Interactions in Progress -->
            <div class="relative overflow-hidden rounded-2xl bg-indigo-50 p-6 shadow-sm ring-1 ring-indigo-100 transition hover:bg-indigo-100/50">
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-widest">Interactions Actives</p>
                <p class="mt-2 text-3xl font-bold text-indigo-700">{{ $data['kpis']['interactions_in_progress'] }}</p>
                <div class="absolute bottom-4 right-4 text-indigo-200">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>

            <!-- Resolved Today -->
            <div class="relative overflow-hidden rounded-2xl bg-emerald-50 p-6 shadow-sm ring-1 ring-emerald-100 transition hover:bg-emerald-100/50">
                <p class="text-sm font-medium text-emerald-600 uppercase tracking-widest">Résolus Aujourd'hui</p>
                <p class="mt-2 text-3xl font-bold text-emerald-700">{{ $data['kpis']['resolved_today'] }}</p>
                <div class="absolute bottom-4 right-4 text-emerald-200">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Ticket Queue (Left - 2 Cols) -->
            <div class="lg:col-span-2 rounded-2xl bg-white shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-gray-900">File d'attente (Récents)</h3>
                    <div class="flex space-x-2">
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">Haute Priorité</span>
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">Moyenne</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Sujet</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Priorité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Assigné à</th>
                                <th class="relative px-6 py-3 bg-gray-50"><span class="sr-only">Voir</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($data['lists']['recent_tickets'] as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ Str::limit($ticket->subject, 40) }}</span>
                                    <span class="block text-xs text-gray-400 mt-0.5">{{ $ticket->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div class="h-6 w-6 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600 mr-2">
                                            {{ substr($ticket->contact->nom ?? 'C', 0, 1) }}
                                        </div>
                                        <div>
                                            {{ $ticket->contact->nom ?? '' }} {{ $ticket->contact->prenom ?? '' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($ticket->priority == 'urgent') bg-rose-100 text-rose-800 ring-1 ring-rose-600/20
                                        @elseif($ticket->priority == 'high') bg-red-100 text-red-800 ring-1 ring-red-600/20
                                        @elseif($ticket->priority == 'medium') bg-amber-100 text-amber-800 ring-1 ring-amber-600/20
                                        @else bg-emerald-100 text-emerald-800 ring-1 ring-emerald-600/20 @endif">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ticket->assignee->name ?? 'Non assigné' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Gérer</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>Tout est calme. Aucun ticket récent.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Side Widgets (Right - 1 Col) -->
            <div class="space-y-6">
                <!-- Active Contacts -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Contacts Actifs (7j)</h3>
                    <div class="space-y-4">
                        @forelse($data['lists']['active_contacts'] as $contact)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-xs ring-1 ring-slate-200">
                                        {{ substr($contact->nom ?? 'C', 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-slate-900 truncate max-w-[120px]">{{ $contact->prenom }} {{ $contact->nom }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('contacts.show', $contact->id) }}" class="text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-500">Voir</a>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 italic">Aucun contact actif.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Daily Activities -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Activités du Jour</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @forelse($data['lists']['daily_activities'] as $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-100" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 border border-slate-100">
                                                <svg class="h-3 w-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 justify-between flex space-x-2">
                                                <p class="text-[10px] text-gray-500 leading-tight">
                                                    <span class="font-bold text-slate-700">{{ $activity->user->name }}</span>: {{ $activity->description }}
                                                </p>
                                                <div class="text-right text-[10px] whitespace-nowrap text-gray-400">
                                                    {{ $activity->created_at->format('H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-xs text-slate-500 italic">Aucune activité aujourd'hui.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                
                <!-- Assigned Tasks List -->
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-900">Mes Tâches Assignées</h3>
                    </div>
                    <ul class="space-y-4">
                        @forelse($data['lists']['tasks'] as $task)
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5">
                                 <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate max-w-[150px]">{{ $task->titre }}</p>
                                <p class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d F Y') }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="text-center text-sm text-gray-500 italic py-2">Aucune tâche.</li>
                        @endforelse
                    </ul>
                </div>

        </div>

    </div>
</div>
@endsection
