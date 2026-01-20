@php
    $isEdit = isset($contact);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Left Column: Identity & Contact Details (8/12 = 2/3) -->
    <div class="lg:col-span-8 space-y-8">
        
        <!-- Card: Identity -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 flex items-center">
                    <svg class="h-6 w-6 text-indigo-500 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Identité du Contact
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                 <!-- Prénom -->
                 <div>
                    <label for="prenom" class="block text-sm font-bold text-slate-900 mb-2">
                        Prénom <span class="text-rose-500"></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $isEdit ? $contact->prenom : '') }}" required 
                            class="block w-full pl-10 rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors placeholder-slate-400" placeholder=>
                    </div>
                </div>
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-bold text-slate-900 mb-2">
                        Nom <span class="text-rose-500"></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $isEdit ? $contact->nom : '') }}" required 
                            class="block w-full pl-10 rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors placeholder-slate-400" placeholder=>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Contact Coordinates -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 flex items-center">
                    <svg class="h-6 w-6 text-indigo-500 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Coordonnées
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Email Principal -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-900 mb-2">
                            Email professionnel <span class="text-rose-500"></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $contact->email : '') }}" required 
                                class="block w-full pl-10 rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors placeholder-slate-400">
                        </div>
                    </div>

                    <!-- Téléphone Principal -->
                    <div>
                        <label for="telephone" class="block text-sm font-bold text-slate-900 mb-2">
                            Téléphone mobile <span class="text-rose-500"></span>
                        </label>
                        <input type="tel" name="telephone_input" id="telephone" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}" 
                            class="block w-full rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors pl-3 placeholder-slate-400">
                        <input type="hidden" name="telephone" id="telephone_full" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}">
                    </div>
                </div>

                <!-- Address -->
                <div class="border-t border-slate-100 pt-6">
                    <label for="adresse" class="block text-sm font-bold text-slate-900 mb-2">Adresse postale</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $isEdit ? $contact->adresse : '') }}" 
                            class="block w-full pl-10 rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors placeholder-slate-400"
                            placeholder="">
                    </div>
                </div>

                <!-- Advanced Coordinates (Alternatives) -->
                <div x-data="{ showAdvanced: {{ ($isEdit && ($contact->alternative_emails || $contact->alternative_telephones)) ? 'true' : 'false' }} }">
                    <button type="button" @click="showAdvanced = !showAdvanced" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center py-2">
                        <span x-text="showAdvanced ? 'Masquer les coordonnées secondaires' : 'Ajouter des coordonnées secondaires'"></span>
                        <svg class="w-4 h-4 ml-1 transition-transform" :class="showAdvanced ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="showAdvanced" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6 animate-fade-in-down" style="display: none;">
                        <!-- Emails Alternatifs -->
                        <div x-data="{ emails: {{ json_encode(old('alternative_emails', ($isEdit && $contact->alternative_emails) ? $contact->alternative_emails : [])) }} }">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Autres Emails</label>
                            <div class="space-y-3">
                                <template x-for="(email, index) in emails" :key="index">
                                    <div class="flex gap-2">
                                        <input type="email" :name="'alternative_emails['+index+']'" x-model="emails[index]" class="block w-full rounded-lg border-slate-300 bg-slate-50 focus:bg-white text-base h-10">
                                        <button type="button" @click="emails.splice(index, 1)" class="text-slate-400 hover:text-rose-500">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="emails.push('')" class="text-sm text-indigo-600 hover:underline font-medium">+ Ajouter un email</button>
                            </div>
                        </div>

                        <!-- Téléphones Alternatifs -->
                        <div x-data="{ phones: {{ json_encode(old('alternative_telephones', ($isEdit && $contact->alternative_telephones) ? $contact->alternative_telephones : [])) }} }">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Autres Téléphones</label>
                            <div class="space-y-3">
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div class="flex gap-2">
                                        <input type="tel" :name="'alternative_telephones['+index+']'" x-model="phones[index]" class="block w-full rounded-lg border-slate-300 bg-slate-50 focus:bg-white text-base h-10">
                                        <button type="button" @click="phones.splice(index, 1)" class="text-slate-400 hover:text-rose-500">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="phones.push('')" class="text-sm text-indigo-600 hover:underline font-medium">+ Ajouter un numéro</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Professional Context & Meta (4/12 = 1/3) -->
    <div class="lg:col-span-4 space-y-8 sticky top-6 h-fit">
        
        <!-- Card: Professional Info -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-900">Profil professionnel</h3>
            </div>
            <div class="p-6 space-y-6">
                <!-- Entreprise -->
                <div>
                    <label for="entreprise" class="block text-sm font-bold text-slate-900 mb-2">
                        Entreprise <span class="text-rose-500"></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $isEdit ? $contact->entreprise : '') }}" required
                            class="block w-full pl-10 rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors placeholder-slate-400">
                    </div>
                </div>

                <!-- Poste -->
                <div>
                    <label for="poste" class="block text-sm font-bold text-slate-900 mb-2">Poste / Fonction</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="text" name="poste" id="poste" value="{{ old('poste', $isEdit ? $contact->poste : '') }}" 
                            class="block w-full pl-10 rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors placeholder-slate-400">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Classification -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-900">Suivi & Classification</h3>
            </div>
            <div class="p-6 space-y-6">
                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-bold text-slate-900 mb-2">
                        Statut <span class="text-rose-500"></span>
                    </label>
                    <select id="statut" name="statut" required 
                        class="block w-full rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors">
                        <option value="lead" {{ old('statut', $isEdit ? $contact->statut : 'lead') == 'lead' ? 'selected' : '' }}>Lead</option>
                        <option value="prospect" {{ old('statut', $isEdit ? $contact->statut : '') == 'prospect' ? 'selected' : '' }}>Prospect</option>
                        <option value="client" {{ old('statut', $isEdit ? $contact->statut : '') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="inactif" {{ old('statut', $isEdit ? $contact->statut : '') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>

                <!-- Source -->
                <div>
                    <label for="source" class="block text-sm font-bold text-slate-900 mb-2">Source</label>
                    <select id="source" name="source" 
                        class="block w-full rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors">
                        <option value=""></option>
                        <option value="LinkedIn" {{ old('source', $isEdit ? $contact->source : '') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="Site Web" {{ old('source', $isEdit ? $contact->source : '') == 'Site Web' ? 'selected' : '' }}>Site Web</option>
                        <option value="Recommandation" {{ old('source', $isEdit ? $contact->source : '') == 'Recommandation' ? 'selected' : '' }}>Recommandation</option>
                        <option value="Emailing" {{ old('source', $isEdit ? $contact->source : '') == 'Emailing' ? 'selected' : '' }}>Emailing</option>
                        <option value="Événement" {{ old('source', $isEdit ? $contact->source : '') == 'Événement' ? 'selected' : '' }}>Événement</option>
                        <option value="Autre" {{ old('source', $isEdit ? $contact->source : '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                 <!-- Tags -->
                 <div>
                    <label for="tags" class="block text-sm font-bold text-slate-900 mb-2">Tags</label>
                    <input type="text" name="tags_input" id="tags" value="{{ old('tags_input', ($isEdit && $contact->tags) ? implode(', ', $contact->tags) : '') }}" 
                        class="block w-full rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base h-12 transition-colors placeholder-slate-400"
                        placeholder="">
                    <p class="mt-1 text-xs text-slate-500 font-medium">Séparés par des virgules</p>
                </div>
            </div>
        </div>

        <!-- Card: Notes -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-900">Note Interne</h3>
            </div>
            <div class="p-6">
                <textarea name="notes_internes" id="notes_internes" rows="6" 
                    class="block w-full rounded-lg border-slate-300 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-base transition-colors"
                    placeholder="Information confidentielle ou contexte important...">{{ old('notes_internes', $isEdit ? $contact->notes_internes : '') }}</textarea>
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