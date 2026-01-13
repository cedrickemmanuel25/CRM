@extends('layouts.app')

@section('title', 'Gestion des Tickets - CRM')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showModal: false, selectedContact: '' }">
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Centre de Support</h1>
            <p class="mt-2 text-sm text-gray-700">Gérez les tickets, problèmes et réclamations clients.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button @click="showModal = true" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Ticket
            </button>
        </div>
    </div>

    <!-- Filters & Stats Component Placeholder -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets Ouverts</p>
            <p class="mt-1 text-2xl font-bold text-indigo-600">{{ $tickets->where('statut', '!=', 'termine')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Haute Priorité</p>
            <p class="mt-1 text-2xl font-bold text-red-600">{{ $tickets->where('priorite', 'haute')->where('statut', '!=', 'termine')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nouveaux (24h)</p>
            <p class="mt-1 text-2xl font-bold text-green-600">{{ $tickets->where('created_at', '>=', now()->subDay())->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Taux Résolution</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">85%</p>
        </div>
    </div>

    <!-- Tickets List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
             <h2 class="text-sm font-bold text-gray-700 uppercase">Liste des tickets récents</h2>
             <div class="flex space-x-2">
                 <select class="text-xs border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                     <option>Tous les statuts</option>
                     <option>Nouveau</option>
                     <option>En cours</option>
                     <option>Terminé</option>
                 </select>
             </div>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($tickets as $ticket)
            <li>
                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full {{ $ticket->priorite === 'haute' ? 'bg-red-100' : 'bg-blue-100' }}">
                                    <svg class="h-6 w-6 {{ $ticket->priorite === 'haute' ? 'text-red-600' : 'text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-indigo-600 truncate">{{ $ticket->description }}</div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    @if($ticket->parent)
                                        <a href="{{ route('contacts.show', $ticket->parent) }}" class="hover:underline">{{ $ticket->parent->nom }} {{ $ticket->parent->prenom }}</a>
                                    @else
                                        Détaché
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <div class="flex space-x-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $ticket->statut === 'nouveau' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $ticket->statut === 'en_cours' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $ticket->statut === 'termine' ? 'bg-gray-100 text-gray-800' : '' }}
                                ">
                                    {{ ucfirst($ticket->statut) }}
                                </span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $ticket->priorite === 'haute' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}
                                ">
                                    {{ ucfirst($ticket->priorite) }}
                                </span>
                            </div>
                            <div class="mt-2 text-xs text-gray-400">
                                Créé {{ $ticket->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @if($ticket->contenu)
                    <div class="mt-3 text-sm text-gray-600 bg-gray-50 p-3 rounded italic border-l-4 border-gray-200">
                        {{ \Illuminate\Support\Str::limit($ticket->contenu, 150) }}
                    </div>
                    @endif
                </div>
            </li>
            @empty
            <li class="px-4 py-8 text-center text-gray-500">
                Aucun ticket trouvé.
            </li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Modal for New Ticket -->
<div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('activities.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="ticket">
                <input type="hidden" name="date_activite" value="{{ now() }}">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 border-b pb-2">Nouveau Ticket de Support</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Client / Contact</label>
                            <select name="parent_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Sélectionner un contact</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->nom }} {{ $contact->prenom }} ({{ $contact->entreprise }})</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="parent_type" value="contact">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sujet / Problème</label>
                            <input type="text" name="description" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ex: Problème d'accès au portail">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                             <div>
                                <label class="block text-sm font-medium text-gray-700">Priorité</label>
                                <select name="priorite" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="normale">Normale</option>
                                    <option value="haute">Haute</option>
                                    <option value="basse">Basse</option>
                                </select>
                             </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700">Statut initial</label>
                                <select name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="nouveau">Nouveau</option>
                                    <option value="en_cours">En cours</option>
                                </select>
                             </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description détaillée</label>
                            <textarea name="contenu" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Détails de la réclamation..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Créer le ticket
                    </button>
                    <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
