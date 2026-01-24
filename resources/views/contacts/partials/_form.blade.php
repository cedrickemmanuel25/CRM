@php
    $isEdit = isset($contact);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Primary Content Area (Left 70%) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Document Section: Identity & Structure -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-4 w-1 bg-indigo-600 rounded-full"></div>
                <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest">Identité et Structure</h2>
            </div>
            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Photo Administration Zone: High Visibility & Clickable -->
                    <div class="shrink-0 flex flex-col items-center gap-4">
                        <div class="relative group" x-data="{ photoPreview: '{{ $isEdit ? $contact->avatar_url : '' }}' }">
                            <div class="h-44 w-44 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-colors group-hover:border-indigo-300">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" alt="Profile" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center text-gray-400">
                                        <svg class="h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                        <span class="text-[10px] font-bold uppercase mt-2 tracking-widest opacity-40">Profil Photo</span>
                                    </div>
                                </template>
                            </div>
                            <!-- Robust Clickable Trigger: Harmonie Indigo -->
                            <button type="button" @click="$refs.photoInput.click()" 
                                class="absolute -bottom-3 inset-x-4 h-10 bg-white border border-gray-200 rounded-lg shadow-lg flex items-center justify-center gap-2 text-[10px] font-bold text-gray-700 hover:bg-indigo-700 hover:text-white transition-all active:scale-95 z-30">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /></svg>
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
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                        <div class="col-span-1 space-y-1.5">
                            <label for="prenom" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Prénom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $isEdit ? $contact->prenom : '') }}" required 
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none">
                        </div>
                        
                        <div class="col-span-1 space-y-1.5">
                            <label for="nom" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nom de Famille</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $isEdit ? $contact->nom : '') }}" required 
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none">
                        </div>

                        <div class="col-span-2 space-y-1.5 pt-2">
                            <label for="entreprise" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Organisation / Entreprise</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </span>
                                <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $isEdit ? $contact->entreprise : '') }}" required
                                    class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none">
                            </div>
                        </div>

                        <div class="col-span-2 space-y-1.5 border-t border-gray-100 pt-6 mt-2">
                            <label for="poste" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Intitulé de Poste / Fonction</label>
                            <input type="text" name="poste" id="poste" value="{{ old('poste', $isEdit ? $contact->poste : '') }}" 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all outline-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Section: Communication & Logistics -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-4 w-1 bg-indigo-600 rounded-full"></div>
                <h2 class="text-xs font-bold text-gray-700 uppercase tracking-widest">Canaux de Communication</h2>
            </div>
            <div class="p-8 space-y-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-8">
                    <div class="space-y-1.5">
                        <label for="email" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email Professionnel</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $contact->email : '') }}" required 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-sm bg-gray-50/20 focus:bg-white focus:border-indigo-600 transition-all outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label for="telephone" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ligne Directe / GSM</label>
                        <div class="iti-container">
                            <input type="tel" name="telephone_input" id="telephone" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}" 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:border-indigo-600 focus:ring-0 outline-none">
                            <input type="hidden" name="telephone" id="telephone_full" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}">
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 border-t border-gray-100 pt-8">
                    <label for="adresse" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Adresse Postale / Siège</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300 group-focus-within:text-indigo-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </span>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $isEdit ? $contact->adresse : '') }}" 
                            class="block w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg text-sm bg-white focus:border-indigo-600 outline-none transition-all">
                    </div>
                </div>

                <!-- Secondary Data (Enterprise Collapsible) -->
                <div x-data="{ open: false }" class="border-t border-gray-100 pt-8">
                    <button type="button" @click="open = !open" class="flex items-center text-[10px] font-bold text-indigo-600 hover:text-indigo-800 tracking-[0.2em] transition-all">
                        <span x-text="open ? 'RÉDUIRE OPTIONS AVANCÉES' : 'PARAMÈTRES DE CONTACT SUPPLÉMENTAIRES'"></span>
                        <svg class="ml-2 w-3 h-3 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" x-collapse x-cloak class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div x-data="{ emails: {{ json_encode(old('alternative_emails', ($isEdit && $contact->alternative_emails) ? $contact->alternative_emails : [])) }} }" class="space-y-4">
                            <h4 class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border-b border-gray-100 pb-1">Emails Alias</h4>
                            <div class="space-y-2">
                                <template x-for="(email, index) in emails" :key="index">
                                    <div class="flex gap-1 group">
                                        <input type="email" :name="'alternative_emails['+index+']'" x-model="emails[index]" class="block w-full h-10 px-3 border border-gray-200 rounded-lg text-xs bg-gray-50/50 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                        <button type="button" @click="emails.splice(index, 1)" class="p-2 text-gray-300 hover:text-rose-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="emails.push('')" class="text-[9px] font-bold text-indigo-500 hover:underline">+ EMAIL SECONDAIRE</button>
                            </div>
                        </div>

                        <div x-data="{ phones: {{ json_encode(old('alternative_telephones', ($isEdit && $contact->alternative_telephones) ? $contact->alternative_telephones : [])) }} }" class="space-y-4">
                            <h4 class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border-b border-gray-100 pb-1">Lignes Seconds</h4>
                            <div class="space-y-2">
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div class="flex gap-1 group">
                                        <input type="tel" :name="'alternative_telephones['+index+']'" x-model="phones[index]" class="block w-full h-10 px-3 border border-gray-200 rounded-lg text-xs bg-gray-50/50 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                        <button type="button" @click="phones.splice(index, 1)" class="p-2 text-gray-300 hover:text-rose-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="phones.push('')" class="text-[9px] font-bold text-indigo-500 hover:underline">+ TÉLÉPHONE ADDITIONNEL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Administrative Sidebar (Right 30%) -->
    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-[100px]">
        
        <!-- Sidebar Section: Lifecycle Management -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-4 w-1 bg-indigo-600 rounded-full"></div>
                <h3 class="text-[10px] font-bold text-gray-700 uppercase tracking-widest">Cycle de Gestion</h3>
            </div>
            <div class="p-6 space-y-8">
                <!-- Administrative Field -->
                <div class="space-y-2">
                    <label for="statut" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Statut du Pipeline</label>
                    <select id="statut" name="statut" required 
                        class="block w-full h-12 px-4 border border-gray-300 rounded-lg text-xs font-bold bg-white focus:border-indigo-600 outline-none cursor-pointer shadow-sm transition-all">
                        <option value="lead" {{ old('statut', $isEdit ? $contact->statut : 'lead') == 'lead' ? 'selected' : '' }}>LEAD (CADRE INITIAL)</option>
                        <option value="prospect" {{ old('statut', $isEdit ? $contact->statut : '') == 'prospect' ? 'selected' : '' }}>PROSPECT (EN QUALIF)</option>
                        <option value="client" {{ old('statut', $isEdit ? $contact->statut : '') == 'client' ? 'selected' : '' }}>CLIENT ACTIF</option>
                        <option value="inactif" {{ old('statut', $isEdit ? $contact->statut : '') == 'inactif' ? 'selected' : '' }}>INACTIF / PERDU</option>
                    </select>
                </div>

                <!-- Administrative Field -->
                <div class="space-y-2">
                    <label for="source" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Origine / Acquisition</label>
                    <div class="relative">
                        <select id="source" name="source" 
                            class="block w-full h-12 px-4 border border-gray-300 rounded-lg text-xs bg-white focus:border-indigo-600 outline-none cursor-pointer appearance-none">
                            <option value="">NON DÉPENDANT</option>
                            <option value="LinkedIn" {{ old('source', $isEdit ? $contact->source : '') == 'LinkedIn' ? 'selected' : '' }}>RESEAU LINKEDIN</option>
                            <option value="Site Web" {{ old('source', $isEdit ? $contact->source : '') == 'Site Web' ? 'selected' : '' }}>SITE WEB INSTITUTIONNEL</option>
                            <option value="Recommandation" {{ old('source', $isEdit ? $contact->source : '') == 'Recommandation' ? 'selected' : '' }}>PARTENAIRE / REFERRAL</option>
                            <option value="Emailing" {{ old('source', $isEdit ? $contact->source : '') == 'Emailing' ? 'selected' : '' }}>CAMPAGNE EMAIL</option>
                            <option value="Événement" {{ old('source', $isEdit ? $contact->source : '') == 'Événement' ? 'selected' : '' }}>SALON / ÉVÉNEMENT</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Administrative Field: Tags -->
                <div class="space-y-2 pt-2">
                    <label for="tags" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Segmentation Tags</label>
                    <input type="text" name="tags_input" id="tags" value="{{ old('tags_input', ($isEdit && $contact->tags) ? implode(', ', $contact->tags) : '') }}" 
                        class="block w-full h-12 px-4 border border-gray-300 rounded-lg text-xs bg-white focus:border-indigo-600 outline-none transition-all">
                    <p class="text-[8px] font-medium text-gray-400 uppercase italic mt-2 tracking-tight">Séparez les mots-clés par des virgules</p>
                </div>
            </div>
        </div>

        <!-- Sticky Note: Internal Perspective (Deep Indigo/Blue Night Harmony) -->
        <div class="bg-[#0f172a] border border-indigo-900/30 shadow-2xl rounded-xl overflow-hidden relative">
            <div class="px-5 py-4 border-b border-indigo-900/20 bg-white/5 flex items-center justify-between">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-indigo-300">Notes Stratégiques</h3>
                <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <div class="p-0">
                <textarea name="notes_internes" id="notes_internes" rows="10" 
                    class="block w-full border-none p-6 text-sm text-indigo-50 bg-transparent placeholder-indigo-900/50 focus:ring-0 outline-none h-[280px] resize-none leading-relaxed">{{ old('notes_internes', $isEdit ? $contact->notes_internes : '') }}</textarea>
                <div class="px-6 py-3 bg-black/20 text-[9px] font-black text-indigo-400 uppercase flex items-center gap-2">
                    <div class="h-1.5 w-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
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
    .iti__selected-dial-code { font-weight: 700 !important; color: #111827 !important; font-size: 0.81rem !important; }
    .iti__country-list { 
        border-radius: 8px !important; 
        border: 1px solid #e5e7eb !important; 
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important; 
        z-index: 50 !important;
    }
    
    [x-cloak] { display: none !important; }
    
    input::placeholder { font-weight: 400; opacity: 0.4; }
    
    /* Global scrollbar refinement */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
</style>
