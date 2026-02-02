@foreach($users as $user)
<tr x-show="!search || $el.innerText.toLowerCase().includes(search.toLowerCase())" class="hover:bg-gray-50/80 transition-all duration-200">
    <td class="whitespace-nowrap py-5 pl-4 pr-3 sm:pl-6 text-sm">
        <div class="flex items-center">
            <div class="h-11 w-11 flex-shrink-0 relative">
                @php
                    $initials = collect(explode(' ', $user->name))->map(fn($part) => substr($part, 0, 1))->take(2)->join('');
                    $colorClasses = $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 
                                   ($user->role === 'commercial' ? 'bg-emerald-100 text-emerald-700' : 
                                   ($user->role === 'support' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-700'));
                @endphp
                <div class="h-11 w-11 rounded-xl {{ $colorClasses }} flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm overflow-hidden" 
                     style="{{ $user->avatar ? 'background-image: url(' . asset('storage/' . $user->avatar) . '); background-size: cover; background-position: center;' : '' }}">
                    {{ $user->avatar ? '' : $initials }}
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 block h-3.5 w-3.5 rounded-full bg-green-400 ring-2 ring-white" title="Actif"></span>
            </div>
            <div class="ml-4">
                <div class="font-bold text-gray-900">{{ $user->name }}</div>
                <div class="text-xs text-gray-400 font-medium">{{ $user->email }}</div>
            </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-sm">
        <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold leading-none
            {{ $user->role === 'admin' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 
                ($user->role === 'commercial' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 
                ($user->role === 'support' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-50 text-slate-700 border border-slate-100')) }}">
            <svg class="mr-1.5 h-1.5 w-1.5 {{ $user->role === 'admin' ? 'text-indigo-400' : ($user->role === 'commercial' ? 'text-emerald-400' : 'text-blue-400') }}" fill="currentColor" viewBox="0 0 8 8">
                <circle cx="4" cy="4" r="3" />
            </svg>
            {{ ucfirst($user->role) }}
        </span>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-xs font-medium text-gray-500">
        <div class="flex items-center space-x-1">
            <svg class="h-4 w-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <span>{{ format_phone($user->telephone) ?: 'Non renseigné' }}</span>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-xs text-gray-500">
        <div class="flex flex-col">
            <span class="font-bold text-gray-700">{{ $user->created_at->translatedFormat('d M Y') }}</span>
            <span class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $user->created_at->diffForHumans() }}</span>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-sm text-center">
        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
            Actif
        </span>
    </td>
    <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
        <div class="flex justify-end items-center space-x-3">
            
            <button type="button" @click="openEdit({{ $user }})" 
                class="p-2 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-xl transition-all duration-200 group" 
                title="Modifier l'utilisateur">
                <svg class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>

            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" 
                onsubmit="return confirm('Attention : Cette action réinitialisera le mot de passe de cet utilisateur à \'password\'. Voulez-vous continuer ?');">
                @csrf
                <button type="submit" 
                    class="p-2 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all duration-200 group" 
                    title="Réinitialiser le mot de passe">
                    <svg class="h-5 w-5 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </button>
            </form>

            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                onsubmit="return confirm('Attention : La suppression d\'un utilisateur est irréversible. Toutes ses données associées seront conservées mais son accès sera révoqué. Confirmer ?');">
                @csrf @method('DELETE')
                <button type="submit" 
                    class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-all duration-200 group" 
                    title="Supprimer définitivement">
                    <svg class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
            @endif
        </div>
    </td>
</tr>
@endforeach

