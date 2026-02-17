<div class="space-y-6">
    <!-- Titre -->
    <div>
        <label for="titre" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2.5 ml-1">
            Titre de la mission <span class="text-rose-500">*</span>
        </label>
        <input type="text" name="titre" id="titre" required value="{{ old('titre') }}"
            class="w-full px-5 py-4 bg-white/[0.03] border {{ $errors->has('titre') ? 'border-rose-500' : 'border-white/10' }} rounded-2xl text-sm text-white placeholder-slate-600 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 focus:bg-white/[0.05] transition-all outline-none"
            placeholder="Ex: Rappeler M. Dupont pour le projet">
        @error('titre') <p class="text-[10px] text-rose-500 mt-2 font-bold uppercase tracking-wider ml-1">{{ $message }}</p> @enderror
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2.5 ml-1">Vision Globale</label>
        <textarea id="description" name="description" rows="3"
            class="w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-sm text-white placeholder-slate-600 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 focus:bg-white/[0.05] transition-all outline-none resize-none"
            placeholder="Détails stratégiques..."></textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Date Échéance -->
        <div>
            <label for="due_date" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2.5 ml-1">
                Échéance <span class="text-rose-500">*</span>
            </label>
            <input type="datetime-local" name="due_date" id="due_date" required value="{{ old('due_date', now()->addHour()->format('Y-m-d\TH:i')) }}"
                class="w-full px-5 py-4 bg-white/[0.03] border {{ $errors->has('due_date') ? 'border-rose-500' : 'border-white/10' }} rounded-2xl text-sm text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 focus:bg-white/[0.05] transition-all outline-none [color-scheme:dark]">
            @error('due_date') <p class="text-[10px] text-rose-500 mt-2 font-bold uppercase tracking-wider ml-1">{{ $message }}</p> @enderror
        </div>

        <!-- Assigné à -->
        <div>
            <label for="assigned_to" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2.5 ml-1">Agent Responsable</label>
            <select id="assigned_to" name="assigned_to" 
                class="w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-sm text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 focus:bg-white/[0.05] transition-all outline-none appearance-none cursor-pointer">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ auth()->id() == $user->id ? 'selected' : '' }} class="bg-slate-900 text-white">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Priorité -->
    <div>
        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">Niveau de Priorité</label>
        <div class="grid grid-cols-3 gap-4">
            <label class="relative cursor-pointer group">
                <input type="radio" class="peer sr-only" name="priority" value="low">
                <div class="flex items-center justify-center gap-2 px-4 py-4 rounded-2xl border border-white/10 bg-white/[0.02] text-slate-400 text-xs font-bold transition-all peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-400 hover:bg-white/[0.05]">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/30 peer-checked:bg-emerald-500"></span>
                    <span>Faible</span>
                </div>
            </label>
            <label class="relative cursor-pointer group">
                <input type="radio" class="peer sr-only" name="priority" value="medium" checked>
                <div class="flex items-center justify-center gap-2 px-4 py-4 rounded-2xl border border-white/10 bg-white/[0.02] text-slate-400 text-xs font-bold transition-all peer-checked:border-amber-500/50 peer-checked:bg-amber-500/10 peer-checked:text-amber-400 hover:bg-white/[0.05]">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500/30 peer-checked:bg-amber-500"></span>
                    <span>Moyenne</span>
                </div>
            </label>
            <label class="relative cursor-pointer group">
                <input type="radio" class="peer sr-only" name="priority" value="high">
                <div class="flex items-center justify-center gap-2 px-4 py-4 rounded-2xl border border-white/10 bg-white/[0.02] text-slate-400 text-xs font-bold transition-all peer-checked:border-rose-500/50 peer-checked:bg-rose-500/10 peer-checked:text-rose-400 hover:bg-white/[0.05]">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500/30 peer-checked:bg-rose-500"></span>
                    <span>Haute</span>
                </div>
            </label>
        </div>
    </div>

    <!-- Lié à -->
    <div x-data="{ type: 'none' }" class="border-t border-white/5 pt-6 mt-2">
        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 ml-1">
            Connexion Stratégique <span class="text-slate-600 text-[9px] ml-2 font-bold opacity-60">(optionnel)</span>
        </label>
        <div class="grid grid-cols-3 gap-3 mb-6">
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="link_type" value="none" x-model="type">
                <div class="flex items-center justify-center gap-2 px-3 py-3 rounded-xl border border-white/10 bg-white/[0.02] text-slate-500 text-[10px] font-black uppercase transition-all peer-checked:border-white/20 peer-checked:bg-white/5 peer-checked:text-white hover:bg-white/[0.05]">
                    <span>Aucun</span>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="link_type" value="contact" x-model="type">
                <div class="flex items-center justify-center gap-3 px-3 py-3 rounded-xl border border-white/10 bg-white/[0.02] text-slate-500 text-[10px] font-black uppercase transition-all peer-checked:border-blue-500/30 peer-checked:bg-blue-500/10 peer-checked:text-blue-400 hover:bg-white/[0.05]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Contact</span>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="link_type" value="opportunity" x-model="type">
                <div class="flex items-center justify-center gap-3 px-3 py-3 rounded-xl border border-white/10 bg-white/[0.02] text-slate-500 text-[10px] font-black uppercase transition-all peer-checked:border-purple-500/30 peer-checked:bg-purple-500/10 peer-checked:text-purple-400 hover:bg-white/[0.05]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Opportunité</span>
                </div>
            </label>
        </div>

        <input type="hidden" name="related_type" :value="type === 'contact' ? 'App\\Models\\Contact' : (type === 'opportunity' ? 'App\\Models\\Opportunity' : '')">
        
        <div x-show="type === 'contact'" x-transition x-cloak class="mt-4">
            <select name="related_id" :disabled="type !== 'contact'" 
                class="w-full px-5 py-4 bg-blue-500/5 border border-blue-500/20 rounded-2xl text-sm text-blue-100 focus:ring-2 focus:ring-blue-500/50 outline-none appearance-none cursor-pointer">
                <option value="" class="bg-slate-900">Sélectionner un contact</option>
                @foreach($contacts as $c)
                    <option value="{{ $c->id }}" class="bg-slate-900 text-white">{{ $c->prenom }} {{ $c->nom }} · {{ $c->entreprise }}</option>
                @endforeach
            </select>
        </div>

        <div x-show="type === 'opportunity'" x-transition x-cloak class="mt-4">
            <select name="related_id" :disabled="type !== 'opportunity'" 
                class="w-full px-5 py-4 bg-purple-500/5 border border-purple-500/20 rounded-2xl text-sm text-purple-100 focus:ring-2 focus:ring-purple-500/50 outline-none appearance-none cursor-pointer">
                <option value="" class="bg-slate-900">Sélectionner une opportunité</option>
                @foreach($opportunities as $o)
                    <option value="{{ $o->id }}" class="bg-slate-900 text-white">{{ $o->titre }} · {{ number_format($o->montant_estime, 0) }} €</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-4 pt-8 mt-4 border-t border-white/5">
        <button type="button" @click="if(typeof openTaskModal !== 'undefined') openTaskModal = false; else window.history.back();" 
            class="px-6 py-3.5 rounded-2xl border border-white/10 bg-white/[0.02] text-slate-400 text-[10px] font-black uppercase tracking-widest hover:bg-white/5 hover:text-white transition-all active:scale-95">
            Annuler
        </button>
        <button type="submit" 
            class="inline-flex items-center gap-3 px-8 py-3.5 rounded-2xl bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-blue-500 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Lancer la tâche</span>
        </button>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
.sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0; }
</style>