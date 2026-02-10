@extends('layouts.app')

@section('title', 'Journal d\'Activité - Nexus CRM')

@section('content')
<div class="px-8 py-8 bg-[#F4F7FC]/30 min-h-screen">
    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Journal d'Activité</h1>
                <p class="text-slate-500 text-sm mt-1">Historique complet de vos interactions et rappels.</p>
            </div>
            <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100 text-[#4C7CDF]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8">
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($activities as $activity)
                        <li>
                            <div class="relative pb-12">
                                @if(!$loop->last)
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-slate-100" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex items-start space-x-4">
                                    <div class="relative">
                                        @php
                                            $iconColor = match($activity->type) {
                                                'appel' => 'bg-emerald-100 text-emerald-600',
                                                'email' => 'bg-blue-100 text-[#4C7CDF]',
                                                'reunion' => 'bg-amber-100 text-amber-600',
                                                'note' => 'bg-slate-100 text-slate-600',
                                                'ticket' => 'bg-rose-100 text-rose-600',
                                                default => 'bg-indigo-100 text-indigo-600'
                                            };
                                        @endphp
                                        <span class="h-10 w-10 rounded-xl flex items-center justify-center ring-8 ring-white {{ $iconColor }}">
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
                                            <div class="flex justify-between items-start">
                                                <p class="font-bold text-slate-900">{{ $activity->description }}</p>
                                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">{{ $activity->date_activite->translatedFormat('d F Y · H:i') }}</span>
                                            </div>
                                            <p class="mt-0.5 text-xs text-slate-400 font-bold uppercase tracking-tighter">
                                                Par <span class="text-[#4C7CDF]">{{ $activity->user->name }}</span>
                                                @if($activity->parent)
                                                    • Lié à <span class="text-slate-600">{{ $activity->parent->nom_complet ?? $activity->parent->titre ?? 'Élément' }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        @if($activity->contenu)
                                        <div class="mt-4 text-sm text-slate-600 bg-slate-50/50 p-4 rounded-xl border border-slate-100 leading-relaxed italic">
                                            {!! nl2br(e($activity->contenu)) !!}
                                        </div>
                                        @endif

                                        @if($activity->piece_jointe)
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/' . $activity->piece_jointe) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-100 transition-colors">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                Voir la pièce jointe
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @empty
                        <div class="text-center py-20">
                            <div class="bg-slate-50 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-700">Aucune activité enregistrée</h3>
                            <p class="text-slate-400 text-sm mt-2">Les activités apparaîtront ici dès qu'une interaction sera loggée.</p>
                        </div>
                        @endforelse
                    </ul>
                </div>

                <div class="mt-12">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
