@extends('layouts.app')

@section('title', 'Gestion du Support')

@section('content')
<div class="min-h-full bg-gradient-to-br from-slate-50 via-white to-slate-50/30 py-6" x-data="{ showAdvanced: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8 lg:flex lg:items-center lg:justify-between">
            <div class="flex-1 min-w-0">
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                        <li class="hover:text-slate-700 transition-colors">CRM PRO</li>
                        <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-indigo-600 font-bold">Support Client</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl mb-2">Gestion du Support</h1>
                <div class="flex items-center gap-3 text-sm text-slate-600">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        <span>{{ $tickets->total() }}</span> tickets ouverts
                    </span>
                </div>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4 gap-3">
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-md text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nouveau Ticket
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="p-5">
                <form action="{{ route('tickets.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex-1">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Recherche globale</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="ID, Sujet, Client...">
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-40">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Statut</label>
                                <select name="status" onchange="this.form.submit()" class="w-full rounded-lg border-slate-300 text-sm font-semibold text-slate-700 bg-slate-50/50 focus:bg-white transition-colors">
                                    <option value="">Tous</option>
                                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Nouveau</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Résolu</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Fermé</option>
                                </select>
                            </div>
                            <div class="w-40">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Urgence</label>
                                <select name="priority" onchange="this.form.submit()" class="w-full rounded-lg border-slate-300 text-sm font-semibold text-slate-700 bg-slate-50/50 focus:bg-white transition-colors">
                                    <option value="">Tous</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Basse</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Haute</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-indigo-700 transition-all">Filtrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full table-auto divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Référence / Sujet</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Catégorie</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Urgence</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickets as $ticket)
                    <tr class="group hover:bg-slate-50/80 transition-all duration-150">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                    {{ $ticket->subject }}
                                </a>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-0.5">#{{ $ticket->id }} • {{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-slate-50 text-slate-600 border border-slate-200 uppercase tracking-tighter">
                                @switch($ticket->category)
                                    @case('technical') 🛠️ Technique @break
                                    @case('commercial') 💼 Commercial @break
                                    @case('billing') 💳 Facturation @break
                                    @case('feature_request') 💡 Suggestion @break
                                    @default ❓ Autre
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = match($ticket->status) {
                                    'new' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'in_progress' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'resolved' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold border {{ $statusClasses }} uppercase tracking-wider">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $priorityColor = match($ticket->priority) {
                                    'urgent' => 'text-rose-600',
                                    'high' => 'text-orange-500',
                                    'medium' => 'text-blue-500',
                                    default => 'text-slate-400'
                                };
                                $dotColor = match($ticket->priority) {
                                    'urgent' => 'bg-rose-600 shadow-[0_0_8px_rgba(225,29,72,0.4)]',
                                    'high' => 'bg-orange-500',
                                    'medium' => 'bg-blue-500',
                                    default => 'bg-slate-400'
                                };
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full {{ $dotColor }} {{ $ticket->priority === 'urgent' ? 'animate-pulse' : '' }}"></span>
                                <span class="text-xs font-bold uppercase {{ $priorityColor }}">{{ $ticket->priority }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-500 border border-slate-200">
                                    {{ substr($ticket->contact->nom_complet, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $ticket->contact->nom_complet }}</p>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $ticket->contact->entreprise ?? 'Indépendant' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('tickets.show', $ticket) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Ouvrir">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Modifier">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800">Aucun ticket pour le moment</h3>
                                <p class="text-sm text-slate-500 mt-1">Les demandes de vos clients apparaîtront ici.</p>
                                <a href="{{ route('tickets.create') }}" class="mt-6 inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-bold shadow-md hover:bg-indigo-700 transition-all">Relancer l'activité</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($tickets->hasPages())
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 rounded-b-xl shadow-sm mt-4">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
