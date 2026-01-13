<div class="bg-gray-50 rounded-lg shadow-sm border border-gray-200">
    <div class="p-4 border-b border-gray-200 bg-white rounded-t-lg flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Activité</h3>
        <span class="text-xs text-gray-500">Historique des échanges</span>
    </div>

    <!-- Add Activity Form -->
    <div class="p-4 bg-white border-b border-gray-200" x-data="{ open: false }">
        <button @click="open = !open" x-show="!open" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter une note, un appel ou un email
        </button>

        <form x-show="open" action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="parent_type" value="{{ $parent_type }}">
            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
            <input type="hidden" name="date_activite" value="{{ now() }}">

            <div class="space-y-3">
                <!-- Type Selection -->
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="appel" class="form-radio text-blue-600" checked>
                        <span class="ml-2">Appel</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="email" class="form-radio text-blue-600">
                        <span class="ml-2">Email</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="reunion" class="form-radio text-blue-600">
                        <span class="ml-2">Réunion</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="note" class="form-radio text-blue-600">
                        <span class="ml-2">Note</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="ticket" class="form-radio text-blue-600">
                        <span class="ml-2">Ticket</span>
                    </label>
                </div>

                <!-- Description/Subject -->
                <div>
                    <label for="description" class="sr-only">Titre / Objet</label>
                    <input type="text" name="description" id="description" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Objet de l'échange (ex: Relance devis)" required>
                </div>

                <!-- Content -->
                <div>
                    <label for="contenu" class="sr-only">Détails</label>
                    <textarea name="contenu" id="contenu" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Détails de l'échange..."></textarea>
                </div>
                
                <!-- Additional Fields (Duration, Status) -->
                <div class="grid grid-cols-2 gap-4">
                     <div>
                        <label for="duree" class="block text-xs font-medium text-gray-700">Durée (min)</label>
                        <input type="number" name="duree" id="duree" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="15">
                     </div>
                     <div>
                         <label for="statut" class="block text-xs font-medium text-gray-700">Statut</label>
                         <select name="statut" id="statut" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                             <option value="termine">Terminé</option>
                             <option value="planifie">Planifié</option>
                         </select>
                     </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700">Pièce jointe (Optionnel)</label>
                    <input type="file" name="piece_jointe" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <div class="flex justify-between items-center pt-2">
                     <button type="button" @click="open = false" class="text-sm text-gray-500 hover:text-gray-700">Annuler</button>
                     <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                         Enregistrer
                     </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Timeline List -->
    <div class="p-4 bg-gray-50 max-h-96 overflow-y-auto">
        <ul role="list" class="-mb-8">
            @forelse($activities as $activity)
            <li>
                <div class="relative pb-8">
                    @if(!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    @endif
                    <div class="relative flex space-x-3">
                        <div>
                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                {{ $activity->type === 'appel' ? 'bg-green-500' : '' }}
                                {{ $activity->type === 'email' ? 'bg-blue-500' : '' }}
                                {{ $activity->type === 'reunion' ? 'bg-purple-500' : '' }}
                                {{ $activity->type === 'note' ? 'bg-gray-500' : '' }}
                                {{ $activity->type === 'ticket' ? 'bg-red-500' : '' }}
                            ">
                                @if($activity->type === 'appel')
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                @elseif($activity->type === 'email')
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                @elseif($activity->type === 'reunion')
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif($activity->type === 'ticket')
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                @else
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @endif
                            </span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    <span class="font-medium text-gray-900">{{ $activity->description }}</span>
                                    <span class="ml-1 text-xs text-gray-400">par {{ $activity->user->name }}</span>
                                </p>
                                @if($activity->contenu)
                                <div class="mt-2 text-sm text-gray-700 bg-white p-2 rounded border border-gray-100 italic">
                                    {!! nl2br(e($activity->contenu)) !!}
                                </div>
                                @endif

                                @if($activity->piece_jointe)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $activity->piece_jointe) }}" target="_blank" class="inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-500">
                                        <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        Voir la pièce jointe
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                <time datetime="{{ $activity->date_activite }}">{{ $activity->date_activite->format('d/m/Y H:i') }}</time>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <li>
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500">Aucune activité enregistrée.</p>
                </div>
            </li>
            @endforelse
        </ul>
    </div>
</div>
