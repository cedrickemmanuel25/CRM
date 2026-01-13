@extends('layouts.app')

@section('title', 'Nouveau Ticket Support')

@section('content')
<div class="min-h-screen bg-[#fcfdfe]">
    <!-- Dynamic Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-50/50 rounded-full blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] bg-blue-50/50 rounded-full blur-[100px]"></div>
    </div>

    <!-- Top Navigation / Header -->
    <div class="relative bg-white border-b border-slate-200/60 shadow-sm z-20">
        <div class="max-w-[1440px] mx-auto px-6 h-24 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="h-14 w-14 bg-gradient-to-tr from-indigo-600 via-indigo-500 to-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 rotate-3 group-hover:rotate-0 transition-transform">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-none uppercase italic">Ticket <span class="text-indigo-600">Studio</span></h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1.5 flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Ouverture d'une nouvelle session support
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="button" onclick="document.getElementById('ticket-form').submit()" 
                    class="group relative inline-flex items-center px-10 py-4 bg-indigo-600 rounded-2xl text-white text-sm font-black uppercase tracking-widest overflow-hidden transition-all hover:bg-indigo-700 active:scale-95 shadow-xl shadow-indigo-600/20">
                    <span class="relative z-10 flex items-center">
                        <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        Propulser le ticket
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-6 py-12 relative z-10">
        <form id="ticket-form" action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- CONTENT ZONE -->
                <div class="lg:col-span-8 space-y-10">
                    
                    <!-- Main Editor Card -->
                    <div class="bg-white rounded-[2.5rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.05)] border border-slate-200 overflow-hidden group/card relative">
                        <div class="px-12 py-10 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                                <span class="h-10 w-1 bg-indigo-600 rounded-full"></span>
                                Objet & Description
                            </h2>
                        </div>
                        
                        <div class="p-12 space-y-12">
                            <!-- Subject Input -->
                            <div class="space-y-4">
                                <label for="subject" class="block text-xs font-black text-slate-400 uppercase tracking-widest transition-colors group-focus-within/subject:text-indigo-600" id="subject-label">Sujet de la demande</label>
                                <div class="relative group/subject">
                                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                        class="w-full px-0 py-4 bg-transparent border-0 border-b-2 border-slate-200 text-2xl font-black text-slate-900 placeholder-slate-300 focus:ring-0 focus:border-indigo-600 transition-all outline-none"
                                        placeholder="Ex: Problème d'accès à la plateforme...">
                                </div>
                                @error('subject') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <!-- Description Area -->
                            <div class="space-y-4">
                                <label for="description" class="block text-xs font-black text-slate-400 uppercase tracking-widest">Description détaillée</label>
                                <div class="relative p-8 bg-slate-50/50 rounded-3xl border border-slate-200 focus-within:bg-white focus-within:border-indigo-400 transition-all">
                                    <textarea name="description" id="description" rows="12" required
                                        class="w-full bg-transparent border-0 focus:ring-0 text-lg font-medium text-slate-700 leading-relaxed placeholder-slate-400 outline-none"
                                        placeholder="Décrivez votre problème en détail ici..."></textarea>
                                </div>
                                @error('description') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Professional Drag & Drop -->
                        <div class="bg-indigo-50/20 p-12 border-t border-slate-100">
                            <div class="relative group/upload h-64">
                                <input type="file" name="attachment" id="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="h-full flex flex-col items-center justify-center border-4 border-dashed border-indigo-200/50 rounded-[2rem] bg-white transition-all group-hover/upload:border-indigo-500 group-hover/upload:shadow-2xl group-hover/upload:shadow-indigo-500/10">
                                    <div class="h-20 w-20 bg-indigo-600 rounded-3xl flex items-center justify-center text-white mb-6 shadow-xl group-hover/upload:scale-110 transition-transform">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    </div>
                                    <p class="text-lg font-black text-slate-900 uppercase tracking-tight">Pièces jointes</p>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Glissez votre fichier technique ici</p>
                                    <div id="file-name-container" class="hidden mt-6 bg-slate-900 text-white px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-2xl scale-110 animate-fade-in">
                                        📎 <span id="file-name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR ZONE -->
                <div class="lg:col-span-4 space-y-10">
                    
                    <!-- Advanced Metadata Card -->
                    <div class="bg-[#1e293b] rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden group/meta">
                        <!-- Background Glow -->
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/20 rounded-full blur-[80px] group-hover/meta:bg-indigo-500/30 transition-colors"></div>
                        
                        <div class="relative z-10 space-y-10">
                            <h3 class="text-sm font-black uppercase tracking-[0.3em] text-indigo-400 border-b border-white/10 pb-6">Options Avancées</h3>

                            <!-- Category Grid -->
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-white/40">Catégorie du dossier</label>
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach([
                                        'technical' => 'Support Technique',
                                        'commercial' => 'Commercial',
                                        'billing' => 'Facturation',
                                        'feature_request' => 'Suggestion',
                                        'other' => 'Autre'
                                    ] as $val => $txt)
                                    <label class="flex items-center p-4 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition-all cursor-pointer group/opt">
                                        <input type="radio" name="category" value="{{ $val }}" {{ $val === 'technical' ? 'checked' : '' }} class="sr-only peer">
                                        <div class="h-5 w-5 rounded-full border-2 border-white/20 mr-4 flex items-center justify-center peer-checked:border-indigo-500 transition-all">
                                            <div class="h-2.5 w-2.5 rounded-full bg-indigo-500 scale-0 peer-checked:scale-100 transition-transform"></div>
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-widest text-white/70 peer-checked:text-white transition-colors">{{ $txt }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- High-Impact Priority -->
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-white/40">Urgence du ticket</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['low' => 'Slow', 'medium' => 'Norm', 'high' => 'High', 'urgent' => 'CRIT'] as $val => $txt)
                                    <label class="flex-1 text-center py-4 rounded-xl border-2 border-white/5 bg-white/5 cursor-pointer hover:border-white/20 transition-all group/prio">
                                        <input type="radio" name="priority" value="{{ $val }}" {{ $val === 'medium' ? 'checked' : '' }} class="sr-only peer">
                                        <span class="text-[10px] font-black uppercase tracking-tighter text-white/40 peer-checked:text-indigo-400 transition-all">{{ $txt }}</span>
                                        <div class="mx-auto mt-2 h-1.5 w-8 rounded-full bg-white/10 peer-checked:bg-indigo-500 transition-all"></div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Client Match Card -->
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200 shadow-xl group/client">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="h-14 w-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover/client:bg-indigo-600 group-hover/client:text-white transition-all duration-500">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-slate-900 tracking-tight leading-none uppercase italic">Client <span class="text-indigo-600">ID</span></h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Synchonisation Contact</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="relative group/select">
                                <select name="contact_id" required class="block w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-[13px] font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                                    <option value="">Sélectionner le client...</option>
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact->id }}" {{ (request('contact_id') == $contact->id) || old('contact_id') == $contact->id ? 'selected' : '' }}>
                                            {{ $contact->nom_complet }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-slate-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            
                            <div class="p-6 bg-indigo-50/50 rounded-3xl border border-indigo-100/50">
                                <p class="text-[11px] font-bold text-indigo-600/70 leading-relaxed italic text-center">
                                    "L'historique client sera automatiquement lié à ce nouveau ticket après validation."
                                </p>
                            </div>

                            <!-- Responsable -->
                            <div class="space-y-4 pt-4 border-t border-slate-100">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Agent en charge</label>
                                <div class="relative group/agent">
                                    <select name="assigned_to" class="block w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-[13px] font-black text-slate-800 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                                        <option value="">Auto-Assignation</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-slate-400">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('attachment').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '';
        const nameDisplay = document.getElementById('file-name');
        const container = document.getElementById('file-name-container');
        
        if (fileName) {
            nameDisplay.textContent = fileName;
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    });

    // Subject Focus Label Toggle
    const subjInput = document.getElementById('subject');
    subjInput.addEventListener('focus', () => {
        document.getElementById('subject-label').classList.add('text-indigo-600');
    });
    subjInput.addEventListener('blur', () => {
        if(!subjInput.value) document.getElementById('subject-label').classList.remove('text-indigo-600');
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1.1); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
</style>
@endsection
