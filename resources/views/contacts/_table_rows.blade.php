@php
    $requestedView = $viewType ?? 'both';
@endphp

@if($requestedView === 'table' || $requestedView === 'both')
    <!-- TABLE_VIEW_START -->
    @forelse($contacts as $contact)
        @php
            $isOwner = (int)auth()->id() === (int)$contact->user_id_owner;
            $canEdit = auth()->user()->isAdmin() || (auth()->user()->isCommercial() && $isOwner);
        @endphp
        <tr class="hover:bg-white/5 transition-colors group align-top">
            <td class="px-3 py-4 break-words">
                <div class="flex items-center">
                    <div class="relative flex-shrink-0">
                        <div class="h-10 w-10 rounded-full border border-white/10 overflow-hidden shadow-sm bg-slate-800 italic">
                            <img src="{{ $contact->avatar_url }}" alt="{{ $contact->nom_complet }}" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div class="ml-3 min-w-0">
                        <div class="text-xs font-semibold text-slate-100 truncate">{{ $contact->prenom }} {{ $contact->nom }}</div>
                        <div class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">ID: #{{ $contact->id }}</div>
                    </div>
                </div>
            </td>
            <td class="px-3 py-4 break-words">
                <div class="text-xs font-semibold text-slate-200">{{ $contact->entreprise ?? 'Indépendant' }}</div>
                <div class="text-[10px] text-slate-500 font-medium uppercase">{{ $contact->poste ?? 'Poste non précisé' }}</div>
            </td>
            <td class="hidden lg:table-cell px-3 py-4">
                <div class="space-y-1">
                    <div class="flex items-start text-[11px] text-slate-400">
                        <svg class="h-3.5 w-3.5 text-slate-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="truncate block w-full" title="{{ $contact->email }}">{{ $contact->email }}</span>
                    </div>
                    @if($contact->telephone)
                    <div class="flex items-center text-[10px] text-slate-500">
                        <svg class="h-3.5 w-3.5 text-slate-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span class="truncate">{{ format_phone($contact->telephone) }}</span>
                    </div>
                    @endif
                </div>
            </td>
            <td class="hidden md:table-cell px-3 py-4">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-400 border border-white/5">
                    {{ $contact->source ?? 'Autre' }}
                </span>
            </td>
            <td class="hidden sm:table-cell px-3 py-4">
                @php
                    $stage = \App\Models\Contact::getStages()[$contact->statut] ?? null;
                    $color = $stage['color'] ?? 'slate';
                    $badgeClasses = match($color) {
                        'slate' => 'bg-slate-800 text-slate-400 border-white/5',
                        'amber' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                        'indigo' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                        'blue' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                        'emerald' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                        'rose' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                        default => 'bg-slate-800 text-slate-400 border-white/5'
                    };
                @endphp
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $badgeClasses }}">
                    {{ $stage['label'] ?? ucfirst($contact->statut) }}
                </span>
            </td>
            <td class="hidden lg:table-cell px-3 py-4 break-words">
                <div class="flex items-center">
                    <span class="text-xs font-medium text-slate-400 truncate">{{ $contact->owner->name ?? 'Inconnu' }}</span>
                </div>
            </td>
            <td class="hidden xl:table-cell px-3 py-4 whitespace-nowrap">
                <div class="text-xs text-slate-300 font-medium">{{ $contact->created_at->format('d/m/Y') }}</div>
                <div class="text-[10px] text-slate-500">{{ $contact->created_at->diffForHumans() }}</div>
            </td>
            <td class="px-3 py-4 text-right whitespace-nowrap">
                <div class="flex items-center justify-end flex-nowrap gap-2 min-w-max">
                    <a href="{{ route('contacts.show', $contact) }}" class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 text-blue-500 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition-all" title="Voir les détails">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </a>
                    @if($canEdit)
                    <a href="{{ route('contacts.edit', $contact) }}" class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 text-slate-500 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg transition-all" title="Modifier">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    @endif
                    @if($canEdit)
                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="contents" onsubmit="return confirm('Confirmer la suppression ?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 text-slate-500 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all" title="Supprimer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="px-6 py-20 text-center">
                <div class="flex flex-col items-center gap-4">
                    <div class="h-16 w-16 bg-white/5 rounded-2xl flex items-center justify-center border border-white/5 shadow-inner">
                        <svg class="h-8 w-8 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest italic opacity-50">Aucun contact trouvé</h3>
                </div>
            </td>
        </tr>
    @endforelse
