@php
    $isEdit = isset($contact);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Main Form Area (Left Column) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Section: Essential Identity -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Informations Générales
                </h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Compact Professional Avatar Upload -->
                    <div class="flex-shrink-0 flex flex-col items-center gap-3">
                        <div class="relative group" x-data="{ photoPreview: '{{ $isEdit ? $contact->avatar_url : '' }}' }">
                            <div class="h-32 w-32 rounded-xl border-2 border-slate-200 overflow-hidden bg-slate-50 flex items-center justify-center">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" alt="Aperçu" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center text-slate-300">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        <span class="text-[10px] font-bold uppercase mt-1">Photo</span>
                                    </div>
                                </template>
                            </div>
                            <label for="photo" class="absolute -bottom-2 -right-2 h-8 w-8 bg-white border border-slate-200 rounded-full shadow-md flex items-center justify-center text-slate-600 cursor-pointer hover:text-indigo-600 hover:border-indigo-200 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
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

                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Prénom -->
                        <div class="space-y-1.5">
                            <label for="prenom" class="text-xs font-bold text-slate-600 ml-0.5">Prénom <span class="text-rose-500">*</span></label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $isEdit ? $contact->prenom : '') }}" required 
                                class="block w-full h-11 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all" placeholder="Ex: Jean">
                        </div>
                        
                        <!-- Nom -->
                        <div class="space-y-1.5">
                            <label for="nom" class="text-xs font-bold text-slate-600 ml-0.5">Nom <span class="text-rose-500">*</span></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $isEdit ? $contact->nom : '') }}" required 
                                class="block w-full h-11 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all" placeholder="Ex: Dupont">
                        </div>

                        <!-- Entreprise -->
                        <div class="space-y-1.5">
                            <label for="entreprise" class="text-xs font-bold text-slate-600 ml-0.5">Entreprise <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </span>
                                <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $isEdit ? $contact->entreprise : '') }}" required
                                    class="block w-full h-11 pl-10 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all" placeholder="Nom de la société">
                            </div>
                        </div>

                        <!-- Poste -->
                        <div class="space-y-1.5">
                            <label for="poste" class="text-xs font-bold text-slate-600 ml-0.5">Fonction</label>
                            <input type="text" name="poste" id="poste" value="{{ old('poste', $isEdit ? $contact->poste : '') }}" 
                                class="block w-full h-11 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all" placeholder="Ex: Directeur Commercial">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Communication -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    Coordonnées Professionnelles
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-bold text-slate-600 ml-0.5">Email principal <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $contact->email : '') }}" required 
                            class="block w-full h-11 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all" placeholder="email@exemple.com">
                    </div>
                    <div class="space-y-1.5">
                        <label for="telephone" class="text-xs font-bold text-slate-600 ml-0.5">Téléphone mobile <span class="text-rose-500">*</span></label>
                        <div class="iti-container">
                            <input type="tel" name="telephone_input" id="telephone" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}" 
                                class="block w-full h-11 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all">
                            <input type="hidden" name="telephone" id="telephone_full" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}">
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 pt-2">
                    <label for="adresse" class="text-xs font-bold text-slate-600 ml-0.5">Adresse du bureau</label>
                    <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $isEdit ? $contact->adresse : '') }}" 
                        class="block w-full h-11 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all" placeholder="Numéro, rue, ville (code postal)">
                </div>

                <!-- Secondary Info Wrapper -->
                <div x-data="{ showExtras: {{ ($isEdit && ($contact->alternative_emails || $contact->alternative_telephones)) ? 'true' : 'false' }} }" class="pt-4">
                    <button type="button" @click="showExtras = !showExtras" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition-colors">
                        <span x-text="showExtras ? '- Masquer coordonnées secondaires' : '+ Ajouter coordonnées secondaires'"></span>
                    </button>

                    <div x-show="showExtras" x-collapse x-cloak class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <!-- Alternative Emails -->
                        <div x-data="{ emails: {{ json_encode(old('alternative_emails', ($isEdit && $contact->alternative_emails) ? $contact->alternative_emails : [])) }} }" class="space-y-3">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Emails additionnels</label>
                            <div class="space-y-2">
                                <template x-for="(email, index) in emails" :key="index">
                                    <div class="flex gap-2">
                                        <input type="email" :name="'alternative_emails['+index+']'" x-model="emails[index]" class="block w-full rounded-lg border-slate-200 h-10 text-xs bg-white focus:border-indigo-400">
                                        <button type="button" @click="emails.splice(index, 1)" class="text-slate-400 hover:text-rose-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="emails.push('')" class="text-[10px] font-bold text-indigo-600">+ Email</button>
                            </div>
                        </div>

                        <!-- Alternative Phones -->
                        <div x-data="{ phones: {{ json_encode(old('alternative_telephones', ($isEdit && $contact->alternative_telephones) ? $contact->alternative_telephones : [])) }} }" class="space-y-3">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Lignes directes secondaires</label>
                            <div class="space-y-2">
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div class="flex gap-2">
                                        <input type="tel" :name="'alternative_telephones['+index+']'" x-model="phones[index]" class="block w-full rounded-lg border-slate-200 h-10 text-xs bg-white focus:border-indigo-400">
                                        <button type="button" @click="phones.splice(index, 1)" class="text-slate-400 hover:text-rose-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="phones.push('')" class="text-[10px] font-bold text-indigo-600">+ Téléphone</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar: Attributes & Metadata (Right Column) -->
    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
        
        <!-- Section: Tracking & Status -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="text-[11px] font-bold text-slate-900 uppercase tracking-[0.15em]">Statut & Qualification</h3>
            </div>
            <div class="p-6 space-y-5">
                <!-- Status Selection -->
                <div class="space-y-1.5">
                    <label for="statut" class="text-xs font-bold text-slate-600 ml-0.5">Cycle de vente</label>
                    <select id="statut" name="statut" required 
                        class="block w-full h-11 border-slate-200 rounded-lg text-sm font-semibold bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all">
                        <option value="lead" {{ old('statut', $isEdit ? $contact->statut : 'lead') == 'lead' ? 'selected' : '' }}>Lead</option>
                        <option value="prospect" {{ old('statut', $isEdit ? $contact->statut : '') == 'prospect' ? 'selected' : '' }}>Prospect</option>
                        <option value="client" {{ old('statut', $isEdit ? $contact->statut : '') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="inactif" {{ old('statut', $isEdit ? $contact->statut : '') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>

                <!-- Acquisition Source -->
                <div class="space-y-1.5">
                    <label for="source" class="text-xs font-bold text-slate-600 ml-0.5">Prouvenance / Source</label>
                    <select id="source" name="source" 
                        class="block w-full h-11 border-slate-200 rounded-lg text-sm bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all">
                        <option value="">Non définie</option>
                        <option value="LinkedIn" {{ old('source', $isEdit ? $contact->source : '') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="Site Web" {{ old('source', $isEdit ? $contact->source : '') == 'Site Web' ? 'selected' : '' }}>Site Web</option>
                        <option value="Recommandation" {{ old('source', $isEdit ? $contact->source : '') == 'Recommandation' ? 'selected' : '' }}>Recommandation</option>
                        <option value="Emailing" {{ old('source', $isEdit ? $contact->source : '') == 'Emailing' ? 'selected' : '' }}>Emailing</option>
                        <option value="Événement" {{ old('source', $isEdit ? $contact->source : '') == 'Événement' ? 'selected' : '' }}>Événement</option>
                    </select>
                </div>

                <!-- Tags -->
                <div class="space-y-1.5">
                    <label for="tags" class="text-xs font-bold text-slate-600 ml-0.5">Mots-clés (Tags)</label>
                    <input type="text" name="tags_input" id="tags" value="{{ old('tags_input', ($isEdit && $contact->tags) ? implode(', ', $contact->tags) : '') }}" 
                        class="block w-full h-11 border-slate-200 rounded-lg text-sm placeholder-slate-300 transition-all"
                        placeholder="Ex: VIP, Prospect-chaud">
                    <p class="text-[10px] text-slate-400 font-medium ml-1 italic">Séparez par des virgules</p>
                </div>
            </div>
        </div>

        <!-- Section: Internal Notes -->
        <div class="bg-indigo-950 rounded-xl shadow-lg overflow-hidden text-white border border-indigo-900">
            <div class="px-6 py-4 border-b border-indigo-900 bg-indigo-900/50">
                <h3 class="text-[11px] font-bold uppercase tracking-[0.15em] opacity-70">Réflexions Internes</h3>
            </div>
            <div class="p-6">
                <textarea name="notes_internes" id="notes_internes" rows="6" 
                    class="block w-full bg-indigo-900/50 border-indigo-800 rounded-lg text-sm text-indigo-100 placeholder-indigo-400/60 focus:ring-0 focus:border-indigo-500/50 transition-all"
                    placeholder="Espace réservé aux notes stratégiques confidentielles...">{{ old('notes_internes', $isEdit ? $contact->notes_internes : '') }}</textarea>
                <div class="mt-4 flex items-center text-[10px] uppercase font-black text-indigo-400/80 gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Visible uniquement par l'équipe
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
    /* Professional CRM density styling */
    .iti { width: 100%; display: block; }
    .iti__selected-dial-code { font-weight: 700; color: #334155; font-size: 0.8rem; }
    .iti__country-list { border-radius: 0.75rem; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
    
    [x-cloak] { display: none !important; }
    
    input::placeholder { font-weight: 400; opacity: 0.6; }
</style>
