@extends('layouts.app')

@section('title', 'Logs d\'Audit v2')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
            <h1 class="page-title">Journal <span class="accent">d'Audit</span></h1>
            <p class="mt-2 text-sm text-slate-400 font-medium">Historique des actions sensibles et des événements système.</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="mt-8">
        <!-- Desktop/Tablet View (Table) -->
        <div class="hidden lg:block">
            <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle md:px-6 lg:px-8">
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 md:rounded-3xl shadow-2xl">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead class="bg-white/[0.02]">
                                <tr>
                                    <th scope="col" class="py-5 pl-4 pr-3 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] sm:pl-8">Date</th>
                                    <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Utilisateur</th>
                                    <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Action</th>
                                    <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cible</th>
                                    <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Détails</th>
                                    <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">IP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 bg-transparent">
                                @forelse($logs as $log)
                                <tr class="hover:bg-white/[0.02] transition-colors duration-200 group/row">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-[10px] font-bold text-slate-400 sm:pl-8">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-xs">
                                        <div class="flex items-center">
                                            @if($log->user)
                                                <div class="h-6 w-6 rounded-md bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 font-black text-[10px] mr-2 shadow-inner">
                                                    {{ substr($log->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-slate-100 group-hover/row:text-blue-400 transition-colors text-xs">{{ $log->user->name }}</div>
                                                    <div class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">{{ \Illuminate\Support\Str::limit($log->user->email, 20) }}</div>
                                                </div>
                                            @else
                                                <span class="italic text-slate-500 font-medium text-[10px]">Système</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-xs">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                            {{ $log->translated_action }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-xs">
                                        @if($log->model_type)
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-300 text-[10px]">{{ $log->translated_model_type }}</span>
                                                <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wide">ID: {{ $log->model_id }}</span>
                                            </div>
                                        @else
                                            <span class="text-slate-600">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 text-xs max-w-[150px] truncate">
                                        <div x-data="{ open: false }">
                                            <button @click="open = true" class="text-blue-400 hover:text-blue-300 text-[10px] font-bold transition-colors uppercase tracking-wide">Voir</button>
                                            
                                            <!-- Enterprise Modal/Details -->
                                            @include('admin.audit_logs._details_modal')
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-[10px] font-mono text-slate-500">
                                        {{ $log->ip_address }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-10 text-sm text-slate-500 text-center italic">
                                        Aucun log d'audit trouvé.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="lg:hidden space-y-4">
            @forelse($logs as $log)
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl p-6 space-y-4 transition-all active:scale-[0.98]">
                <!-- Card Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($log->user)
                            <div class="h-10 w-10 rounded-xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 font-black text-xs shadow-inner">
                                {{ substr($log->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-white uppercase tracking-wide leading-tight">{{ $log->user->name }}</h4>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider truncate max-w-[150px]">{{ $log->user->email }}</p>
                            </div>
                        @else
                            <div class="h-10 w-10 rounded-xl bg-slate-500/10 border border-slate-500/20 flex items-center justify-center text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-300 uppercase tracking-wide italic">Système</h4>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Action auto</p>
                            </div>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black bg-white/5 text-slate-300 border border-white/10 uppercase tracking-widest">
                        {{ $log->translated_action }}
                    </span>
                </div>

                <!-- Card Body (Vertical Stack) -->
                <div class="py-4 border-y border-white/5 space-y-4">
                    <!-- Target Row -->
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex-shrink-0">
                            <svg class="h-4 w-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.2em] mb-1">Cible de l'action</p>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-xs font-bold text-slate-300">{{ $log->translated_model_type ?? '-' }}</span>
                                @if($log->model_id)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded border border-white/10 bg-white/5 text-[9px] text-slate-400 font-mono">
                                        ID #{{ $log->model_id }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- IP Row -->
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex-shrink-0">
                            <svg class="h-4 w-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.828a5 5 0 117.07 0M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.2em] mb-1">Source (IP)</p>
                            <div class="bg-black/20 rounded-xl border border-white/5 p-2.5">
                                <code class="text-[10px] text-slate-400 font-mono break-all leading-relaxed block w-full">
                                    {{ $log->ip_address }}
                                </code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer/Action -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5 text-[10px] text-slate-300 font-bold whitespace-nowrap uppercase tracking-wide">
                            <svg class="h-3.5 w-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            {{ $log->created_at->format('d/m/Y') }}
                        </div>
                        <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest ml-5">{{ $log->created_at->format('H:i') }} ({{ $log->created_at->diffForHumans() }})</p>
                    </div>
                    
                    <div x-data="{ open: false }" class="flex-shrink-0">
                        <button @click="open = true" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-blue-500/20 hover:bg-blue-500 transition-all active:scale-95 whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                            Détails
                        </button>
                        
                        <!-- Enterprise Modal/Details (Shared Partial) -->
                        @include('admin.audit_logs._details_modal')
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-slate-900/40 rounded-3xl border-2 border-dashed border-white/5 p-12 text-center">
                <p class="text-sm text-slate-500 italic">Aucun log d'audit trouvé.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
