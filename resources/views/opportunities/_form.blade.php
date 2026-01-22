@php
    $isEdit = isset($opportunity);
    $stades = [
        'prospection' => ['label' => 'Prospection', 'color' => 'bg-slate-500'],
        'qualification' => ['label' => 'Qualification', 'color' => 'bg-blue-500'],
        'proposition' => ['label' => 'Proposition', 'color' => 'bg-indigo-500'],
        'negociation' => ['label' => 'Négociation', 'color' => 'bg-purple-500'],
        'gagne' => ['label' => 'Gagné', 'color' => 'bg-emerald-500'],
        'perdu' => ['label' => 'Perdu', 'color' => 'bg-rose-500']
    ];
@endphp

<div x-data="{ 
    montant: {{ old('montant_estime', $opportunity->montant_estime ?? 0) }}, 
    probabilite: {{ old('probabilite', $opportunity->probabilite ?? 10) }},
    stade: '{{ old('stade', $opportunity->stade ?? 'prospection') }}',
    weightedValue() { 
        return Math.round(this.montant * (this.probabilite / 100)); 
    },
    getSliderColor() {
        if (this.probabilite < 30) return 'bg-rose-500';
        if (this.probabilite < 70) return 'bg-amber-500';
        return 'bg-emerald-500';
    }
}" class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Section: Informations de base (Left Column - 2/3) -->
        <div class="lg:col-span-2 space-y-8">
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center space-x-3">
                    <div class="p-2 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Informations de base</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Titre -->
                    <div class="space-y-2">
                        <label for="titre" class="text-sm font-semibold text-slate-700 flex items-center">
                            Titre de l'opportunité
                            <span class="text-rose-500 ml-1">*</span>
                        </label>
                        <input type="text" name="titre" id="titre" required
                            value="{{ old('titre', $opportunity->titre ?? '') }}"
                            class="block w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm transition-all duration-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 placeholder:text-slate-400 @error('titre') border-rose-300 ring-4 ring-rose-500/10 @enderror"
                            placeholder="Ex: Refonte site e-commerce - Client X">
                        @error('titre')
                            <p class="text-xs font-medium text-rose-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0118 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Contact Associé -->
                    <div x-data="{ 
                        search: '', 
                        open: false, 
                        selectedId: '{{ old('contact_id', $opportunity->contact_id ?? '') }}', 
                        selectedName: '{{ $isEdit && $opportunity->contact ? str_replace("'", "\'", $opportunity->contact->prenom . ' ' . $opportunity->contact->nom) : '' }}' 
                    }" class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 flex items-center">
                            Contact associé
                            <span class="text-rose-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input type="hidden" name="contact_id" :value="selectedId">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="selectedName" @focus="open = true" @click.away="open = false" 
                                    class="block w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm transition-all duration-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 placeholder:text-slate-400"
                                    placeholder="Rechercher par nom ou entreprise..." autocomplete="off">
                            </div>

                            <!-- Dropdown -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute z-20 mt-2 w-full bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-1">
                                <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                    @foreach($contacts as $contact)
                                    <div @click="selectedId = '{{ $contact->id }}'; selectedName = '{{ $contact->prenom }} {{ $contact->nom }}'; open = false;"
                                        class="flex items-center px-4 py-3 hover:bg-slate-50 cursor-pointer transition-colors border-b last:border-0 border-slate-50">
                                        <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3">
                                            {{ substr($contact->prenom, 0, 1) }}{{ substr($contact->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{{ $contact->prenom }} {{ $contact->nom }}</p>
                                            <p class="text-xs text-slate-500">{{ $contact->entreprise ?? 'Particulier' }}</p>
                                        </div>
                                        <template x-if="selectedId == '{{ $contact->id }}'">
                                            <svg class="w-4 h-4 text-indigo-600 ml-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        </template>
                                    </div>
                                    @endforeach
                                    @if($contacts->isEmpty())
                                        <div class="px-4 py-8 text-center">
                                            <p class="text-sm text-slate-500 italic">Aucun contact trouvé</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('contact_id')
                            <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="text-sm font-semibold text-slate-700">Description</label>
                        <textarea id="description" name="description" rows="5"
                            class="block w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm transition-all duration-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 placeholder:text-slate-400"
                            placeholder="Décrivez les besoins et le contexte de cette opportunité commerciale...">{{ old('description', $opportunity->description ?? '') }}</textarea>
                    </div>
                </div>
            </section>
        </div>

        <!-- Section: Détails Financiers & Pipeline (Right Column - 1/3) -->
        <div class="space-y-8">
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center space-x-3">
                    <div class="p-2 bg-emerald-100 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Détails de la vente</h3>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Montant -->
                    <div class="space-y-2">
                        <label for="montant_estime" class="text-sm font-semibold text-slate-700">Montant estimé <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-bold sm:text-sm whitespace-nowrap">{{ currency_symbol() }}&nbsp;</span>
                            </div>
                            <input type="number" name="montant_estime" id="montant_estime" x-model.number="montant" required step="0.01"
                                class="block w-full pl-20 pr-12 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-black transition-all duration-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 placeholder:text-slate-400" 
                                placeholder="0.00">
                        </div>
                        @error('montant_estime')
                            <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Probabilité & Valeur Pondérée -->
                    <div class="space-y-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold text-slate-700">Probabilité</label>
                            <span x-text="probabilite + '%'" :class="getSliderColor().replace('bg-', 'text-')" class="text-lg font-bold"></span>
                        </div>
                        
                        <div class="relative flex items-center h-2 bg-slate-200 rounded-full overflow-hidden">
                            <div :class="getSliderColor()" class="h-full transition-all duration-300" :style="`width: ${probabilite}%`"></div>
                            <input type="range" name="probabilite" id="probabilite" min="0" max="100" step="5" x-model.number="probabilite"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>

                        <div class="pt-2 border-t border-slate-200 mt-2">
                            <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Valeur pondérée</p>
                            <p class="text-xl font-black text-slate-900" x-text="new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(weightedValue()) + ' {{ currency_symbol() }}'"></p>
                        </div>
                    </div>

                    <!-- Date Clôture -->
                    <div class="space-y-2">
                        <label for="date_cloture_prev" class="text-sm font-semibold text-slate-700">Clôture prévue <span class="text-rose-500">*</span></label>
                        <input type="date" name="date_cloture_prev" id="date_cloture_prev" required
                            value="{{ old('date_cloture_prev', isset($opportunity->date_cloture_prev) ? $opportunity->date_cloture_prev->format('Y-m-d') : '') }}"
                            class="block w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm transition-all duration-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                    </div>

                    <!-- Pipeline Stage -->
                    <div class="space-y-2">
                        <label for="stade" class="text-sm font-semibold text-slate-700">Stade actuel <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="stade" name="stade" x-model="stade"
                                class="appearance-none block w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-medium transition-all duration-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 pr-10">
                                @foreach($stades as $key => $config)
                                    <option value="{{ $key }}">{{ $config['label'] }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Mini visual guide for stages -->
                        <div class="grid grid-cols-6 gap-1 mt-3">
                            @foreach($stades as $key => $config)
                                <div class="h-1.5 rounded-full transition-all duration-300 {{ $config['color'] }}" 
                                    :class="stade === '{{ $key }}' ? 'opacity-100 scale-y-125 shadow-sm' : 'opacity-20'"></div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Attribution Section (Admin Only for Change) -->
                    @if(auth()->user()->isAdmin())
                    <div class="space-y-2 pt-4 border-t border-slate-100">
                        <label for="commercial_id" class="text-sm font-semibold text-slate-700">Propriétaire / Attribution <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="commercial_id" name="commercial_id"
                                class="appearance-none block w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-medium transition-all duration-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 pr-10">
                                @if(!$isEdit)
                                    <option value="auto">Auto-attribution (Règles)</option>
                                @endif
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('commercial_id', $opportunity->commercial_id ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ ucfirst($user->role) }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium">Déterminez qui sera responsable de cette opportunité.</p>
                    </div>
                    @else
                        <input type="hidden" name="commercial_id" value="{{ $opportunity->commercial_id ?? auth()->id() }}">
                    @endif

                </div>
            </section>
        </div>
    </div>

    <!-- Sticky Actions Bar -->
    <div class="sticky bottom-0 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 py-5 mt-8 bg-white/90 backdrop-blur-sm border-t border-slate-200 flex items-center justify-end space-x-4 z-10">
        <div class="hidden sm:block mr-auto">
            <p class="text-xs text-slate-500 italic">Tous les champs marqués d'une <span class="text-rose-500 font-bold">*</span> sont obligatoires.</p>
        </div>
        <a href="{{ route('opportunities.index') }}" 
            class="px-6 py-3 rounded-xl bg-white border border-slate-300 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all active:scale-95">
            Annuler
        </a>
        <button type="submit" 
            class="px-8 py-3 rounded-xl bg-indigo-600 text-sm font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all active:scale-95 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ $isEdit ? 'Mettre à jour' : 'Créer l\'opportunité' }}
        </button>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: white;
        cursor: pointer;
        border: 2px solid #6366f1;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        margin-top: -8px; 
    }
    input[type=range]::-moz-range-thumb {
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: white;
        cursor: pointer;
        border: 2px solid #6366f1;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
</style>
