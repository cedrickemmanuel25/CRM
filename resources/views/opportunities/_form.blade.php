@php
    $isEdit = isset($opportunity);
    $stades = [
        'prospection'   => ['label' => 'Prospection',   'color' => 'bg-slate-500',   'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
        'qualification' => ['label' => 'Qualification', 'color' => 'bg-blue-500',    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        'proposition'   => ['label' => 'Proposition',   'color' => 'bg-purple-600',  'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        'negociation'   => ['label' => 'Négociation',   'color' => 'bg-amber-500',   'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
        'gagne'         => ['label' => 'Gagné',         'color' => 'bg-emerald-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        'perdu'         => ['label' => 'Perdu',         'color' => 'bg-rose-500',    'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z']
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
        return 'bg-indigo-600';
    },
    getSliderTextColor() {
        if (this.probabilite < 30) return 'text-rose-600';
        if (this.probabilite < 70) return 'text-amber-600';
        return 'text-indigo-600';
    }
}" class="max-w-7xl mx-auto">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Main Information (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 1. General Information Card -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 uppercase tracking-wide">Informations Générales</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Titre de l'opportunité -->
                    <div>
                        <label for="titre" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Titre de l'opportunité <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            <input type="text" name="titre" id="titre" required
                                value="{{ old('titre', $opportunity->titre ?? '') }}"
                                placeholder="Ex: Contrat de maintenance 2026 - Société X"
                                class="block w-full h-12 pl-12 pr-4 rounded-lg border-2 border-slate-200 bg-white text-sm font-semibold text-slate-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                        </div>
                    </div>

                    <!-- Contact Selector -->
                    <div x-data="{ 
                        search: '', 
                        open: false, 
                        selectedId: '{{ old('contact_id', $opportunity->contact_id ?? '') }}', 
                        selectedName: '{{ $isEdit && $opportunity->contact ? str_replace("'", "\'", $opportunity->contact->prenom . ' ' . $opportunity->contact->nom) : '' }}',
                        contacts: {{ $contacts->map(function($c) { return ['id' => $c->id, 'name' => $c->prenom . ' ' . $c->nom, 'company' => $c->entreprise ?? 'Particulier', 'initials' => strtoupper(substr($c->prenom,0,1).substr($c->nom,0,1))]; })->toJson() }},
                        get filteredContacts() {
                            if (this.search === '') return this.contacts;
                            return this.contacts.filter(c => c.name.toLowerCase().includes(this.search.toLowerCase()) || c.company.toLowerCase().includes(this.search.toLowerCase()));
                        }
                    }" class="relative">
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-2">Contact Principal / Décideur <span class="text-rose-500">*</span></label>
                        <input type="hidden" name="contact_id" :value="selectedId">
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <input type="text" x-model="selectedName" @input="open = true; search = selectedName" @focus="open = true" @click.away="open = false" 
                                placeholder="Rechercher un contact..."
                                class="block w-full h-12 pl-12 pr-4 rounded-lg border-2 border-slate-200 bg-white text-sm font-semibold text-slate-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none"
                                autocomplete="off">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>

                        <!-- Dropdown Results -->
                        <div x-show="open" x-transition class="absolute z-50 mt-1 w-full bg-white rounded-lg shadow-xl border border-gray-100 max-h-60 overflow-y-auto">
                            <template x-for="contact in filteredContacts" :key="contact.id">
                                <div @click="selectedId = contact.id; selectedName = contact.name; open = false"
                                    class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold mr-3" x-text="contact.initials"></div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900" x-text="contact.name"></p>
                                        <p class="text-xs text-gray-500" x-text="contact.company"></p>
                                    </div>
                                </div>
                            </template>
                            <div x-show="filteredContacts.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">
                                Aucun contact trouvé.
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Description & Contexte</label>
                        <textarea name="description" id="description" rows="6"
                            placeholder="Détails du besoin, contexte du projet..."
                            class="block w-full px-4 py-3 border-2 border-slate-200 rounded-lg text-sm bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none resize-none font-medium text-slate-700">{{ old('description', $opportunity->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings & Data (1/3) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Financial Projections -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 uppercase tracking-wide">Paramètres Financiers</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Montant Estimé -->
                    <div>
                        <label for="montant_estime" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Valeur du Deal <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 font-bold text-xs border-r border-slate-200 mr-4">
                                {{ currency_symbol() }}
                            </div>
                            <input type="number" name="montant_estime" id="montant_estime" x-model.number="montant" required step="0.01"
                                class="block w-full h-12 pl-12 pr-4 rounded-lg border-2 border-slate-200 text-sm font-bold text-slate-900 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                        </div>
                    </div>

                    <!-- Date de clôture -->
                    <div>
                        <label for="date_cloture_prev" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Date de signature <span class="text-rose-500">*</span></label>
                        <input type="date" name="date_cloture_prev" id="date_cloture_prev" required
                            value="{{ old('date_cloture_prev', isset($opportunity->date_cloture_prev) ? $opportunity->date_cloture_prev->format('Y-m-d') : '') }}"
                            class="block w-full h-12 px-4 rounded-lg border-2 border-slate-200 bg-white text-sm font-semibold text-slate-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                    </div>

                    <!-- Probabilité -->
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Probabilité</label>
                            <div class="px-3 py-1 rounded-lg bg-white border border-slate-200 shadow-sm">
                                <span x-text="probabilite + '%'" :class="getSliderTextColor()" class="text-base font-black transition-colors"></span>
                            </div>
                        </div>
                        
                        <input type="range" name="probabilite" min="0" max="100" step="5" x-model.number="probabilite"
                            class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600 hover:accent-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                        
                        <div class="mt-5 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Valeur Pondérée</p>
                            <p class="text-lg font-black text-slate-800" x-text="new Intl.NumberFormat('fr-FR').format(weightedValue()) + ' {{ currency_symbol() }}'"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pipeline Status -->
            @if(!$isEdit)
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 uppercase tracking-wide">Pipeline</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="stade" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Stade initial</label>
                        <div class="relative">
                            <select id="stade" name="stade" x-model="stade"
                                class="block w-full h-12 px-4 rounded-lg border-2 border-slate-200 text-sm font-bold text-slate-900 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none cursor-pointer appearance-none">
                                @foreach($stades as $key => $config)
                                    <option value="{{ $key }}">{{ strtoupper($config['label']) }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Indicator -->
                    <div class="flex gap-1 h-1.5 mt-2">
                        @foreach($stades as $key => $config)
                        <div class="flex-1 rounded-full transition-all duration-300"
                            :class="stade === '{{ $key }}' ? '{{ str_replace('bg-', 'bg-', $config['color']) }} opacity-100 ring-2 ring-offset-1 ring-slate-200' : 'bg-slate-200 opacity-50'"></div>
                        @endforeach
                    </div>

                    @if(auth()->user()->isAdmin())
                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <label for="commercial_id" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Responsable</label>
                        <div class="relative">
                            <select id="commercial_id" name="commercial_id"
                                class="block w-full h-12 px-4 rounded-lg border-2 border-slate-200 text-sm font-medium text-slate-900 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none appearance-none">
                                <option value="auto">Distribution Automatique</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('commercial_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>
                    @else
                        <input type="hidden" name="commercial_id" value="{{ auth()->id() }}">
                    @endif
                </div>
            </div>
            @else
                <input type="hidden" name="stade" value="{{ $opportunity->stade }}">
                <input type="hidden" name="commercial_id" value="{{ $opportunity->commercial_id }}">
            @endif
        </div>
    </div>
</div>
