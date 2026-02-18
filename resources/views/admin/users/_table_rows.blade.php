@foreach($users as $user)
<tr x-show="!search || $el.innerText.toLowerCase().includes(search.toLowerCase())" class="hover:bg-white/[0.02] transition-all duration-300 group/row">
    <td class="whitespace-nowrap py-5 pl-4 pr-3 sm:pl-6 text-sm">
        <div class="flex items-center">
            <div class="h-11 w-11 flex-shrink-0 relative">
                @php
                    $initials = collect(explode(' ', $user->name))->map(fn($part) => substr($part, 0, 1))->take(2)->join('');
                    $colorClasses = $user->role === 'admin' ? 'bg-indigo-500/20 text-indigo-400 border-indigo-500/30' : 
                                   ($user->role === 'commercial' ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' : 
                                   ($user->role === 'support' ? 'bg-blue-500/20 text-blue-400 border-blue-500/30' : 'bg-slate-500/20 text-slate-400 border-slate-500/30'));
                @endphp
                <div class="h-11 w-11 rounded-xl {{ $colorClasses }} border flex items-center justify-center font-bold text-xs shadow-inner overflow-hidden" 
                     style="{{ $user->avatar ? 'background-image: url(' . asset('storage/' . $user->avatar) . '); background-size: cover; background-position: center;' : '' }}">
                    {{ $user->avatar ? '' : $initials }}
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 block h-3.5 w-3.5 rounded-full bg-emerald-500 border-2 border-[#020617]" title="Actif"></span>
            </div>
            <div class="ml-4">
                <div class="font-bold text-slate-100 group-hover/row:text-blue-400 transition-colors">{{ $user->name }}</div>
                <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ $user->email }}</div>
            </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-sm">
        <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-widest leading-none
            {{ $user->role === 'admin' ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 
                ($user->role === 'commercial' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 
                ($user->role === 'support' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : 'bg-slate-500/10 text-slate-400 border border-slate-500/20')) }}">
            {{ $user->role }}
        </span>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-xs font-bold text-slate-400">
        <div class="flex items-center space-x-2">
            <svg class="h-3.5 w-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <span class="tracking-wide">{{ format_phone($user->telephone) ?: 'SILENCE' }}</span>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-xs">
        <div class="flex flex-col">
            <span class="font-bold text-slate-300">{{ $user->created_at->translatedFormat('d M Y') }}</span>
            <span class="text-[9px] text-slate-500 uppercase font-black tracking-widest">{{ $user->created_at->diffForHumans() }}</span>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-sm text-center">
        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 shadow-lg shadow-emerald-500/5">
            Actif
        </span>
    </td>
    <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
        <div class="flex justify-end items-center space-x-2">
            <button type="button" @click="openEdit({{ $user }})" 
                class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 text-slate-500 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg transition-all" 
                title="Modifier">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>

            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" 
                class="contents"
                onsubmit="return confirm('Attention : Cette action réinitialisera le mot de passe de cet utilisateur à \'password\'. Voulez-vous continuer ?');">
                @csrf
                <button type="submit" 
                    class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 text-slate-500 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition-all" 
                    title="Réinitialiser le mot de passe">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </button>
            </form>

            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                class="contents"
                onsubmit="return confirm('Attention : La suppression d\'un utilisateur est irréversible. Toutes ses données associées seront conservées mais son accès sera révoqué. Confirmer ?');">
                @csrf @method('DELETE')
                <button type="submit" 
                    class="flex-shrink-0 inline-flex items-center justify-center h-8 w-8 text-slate-500 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all" 
                    title="Révoquer l'accès">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
            @endif
        </div>
    </td>
</tr>
@endforeach

