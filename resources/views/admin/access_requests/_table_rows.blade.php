@forelse($requests as $request)
    <tr class="hover:bg-blue-900/10 transition-colors duration-200 group/row border-b border-white/5">
        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
            <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-400 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                        <span class="text-white font-black text-xs">{{ strtoupper(substr($request->prenom, 0, 1) . substr($request->nom, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="font-bold text-white group-hover/row:text-cyan-400 transition-colors">{{ $request->prenom }} {{ $request->nom }}</div>
                </div>
            </div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm">
            <div class="text-sm font-medium text-slate-300">{{ $request->email }}</div>
            <div class="text-xs font-bold text-slate-500 tracking-wide">{{ format_phone($request->telephone) }}</div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm">
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-[0_0_10px_rgba(6,182,212,0.1)]">
                {{ $request->role }}
            </span>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-xs font-bold text-slate-400">
            {{ $request->created_at->format('d/m/Y H:i') }}
        </td>
        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-8">
            <div class="flex justify-end items-center gap-3">
                <form action="{{ route('admin.access-requests.approve', $request->id) }}" method="POST" onsubmit="return confirm('Créer cet utilisateur ?')">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20 hover:text-emerald-400 border border-emerald-500/20 transition-all font-bold text-xs uppercase tracking-wider">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Approuver
                    </button>
                </form>
                <form action="{{ route('admin.access-requests.reject', $request->id) }}" method="POST" onsubmit="return confirm('Rejeter cette demande ?')">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-500 hover:bg-rose-500/20 hover:text-rose-400 border border-rose-500/20 transition-all font-bold text-xs uppercase tracking-wider">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Rejeter
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="h-12 w-12 rounded-full bg-slate-800/50 flex items-center justify-center mb-3 border border-white/5">
                    <svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-500">Aucune demande d'accès en attente.</p>
            </div>
        </td>
    </tr>
@endforelse