@endif

@if($requestedView === 'card' || $requestedView === 'both')
    <!-- CARD_VIEW_START -->
    @forelse($contacts as $contact)
        @php
            $isOwner = (int)auth()->id() === (int)$contact->user_id_owner;
            $canEdit = auth()->user()->isAdmin() || (auth()->user()->isCommercial() && $isOwner);
            $stage = \App\Models\Contact::getStages()[$contact->statut] ?? null;
            $color = $stage['color'] ?? 'slate';
            $badgeClasses = match($color) {
                'slate' => 'bg-slate-800 text-slate-400 border-white/5',
                'amber' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                'indigo' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                'blue' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                'emerald' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                'rose' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                default => 'bg-slate-800 text-slate-400 border-white/5'
            };
        @endphp
        <div class="saas-card p-4 space-y-4">
            <!-- Card Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ $contact->avatar_url }}" alt="{{ $contact->nom_complet }}" class="h-12 w-12 rounded-full border border-white/10 shadow-sm object-cover bg-slate-800">
                    <div>
                        <h4 class="text-xs font-bold text-slate-100">{{ $contact->prenom }} {{ $contact->nom }}</h4>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">{{ $contact->entreprise ?? 'Indépendant' }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded-lg text-[9px] font-bold border {{ $badgeClasses }}">
                    {{ $stage['label'] ?? ucfirst($contact->statut) }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="grid grid-cols-2 gap-3 pt-1">
                <div class="space-y-0.5">
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Email</p>
                    <p class="text-[11px] text-slate-300 truncate font-medium">{{ $contact->email }}</p>
                </div>
                <div class="space-y-0.5 text-right">
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Téléphone</p>
                    <p class="text-[11px] text-slate-300 font-medium">{{ $contact->telephone ? format_phone($contact->telephone) : '-' }}</p>
                </div>
            </div>

            <!-- Card Metadata (Source & Owner) -->
            <div class="flex items-center justify-between pt-2 text-[9px] text-slate-500 border-t border-white/5">
                <div class="flex items-center gap-1.5">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="font-bold uppercase tracking-wider">{{ $contact->source ?? 'Direct' }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="font-bold uppercase tracking-wider">{{ $contact->owner->name ?? 'Inconnu' }}</span>
                </div>
            </div>

            <!-- Card Actions -->
            <div class="flex items-center gap-2 pt-1">
                <a href="{{ route('contacts.show', $contact) }}" class="flex-1 inline-flex items-center justify-center py-2 bg-white/5 text-slate-300 text-[10px] font-bold rounded-xl hover:bg-white/10 hover:text-white transition-all">
                    <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Voir
                </a>
                @if($canEdit)
                <a href="{{ route('contacts.edit', $contact) }}" class="flex-1 inline-flex items-center justify-center py-2 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded-xl hover:bg-blue-500/20 transition-all">
                    <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Éditer
                </a>
                @endif
                @if($canEdit)
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="contents" onsubmit="return confirm('Supprimer ?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-10 h-9 inline-flex items-center justify-center bg-rose-500/10 text-rose-400 rounded-xl hover:bg-rose-500/20 transition-all">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
                @endif
            </div>
        </div>
    @empty
        <div class="py-16 text-center saas-card bg-white/5 border-dashed">
             <div class="flex flex-col items-center gap-3">
                <svg class="h-10 w-10 text-slate-700 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-widest italic opacity-50">Aucun contact trouvé</p>
            </div>
        </div>
    @endforelse
    <!-- CARD_VIEW_END -->
@endif
