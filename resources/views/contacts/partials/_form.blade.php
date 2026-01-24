@php
    $isEdit = isset($contact);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Primary Content Area: The Core Data (Left 70%) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Document Section: Identity & Company -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-3 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Identité et Structure</h2>
            </div>
            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Photo Administration Zone: High Visibility & Clickable -->
                    <div class="shrink-0 flex flex-col items-center gap-4">
                        <div class="relative group" x-data="{ photoPreview: '{{ $isEdit ? $contact->avatar_url : '' }}' }">
                            <div class="h-40 w-40 rounded bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" alt="Profile" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center text-gray-400">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                        <span class="text-[9px] font-bold uppercase mt-2 tracking-tighter">Profil Photo</span>
                                    </div>
                                </template>
                            </div>
                            <!-- Secure Click Layer -->
                            <label for="photo" class="absolute -bottom-3 inset-x-4 h-9 bg-white border border-gray-200 rounded shadow-md flex items-center justify-center text-[10px] font-bold text-gray-700 cursor-pointer hover:bg-gray-900 hover:text-white transition-all z-20">
                                MODIFIER PHOTO
                            </label>
                            <input type="file" name="photo" id="photo" class="hidden" accept="image/*" @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL(file);
                                }
                            ">
                        </div>
                    </div>

                    <!-- Core Fields: Aligned with App Palette -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                        <div class="col-span-1 space-y-1.5">
                            <label for="prenom" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Prénom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $isEdit ? $contact->prenom : '') }}" required 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600/10 transition-colors" placeholder="Ex: Marc">
                        </div>
                        
                        <div class="col-span-1 space-y-1.5">
                            <label for="nom" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Nom</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $isEdit ? $contact->nom : '') }}" required 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600/10 transition-colors" placeholder="Ex: Dubois">
                        </div>

                        <div class="col-span-2 space-y-1.5 pt-1">
                            <label for="entreprise" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Société / Organisation</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </span>
                                <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $isEdit ? $contact->entreprise : '') }}" required
                                    class="block w-full px-3 py-2.5 pl-10 border border-gray-300 rounded-md text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600/10 transition-colors" placeholder="Désignation complète du partenaire">
                            </div>
                        </div>

                        <div class="col-span-2 space-y-1.5 border-t border-gray-100 pt-4 mt-2">
                            <label for="poste" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Poste Occupé</label>
                            <input type="text" name="poste" id="poste" value="{{ old('poste', $isEdit ? $contact->poste : '') }}" 
                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600/10 transition-colors" placeholder="Directeur Général, Responsable IT...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Section: Channels & Logistics -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-3 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Canaux de Communication</h2>
            </div>
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="space-y-1.5">
                        <label for="email" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Email Principal</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $contact->email : '') }}" required 
                            class="block w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm bg-gray-50/30 focus:bg-white focus:border-indigo-600 focus:ring-0" placeholder="coordonnees@societe.com">
                    </div>
                    <div class="space-y-1.5">
                        <label for="telephone" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Téléphone Professionnel</label>
                        <div class="iti-container">
                            <input type="tel" name="telephone_input" id="telephone" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}" 
                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-md text-sm focus:border-indigo-600 focus:ring-0">
                            <input type="hidden" name="telephone" id="telephone_full" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}">
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 border-t border-gray-100 pt-6">
                    <label for="adresse" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Adresse Bureau / Siège</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </span>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $isEdit ? $contact->adresse : '') }}" 
                            class="block w-full px-3 py-2.5 pl-10 border border-gray-300 rounded-md text-sm bg-white focus:border-indigo-600 focus:ring-0" placeholder="Rue, Code Postal, Ville, Pays">
                    </div>
                </div>

                <!-- Secondary Data (Enterprise Collapsible) -->
                <div x-data="{ open: false }" class="border-t border-gray-100 pt-6">
                    <button type="button" @click="open = !open" class="flex items-center text-[10px] font-bold text-indigo-600 hover:text-indigo-800 tracking-widest transition-all">
                        <span x-text="open ? 'RÉDUIRE OPTIONS' : 'PARAMÈTRES DE CONTACT SUPPLÉMENTAIRES'"></span>
                        <svg class="ml-2 w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" x-collapse x-cloak class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div x-data="{ emails: {{ json_encode(old('alternative_emails', ($isEdit && $contact->alternative_emails) ? $contact->alternative_emails : [])) }} }" class="space-y-4">
                            <h4 class="text-[9px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-1 italic">Emails Alias</h4>
                            <div class="space-y-2">
                                <template x-for="(email, index) in emails" :key="index">
                                    <div class="flex gap-1 group">
                                        <input type="email" :name="'alternative_emails['+index+']'" x-model="emails[index]" class="block w-full h-9 px-3 border border-gray-200 rounded text-xs bg-gray-50/50 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                        <button type="button" @click="emails.splice(index, 1)" class="p-2 text-gray-300 hover:text-rose-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="emails.push('')" class="text-[9px] font-bold text-indigo-600 hover:underline">+ CONTACT EMAIL</button>
                            </div>
                        </div>

                        <div x-data="{ phones: {{ json_encode(old('alternative_telephones', ($isEdit && $contact->alternative_telephones) ? $contact->alternative_telephones : [])) }} }" class="space-y-4">
                            <h4 class="text-[9px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-1 italic">Lignes Directes</h4>
                            <div class="space-y-2">
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div class="flex gap-1 group">
                                        <input type="tel" :name="'alternative_telephones['+index+']'" x-model="phones[index]" class="block w-full h-9 px-3 border border-gray-200 rounded text-xs bg-gray-50/50 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                        <button type="button" @click="phones.splice(index, 1)" class="p-2 text-gray-300 hover:text-rose-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="phones.push('')" class="text-[9px] font-bold text-indigo-600 hover:underline">+ LIGNE TÉLÉPHONIQUE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Administrative Sidebar: Rights & Status (Right 30%) -->
    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-[100px]">
        
        <!-- Sidebar Section: Lifecycle Management -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Cycle de Gestion</h3>
            </div>
            <div class="p-6 space-y-7">
                <!-- Status Field -->
                <div class="space-y-2">
                    <label for="statut" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Phase du Prospect</label>
                    <select id="statut" name="statut" required 
                        class="block w-full h-11 px-3 border border-gray-300 rounded-md text-xs font-bold bg-white focus:border-indigo-600 outline-none cursor-pointer">
                        <option value="lead" {{ old('statut', $isEdit ? $contact->statut : 'lead') == 'lead' ? 'selected' : '' }}>LEAD INITIAL</option>
                        <option value="prospect" {{ old('statut', $isEdit ? $contact->statut : '') == 'prospect' ? 'selected' : '' }}>PROSPECT QUALIFIÉ</option>
                        <option value="client" {{ old('statut', $isEdit ? $contact->statut : '') == 'client' ? 'selected' : '' }}>CLIENT ACTIF</option>
                        <option value="inactif" {{ old('statut', $isEdit ? $contact->statut : '') == 'inactif' ? 'selected' : '' }}>INACTIF / ARCHIVÉ</option>
                    </select>
                </div>

                <!-- Source Field -->
                <div class="space-y-2">
                    <label for="source" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Origine de l'Acquisition</label>
                    <div class="relative">
                        <select id="source" name="source" 
                            class="block w-full h-11 px-3 border border-gray-300 rounded-md text-xs bg-white focus:border-indigo-600 outline-none cursor-pointer appearance-none">
                            <option value="">NON SPÉCIFIÉ</option>
                            <option value="LinkedIn" {{ old('source', $isEdit ? $contact->source : '') == 'LinkedIn' ? 'selected' : '' }}>RÉSEAU LINKEDIN</option>
                            <option value="Site Web" {{ old('source', $isEdit ? $contact->source : '') == 'Site Web' ? 'selected' : '' }}>SITE WEB (APPEL D'OFFRE)</option>
                            <option value="Recommandation" {{ old('source', $isEdit ? $contact->source : '') == 'Recommandation' ? 'selected' : '' }}>PARTENAIRE / REFERAL</option>
                            <option value="Emailing" {{ old('source', $isEdit ? $contact->source : '') == 'Emailing' ? 'selected' : '' }}>PROSPECTION EMAIL</option>
                            <option value="Événement" {{ old('source', $isEdit ? $contact->source : '') == 'Événement' ? 'selected' : '' }}>SALON PROFESSIONNEL</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Segmentation Tags -->
                <div class="space-y-2 pt-2">
                    <label for="tags" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Classification Interne (Tags)</label>
                    <input type="text" name="tags_input" id="tags" value="{{ old('tags_input', ($isEdit && $contact->tags) ? implode(', ', $contact->tags) : '') }}" 
                        class="block w-full h-11 px-3 border border-gray-300 rounded-md text-xs bg-white focus:border-indigo-600 outline-none"
                        placeholder="VIP, INDUSTRIE_TECH, CHAUD">
                    <p class="text-[8px] font-medium text-gray-400 uppercase mt-1.5 italic">Utilisez la virgule pour séparer les entrées</p>
                </div>
            </div>
        </div>

        <!-- Professional Context: Secure & Dedicated -->
        <div class="bg-gray-900 border border-gray-800 shadow-xl rounded-lg overflow-hidden relative">
            <!-- Icon Badge -->
            <div class="absolute top-3 right-3 opacity-20 text-indigo-400">
                <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24"><path d="M11 5h2v2h-2V5zm0 4h2v6h-2V9zm-8 4v2h2v-2H3zm16 0v2h2v-2h-2z"/></svg>
            </div>
            
            <div class="px-5 py-3 border-b border-gray-800 bg-gray-800 flex items-center justify-between">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-indigo-300">Contexte Stratégique</h3>
            </div>
            <div class="p-0">
                <textarea name="notes_internes" id="notes_internes" rows="8" 
                    class="block w-full border-none p-5 text-sm text-gray-300 bg-transparent placeholder-gray-600 focus:ring-0 outline-none min-h-[220px] resize-none"
                    placeholder="Saisissez ici les informations sensibles, enjeux ou historiques d'échange...">{{ old('notes_internes', $isEdit ? $contact->notes_internes : '') }}</textarea>
                <div class="px-5 py-2.5 bg-black/30 flex items-center gap-2 text-[9px] font-black text-gray-500 uppercase tracking-wider">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Contenu Restreint (Équipe CRM)
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
    /* Robust Integrated Theme Styles */
    .iti { width: 100% !important; display: block !important; }
    .iti__selected-dial-code { font-weight: 700 !important; color: #111827 !important; font-size: 0.81rem !important; }
    .iti__country-list { 
        border-radius: 8px !important; 
        border: 1px solid #e5e7eb !important; 
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important; 
        font-size: 0.75rem !important;
        z-index: 50 !important;
    }
    
    [x-cloak] { display: none !important; }
    
    input::placeholder { font-weight: 400; opacity: 0.4; }
    
    /* Ensure the upload label is always on top for clickability */
    label[for="photo"] {
        pointer-events: auto !important;
        cursor: pointer !important;
    }
</style>
