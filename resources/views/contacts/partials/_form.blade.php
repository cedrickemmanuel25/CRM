@php
    $isEdit = isset($contact);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Primary Content Area (Left 70%) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Document Section: Identity & Structure -->
        <div class="saas-card overflow-hidden">
            <div class="px-5 sm:px-8 py-4 sm:py-5 border-b border-white/5 bg-white/5 flex items-center gap-3">
                <div class="h-4 w-1 bg-blue-600 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                <h2 class="label-caps !text-slate-100">Identité et Structure</h2>
            </div>
            <div class="p-5 sm:p-8">
                <div class="flex flex-col lg:flex-row gap-8 sm:gap-12">
                    <!-- Photo Administration Zone: High Visibility & Clickable -->
                    <div class="shrink-0 flex flex-col items-center gap-6">
                        <div class="relative group" x-data="{ photoPreview: '{{ $isEdit ? $contact->avatar_url : '' }}' }">
                            <div class="h-32 w-32 sm:h-48 sm:w-48 rounded-2xl bg-white/5 border-2 border-dashed border-white/10 flex items-center justify-center overflow-hidden transition-all group-hover:border-blue-500/50 group-hover:bg-blue-500/5">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" alt="Profile" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center text-slate-500">
                                        <svg class="h-10 w-10 sm:h-14 sm:w-14 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                        <span class="text-[9px] sm:text-[10px] font-black uppercase mt-3 tracking-widest opacity-40">Profil Photo</span>
                                    </div>
                                </template>
                            </div>
                            <!-- Robust Clickable Trigger: Harmonie Blue -->
                            <button type="button" @click="$refs.photoInput.click()" 
                                class="absolute -bottom-4 inset-x-5 h-12 bg-blue-600 text-white rounded-xl shadow-xl shadow-blue-900/40 flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all active:scale-95 z-30">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /></svg>
                                CHARGER PHOTO
                            </button>
                            <input type="file" name="photo" x-ref="photoInput" class="hidden" accept="image/*" @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL(file);
                                }
                            ">
                        </div>
                    </div>

                    <!-- Core Fields: Restored Grid for Perfect Alignment -->
                    <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-7">
                        <div class="col-span-1 space-y-2">
                            <label for="prenom" class="label-caps">Prénom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $isEdit ? $contact->prenom : '') }}" 
                                class="block w-full px-5 py-3 border border-white/10 rounded-xl text-sm text-slate-100 bg-white/5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder-slate-600 @error('prenom') border-rose-500 ring-2 ring-rose-500/20 @enderror" placeholder="Ex: Jean">
                            @error('prenom')
                                <p class="mt-1.5 text-[10px] text-rose-400 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="col-span-1 space-y-2">
                            <label for="nom" class="label-caps">Nom de Famille</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $isEdit ? $contact->nom : '') }}" 
                                class="block w-full px-5 py-3 border border-white/10 rounded-xl text-sm text-slate-100 bg-white/5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder-slate-600 @error('nom') border-rose-500 ring-2 ring-rose-500/20 @enderror" placeholder="Ex: Dupont">
                            @error('nom')
                                <p class="mt-1.5 text-[10px] text-rose-400 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 sm:col-span-2 space-y-2 pt-2">
                            <label for="entreprise" class="label-caps">Organisation / Entreprise</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-500 group-focus-within:text-blue-400 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </span>
                                <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $isEdit ? $contact->entreprise : '') }}"
                                    class="block w-full px-5 py-3.5 pl-12 border border-white/10 rounded-xl text-sm text-slate-100 bg-white/5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder-slate-600 @error('entreprise') border-rose-500 ring-2 ring-rose-500/20 @enderror" placeholder="Nom de la société">
                            </div>
                            @error('entreprise')
                                <p class="mt-1.5 text-[10px] text-rose-400 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 sm:col-span-2 space-y-2 border-t border-white/5 pt-8 mt-4">
                            <label for="poste" class="label-caps">Intitulé de Poste / Fonction</label>
                            <input type="text" name="poste" id="poste" value="{{ old('poste', $isEdit ? $contact->poste : '') }}" 
                                class="block w-full px-5 py-3.5 border border-white/10 rounded-xl text-sm text-slate-100 bg-white/5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder-slate-600" placeholder="Ex: Directeur Commercial">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Section: Communication & Logistics -->
        <div class="saas-card overflow-hidden">
            <div class="px-5 sm:px-8 py-4 sm:py-5 border-b border-white/5 bg-white/5 flex items-center gap-3">
                <div class="h-4 w-1 bg-blue-600 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                <h2 class="label-caps !text-slate-100">Canaux de Communication</h2>
            </div>
            <div class="p-5 sm:p-8 space-y-8 sm:space-y-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-10">
                    <div class="space-y-2">
                        <label for="email" class="label-caps">Email Professionnel</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $contact->email : '') }}" 
                            class="block w-full px-5 py-3.5 border border-white/10 rounded-xl text-sm text-slate-100 bg-white/5 focus:bg-white/10 focus:border-blue-500 transition-all outline-none placeholder-slate-600 @error('email') border-rose-500 ring-2 ring-rose-500/20 @enderror" placeholder="email@exemple.com">
                        @error('email')
                            <p class="mt-1.5 text-[10px] text-rose-400 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="telephone" class="label-caps">Ligne Directe / GSM</label>
                        <div class="iti-container saas-scroll">
                            <input type="tel" name="telephone_input" id="telephone" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}" 
                                class="block w-full px-5 py-3.5 border border-white/10 rounded-xl text-sm text-slate-100 bg-white/5 focus:border-blue-500 focus:ring-0 outline-none transition-all placeholder-slate-600">
                            <input type="hidden" name="telephone" id="telephone_full" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}">
                        </div>
                        @error('telephone')
                            <p class="mt-1.5 text-[10px] text-rose-400 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2 border-t border-white/5 pt-10">
                    <label for="adresse" class="label-caps">Adresse Postale / Siège</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-500 group-focus-within:text-blue-400 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </span>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $isEdit ? $contact->adresse : '') }}" 
                            class="block w-full px-5 py-4 pl-14 border border-white/10 rounded-xl text-sm text-slate-100 bg-white/5 focus:border-blue-500 outline-none transition-all placeholder-slate-600" placeholder="Adresse complète">
                    </div>
                </div>

                <!-- Secondary Data (Enterprise Collapsible) -->
                <div x-data="{ open: false }" class="border-t border-white/5 pt-10">
                    <button type="button" @click="open = !open" class="flex items-center text-[11px] font-black text-blue-500 hover:text-blue-400 tracking-widest transition-all uppercase group">
                        <span x-text="open ? 'RÉDUIRE OPTIONS AVANCÉES' : 'PARAMÈTRES DE CONTACT SUPPLÉMENTAIRES'"></span>
                        <svg class="ml-3 w-4 h-4 transition-transform duration-300 group-hover:translate-y-0.5" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" x-collapse x-cloak class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-12">
                        <div x-data="{ emails: {{ json_encode(old('alternative_emails', ($isEdit && $contact->alternative_emails) ? $contact->alternative_emails : [])) }} }" class="space-y-6">
                            <h4 class="label-caps !text-slate-500 border-b border-white/5 pb-2">Emails Alias</h4>
                            <div class="space-y-3">
                                <template x-for="(email, index) in emails" :key="index">
                                    <div class="flex gap-2 group">
                                        <input type="email" :name="'alternative_emails['+index+']'" x-model="emails[index]" class="block w-full h-11 px-4 border border-white/10 rounded-xl text-xs text-slate-100 bg-white/5 focus:bg-white/10 focus:border-blue-500 outline-none transition-all">
                                        <button type="button" @click="emails.splice(index, 1)" class="p-2.5 text-slate-600 hover:text-rose-500 transition-colors hover:bg-rose-500/10 rounded-xl">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="emails.push('')" class="text-[10px] font-black text-blue-500 hover:text-blue-400 transition-colors uppercase tracking-widest">+ EMAIL SECONDAIRE</button>
                            </div>
                        </div>

                        <div x-data="{ phones: {{ json_encode(old('alternative_telephones', ($isEdit && $contact->alternative_telephones) ? $contact->alternative_telephones : [])) }} }" class="space-y-6">
                            <h4 class="label-caps !text-slate-500 border-b border-white/5 pb-2">Lignes Seconds</h4>
                            <div class="space-y-3">
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div class="flex gap-2 group">
                                        <input type="tel" :name="'alternative_telephones['+index+']'" x-model="phones[index]" class="block w-full h-11 px-4 border border-white/10 rounded-xl text-xs text-slate-100 bg-white/5 focus:bg-white/10 focus:border-blue-500 outline-none transition-all">
                                        <button type="button" @click="phones.splice(index, 1)" class="p-2.5 text-slate-600 hover:text-rose-500 transition-colors hover:bg-rose-500/10 rounded-xl">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="phones.push('')" class="text-[10px] font-black text-blue-500 hover:text-blue-400 transition-colors uppercase tracking-widest">+ TÉLÉPHONE ADDITIONNEL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Administrative Sidebar (Right 30%) -->
    <div class="lg:col-span-4 space-y-8 lg:sticky lg:top-[100px]">
        
        <!-- Sidebar Section: Administration -->
        <div class="saas-card overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-white/5 bg-white/5 flex items-center gap-3">
                <div class="h-4 w-1 bg-blue-600 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                <h3 class="label-caps !text-slate-100">Administration</h3>
            </div>
            <div class="p-5 sm:p-6 space-y-8 sm:space-y-10">

                <!-- Administrative Field -->
                <div class="space-y-3">
                    <label for="source" class="label-caps">Origine / Acquisition</label>
                    <div class="relative">
                        <select id="source" name="source" 
                            class="block w-full h-12 px-5 border border-white/10 rounded-xl text-xs text-slate-100 bg-white/5 focus:border-blue-500 outline-none cursor-pointer appearance-none transition-all">
                            <option value="" class="bg-[#1e293b]">NON DÉPENDANT</option>
                            <option value="LinkedIn" {{ old('source', $isEdit ? $contact->source : '') == 'LinkedIn' ? 'selected' : '' }} class="bg-[#1e293b]">RESEAU LINKEDIN</option>
                            <option value="Site Web" {{ old('source', $isEdit ? $contact->source : '') == 'Site Web' ? 'selected' : '' }} class="bg-[#1e293b]">SITE WEB INSTITUTIONNEL</option>
                            <option value="Recommandation" {{ old('source', $isEdit ? $contact->source : '') == 'Recommandation' ? 'selected' : '' }} class="bg-[#1e293b]">PARTENAIRE / REFERRAL</option>
                            <option value="Emailing" {{ old('source', $isEdit ? $contact->source : '') == 'Emailing' ? 'selected' : '' }} class="bg-[#1e293b]">CAMPAGNE EMAIL</option>
                            <option value="Événement" {{ old('source', $isEdit ? $contact->source : '') == 'Événement' ? 'selected' : '' }} class="bg-[#1e293b]">SALON / ÉVÉNEMENT</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Administrative Field: Tags -->
                <div class="space-y-3 pt-2">
                    <label for="tags" class="label-caps">Segmentation Tags</label>
                    <input type="text" name="tags_input" id="tags" value="{{ old('tags_input', ($isEdit && $contact->tags) ? implode(', ', $contact->tags) : '') }}" 
                        class="block w-full h-12 px-5 border border-white/10 rounded-xl text-xs text-slate-100 bg-white/5 focus:border-blue-500 outline-none transition-all placeholder-slate-600" placeholder="Ex: Client, VIP, Support">
                    <p class="text-[9px] font-bold text-slate-600 uppercase italic mt-3 tracking-tighter">Séparez les mots-clés par des virgules</p>
                </div>
            </div>
        </div>

        <!-- Sticky Note: Internal Perspective (Enterprise Dark Mode Harmony) -->
        <div class="saas-card overflow-hidden !bg-blue-950/20 border-blue-500/10">
            <div class="px-5 sm:px-6 py-4 border-b border-white/5 bg-white/5 flex items-center justify-between">
                <h3 class="label-caps !text-blue-400">Notes Stratégiques</h3>
                <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <div class="p-0">
                <textarea name="notes_internes" id="notes_internes" rows="10" 
                    class="block w-full border-none p-5 sm:p-8 text-sm text-blue-100 bg-transparent placeholder-blue-900/40 focus:ring-0 outline-none min-h-[250px] sm:min-h-[300px] resize-none leading-relaxed custom-scrollbar" placeholder="Saisir les informations confidentielles ici...">{{ old('notes_internes', $isEdit ? $contact->notes_internes : '') }}</textarea>
                <div class="px-6 py-4 bg-blue-600/10 text-[10px] font-black text-blue-500 uppercase flex items-center gap-3 border-t border-white/5">
                    <div class="h-2 w-2 rounded-full bg-blue-500 animate-[pulse_2s_infinite]"></div>
                    Contenu Sensible (Accès Restreint)
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector("#telephone");
        const fullPhoneInput = document.querySelector("#telephone_full");
        
        if (phoneInput && fullPhoneInput) {
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "ci",
                onlyCountries: ["ci"],
                countrySearch: false,
                allowDropdown: false,
                showSelectedDialCode: true,
                separateDialCode: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js",
            });

            const updateFullNumber = () => {
                fullPhoneInput.value = iti.getNumber();
            };

            phoneInput.addEventListener('change', updateFullNumber);
            phoneInput.addEventListener('keyup', updateFullNumber);
            
            const form = phoneInput.closest('form');
            if (form) {
                form.addEventListener('submit', updateFullNumber);
            }
        }
    });
