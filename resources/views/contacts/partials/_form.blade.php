@php
    $isEdit = isset($contact);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Primary Content Area: The Core Data (Left 70%) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Document Section: Identity & Company -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-3 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-[11px] font-bold text-gray-800 uppercase tracking-widest">Identité et Structure</h2>
            </div>
            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Photo Administration Zone -->
                    <div class="shrink-0 flex flex-col items-center gap-4">
                        <div class="relative" x-data="{ photoPreview: '{{ $isEdit ? $contact->avatar_url : '' }}' }">
                            <div class="h-40 w-40 rounded bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" alt="Profile" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center text-slate-400">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        <span class="text-[9px] font-black uppercase mt-2">Aucun Visuel</span>
                                    </div>
                                </template>
                            </div>
                            <label for="photo" class="absolute -bottom-3 inset-x-4 h-8 bg-white border border-slate-200 rounded shadow-sm flex items-center justify-center text-[10px] font-black text-slate-600 cursor-pointer hover:bg-slate-900 hover:text-white transition-all">
                                CHARGER PHOTO
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

                    <!-- Core Fields: High Density -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                        <div class="col-span-1 space-y-1">
                            <label for="prenom" class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Prénom Officiel</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $isEdit ? $contact->prenom : '') }}" required 
                                class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-0 transition-colors" placeholder="Obligatoire">
                        </div>
                        
                        <div class="col-span-1 space-y-1">
                            <label for="nom" class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Nom de Famille</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $isEdit ? $contact->nom : '') }}" required 
                                class="block w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-900 bg-white focus:border-indigo-600 focus:ring-0 transition-colors" placeholder="Obligatoire">
                        </div>

                        <div class="col-span-2 space-y-1">
                            <label for="entreprise" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Organisation / Entreprise</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </span>
                                <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $isEdit ? $contact->entreprise : '') }}" required
                                    class="block w-full px-3 py-2 pl-10 border border-slate-300 rounded text-sm text-slate-900 bg-white focus:border-indigo-600 focus:ring-0 transition-colors" placeholder="Désignation sociale complète">
                            </div>
                        </div>

                        <div class="col-span-2 space-y-1 border-t border-slate-50 pt-3 mt-1">
                            <label for="poste" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Intitulé de Poste / Responsabilité</label>
                            <input type="text" name="poste" id="poste" value="{{ old('poste', $isEdit ? $contact->poste : '') }}" 
                                class="block w-full px-3 py-2 border border-slate-300 rounded text-sm text-slate-900 bg-white focus:border-indigo-600 focus:ring-0 transition-colors" placeholder="Ex: Directeur des Achats">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Section: Communication & Logistics -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-3 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Canaux de Communication</h2>
            </div>
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="space-y-1">
                        <label for="email" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Email Professionnel Principal</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $contact->email : '') }}" required 
                            class="block w-full px-3 py-2 border border-slate-300 rounded text-sm bg-indigo-50/10 focus:border-indigo-600 focus:ring-0" placeholder="contact@domaine.com">
                    </div>
                    <div class="space-y-1">
                        <label for="telephone" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Ligne Directe / Mobile</label>
                        <div class="iti-container">
                            <input type="tel" name="telephone_input" id="telephone" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}" 
                                class="block w-full px-3 py-2 border border-slate-300 rounded text-sm focus:border-indigo-600 focus:ring-0">
                            <input type="hidden" name="telephone" id="telephone_full" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}">
                        </div>
                    </div>
                </div>

                <div class="space-y-1 border-t border-slate-50 pt-5">
                    <label for="adresse" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Siège Social / Adresse Postale</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </span>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $isEdit ? $contact->adresse : '') }}" 
                            class="block w-full px-3 py-2 pl-10 border border-slate-300 rounded text-sm bg-white focus:border-indigo-600 focus:ring-0" placeholder="Adresse complète (Ville, Pays)">
                    </div>
                </div>

                <!-- Secondary Data (Enterprise Collapsible) -->
                <div x-data="{ open: false }" class="border-t border-slate-100 pt-6">
                    <button type="button" @click="open = !open" class="flex items-center text-[10px] font-black text-indigo-600 hover:text-slate-900 tracking-[0.2em] transition-all">
                        <span x-text="open ? 'RÉDUIRE PARAMÈTRES AVANCÉS' : 'AFFICHER COORDONNÉES SECONDAIRES'"></span>
                        <svg class="ml-2 w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" x-collapse x-cloak class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div x-data="{ emails: {{ json_encode(old('alternative_emails', ($isEdit && $contact->alternative_emails) ? $contact->alternative_emails : [])) }} }" class="space-y-4">
                            <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">Alias Emails</h4>
                            <div class="space-y-2">
                                <template x-for="(email, index) in emails" :key="index">
                                    <div class="flex gap-1 group">
                                        <input type="email" :name="'alternative_emails['+index+']'" x-model="emails[index]" class="block w-full h-9 px-3 border border-slate-200 rounded text-xs bg-slate-50/50 focus:bg-white focus:border-indigo-400 outline-none">
                                        <button type="button" @click="emails.splice(index, 1)" class="p-2 text-slate-300 hover:text-rose-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="emails.push('')" class="text-[9px] font-black text-indigo-500 hover:underline">+ EMAIL SUPPLÉMENTAIRE</button>
                            </div>
                        </div>

                        <div x-data="{ phones: {{ json_encode(old('alternative_telephones', ($isEdit && $contact->alternative_telephones) ? $contact->alternative_telephones : [])) }} }" class="space-y-4">
                            <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">Lignes Secondaires</h4>
                            <div class="space-y-2">
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div class="flex gap-1 group">
                                        <input type="tel" :name="'alternative_telephones['+index+']'" x-model="phones[index]" class="block w-full h-9 px-3 border border-slate-200 rounded text-xs bg-slate-50/50 focus:bg-white focus:border-indigo-400 outline-none">
                                        <button type="button" @click="phones.splice(index, 1)" class="p-2 text-slate-300 hover:text-rose-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="phones.push('')" class="text-[9px] font-black text-indigo-500 hover:underline">+ NUMÉRO SUPPLÉMENTAIRE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Administrative Sidebar (Right 30%) -->
    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-[100px]">
        
        <!-- Sidebar Section: Global Positioning -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Cycle de Vie & Ventes</h3>
            </div>
            <div class="p-5 space-y-6">
                <!-- Administrative Field -->
                <div class="space-y-1.5">
                    <label for="statut" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Statut Pipeline</label>
                    <select id="statut" name="statut" required 
                        class="block w-full h-10 px-3 border border-slate-300 rounded text-xs font-bold bg-white focus:border-indigo-600 outline-none cursor-pointer">
                        <option value="lead" {{ old('statut', $isEdit ? $contact->statut : 'lead') == 'lead' ? 'selected' : '' }}>LEAD (INITIÉ)</option>
                        <option value="prospect" {{ old('statut', $isEdit ? $contact->statut : '') == 'prospect' ? 'selected' : '' }}>PROSPECT (EN COURS)</option>
                        <option value="client" {{ old('statut', $isEdit ? $contact->statut : '') == 'client' ? 'selected' : '' }}>CLIENT (CONCLU)</option>
                        <option value="inactif" {{ old('statut', $isEdit ? $contact->statut : '') == 'inactif' ? 'selected' : '' }}>INACTIF / PERDU</option>
                    </select>
                </div>

                <!-- Administrative Field -->
                <div class="space-y-1.5">
                    <label for="source" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Provenance CRM / Origine</label>
                    <select id="source" name="source" 
                        class="block w-full h-10 px-3 border border-slate-300 rounded text-xs bg-white focus:border-indigo-600 outline-none cursor-pointer">
                        <option value="">NON DÉTERMINÉE</option>
                        <option value="LinkedIn" {{ old('source', $isEdit ? $contact->source : '') == 'LinkedIn' ? 'selected' : '' }}>LINKEDIN (RÉSEAU)</option>
                        <option value="Site Web" {{ old('source', $isEdit ? $contact->source : '') == 'Site Web' ? 'selected' : '' }}>SITE WEB (APPEL D'INBOUND)</option>
                        <option value="Recommandation" {{ old('source', $isEdit ? $contact->source : '') == 'Recommandation' ? 'selected' : '' }}>RECOMMANDATION (TIERS)</option>
                        <option value="Emailing" {{ old('source', $isEdit ? $contact->source : '') == 'Emailing' ? 'selected' : '' }}>EMAILING (CAMPAGNE)</option>
                        <option value="Événement" {{ old('source', $isEdit ? $contact->source : '') == 'Événement' ? 'selected' : '' }}>ÉVÉNEMENT / SALON</option>
                    </select>
                </div>

                <!-- Administrative Field: Professional Tags -->
                <div class="space-y-1.5 pt-2">
                    <label for="tags" class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Segmentation (Mots-clés)</label>
                    <input type="text" name="tags_input" id="tags" value="{{ old('tags_input', ($isEdit && $contact->tags) ? implode(', ', $contact->tags) : '') }}" 
                        class="block w-full h-10 px-3 border border-slate-300 rounded text-xs bg-white focus:border-indigo-600 outline-none"
                        placeholder="VIP, INDUSTRIE, URGENCY_HIGH">
                    <p class="text-[8px] font-medium text-slate-400 uppercase italic mt-1">Séparez par des virgules pour le filtrage</p>
                </div>
            </div>
        </div>

        <!-- Sticky Note: Professional Context -->
        <div class="bg-white border border-slate-200 shadow-lg rounded-lg overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-slate-900 text-white flex items-center justify-between">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-300">Notes Stratégiques</h3>
                <svg class="h-3.5 w-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <div class="p-0">
                <textarea name="notes_internes" id="notes_internes" rows="10" 
                    class="block w-full border-none p-5 text-sm text-slate-800 bg-indigo-50/30 placeholder-slate-400 focus:ring-0 outline-none h-[250px] resize-none"
                    placeholder="Saisissez ici le contexte confidentiel, les enjeux commerciaux ou les compte-rendus d'appels...">{{ old('notes_internes', $isEdit ? $contact->notes_internes : '') }}</textarea>
                <div class="px-5 py-2 bg-slate-50 border-t border-slate-100 text-[9px] font-black text-slate-400 uppercase leading-none">
                    Espace confidentiel (Interne uniquement)
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
    /* Integrated CRM density styling */
    .iti { width: 100% !important; display: block !important; }
    .iti__selected-dial-code { font-weight: 700 !important; color: #111827 !important; font-size: 0.75rem !important; }
    .iti__country-list { 
        border-radius: 6px !important; 
        border: 1px solid #e5e7eb !important; 
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1) !important; 
        font-size: 0.75rem !important;
    }
    
    [x-cloak] { display: none !important; }
    
    input::placeholder { font-weight: 400; opacity: 0.4; }
</style>
