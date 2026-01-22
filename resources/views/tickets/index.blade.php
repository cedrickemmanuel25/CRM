@extends('layouts.app')

@section('title', 'Gestion du Support')

@section('content')
<div class="min-h-full bg-gradient-to-br from-slate-50 via-white to-slate-50/30 py-6" x-data="{ showAdvanced: false, openTicketModal: false }">
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
                <button @click="openTicketModal = true" class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-md text-sm font-semibold rounded-lg text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nouveau Ticket
                </button>
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
                                $priorityLabels = [
                                    'urgent' => 'Urgent',
                                    'high' => 'Haute',
                                    'medium' => 'Moyenne',
                                    'low' => 'Basse',
                                ];
                                $priorityLabel = $priorityLabels[$ticket->priority] ?? ucfirst($ticket->priority);
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full {{ $dotColor }} {{ $ticket->priority === 'urgent' ? 'animate-pulse' : '' }}"></span>
                                <span class="text-xs font-bold uppercase {{ $priorityColor }}">{{ $priorityLabel }}</span>
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
                                <button @click="openTicketModal = true" class="mt-6 inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-lg font-bold shadow-md hover:from-indigo-700 hover:to-blue-700 transition-all">Relancer l'activité</button>
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

        // Find submit button - could be inside form or outside with form attribute
        const submitBtn = form.querySelector('button[type="submit"]') || document.querySelector('button[form="create-ticket-form"]');
        if (!submitBtn) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
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
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Erreur lors de la création');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    // Reload page to show validation errors
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reload page to show validation errors
                window.location.reload();
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });

        // Also handle button click outside form
        submitBtn.addEventListener('click', function(e) {
            if (submitBtn.form !== form && submitBtn.getAttribute('form') === 'create-ticket-form') {
                e.preventDefault();
                form.requestSubmit();
            }
        });
    });
</script>
@endpush
@endsection
