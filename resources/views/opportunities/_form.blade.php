@php
    $isEdit = isset($opportunity);
    $stades = [
        'prospection' => ['label' => 'Prospection', 'color' => 'bg-gray-400'],
        'qualification' => ['label' => 'Qualification', 'color' => 'bg-blue-500'],
        'proposition' => ['label' => 'Proposition', 'color' => 'bg-indigo-600'],
        'negociation' => ['label' => 'Négociation', 'color' => 'bg-purple-600'],
        'gagne' => ['label' => 'Gagné', 'color' => 'bg-emerald-600'],
        'perdu' => ['label' => 'Perdu', 'color' => 'bg-rose-600']
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
    }
}" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

    <!-- Primary Content Area: The Core Data (Left 70%) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Document Section: Opportunity Identity -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-4 w-1 bg-indigo-600 rounded-full"></div>
                <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest">Descriptor & Source</h2>
            </div>
            <div class="p-8 space-y-8">
                <!-- Titre -->
                <div class="space-y-2">
                    <label for="titre" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center">
                        Intitulé de l'Opportunité
                        <span class="text-rose-500 ml-1">*</span>
                    </label>
                    <input type="text" name="titre" id="titre" required
                        value="{{ old('titre', $opportunity->titre ?? '') }}"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none @error('titre') border-rose-300 ring-4 ring-rose-500/10 @enderror">
                    @error('titre')
                        <p class="text-[10px] font-bold text-rose-600 mt-1 flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0118 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Contact Associé (Double Entry Design) -->
                <div x-data="{ 
                    search: '', 
                    open: false, 
                    selectedId: '{{ old('contact_id', $opportunity->contact_id ?? '') }}', 
                    selectedName: '{{ $isEdit && $opportunity->contact ? str_replace("'", "\'", $opportunity->contact->prenom . ' ' . $opportunity->contact->nom) : '' }}' 
                }" class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center">
                        Contact / Décideur Assigné
                        <span class="text-rose-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <input type="hidden" name="contact_id" :value="selectedId">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300 transition-colors group-focus-within:text-indigo-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <input type="text" x-model="selectedName" @focus="open = true" @click.away="open = false" 
                                class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none"
                                autocomplete="off">
                        </div>

                        <!-- Professional Dropdown -->
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden py-1">
                            <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                @foreach($contacts as $contact)
                                <div @click="selectedId = '{{ $contact->id }}'; selectedName = '{{ $contact->prenom }} {{ $contact->nom }}'; open = false;"
                                    class="flex items-center px-4 py-3 hover:bg-indigo-50/50 cursor-pointer transition-colors border-b last:border-0 border-gray-50 group">
                                    <div class="h-9 w-9 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-[10px] mr-3 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                        {{ strtoupper(substr($contact->prenom, 0, 1)) }}{{ strtoupper(substr($contact->nom, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $contact->prenom }} {{ $contact->nom }}</p>
                                        <p class="text-[10px] text-gray-500 font-medium uppercase truncate tracking-tight">{{ $contact->entreprise ?? 'PARTICULIER' }}</p>
                                    </div>
                                    <template x-if="selectedId == '{{ $contact->id }}'">
                                        <svg class="h-4 w-4 text-indigo-600 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </template>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description (High Power Textarea) -->
                <div class="space-y-2 pt-2 border-t border-gray-50 mt-4">
                    <label for="description" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Contexte & Objectifs de la Vente</label>
                    <textarea id="description" name="description" rows="6"
                        class="block w-full px-4 py-4 border border-gray-300 rounded-xl text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none resize-none">{{ old('description', $opportunity->description ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Administrative Sidebar (Right 30%) -->
    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-[100px]">
        
        <!-- Sidebar Section: Financial Architecture -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-4 w-1 bg-indigo-600 rounded-full"></div>
                <h3 class="text-[10px] font-bold text-gray-700 uppercase tracking-widest">Valeur & Projection</h3>
            </div>

            <div class="p-6 space-y-8">
                <!-- Montant Principal -->
                <div class="space-y-2">
                    <label for="montant_estime" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Montant Estimé <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 font-bold text-xs uppercase italic mr-1">
                            {{ currency_symbol() }}
                        </div>
                        <input type="number" name="montant_estime" id="montant_estime" x-model.number="montant" required step="0.01"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-lg font-black text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none">
                    </div>
                </div>

                <!-- Probability Widget -->
                <div class="space-y-4 p-5 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Confiance</label>
                        <span x-text="probabilite + '%'" :class="getSliderColor().replace('bg-', 'text-')" class="text-xl font-black"></span>
                    </div>
                    
                    <div class="relative group flex items-center h-2 bg-gray-200 rounded-full">
                        <div :class="getSliderColor()" class="h-full rounded-full transition-all duration-300" :style="`width: ${probabilite}%`"></div>
                        <input type="range" name="probabilite" id="probabilite" min="0" max="100" step="5" x-model.number="probabilite"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>

                    <div class="pt-4 border-t border-gray-200 mt-2 flex flex-col items-center">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1">Valeur Pondérée (Poids CRM)</p>
                        <p class="text-2xl font-black text-gray-900" x-text="new Intl.NumberFormat('fr-FR').format(weightedValue()) + ' {{ currency_symbol() }}'"></p>
                    </div>
                </div>

                <!-- Closing Date -->
                <div class="space-y-2 pt-2 border-t border-gray-100 mt-2">
                    <label for="date_cloture_prev" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest uppercase">Échéance de Clôture <span class="text-rose-500">*</span></label>
                    <input type="date" name="date_cloture_prev" id="date_cloture_prev" required
                        value="{{ old('date_cloture_prev', isset($opportunity->date_cloture_prev) ? $opportunity->date_cloture_prev->format('Y-m-d') : '') }}"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 bg-white focus:border-indigo-600 outline-none transition-all">
                </div>
            </div>
        </div>

        <!-- Pipeline Execution Sidebar -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-4 w-1 bg-indigo-600 rounded-full"></div>
                <h3 class="text-[10px] font-bold text-gray-700 uppercase tracking-widest">Position Pipeline</h3>
            </div>
            <div class="p-6 space-y-6">
                <!-- Stade selector -->
                <div class="space-y-2">
                    <label for="stade" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Statut du Deal</label>
                    <div class="relative">
                        <select id="stade" name="stade" x-model="stade"
                            class="block w-full h-12 px-4 border border-gray-300 rounded-lg text-xs font-black bg-white focus:border-indigo-600 outline-none cursor-pointer appearance-none transition-all">
                            @foreach($stades as $key => $config)
                                <option value="{{ $key }}">{{ strtoupper($config['label']) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                    
                    <!-- Progress Bar View -->
                    <div class="grid grid-cols-6 gap-1 mt-4">
                        @foreach($stades as $key => $config)
                            <div class="h-2 rounded-full transition-all duration-300 {{ $config['color'] }}" 
                                :class="stade === '{{ $key }}' ? 'opacity-100 ring-2 ring-offset-1 ring-gray-100' : 'opacity-10'"></div>
                        @endforeach
                    </div>
                </div>

                <!-- Attribution Section (Admin Only) -->
                @if(auth()->user()->isAdmin())
                <div class="space-y-2 pt-4 border-t border-gray-100">
                    <label for="commercial_id" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest uppercase">Expert / Responsable</label>
                    <div class="relative">
                        <select id="commercial_id" name="commercial_id"
                            class="block w-full h-12 px-4 border border-gray-300 rounded-lg text-xs font-bold bg-white focus:border-indigo-600 outline-none cursor-pointer appearance-none">
                            @if(!$isEdit)
                                <option value="auto">DISTRIBUTION AUTO (SMART-RULES)</option>
                            @endif
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('commercial_id', $opportunity->commercial_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ strtoupper($user->name) }} ({{ strtoupper($user->role) }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                    </div>
                </div>
                @else
                    <input type="hidden" name="commercial_id" value="{{ $opportunity->commercial_id ?? auth()->id() }}">
                @endif
            </div>
        </div>

    </div>
</div>

<style>
    /* Integrated CRM precision styling */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    
    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: white;
        cursor: pointer;
        border: 4px solid #4f46e5;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        margin-top: -8px; 
    }
    input[type=range]::-moz-range-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: white;
        cursor: pointer;
        border: 4px solid #4f46e5;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
    
    [x-cloak] { display: none !important; }
</style>
