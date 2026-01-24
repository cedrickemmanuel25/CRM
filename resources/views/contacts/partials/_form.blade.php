@php
    $isEdit = isset($contact);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <!-- Left Column: Core Identity & Details -->
    <div class="lg:col-span-8 space-y-8">
        
        <!-- Identity Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden transition-all hover:shadow-md">
            <div class="px-8 py-5 border-b border-slate-100 bg-slate-50/40 backdrop-blur-md flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </span>
                    Identité du Contact
                </h3>
            </div>
            
            <div class="p-8">
                <!-- Premium Photo Section -->
                <div class="mb-10 flex flex-col sm:flex-row items-center gap-8 pb-10 border-b border-slate-50">
                    <div class="relative group" x-data="{ photoPreview: '{{ $isEdit ? $contact->avatar_url : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%23cbd5e1\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'%3E%3C/path%3E%3C/svg%3E' }}' }">
                        <div class="h-32 w-32 rounded-full border-[6px] border-white shadow-xl overflow-hidden bg-slate-50 ring-1 ring-slate-200 group-hover:scale-[1.02] transition-transform duration-300">
                            <img :src="photoPreview" alt="Profile" class="h-full w-full object-cover">
                        </div>
                        <label for="photo" class="absolute bottom-0 right-0 h-10 w-10 bg-indigo-600 rounded-full flex items-center justify-center text-white border-4 border-white shadow-lg cursor-pointer hover:bg-indigo-700 hover:scale-110 transition-all duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
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
                    <div class="flex-1 text-center sm:text-left space-y-2">
                        <h4 class="text-lg font-bold text-slate-900 leading-tight">Image de profil</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">
                            Personnalisez la fiche avec une photo. <br>
                            <span class="text-xs italic text-slate-400 font-normal">Formats : JPG, PNG ou WebP. Max 2Mo.</span>
                        </p>
                        <div class="pt-2">
                            <button type="button" @click="document.getElementById('photo').click()" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                                Sélectionner une image
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <!-- Prénom -->
                    <div class="space-y-2">
                        <label for="prenom" class="block text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Prénom</label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $isEdit ? $contact->prenom : '') }}" required 
                                class="block w-full pl-12 pr-4 h-14 bg-slate-50 border-slate-200 rounded-2xl text-slate-900 font-medium placeholder-slate-400 transition-all focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500" placeholder="Ex: Jean">
                        </div>
                    </div>
                    
                    <!-- Nom -->
                    <div class="space-y-2">
                        <label for="nom" class="block text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Nom de famille</label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $isEdit ? $contact->nom : '') }}" required 
                                class="block w-full pl-12 pr-4 h-14 bg-slate-50 border-slate-200 rounded-2xl text-slate-900 font-medium placeholder-slate-400 transition-all focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500" placeholder="Ex: Dupont">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Methods Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden transition-all hover:shadow-md">
            <div class="px-8 py-5 border-b border-slate-100 bg-slate-50/40 backdrop-blur-md flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-3">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </span>
                    Coordonnées Directes
                </h3>
            </div>
            
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <!-- Professional Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Email professionnel</label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $contact->email : '') }}" required 
                                class="block w-full pl-12 pr-4 h-14 bg-slate-50 border-slate-200 rounded-2xl text-slate-900 font-medium placeholder-slate-400 transition-all focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500" placeholder="jean.dupont@entreprise.com">
                        </div>
                    </div>

                    <!-- Main Phone -->
                    <div class="space-y-2">
                        <label for="telephone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Téléphone mobile</label>
                        <div class="phone-input-fancy group">
                            <input type="tel" name="telephone_input" id="telephone" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}" 
                                class="block w-full h-14 bg-slate-50 border-slate-200 rounded-2xl text-slate-900 font-medium transition-all focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500">
                            <input type="hidden" name="telephone" id="telephone_full" value="{{ old('telephone', $isEdit ? $contact->telephone : '') }}">
                        </div>
                    </div>
                </div>

                <!-- Postal Address -->
                <div class="space-y-2 pt-4">
                    <label for="adresse" class="block text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Adresse postale</label>
                    <div class="group relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $isEdit ? $contact->adresse : '') }}" 
                            class="block w-full pl-12 pr-4 h-14 bg-slate-50 border-slate-200 rounded-2xl text-slate-900 font-medium placeholder-slate-400 transition-all focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500" placeholder="123 Rue de l'Équilibre, 75001 Paris">
                    </div>
                </div>

                <!-- Collapsible Advanced Info -->
                <div x-data="{ showAdvanced: {{ ($isEdit && ($contact->alternative_emails || $contact->alternative_telephones)) ? 'true' : 'false' }} }" class="pt-4">
                    <button type="button" @click="showAdvanced = !showAdvanced" class="inline-flex items-center text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-indigo-600 transition-colors">
                        <span x-text="showAdvanced ? 'Masquer options secondaires' : 'Afficher options secondaires'"></span>
                        <svg class="w-3 h-3 ml-2 transition-transform duration-300" :class="showAdvanced ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="showAdvanced" x-collapse x-cloak class="mt-6 border-t border-slate-50 pt-8 animate-fade-in">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                            <!-- Alternative Emails -->
                            <div x-data="{ emails: {{ json_encode(old('alternative_emails', ($isEdit && $contact->alternative_emails) ? $contact->alternative_emails : [])) }} }" class="space-y-4">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Autres Emails</label>
                                <div class="space-y-3">
                                    <template x-for="(email, index) in emails" :key="index">
                                        <div class="flex gap-2 group/field">
                                            <input type="email" :name="'alternative_emails['+index+']'" x-model="emails[index]" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-sm h-11 focus:bg-white focus:border-indigo-400 transition-all">
                                            <button type="button" @click="emails.splice(index, 1)" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                    <button type="button" @click="emails.push('')" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800 py-1">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Ajouter un email
                                    </button>
                                </div>
                            </div>

                            <!-- Alternative Phones -->
                            <div x-data="{ phones: {{ json_encode(old('alternative_telephones', ($isEdit && $contact->alternative_telephones) ? $contact->alternative_telephones : [])) }} }" class="space-y-4">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Autres Téléphones</label>
                                <div class="space-y-3">
                                    <template x-for="(phone, index) in phones" :key="index">
                                        <div class="flex gap-2 group/field">
                                            <input type="tel" :name="'alternative_telephones['+index+']'" x-model="phones[index]" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-sm h-11 focus:bg-white focus:border-indigo-400 transition-all">
                                            <button type="button" @click="phones.splice(index, 1)" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                    <button type="button" @click="phones.push('')" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800 py-1">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Ajouter un numéro
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Professional Context & Meta -->
    <div class="lg:col-span-4 space-y-8 lg:sticky lg:top-10">
        
        <!-- Professional Bio Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden transition-all hover:shadow-md">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/40 backdrop-blur-md">
                <h3 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em]">Profil Pro</h3>
            </div>
            <div class="p-7 space-y-6">
                <!-- Company -->
                <div class="space-y-2">
                    <label for="entreprise" class="block text-xs font-bold text-slate-700 ml-1">Entreprise</label>
                    <div class="group relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $isEdit ? $contact->entreprise : '') }}" required
                            class="block w-full pl-12 pr-4 h-12 bg-slate-50 border-slate-200 rounded-xl text-sm text-slate-900 font-medium placeholder-slate-400 transition-all focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500" placeholder="Ex: Acme Corp">
                    </div>
                </div>

                <!-- Position -->
                <div class="space-y-2">
                    <label for="poste" class="block text-xs font-bold text-slate-700 ml-1">Fonction</label>
                    <div class="group relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="text" name="poste" id="poste" value="{{ old('poste', $isEdit ? $contact->poste : '') }}" 
                            class="block w-full pl-12 pr-4 h-12 bg-slate-50 border-slate-200 rounded-xl text-sm text-slate-900 font-medium placeholder-slate-400 transition-all focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500" placeholder="Ex: Directeur Marketing">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden transition-all hover:shadow-md">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/40 backdrop-blur-md">
                <h3 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em]">Classification</h3>
            </div>
            <div class="p-7 space-y-6">
                <!-- Status -->
                <div class="space-y-2">
                    <label for="statut" class="block text-xs font-bold text-slate-700 ml-1">Statut</label>
                    <select id="statut" name="statut" required 
                        class="block w-full h-12 border-slate-200 rounded-xl text-sm text-slate-900 font-bold bg-slate-50 transition-all focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                        <option value="lead" {{ old('statut', $isEdit ? $contact->statut : 'lead') == 'lead' ? 'selected' : '' }}>Lead 🔥</option>
                        <option value="prospect" {{ old('statut', $isEdit ? $contact->statut : '') == 'prospect' ? 'selected' : '' }}>Prospect 💎</option>
                        <option value="client" {{ old('statut', $isEdit ? $contact->statut : '') == 'client' ? 'selected' : '' }}>Client 👑</option>
                        <option value="inactif" {{ old('statut', $isEdit ? $contact->statut : '') == 'inactif' ? 'selected' : '' }}>Inactif ⚙️</option>
                    </select>
                </div>

                <!-- Source -->
                <div class="space-y-2">
                    <label for="source" class="block text-xs font-bold text-slate-700 ml-1">Acquisition</label>
                    <div class="relative">
                        <select id="source" name="source" 
                            class="block w-full h-12 border-slate-200 rounded-xl text-sm text-slate-700 font-medium bg-white transition-all focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 appearance-none">
                            <option value="">Sélectionner une source...</option>
                            <option value="LinkedIn" {{ old('source', $isEdit ? $contact->source : '') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                            <option value="Site Web" {{ old('source', $isEdit ? $contact->source : '') == 'Site Web' ? 'selected' : '' }}>Site Web</option>
                            <option value="Recommandation" {{ old('source', $isEdit ? $contact->source : '') == 'Recommandation' ? 'selected' : '' }}>Recommandation</option>
                            <option value="Emailing" {{ old('source', $isEdit ? $contact->source : '') == 'Emailing' ? 'selected' : '' }}>Emailing</option>
                            <option value="Événement" {{ old('source', $isEdit ? $contact->source : '') == 'Événement' ? 'selected' : '' }}>Événement</option>
                            <option value="Autre" {{ old('source', $isEdit ? $contact->source : '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                <div class="space-y-2">
                    <label for="tags" class="block text-xs font-bold text-slate-700 ml-1">Mots-clés</label>
                    <input type="text" name="tags_input" id="tags" value="{{ old('tags_input', ($isEdit && $contact->tags) ? implode(', ', $contact->tags) : '') }}" 
                        class="block w-full h-12 border-slate-200 rounded-xl text-sm text-slate-700 font-medium placeholder-slate-300 transition-all focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500"
                        placeholder="Ex: VIP, Urgent, Tech">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter ml-1">Séparés par des virgules</p>
                </div>
            </div>
        </div>

        <!-- Sticky Interaction Note -->
        <div class="bg-indigo-900 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden group">
            <div class="relative z-10">
                <h3 class="text-sm font-black uppercase tracking-widest mb-4 opacity-70">Note Interne</h3>
                <textarea name="notes_internes" id="notes_internes" rows="5" 
                    class="block w-full bg-indigo-800/50 border-indigo-700/50 rounded-2xl text-sm text-indigo-50 placeholder-indigo-300/50 focus:ring-0 focus:border-indigo-400/50 transition-all ring-inset ring-1 ring-indigo-700/30"
                    placeholder="Détails confidentiels ou contexte spécifique au contact...">{{ old('notes_internes', $isEdit ? $contact->notes_internes : '') }}</textarea>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl group-hover:bg-indigo-400/30 transition-all duration-700"></div>
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
    /* Premium Hover Effects */
    .animate-fade-in { animation: fadeIn 0.4s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    [x-cloak] { display: none !important; }

    /* Custom Phone Input Styling */
    .iti { width: 100%; }
    .iti__selected-dial-code { font-weight: 700; color: #1e293b; font-size: 0.875rem; }
    .iti__country-list { border-radius: 1rem; border: none; shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
</style>
