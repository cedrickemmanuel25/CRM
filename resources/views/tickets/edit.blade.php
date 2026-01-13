@extends('layouts.app')

@section('title', 'Modifier Ticket #' . $ticket->id)

@section('content')
<div class="min-h-full bg-gradient-to-br from-slate-50 via-white to-slate-50/30 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                    <li class="hover:text-indigo-600 transition-colors">
                        <a href="{{ route('tickets.index') }}" class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            Support
                        </a>
                    </li>
                    <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="hover:text-indigo-600 transition-colors font-semibold"><a href="{{ route('tickets.show', $ticket) }}">#{{ $ticket->id }}</a></li>
                    <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-indigo-600 font-bold">Modification</li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-1">Mise à jour du ticket</h1>
                    <p class="text-sm text-slate-600 font-medium">Modifiez les paramètres globaux de la demande d'assistance.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('tickets.show', $ticket) }}" class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">Retour</a>
                    <button type="button" onclick="document.getElementById('edit-form').submit()" 
                        class="inline-flex items-center px-6 py-2.5 bg-slate-900 border border-transparent shadow-md text-sm font-bold rounded-lg text-white hover:bg-slate-800 focus:outline-none transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Mettre à jour
                    </button>
                </div>
            </div>
        </div>

        <form id="edit-form" action="{{ route('tickets.update', $ticket) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- MAIN CONTENT AREA -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 px-6 py-4 border-b border-slate-200">
                            <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Détails de la demande</h3>
                        </div>
                        <div class="p-6 space-y-8">
                            <!-- Subject -->
                            <div class="space-y-2">
                                <label for="subject" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Sujet du ticket</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject', $ticket->subject) }}" required
                                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                                @error('subject') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Description</label>
                                <textarea name="description" id="description" rows="12" required
                                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 leading-relaxed focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">{{ old('description', $ticket->description) }}</textarea>
                                @error('description') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR AREA -->
                <div class="space-y-6">
                    <!-- Config Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-widest">État du dossier</span>
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="p-5 space-y-6">
                            <!-- Status -->
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Statut actuel</label>
                                <select name="status" required class="block w-full pl-3 pr-10 py-2.5 text-sm font-black border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all bg-slate-50/50">
                                    <option value="new" {{ old('status', $ticket->status) == 'new' ? 'selected' : '' }}>🔵 Nouveau</option>
                                    <option value="in_progress" {{ old('status', $ticket->status) == 'in_progress' ? 'selected' : '' }}>🟡 En cours</option>
                                    <option value="resolved" {{ old('status', $ticket->status) == 'resolved' ? 'selected' : '' }}>🟢 Résolu</option>
                                    <option value="closed" {{ old('status', $ticket->status) == 'closed' ? 'selected' : '' }}>⚪ Fermé</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Domaine d'intervention</label>
                                <select name="category" required class="block w-full pl-3 pr-10 py-2.5 text-sm font-semibold border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all bg-slate-50/50">
                                    <option value="technical" {{ old('category', $ticket->category) == 'technical' ? 'selected' : '' }}>🛠️ Support Technique</option>
                                    <option value="commercial" {{ old('category', $ticket->category) == 'commercial' ? 'selected' : '' }}>💼 Administratif & Commercial</option>
                                    <option value="billing" {{ old('category', $ticket->category) == 'billing' ? 'selected' : '' }}>💳 Facturation & Paiement</option>
                                    <option value="feature_request" {{ old('category', $ticket->category) == 'feature_request' ? 'selected' : '' }}>💡 Suggestion d'évolution</option>
                                    <option value="other" {{ old('category', $ticket->category) == 'other' ? 'selected' : '' }}>❓ Autre demande</option>
                                </select>
                            </div>

                            <!-- Priority -->
                            <div class="space-y-3">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Niveau de priorité</label>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach(['low' => 'Basse', 'medium' => 'Normale', 'high' => 'Haute', 'urgent' => 'Critique'] as $value => $label)
                                    <label class="relative flex items-center p-3 cursor-pointer rounded-xl border {{ old('priority', $ticket->priority) == $value ? 'border-indigo-400 bg-indigo-50/30' : 'border-slate-200 hover:bg-slate-50' }} transition-all group">
                                        <input type="radio" name="priority" value="{{ $value }}" {{ old('priority', $ticket->priority) == $value ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                        <div class="ml-3 flex flex-col">
                                            <span class="text-xs font-bold {{ old('priority', $ticket->priority) == $value ? 'text-indigo-700' : 'text-slate-700' }}">{{ $label }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Assigned To -->
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Agent responsable</label>
                                <select name="assigned_to" class="block w-full pl-3 pr-10 py-2.5 text-sm font-semibold border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all bg-slate-50/50">
                                    <option value="">Non assigné</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to) == $user->id ? 'selected' : '' }}>
                                            👤 {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Side Action Card -->
                    <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white text-center">
                        <div class="flex items-center justify-center gap-2 mb-4">
                            <span class="text-xs font-bold uppercase tracking-widest opacity-80 italic">Action rapide</span>
                        </div>
                        <button type="submit" name="status" value="resolved" class="w-full bg-white text-indigo-700 py-3 rounded-lg font-black text-xs uppercase tracking-widest hover:bg-white/90 transition-all shadow-md">
                            Marquer comme résolu
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
