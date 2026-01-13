<div class="lg:col-span-2 space-y-6 block">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Demandes en attente & Urgences</h3>
            <span class="text-xs text-gray-500">Priorité SLA</span>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($tickets as $ticket)
            <li class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-purple-600 truncate">
                        {{ $ticket->description ?? 'Sans titre' }}
                    </p>
                    <div class="ml-2 flex-shrink-0 flex">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->priorite === 'haute' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($ticket->priorite ?? 'Normale') }}
                        </span>
                    </div>
                </div>
                <div class="mt-2 sm:flex sm:justify-between">
                    <div class="sm:flex">
                        <p class="flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $ticket->parent ? class_basename($ticket->parent) . ' #' . $ticket->parent->id : 'Contact Direct' }}
                        </p>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p>
                            Créé {{ $ticket->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-4 py-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="mt-2 text-sm">Aucun ticket en attente. Bon travail !</p>
            </li>
            @endforelse
        </ul>
        <div class="bg-gray-50 px-4 py-4 sm:px-6 rounded-b-lg">
            <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-500">Voir tous les tickets &rarr;</a>
        </div>
    </div>
</div>
