@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
<div class="min-h-full bg-gradient-to-br from-slate-50 via-white to-slate-50/30 py-6" x-data="{ showReply: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                    <li class="hover:text-indigo-600 transition-colors">
                        <a href="{{ route('tickets.index') }}" class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            Support
                        </a>
                    </li>
                    <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-slate-700 font-semibold">Détails du ticket #{{ $ticket->id }}</li>
                </ol>
            </nav>

            <!-- Title & Quick Actions -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        #{{ $ticket->id }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $ticket->subject }}</h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-wide">
                                @switch($ticket->category)
                                    @case('technical') 🛠️ Technique @break
                                    @case('commercial') 💼 Commercial @break
                                    @case('billing') 💳 Facturation @break
                                    @case('feature_request') 💡 Suggestion @break
                                    @default ❓ Autre
                                @endswitch
                            </span>
                            <span class="text-xs text-slate-400 font-medium tracking-tight">Ouvert par {{ $ticket->creator->name ?? 'Utilisateur inconnu' }} • {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-all shadow-sm">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Modifier
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isSupport() || $ticket->user_id === auth()->id())
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce ticket ?');" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-200" title="Supprimer">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT AREA: Conversation & Description -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Initial Message Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Description initiale</span>
                        <span class="text-[10px] font-bold text-slate-400 capitalize">{{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="p-8">
                        <p class="text-[15px] text-slate-700 leading-relaxed whitespace-pre-line">{{ $ticket->description }}</p>
                        
                        @if($ticket->attachment)
                        <div class="mt-12 pt-8 border-t border-slate-100">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Document rattaché</h4>
                            <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" class="inline-flex items-center p-5 bg-white border border-slate-200 rounded-2xl hover:bg-indigo-50/30 hover:border-indigo-300 hover:shadow-lg hover:shadow-indigo-500/5 transition-all group max-w-sm">
                                <div class="h-14 w-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center text-white mr-5 group-hover:scale-110 transition-transform shadow-md">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="text-sm font-bold text-slate-900 truncate">{{ basename($ticket->attachment) }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-indigo-100 text-indigo-700 mt-1 uppercase tracking-tighter">Ouvrir le fichier</span>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Responses Journal -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between px-2">
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Fil de discussion</h3>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $ticket->activities->where('type', 'interaction')->count() }} messages</span>
                    </div>
                    
                    <div class="flow-root px-1">
                        <ul class="-mb-8">
                            @foreach($ticket->activities->where('type', 'interaction') as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last) <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span> @endif
                                    <div class="relative flex items-start space-x-4">
                                        <div class="relative">
                                            <div class="h-10 w-10 flex items-center justify-center rounded-xl shadow-md border {{ ($activity->user && $activity->user->isSupport()) ? 'bg-indigo-600 text-white border-indigo-700' : 'bg-white text-slate-500 border-slate-200' }} font-black text-sm transition-transform hover:scale-110">
                                                {{ substr($activity->user->name ?? '?', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="bg-white rounded-2xl shadow-sm border {{ ($activity->user && $activity->user->isSupport()) ? 'border-indigo-100 bg-indigo-50/10' : 'border-slate-200' }} p-6 transition-all hover:shadow-md">
                                                <div class="flex items-center justify-between mb-3">
                                                    <div class="flex items-center gap-2">
                                                        <p class="text-sm font-black text-slate-900">{{ $activity->user->name ?? 'Inconnu' }}</p>
                                                        @if($activity->user && $activity->user->isSupport())
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[8px] font-black bg-indigo-600 text-white uppercase tracking-tighter">Support</span>
                                                        @endif
                                                    </div>
                                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $activity->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-[14px] text-slate-600 leading-relaxed font-medium whitespace-pre-line">{{ $activity->contenu }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Reply Form -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden focus-within:ring-4 focus-within:ring-indigo-500/10 transition-all">
                    <form action="{{ route('tickets.response', $ticket) }}" method="POST">
                        @csrf
                        <div class="bg-gradient-to-r from-slate-50 to-white px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Répondre au client</span>
                            </div>
                        </div>
                        <textarea name="message" rows="5" class="w-full border-0 focus:ring-0 text-[15px] p-8 font-medium text-slate-800 placeholder-slate-400" placeholder="Votre message ici..." required></textarea>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2 opacity-60">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter">Notification email automatique</p>
                            </div>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 shadow-lg shadow-indigo-600/20 text-sm font-black rounded-xl text-white hover:bg-indigo-700 transition-all active:scale-95 leading-none">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RIGHT AREA: Sidebar Info -->
            <div class="space-y-6">
                <!-- Status & Assignation Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100/30 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                        <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Configuration</span>
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <div class="p-5 space-y-6">
                        @php
                            $statusClasses = match($ticket->status) {
                                'new' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'in_progress' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'waiting_client' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'closed' => 'bg-gray-50 text-gray-600 border-gray-200',
                                default => 'bg-gray-50 text-gray-600 border-gray-200',
                            };
                            $priorityColor = match($ticket->priority) {
                                'urgent' => 'text-rose-600',
                                'high' => 'text-orange-500',
                                'medium' => 'text-blue-500',
                                'low' => 'text-slate-400',
                                default => 'text-slate-400',
                            };
                            $priorityLabels = [
                                'urgent' => 'Urgent',
                                'high' => 'Haute',
                                'medium' => 'Moyenne',
                                'low' => 'Basse',
                            ];
                            $priorityLabel = $priorityLabels[$ticket->priority] ?? ucfirst($ticket->priority);
                        @endphp
                        <!-- Status Pills -->
                        <div class="space-y-2">
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Statut du ticket</p>
                             <div class="flex">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black border {{ $statusClasses }} uppercase tracking-tighter shadow-sm w-full justify-center">
                                    {{ str_replace('_', ' ', $ticket->status) }}
                                </span>
                             </div>
                        </div>

                        <!-- Priority -->
                        <div class="space-y-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Niveau d'urgence</p>
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200/50 shadow-inner">
                                <div class="h-3 w-3 rounded-full {{ $ticket->priority === 'urgent' ? 'bg-rose-600 animate-pulse' : ($ticket->priority === 'high' ? 'bg-orange-500 shadow-[0_0_10px_rgba(249,115,22,0.3)]' : 'bg-blue-500') }}"></div>
                                <span class="text-xs font-black uppercase tracking-wide {{ $priorityColor }}">{{ $priorityLabel }}</span>
                            </div>
                        </div>

                        <!-- Assignee -->
                        <div class="space-y-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Agent responsable</p>
                            @if($ticket->assignee)
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-indigo-50/50 border border-indigo-100 hover:bg-indigo-100/50 transition-colors">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-xs font-black shadow-md">
                                    {{ substr($ticket->assignee->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-black text-slate-900 truncate leading-none mb-1">{{ $ticket->assignee->name }}</p>
                                    <span class="text-[9px] text-indigo-600 font-black uppercase tracking-widest opacity-70">{{ $ticket->assignee->role }}</span>
                                </div>
                            </div>
                            @else
                            <div class="p-6 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/30 flex flex-col items-center justify-center text-center group">
                                <button class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                </button>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Prendre en charge</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Client Box (Vibrant Refined) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 px-5 py-4 border-b border-indigo-700 flex items-center justify-between">
                         <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-xs font-bold text-white uppercase tracking-widest">Fiche Client</span>
                        </div>
                        @if($ticket->contact)
                        <a href="{{ route('contacts.show', $ticket->contact) }}" class="text-white opacity-60 hover:opacity-100 transition-opacity">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                        @endif
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="flex flex-col">
                            <p class="text-base font-black text-slate-900 tracking-tight leading-tight">{{ $ticket->contact->nom_complet ?? 'Client Inconnu' }}</p>
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mt-0.5">{{ $ticket->contact ? ($ticket->contact->entreprise ?? 'Client Indépendant') : 'N/A' }}</p>
                        </div>
                        
                        <div class="space-y-2 pt-2 border-t border-slate-100">
                            <div class="flex items-center text-xs font-semibold text-slate-600">
                                <div class="h-6 w-6 rounded bg-slate-50 flex items-center justify-center mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="truncate">{{ $ticket->contact->email ?? 'Non renseigné' }}</span>
                            </div>
                            @if($ticket->contact && $ticket->contact->telephone)
                            <div class="flex items-center text-xs font-semibold text-slate-600">
                                <div class="h-6 w-6 rounded bg-slate-50 flex items-center justify-center mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <span>{{ $ticket->contact->telephone }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-3">
                    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                        @csrf @method('PUT')
                        @if($ticket->status !== 'resolved')
                        <input type="hidden" name="status" value="resolved">
                        <button type="submit" class="w-full bg-slate-900 border border-transparent text-white text-[11px] font-black uppercase tracking-widest py-4 rounded-2xl hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/10 active:scale-95 leading-none">
                            Félicitations, Résoudre !
                        </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