</script>

<style>
    /* Integrated CRM precision styling */
    .iti { width: 100% !important; display: block !important; }
    .iti__selected-dial-code { font-weight: 800 !important; color: #f8fafc !important; font-size: 0.85rem !important; margin-left: 8px !important; }
    .iti__country-list { 
        background-color: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important; 
        border-radius: 12px !important; 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3) !important; 
        z-index: 50 !important;
        padding: 8px !important;
    }
    .iti__country { padding: 10px 12px !important; border-radius: 8px !important; color: #f1f5f9 !important; }
    .iti__country.iti__highlight { background-color: rgba(59, 130, 246, 0.2) !important; }
    .iti__dial-code { color: #94a3b8 !important; }
    
    [x-cloak] { display: none !important; }
    
    input::placeholder { font-weight: 500; color: rgba(148, 163, 184, 0.3); }
    
    /* Global scrollbar refinement */
    .saas-scroll::-webkit-scrollbar { width: 4px; }
    .saas-scroll::-webkit-scrollbar-track { background: transparent; }
    .saas-scroll::-webkit-scrollbar-thumb { background: rgba(59, 130, 246, 0.2); border-radius: 10px; }
    .saas-scroll::-webkit-scrollbar-thumb:hover { background: rgba(59, 130, 246, 0.4); }

    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.1); }
</style>
