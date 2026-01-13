<div class="space-y-5">
    <!-- Titre -->
    <div>
        <label for="titre" class="block text-sm font-medium text-slate-700 mb-1.5">
            Titre <span class="text-red-500">*</span>
        </label>
        <input type="text" name="titre" id="titre" required
            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
            placeholder="Ex: Rappeler M. Dupont pour le projet">
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
        <textarea id="description" name="description" rows="3"
            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
            placeholder="Ajouter des détails sur cette tâche..."></textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <!-- Date Échéance -->
        <div>
            <label for="due_date" class="block text-sm font-medium text-slate-700 mb-1.5">
                Échéance <span class="text-red-500">*</span>
            </label>
            <input type="datetime-local" name="due_date" id="due_date" required
                class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
        </div>

        <!-- Assigné à -->
        <div>
            <label for="assigned_to" class="block text-sm font-medium text-slate-700 mb-1.5">Assigné à</label>
            <select id="assigned_to" name="assigned_to" 
                class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ auth()->id() == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Priorité -->
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Priorité</label>
        <div class="grid grid-cols-3 gap-3">
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="priority" value="low">
                <div class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border-2 border-slate-200 bg-white text-slate-600 text-sm font-medium transition-all peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 hover:border-slate-300">
                    <span>Faible</span>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="priority" value="medium" checked>
                <div class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border-2 border-slate-200 bg-white text-slate-600 text-sm font-medium transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:border-slate-300">
                    <span>Moyenne</span>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="priority" value="high">
                <div class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border-2 border-slate-200 bg-white text-slate-600 text-sm font-medium transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 hover:border-slate-300">
                    <span>Haute</span>
                </div>
            </label>
        </div>
    </div>

    <!-- Lié à -->
    <div x-data="{ type: 'none' }" class="border-t border-slate-200 pt-5">
        <label class="block text-sm font-medium text-slate-700 mb-2">
            Lier à un élément <span class="text-slate-400 text-xs ml-1">(optionnel)</span>
        </label>
        <div class="grid grid-cols-3 gap-3 mb-4">
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="link_type" value="none" x-model="type">
                <div class="flex items-center justify-center gap-2 px-3 py-2 rounded-lg border-2 border-slate-200 bg-white text-slate-600 text-sm font-medium transition-all peer-checked:border-slate-400 peer-checked:bg-slate-50 hover:border-slate-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Aucun</span>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="link_type" value="contact" x-model="type">
                <div class="flex items-center justify-center gap-2 px-3 py-2 rounded-lg border-2 border-slate-200 bg-white text-slate-600 text-sm font-medium transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 hover:border-slate-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Contact</span>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" class="peer sr-only" name="link_type" value="opportunity" x-model="type">
                <div class="flex items-center justify-center gap-2 px-3 py-2 rounded-lg border-2 border-slate-200 bg-white text-slate-600 text-sm font-medium transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:text-purple-700 hover:border-slate-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Opportunité</span>
                </div>
            </label>
        </div>

        <input type="hidden" name="related_type" :value="type === 'contact' ? 'App\\Models\\Contact' : (type === 'opportunity' ? 'App\\Models\\Opportunity' : '')">
        
        <div x-show="type === 'contact'" x-transition x-cloak>
            <select name="related_id" :disabled="type !== 'contact'" 
                class="w-full px-3 py-2 bg-indigo-50 border border-indigo-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <option value="">Sélectionner un contact</option>
                @foreach($contacts as $c)
                    <option value="{{ $c->id }}">{{ $c->prenom }} {{ $c->nom }} · {{ $c->entreprise }}</option>
                @endforeach
            </select>
        </div>

        <div x-show="type === 'opportunity'" x-transition x-cloak>
            <select name="related_id" :disabled="type !== 'opportunity'" 
                class="w-full px-3 py-2 bg-purple-50 border border-purple-200 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                <option value="">Sélectionner une opportunité</option>
                @foreach($opportunities as $o)
                    <option value="{{ $o->id }}">{{ $o->titre }} · {{ number_format($o->montant_estime, 0) }} €</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-200">
        <button type="button" @click="openTaskModal = false" 
            class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-slate-700 text-sm font-medium hover:bg-slate-50 transition-colors">
            Annuler
        </button>
        <button type="submit" 
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Créer la tâche</span>
        </button>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
.sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0; }
</style>