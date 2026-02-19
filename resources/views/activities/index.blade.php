@extends('layouts.app')

@section('title', 'Historique des activités - CRM')

@section('content')
<style>
    :root {
        --enterprise-bg: #0f172a;
        --enterprise-card: rgba(30, 41, 59, 0.4);
        --enterprise-border: rgba(255, 255, 255, 0.08);
        --enterprise-accent: #3b82f6;
    }

    .saas-card {
        background: var(--enterprise-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--enterprise-border);
        border-radius: 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .saas-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .label-caps {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
    }

    /* Custom Scrollbar */
    .saas-scroll::-webkit-scrollbar { width: 4px; }
    .saas-scroll::-webkit-scrollbar-track { background: transparent; }
    .saas-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>

<div class="w-full flex flex-col bg-[#0f172a] min-h-screen text-slate-100">
    <div class="px-4 sm:px-6 lg:px-8 py-6 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        <li class="hover:text-slate-300 transition-colors">CRM PRO</li>
                        <li><svg class="h-3 w-3 text-slate-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-blue-500">Activités</li>
                    </ol>
                </nav>
                <h1 class="page-title">Journal <span class="accent">d'Activité</span></h1>
                <p class="text-slate-500 text-sm mt-1">Historique complet de vos interactions et rappels.</p>
            </div>
            <div class="bg-white/5 p-4 rounded-2xl border border-white/10 text-blue-500 shadow-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="saas-card overflow-hidden">
            <div class="p-6 sm:p-10">
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($activities as $activity)
                        <li>
                            <div class="relative pb-12">
                                @if(!$loop->last)
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-white/5" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex items-start space-x-6">
                                    <div class="relative">
                                        @php
                                            $iconBg = match($activity->type) {
                                                'appel' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                'email' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                'reunion' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                                'note' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                                'ticket' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                                default => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20'
                                            };
                                        @endphp
                                        <span class="h-11 w-11 rounded-xl flex items-center justify-center border shadow-lg {{ $iconBg }}">
                                            @if($activity->type === 'appel')
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            @elseif($activity->type === 'email')
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            @elseif($activity->type === 'reunion')
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @else
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 py-1">
                                        <div class="text-sm">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                                                <p class="font-bold text-slate-100 text-base">{{ $activity->description }}</p>
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap bg-white/5 px-2 py-1 rounded-lg border border-white/5">{{ $activity->date_activite->translatedFormat('d F Y · H:i') }}</span>
                                            </div>
                                            <p class="mt-1 text-[10px] text-slate-500 font-bold uppercase tracking-wider">
                                                Par <span class="text-blue-400 font-black">{{ $activity->user->name }}</span>
                                                @if($activity->parent)
                                                    <span class="mx-2 text-slate-700">/</span> Lié à <span class="text-slate-300">{{ $activity->parent->nom_complet ?? $activity->parent->titre ?? 'Élément' }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        @if($activity->contenu)
                                        <div class="mt-5 text-sm text-slate-400 bg-white/[0.02] p-6 rounded-2xl border border-white/5 leading-relaxed italic relative">
                                            <div class="absolute -left-2 top-6 w-1 h-8 bg-blue-500/30 rounded-full"></div>
                                            {!! nl2br(e($activity->contenu)) !!}
                                        </div>
                                        @endif

                                        @if($activity->piece_jointe)
                                        <div class="mt-4">
                                            <a href="{{ asset('storage/' . $activity->piece_jointe) }}" target="_blank" class="inline-flex items-center gap-3 px-4 py-2 bg-blue-500/10 text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-xl border border-blue-500/20 hover:bg-blue-500/20 transition-all">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                Pièce Jointe
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @empty
                        <div class="text-center py-20 bg-white/5 rounded-[2rem] border border-dashed border-white/10">
                            <div class="bg-white/5 w-24 h-24 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 text-slate-700 border border-white/5">
                                <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">Vide</h3>
                            <p class="text-slate-600 text-[9px] font-bold uppercase tracking-widest mt-3">Aucune activité enregistrée</p>
                        </div>
                        @endforelse
                    </ul>
                </div>

                <div class="mt-12 bg-slate-900/50 p-6 rounded-2xl border border-white/5">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
