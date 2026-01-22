@forelse($contacts as $contact)
    @php
        $isOwner = auth()->id() === $contact->user_id_owner;
        $canEdit = auth()->user()->isAdmin() || (auth()->user()->isCommercial() && $isOwner);
    @endphp
<tr class="hover:bg-slate-50/50 transition-colors group align-top">
    <td class="px-3 py-4 break-words">
        <div class="flex items-center">
            <div class="relative flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                    {{ strtoupper(substr($contact->prenom, 0, 1)) }}{{ strtoupper(substr($contact->nom, 0, 1)) }}
                </div>
            </div>
            <div class="ml-3 min-w-0">
                <div class="text-xs font-semibold text-slate-900 truncate">{{ $contact->prenom }} {{ $contact->nom }}</div>
                <div class="text-[10px] text-slate-500 font-medium">ID: #{{ $contact->id }}</div>
            </div>
        </div>
    </td>
    <td class="px-3 py-4 break-words">
        <div class="text-xs font-semibold text-slate-900">{{ $contact->entreprise ?? 'Indépendant' }}</div>
        <div class="text-[10px] text-slate-500">{{ $contact->poste ?? 'Poste non précisé' }}</div>
    </td>
    <td class="px-3 py-4">
        <div class="space-y-1">
            <div class="flex items-start text-xs text-slate-700">
                <svg class="h-4 w-4 text-slate-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="truncate block w-full" title="{{ $contact->email }}">{{ $contact->email }}</span>
            </div>
            @if($contact->telephone)
            <div class="flex items-center text-[10px] text-slate-500">
                <svg class="h-4 w-4 text-slate-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span class="truncate">{{ format_phone($contact->telephone) }}</span>
            </div>
            @endif
        </div>
    </td>
    <td class="px-3 py-4">
        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700">
            {{ $contact->source ?? 'Autre' }}
        </span>
    </td>
    <td class="px-3 py-4 break-words">
        <div class="flex items-center">
            <span class="text-xs font-medium text-slate-700 truncate">{{ $contact->owner->name ?? 'Inconnu' }}</span>
        </div>
    </td>
    <td class="px-3 py-4 whitespace-nowrap">
        <div class="text-xs text-slate-900 font-medium">{{ $contact->created_at->format('d/m/Y') }}</div>
        <div class="text-[10px] text-slate-500">{{ $contact->created_at->diffForHumans() }}</div>
    </td>
    <td class="px-3 py-4 text-right whitespace-nowrap">
        <div class="flex items-center justify-end space-x-1">
            <a href="{{ route('contacts.show', $contact) }}" class="inline-flex items-center justify-center h-8 w-8 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Voir les détails">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </a>
            @if($canEdit)
            <a href="{{ route('contacts.edit', $contact) }}" class="inline-flex items-center justify-center h-8 w-8 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Modifier">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </a>
            @endif
            @if(auth()->user()->isSupport())
            <a href="{{ route('contacts.show', $contact) }}#activities" class="inline-flex items-center justify-center h-8 w-8 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Ajouter une note">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </a>
            @endif
            @if($canEdit)
            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?');">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center h-8 w-8 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Supprimer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-6 py-16 text-center">
        <div class="flex flex-col items-center">
            <div class="h-16 w-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-1">Aucun contact trouvé</h3>
                <p class="text-sm text-slate-500 mb-6 max-w-sm">Modifiez vos filtres de recherche.</p>
            <a href="{{ route('contacts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Réinitialiser</a>
        </div>
    </td>
</tr>
@endforelse
